<?php

class TipoUsuario {

    public const CANDIDATO = "CANDIDATO";
    public const ADMINISTRADOR = "ADMINISTRADOR";
    public const EMPRESA = "EMPRESA";

    private ?int $id;
    private ?string $nome;

    public static function getAllAsArray() {
        return [TipoUsuario::CANDIDATO, TipoUsuario::EMPRESA, TipoUsuario::ADMINISTRADOR];
    }

     public static function getEmpresaCandidatoAsArray() {
        return [TipoUsuario::CANDIDATO, TipoUsuario::EMPRESA];
    }
    
    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome(): ?string
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome(?string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }
}