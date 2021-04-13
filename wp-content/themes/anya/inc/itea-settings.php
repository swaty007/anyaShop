<?php
//settings start
//get_option('true_options');
$true_page = 'iteasettings'; // это часть URL страницы, рекомендую использовать строковое значение, т.к. в данном случае не будет зависимости от того, в какой файл вы всё это вставите

/*
 * Функция, добавляющая страницу в пункт меню Настройки
 */
function true_options() {
    global $true_page;
    add_options_page( 'Параметры ITEA', 'Параметры ITEA', 'manage_options', $true_page, 'true_option_page');
}
add_action('admin_menu', 'true_options');

/**
 * Возвратная функция (Callback)
 */
function true_option_page(){
    global $true_page;
    ?><div class="wrap">
    <h2>Дополнительные параметры сайта</h2>
    <form method="post" enctype="multipart/form-data" action="options.php">
        <?php
        settings_fields('true_options'); // меняем под себя только здесь (название настроек)
        do_settings_sections($true_page);
        ?>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
    <br>
    <br>
    <button id="delete_all_dates" class="button button-link-delete" >Удалить все даты</button>
    <style>
        input.regular-text {
            width: 100%;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
          let block = false
          jQuery('#delete_all_dates').on('click', function (e) {
            if (block) return
            block = true
            let nonce = "<?=wp_create_nonce('protection');?>",
              ajaxurl = "<?=admin_url('admin-ajax.php');?>"
              console.log(nonce)
              console.log(ajaxurl)
            jQuery.ajax({
              url: ajaxurl,
              data: {
                security: nonce,
                action: 'delete_all_dates',
              },
              type: 'POST',
              success: (data) => {
                if (data) {
                  jQuery(this).attr('disabled', true)
                  block = false
                }
              }
            })
          })
        })
    </script>
    </div><?php
}

/*
 * Регистрируем настройки
 * Мои настройки будут храниться в базе под названием true_options (это также видно в предыдущей функции)
 */
function true_option_settings() {
    global $true_page;
    // Присваиваем функцию валидации ( true_validate_settings() ). Вы найдете её ниже
    register_setting( 'true_options', 'true_options', 'true_validate_settings' ); // true_options

    // Добавляем секцию
    add_settings_section( 'true_section_1', 'Текстовые поля ввода', '', $true_page );

    if(function_exists('pll_languages_list')) {
        // Создадим текстовое поле в первой секции
        foreach(pll_languages_list() as $lang) {
            $true_field_params = array(
                'type'      => 'text', // тип
                'id'        => "phone_number_$lang",
                'desc'      => 'отображается в хедере', // описание
                'label_for' => "phone_number" // позволяет сделать название настройки лейблом (если не понимаете, что это, можете не использовать), по идее должно быть одинаковым с параметром id
            );
            add_settings_field( "phone_number_$lang", "Номер телефона $lang", 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );

        }
    }


    $true_field_params = array(
        'type'      => 'textarea', // тип
        'id'        => 'emails_to',
        'desc'      => 'Емейлы кому отправлять заявки, записанные с новой строки', // описание
        'label_for' => 'emails_to'
    );
    add_settings_field( 'emails_to', 'Emails', 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );

    // Создадим textarea в первой секции
    $true_field_params = array(
        'type'      => 'textarea',
        'id'        => 'my_textarea',
        'desc'      => 'Пример большого текстового поля.'
    );

    $true_field_params = array(
        'type'      => 'text', // тип
        'id'        => 'bitrix_url',
        'desc'      => '', // описание
        'label_for' => 'bitrix_url'
    );
    add_settings_field( 'bitrix_url', 'Bitrix API URL', 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );

//    add_settings_field( 'my_textarea_field', 'Большое текстовое поле', 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );

    // Добавляем вторую секцию настроек

    add_settings_section( 'true_section_2', 'ERP ITEA', '', $true_page );

    $true_field_params = array(
        'type'      => 'text', // тип
        'id'        => 'erp_url',
        'desc'      => 'https://api.onlineitea.com/ с "/" в конце', // описание
        'label_for' => 'erp_url'
    );
    add_settings_field( 'erp_url', 'ERP URL', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );

    $true_field_params = array(
        'type'      => 'text', // тип
        'id'        => 'erp_login',
        'desc'      => '', // описание
        'label_for' => 'erp_login'
    );
    add_settings_field( 'erp_login', 'ERP ITEA Login', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );

    $true_field_params = array(
        'type'      => 'text', // тип
        'id'        => 'erp_password',
        'desc'      => '', // описание
        'label_for' => 'erp_password'
    );
    add_settings_field( 'erp_password', 'ERP ITEA Password', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );

    $true_field_params = array(
        'type'      => 'text', // тип
        'id'        => 'client_id',
        'desc'      => '', // описание
        'label_for' => 'client_id'
    );
    add_settings_field( 'client_id', 'ERP ITEA Cliend ID', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );

    $true_field_params = array(
        'type'      => 'text', // тип
        'id'        => 'client_secret',
        'desc'      => '', // описание
        'label_for' => 'client_secret'
    );
    add_settings_field( 'client_secret', 'ERP ITEA Cliend Secret', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );

    $true_field_params = array(
        'type'      => 'text', // тип
        'id'        => 'department_uuid',
        'desc'      => '', // описание
        'label_for' => 'department_uuid'
    );
    add_settings_field( 'department_uuid', 'ERP ITEA Department uuid', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );

    $true_field_params = array(
        'type'      => 'text', // тип
        'id'        => 'filiation_uuid',
        'desc'      => '', // описание
        'label_for' => 'filiation_uuid'
    );
    add_settings_field( 'filiation_uuid', 'ERP ITEA Filiation uuid', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );

    // Создадим радио-кнопку
    $true_field_params = array(
        'type'      => 'radio',
        'id'      => 'erp_format',
        'vals'		=> array( 'ONLINE' => 'Онлайн', 'OFFLINE' => 'Офлайн')
    );
    add_settings_field( 'erp_format', 'Формат обучения', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );


    // Создадим чекбокс
    $true_field_params = array(
        'type'      => 'checkbox',
        'id'        => 'my_checkbox',
        'desc'      => 'Пример чекбокса.'
    );
//    add_settings_field( 'my_checkbox_field', 'Чекбокс', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );

    // Создадим выпадающий список
    $true_field_params = array(
        'type'      => 'select',
        'id'        => 'my_select',
        'desc'      => 'Пример выпадающего списка.',
        'vals'		=> array( 'val1' => 'Значение 1', 'val2' => 'Значение 2', 'val3' => 'Значение 3')
    );
//    add_settings_field( 'my_select_field', 'Выпадающий список', 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );


}
add_action( 'admin_init', 'true_option_settings' );

/*
 * Функция отображения полей ввода
 * Здесь задаётся HTML и PHP, выводящий поля
 */
function true_option_display_settings($args) {
    extract( $args );

    $option_name = 'true_options';

    $o = get_option( $option_name );

    if (empty($o[$id])) $o[$id] = "";
    switch ( $type ) {
        case 'text':
            $o[$id] = esc_attr( stripslashes($o[$id]) );
            echo "<input class='regular-text' type='text' id='$id' name='" . $option_name . "[$id]' value='$o[$id]' />";
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
            break;
        case 'textarea':
            $o[$id] = esc_attr( stripslashes($o[$id]) );
            echo "<textarea class='code large-text' cols='50' rows='10' type='text' id='$id' name='" . $option_name . "[$id]'>$o[$id]</textarea>";
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
            break;
        case 'checkbox':
            $checked = ($o[$id] == 'on') ? " checked='checked'" :  '';
            echo "<label><input type='checkbox' id='$id' name='" . $option_name . "[$id]' $checked /> ";
            echo ($desc != '') ? $desc : "";
            echo "</label>";
            break;
        case 'select':
            echo "<select id='$id' name='" . $option_name . "[$id]'>";
            foreach($vals as $v=>$l){
                $selected = ($o[$id] == $v) ? "selected='selected'" : '';
                echo "<option value='$v' $selected>$l</option>";
            }
            echo ($desc != '') ? $desc : "";
            echo "</select>";
            break;
        case 'radio':
            echo "<fieldset>";
            foreach($vals as $v=>$l){
                $checked = ($o[$id] == $v) ? "checked='checked'" : '';
                echo "<label><input type='radio' name='" . $option_name . "[$id]' value='$v' $checked />$l</label><br />";
            }
            echo "</fieldset>";
            break;
    }
}

/*
 * Функция проверки правильности вводимых полей
 */
function true_validate_settings($input) {
    foreach($input as $k => $v) {
        $valid_input[$k] = trim($v);

        /* Вы можете включить в эту функцию различные проверки значений, например
        if(! задаем условие ) { // если не выполняется
            $valid_input[$k] = ''; // тогда присваиваем значению пустую строку
        }
        */
    }
    return $valid_input;
}
//settings end
