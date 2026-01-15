<?php

namespace App\Models;

require './vendor/autoload.php';


class User{
    private int $id;
    private string $name;
    private string $email;
    private string $password;


    public function __construct($id,$name,$email,$password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }
    public function setId($id){
        return $this->id = $id;
    }
    public function setName($name){
        return $this->name = $name;
    }

    public function setEmail($email){
        return $this->email = $email;
    }

    public function setPassword($password){
        return $this->password = $password;
    }
}