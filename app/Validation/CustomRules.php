<?php

namespace App\Validation;

use App\Models\Registos;


class CustomRules
{

    // Rule is to validate mobile number digits
    public function mobileValidation(string $str, string $fields, array $data)
    {

        /*Checking: Number must start from 5-9{Rest Numbers}*/
        if (preg_match('/^[5-9]{1}[0-9]+/', $data['mobile'])) {

            /*Checking: Mobile number must be of 10 digits*/
            $bool = preg_match('/^[0-9]{10}+$/', $data['mobile']);
            return $bool == 0 ? false : true;
        } else {

            return false;
        }
    }

    public function validaVoucher(string $str, string $fields, array $data, string &$error = null): bool
    {
        if ($data["id_voucher"] == "") {
            $error = "Nº de Senha obrigatória";
            return false;
        } else {
            $registosModel = new Registos();

            if ($registosModel->getVoucher($data["id_voucher"]) == "") {
                $error = "Senha inexistente";
                return false;
            }
            if ($registosModel->getVoucher($data["id_voucher"]) == "-1") {
                $error = "Senha já foi registada";
                return false;
            }
        }
        return true;
    }


    public function validaSenhas(string $str, string $fields, array $data, string &$error = null): bool
    {
        if ($data["n_macos"] == "" || !is_numeric($data["n_macos"])) {
            $error = "Número de maços tem de ser um número!";
            return false;
        } else {
            if (intval($data["n_macos"]) >= 10) {
                $error = "Número máximo de maços é 10 de uma vez!";
                return false;
            }
            if ($data["codigo"] != "") {
                $registosModel = new Registos();
                //if ($registosModel->verificaSenhas($data["codigo"], $data["n_macos"]) > 0) {
                //    $error = "Já foram criadas senhas entre " . $data["codigo"] . " e " . (intval($data["codigo"]) + (intval($data["n_macos"]) * intval($registosModel->getNSenhasMaco())));
                if ($registosModel->verificaSenhas($data["codigo"], $data["codigo_f"]) > 0) {
                    $error = "Já foram criadas senhas entre " . $data["codigo"] . " e " . $data["codigo_f"];
                    return false;
                }
            }
        }

        return true;
    }

    //as senhas a atribuir a comerciantes devem existir!
    public function validaSenhasEdit(string $str, string $fields, array $data, string &$error = null): bool
    {
        if ($data["n_macos"] == "" || !is_numeric($data["n_macos"])) {
            $error = "Número de maços tem de ser um número!";
            return false;
        } else {
            $registosModel = new Registos();
            //if ($registosModel->verificaSenhasEdit($data["codigo"], $data["n_macos"]) != 1) {
            //   $error = "Algumas das senhas que quer atribuir não existem! (entre " . $data["codigo"] . " e " . (intval($data["codigo"]) + (intval($data["n_macos"]) * intval($registosModel->getNSenhasMaco())).")");
            if ($registosModel->verificaSenhasEdit($data["codigo"], $data["codigo_f"]) != 1) {
                $error = "Algumas das senhas que quer atribuir não existem! (entre " . $data["codigo"] . " e " . $data["codigo_f"];
                return false;
            }
        }

        return true;
    }


    public function validaNIF(string $str, string $fields, array $data, string &$error = null): bool
    {

        //Limpamos eventuais espaços a mais
        $nif = trim($str);
        //Verificamos se é numérico e tem comprimento 9
        if (!is_numeric($nif) || strlen($nif) != 9) {
            $error = lang('Validation.incorrect_nif');
            return false;
        } else {
            $nifSplit = str_split($nif);
            //O primeiro digíto tem de ser 1, 2, 3, 5, 6, 8 ou 9
            //Ou não, se optarmos por ignorar esta "regra"
            if (
                in_array($nifSplit[0], array(1, 2, 3, 5, 6, 8, 9))
            ) {
                //Calculamos o dígito de controlo
                $checkDigit = 0;
                for ($i = 0; $i < 8; $i++) {
                    $checkDigit += $nifSplit[$i] * (10 - $i - 1);
                }
                $checkDigit = 11 - ($checkDigit % 11);
                //Se der 10 então o dígito de controlo tem de ser 0
                if ($checkDigit >= 10) $checkDigit = 0;
                //Comparamos com o último dígito
                if ($checkDigit == $nifSplit[8]) {
                    return true;
                } else {
                    $error = lang('Validation.incorrect_nif');
                    return false;
                }
            } else {
                $error = lang('Validation.incorrect_nif');
                return false;
            }
        }
    }
}
