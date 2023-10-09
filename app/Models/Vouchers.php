<?php

namespace App\Models;

use CodeIgniter\Model;

class Vouchers extends Model
{
    //https://codeigniter4.github.io/CodeIgniter4/models/model.html#in-model-validation
    protected $DBGroup              = 'default';
    protected $table                = 'vouchers';
    protected $primaryKey           = 'id_voucher';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDelete        = false;
    protected $protectFields        = true;
    protected $allowedFields        = ["id_comerciante", "id_sorteio","codigo","valor"];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';

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


    public function updateRegistados()
    {
      //  $query = $this->db->query('select id_voucher from registos where id_voucher='.$id_voucher);
      $query = $this->db->query('update vouchers set registado=1 where id_voucher in (select id_voucher from registos) and registado=0');
    }    
}
