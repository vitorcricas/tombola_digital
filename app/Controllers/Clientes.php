<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Libraries\Tooltip_GCRUD;

use App\Models\LogModel;
use App\Models\ComerciantesModel;
use App\Models\Vouchers;
use App\Models\AdminModel;
use App\Models\QuizModel;
use App\Models\Registos;


//ao extender ionauth permite usar a libraria em baixo
//home é o default controller mas só entra se tiver "loggedIn"
class Clientes extends BaseController
{

    protected $session;
    public $data = array();
    private $user;


    public function __construct()
    {
        $this->ionAuth    = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->user = $this->ionAuth->user()->row();
    }


    public function dashboard()
    {

        if ($this->ionAuth->inGroup("comerciantes") || $this->ionAuth->isAdmin())
            return redirect()->to('/comerciantes/dashboard')->withCookies();
        else if (!$this->ionAuth->loggedIn())
            return redirect()->to('/clientes')->withCookies();

        $admin = new AdminModel();

        $this->data['ionAuth']          = $this->ionAuth;
        $this->data['user']          = $this->user;
        $this->data["title"] = "Área de Cliente";
        $this->data["menu"] = 2;
        $this->data["submenu"] = 0;
        $this->data["hasQuiz"] = $admin->hasQuiz($this->user->id);

        $drawData = $admin->select(['registo_dataI', 'registo_dataF'])->where('id_sorteio', 1)->first();

        $currentDate = strtotime(date('Y-m-d', time()));
        $startDate = strtotime($drawData["registo_dataI"]);
        $endDate = strtotime($drawData["registo_dataF"]);
        $this->data["registration"] = 1;

        $this->data["concelhos"] = $admin->getConcelhos();

        if ($currentDate < $startDate || $currentDate > $endDate) {
            $this->data["registration"] = 0;
        }

        if ($admin->hasQuiz($this->user->id)) {
            $registosModel = new Registos();
            $this->data["totalCupoes"]  = count($registosModel->where('id_utilizador', $this->user->id)->findAll());

            return view('clientes/dashboard', $this->data);
        } else
            return view('clientes/quiz', $this->data);
    }



    public function cupoes()
    {


        if (!$this->ionAuth->loggedIn())
            return redirect()->to('/')->withCookies();
        if (!$this->ionAuth->inGroup("clientes"))
            return redirect()->to('/dashboardC')->withCookies();



        $crud = new Tooltip_GCRUD();
        //$crud->setRead(true);
        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->unsetDelete();
        $crud->unsetEdit();

        $admin = new AdminModel();
        $drawData = $admin->select(['registo_dataI', 'registo_dataF'])->where('id_sorteio', 1)->first();
        $currentDate = strtotime(date('Y-m-d', time()));
        $startDate = strtotime($drawData["registo_dataI"]);
        $endDate = strtotime($drawData["registo_dataF"]);

        if ($currentDate < $startDate || $currentDate > $endDate) {
            $crud->unsetAdd();
        }

        $crud->setTable('registos');
        $crud->setSubject('Senhas');
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();


        //$crud->setApiUrlPath(base_url('clientes/cupoes'));
        $crud->fields(array('id_voucher', 'id_utilizador'));
        $crud->fieldType('id_utilizador', 'hidden');
        $crud->requiredFields(['id_voucher']);

        $crud->fieldType('data', 'timestamp');

        $crud->setRule('id_voucher', 'voucher', 'validaVoucher[id_voucher]');

        $crud->columns(array('id_voucher', 'data', 'id_comerciante'));
        $crud->defaultOrdering('data', 'desc');
        $crud->displayAs('id_voucher', 'Nº Senha');
        $crud->displayAs('data', 'Data Registo');
        $crud->displayAs('id_comerciante', 'Comerciante');

        $crud->tooltip("id_voucher", "Coloque aqui o número que aparece na senha");

        //não pode ser senão qualquer pessoa vê a lista toda de senhas existentes
        //$crud->setRelation("id_voucher", "vouchers", "codigo");


        $crud->callbackColumn('id_comerciante', function ($value, $row) {
            $vouchers = new Vouchers();
            $comerciantes = new ComerciantesModel();
            $id_comer = $vouchers->find($row->id_voucher)["id_comerciante"];
            $comerciante = $comerciantes->find($id_comer)["nome"];
            return $comerciante;
        });

        //para não aparecerem todos as senhas em lista...
        $crud->callbackAddField('id_voucher', function ($fieldType, $fieldName) {
            return '<input class="form-control" name="id_voucher" type="number" value="">';
        });


        $crud->callbackBeforeInsert(function ($stateParameters) {
            $registosModel = new Registos();
            $stateParameters->data["id_voucher"] = $registosModel->getVoucher($stateParameters->data["id_voucher"]);
            $stateParameters->data["id_utilizador"] = $this->user->id;

            return $stateParameters;
        });

        $crud->callbackAfterInsert(function ($stateParameters) {
            $logModel = new LogModel();
            // Add operation
            $logModel->insert_data(array(
                "created_by" => $this->session->get('user_id'),
                "type" => "senhas",
                "comment" => "inseriu senha com o código " . $stateParameters->data["id_voucher"],
            ));
            return $stateParameters;
        });

        $crud->where('registos.id_utilizador', $this->user->id);

        //search for fallback fields
        if (isset($_POST['search_field']) && $_POST['search_field'] != "") {
            $searchFields = $_POST['search_field'];
            $searchValues = $_POST['search_text'];

            $key = array_search('id_comerciante', $searchFields);
            if ($key !== false) {

                $crud->where("registos.id_voucher in (select id_voucher from vouchers v, comerciantes c where v.id_comerciante=c.id_comerciante and c.nome like '%" . $searchValues[$key] . "%')");
                //unset para não correr os métodos na libraria gcrud
                $searchValues[$key] = '';
                $_POST['search_text'] = $searchValues;
            }
        }

        $output = $crud->render();

        $output->ionAuth          = $this->ionAuth;
        $output->user          = $this->user;
        $output->title = "Registo de Senhas";
        $output->menu = 2;
        $output->submenu = 1;

        if ($currentDate < $startDate || $currentDate > $endDate) {
            $output->output = "<div role='alert' class='alert alert-danger'>" . lang('Errors.cupon_registration_closed') . "</div>" . $output->output;
        }

        return $this->render('clientes/cupoes', $output);
    }



    public function sorteios()
    {

        if (!$this->ionAuth->loggedIn())
            return redirect()->to('/')->withCookies();


        $crud = new GroceryCrud();

        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->unsetDelete();
        $crud->unsetEdit();
        $crud->unsetAdd();
        //$crud->setRead(true);
        $crud->displayAs('data', 'Data do Sorteio');
        $crud->displayAs('cupoes', 'Senhas Registadas na tômbola digital');

        $crud->columns(['descricao', 'ano', 'cupoes', 'info']);

        $crud->callbackColumn('info', function ($value, $row) {

            $html = "<a class='btn btn-default' href='#' id='drawInfo' data-toggle='modal' data-target='#modal-drawInfo' data-id='" . $row->id_sorteio . "'><i class='fas fa-info-circle'></i></i> Mais Info.</a>";
            if ($row->data != "")
                $html .= "<a class='btn btn-default' href='#' id='drawPrizes' data-id='" . $row->id_sorteio . "'><i class='fas fa-trophy'></i></i> Senhas Premiadas</a>";

            return $html;
        });

        $crud->callbackColumn('cupoes', function ($value, $row) {
            $registosModel = new Registos();
            return count($registosModel->findAll());
        });

        $crud->setTable('sorteios');
        $crud->setSubject('Sorteios');
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();
        $crud->defaultOrdering('ano', 'desc');


        $output = $crud->render();

        $output->ionAuth          = $this->ionAuth;
        $output->user          = $this->user;
        $output->title = "Sorteios";
        $output->menu = 2;
        $output->submenu = 4;

        return $this->render('clientes/sorteios', $output);
    }


    public function drawInfo()
    {
        if (!$this->ionAuth->loggedIn())
            return redirect()->to('/')->withCookies();

        $admin = new AdminModel();
        echo json_encode($admin->getDrawInfo($_POST['id_sorteio']));
        //$input_data = json_decode(trim(file_get_contents('php://input')), true);

    }

    public function doneQuiz()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getPost()) {
            $admin = new AdminModel();
            echo json_encode($admin->saveQuiz($this->user->id));
        }
    }



    public function saveQuiz()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getPost()) {

            $data = [
                'q1'    => $this->request->getVar("q1"),
                'q2'    => $this->request->getVar("q2"),
                'q3'    => $this->request->getVar("q3"),
                'q4'    => ($this->request->getVar("q4") != "Outros") ? $this->request->getVar("q4") : $this->request->getVar("outros"),
                'q5'    => $this->request->getVar("q5")
            ];

            $userModel = new QuizModel();
            $response = [
                'success' => $userModel->insert($data, false)
            ];

            $userModel->saveQuiz($this->user->id);

            return $this->response->setJSON($response);
        }
    }

    private function render($view = 'default', $output = null)
    {
        $admin = new AdminModel();
        $output->hasQuiz = $admin->hasQuiz($this->user->id);
        return view($view, (array)$output);
    }



    protected function _unique_join_name($field_name)
    {
        return 'j' . substr(md5($field_name), 0, 8); //This j is because is better for a string to begin with a letter and not with a number
    }

    protected function _unique_field_name($field_name)
    {
        return 's' . substr(md5($field_name), 0, 8); //This s is because is better for a string to begin with a letter and not with a number
    }
}
