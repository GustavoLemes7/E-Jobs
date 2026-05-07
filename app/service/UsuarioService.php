<?php
    
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/UsuarioAuth.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");

class UsuarioService {

    private UsuarioDAO $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
  
    }

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(UsuarioAuth $usuarioAuth, ?string $confSenha) {
        $erros = array();
    
        // Validar campos obrigatórios
    
        if (! $usuarioAuth->getUsuario()->getEmail())
            array_push($erros, "O campo [Email] é obrigatório.");
    
        if (! $usuarioAuth->getSenha())
            array_push($erros, "O campo [Senha] é obrigatório.");
    
        if (! $confSenha)
            array_push($erros, "O campo [Confirmação da senha] é obrigatório.");
    
    
        if (! $usuarioAuth->getUsuario()->getTelefone())
            array_push($erros, "O campo [Telefone] é obrigatório.");
    
        // Validar se a senha é igual à confirmação
        if ($usuarioAuth->getSenha() && $confSenha && $usuarioAuth->getSenha() != $confSenha)
            array_push($erros, "O campo [Senha] deve ser igual ao [Confirmação da senha].");
    
        return $erros;
    }

    // RN 01 - Cada usuário deve possuir um e-mail único para cadastro.
    public function validarEmail(string $email) {
        $erros = array();
        $usuario = $this->usuarioDAO->findByEmail($email);
        if($usuario != null)
            array_push($erros, "Já existe um usuário utilizando esse email");
          
        return $erros; 
    }

    public function validarSenha(string $senha){
        $erros = array();
        if(strlen($senha) < 8){
            array_push($erros, "Tamanho mínimo 8 caracteres");
        }
        if(ctype_alnum($senha)){
            array_push($erros, "1 caractere especial" );
        }

        if(!preg_match('/[a-z]/', $senha)){
            array_push($erros, "1 caractere mínusculo");
        }

        if(!preg_match('/[A-Z]/', $senha)){
            array_push($erros, "1 caractere maiúsculo");
        }

        if(!preg_match('/[0-9]/', $senha)){
            array_push($erros, "1 número");
        }

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
