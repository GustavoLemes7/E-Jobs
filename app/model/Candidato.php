<?php

class Candidato
{
    private ?Usuario $usuario;
    private ?int $usuario_id;
    private ?string $nomeCompleto;
    private ?string $cpf;
    private ?string $genero;
    private ?string $descricao;
    private ?string $curriculoUrl;
    private ?string $fotoPerfilUrl;
    private $dataNascimento;
    private ?string $linkedin;
    private ?string $github;
    private ?Formacao $formacao;
    private ?Experiencia $experiencia;
    private ?string $habilidades;
    private ?string $telefoneContato;
    private ?string $emailContato;

    public function __construct()
    {
        $this->usuario = NULL;
        $this->usuario_id = NULL;
        $this->nomeCompleto = NULL;
        $this->cpf = NULL;
        $this->genero = NULL;
        $this->descricao = NULL;
        $this->curriculoUrl = NULL;
        $this->fotoPerfilUrl = NULL;
        $this->dataNascimento = NULL;
        $this->linkedin = NULL;
        $this->github = NULL;
        $this->formacao = NULL;
        $this->experiencia = NULL;
        $this->habilidades = NULL;
        $this->telefoneContato = NULL;
        $this->emailContato = NULL;

    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario)
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

    
    public function getNomeCompleto()
    {
        return $this->nomeCompleto;
    }


    public function setNomeCompleto($nomeCompleto)
    {
        $this->nomeCompleto = $nomeCompleto;

        return $this;
    }


    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }


    public function getGenero()
    {
        return $this->genero;
    }

    public function setGenero($genero)
    {
        $this->genero = $genero;

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


    public function getCurriculoUrl()
    {
        return $this->curriculoUrl;
    }

    public function setCurriculoUrl($curriculoUrl)
    {
        $this->curriculoUrl = $curriculoUrl;

        return $this;
    }

 
    public function getFotoPerfilUrl()
    {
        return $this->fotoPerfilUrl;
    }

    public function setFotoPerfilUrl($fotoPerfilUrl)
    {
        $this->fotoPerfilUrl = $fotoPerfilUrl;

        return $this;
    }


    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;

        return $this;
    }


    public function getLinkedin()
    {
        return $this->linkedin;
    }

    public function setLinkedin($likedin)
    {
        $this->linkedin = $likedin;

        return $this;
    }


    public function getGithub()
    {
        return $this->github;
    }

    public function setGithub($github)
    {
        $this->github = $github;

        return $this;
    }


    public function getFormacao(): ?Formacao
    {
        return $this->formacao;
    }

    public function setFormacao(?Formacao $formacao)
    {
        $this->formacao = $formacao;

        return $this;
    }


    public function getExperiencia(): ?Experiencia
    {
        return $this->experiencia;
    }

    public function setExperiencia(?Experiencia $experiencia)
    {
        $this->experiencia = $experiencia;

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


    public function getHabilidades()
    {
        return $this->habilidades;
    }

    public function setHabilidades($habilidades)
    {
        $this->habilidades = $habilidades;

        return $this;
    }


}
