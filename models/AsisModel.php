<?php
class FormData {
    public $name;
    public $email;
    public $tele;
    public $date;
    public $message;

    public function __construct($name, $email, $tele, $date, $message) {
        $this->name = $name;
        $this->email = $email;
        $this->tele = $tele;
        $this->date = $date;
        $this->message = $message;
    }
    
    //metodos para obtener los datos
    public function getName(){
        return $this->name;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getTele(){
        return $this->tele;
    }
    public function getDate(){
        return $this->date;
    }
    public function getMessage(){
        return $this->message;
    }
}