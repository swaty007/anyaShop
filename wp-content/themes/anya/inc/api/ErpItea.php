<?php

class ErpItea {
    protected $apiType;
    protected $urlToken;
    protected $urlOrder;
    protected $urlCallbackOrder;
    protected $urlForResume;

    protected $login;
    protected $password;
    protected $client_id;
    protected $client_secret;
    protected $department_uuid;
    protected $filiation_uuid;
    protected $accessToken;
    protected $refreshToken;
    protected $accessLifetime;


    public function __construct()
    {
        $this->apiType = 'crm_symfony';
        $this->apiUrl = get_option('true_options')['erp_url'];
        $this->urlToken = $this->apiUrl.'oauth/v2/token';
        $this->urlOrder = $this->apiUrl.'api/v1/proposal-pull/';
        $this->urlCallbackOrder = $this->apiUrl.'api/v1/call-back/';
        $this->urlForResume = $this->apiUrl.'api/v1/contact/putItea/';
        $this->urlCheckPromo = $this->apiUrl.'api/v1/check-promo-code/';

        $this->login = get_option('true_options')['erp_login']; //itea.site
        $this->password = get_option('true_options')['erp_password']; //HeWwh7qMp@naxrdb
        $this->client_id = get_option('true_options')['client_id']; //1_2y2i4fpadfi844gggogsg8coo00408c80kwos0gck40cc8kc84
        $this->client_secret = get_option('true_options')['client_secret']; //51c915aa0n8k8cg0sscgw8cskksk4skc88k84oscksgccckock
        $this->department_uuid = get_option('true_options')['department_uuid']; //70d95c1d-143b-4d66-a078-821be4df20c0
        $this->filiation_uuid = get_option('true_options')['filiation_uuid']; //e7f33e0e-9605-4f0b-8ed3-7de8cde053b7
        $this->format = get_option('true_options')['erp_format'];

        $this->accessToken = get_option('erp_itea')['access_token'];
        $this->refreshToken = get_option('erp_itea')['refresh_token'];
        $this->accessLifetime = get_option('erp_itea')['access_lifetime'];
    }

    protected function checkAccesses()
    {
        $connectionStatus = true;

        if (empty($this->accessToken) || $this->accessLifetime < time() + 5) {
            $connectionStatus = $this->getAccesses();
        }

        return $connectionStatus;
    }

protected function requestAccesses($params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlToken);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE); // CURLINFO_HTTP_CODE or CURLINFO_RESPONSE_CODE

        curl_close($ch);
        return [
            'status' => $status,
            'data' => $data
        ];
    }

    protected function getAccesses()
    {
        $status = 0;


        if (!empty($this->refreshToken)) {
            $result = self::requestAccesses([
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->refreshToken,
            ]);
            $status = $result['status'];
            if ($status == 200) {
                self::updateOAuth(json_decode($result['data']));
            }
        }

        if (empty($this->refreshToken) || $status != 200) {
           $result = self::requestAccesses([
               'client_id' => $this->client_id,
               'client_secret' => $this->client_secret,
               'grant_type' => 'password',
               'username' => $this->login,
               'password' => $this->password,
           ]);
            $status = $result['status'];
            if ($status == 200) {
                self::updateOAuth(json_decode($result['data']));
            }
        }
        return $status == 200;
    }

    protected function updateOAuth($result) {
        $this->accessToken = $result->access_token;
        $this->refreshToken = $result->refresh_token;
        $this->accessLifetime = time() + $result->expires_in;

        update_option('erp_itea', [
            'access_token' => $this->accessToken,
            'refresh_token' => $this->refreshToken,
            'access_lifetime' => $this->accessLifetime,
        ]);
    }

    final public function sendOrder($data)
    {
        try {
            $result = '';
            $responseCode = 0;

            $this->checkAccesses();

            $comments ="Название: ".$data['post_name'];
            $comments.= " Валюта: ".$data['currency'];
            if ($data['promo']) {
                $comments.=" Promocode: ".$data['promo'];
                $comments.=" Скидка: ".$data['discount'];
            }

            $params = [
                'coursesUuid' => $data['courses_uuid'],
                'roadmapUuid' => $data['roadmap_uuid'],
                'sum' => $data['price'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'format' => $this->format ? $this->format : "OFFLINE",
                'discountFromSite' => $data['discount'],
                'filiation' => $this->filiation_uuid,
                'promocode' => $data['promocode'],
                'comment' => $comments,
                'cityUuid' => $this->department_uuid,
                'courseType' => 'INNER_EVENING',
                'sourceUuid' => '',
            ];

            for ($shot = 0; $shot < 2; $shot++) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->urlOrder);
                // curl_setopt($ch, CURLINFO_HEADER_OUT, true); //enable headers
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    [
                        "Authorization: Bearer {$this->accessToken}",
                        "X-DEPARTMENT: $this->department_uuid",
                    ]
                );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // CURLINFO_HTTP_CODE or CURLINFO_RESPONSE_CODE

                curl_close($ch);

                if ($responseCode == 401) {
                    $this->getAccesses();
                } else {
                    break;
                }
            }

            return [
                'code' => $responseCode,
                'message' => $result,
                'success' => $responseCode >= 200 && $responseCode <= 299,
            ];
        } catch (Exception $e) {
            error_log($e->getMessage().' ('.$e->getCode().'); ', 0);
        }
    }

    final public function sendCallbackOrder($data)
    {
        $result = '';
        $responseCode = 0;

        $this->checkAccesses();

        $params = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
//                'utm_source' => $_POST['data']['utm_source'],
            'cityUuid' => $this->department_uuid,
        ];

        for ($shot = 0; $shot < 2; $shot++) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->urlCallbackOrder);
            // curl_setopt($ch, CURLINFO_HEADER_OUT, true); //enable headers
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                [
                    "Authorization: Bearer {$this->accessToken}",
                    "X-DEPARTMENT: $this->department_uuid",
                ]
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // CURLINFO_HTTP_CODE or CURLINFO_RESPONSE_CODE

            curl_close($ch);

            if ($responseCode == 401) {
                $this->getAccesses();
            } else {
                break;
            }
        }

        return [
            'code' => $responseCode,
            'message' => $result,
            'success' => $responseCode >= 200 && $responseCode <= 299,
        ];
    }
    final public function checkPromoCode ($promo) {
        $result = '';
        $responseCode = 0;

        $this->checkAccesses();

        for ($shot = 0; $shot < 2; $shot++) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->urlCheckPromo.$promo);
            // curl_setopt($ch, CURLINFO_HEADER_OUT, true); //enable headers
//            curl_setopt($ch, CURLOPT_POST, 1);
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                [
                    "Authorization: Bearer {$this->accessToken}",
                    "X-DEPARTMENT: $this->department_uuid",
                ]
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // CURLINFO_HTTP_CODE or CURLINFO_RESPONSE_CODE

            curl_close($ch);

            if ($responseCode == 401) {
                $this->getAccesses();
            } else {
                break;
            }
        }

        return [
            'code' => $responseCode,
            'message' => $result,
            'success' => $responseCode >= 200 && $responseCode <= 299,
        ];
    }
}
