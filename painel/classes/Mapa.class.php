<?php

require_once 'DB.class.php';

class Mapa {

    private $table = 'mapa';
    // Atributos da classe
    private $id;
    private $nome;
    private $image;
    private $created_at, $updated_at;

    /* Count total de mapas */

    public function getCount() {

        $sql = "SELECT id FROM $this->table";

        $stmt = DB::prepare($sql);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    /* Busca mapa no banco pelo id */
    
    public function getMapa($id) {

        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            // Passa o resultado da consulta para variavel $data
            $data = $stmt->fetch();

            // preenche o objeto
            $this->id = $data->id;
            $this->nome = $data->nome;
            $this->image = $data->image;
            $this->updated_at = $data->updated_at;
            $this->created_at = $data->created_at;

            return $this;
        } else {
            return false;
        }
    }
    
    /* Busca todos os mapas cadastrados no banco */
    
    public function getMapas() {
        
        $array = array();
        
        $sql = "SELECT * FROM $this->table";        
        $stmt = DB::prepare($sql);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetchAll();
        }
        return $array;
    }
    
    public function getMapasRandom() {
        
        
    }
    
    public function salvar() {
        
        if (!empty($this->id)) {
            $sql = "UPDATE $this->table SET nome = :nome, image = :image, updated_at = NOW() where id = :id";
            $stmt = DB::prepare($sql);
            $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
            $stmt->bindValue(":nome", $this->nome, PDO::PARAM_STR);
            $stmt->bindValue(":image", $this->image, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } else {
            $sql =  "INSERT INTO $this->table (nome, image) VALUES (:nome, :image)";
            $stmt = DB::prepare($sql);
            $stmt->bindValue(":nome", $this->nome, PDO::PARAM_STR);
            $stmt->bindValue(":image", $this->image, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    /* Exclui mapa do banco de dados */
    public function delete($id) {
        
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /* Métodos getters e setters */
    function getTable() {
        return $this->table;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getAprovado() {
        return $this->aprovado;
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

    function setTable($table) {
        $this->table = $table;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setAprovado($aprovado) {
        $this->aprovado = $aprovado;
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
