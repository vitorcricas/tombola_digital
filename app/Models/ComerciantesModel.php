<?php

namespace App\Models;

use CodeIgniter\Model;


class ComerciantesModel extends Model
{
    protected $DBGroup = 'default';

    protected $table = 'comerciantes';
    protected $primaryKey = 'id_comerciante';
    //   protected $allowedFields = ['id_emissao','local','freguesia'];

    //https://codeigniter4.github.io/userguide/models/model.html

    //todo
    //não é em tempo real visto que só depois do cliente registar a senha é que ele deixar de estar disponível no comerciante! será o comerciante a registar que deu a senha x??
    //o ideal será o comerciante registar os cupoues que entrega (só o código do cupao!!) so mostra os cupoes dele...e nao identifica cliente. 
    public function getDisponibilidade($id_comerciante)
    {
        $query = $this->db->query('SELECT COUNT(id_voucher) AS num FROM vouchers WHERE id_comerciante=' . $id_comerciante . ' AND id_voucher NOT IN (SELECT id_voucher FROM registos)');

        $row = $query->getResult()[0];
        return $row->num;
    }


    public function getAreas()
    {
        $query = $this->db->query('SELECT distinct(setor) as "atividade" from comerciantes WHERE setor is not null and ativo=1 order by setor');

        $row = $query->getResultArray();
        return $row;
    }

    public function getFreguesias()
    {
        $query = $this->db->query('SELECT distinct(freguesia) from comerciantes WHERE ativo=1');

        $row = $query->getResultArray();
        return $row;
    }


    public function getMerchantVouchers($id_comerciante)
    {
        $query = $this->db->query('SELECT codigo FROM vouchers where id_comerciante='.$id_comerciante.' ORDER BY codigo');

        $row = $query->getResultArray();
        return $row;
    }


    

    public function getUsedMerchantVouchers($id_comerciante)
    {
        $query = $this->db->query('SELECT codigo FROM registos r, vouchers v where r.id_voucher=v.id_voucher and v.id_comerciante='.$id_comerciante.' ORDER BY codigo');

        $row = $query->getResultArray();
        return $row;
    }


    public function getUsedMerchantVouchersClients($id_comerciante)
    {
        $query = $this->db->query('SELECT u.first_name, v.codigo, r.`data` FROM vouchers v, registos r, users u WHERE v.id_comerciante='.$id_comerciante.'  AND v.id_voucher=r.id_voucher AND r.id_utilizador=u.id ORDER BY data');

        $row = $query->getResultArray();
        $result = "";

        foreach ($row as $voucher){
            $result.= "<b>Cliente: </b>".$voucher["first_name"];
            $result.= " | <b>Codigo: </b>".$voucher["codigo"];
            $result.= " | <b>Data: </b>".$voucher["data"]."<br>";            
        }

        return $result;
    }


    public function getCP($cp4, $cp3)
    {

        $query = $this->db->query('SELECT localidade FROM cpostais WHERE cp4=' . $cp4 . ' and cp3=' . $cp3);

        $row = $query->getRow();
        return $row->localidade;
    }

    public function confirmMerchant($id)
    {
        //$query = $this->db->query('update comerciantes_adesao set confirmado=1 where id_adesao⁼'.$id);

        $db      = \Config\Database::connect();
        $builder = $this->db->table('comerciantes_adesao');
        $builder->set('confirmado', '1');
        $builder->where('id_adesao', $id);
        $builder->update();

        $query = $this->db->query('insert into comerciantes (nome, morada, contato, email) select nome, morada, contato, email from comerciantes_adesao where id_adesao=' . $id);

        $response = [
            'success' => $query
        ];

        return $response;
    }

    public function toggleMerchant($id, $val)
    {
        //$query = $this->db->query('update comerciantes_adesao set confirmado=1 where id_adesao⁼'.$id);

        $db      = \Config\Database::connect();
        $builder = $this->db->table('comerciantes');
        $builder->set('ativo', $val);
        $builder->where('id_comerciante', $id);
        $result = $builder->update();

        $response = [
            'success' => $result
        ];

        return $response;
    }    
}
