<?php

class UsuarioAuth {

    private ?int $id;
    private ?Usuario $usuario;
    private ?string $provider;
    private ?string $provider_id;
    private ?string $senha;

    

    public function __construct()
    {
        $this->id = null;
        $this->usuario = null;
        $this->provider = null;
        $this->provider_id = null;
        $this->senha = null;
    }
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of usuario
     */ 
    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     *
     * @return  self
     */ 
    public function setUsuario(?Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of provider
     */ 
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set the value of provider
     *
     * @return  self
     */ 
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get the value of provider_id
     */ 
    public function getProvider_id()
    {
        return $this->provider_id;
    }

    /**
     * Set the value of provider_id
     *
     * @return  self
     */ 
    public function setProvider_id($provider_id)
    {
        $this->provider_id = $provider_id;

        return $this;
    }

    /**
     * Get the value of senha
     */ 
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     *
     * @return  self
     */ 
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }
}