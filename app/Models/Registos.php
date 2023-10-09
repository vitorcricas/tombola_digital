<?php

namespace App\Models;

use CodeIgniter\Model;

class Registos extends Model
{
    //https://codeigniter4.github.io/CodeIgniter4/models/model.html#in-model-validation
    protected $DBGroup              = 'default';
    protected $table                = 'registos';
    protected $primaryKey           = 'id_registo';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDelete        = false;
    protected $protectFields        = true;
    protected $allowedFields        = ["id_voucher", "data"];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'data';

    // Validation

    protected $validationRules = [];

    protected $validationMessages = [];


    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];


    protected $beforeInsert = [];


    public function getVoucher($cupao)
    {
        $query = $this->db->query('select id_voucher from vouchers where codigo=\'' . $cupao . '\'');

        $row = $query->getRow();

        if ($row->id_voucher != "") {
            $query = $this->db->query('select id_voucher from registos where id_voucher=' . $row->id_voucher);
            if ($query->getNumRows()) //já foi registado
                return "-1";
        }

        return $row->id_voucher;
    }


    public function verificaSenhas($codigoI, $codigoF)
    {
        //$query = $this->db->query('SELECT * FROM vouchers WHERE codigo BETWEEN ' . $codigoI . ' AND ' . ($codigoI - 1) . '+(SELECT nsenhas_maco*' . $nMacos . ' FROM definicoes)');
        $query = $this->db->query('SELECT * FROM vouchers WHERE codigo BETWEEN ' . $codigoI . ' AND ' . $codigoF);
        return $query->getNumRows();
    }

    public function verificaSenhasEdit($codigoI, $codigoF)
    {
        //$nsenhas = $this->getNSenhasMaco();
        //$final = $codigoI + ($nsenhas * $nMacos);
        //$dif = $final - $codigoI;
        $dif = $codigoF - $codigoI + 1;        

        //$query = $this->db->query('SELECT count(*) as num FROM vouchers WHERE codigo BETWEEN ' . $codigoI . ' AND ' . ($codigoI - 1) . '+(SELECT nsenhas_maco*' . $nMacos . ' FROM definicoes)');
        $query = $this->db->query('SELECT count(*) as num FROM vouchers WHERE codigo BETWEEN ' . $codigoI . ' AND ' . $codigoF);

        $row = $query->getRow();

        return $row->num == $dif;
    }

    public function getNSenhasMaco()
    {
        $query = $this->db->query('SELECT nsenhas_maco  FROM definicoes');
        $row = $query->getRow();
        return $row->nsenhas_maco;
    }

    public function insereSenhas(int $codigo, int $codigo_f, $id_comerciante)
    {
        $builder = $this->db->table('vouchers');

        //$nsenhas = $this->getNSenhasMaco();
        $data = [];

        //ativa comerciante
        $query = $this->db->query('update comerciantes set ativo=1 where id_comerciante=' . $id_comerciante);

        //for ($i = $codigo + 1; $i < $codigo + ($nsenhas * $nMacos); $i++)
        for ($i = $codigo + 1; $i <= $codigo_f; $i++)
            $data[] = ["codigo" => $i, "id_comerciante" =>  $id_comerciante];

        $builder->insertBatch($data);
    }

    public function atualizaSenhas(int $codigo, int $codigo_f, $id_comerciante)
    {
        $nsenhas = $this->getNSenhasMaco();
        //$final = $codigo + ($nsenhas * $nMacos) - 1;
        $final = $codigo_f;

        $query = $this->db->query('update vouchers set id_comerciante=' . $id_comerciante . ' where codigo between ' . $codigo . ' and ' . $final);

        //ativa comerciante
        $query = $this->db->query('update comerciantes set ativo=1 where id_comerciante=' . $id_comerciante);

    }
}
