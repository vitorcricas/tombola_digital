<?php

namespace App\Controllers;

use App\Models\ComerciantesModel;
use App\Models\ComerciantesAdesao;
use App\Models\AdminModel;
use App\Models\Registos;


//ao extender ionauth permite usar a libraria em baixo
//home é o default controller mas só entra se tiver "loggedIn"
class Home extends \IonAuth\Controllers\Auth
{

    protected $session;
    public $data = array();

    public function __construct()
    {
        helper(["url"]);
    }

    //https://onlinewebtutorblog.com/working-with-codeigniter-4-model-and-entity/

    /* public function login()
    {
        //      helper('login');      
        //$isLog=isLogged($this,"user","passwd");
        //echo $isLog;
        if (! $this->ionAuth->loggedIn())
        {
            // redirect them to the login page
            return redirect()->to('/login')->withCookies();
        }
        $this->session = \Config\Services::session();
        //print_r($this->session->get('email'));
        $id = $this->ionAuth->user()->row()->id;
        $user          = $this->ionAuth->user($id)->row();
        $this->data['ionAuth']          = $this->ionAuth;
        $this->data['user']          = $user;

        $this->data["title"] = "Emissões";
        $this->data["menu"] = 2;
ComerciantesModel);
        //neste where é que é feita a filtragem pelo utilizador atual...
      //  $this->data['emissoes'] = $ocoModel->getEmissoes($this->ionAuth->user()->row()->nif,$this->ionAuth->user()->row()->email);

        return
         view('emissoes', $this->data);
    }*/

    public function index()
    {
        $admin = new AdminModel();
        $drawData = $admin->select(['adesao_dataI', 'adesao_dataF', 'registo_dataI', 'registo_dataF'])->where('id_sorteio', 1)->first();
        $currentDate = strtotime(date('Y-m-d', time()));
        $startDate = strtotime($drawData["registo_dataI"]);
        $endDate = strtotime($drawData["registo_dataF"]);
        $this->data["openR"]  = 1;
        if ($currentDate < $startDate || $currentDate > $endDate) {
            $this->data["openR"]  = 0;
        }


        $startDate = strtotime($drawData["adesao_dataI"]);
        $endDate = strtotime($drawData["adesao_dataF"]);
        $this->data["open"]  = 1;
        if ($currentDate < $startDate || $currentDate > $endDate) {
            $this->data["open"]  = 0;
        }
        $this->data["title"] = "Início";
        $this->data["menu"] = 1;
        return view('inicio', $this->data);
    }


     public function comerciantes()
    {
        $this->data["title"] = "Comerciantes";
        $this->data["menu"] = 3;

        $comerciantesModel = new ComerciantesModel();
        //todo filtrar ativos
        $comerciantes = $comerciantesModel->where('ativo', 1)->orderBy('nome', 'asc')->findAll();

        foreach ($comerciantes as $key => &$val) :
            $val['disponivel'] = $comerciantesModel->getDisponibilidade($val["id_comerciante"]);
        endforeach;

        $this->data["comerciantes"] = $comerciantes;
        $this->data["areas"] = $comerciantesModel->getAreas();
        $this->data["freguesias"] = $comerciantesModel->getFreguesias();
        $config = config('gmaps');
        $this->data["apikey"] = $config->apikey;


        //neste where é que é feita a filtragem pelo utilizador atual...
        //  $this->data['emissoes'] = $ocoModel->getEmissoes($this->ionAuth->user()->row()->nif,$this->ionAuth->user()->row()->email);

        return view('comerciantes', $this->data);
    }
/*
    public function faq()
    {
        $this->data["title"] = "FAQ";
        $this->data["menu"] = 6;

        return view('faq', $this->data);
    }*/


    public function adesao()
    {
        $admin = new AdminModel();
        $drawData = $admin->select(['adesao_dataI', 'adesao_dataF'])->where('id_sorteio', 1)->first();
        $currentDate = strtotime(date('Y-m-d', time()));
        $startDate = strtotime($drawData["adesao_dataI"]);
        $endDate = strtotime($drawData["adesao_dataF"]);
        $this->data["open"]  = 1;
        if ($currentDate < $startDate || $currentDate > $endDate) {
            $this->data["open"]  = 0;
        }

        $this->data["title"] = "Adesão de Comerciantes";
        $this->data["menu"] = 3;

        return view('adesao', $this->data);
    }

    public function regulamento()
    {
        $this->data["title"] = "Regulamento";
        $this->data["menu"] = 5;

        return view('regulamento', $this->data);
    }

    public function montras()
    {
        $this->data["title"] = "Concurso de Montras";
        $this->data["menu"] = 8;

        return view('montras', $this->data);
    }    

    function contato()
    {
        $this->data["title"] = "FAQ";
        $this->data["menu"] = 7;

        return view('contato', $this->data);
    }

      public function sorteio()
    {
        $registosModel = new Registos();
        $this->data["totalCupoes"]  = count($registosModel->findAll());
        $admin = new AdminModel();
        $this->data["premios"]  = $admin->getPremios(1);
        $this->data["premiados"]  = $admin->getListaPremios(1);
        $this->data["title"] = "Sorteio";
        $this->data["menu"] = 9;

        return view('sorteios', $this->data);
    }



    public function getCP()
    {
        $request = \Config\Services::request();
        $userModel = new ComerciantesModel();
        //todo filtrar ativos
        $localidade = $userModel->getCP($request->getVar('cp4'), $request->getVar('cp3'));
        echo $localidade;
    }


    public function sendMailAdesao()
    {

        $this->request = \Config\Services::request();
        //echo $request->getVar('nome');

        if ($this->request->getPost()) {

            $rules = [
                "nome" => "required",
                "morada" => "required",
                "telefone" => "required",
                "resp_nome" => "required"
            ];

            if (!$this->validate($rules)) {

                $response = [
                    'success' => false,
                    'msg' => "Erros de validação"
                ];
                return $this->response->setJSON($response);
            } else {

                $adesaoModel = new ComerciantesAdesao();

                $data = [
                    "nome" => $this->request->getVar("nome"),
                    "resp_nome" => $this->request->getVar("resp_nome"),
                    "email" => $this->request->getVar("email"),
                    "contato" => $this->request->getVar("telefone"),
                    "morada" => $this->request->getVar("morada") . ", " . $this->request->getVar("cp1") . "-" . $this->request->getVar("cp2") . " " . $this->request->getVar("localidade")
                ];

                if ($this->sendMail($data) == "") {
                    if ($adesaoModel->insert($data)) {

                        $response = [
                            'success' => true,
                            'msg' => "Adesão inserida"
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'msg' => "Falha ao registar adesão"
                        ];
                    }
                } else {
                    $response = [
                        'success' => false,
                        'msg' => "Email inválido?"
                    ];
                }
                return $this->response->setJSON($response);
            }
        }
    }

    public function sendMail($data)
    {

        $subject = lang('Email.adesaoSubject');

        $message =  view('App\Views\email\adesao', $data);

        $email = \Config\Services::email();

        if ($data["email"] != "") { //comerciante tem email?
            $to = $data["email"];
            $email->setTo($to);
        }
        $email->setBCC("infoaciba@gmail.com");

        $email->setFrom($email->SMTPUser, 'ACIBA - Tômbola de Natal');

        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            return '';
        } else {
            $data = $email->printDebugger(['headers']);
            //print_r($data);
            return "-1";
        }
    }



    public function sendContactForm()
    {

        $RESPONSE_MSG = [
            'success' => [
                "message_sent"           => "We have <strong>successfully</strong> received your message. We will get back to you as soon as possible."
            ],
            'form' => [
                "recipient_email"        => "Message not sent! The recipient email address is missing in the config file.",
                "name"                   => "Contact Form",
                "subject"                => "New Message From Contact Form"
            ],
            'google' => [
                "recaptcha_invalid"     => "Faça a verificação do recaptcha",
                "recaptcha_secret_key"  => "Google reCaptcha secret key is missing in config file!"
            ],
            'config' => [
                "allow_url_fopen_invalid"     => "PHP: <strong>allow_url_fopen</strong> OR <strong>php_curl</strong> extension must be enabled in your php.ini file in order to use Google reCaptcha."
            ]
        ];

        $this->request = \Config\Services::request();
        //echo $request->getVar('nome');
        $recaptcha_secret_key = "6Ld_mfMiAAAAAFLpf_OU9CQrytyNcy9l9lnX1DmX";

        if (isset($_POST['g-recaptcha-response'])) {

            if (empty($recaptcha_secret_key)) {
                $response = array('response' => 'error', 'message' => $RESPONSE_MSG['google']['recaptcha_secret_key']);
                return $this->response->setJSON($response);
            }

            if (ini_get('allow_url_fopen')) {
                //Try option: 1 - File get contents
                $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret_key . '&response=' . $_POST['g-recaptcha-response']);
                $response_data = json_decode($response);
            } else if (extension_loaded('curl')) {
                //Try option: 2 - cUrl
                $ch = curl_init();
                curl_setopt_array($ch, [CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify', CURLOPT_POST => true, CURLOPT_POSTFIELDS => ['secret' => $recaptcha_secret_key, 'response' => $_POST['g-recaptcha-response'], 'remoteip' => $_SERVER['REMOTE_ADDR']], CURLOPT_RETURNTRANSFER => true]);
                $response = curl_exec($ch);
                curl_close($ch);
                $response_data = json_decode($response);
            } else {
                $response = array('response' => 'error', 'message' => $RESPONSE_MSG['config']['allow_url_fopen_invalid']);
                return $this->response->setJSON($response);
            }

            //Return error message if not validated
            if ($response_data->success !== true) {
                $response = array('response' => 'error', 'message' => $RESPONSE_MSG['google']['recaptcha_invalid']);
                return $this->response->setJSON($response);
            }
        }


        if ($this->request->getPost()) {
            $data = [
                "nome" => $this->request->getVar("nome"),
                "email" => $this->request->getVar("email"),
                "assunto" => $this->request->getVar("assunto"),
                "mensagem" => $this->request->getVar("mensagem")
            ];

            $to = $data["email"];
            $subject = $data["assunto"];

            $message =  view('App\Views\email\contato', $data);

            $email = \Config\Services::email();
            $email->setTo($to);
            $email->setBCC("infoaciba@gmail.com");

            $email->setFrom($email->SMTPUser, 'ACIBA - Tômbola de Natal');

            $email->setSubject($subject);
            $email->setMessage($message);
            if ($email->send())
                $response = [
                    'response' => true
                ];
            else {
                $data = $email->printDebugger(['headers']);
                //print_r($data);
                $response = [
                    'response' => false,
                    'message' => 'Erro no envio. O email está correto?'
                ];
            }

            return $this->response->setJSON($response);
        }
    }
}




    /*class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}
}*/
