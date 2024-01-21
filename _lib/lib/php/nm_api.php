<?php

function nm_get_api_gateways($api = '') {
    $arr_all = nm_get_api_gateways_deep($api);
    $flatten = [];
    foreach($arr_all as $scope => $scope_data) {
        if (!isset($flatten[$scope])) {
            $flatten[$scope] = [];
        }
        foreach ($scope_data as $field => $field_data) {
            $k_f =  strval($field);
            if (!isset($flatten[$scope][$k_f])) {
                $flatten[$scope][$k_f] = [];
            }
            $field_flat = [];
            foreach ($field_data as $cols) {
                foreach ($cols as $key => $val) {
                    $field_flat[$key] = $val;
                }
            }
            $flatten[$scope][$k_f] = $field_flat;
        }
    }
    return $flatten;
}
function nm_get_api_gateways_deep($api = '')
{
    $arr_apis = ['email' => [], 'sms' => [], 'payment' => []];

    $aws_region = [
        'us-east-1' => 'Leste dos EUA (Norte da Virgínia)',
        'us-east-2' => 'Leste dos EUA (Ohio)',
        'us-west-1' => 'Oeste dos EUA (Norte da Califórnia)',
        'us-west-2' => 'Oeste dos EUA (Oregon)',
        'af-south-1' => 'África (Cidade do Cabo)',
        'ap-east-1' => 'Ásia-Pacífico (Hong Kong)',
        'ap-south-1' => 'Ásia-Pacífico (Mumbai)',
        'ap-northeast-2' => 'Ásia-Pacífico (Seul)',
        'ap-southeast-1' => 'Ásia-Pacífico (Cingapura)',
        'ap-southeast-2' => 'Ásia-Pacífico (Sydney)',
        'ap-northeast-1' => 'Ásia-Pacífico (Tóquio)',
        'ca-central-1' => 'Canadá (Central)',
        'eu-central-1' => 'Europa (Frankfurt)',
        'eu-west-1' => 'Europa (Irlanda)',
        'eu-west-2' => 'Europa (Londres)',
        'eu-south-1' => 'Europa (Milão)',
        'eu-west-3' => 'Europa (Paris)',
        'eu-north-1' => 'Europa (Estocolmo)',
        'me-south-1' => 'Oriente Médio (Bahrein)',
        'sa-east-1' => 'América do Sul (São Paulo)',
    ];
    $arr_apis['email']['smtp'] = [
        [
            'smtp_server' => ['placeholder' => 'smtp.example.com'],
            'smtp_port' => ['placeholder' => '465', 'type' => 'number'],
            'smtp_protocol' => ['options' => ['', 'SSL', 'TLS'], 'type' => 'select']
        ],
        [
            'smtp_user' => ['placeholder' => 'default@example.com'],
            'smtp_password' => ['placeholder' => '********', 'type' => 'password']
        ],
        [
            'from_email' => ['placeholder' => 'default@example.com'],
            'from_name' => ['placeholder' => 'default']
        ],
    ];


    $arr_apis['email']['mandrill'] = [
        [
            'from_email' => ['placeholder' => 'default@example.com'],
            'from_name' => ['placeholder' => 'default'],
        ],
        [
            'api_key' => ['placeholder' => 'Your API']
        ]
    ];


    $arr_apis['email']['SES'] = [
        [
            'api_key' => ['placeholder' => 'Your Key API'],
            'api_secret' => ['placeholder' => 'Your Secret API'],
        ],
        [
            'from_email' => ['placeholder' => 'default@example.com'],
            'from_name' => ['placeholder' => 'default'],
        ],
        [
            'region' => ['type' => 'select', 'options' => $aws_region, 'use_key' => true, 'use_lang' => true],
        ]
    ];


    $arr_apis['sms']['twilio'] = [
        [
            'auth_id' => ['placeholder' => 'Your Auth ID'],
            'auth_token' => ['placeholder' => 'Your Auth Token'],
        ],
        [
            'from' => ['placeholder' => 'Default number to send SMS'],
        ]
    ];

    $arr_apis['sms']['plivo'] = [
        [
            'auth_id' => ['placeholder' => 'Your Auth ID'],
            'auth_token' => ['placeholder' => 'Your Auth Token'],
        ],
        [
            'from' => ['placeholder' => 'Default number to send SMS'],
        ]
    ];

    $arr_apis['sms']['clickatell'] = [
        [
            'auth_token' => ['placeholder' => 'Your Auth Token'],
        ]
    ];

    $arr_apis['payment']['pagseguro'] = [
        [
            'environment' => ['placeholder' => 'Sandbox or Production'],
            'charset' => ['options' => ['UTF-8', 'ISO-8859-1'], 'type' => 'select'],
        ],
        [
            'auth_email' => ['placeholder' => 'Email to auth in API'],
            'auth_token' => ['placeholder' => 'Your Auth token'],
        ],
        [
            'auth_appId' => ['placeholder' => 'AppID to connect in pagseguro by app'],
            'auth_appKey' => ['placeholder' => 'AppKey to connect in pagseguro by app'],
        ]
    ];

    $arr_apis['payment']['paypal_express'] = [
        [
            'username' => ['placeholder' => 'Username'],
            'password' => ['placeholder' => 'Password'],
        ],
        [
            'signature' => ['placeholder' => 'Signature'],
            'testMode' => ['options' => ['FALSE', 'TRUE'], 'type' => 'select'],
        ]
    ];

    $arr_apis['payment']['paypal_express_incontext'] = [
        [
            'username' => ['placeholder' => 'Username'],
            'password' => ['placeholder' => 'Password'],
        ],
        [
            'signature' => ['placeholder' => 'Signature'],
            'testMode' => ['options' => ['FALSE', 'TRUE'], 'type' => 'select'],
        ]
    ];

    $arr_apis['payment']['paypal_pro'] = [
        [
            'username' => ['placeholder' => 'Username'],
            'password' => ['placeholder' => 'Password'],
        ],
        [
            'signature' => ['placeholder' => 'Signature'],
            'testMode' => ['options' => ['FALSE', 'TRUE'], 'type' => 'select'],
        ]
    ];

    $arr_apis['payment']['paypal_rest'] = [
        [
            'clientId' => ['placeholder' => 'Your Auth ClientId'],
            'secret' => ['placeholder' => 'Your Auth Secret'],
        ],
        [
            'token' => ['placeholder' => 'Your Auth token'],
            'testMode' => ['options' => ['FALSE', 'TRUE'], 'type' => 'select'],
        ]
    ];
    if(PHP_MAJOR_VERSION >7 || (PHP_MAJOR_VERSION ==7 && PHP_MINOR_VERSION >= 3) ) {
        $arr_apis['payment']['braintree'] = [
            [
                'privateKey' => ['placeholder' => 'Your privateKey'],
                'publicKey' => ['placeholder' => 'Your publicKey'],
            ],
            [
                'merchantId' => ['placeholder' => 'Your merchantId'],
                'testMode' => ['options' => ['FALSE', 'TRUE'], 'type' => 'select'],
            ]
        ];


        $arr_apis['payment']['mercadopago'] = [
            [
                'token' => ['placeholder' => 'Your Auth token'],
            ]
        ];
    }
    $arr_apis['payment']['stripe'] = [
        [
            'apiKey' => ['placeholder' => 'Your apiKey'],
        ]
    ];
    /*
            $arr_apis['whatsapp']['waboxapp'] = [
                'token' => ['placeholder' => 'Your token'],
                'uid' => ['placeholder' => 'Your UID'],
                'testMode' => ['options' => ['FALSE','TRUE'], 'type' => 'select'],
            ];*/
    /*
        $arr_apis['whatsapp']['chatapi'] = [
            'url' => ['placeholder' => 'Your Url'],
            'token' => ['placeholder' => 'Your token'],
        ];*/

    $arr_apis['storage']['S3'] = [
        [
            'api_key' => ['placeholder' => 'Your Key API'],
            'api_secret' => ['placeholder' => 'Your Secret API'],
        ],
        [
            'region' => ['type' => 'select', 'options' => $aws_region, 'use_key' => true, 'use_lang' => true],
            'bucket' => ['placeholder' => 'Your Bucket'],
        ]
    ];
    $arr_apis['storage']['dropbox'] = [
        [
            "api_key" => ['placeholder' => 'Your App Key'],
            "api_secret" => ['placeholder' => 'Your App Secret'],
            "access_token" => ['placeholder' => 'Your Access Token'],
        ]
    ];
    $arr_apis['storage']['google_drive'] = [
        [
            "app_name" => ['placeholder' => 'Your App Name'],
            "auth_code" => ['placeholder' => 'Click in button and insert Auth Code generated', 'type' => 'gd_auth_code'],
        ],
        [
            "json_oauth" => ['placeholder' => 'Your Json Oauth', 'type' => 'textarea'],
        ]
    ];
    /*
    $arr_apis['storage']['onedrive'] = [
        'api_key' => ['placeholder' => 'Your App Key'],
        'api_secret' => ['placeholder' => 'Your App Secret'],
        "auth_code" => ['placeholder' => 'Click in button and insert Auth Code generated', 'type' => 'od_auth_code'],
    ];*/
    $arr_apis['auth']['google_authenticator'] = [
        [
            // 'salt' => ['placeholder' => 'Salt'],
            'domain' => ['placeholder' => 'Domain'],
        ]
    ];

    $arr_apis['reporting']['google_sheets'] = [
        [
            "app_name" => ['placeholder' => 'Your App Name'],
            "auth_code" => ['placeholder' => 'Click in button and insert Auth Code generated', 'type' => 'gd_auth_code'],
        ],
        [
            "json_oauth" => ['placeholder' => 'Your Json Oauth', 'type' => 'textarea'],
        ]
    ];

    if (!empty($api))
        return $arr_apis[$api];

    return $arr_apis;
}


function nm_load_profile($profile)
{
    $file = __DIR__ . "/../../profile_api.conf.php";
    if (!file_exists($file)) {
        $file = nm_get_prod_path() . "../conf/profile_api.conf.php";
    }

    if (!file_exists($file)) {
        return false;
    }

    $str_content = strtr(file_get_contents($file), array("<?php" => '', "?>" => ''));
    $arr_content = unserialize(trim($str_content));
    if (isset($arr_content[$profile])) {
        return $arr_content[$profile];
    } else {
        $ret = explode("__NM__", $profile);
        $profile = isset($ret[1]) ? $ret[1] : $ret[0];
        if (isset($arr_content[$profile])) {
            return $arr_content[$profile];
        } else {
            foreach (['sys', 'grp', 'usr'] as $mod) {
                if (isset($arr_content[$mod . '__NM__' . $profile])) {
                    return $arr_content[$mod . '__NM__' . $profile];
                }
            }
        }
    }
    return (isset($arr_content[$profile]) ? $arr_content[$profile] : false);
}

use Aws\S3\S3Client;
use Aws\Ses\SesClient;
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Omnipay\Omnipay;
use Plivo\RestClient;
use Twilio\Rest\Client;
use Tsk\OneDrive\Services\OneDriveService;
use Tsk\OneDrive\Client as OndriveClient;
use Tsk\OneDrive\Http\MediaFileUpload;
use Google\Authenticator\GoogleAuthenticator;

function sc_call_api($profile, $arr_settings = [])
{
    if (!empty($profile)) {
        $arr_settings = nm_load_profile($profile);
        if ($arr_settings == false) {
            return false;
        }
    }
    if (!isset($arr_settings['settings']) && isset($arr_settings['gateway'])) {
        $arr_settings['settings'] = $arr_settings;
    }


    $prod_path = nm_get_prod_path();

    if (isset($arr_settings['gateway'])) {
        $arr_settings['settings']['gateway'] = $arr_settings['gateway'];
    }

    switch (strtolower($arr_settings['settings']['gateway'])) {
        case 'mandrill':
            include_once($prod_path . "/third/mandrill/src/Mandrill.php");
            return new Mandrill($arr_settings['settings']['api_key']);
            break;

        case 'ses':
            include_once($prod_path . "/third/aws.phar");

            return SesClient::factory(array(
                'version' => 'latest',
                'region' => $arr_settings['settings']['region'],
                'credentials' => array(
                    'key' => $arr_settings['settings']['api_key'],
                    'secret' => $arr_settings['settings']['api_secret'],
                )
            ));

            break;


        case 'smtp':
            include_once($prod_path . "/third/swift/swift_required.php");
            $transport = (new Swift_SmtpTransport($arr_settings['settings']['smtp_server'], $arr_settings['settings']['smtp_port']))
                ->setUsername($arr_settings['settings']['smtp_user'])
                ->setPassword($arr_settings['settings']['smtp_password']);
            $protocol = null;
            if (isset($arr_settings['settings']['smtp_protocol'])) {
                $protocol = $arr_settings['settings']['smtp_protocol'];
            } else {
                switch (strtolower($arr_settings['settings']['smtp_port'])) {
                    default:
                    case 25:
                        $protocol = null;
                        break;
                    case 465:
                        $protocol = 'ssl';
                        break;
                    case 587:
                        $protocol = 'tls';
                        break;
                }
            }
            $transport->setEncryption(strtolower($protocol));
            return new Swift_Mailer($transport);
            break;
        case 'plivo':
            include_once($prod_path . "/third/plivo/plivo.php");
            return new RestClient($arr_settings['settings']['auth_id'], $arr_settings['settings']['auth_token']);
            break;
        case 'twilio':
            include_once($prod_path . "/third/twilio/autoload.php");

            return new Client($arr_settings['settings']['auth_id'], $arr_settings['settings']['auth_token']);

            break;
        case 'clickatell':
            include_once($prod_path . "/third/clickatell/src/Rest.php");
            return new \Clickatell\Rest($arr_settings['settings']['auth_token']);
            break;

        case 'pagseguro':
            include_once($prod_path . "/third/pagseguro/autoload.php");
            \PagSeguro\Library::initialize();
            \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
            \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

            \PagSeguro\Configuration\Configure::setEnvironment($arr_settings['settings']['environment']);//production or sandbox
            if (!isset($arr_settings['settings']['auth_email']) && isset($arr_settings['settings']['auth_appId'])) {
                \PagSeguro\Configuration\Configure::setApplicationCredentials(
                    $arr_settings['settings']['auth_appId'],
                    $arr_settings['settings']['auth_appKey']
                );
            } else {
                \PagSeguro\Configuration\Configure::setAccountCredentials(
                    $arr_settings['settings']['auth_email'],
                    $arr_settings['settings']['auth_token']
                );
            }
            if (!isset($arr_settings['settings']['charset']) || empty($arr_settings['settings']['charset'])) {
                $arr_settings['settings']['charset'] = 'UTF-8';
            }
            \PagSeguro\Configuration\Configure::setCharset($arr_settings['settings']['charset']);// UTF-8 or ISO-8859-1

            break;
        case 'paypal_express':
        case 'paypal_express_incontext':
        case 'paypal_pro':


            switch (strtolower($arr_settings['settings']['gateway'])) {
                case 'paypal_express':
                    $gw = "PayPal_Express";
                    break;
                case 'paypal_express_incontext':
                    $gw = "PayPal_ExpressInContext";
                    break;
                case 'paypal_pro':
                    $gw = "PayPal_Pro";
                    break;
            }
            include_once($prod_path . "/third/omnipay/vendor/autoload.php");

            $gateway = Omnipay::create($gw);


            $instance = $gateway->initialize([
                'username' => $arr_settings['settings']['username'],
                'password' => $arr_settings['settings']['password'],
                'signature' => $arr_settings['settings']['signature'],
                'testMode' => isset($arr_settings['settings']['testMode']) ? $arr_settings['settings']['testMode'] : false,
            ]);

            return $instance;

            break;
        case 'paypal_rest':

            include_once($prod_path . "/third/omnipay/vendor/autoload.php");
            $gateway = Omnipay::create('PayPal_Rest');

            $instance = $gateway->initialize([
                'clientId' => $arr_settings['settings']['clientId'],
                'secret' => $arr_settings['settings']['secret'],
                'token' => $arr_settings['settings']['token'],
                'testMode' => isset($arr_settings['settings']['testMode']) ? $arr_settings['settings']['testMode'] : false,
            ]);

            return $instance;
            break;

        case 'braintree':

            include_once($prod_path . "/third/braintree/autoload.php");
            $instance = new Braintree\Gateway([
                'environment' => isset($arr_settings['settings']['testMode']) ? 'sandbox' : 'live',
                'merchantId' => $arr_settings['settings']['merchantId'],
                'publicKey' => $arr_settings['settings']['publicKey'],
                'privateKey' => $arr_settings['settings']['privateKey']
            ]);


            return $instance;
        case 'mercadopago':
            include_once($prod_path . "/third/mercadopago/autoload.php");

            MercadoPago\SDK::setAccessToken($arr_settings['settings']['token']);
            $instance = new MercadoPago\Payment();

            return $instance;

        case 'stripe':

            include_once($prod_path . "/third/stripe/autoload.php");
            $instance = new \Stripe\StripeClient($arr_settings['settings']['apiKey']);

            return $instance;
        case 'waboxapp':
            break;
        case 'chatapi':
            /* include_once($prod_path . "/third/chatapi/autoload.php");

             $instance = chatapi\WhatsApp\Client::getInstance([
                 'url' => trim($arr_settings['settings']['url']),
                 'token' => $arr_settings['settings']['token']
             ]);
             return $instance;*/
        case 's3':
            include_once($prod_path . "/third/aws.phar");

            return S3Client::factory(array(
                'version' => 'latest',
                'region' => $arr_settings['settings']['region'],
                'credentials' => array(
                    'key' => $arr_settings['settings']['api_key'],
                    'secret' => $arr_settings['settings']['api_secret'],
                ),
                'curl.options' => array(
                    'CURLOPT_SSL_VERIFYHOST' => 0,
                    'CURLOPT_SSL_VERIFYPEER' => 0,
                )
            ));
            break;

        case 'dropbox':
            include_once($prod_path . "/third/dropbox/autoload.php");
            //Configure Dropbox Application
            $app = new DropboxApp(
                $arr_settings['settings']["api_key"],
                $arr_settings['settings']["api_secret"],
                $arr_settings['settings']["access_token"]
            );

            //Configure Dropbox service
            return new Dropbox($app);

            break;
        case 'google_drive':


            $client = api_google_get_client($profile, $arr_settings['settings']['app_name'], $arr_settings['settings']['json_oauth'],
                isset($arr_settings['settings']['auth_code']) ? $arr_settings['settings']['auth_code'] : '',
                isset($arr_settings['settings']['token_code']) ? $arr_settings['settings']['token_code'] : '',
                'drive',
                isset($arr_settings['settings']['return_token']) ? $arr_settings['settings']['return_token'] : false);

            if (is_string($client)) {
                return $client;
            }
            return new Google_Service_Drive($client);

            break;
        case 'google_sheets':

            $client = api_google_get_client($profile, $arr_settings['settings']['app_name'], $arr_settings['settings']['json_oauth'],
                isset($arr_settings['settings']['auth_code']) ? $arr_settings['settings']['auth_code'] : '',
                isset($arr_settings['settings']['token_code']) ? $arr_settings['settings']['token_code'] : '',
                'sheets',
                isset($arr_settings['settings']['return_token']) ? $arr_settings['settings']['return_token'] : false);

            if (is_string($client)) {
                return $client;
            }
            return new Google_Service_Sheets($client);

            break;
        case 'onedrive':

            $client = api_onedrive_get_client($profile, $arr_settings['settings']['api_key'], $arr_settings['settings']['api_secret'],
                isset($arr_settings['settings']['auth_code']) ? $arr_settings['settings']['auth_code'] : '',
                isset($arr_settings['settings']['token_code']) ? $arr_settings['settings']['token_code'] : '',
                isset($arr_settings['settings']['return_token']) ? $arr_settings['settings']['return_token'] : false);
            return $client;

            break;
        case 'google_authenticator':
            require_once $prod_path . '/vendor/autoload.php';
            $client = new GoogleAuthenticator();

            return [ $client, $arr_settings['settings'] ];

            break;


    }

}

function sc_api_ondrive_get_url($profile, $api_key, $api_secret)
{
    $client = sc_call_api($profile, ['gateway'=> 'onedrive', 'settings' => ['api_secret' => $api_secret, 'api_key' => $api_key]]);
    return $client->createAuthUrl();
}
function sc_api_gc_get_url($app_name, $json_oauth)
{
    return api_google_get_client('', $app_name, $json_oauth);
}

function sc_api_gc_get_obj($app_name, $json_oauth, $auth_code = '', $token = ''){
    return api_google_get_client('', $app_name, $json_oauth, $auth_code, $token, '', true);
}
function sc_api_gc_token($app_name, $json_oauth, $auth_code = '', $token = '', $scope = '', $return_token = false, $profile = '')
{
    return api_google_get_client($profile, $app_name, $json_oauth, $auth_code, $token, $scope, $return_token);
}

function api_google_get_client($profile, $app_name, $json_oauth, $auth_code = '', $token = '', $scope = '', $return_token = false)
{

    $prod_path = nm_get_prod_path();
    $json_file = __DIR__ . "/api_gd_" . $profile . ".json";
    $tokenPath = __DIR__ . "/api_gd_token_" . $profile . ".json";
    if(isset($_SERVER['HTTP_REFERER'])) {
        if (strpos($_SERVER['SCRIPT_NAME'], 'prj_api')) {
            $url = explode('/devel/iface/prj_api.php', $_SERVER['HTTP_REFERER'])[0];
        } else {
            $url = explode('/prod/lib/php/nm_ini_manager2.php', $_SERVER['HTTP_REFERER'])[0];
        }
        $url .= "/prod/third/oauth/google-api-php-client/code.php";
        $json_oauth = strtr($json_oauth, ["http://localhost" => $url]);
    }
    file_put_contents($json_file, $json_oauth);
    include_once($prod_path . "/third/oauth/google-api-php-client/vendor/autoload.php");
    $client = new Google_Client();
    $client->setApplicationName($app_name);
    $client->setRedirectUri("https://scriptcase.net/scriptcase-api/");
    if (empty($scope) || $scope == 'drive') {
        $client->setScopes([Google_Service_Drive::DRIVE]);
    }elseif ($scope == 'sheets'){
        $client->setScopes([Google_Service_Drive::DRIVE, \Google_Service_Sheets::SPREADSHEETS]);
    }

    $client->setAccessType('offline');
    $client->setAuthConfig($json_file);
    //$client->setPrompt('vmunizm@gmail.com');
    $client->setApprovalPrompt('force');

    if (!empty($token)) {
        $accessToken = json_decode($token, true);
        $client->setAccessToken($accessToken);
    } else if (!empty($auth_code)) {

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($auth_code);
        // var_dump($accessToken);
        $client->setAccessToken($accessToken);

//        // Check to see if there was an error.
//        if (array_key_exists('error', $accessToken)) {
//            throw new Exception(join(', ', $accessToken));
//        }
        if ($return_token) {
            return json_encode($accessToken);
        }
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            return $client->createAuthUrl();

        }
        // Save the token to a file.

    }
    return $client;
}

function api_onedrive_get_client($profile, $api_key, $api_secret, $auth_code = '', $token='', $return_token = false)
{
    $prod_path = nm_get_prod_path();

    $json_file = __DIR__ . "/api_od_" . $profile . ".json";

    require_once $prod_path . '/vendor/autoload.php';

    $client = new OndriveClient();
    $client->setClientId($api_key);
    //$client->setTenantId('125b3545-7c05-4135-8caa-ec73a23aa2cd');
    $client->setClientSecret($api_secret);
    $client->setRedirectUri('http://localhost');
    $client->setScopes([
        OneDriveService::ONEDRIVE_OFFLINE_ACCESS,
        OneDriveService::ONEDRIVE_FILE_READ,
        OneDriveService::ONEDRIVE_FILE_READ_ALL,
        OneDriveService::ONEDRIVE_FILE_READ_WRITE,
        OneDriveService::ONEDRIVE_FILE_READ_WRITE_ALL
    ]);

    if (!empty($token)) {
        $client->setAccessToken($token);
    }
    else if(!empty($auth_code)){
        $token = json_encode($client->fetchAccessTokenWithAuthCode($auth_code));
        file_put_contents($json_file, $token);
        $client->setAccessToken($token);
        if($return_token){
            return $token;
        }
    } else{
        try {
            return ($client->createAuthUrl());
        }catch(Exception $e){
            dd($e);
        }
        return $client->createAuthUrl();
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        $client->refreshToken();

        $token = $client->getAccessToken();
        file_put_contents($json_file, $token);
        // Save the token to a file.

    }
    return $client;
}

function sc_send_sms($arr_settings)
{
    if (isset($arr_settings['profile']) && !empty($arr_settings['profile'])) {
        $instance = sc_call_api($arr_settings['profile']);
        if ($instance == false) {
            return false;
        }
        $arr_profile = nm_load_profile($arr_settings['profile']);


        $arr_profile['settings']['gateway'] = $arr_profile['gateway'];
        if (!isset($arr_settings['settings'])) {
            $arr_settings['settings'] = [];
        }
        $arr_set = array_merge($arr_settings['settings'], $arr_profile['settings']);
        $arr_sms = array_merge($arr_settings['message'], $arr_profile['settings']);
    } else {
        $instance = sc_call_api('', $arr_settings);
        $arr_sms = array_merge($arr_settings['message'], $arr_settings['settings']);
        $arr_set = $arr_settings['settings'];
    }
    try {
        switch (strtolower($arr_set['gateway'])) {
            case 'plivo':
                return $instance->messages->create(
                    $arr_sms['from'],
                    !is_array($arr_sms['to']) ? [$arr_sms['to']] : $arr_sms['to'],
                    $arr_sms['message']
                );
                break;
            case 'twilio':
                return $instance->messages->create(
                    substr($arr_sms['to'], 0, 1) == '+' ? $arr_sms['to'] : '+' . $arr_sms['to'],
                    [
                        'from' => substr($arr_sms['from'], 0, 1) == '+' ? $arr_sms['from'] : '+' . $arr_sms['from'],
                        'body' => $arr_sms['message']
                    ]
                );
            case 'clickatell':

                return $instance->sendMessage([
                    'to' => !is_array($arr_sms['to']) ? [$arr_sms['to']] : $arr_sms['to'],
                    'content' => $arr_sms['message']
                ]);
                break;
        }
    } catch (exception $e) {

    }


}

function sc_send_whatsapp($arr_settings)
{
    return;
    if (isset($arr_settings['profile']) && !empty($arr_settings['profile'])) {
        $instance = sc_call_api($arr_settings['profile']);
        if ($instance == false) {
            return false;
        }
        $arr_profile = nm_load_profile($arr_settings['profile']);


        $arr_profile['settings']['gateway'] = $arr_profile['gateway'];
        if (!isset($arr_settings['settings'])) {
            $arr_settings['settings'] = [];
        }

        $arr_set = array_merge($arr_settings['settings'], $arr_profile['settings']);

    } else {
        $instance = sc_call_api('', $arr_settings);
        $arr_set = $arr_settings['settings'];
    }
    return $instance->sendMessage([
        'phone' => $arr_settings['to'],
        'body' => $arr_settings['message']
    ]);

}

function sc_send_mail_api($arr_settings)
{
    if (isset($arr_settings['profile']) && !empty($arr_settings['profile'])) {
        $instance = sc_call_api($arr_settings['profile']);
        if ($instance == false) {
            return false;
        }
        $arr_profile = nm_load_profile($arr_settings['profile']);


        $arr_profile['settings']['gateway'] = $arr_profile['gateway'];
        if (!isset($arr_settings['settings'])) {
            $arr_settings['settings'] = [];
        }
        $arr_set = array_merge($arr_settings['settings'], $arr_profile['settings']);
        $arr_mail = array_merge($arr_settings['message'], $arr_profile['settings']);
    } else {
        $instance = sc_call_api('', $arr_settings);
        $arr_mail = array_merge($arr_settings['message'], $arr_settings['settings']);
        $arr_set = $arr_settings['settings'];
    }

    switch (strtolower($arr_set['gateway'])) {
        case 'mandrill':
            if (isset($arr_mail['attachments'])) {
                $_arr = [];

                foreach ($arr_mail['attachments'] as $att) {
                    $_arr[] = array(
                        'type' => mime_content_type($att),
                        'name' => basename($att),
                        'content' => base64_encode(file_get_contents($att))
                    );
                }
                $arr_mail['attachments'] = $_arr;
            }
            if (!is_array($arr_mail['to'])) {
                $arr_mail['to'] = [['email' => $arr_mail['to']]];
            }

            $result = $instance->messages->send($arr_mail, false, 'Main Pool', date("Y-m-d H:i:s"));
            break;

        case 'ses':

            $arr_message = ['Source' => $arr_mail['from_email']];
            if (isset($arr_mail['to']) && is_array($arr_mail['to'])) {

                $arr_to = array();
                $arr_cc = array();
                $arr_bcc = array();
                foreach ($arr_mail['to'] as $rec) {
                    if (!is_array($rec)) {
                        $rec_bkp = $rec;
                        $rec = ['email' => $rec_bkp, 'name' => '', 'type' => 'to'];
                    }
                    $rec['name'] = (!isset($rec['name'])) ? '' : $rec['name'];
                    $rec['type'] = (!isset($rec['type'])) ? 'to' : $rec['type'];
                    switch ($rec['type']) {
                        default:
                        case 'to':
                            $arr_to[$rec['email']] = $rec['name'];
                            break;
                        case 'cc':
                            $arr_cc[$rec['email']] = $rec['name'];
                            break;
                        case 'bcc':
                            $arr_bcc[$rec['email']] = $rec['name'];
                            break;
                    }
                }
                if (!isset($arr_message['Destination']) || !is_array($arr_message['Destination'])) {
                    $arr_message['Destination'] = [];
                }
                if (count($arr_to) > 0) {
                    $arr_message['Destination']['ToAddresses'] = array_keys($arr_to);
                }
                if (count($arr_cc) > 0) {
                    $arr_message['Destination']['CcAddresses'] = array_keys($arr_cc);
                }
                if (count($arr_bcc) > 0) {
                    $arr_message['Destination']['BccAddresses'] = array_keys($arr_bcc);
                }

            } else if (!is_array($arr_mail['to'])) {
                $arr_message['Destination']['ToAddresses'] = [$arr_mail['to']];
            }
            $arr_message['Message']['Subject']['Data'] = $arr_mail['subject'];
            $arr_message['Message']['Body']['Text']['Data'] = $arr_mail['text'];
            $arr_message['Message']['Body']['Html']['Data'] = $arr_mail['html'];
            if (isset($arr_mail['Reply-To'])) {
                $arr_message['ReplyToAddresses'] = $arr_mail['Reply-To'];
            }


            if (isset($arr_mail['attachments'])) {
                include(nm_get_prod_path() . '/third/Mail/mime.php');


                $mail_mime = new Mail_mime(array("eol" => "\n"));
                $mail_mime->setTxtBody($arr_mail['text']);
                $mail_mime->setHTMLBody($arr_mail['html']);

                foreach ($arr_mail['attachments'] as $att) {
                    $mail_mime->addAttachment($att, mime_content_type($att));
                }
                $mime_params = array(
                    'text_encoding' => '7bit',
                    'text_charset' => 'UTF-8',
                    'html_charset' => 'UTF-8',
                    'head_charset' => 'UTF-8'
                );

                $body = $mail_mime->get($mime_params);
                $headers = $mail_mime->txtHeaders([
                    'From' => $arr_mail['from_email'],
                    'Subject' => $arr_mail['subject'],
                    'Content-Type' => 'text/html; charset=UTF-8',
                ]);
                $message = $headers . "\r\n" . $body;
                $arr_message['RawMessage'] = [
                    'Data' => $message
                ];
                unset($arr_message['Message']);

                $arr_message['Destinations'] = $arr_message['Destination'];
                $arr_message['Destinations'] = [];
                $arr_message['Destinations']['ToAddresses'] = implode(';', ($arr_message['Destination']['ToAddresses']));
                if (isset($arr_message['Destination']['CcAddresses']) && count($arr_message['Destination']['CcAddresses']) > 0) {
                    $arr_message['Destinations']['CcAddresses'] = implode(';', ($arr_message['Destination']['CcAddresses']));
                }
                if (isset($arr_message['Destination']['BccAddresses']) && count($arr_message['Destination']['BccAddresses']) > 0) {
                    $arr_message['Destinations']['BccAddresses'] = implode(';', ($arr_message['Destination']['BccAddresses']));
                }
                unset($arr_message['Destination']);

                $result = $instance->sendRawEmail($arr_message);

            } else {
                $result = $instance->sendEmail($arr_message);
            }
            break;

        case 'smtp':
            $message = (new Swift_Message($arr_mail['subject']))
                ->setFrom([$arr_mail['from_email'] => $arr_mail['from_name']])
                ->setBody($arr_mail['text']);
            if (isset($arr_mail['html'])) {
                $message->addPart($arr_mail['html'], 'text/html');
            }
            if (isset($arr_mail['attachments'])) {
                foreach ($arr_mail['attachments'] as $att) {
                    $message->attach(Swift_Attachment::fromPath($att));
                }
            }

            if (isset($arr_mail['to'])) {

                if (!is_array($arr_mail['to'])) {
                    if(strpos($arr_mail['to'], ';') !== false){
                        $_tmp = explode(';', $arr_mail['to']);
                        $arr_mail['to'] = array();
                        foreach($_tmp as $__mail) {
                            $arr_mail['to'][] =  [
                                'email' => $__mail,
                                'type' => 'to'
                            ];
                        }
                    }else {
                        $arr_mail['to'] = [['email' => $arr_mail['to'], 'type' => 'to']];
                    }
                }
                $arr_to = array();
                $arr_cc = array();
                $arr_bcc = array();
                foreach ($arr_mail['to'] as $_rec) {
                    $rec = array();
                    $rec['email'] = !is_array($_rec) ? $_rec : $_rec['email'];
                    $rec['name'] = (!isset($_rec['name'])) ? '' : $_rec['name'];
                    $rec['type'] = !isset($_rec['type']) ? 'to' : $_rec['type'];
                    switch ($rec['type']) {
                        default:
                        case 'to':
                            $arr_to[$rec['email']] = $rec['name'];
                            break;
                        case 'cc':
                            $arr_cc[$rec['email']] = $rec['name'];
                            break;
                        case 'bcc':
                            $arr_bcc[$rec['email']] = $rec['name'];
                            break;
                    }
                }
                $message->setTo($arr_to);
                $message->setCc($arr_cc);
                $message->setBcc($arr_bcc);
            }
            if (isset($arr_mail['headers']) && isset($arr_mail['Reply-To'])) {
                $message->setReplyTo($arr_mail['Reply-To']);
            }

            $result = $instance->send($message);
            break;
    }

    return $result;

}

function nm_get_prod_path()
{
    return $_SESSION['scriptcase']['nm_path_prod'];
}

function sc_api_upload($arr_settings)
{
    global $nmgp_lang;
    if (isset($arr_settings['profile']) && !empty($arr_settings['profile'])) {
        $instance = sc_call_api($arr_settings['profile']);
        if ($instance == false) {
            return false;
        }
        $arr_profile = nm_load_profile($arr_settings['profile']);

        $arr_profile['settings']['gateway'] = $arr_profile['gateway'];
        if (!isset($arr_settings['settings'])) {
            $arr_settings['settings'] = [];
        }
        $arr_set = array_merge($arr_settings['settings'], $arr_profile['settings']);

    } else {
        $instance = sc_call_api('', $arr_settings);
        $arr_set = $arr_settings['settings'];
    }

    if (!isset($arr_settings['file_name']) || empty($arr_settings['file_name'])) {
        $arr_settings['file_name'] = mb_convert_encoding(basename($arr_settings['file']), 'UTF-8', $_SESSION['scriptcase']['charset']);
    }
    if(!isset($arr_settings['parents'])){
        $arr_settings['parents'] = '';
    }
    if (!file_exists($arr_settings['file'])) {
        $app_name = __api_getAppName();

        $__file = $_SESSION['scriptcase'][$app_name]['glo_nm_path_doc'] . '/' . $arr_settings['file'];
        $__file_img = $_SERVER['DOCUMENT_ROOT'] . $_SESSION['scriptcase'][$app_name]['glo_nm_path_imagens'] . '/' . $arr_settings['file'];
        if (file_exists($__file)) {
            $arr_settings['file'] = $__file;
        } else if (file_exists($__file_img)) {
            $arr_settings['file'] = $__file_img;
        } else {
            echo $arr_settings['file'] . ": File don't exist!";
        }
    }
    try {

        switch (strtolower($arr_set['gateway'])) {
            case 's3':
                if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                    $arr_settings['parents'] = strtr($arr_settings['parents'] . '/', ['//' => '/']);
                }
                $result = $instance->putObject([
                    'Bucket' => $arr_set['bucket'],
                    'Key' => $arr_settings['parents'] . $arr_settings['file_name'],
                    'SourceFile' => $arr_settings['file'],
                ])->toArray();

                return $result['ObjectURL'];
                break;
            case 'dropbox':
                if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                    $arr_settings['parents'] = $arr_settings['parents'][0] != '/' ? '/' . $arr_settings['parents'] : $arr_settings['parents'];
                }
                $result = $instance->upload($arr_settings['file'], $arr_settings['parents'] . '/' . $arr_settings['file_name']);

                return $result->getName();

                break;
            case 'google_drive':

                $file = new Google_Service_Drive_DriveFile();
                $file->setName($arr_settings['file_name']);
                if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                    $id = '';
                    $folders = explode('/', strtr($arr_settings['parents'], ["\\" => "/"]));

                    foreach ($folders as $_folder) {
                        if (empty($_folder)) continue;
                        $_id = '';
                        if (!empty($id)) {
                            $_id = " AND parents='" . $id . "'";
                        } else {
                            $_id = " AND parents='root'";
                        }
                        $results = $instance->files->listFiles(['q' => 'name="' . $_folder . '" AND trashed = false AND mimeType=\'application/vnd.google-apps.folder\'' . $_id]);
                        if (count($results->getFiles()) != 0) {
                            foreach ($results->getFiles() as $files) {
                                $id = $files->getId();
                                break;
                            }
                        } else {

                            $folder = new Google_Service_Drive_DriveFile();
                            $folder->setName($_folder);
                            $folder->setMimeType('application/vnd.google-apps.folder');
                            if (!empty($id)) {
                                $folder->setParents([$id]);
                            }
                            $folder = $instance->files->create($folder);
                            $id = $folder->getId();

                        }
                    }
                    $file->setParents([$id]);
                }

                $result = $instance->files->create($file, array(
                    'data' => file_get_contents($arr_settings['file']),
//                'mimeType' => mime_content_type($arr_settings['file']),
//                'uploadType' => 'media'
                ));

                return true;
                break;
            case 'onedrive':
                $handle   = fopen($arr_settings['file'], 'rb');
                $fileSize = filesize($arr_settings['file']);
                $chunkSize = 1024*1024;

                $media = new MediaFileUpload($instance, basename($arr_settings['file']), $arr_settings['parents'], true, $chunkSize);
                $media->setFileSize($fileSize);

                $res = null;
                while (!feof($handle)) {
                    $bytes = fread($handle, $chunkSize);
                    $res = $media->nextChunk($bytes);
                }
                return true;
                break;
        }
    } catch (exception $e) {
        echo isset($nmgp_lang[$_SESSION['scriptcase']['str_lang']]['nmgp_lang_usr_lang_error_upload']) ? $nmgp_lang[$_SESSION['scriptcase']['str_lang']]['nmgp_lang_usr_lang_error_upload'] : '';
        return false;
    }
}

function sc_api_download($arr_settings)
{
    if (isset($arr_settings['profile']) && !empty($arr_settings['profile'])) {
        $instance = sc_call_api($arr_settings['profile']);
        if ($instance == false) {
            return false;
        }
        $arr_profile = nm_load_profile($arr_settings['profile']);

        $arr_profile['settings']['gateway'] = $arr_profile['gateway'];
        if (!isset($arr_settings['settings'])) {
            $arr_settings['settings'] = [];
        }
        $arr_set = array_merge($arr_settings['settings'], $arr_profile['settings']);

    } else {
        $instance = sc_call_api('', $arr_settings);
        $arr_set = $arr_settings['settings'];
    }
    $arr_settings['destination'] = strtr($arr_settings['destination'], ['//' => '/']);

    $file_destination = $arr_settings['destination'];
    $path_destination = dirname($arr_settings['destination']);
    if (!is_dir($path_destination)) {
        mkdir(dirname($arr_settings['destination']), 0755, true);
    }

    try {

        switch (strtolower($arr_set['gateway'])) {
            case 's3':
                if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                    $arr_settings['parents'] = strtr($arr_settings['parents'] . '/', ['//' => '/']);
                }
                $result = $instance->getObject([
                    'Bucket' => $arr_set['bucket'],
                    'Key' => $arr_settings['parents'] . basename($arr_settings['file']),

                ]);

                file_put_contents($file_destination, $result['Body']);

                break;
            case 'dropbox':

                if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                    $arr_settings['parents'] = $arr_settings['parents'][0] != '/' ? '/' . $arr_settings['parents'] : $arr_settings['parents'];
                }
                try {
                    $retorno = $instance->download($arr_settings['parents'] . '/' . basename($arr_settings['file']), $file_destination);
                } catch (exception $e) {
                    //unlink($file_destination);
                    return false;
                }

                break;

            case 'google_drive':
                if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                    $id = '';
                    $folders = explode('/', strtr($arr_settings['parents'], ["\\" => "/"]));
                    $_id = '';

                    foreach ($folders as $_folder) {
                        if (empty($_folder)) continue;
                        if (!empty($id)) {
                            $_id = " AND parents='" . $id . "'";
                        } else {
                            $_id = " AND parents='root'";
                        }
                        $results = $instance->files->listFiles(['q' => 'name="' . $_folder . '" AND trashed = false AND mimeType=\'application/vnd.google-apps.folder\'' . $_id]);
                        if (count($results->getFiles()) != 0) {
                            foreach ($results->getFiles() as $files) {
                                $id = $files->getId();
                                break;
                            }
                        }
                    }
                }
                $_id = '';
                if (!empty($id)) {
                    $_id = " AND parents='" . $id . "'";
                }

                $results = $instance->files->listFiles(['q' => 'name="' . basename($arr_settings['file']) . '" AND trashed = false ' . $_id]);
                if (count($results->getFiles()) != 0) {
                    foreach ($results->getFiles() as $file) {
                        $id = $file->getId();
                        break;
                    }
                }
                $content = $instance->files->get($id, array("alt" => "media"));
                //$file_destination = utf8_encode($file_destination);
                file_put_contents($file_destination, $content->getBody()->getContents());

                break;
            case 'onedrive':
                $handle   = fopen($arr_settings['file'], 'rb');
                $fileSize = filesize($arr_settings['file']);
                $chunkSize = 1024*1024;

                $media = new MediaFileUpload($instance, basename($arr_settings['file']), $arr_settings['parents'], true, $chunkSize);
                $media->setFileSize($fileSize);

                $res = null;
                while (!feof($handle)) {
                    $bytes = fread($handle, $chunkSize);
                    $res = $media->nextChunk($bytes);
                }

                break;
        }
    } catch (exception $e) {
        return false;
    }
    return true;
}

function __sc_api_storage_check($arr_settings)
{

    if (isset($arr_settings['profile']) && !empty($arr_settings['profile'])) {
        $instance = sc_call_api($arr_settings['profile']);
        if ($instance == false) {
            return false;
        }
        $arr_profile = nm_load_profile($arr_settings['profile']);

        $arr_profile['settings']['gateway'] = $arr_profile['gateway'];
        if (!isset($arr_settings['settings'])) {
            $arr_settings['settings'] = [];
        }
        $arr_set = array_merge($arr_settings['settings'], $arr_profile['settings']);

    } else {
        $instance = sc_call_api('', $arr_settings);
        $arr_set = $arr_settings['settings'];
    }

    if (!isset($arr_settings['file_name']) || empty($arr_settings['file_name'])) {
        $arr_settings['file_name'] = basename($arr_settings['file']);
    }
    $file = $arr_settings['destination'] . basename($arr_settings['file']);

    if (!file_exists($arr_settings['file'])) {
        return false;
    }
    try {
        switch (strtolower($arr_set['gateway'])) {
            case 's3':
                if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                    $arr_settings['parents'] = strtr($arr_settings['parents'] . '/', ['//' => '/']);
                }
                $result = $instance->headObject([
                    'Bucket' => $arr_set['bucket'],
                    'Key' => $arr_settings['parents'] . basename($arr_settings['file']),

                ]);

                return $result->get('ETag');

                break;
            case 'dropbox':
                try {
                    if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                        $arr_settings['parents'] = $arr_settings['parents'][0] != '/' ? '/' . $arr_settings['parents'] : $arr_settings['parents'];
                    }
                    return $instance->getMetadata($arr_settings['parents'] . '/' . $arr_settings['file_name'])->content_hash == hash('sha256', hash_file('sha256', $file, true));
                } catch (exception $e) {
                }
                break;
            case 'google_drive':
                $id = '';

                if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                    $id = '';
                    $folders = explode('/', strtr($arr_settings['parents'], ["\\" => "/"]));

                    foreach ($folders as $_folder) {
                        if (empty($_folder)) continue;
                        $_id = '';
                        if (!empty($id)) {
                            $_id = " AND parents='" . $id . "'";
                        } else {
                            $_id = " AND parents='root'";
                        }
                        $results = $instance->files->listFiles(['q' => 'name="' . $_folder . '" AND trashed = false AND mimeType=\'application/vnd.google-apps.folder\'' . $_id]);
                        if (count($results->getFiles()) != 0) {
                            foreach ($results->getFiles() as $files) {
                                $id = $files->getId();
                                break;
                            }
                        }
                    }
                }
                $_id = '';
                if (!empty($id)) {
                    $_id = " AND parents='" . $id . "'";
                }

                $results = $instance->files->listFiles(['q' => 'name="' . $arr_settings['file_name'] . '" AND trashed = false ' . $_id]);
                if (count($results->getFiles()) != 0) {
                    foreach ($results->getFiles() as $file) {
                        $id = $file->getId();
                        break;
                    }
                    $md5 = $instance->files->get($id, array('fields' => 'md5Checksum'));
                }
                return $md5->md5Checksum == md5_file($arr_settings['file']);
                break;
        }
        return $file;
    } catch (exception $e) {
        return false;
    }
}

function sc_api_storage_delete($arr_settings)
{
    if (isset($arr_settings['profile']) && !empty($arr_settings['profile'])) {
        $instance = sc_call_api($arr_settings['profile']);
        if ($instance == false) {
            return false;
        }
        $arr_profile = nm_load_profile($arr_settings['profile']);

        $arr_profile['settings']['gateway'] = $arr_profile['gateway'];
        if (!isset($arr_settings['settings'])) {
            $arr_settings['settings'] = [];
        }
        $arr_set = array_merge($arr_settings['settings'], $arr_profile['settings']);

    } else {
        $instance = sc_call_api('', $arr_settings);
        $arr_set = $arr_settings['settings'];
    }

    if (!isset($arr_settings['file_name']) || empty($arr_settings['file_name'])) {
        $arr_settings['file_name'] = basename($arr_settings['file']);
    }
    $file = $arr_settings['parents'] . '/' . basename($arr_settings['file']);
    $file = strtr($file, ['//' => '/']);
    if (empty($arr_settings['file'])) {
        return false;
    }
    try {
        switch (strtolower($arr_set['gateway'])) {
            case 's3':

                $result = $instance->deleteObject([
                    'Bucket' => $arr_set['bucket'],
                    'Key' => $file,

                ]);
                if ($result['DeleteMarker']) {
                    return true;
                }
                return false;

                break;
            case 'dropbox':
                $arr_settings['file_name'] = mb_convert_encoding($arr_settings['file_name'], 'UTF-8', $_SESSION['scriptcase']['charset']);
                try {
                    if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                        $arr_settings['parents'] = $arr_settings['parents'][0] != '/' ? '/' . $arr_settings['parents'] : $arr_settings['parents'];
                    }
                    return $instance->delete($arr_settings['parents'] . '/' . $arr_settings['file_name']);
                } catch (exception $e) {
                    if (isset($nmgp_lang[$_SESSION['scriptcase']['str_lang']]['nmgp_lang_usr_lang_google_error_cert'])) {
                        echo $nmgp_lang[$_SESSION['scriptcase']['str_lang']]['nmgp_lang_usr_lang_google_error_cert'];
                    } elseif (function_exists("nm_get_text_lang")) {
                        echo nm_get_text_lang("['error_gd_cert']");
                    }
                }
                break;
            case 'google_drive':
                $id = '';
                try {
                    if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
                        $id = '';
                        $folders = explode('/', strtr($arr_settings['parents'], ["\\" => "/"]));

                        foreach ($folders as $_folder) {
                            if (empty($_folder)) continue;
                            $_id = '';
                            if (!empty($id)) {
                                $_id = " AND parents='" . $id . "'";
                            } else {
                                $_id = " AND parents='root'";
                            }
                            $results = $instance->files->listFiles(['q' => 'name="' . $_folder . '" AND trashed = false AND mimeType=\'application/vnd.google-apps.folder\'' . $_id]);
                            if (count($results->getFiles()) != 0) {
                                foreach ($results->getFiles() as $files) {
                                    $id = $files->getId();
                                    break;
                                }
                            }
                        }
                    }
                    $_id = '';
                    if (!empty($id)) {
                        $_id = " AND parents='" . $id . "'";
                    }

                    $results = $instance->files->listFiles(['q' => 'name="' . utf8_encode($arr_settings['file_name']) . '" AND trashed = false ' . $_id])->getFiles();

                    if (count($results) == 0) {
                        $results = $instance->files->listFiles(['q' => 'name="' . ($arr_settings['file_name']) . '" AND trashed = false ' . $_id])->getFiles();
                    }
                    if (count($results) == 0) {
                        $results = $instance->files->listFiles(['q' => 'name="' . urldecode($arr_settings['file_name']) . '" AND trashed = false ' . $_id])->getFiles();
                    }

                    if (count($results) != 0) {
                        foreach ($results as $file) {
                            $id = $file->getId();
                            break;
                        }
                        $instance->files->delete($id);
                    }
                    return true;
                } catch (exception $e) {
                    return false;
                }
                break;
        }
        return $file;
    } catch (exception $e) {
        return false;
    }
}

function __api_getAppName()
{
    $app = end(explode('/', strtr(dirname($_SERVER['PHP_SELF']), ["\\" => "/"])));

    return $app;
}

function sc_googledrive_get_fileid($arr_settings, $instance=null){

    $client = api_google_get_client('', $arr_settings['settings']['app_name'], $arr_settings['settings']['json_oauth'],
        isset($arr_settings['settings']['auth_code']) ? $arr_settings['settings']['auth_code'] : '',
        isset($arr_settings['settings']['token_code']) ? $arr_settings['settings']['token_code'] : '',
        'drive',
        isset($arr_settings['settings']['return_token']) ? $arr_settings['settings']['return_token'] : false);

    $instance =  new Google_Service_Drive($client);

    if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
        $id = '';
        $folders = explode('/', strtr($arr_settings['parents'], ["\\" => "/"]));
        $_id = '';

        foreach ($folders as $_folder) {
            if (empty($_folder)) continue;
            if (!empty($id)) {
                $_id = " AND parents='" . $id . "'";
            } else {
                $_id = " AND parents='root'";
            }
            $results = $instance->files->listFiles(['q' => 'name="' . $_folder . '" AND trashed = false AND mimeType=\'application/vnd.google-apps.folder\'' . $_id]);
            if (count($results->getFiles()) != 0) {
                foreach ($results->getFiles() as $files) {
                    $id = $files->getId();
                    break;
                }
            }/*else{
                $folder = new Google_Service_Drive_DriveFile();
                $folder->setName($_folder);
                $folder->setMimeType('application/vnd.google-apps.folder');
                if (!empty($id)) {
                    $folder->setParents([$id]);
                }
                $folder = $instance->files->create($folder);
                $id = $folder->getId();
            }*/
        }
    }
    $_id = '';
    if (!empty($id)) {
        $_id = " AND parents='" . $id . "'";
    }

    $results = $instance->files->listFiles(['q' => 'name="' . basename($arr_settings['file']) . '" AND trashed = false ' . $_id]);
    $id = '';
    if (count($results->getFiles()) != 0) {
        foreach ($results->getFiles() as $file) {
            $id = $file->getId();
            break;
        }
    }
    return $id;
}

function sc_googlesheets_create($arr_settings, $filename){
    if(isset($arr_settings['profile'])) {
        $service = sc_call_api($arr_settings['profile']);
    }else {
        $service = sc_call_api("", $arr_settings);
    }/*
    if (isset($arr_settings['parents']) && !empty($arr_settings['parents'])) {
        $id = '';
        $folders = explode('/', strtr($arr_settings['parents'], ["\\" => "/"]));
        $_id = '';
        foreach ($folders as $_folder) {
            if (empty($_folder)) continue;
            if (!empty($id)) {
                $_id = " AND parents='" . $id . "'";
            } else {
                $_id = " AND parents='root'";
            }
            $results = $service->files->listFiles(['q' => 'name="' . $_folder . '" AND trashed = false AND mimeType=\'application/vnd.google-apps.folder\'' . $_id]);
            if (count($results->getFiles()) != 0) {
                foreach ($results->getFiles() as $files) {
                    $id = $files->getId();
                    break;
                }
            }
        }
    }*/
    $spreadsheet = new Google_Service_Sheets_Spreadsheet([
        'properties' => [
            'title' => $filename
        ]
    ]);
    $spreadsheet = $service->spreadsheets->create($spreadsheet, [
        'fields' => 'spreadsheetId'
    ]);
    return $spreadsheet->spreadsheetId;
}

function sc_googlesheets_addRow($file_id, $arr_data, $arr_settings){

    if(isset($arr_settings['profile'])) {
        $service = sc_call_api($arr_settings['profile']);
    }else {
        $service = sc_call_api("", $arr_settings);
    }
    foreach($arr_data as $k1 => $datas){
        if(is_array($datas)) {
            foreach ($datas as $k2 => $d) {
                $arr_data[$k1][$k2] = empty($d) ? ' ' : $d;
            }
        }
    }

    $valueRange = new Google_Service_Sheets_ValueRange();
    $valueRange->setValues($arr_data);
    $range = 'A1'; // the service will detect the last row of this sheet
    $options = ['valueInputOption' => 'RAW'];
    $service->spreadsheets_values->append($file_id, $range, $valueRange, $options);
}