<?php
    
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/UsuarioAuth.php");
require_once(__DIR__ . "/../dao/CandidatoDAO.php");

class CandidatoService {

    private CandidatoDAO $candidatoDAO;

    public function __construct() {
        $this->candidatoDAO = new CandidatoDAO();
  
    }

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Candidato $candidato) {
        $erros = array();
    
        // Validar campos obrigatórios
    
        if (! $candidato->getNomeCompleto())
            array_push($erros, "O campo [Nome Completo] é obrigatório.");
    
    
        if (! $candidato->getCpf())
            array_push($erros, "O campo [CPF] é obrigatório.");
    
    
        if (! $candidato->getDataNascimento())
            array_push($erros, "O campo [Data de nascimeto] é obrigatório.");
    
       
        return $erros;
    }



    public function validarCPF(string $cpf): bool {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
        // Verifica se tem 11 dígitos ou se é uma sequência repetida (ex: 11111111111)
        if (strlen($cpf) != 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }
    
        // Calcula e verifica o primeiro dígito verificador
        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += $cpf[$i] * (($t + 1) - $i);
            }
    
            $digito = (10 * $soma) % 11;
            $digito = $digito == 10 ? 0 : $digito;
    
            if ($cpf[$t] != $digito) {
                return false;
            }
        }
    
        return true;
    }
    
    
}
