<?php
require_once(__DIR__ . "/../model/Empresa.php");
require_once(__DIR__ . "/../dao/EmpresaDAO.php");

class EmpresaService{

    private EmpresaDAO $empresaDAO;

    public function __construct()
    {
         $this->empresaDAO = new EmpresaDAO();
    }

    public function validarDados(Empresa $empresa) {
        $erros = array();
    
        // Validar campos obrigatórios
    
        if (! $empresa->getNomeFantasia())
            array_push($erros, "O campo [Nome Fantasia] é obrigatório.");
    
        if (! $empresa->getRazaoSocial())
            array_push($erros, "O campo [Razão Social] é obrigatório.");
    
        if (! $empresa->getCnpj())
            array_push($erros, "O campo [CNPJ] é obrigatório.");
    
    
        if (! $empresa->getInscricaoEstadual())
            array_push($erros, "O campo [Inscrição Estadual] é obrigatório.");
    
        // Validar se a senha é igual à confirmação
        if (! $empresa->getDescricao())
            array_push($erros, "O campo [Descrição] é obrigatório ");
    
        return $erros;
    }

    public function validarCNPJ(string $documento){
        $erros = array();
        $usuario = $this->empresaDAO->findByCNPJ($documento);
        if($usuario != null)
            array_push($erros, "Já existe um usuário utilizando esse documento");
          
        return $erros;
    }

   public function isCnpjValido(string $cnpj): bool
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14) return false;
        if (preg_match('/(\d)\1{13}/', $cnpj)) return false;

        $soma = 0;
        $peso = 5;

        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $peso;
            $peso = ($peso == 2) ? 9 : $peso - 1;
        }

        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cnpj[12] != $digito1) return false;

        $soma = 0;
        $peso = 6;

        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $peso;
            $peso = ($peso == 2) ? 9 : $peso - 1;
        }

        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        return $cnpj[13] == $digito2;
    }
}