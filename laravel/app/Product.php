<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /*
    private $message;

    public function __construct() {
        $this->message = 'Hello, ';
    }

    public function getMessage() {
        return $this->message;
    }

    */
    //Разрешаем автоматическое
    protected $fillable = ['title', 'about', 'amount', 'price'];


}
