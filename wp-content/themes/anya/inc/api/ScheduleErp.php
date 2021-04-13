<?php

class ScheduleErp
{
    public function __construct()
    {

    }
}

add_action('rest_api_init', function () {
    register_rest_route('erp/v1', 'schedule', array(
        'methods' => [
//            WP_REST_Server::READABLE,   // GET
            WP_REST_Server::CREATABLE,   // POST
            'PATCH',
//            WP_REST_Server::EDITABLE,    // POST, PUT, PATCH
            WP_REST_Server::DELETABLE,   // DELETE
//            WP_REST_Server::ALLMETHODS,  // GET, POST, PUT, PATCH, DELETE
        ],
        'callback' => 'scheduleErp'
    ));

    register_rest_route('erp/v1', 'schedule/mass', array(
        'methods' => [
//            WP_REST_Server::READABLE,   // GET
            WP_REST_Server::CREATABLE,   // POST
            'PATCH',
//            WP_REST_Server::EDITABLE,    // POST, PUT, PATCH
            WP_REST_Server::DELETABLE,   // DELETE
//            WP_REST_Server::ALLMETHODS,  // GET, POST, PUT, PATCH, DELETE
        ],
        'callback' => 'scheduleErpMass'
    ));
});


function scheduleErpCreateDates($courseUuid, $dateRequest, $dateStatus, $dateUuid)
{
    $courses = get_posts([
        'post_type' => 'courses',
        'posts_per_page' => -1,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'uuid_for_itea_crm',
                'value' => $courseUuid,
                'compare' => '=',
            ],
        ],
    ]);

    foreach ($courses as $course) {
        $dates = [];
        $rowsNum = get_post_meta($course->ID, 'date', true);

        //Добавим даты из запроса
        $dates[] = [
            'date' => $dateRequest,
            'color' => $dateStatus,
            'date_uuid' => $dateUuid,
        ];

        //Соберем имеющиеся даты
        while (have_rows('date', $course->ID)): the_row();
            $dates[] = [
                'date' => get_sub_field('date', false),
                'color' => get_sub_field('color', false),
                'date_uuid' => get_sub_field('date_uuid', false),
            ];
        endwhile;

        //Отфильтруем дубли по дате и uuid дат
        $datesFinish = $keyDate = $keyUuid = [];
        foreach ($dates as $date) {
            if (!in_array($date['date_uuid'], $keyUuid)) { //!in_array($date['date'], $keyDate) &&
                $keyDate[] = $date['date'];
                $keyUuid[] = $date['date_uuid'];
                $datesFinish[] = $date;
            }
        }

        //Отсортируем по возрастанию
        usort($datesFinish, function ($a, $b) {
            return $a['date'] < $b['date'] ? -1 : 1;
        });

        // Удалим старые поля
        for ($rowsNum; $rowsNum > 0; $rowsNum--) {
            delete_row('date', $rowsNum, $course->ID);
        }

        //Добавил новые
        foreach ($datesFinish as $newDates) {
            add_row('date', [
                'date' => $newDates['date'],
                'color' => $newDates['color'],
                'date_uuid' => $newDates['date_uuid'],
            ], $course->ID);
        }

    }
}

function scheduleErpMass(WP_REST_Request $request)
{
    $data = $request['data'];
    if (empty($data)) {
        return new WP_REST_Response($request, 400 );
    }

    foreach ($data as $item)
    {
        $courseUuid = $item['courseUuid']; //Курс UUID
        $dateUuid = $item['dateUuid']; //Календарь курс UUID
        $dateRequest = date('Ymd', strtotime($item['date']));
        $dateStatus = $item['dateStatus'];
        $filiationUuid = $item['filiationUuid'];
        scheduleErpCreateDates($courseUuid, $dateRequest, $dateStatus, $dateUuid);
    }

    return new WP_REST_Response( [
        'data' => $data,
    ], 200 );
}
function scheduleErp(WP_REST_Request $request)
{
    switch ($request->get_method()) {
        case WP_REST_Server::CREATABLE:
        case 'PATCH':
            $courseUuid = $request['courseUuid']; //Курс UUID
            $dateUuid = $request['dateUuid']; //Календарь курс UUID
            $dateRequest = date('Ymd', strtotime($request['date']));
            $dateStatus = $request['dateStatus'];
            $filiationUuid = $request['filiationUuid'];
            if (empty($dateUuid) || empty($courseUuid) || empty($request['date'])) {
//                wp_send_json(false, 400);
                return new WP_REST_Response( false, 400 );
            }

            scheduleErpCreateDates($courseUuid, $dateRequest, $dateStatus, $dateUuid);

        return new WP_REST_Response( [
            'courseUuid' => $courseUuid,
            'date' => $request['date'],
            'dateStatus' => $dateStatus,
            'dateUuid' => $dateUuid,
        ], 200 );
//            wp_send_json([
//                'courseUuid' => $courseUuid,
//                'date' => $request['date'],
//                'dateStatus' => $dateStatus,
//                'dateUuid' => $dateUuid,
//            ]);
            break;
        case WP_REST_Server::DELETABLE:
            $dateUuid = $request['dateUuid'];
            $filiationUuid = $request['filiationUuid'];
            if (empty($dateUuid)) {
                return new WP_REST_Response( false, 400 );
//                wp_send_json(false, 400);
            }

            global $wpdb;
            $result = $wpdb->get_results("SELECT * FROM wp_postmeta WHERE meta_value='$dateUuid'");

            $keyPostsId = [];
            foreach ($result as $course) {
                if (!in_array($course->post_id, $keyPostsId)) {
                    $keyPostsId[] = $course->post_id;
                    $course->post_id;
                }
                while (have_rows('date', $course->post_id)): the_row();
                if (get_sub_field('date_uuid', false) == $dateUuid) {
                    delete_row('date', get_row_index(), $course->post_id);
                }
                endwhile;
            }
            return new WP_REST_Response( [
                'dateUuid' => $dateUuid,
            ], 200 );
//            wp_send_json(true);
//            wp_send_json([
//                'dateUuid' => $dateUuid,
//            ]);
            break;
    }
}


add_action('clear_meta_dates', 'clear_postmeta_dates');
function clear_postmeta_dates()
{

//    global $wpdb;
    $today = date('d.m.Y');
//    $result = $wpdb->get_results("SELECT * FROM wp_postmeta WHERE meta_key='date1' OR meta_key='date2' OR meta_key='date3' OR meta_key='date4' OR meta_key='date5' OR meta_key='date6'");
//    foreach ($result as $item) {
//        if (preg_match("/^([0-9]{2}).([0-9]{2}).([0-9]{4})$/", $item->meta_value)) { // regEx for nn.nn.nnnn
//            if (strtotime($item->meta_value) < strtotime($today)) {
//                $num = substr($item->meta_key, -1);
//                $res = $wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '' WHERE (meta_key='date" . $num . "' OR meta_key='date" . $num . "-bg-color' OR meta_key='date" . $num . "-uuid') AND post_id=" . $item->post_id . " AND meta_filiation='" . $item->meta_filiation . "'");
//            }
//        }
//    }


    $courses = get_posts([
        'post_type' => 'courses',
        'posts_per_page' => -1,
//        'meta_query' => [
//            'relation' => 'AND',
//            [
//                'key' => 'uuid_for_itea_crm',
//                'compare' => 'EXISTS',
//            ],
//        ],
    ]);

    $keyPostsId  = [];
    foreach ($courses as $course) {
        if (!in_array($course->ID, $keyPostsId)) {
            $keyPostsId[] = $course->ID;
            $course->ID;
        }

        while (have_rows('date', $course->ID)): the_row();
            if (strtotime(get_sub_field('date', false)) < strtotime($today)) {
                delete_row('date', get_row_index(), $course->ID);
            }
        endwhile;
    }

}

if (!wp_next_scheduled('clear_meta_dates')) {
    wp_schedule_event( time(), 'daily', 'clear_meta_dates' );
}
