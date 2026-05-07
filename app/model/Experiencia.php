<?php

class Experiencia{
    private ?int $id;
    private ?int $candidato_id;
    private ?string $cargo;
    private ?string $empresa;
    private ?string $data_inicio;
    private ?string $data_fim;
    private ?string $descricao;   

    /**
     * Get the value of candidato_id
     */ 
    public function getCandidato_id()
    {
        return $this->candidato_id;
    }

    /**
     * Set the value of candidato_id
     *
     * @return  self
     */ 
    public function setCandidato_id($candidato_id)
    {
        $this->candidato_id = $candidato_id;

        return $this;
    }

    /**
     * Get the value of cargo
     */ 
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set the value of cargo
     *
     * @return  self
     */ 
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get the value of empresa
     */ 
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set the value of empresa
     *
     * @return  self
     */ 
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get the value of data_inicio
     */ 
    public function getDataInicio()
    {
        return $this->data_inicio;
    }

    /**
     * Set the value of data_inicio
     *
     * @return  self
     */ 
    public function setDataInicio($data_inicio)
    {
        $this->data_inicio = $data_inicio;

        return $this;
    }

    /**
     * Get the value of data_fim
     */ 
    public function getDataFim()
    {
        return $this->data_fim;
    }

    /**
     * Set the value of data_fim
     *
     * @return  self
     */ 
    public function setDataFim($data_fim)
    {
        $this->data_fim = $data_fim;

        return $this;
    }

    /**
     * Get the value of descricao
     */ 
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     *
     * @return  self
     */ 
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
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
}