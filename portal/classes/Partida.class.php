<?php

require_once 'Equipe.class.php';

abstract class Partida {

    protected $id;    
    protected $mapa;    
    protected $placar;
    protected $evento;
    protected $rounds;
    protected $aprovado;
    protected $horario;
    protected $link;
    protected $created_at, $updated_at;

  
    // Métodos getters e setters
    function getTable() {
        return $this->table;
    }

    function getId() {
        return $this->id;
    }

    function getMapa() {
        return $this->mapa;
    }
    
    function getPlacar() {
        return $this->placar;
    }

    function getEvento() {
        return $this->evento;
    }

    function getRounds() {
        return $this->rounds;
    }

    function getAprovado() {
        return $this->aprovado;
    }

    function getHorario() {
        return $this->horario;
    }
    
    function getLink() {
        return $this->link;
    }

    function getCreated_at() {
        return $this->created_at;
    }

    function getUpdated_at() {
        return $this->updated_at;
    }

    function setTable($table) {
        $this->table = $table;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setMapa($mapa) {
        $this->mapa = $mapa;
    }

    function setPlacar($placar) {
        $this->placar = $placar;
    }
    
    function setEvento($evento) {
        $this->evento = $evento;
    }

    function setRounds($rounds) {
        $this->rounds = $rounds;
    }

    function setAprovado($aprovado) {
        $this->aprovado = $aprovado;
    }

    function setHorario($horario) {
        $this->horario = $horario;
    }
    
    function setLink($link) {
        $this->link = $link;
    }
                function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    function setUpdated_at($updated_at) {
        $this->updated_at = $updated_at;
    }


    

}
