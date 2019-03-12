<?php

require_once 'Usuario.class.php';

class Equipe {

    private $table = "equipe";
    private $id;
    private $lider;
    private $nome;
    private $descricao;
    private $ativo;
    private $image;
    private $created_at, $updated_at;

    // Busca equipe no banco pelo id
    public function getEquipe($id) {

        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            // Passa o resultado da consulta para variavel $data
            $data = $stmt->fetch();

            // preenche o objeto
            $this->id = $data->id;
            $this->lider = $data->id_lider_fk;
            $this->nome = $data->nome;
            $this->descricao = $data->descricao;
            $this->ativo = $data->ativo;
            $this->image = $data->image;
            $this->created_at = $data->created_at;
            $this->updated_at = $data->updated_at;

            return $this;
        } else {
            return false;
        }
    }

    /* Busca todas as equipes cadastradas no banco */

    public function getEquipes() {

        $array = array();

        $sql = "SELECT * FROM $this->table";
        $stmt = DB::prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetchAll();
        }

        return $array;
    }

    /* Criar uma nova equipe no banco de dados */

    public function criarEquipe($lider, $nome) {

        $this->lider = $lider;
        // Verifica se o lider já possuí uma equipe
        //$sql = "SELECT id FROM $this->lider->getTable() WHERE id = ";

        if ($lider->getAtivo() && $lider->getEquipe() == NULL) {
            $sql = "INSERT INTO $this->table (id_lider_fk, nome) VALUES (:lider, :nome)";
            $stmt = DB::prepare($sql);
            $stmt->bindValue(":lider", $this->lider->getId());
            $stmt->bindValue(":nome", $nome);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $last_id = DB::getInstance()->lastInsertId();
                $this->lider->setEquipe($last_id);
                if ($this->lider->participarEquipe($last_id)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    /* Busca todos os membros de uma equipe */

    public function getmembros($id_equipe) {
        $sql = "SELECT * FROM $this->table INNER JOIN usuario ON $this->table.id  = usuario.id_equipe_fk WHERE id_equipe_fk = :id_equipe";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id_equipe", $id_equipe);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    

    // Métodos Getters e Setters
    function getId() {
        return $this->id;
    }

    function getLider() {
        return $this->lider;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getAtivo() {
        return $this->ativo;
    }

    function getImage() {
        return $this->image;
    }

    function getCreated_at() {
        return $this->created_at;
    }

    function getUpdated_at() {
        return $this->updated_at;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLider($lider) {
        $this->lider = $lider;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    function setUpdated_at($updated_at) {
        $this->updated_at = $updated_at;
    }

}
