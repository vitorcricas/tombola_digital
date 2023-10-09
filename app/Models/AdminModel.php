<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'definicoes';
    protected $primaryKey           = 'id_definicao';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDelete        = false;
    protected $protectFields        = true;
    protected $allowedFields        = ["adesao_dataI", "adesao_dataF", "registo_dataI", "registo_dataF", "user_registration"];

    // Dates
    protected $useTimestamps        = false;
    protected $createdField         = '';

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }

    public function insert_data($data = array())
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

    public function update_data($id, $data = array())
    {
        $this->db->table($this->table)->update($data, array(
            "id" => $id,
        ));
        return $this->db->affectedRows();
    }

    public function delete_data($id)
    {
        return $this->db->table($this->table)->delete(array(
            "id" => $id,
        ));
    }

    public function get_all_data()
    {
        $query = $this->db->query('select * from ' . $this->table);
        return $query->getResult();
    }


    public function getDrawInfo($id_sorteio)
    {
        $query = $this->db->query('select s.descricao, d.* from definicoes d, sorteios s where s.id_sorteio=d.id_sorteio and s.id_sorteio=' . $id_sorteio);
        return $query->getRow();
    }

    public function hasQuiz($id_user)
    {
        $query = $this->db->query('select * from users where id=' . $id_user . ' and hasQuiz!=0');
        return $query->getNumRows() > 0;
    }


    public function getConcelhos()
    {
        $query = $this->db->query('SELECT * FROM concelhos_metadata order BY dicofre, designacao');
        $row = $query->getResultArray();
        return $row;
    }

    public function saveQuiz($id)
    {

        $this->db->query('update users set hasQuiz=-1 where id=' . $id);
        $response = [
            'success' => '1'
        ];

        return $response;
    }

    function getEstatisticas()
    {

        $this->db->query("SET lc_time_names = 'pt_PT'");

        $query = $this->db->query("SELECT r.id_registo as voucher, date(r.data) as dia, WEEK(r.data,3) as Semana, MONTHNAME(r.data) as mês, year(r.data) as ano, v.codigo, coalesce(c.nome,'Comerciante não atribuído') as Comerciante, coalesce(c.freguesia,'Comerciante não atribuído') as freguesia , coalesce(c.setor,'Comerciante não atribuído') as setor  FROM registos r, vouchers v LEFT join comerciantes c ON  v.id_comerciante=c.id_comerciante   WHERE r.id_voucher=v.id_voucher ");

        return json_encode($query->getResultArray());
    }

    function getEstatisticasQuiz()
    {

        $this->db->query("SET lc_time_names = 'pt_PT'");

        $query = $this->db->query("SELECT id_quiz as resposta, q1 as 'Costuma fazer compras no concelho da Mealhada?',q2 as 'Gastos em compras de natal', q3 as  'Já visitou o concelho', q4 as  'O que identifica melhor o Município?', q5 as  'Concelho Residência' from quiz");

        return json_encode($query->getResultArray());
    }


    function getCupoesSorteio()
    {
        $query = $this->db->query("SELECT v.id_voucher, v.codigo, u.first_name AS cliente, coalesce(c.nome,'N/D') AS nome FROM registos r, users u, vouchers v LEFT join comerciantes c on v.id_comerciante=c.id_comerciante WHERE v.registado=1  AND v.id_voucher=r.id_voucher AND r.id_utilizador=u.id   AND v.id_sorteio IS null  ORDER BY RAND()");

        return $query->getResultArray();
    }

    function getPremios($id_sorteio)
    {
        $query = $this->db->query("SELECT premios from definicoes where id_sorteio=?", array($id_sorteio));

        return $query->getRow()->premios;
    }

    function getPremiosAtribuidos($id_sorteio)
    {
        $query = $this->db->query("SELECT id_voucher, valor FROM vouchers WHERE id_sorteio=1");

        return $query->getResultArray();
    }

    function saveWinner($winnerData)
    {
        $this->db->query('update vouchers set valor=?, id_sorteio=? where id_voucher=?', array($winnerData["valor"], $winnerData["id_sorteio"], $winnerData["id_voucher"]));
        $response = [
            'success' => '1'
        ];

        return $response;
    }

    function getDadosPremiado($id_voucher)
    {
        $query = $this->db->query("SELECT u.first_name, u.email, u.telefone from registos r, vouchers v, users u where v.id_voucher=? and v.id_voucher=r.id_voucher and r.id_utilizador=u.id", array($id_voucher));
        $dados = $query->getRow();
        return $dados->first_name."<br>".$dados->email."<br>".$dados->telefone;
    }   
    
    
    function getListaPremios($id_sorteio)
    {
        $query = $this->db->query("SELECT coalesce(c.nome,'N/D') as nome, c.freguesia, v.codigo, v.valor FROM vouchers v left join comerciantes c on v.id_comerciante=c.id_comerciante WHERE v.id_sorteio=".$id_sorteio."  ORDER BY valor desc");
        return $query->getResultArray();

    }        
}
