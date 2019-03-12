<?php

require_once 'DB.class.php';

class Usuario {

    private $table = 'usuario';
    // Atributos da classe
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $nick;
    private $ativo;
    private $image;
    private $facebook, $whatsapp, $youtube;
    // Atributo objeto
    public $equipe;

    /* Count membros na equipe */

    public function getCountMembrosEquipe($id_equipe) {

        $sql = "SELECT COUNT(id) as count FROM $this->table WHERE id_equipe_fk = :id_equipe";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id_equipe", $id_equipe);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch();
        } else {
            return false;
        }
    }

    // Busca usuário no banco pelo id
    public function getUsuario($id) {

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
            $this->email = $data->email;
            $this->senha = $data->senha;
            $this->nick = $data->nick;
            $this->ativo = $data->ativo;
            $this->image = $data->image;
            $this->facebook = $data->facebook;
            $this->whatsapp = $data->whatsapp;
            $this->youtube = $data->youtube;

            if ($data->id_equipe_fk) {
                $equipe = new Equipe();
                $equipe->getEquipe($data->id_equipe_fk);
                $this->equipe = $equipe;
            }
            //$this->equipe = $data->id_equipe_fk;

            return $this;
        } else {
            return false;
        }
    }

    public function participarEquipe($equipe) {

        $sql = "UPDATE $this->table SET id_equipe_fk = :id_equipe WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":id_equipe", $equipe);
        $stmt->bindValue(":id", $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /* Método para sair de uma equipe */

    public function sairEquipe() {

        if (!empty($this->id)) {
            $sql = "UPDATE $this->table SET id_equipe_fk = :id_equipe, updated_at = NOW() WHERE id = :id";
            $stmt = DB::prepare($sql);
            $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
            $stmt->bindValue(":id_equipe", null);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        }
    }

    /* Atualizar no banco de dados todas as informações setadas no objeto */

    public function salvar() {

        if (!empty($this->id)) {
            $sql = "UPDATE $this->table SET nome = :nome, email = :email, senha = :senha, nick = :nick, ativo = :ativo, image = :image, whatsapp = :whatsapp, facebook = :facebook, youtube = :youtube, updated_at = NOW() WHERE id = :id";
            $stmt = DB::prepare($sql);
            $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
            $stmt->bindValue(":nome", $this->nome, PDO::PARAM_STR);
            $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue(":senha", $this->senha, PDO::PARAM_STR);
            $stmt->bindValue(":nick", $this->nick, PDO::PARAM_STR);
            $stmt->bindValue(":ativo", $this->ativo, PDO::PARAM_INT);
            $stmt->bindValue(":image", $this->image, PDO::PARAM_STR);
            $stmt->bindValue(":whatsapp", $this->whatsapp, PDO::PARAM_STR);
            $stmt->bindValue(":facebook", $this->facebook, PDO::PARAM_STR);
            $stmt->bindValue(":youtube", $this->youtube, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        }
    }

    /* Registrar novo usuário no banco de dados */

    public function registrar() {

        $sql = "INSERT INTO $this->table (nick, email, senha) VALUES (:nick, :email, :senha)";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":nick", $this->nick);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":senha", $this->senha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Logar no sistema
    public function login($email, $senha) {

        $sql = "SELECT id, nome, email, nick FROM $this->table WHERE email = :email AND senha = :senha";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", md5($senha));
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch();
            $_SESSION['login'] = array('id' => $data->id, 'nome' => $data->nome, 'email' => $data->email, 'nick' => $data->nick);
            return true;
        } else {
            return false;
        }
    }

    // Deslogar do sistema
    public function logout() {
        session_destroy();
        header("Location: login.php");
    }

    // Métodos Setters e Getters
    function getTable() {
        return $this->table;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getNick() {
        return $this->nick;
    }

    function getAtivo() {
        return $this->ativo;
    }

    function getEquipe() {
        return $this->equipe;
    }

    function getImage() {
        return $this->image;
    }

    function getFacebook() {
        return $this->facebook;
    }

    function getWhatsapp() {
        return $this->whatsapp;
    }

    function getYoutube() {
        return $this->youtube;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = md5($senha);
    }

    function setNick($nick) {
        $this->nick = $nick;
    }

    function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    function setEquipe($equipe) {
        $this->equipe = $equipe;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    function setWhatsapp($whatsapp) {
        $this->whatsapp = $whatsapp;
    }

    function setYoutube($youtube) {
        $this->youtube = $youtube;
    }

}
