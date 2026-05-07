<?php

class Status{
    
    const ATIVO = "ATIVO";
    const INATIVO = "INATIVO";
    const PENDENTE = "PENDENTE";

    public static function getAllAsArray() {
        return [Status::ATIVO, Status::INATIVO];

        
    }
}