<?php

class Formacao{
    private ?int $id;
    private ?int $candidato_id;
    private ?string $curso;
    private ?string $instituicao;
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
     * Get the value of curso
     */ 
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set the value of curso
     *
     * @return  self
     */ 
    public function setCurso($curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get the value of instituicao
     */ 
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * Set the value of instituicao
     *
     * @return  self
     */ 
    public function setInstituicao($instituicao)
    {
        $this->instituicao = $instituicao;

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