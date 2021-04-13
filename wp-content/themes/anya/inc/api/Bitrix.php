<?php

class Bitrix
{
    protected $apiBitrixUrl;
    public function __construct()
    {
        $this->apiBitrixUrl  = get_option('true_options')['bitrix_url'];
    }

    public function createLeadBitrix ($title = 'onlineitea.com', $data) {

        $comments ="Название: ".$data['post_name'];
        $comments.= " Валюта: ".$data['currency'];
        if ($data['promo']) {
            $comments.=" Promocode: ".$data['promo'];
            $comments.=" Скидка: ".$data['discount'];
        }
        $currency = "UAH";
        if (!empty($data['currency'])) {
            $currency = $data['currency'];
        }

//Сум - UZS
//Бел. рубль - BYN
//Евро - EUR
//Укр - UAH
//Казах - KZT
//Доллар - USD
//Руб - RUB

        $dataPostArr = [];
        $source_id = 15;//15 Сайт ITEA, 11 Звонок, 191 Tilda
        switch($title) {
            case 'Tilda':
            case 'tilda':
                $source_id = 191;
                $title = $_POST['host'];
            $currency = "USD";
                break;
            case 'itea.ua Callback':
                $source_id = 27;
                $title = $_POST['host'];
                break;
            case 'getcourse':
                break;
        };
        $dataArr = array(
            'TITLE' => 'Заявка с ' .  $title,
            'STATUS_ID' => 'NEW',
            'SOURCE_ID' => $source_id,
            'NAME' => $data['name'],
            'PHONE' => array(['VALUE' => $data['phone'], 'VALUE_TYPE' => 'WORK']),
            'EMAIL' => array(['VALUE' => $data['email'], 'VALUE_TYPE' => 'WORK']),
            'UTM_SOURCE' => !empty($data['sourceUuid']) ? $data['sourceUuid'] : "",
            'CURRENCY_ID' => $currency,
            'OPPORTUNITY' => $data['price'],
            'UF_CRM_1598864673' => !empty($data['host']) ? $data['host'] : '',//site url
            'COMMENTS' => $comments,
            'UF_CRM_1597823198' => "",//location_city
            'UF_CRM_1597823213' => "",//location_courses
            'UF_CRM_1597823228' => "",//roadmap_uuid
            'UF_CRM_1597823436' => get_option('true_options')['erp_format'],//format
            'UF_CRM_1597823284' => "",//coursesUuid
            'UF_CRM_1597823271' => "",//сегмент
        );
        $data = array_merge($dataArr, $dataPostArr);
        $queryData = http_build_query(array(
            'fields' => $data,
            'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->apiBitrixUrl.'crm.lead.add.json',
            CURLOPT_POSTFIELDS => $queryData,
        ));

        $result = curl_exec($curl);
        curl_close($curl);


        return $result = json_decode($result, 1);
    }
}
