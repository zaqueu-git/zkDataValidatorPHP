<?php
namespace zkDataValidatorPHP;

class zkDataValidatorPHP
{
    /**
     * Verifica se o RG é válido.
     * @param string $value - O valor do RG a ser verificado.
     * @return boolean true se o RG for válido, false caso contrário.
     */
    public static function rg($value) {
        $rg = $value;
        $rg = str_replace('.', '', $rg);
        $rg = str_replace('-', '', $rg);

        if (preg_match('/^(?=.*\d)[A-Za-z0-9]{7,11}$/', $rg)) {
            return true;
        }
        return false;
    }
    /**
     * Verifica se o número de telefone é válido.
     * @param string $value - O número de telefone a ser verificado.
     * @return boolean true se o número de telefone for válido, false caso contrário.
     */
    public static function phone($value) {
        if (preg_match('/^\(?[1-9]{2}\)? ?(?:[2-8]|9[1-9])[0-9]{3}\-?[0-9]{4}$/', $value)) {
            return true;
        }
        return false;
    }
    /**
     * Verifica se a senha é forte.
     * @param string $value - A senha a ser verificada.
     * @return boolean true se a senha for forte, false caso contrário.
     */
    public static function password($value) {
        $res = [];

        $res[0] = preg_match('/^[a-zA-Z0-9@#._-]+$/', $value);
        $res[1] = preg_match('/[a-zA-Z]+/', $value);
        $res[2] = preg_match('/[0-9]+/', $value);
        $res[3] = preg_match('/[A-Z]+/', $value);
        $res[4] = preg_match('/[@#._-]+/', $value);

        $res = array_filter($res, function ($e) {
            return $e == false;
        });

        if (count($res) == 0) {
            return true;
        }

        return false;
    }
    /**
     * Verifica se o nome completo é válido.
     * @param string $value - O nome completo a ser verificado.
     * @return boolean true se o nome completo for válido, false caso contrário.
     */
    public static function fullName($value) {
        $pattern = '/^[a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{3,} ([a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+){2,}$/';
        if (preg_match($pattern, $value)) {
            return true;
        }
        return false;
    }
    /**
     * Verifica se a data é válida.
     * @param string $value - A data no formato "YYYY-MM-DD" a ser verificada.
     * @return boolean true se a data for válida, false caso contrário.
     */
    public static function dateValid($value) {
        $array = explode("-", $value);

        $year = $array[0];
        $month = $array[1];
        $day = $array[2];

        if (checkdate($month, $day, $year)) {
            return true;
        }
        return false;
    }
    /**
     * Verifica se o e-mail é válido.
     * @param string $value - O e-mail a ser verificado.
     * @return boolean true se o e-mail for válido, false caso contrário.
     */
    public static function email($value) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    /**
     * Verifica se o CPF é válido.
     * @param string $value - O CPF a ser verificado.
     * @return boolean true se o CPF for válido, false caso contrário.
     */
    public static function cpf($value) {
        $cpf = $value;
        $cpf = str_replace(['.', '-'], '', $cpf);

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($i = 0, $v1 = 0, $p = 10; $i < 9; $i++, $p--) {
            $v1 += $cpf[$i] * $p;
        }
        
        $v1 = ($v1 * 10) % 11;
        
        if ($v1 == 10) {
            $v1 = 0;
        }
        
        if ($v1 != $cpf[9]) {
            return false;
        }

        for ($i = 0, $v2 = 0, $p = 11; $i < 10; $i++, $p--) {
            $v2 += $cpf[$i] * $p;
        }
        
        $v2 = ($v2 * 10) % 11;
        
        if ($v2 == 10) {
            $v2 = 0;
        }

        if ($v2 != $cpf[10]) {
            return false;
        }

        return true;
    }
    /**
     * Verifica se o CNPJ é válido.
     * @param string $value - O CNPJ a ser verificado.
     * @return boolean true se o CNPJ for válido, false caso contrário.
     */
    public static function cnpj($value) {
        $cnpj = $value;
        $cnpj = str_replace(['.', '-', '/'], '', $cnpj);

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        for ($i = 0, $v1 = 0, $p1 = 5, $p2 = 13; $i < 12; $i++, $p1--, $p2--) {
            if ($p1 >= 2) {
                $v1 += $cnpj[$i] * $p1;
            } else {
                $v1 += $cnpj[$i] * $p2;
            }
        }

        $v1 = $v1 % 11;
        
        if ($v1 < 2) {
            $v1 = 0;
        } else {
            $v1 = 11 - $v1;
        }
        
        if ($v1 != $cnpj[12]) {
            return false;
        }

        for ($i = 0, $v2 = 0, $p1 = 6, $p2 = 14; $i < 13; $i++, $p1--, $p2--) {
            if ($p1 >= 2) {
                $v2 += $cnpj[$i] * $p1;
            } else {
                $v2 += $cnpj[$i] * $p2;
            }
        }

        $v2 = $v2 % 11;
        
        if ($v2 < 2) {
            $v2 = 0;
        } else {
            $v2 = 11 - $v2;
        }
        
        if ($v2 != $cnpj[13]) {
            return false;
        }

        return true;
    }
    /**
     * Verifica se o CEP é válido.
     * @param string $value - O CEP a ser verificado.
     * @return boolean true se o CEP for válido, false caso contrário.
     */
    public static function cep($value) {
        if (preg_match('/^[0-9]{5}-[0-9]{3}$/', $value)) {
            return true;
        }
        return false;
    }  
}

$class = new zkDataValidatorPHP();

echo $class::cep('88108-167') ? 'CEP: Válido' : 'CEP: Inválido';
echo ", ";
echo $class::cnpj('62.193.755/0001-07') ? 'CNPJ: Válido' : 'CNPJ: Inválido';
echo ", ";
echo $class::cpf('335.516.700-21') ? 'CPF: Válido' : 'CPF: Inválido';
echo ", ";
echo $class::dateValid('2002-10-03') ? 'Data: Válida' : 'Data: Inválida';
echo ", ";
echo $class::email('teste@teste.com') ? 'E-mail: Válido' : 'E-mail: Inválido';
echo ", ";
echo $class::fullName('Nome de teste') ? 'Nome Completo: Válido' : 'Nome Completo: Inválido';
echo ", ";
echo $class::password('86A489m@') ? 'Senha: Válida' : 'Senha: Inválida';
echo ", ";
echo $class::phone('(48) 2775-8157') ? 'Telefone: Válido' : 'Telefone: Inválido';
echo ", ";
echo $class::rg('136671949') ? 'RG: Válido' : 'RG: Inválido';
echo "\n";