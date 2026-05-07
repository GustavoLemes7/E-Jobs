<?php
require_once(__DIR__ . "/Cidade.php");


class Usuario
{
    private ?int $id;
    private ?string $email;
    private ?string $status;
    private ?string $telefone;
    private ?string $dataCriacao;
    private ?string $tipoUsuario;

   public function __construct()
   {
    $this->id = null;
    $this->email = null;
    $this->status = null;
    $this->telefone = null;
    $this->tipoUsuario = null;
   }

    /**
     * Get the value of id
     */ 
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(?int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail(?string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus(?string $status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * Get the value of telefone
     */ 
    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    /**
     * Set the value of telefone
     *
     * @return  self
     */ 
    public function setTelefone(?string $telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get the value of dataCriacao
     */ 
    public function getDataCriacao() : ?string
    {
        return $this->dataCriacao;
    }

    /**
     * Set the value of dataCriacao
     *
     * @return  self
     */ 
    public function setDataCriacao(?string $dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get the value of tipoUsuario
     */ 
    public function getTipoUsuario(): ?string
    {
        return $this->tipoUsuario;
    }

    /**
     * Set the value of tipoUsuario
     *
     * @return  self
     */ 
    public function setTipoUsuario(?string $tipoUsuario)
    {
        $this->tipoUsuario = $tipoUsuario;

        return $this;
    }

}
