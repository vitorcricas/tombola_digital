<?php
//todo update registados antes do sorteio

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Libraries\Tooltip_GCRUD;

use App\Models\LogModel;
use App\Models\ComerciantesModel;
use App\Models\Vouchers;

use App\Models\Registos;

use setasign\Fpdi\Fpdi;
use mikehaertl\pdftk\Pdf;
use PHPUnit\TextUI\XmlConfiguration\Group;

//ao extender ionauth permite usar a libraria em baixo
//home é o default controller mas só entra se tiver "loggedIn"
class Comerciantes extends BaseController
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

        if (!$this->ionAuth->loggedIn())
            return redirect()->to('/')->withCookies();
        if (!$this->ionAuth->inGroup("comerciantes") && !$this->ionAuth->isAdmin())
            return redirect()->to('/dashboard')->withCookies();


        $this->data['ionAuth']          = $this->ionAuth;
        $this->data['user']          = $this->user;

        $registosModel = new Registos();

        $this->data["totalCupoes"]  = count($registosModel->findAll());


        $this->data["title"] = "Área de Comerciantes";
        $this->data["menu"] = 2;
        $this->data["submenu"] = 0;


        return view('comerciantes/dashboard', $this->data);
    }



    public function cupoes()
    {

        if (!$this->ionAuth->loggedIn())
            return redirect()->to('/')->withCookies();
        if (!$this->ionAuth->inGroup("comerciantes") && !$this->ionAuth->isAdmin())
            return redirect()->to('/dashboard')->withCookies();


        // $crud = new GroceryCrud();
        $crud = new GroceryCrud(); //create object

        //$crud->setRead(true);
        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->unsetDelete();
        $crud->unsetEdit();
        $crud->unsetAdd();



        $crud->columns(array('id_utilizador', 'id_voucher', 'data', 'id_comerciante'));

        $crud->setTable('registos');
        $crud->setSubject('Senhas Registadas');
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();


        $crud->defaultOrdering('data', 'desc');
        $crud->displayAs('id_voucher', 'Nº Senha');
        $crud->displayAs('data', 'Data Registo');
        $crud->displayAs('id_utilizador', 'Cliente');
        $crud->displayAs('id_comerciante', 'Comerciante');


        //não pode ser senão qualquer pessoa vê a lista toda de senhas existentes
        $crud->setRelation("id_voucher", "vouchers", "codigo");
        $crud->setRelation("id_utilizador", "users", "first_name");


        $crud->callbackColumn('id_comerciante', function ($value, $row) {
            $vouchers = new Vouchers();
            $comerciantes = new ComerciantesModel();
            $id_comer = $vouchers->find($row->id_voucher)["id_comerciante"];
            $comerciante = $comerciantes->find($id_comer)["nome"];
            return $comerciante;
        });


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
        $output->title = "Senhas Registadas";
        $output->menu = 2;
        $output->submenu = 1;

        return $this->render('comerciantes/cupoes', $output);
    }


    public function vouchers()
    {

        if (!$this->ionAuth->loggedIn())
            return redirect()->to('/')->withCookies();
        if (!$this->ionAuth->inGroup("comerciantes") && !$this->ionAuth->isAdmin())
            return redirect()->to('/dashboard')->withCookies();


        $crud = new Tooltip_GCRUD();
        $crud->unsetDelete();
        //$crud->unsetEdit();
        //$crud->setRead(true);
        $registosModel = new Registos();
        $nSenhasMaco = intval($registosModel->getNSenhasMaco());

        $vouchers = new Vouchers();
        $vouchers->updateRegistados();

        $crud->columns(array('id_comerciante', 'codigo', 'registado', 'id_sorteio',  'valor'));
        $crud->fields(array('id_comerciante', 'codigo', 'codigo_f', 'n_macos'));

        $crud->setTable('vouchers');
        $crud->setSubject('Senhas');
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();


        $crud->defaultOrdering('codigo', 'desc');
        $crud->displayAs('id_sorteio', 'Sorteado?');
        $crud->displayAs('id_comerciante', 'Comerciante');
        $crud->displayAs('registado', 'Registado por cliente?');
        $crud->displayAs('n_macos', 'Nº de Maços');
        $crud->displayAs('codigo', 'Código Inicial');
        $crud->displayAs('codigo_f', 'Código Final');
        $crud->tooltip('codigo', 'Código inicial do maço de senhas a atribuir');
        $crud->tooltip('codigo_f', 'O sistema assume automaticamente 100 senhas visto que cada maço normalmente tem ' . $nSenhasMaco . ' senhas. Confirme que o código final é este ou altere');
        $crud->tooltip('n_macos', 'Só é possível inserir/atribuir um maço de cada vez');

        $crud->uniqueFields(['codigo']);


        //não pode ser senão qualquer pessoa vê a lista toda de senhas existentes
        $crud->setRelation("id_sorteio", "sorteios", "descricao");
        $crud->setRelation("id_comerciante", "comerciantes", "nome");



        if ($state == "add" || $state == "insert_validation") {
            $crud->requiredFields(['codigo', 'codigo_f', 'n_macos']);
            $crud->setRule('n_macos', 'Nº Maços', 'validaSenhas[n_macos, codigo, codigo_f]');

            $crud->callbackAddField('n_macos', function ($fieldValue, $primaryKeyValue, $rowData) {
                return '<input id="field-n_macos" class="form-control" name="n_macos" type="numeric" value="1" readonly>';
            });
            $crud->callbackAddField('codigo_f', function ($fieldValue, $primaryKeyValue, $rowData) {
                return '<input id="field-codigo_f" class="form-control" name="codigo_f" type="numeric" value="">';
            });
        }

        if ($state == "edit" || $state == "update_validation") {
            $crud->requiredFields(['n_macos', 'id_comerciante']);
            $crud->setRule('n_macos', 'Nº Maços', 'validaSenhasEdit[n_macos, codigo, codigo_f]');

            $crud->callbackEditField('codigo', function ($fieldValue, $primaryKeyValue, $rowData) {
                return '<input id="field-codigo" class="form-control" name="codigo" type="text" value="' . $fieldValue . '" readonly>';
            });

            $crud->callbackEditField('n_macos', function ($fieldValue, $primaryKeyValue, $rowData) {
                return '<input id="field-n_macos" class="form-control" name="n_macos" type="numeric" value="1" readonly>';
            });

            $crud->callbackEditField('codigo_f', function ($fieldValue, $primaryKeyValue, $rowData) {
                return '<input id="field-codigo_f" class="form-control" name="codigo_f" type="numeric" value="">';
            });
        }



        $crud->callbackColumn('registado', function ($value, $row) {
            return $value == "1" ? "<span class='btn btn-success'>Sim</span>" : "<span class='btn btn-danger'>Não</span>";
        });


        $crud->callbackColumn('valor', function ($value, $row) {
            return $value!=null ? $value ."€": "";
        });        


        $crud->callbackBeforeInsert(function ($stateParameters) {
            $logModel = new LogModel();

            $nmacos = $stateParameters->data["n_macos"];
            $codigo = $stateParameters->data["codigo"];
            $codigo_f = $stateParameters->data["codigo_f"];

            $comerciante = $stateParameters->data["id_comerciante"] != "" ? $stateParameters->data["id_comerciante"] : null;

            $registos = new Registos();
            //insere as senhas todas (menos a primeira que é inserida com o gcrud normalmente)
            $registos->insereSenhas($codigo, $codigo_f, $comerciante);

            unset($stateParameters->data["n_macos"]);
            unset($stateParameters->data["codigo_f"]);

            // Add operation
            $logModel->insert_data(array(
                "created_by" => $this->session->get('user_id'),
                "type" => "senhas",
                "comment" => "inseriu " . $nmacos . " maços de senhas com o código inicial " . $codigo,
            ));
            return $stateParameters;
        });

        $crud->callbackBeforeUpdate(function ($stateParameters) {
            $logModel = new LogModel();

            $nmacos = $stateParameters->data["n_macos"];
            $codigo = $stateParameters->data["codigo"];
            $codigo_f = $stateParameters->data["codigo_f"];

            $comerciante = $stateParameters->data["id_comerciante"];

            $registos = new Registos();
            //atualiza os comerciantes nas senhas todas (menos a primeira que é atualizada com o gcrud normalmente)
            $registos->atualizaSenhas($codigo, $codigo_f, $comerciante);

            $comerciantes = new ComerciantesModel();
            $comerciante = $comerciantes->find($comerciante)["nome"];

            unset($stateParameters->data["n_macos"]);
            unset($stateParameters->data["codigo_f"]);

            // Add operation
            $logModel->insert_data(array(
                "created_by" => $this->session->get('user_id'),
                "type" => "senhas",
                "comment" => "atribuiu " . $nmacos . " maços de senhas com o código inicial " . $codigo . " ao comerciante " . $comerciante,
            ));
            return $stateParameters;
        });


        //search for fallback fields
        if (isset($_POST['search_field']) && $_POST['search_field'] != "") {
            $searchFields = $_POST['search_field'];
            $searchValues = $_POST['search_text'];

            $key = array_search('registado', $searchFields);

            if ($key !== false) {
                if (strpos($searchValues[$key], "Sim") !== false)
                    $searchValues[$key] = 1;
                else if (strpos($searchValues[$key], "Não") !== false)
                    $searchValues[$key] = 0;

                $_POST['search_text'] = $searchValues;
            }
        }

        $output = $crud->render();

        if ($state == "edit")
            $output->output = "<h4>Atribuir senhas a um comerciante!</h4>" . $output->output;


        if ($state == "list")
            $output->output = "<label class='label label-info'>".count($vouchers->findAll())."</label> senhas impressas!&nbsp;<label class='label label-info'>".count($vouchers->where('id_comerciante is not null')->findAll()) . "</label> senhas associadas a comerciantes!".$output->output;

        $output->nSenhasMaco = $nSenhasMaco;

        $output->ionAuth          = $this->ionAuth;
        $output->user          = $this->user;
        $output->title = "Senhas";
        $output->menu = 2;
        $output->submenu = 5;

        return $this->render('comerciantes/vouchers', $output);
    }


    public function listagem()
    {

        if (!$this->ionAuth->loggedIn())
            return redirect()->to('/')->withCookies();
        if (!$this->ionAuth->inGroup("comerciantes") && !$this->ionAuth->isAdmin())
            return redirect()->to('/dashboard')->withCookies();


        $crud = new GroceryCrud();
        //$crud->setRead(true);


        $crud->setTable('comerciantes');
        $crud->setSubject('Comerciantes');
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();
        $crud->defaultOrdering('nome', 'asc');

        $crud->requiredFields(['nome', 'morada', 'freguesia', 'setor', 'ativo']);
        $crud->columns(array('nome', 'morada', 'freguesia', 'contato', 'gps', 'ativo', 'setor', 'responsavel', 'vouchers'));


        $crud->fieldType("ativo", "true_false", array('Não', 'Sim'));
        $crud->callbackColumn('ativo', function ($value, $row) {
            if ($value == 0) {
                return "<label class='label label-danger'>Não</label>&nbsp;<span href='#' style='cursor:pointer' title='Ativar?' class='toggle_merchant' data-val='1' data-id=" . $row->id_comerciante . "><i class='fas fa-chevron-circle-up'></i></span>";
            } else
                return "<label class='label label-success'>Sim</label>&nbsp;<span title='Destivar?' style='cursor:pointer' class='toggle_merchant' data-val='0' data-id=" . $row->id_comerciante . "><i class='fas fa-chevron-circle-down'></i></span>";
        });

        $crud->callbackColumn('vouchers', function ($value, $row) {
            $comer = new ComerciantesModel();
            $vouchersAtribuidos = count($comer->getMerchantVouchers($row->id_comerciante));
            $vouchersUsados = count($comer->getUsedMerchantVouchers($row->id_comerciante));

            /*$vouchersDisponiveis = $vouchersAtribuidos - $vouchersUsados;
            if ($vouchersDisponiveis <  $vouchersAtribuidos / 10)
                $vouchersDisponiveis = "<label class='label label-danger'>" . $vouchersDisponiveis . "</label>";
            else
                $vouchersDisponiveis = "<label class='label label-success   '>" . $vouchersDisponiveis . "</label>";
                */


            if ($vouchersAtribuidos != 0)
                return $vouchersAtribuidos . "<br><a data-nome='" . $comer->find($row->id_comerciante)["nome"] . "' data-id=" . $row->id_comerciante . "  class='usedVouchers' href='#'>" . $vouchersUsados . "</a> (usados na plataforma)";
            else
                return "";
        });

        $crud->callbackColumn('contato', function ($value, $row) {
            return $value . "<br>" . $row->email;
        });

        $crud->callbackColumn('gps', function ($value, $row) {

            $html = "";
            $config = config('gmaps');


            if ($value !== null)
                $html .= "<a class='gmap-lightbox btn btn-sm btn-light btn-roundeded' href='#' data-src='https://www.google.com/maps/embed/v1/place?key=" . $config->apikey . "&q=" . $value . "&center=" . $value . "&zoom=18&maptype=satellite'><i class='fa fa-map-marker'></i> Ver mapa</a>";
            if (file_exists(FCPATH . "/images/aderentes/" . $row->id_comerciante . ".jpg"))
                $html .= "<br><a class='image-lightbox btn btn-sm btn-light btn-roundeded' href='#' data-src='" . base_url("images/aderentes/" . $row->id_comerciante . ".jpg") . "'><i class='fa fa-image'></i> Ver foto</a>";

            return $html;
        });



        if (isset($_POST['search_field']) && $_POST['search_field'] != "") {
            $searchFields = $_POST['search_field'];
            $searchValues = $_POST['search_text'];

            $key = array_search('ativo', $searchFields);
            if ($key !== false) {
                if (strpos($searchValues[$key], "Sim") !== false)
                    $searchValues[$key] = '1';
                else if (strpos($searchValues[$key], "Não") !== false)
                    $searchValues[$key] = '0';


                // $searchValues[$key] = '';
                $_POST['search_text'] = $searchValues;
            }
        }

        $crud->callbackAfterInsert(function ($stateParameters) {
            $logModel = new LogModel();
            // Add operation
            $logModel->insert_data(array(
                "created_by" => $this->session->get('user_id'),
                "type" => "comerciantes",
                "comment" => "inseriu comerciante com o nome " . $stateParameters->data["nome"],
            ));
            return $stateParameters;
        });

        $crud->callbackAfterUpdate(function ($stateParameters) {
            $logModel = new LogModel();
            // Add operation
            $logModel->insert_data(array(
                "created_by" => $this->session->get('user_id'),
                "type" => "comerciantes",
                "comment" => "atualizou comerciante com o nome " . $stateParameters->data["nome"] . ", Dados: " . implode(",", $stateParameters->data),
            ));
            return $stateParameters;
        });


        $output = $crud->render();

        $output->ionAuth          = $this->ionAuth;
        $output->user          = $this->user;
        $output->title = "Comerciantes";
        $output->menu = 2;
        $output->submenu = 2;

        return $this->render('comerciantes/listagem', $output);
    }


    public function pedidosAdesao()
    {

        if (!$this->ionAuth->loggedIn())
            return redirect()->to('/')->withCookies();
        if (!$this->ionAuth->inGroup("comerciantes") && !$this->ionAuth->isAdmin())
            return redirect()->to('/dashboard')->withCookies();


        $crud = new GroceryCrud();

        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->unsetDelete();
        $crud->unsetAdd();
        $crud->unsetEdit();

        //$crud->setRead(true);


        $crud->setTable('comerciantes_adesao');
        $crud->setSubject('Pedidos de Adesão de Comerciantes');
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();
        $crud->defaultOrdering('nome', 'asc');
        $crud->displayAs('created_at', 'Data de Registo');
        $crud->fieldType("confirmado", "true_false", array('Não', 'Sim'));

        $crud->callbackColumn('confirmado', function ($value, $row) {
            if ($value == 0) {
                return "<label class='label label-danger'>Não</label>&nbsp;<h4><a href='#' title='Colocar o comerciante na lista pública' class='label label-info confirm_merchant' data-id=" . $row->id_adesao . ">Tornar permanente?</a></h4>";
            } else
                return "<label class='label label-success'>Sim</label>";
        });
        $output = $crud->render();

        $output->ionAuth          = $this->ionAuth;
        $output->user          = $this->user;
        $output->title = "Pedidos de Adesão";
        $output->menu = 2;
        $output->submenu = 3;

        return $this->render('comerciantes/listagem', $output);
    }


    public function quizzes()
    {

        if (!$this->ionAuth->loggedIn())
            return redirect()->to('/')->withCookies();
        if (!$this->ionAuth->inGroup("comerciantes") && !$this->ionAuth->isAdmin())
            return redirect()->to('/dashboard')->withCookies();


        $crud = new GroceryCrud();

        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->unsetDelete();
        $crud->unsetEdit();
        $crud->unsetAdd();
        //$crud->setRead(true);


        $crud->setTable('quiz');
        $crud->setSubject('Recolha de dados estatísticos');

        $crud->displayAs('q1', 'Costuma fazer compras no concelho da Mealhada?');
        $crud->displayAs('q2', 'Gastos em compras de natal');
        $crud->displayAs('q3', 'Já visitou o concelho?');
        $crud->displayAs('q4', 'O que identifica melhor o Município?');
        $crud->displayAs('q5', 'Concelho Residência');


        /*   $crud->callbackColumn('q1', function ($value, $row) {
            return $value == "true" ? "Sim" : "Não";
        });
        $crud->callbackColumn('q3', function ($value, $row) {
            return $value == "true" ? "Sim" : "Não";
        });*/

        $output = $crud->render();

        $output->ionAuth          = $this->ionAuth;
        $output->user          = $this->user;
        $output->title = "Quizzes Clientes";
        $output->menu = 2;
        $output->submenu = 6;

        return $this->render('comerciantes/listagem', $output);
    }



    public function  confirmMerchant()
    {
        $request = \Config\Services::request();
        $userModel = new ComerciantesModel();

        $logModel = new LogModel();
        // Add operation
        $logModel->insert_data(array(
            "created_by" => $this->session->get('user_id'),
            "type" => "comerciantes",
            "comment" => "Confirmou pedido de adesão com o id " . $request->getVar('id'),
        ));

        echo json_encode($userModel->confirmMerchant($request->getVar('id')));
    }


    public function  toggleMerchant()
    {
        $request = \Config\Services::request();
        $userModel = new ComerciantesModel();

        $logModel = new LogModel();
        // Add operation
        $logModel->insert_data(array(
            "created_by" => $this->session->get('user_id'),
            "type" => "comerciantes",
            "comment" => "Alterou estado do comerciante " . $request->getVar('id') . ", valor: " . $request->getVar('val'),
        ));

        echo json_encode($userModel->toggleMerchant($request->getVar('id'), $request->getVar('val')));
    }


    private function render($view = 'default', $output = null)
    {
        return view($view, (array)$output);
    }

    public function getUsedMerchantVouchersClients()
    {
        if ($this->ionAuth->isAdmin()) {

            $request = \Config\Services::request();
            $comer = new ComerciantesModel();
            echo $comer->getUsedMerchantVouchersClients($request->getVar("id"));
        }
    }
    public function exportMerchants()
    {

        $comerciantesModel = new ComerciantesModel();
        $comerciantes = $comerciantesModel->where('ativo', 1)->orderBy('nome', 'asc')->findAll();

        $path = "assets/uploads/";
        $files = array();

        foreach ($comerciantes as $comer) {

            $fields = array(
                'designacao'    => $comer["nome"],
                'responsavel' => $comer["responsavel"],
                'morada' => $comer["morada"],
                'cp' => '',
                'localidade' => $comer["freguesia"],
                'contatos' => $comer["contato"],
                'email' => $comer["email"],
            );

            $pdf = new Pdf($path . 'Imp-Tomb-A01-Freg.pdf');
            $pdf->fillForm($fields)->flatten()->needAppearances()->saveAs($path . "tombola_23_" . $comer["id_comerciante"] . ".pdf");
            $files[] = $path . "tombola_22_" . $comer["id_comerciante"] . ".pdf";
        }

        //concatenar
        $fpdi = new Fpdi();

        foreach ($files as $file) {
            $fpdi->setSourceFile($file);
            $pageId = $fpdi->ImportPage(1);
            $s = $fpdi->getTemplatesize($pageId);
            $fpdi->AddPage($s['orientation'], $s);
            $fpdi->useTemplate($pageId);
        }

        $fpdi->Output("D", "Tombola_2023_comerciantes.pdf");

        foreach ($files as $file) {
            if (!is_dir($file))
                unset($file);
        }
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
