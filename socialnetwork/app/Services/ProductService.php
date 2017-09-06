<?php
namespace App\Services;

use App\Product;


class ProductService implements \App\Contracts\Service {
    public function index()
    {
        //Вывод формуляра HTML, для создания записи о товаре
        //Создаём объект в памяти компа
        $product = Product::get();
        return $product;
    }
}