<?php

class Empresa 
{
    private ?Usuario $usuario;
    private ?int $usuario_id;
    private ?string $nomeFantasia;
    private ?string $razaoSocial;
    private ?string $descricao;
    private ?string $cnpj;
    private ?string $inscricaoEstadual;
    private $dataAbertura;
    private ?string $logoUrl;
    private ?string $siteUrl;
    private ?int $numeroFuncionarios;
    private ?string $telefoneContato;
    private ?string $emailContato;

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }


    public function getUsuario_id()
    {
        return $this->usuario_id;
    }

    public function setUsuario_id($usuario_id)
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }


    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }

    public function setNomeFantasia($nomeFantasia)
    {
        $this->nomeFantasia = $nomeFantasia;

        return $this;
    }


    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;

        return $this;
    }


    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }


    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;

        return $this;
    }


    public function getInscricaoEstadual()
    {
        return $this->inscricaoEstadual;
    }

    public function setInscricaoEstadual($inscricaoEstadual)
    {
        $this->inscricaoEstadual = $inscricaoEstadual;

        return $this;
    }


    public function getDataAbertura()
    {
        return $this->dataAbertura;
    }

    public function setDataAbertura($dataAbertura)
    {
        $this->dataAbertura = $dataAbertura;

        return $this;
    }


    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;

        return $this;
    }

 
    public function getSiteUrl()
    {
        return $this->siteUrl;
    }

    public function setSiteUrl($siteUrl)
    {
        $this->siteUrl = $siteUrl;

        return $this;
    }


    public function getNumeroFuncionarios()
    {
        return $this->numeroFuncionarios;
    }

    public function setNumeroFuncionarios($numeroFuncionarios)
    {
        $this->numeroFuncionarios = $numeroFuncionarios;

        return $this;
    }

 
    public function getTelefoneContato()
    {
        return $this->telefoneContato;
    }

    public function setTelefoneContato($telefoneContato)
    {
        $this->telefoneContato = $telefoneContato;

        return $this;
    }


    public function getEmailContato()
    {
        return $this->emailContato;
    }

    public function setEmailContato($emailContato)
    {
        $this->emailContato = $emailContato;

        return $this;
    }
}
