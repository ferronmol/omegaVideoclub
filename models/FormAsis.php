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
}