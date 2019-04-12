<?php

require_once 'Partida.class.php';

class PartidaAmistoso extends Partida {

    private $table = "partida_amistoso";
    private $desafiante, $desafiado;
    private $partidas = array();
    public static $lista = array();

    // Métodos crud
    public function find($id) {

        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            // Passando o resultado da consulta para $data
            $data = $stmt->fetch();

            // Preenche o objeto
            $this->id = $data->id;
            $this->desafiante = $data->desafiante;
            $this->desafiado = $data->desafiado;
            $this->mapa = $data->mapa;
            // $this->evento = $data->evento;
            $this->rounds = $data->rounds;
            $this->aprovado = $data->aprovado;
            $this->horario = $data->horario;
            $this->link = $data->link;
            $this->created_at = $data->created_at;
            $this->updated_at = $data->updated_at;

            return $this;
        }
    }

    // Método para pegar todas as partidas com instacia
    public function getPartidas() {
        $sql = "SELECT * FROM $this->table";
        $stmt = DB::prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetchAll();

            foreach ($data as $row) {
                $register = new PartidaAmistoso();
                $register->setId($row->id);
                $register->setDesafiante($row->desafiante);
                $register->setDesafiado($row->desafiado);
                $register->setMapa($row->mapa);
                $register->setPlacar($row->placar);
                $register->setRounds($row->rounds);
                $register->setAprovado($row->aprovado);
                $register->setHorario($row->horario);
                $register->setLink($row->link);
                $register->setCreated_at($row->created_at);
                $register->setUpdated_at($row->updated_at);
                $this->partidas[] = $register;
            }
            return $this->partidas;
        }
    }

    // Método para pegar todas as partidas da Equipe com id da equipe e com instacia
    public function getPartidasEquipe($id_equipe) {
        $sql = "SELECT * FROM $this->table WHERE desafiante = :id_equipe OR desafiado = :id_equipe ORDER BY id desc";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id_equipe", $id_equipe);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetchAll();

            foreach ($data as $row) {
                $register = new PartidaAmistoso();
                $register->setId($row->id);

                // Cria objeto equipe com id do desafiante
                $desafiante = new Equipe();
                $desafiante->getEquipe($row->desafiante);
                $register->setDesafiante($desafiante);

                // Cria objeto equipe com id do desafiado
                $desafiado = new Equipe();
                $desafiado->getEquipe($row->desafiado);
                $register->setDesafiado($desafiado);

                // Cria objeto mapa com id do mapa
                $mapa = new Mapa();
                $mapa->getMapa($row->mapa);
                $register->setMapa($mapa);

                $register->setPlacar($row->placar);
                $register->setRounds($row->rounds);
                $register->setAprovado($row->aprovado);
                $register->setHorario($row->horario);
                $register->setLink($row->link);
                $register->setCreated_at($row->created_at);
                $register->setUpdated_at($row->updated_at);
                $this->partidas[] = $register;
            }
            return $this->partidas;
        }
    }

    // Método static para pegar todas as partidas sem instancia
    public static function getAll() {

        $sql = "SELECT * FROM partida_amistoso";
        $stmt = DB::prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetchAll();

            foreach ($data as $row) {
                $register = new PartidaAmistoso();
                $register->setId($row->id);

                // Cria objeto equipe com id do desafiante
                $desafiante = new Equipe();
                $desafiante->getEquipe($row->desafiante);
                $register->setDesafiante($desafiante);

                // Cria objeto equipe com id do desafiado
                $desafiado = new Equipe();
                $desafiado->getEquipe($row->desafiado);
                $register->setDesafiado($desafiado);

                // Cria objeto mapa com id do mapa
                $mapa = new Mapa();
                $mapa->getMapa($row->mapa);
                $register->setMapa($mapa);

                $register->setPlacar($row->placar);
                $register->setRounds($row->rounds);
                $register->setAprovado($row->aprovado);
                $register->setHorario($row->horario);
                $register->setLink($row->link);
                $register->setCreated_at($row->created_at);
                $register->setUpdated_at($row->updated_at);


                self::$lista[] = $register;
            }
            return self::$lista;
        }
    }

    // Métodos Getters e Setters
    function getTable() {
        return $this->table;
    }

    function getDesafiante() {
        return $this->desafiante;
    }

    function getDesafiado() {
        return $this->desafiado;
    }

    function setTable($table) {
        $this->table = $table;
    }

    function setDesafiante($desafiante) {
        $this->desafiante = $desafiante;
    }

    function setDesafiado($desafiado) {
        $this->desafiado = $desafiado;
    }

}
