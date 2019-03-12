<?php

class EquipeApply {
    
    private $table = 'equipe_apply';
    private $id;
    private $equipe;
    private $usuario;
    private $status;
    private $created_at;
    
    public function aplicar($usuario, $equipe) {
        
        $sql = "INSERT INTO $this->table (usuario, equipe) VALUES (:usuario, :equipe)";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":usuario", $usuario, PDO::PARAM_STMT);
        $stmt->bindValue(":equipe", $equipe, PDO::PARAM_STMT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function cancelar($usuario) {
        
        $sql = "DELETE FROM $this->table WHERE usuario = :id_usuario";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id_usuario", $usuario);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    /* Busca uma registro no banco de dados */
    public function getApply($id_usuario) {
        
        $sql = "SELECT * FROM $this->table WHERE usuario = :id_usuario";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id_usuario", $id_usuario);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            
           // Passando o resultado da consulta para variavel $data
           $data = $stmt->fetch();
           
           // preenche o objeto
           $this->id = $data->id;
           
           // Cria objeto equipe com id do banco
           $equipe = new Equipe();
           $equipe->getEquipe($data->equipe);
           $this->equipe = $equipe;
           
           // Cria objeto usuario com id do banco
           $usuario = new Usuario();
           $usuario->getUsuario($data->id);
           $this->usuario = $usuario;
           $this->status = $data->status;
           $this->created_at = $data->created_at;
                   
            return $this;
            
        } else {
            return false;
        }
    }


    // métodos getters e setters
    function getId() {
        return $this->id;
    }

    function getEquipe() {
        return $this->equipe;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getStatus() {
        return $this->status;
    }

    function getCreated_at() {
        return $this->created_at;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEquipe($equipe) {
        $this->equipe = $equipe;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }


    
}