<?php

class Controller
{
    private $public_id = '';
    private $secret_key = '';
    private $INN = '';
    private $applepay_merchant_id = '';
    private $googlepay_merchant_id = '';
    private $googlepay_gateway = '';

    private $base_path = '/'; // Укажите путь, если сайт развернут не в корне домена

    public $view;
    public $model;
    public $products;

    private $site_url = '';

    function __construct()
    {
        $this->loadConfig();
        $this->model = new Model();
        $this->view = new View();
        $this->site_url = 'https://' . $_SERVER['HTTP_HOST'] . $this->base_path;
        $this->view->setData('base_path', $this->base_path);
        $this->view->setData('base_url', $this->base_path);
        $this->view->setData('assets_url', $this->base_path . 'assets/');

        $this->view->setData('config', array(
            'public_id' => $this->public_id,
            'applepay_merchant_id' => $this->applepay_merchant_id,
            'googlepay_gateway' => $this->googlepay_gateway,
            'googlepay_merchant_id' => $this->googlepay_merchant_id
        ));
        $this->view->setData('footer_classes', '');

        if (!$this->dispatchAction()) {
            $this->view->setLayout('layout');
            $this->dispatch();
        };
    }

    public function loadConfig()
    {
        $file = __DIR__ . '/config.php';
        if (file_exists($file)) {
            $config = include $file;
            $this->public_id = isset($config['public_id']) ? $config['public_id'] : '';
            $this->secret_key = isset($config['secret_key']) ? $config['secret_key'] : '';
            $this->INN = isset($config['inn']) ? $config['inn'] : '';
            $this->applepay_merchant_id = isset($config['applepay_merchant_id']) ? $config['applepay_merchant_id'] : '';
            $this->googlepay_merchant_id = isset($config['googlepay_merchant_id']) ? $config['googlepay_merchant_id'] : '';
            $this->googlepay_gateway = isset($config['googlepay_gateway']) ? $config['googlepay_gateway'] : '';
        }
    }

    /**
     * Роутинг страниц
     */
    public function dispatch()
    {
        $route = current(explode('?', $_SERVER['REQUEST_URI']));
        $route = preg_replace('/[^a-z0-9_]/', '', $route);

        $data = array();

        $data['products_count'] = $this->model->getCartCount();
        $data['cart'] = $this->model->getCart();

        $template = $route;
        switch ($route) {
            case '':
                $template = 'index';
                break;
            case 'widget':
                $data['products'] = $this->model->getProducts();
                $data['order'] = $this->model->getOrder();
                break;
            case 'checkout':
                $data['products'] = $this->model->getProducts();
                $data['order'] = $this->model->getOrder();
                break;
            case 'order':
                $data['order'] = $this->model->getOrder();
                break;
            case 'success':
                $this->model->clear();
                break;
            case 'success2':
                $this->model->clear();
                break;
            case 'failure':
                break;
            default:
                $template = '404';
        }

        $this->view->render($template, $data);
    }

    /** Оплата по криптограмме *
     * @param $data
     * @return mixed|null
     */
    public function cryptogramPay($data)
    {
        $API_URL = "https://api.cloudpayments.ru/payments/cards/charge";

        $order = $this->model->getOrder();

        $items = array();
        foreach ($order['items'] as $item) {
            $items[] = array(
                'label' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['count'],
                'amount' => $item['price'] * $item['count'],
                'vat' => 18
            );
        }

        $json_data = array(
            'cloudPayments' => array(
                'customerReceipt' => array(
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'Items' => $items
                )
            )
        );

        $request = array(
            'Amount' => $order['total_cost'],
            'Currency' => 'RUB',
            'IpAddress' => $_SERVER['REMOTE_ADDR'],
            'InvoiceId' => '1',
            'AccountId' => '1',
            'Name' => $data['name'],
            'Email' => $data['email'],
            'CardCryptogramPacket' => $data['cryptogram'],
            'JsonData' => json_encode($json_data),
        );

        return $this->sendRequest($API_URL, $request);
    }

    /**
     * Отправка API запроса в CloudPayments
     *
     * @param $API_URL
     * @param $request
     * @return mixed|null
     */
    public function sendRequest($API_URL, $request)
    {
        if ($curl = curl_init($API_URL)) {

            $ch = curl_init($API_URL);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $this->public_id . ":" . $this->secret_key);
            curl_setopt($ch, CURLOPT_URL, $API_URL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            $data1 = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            $content = json_decode($data1, true);
            return $content;
        } else {
            return null;
        }
    }


    /**
     * Обработка AJAX запросов
     */
    public function dispatchAction()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return false;
        }
        switch ($_REQUEST['action']) {
            case 'addCart':
                $new_count = $this->model->addProduct($_POST['product_id'], isset($_POST['count']) ? $_POST['count'] : 1);
                $order = $this->model->getOrder();
                $response = array(
                    'product_id' => $_POST['product_id'],
                    'cart_widget' => $this->view->fetch('cart_widget', array(
                        'order' => $order
                    )),
                    'cart_added' => $this->view->fetch('cart_added', array(
                        'item' => $order['items'][$_POST['product_id']]
                    )),
                    'total_count' => $order['total_count'],
                    'total_cost' => $order['total_cost'],
                    'item_count' => $new_count,
                    'item_cost' => $order['items'][$_POST['product_id']]['cost']
                );

                $this->responseJson($response);

                break;

            case 'removeCart':
                $new_count = $this->model->deleteProduct($_POST['product_id'], isset($_POST['count']) ? $_POST['count'] : null);

                $order = $this->model->getOrder();
                $response = array(
                    'product_id' => $_POST['product_id'],
                    'cart_widget' => $this->view->fetch('cart_widget', array(
                        'order' => $order
                    )),
                    'total_count' => $order['total_count'],
                    'total_cost' => $order['total_cost'],
                    'item_count' => $new_count,
                    'item_cost' => $new_count > 0 ? $order['items'][$_POST['product_id']]['cost'] : 0
                );

                $this->responseJson($response);

                break;

            case 'sendCryptogram':
                $response = $this->cryptogramPay($_POST);

                $response['success_url'] = $this->base_path . 'success2/';
                $response['failure_url'] = $this->base_path . 'failure/';

                if ($response['Success']) {
                    $this->model->clear();
                } else {
                    if (isset($response['Model']['AcsUrl'])) {
                        $response['Model']['TermUrl'] = $this->site_url . '?action=post3ds';
                        $response['acs_form'] = $this->view->fetch('3ds_secure', $response['Model']);
                    }
                }

                $this->responseJson($response);
                break;

            case 'post3ds':
                /** 3Dsec подтверждение **/
                if (isset($_POST['MD'], $_POST['PaRes'])) {
                    $request = array(
                        "TransactionId" => $_POST['MD'],
                        "PaRes" => $_POST['PaRes'],
                    );
                    $response = $this->sendRequest('https://api.cloudpayments.ru/payments/cards/post3ds', $request);
                    if ($response['Success']) {
                        $this->model->clear();
                        header('Location: ' . $this->site_url . 'success/');
                        die();
                    } else {
                        if ($response['Model']['CardHolderMessage']) {
                            header('Location: ' . $this->site_url . 'failure/?msg=' . $response['Model']['CardHolderMessage']);
                        } else {
                            header('Location: ' . $this->site_url . 'failure/?msg=' . $response['Message']);
                        }
                        die();
                    }
                }
                break;
            /** APPLE PAY **/
            case 'startSession':
                if ($_POST['pay'] == 'Apple') {
                    if ($_POST['validationUrl']) {
                        $request = array(
                            "ValidationUrl" => $_POST['validationUrl'],
                        );
                        $response = $this->sendRequest('https://api.cloudpayments.ru/applepay/startsession',
                            $request);
                        $this->responseJson($response);
                    }
                }
                break;

            case 'pay':
                //ApplePay и GooglePay
                $request = array();
                $request['name'] = 'Ivanov Ivan';
                $request['cryptogram'] = $_POST['cryptogram'];
                if (isset($_POST['Phone'])) {
                    $request['phone'] = $_POST['Phone'];
                } elseif (isset($_POST['Email'])) {
                    $request['email'] = $_POST['Email'];
                }
                $response = $this->cryptogramPay($request);
                if ($_POST['pay'] == 'Google') {
                    $response['Model']['TermUrl'] = $this->site_url . '?action=post3ds';
                    $response['acs_form'] = $this->view->fetch('3ds_secure', $response['Model']);
                }
                $this->responseJson($response);
                break;
            default:
                //Действие не найдено, поэтому перенаправляем на роутинг страниц
                return false;
        }

        return true;
    }

    /**
     * Возвращает ответ в JSON
     *
     * @param $response
     */
    public function responseJson($response)
    {
        header('Content-Type: application/json');

        echo json_encode($response);
        die();
    }
}
