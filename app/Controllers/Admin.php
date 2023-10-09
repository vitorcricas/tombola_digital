<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Models\AdminModel;
use App\Models\Vouchers;

//ao extender ionauth permite usar a libraria em baixo
//home é o default controller mas só entra se tiver "loggedIn"
class Admin extends \IonAuth\Controllers\Auth
{

    protected $session;
    public $data = array();
    private $minTooltipChars = 40;

    public function __construct()
    {
        $this->ionAuth    = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->user = $this->ionAuth->user()->row();
    }


    public function index()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();

        $this->data["title"] = "Administração";
        $this->data["menu"] = 2;

        $this->data['ionAuth']          = $this->ionAuth;
        $this->data['user']          = $this->user;

        return view('comerciantes/admin', $this->data);
    }

    public function stats()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();

        $this->data["title"] = "Estatísticas";
        $this->data["menu"] = 7;

        $this->data['ionAuth']          = $this->ionAuth;
        $this->data['user']          = $this->user;

        return view('comerciantes/stats', $this->data);
    }

    public function statsQuiz()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();

        $this->data["title"] = "Estatísticas dos Quizzes";
        $this->data["menu"] = 7;

        $this->data['ionAuth']          = $this->ionAuth;
        $this->data['user']          = $this->user;

        return view('comerciantes/statsQuiz', $this->data);
    }



    public function logs()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();

        $crud = new GroceryCrud();
        //$crud->setRead(true);
        $crud->unsetDelete();
        $crud->unsetEdit();
        $crud->unsetAdd();

        $crud->displayAs('created_on', 'Data');
        $crud->displayAs('created_by', 'Utilizador');
        $crud->displayAs('type', 'Tipo');
        $crud->displayAs('comment', 'Descrição');

        $crud->callbackColumn('comment', function ($value, $row) {
            return $this->tooltip_field($value, $row);
        });


        $crud->setTable('logger');
        $crud->setSubject('Logs');
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();

        //não pode ser senão qualquer pessoa vê a lista toda de senhas existentes
        $crud->setRelation("created_by", "users", "first_name");
        $crud->defaultOrdering('created_on', 'desc');


        $output = $crud->render();

        $output->ionAuth          = $this->ionAuth;
        $output->user          = $this->user;
        $output->title = "Registo do Portal";
        $output->menu = 2;
        $output->submenu = 1;

        return $this->render('comerciantes/logs', $output);
    }



    public function drawInfo()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();

        $admin = new AdminModel();
        echo json_encode($admin->getDrawInfo($_POST['id_sorteio']));
        //$input_data = json_decode(trim(file_get_contents('php://input')), true);

    }

    public function getEstatisticas()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();

        $admin = new AdminModel();
        echo $admin->getEstatisticas();
    }

    public function getEstatisticasQuiz()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();

        $admin = new AdminModel();
        echo $admin->getEstatisticasQuiz();
    }


    public function settings()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();

        $crud = new GroceryCrud();
        //$crud->setRead(true);


        $crud->setTable('definicoes');
        $crud->setSubject('Definições');
        $crud->setRelation("id_sorteio", "sorteios", "descricao");

        $crud->fieldType("user_registration", "true_false", array('Não', 'Sim'));


        $output = $crud->render();

        $output->ionAuth          = $this->ionAuth;
        $output->user          = $this->user;
        $output->title = "Definições do Portal";
        $output->menu = 2;
        $output->submenu = 1;

        return $this->render('comerciantes/logs', $output);
    }



    function tooltip_field($value, $row)
    {
        $value = htmlentities(strip_tags($value));
        $value =  str_replace("ª", "a", $value);
        $value =  str_replace("º", "o", $value);

        if (strlen($value) > $this->minTooltipChars)
            return "<span rel='tooltip' title='" . $value . "'>" . substr($value, 0, $this->minTooltipChars) . "...</span>";
        else
            return $value;
    }


    public function draw()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();

        $admin = new AdminModel();
        $vouchers = new Vouchers();
        $vouchers->updateRegistados();

        $this->data["title"] = "Sorteio";
        $this->data["menu"] = 2;
        $this->data["submenu"] = 8;

        $this->data['ionAuth']          = $this->ionAuth;
        $this->data['user']          = $this->user;

        $this->data['id_sorteio']          = 1;
        $this->data['cupoes']          = $admin->getCupoesSorteio();
        $this->data['premios']          = $admin->getPremios($this->data['id_sorteio']);
        $this->data['premiosAtribuidos']          = $admin->getPremiosAtribuidos($this->data['id_sorteio']);

        return view('comerciantes/draw', $this->data);
    }

    public function premiados()
    {
        if (!$this->ionAuth->isAdmin())
            return redirect()->to('/')->withCookies();


        $crud = new GroceryCrud();
        $crud->unsetOperations();
        $crud->unsetExport();
        $crud->unsetPrint();

        $crud->displayAs("id_sorteio", "Sorteio");
        $crud->displayAs("id_comerciante", "Comerciante");
        $crud->setTable('vouchers');
        $crud->setSubject('Premiados');

        $crud->setRelation("id_sorteio", "sorteios", "descricao");
        $crud->setRelation("id_comerciante", "comerciantes", "nome");

        $crud->columns(array("id_sorteio", "cliente", "id_comerciante", "codigo", "valor"));
        $crud->where('vouchers.id_sorteio', "1");
        $crud->defaultOrdering('valor', "desc");

        $crud->callbackColumn('cliente', function ($value, $row) {
            $admin = new AdminModel();
            return $admin->getDadosPremiado($row->id_voucher);
        });

        $crud->callbackColumn('valor', function ($value, $row) {
            return $value."€";
        });

        $output = $crud->render();

        $output->ionAuth          = $this->ionAuth;
        $output->user          = $this->user;
        $output->title = "Premiados";
        $output->menu = 2;
        $output->submenu = 8;
        return $this->render('comerciantes/premiados', $output);
    }


    public function saveWinner()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getPost()) {
            $admin = new AdminModel();
            $admin->saveWinner($this->request->getPost());
        }
    }


    private function render($view = 'default', $output = null)
    {
        return view($view, (array)$output);
    }
}
