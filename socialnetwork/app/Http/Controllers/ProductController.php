<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Contracts\Service;

class ProductController extends Controller
{

    public function __construct(Service $service)
    {
        $this->service = $service;
    }


    public function createJson()
    {
        $product = $this->service->index();
        return response()->json($product->toArray());
    }

    public function create() {
        //Вывод формуляра HTML, для создания записи о товаре
        //Создаём объект в памяти компа
        //$product = new Product();
        $product = $this->service->index();

        //Выводим формуляр
        // resources/views/layouts/products/create.blade.php
        return view('layouts.products.create', [
            'entity' => $product
        ]);
    }

    public function store(ProductRequest $request){
        //Сохранение нового товара в БД

        //Извлекаем из запроса только поля
        // title и price
        $attributes = $request->only(['title', 'about', 'amount', 'price']);
        //Отладочная печать данных из формы
        var_dump($attributes);
        //Создаёт новый кортеж в БД
        Product::create($attributes);
        //Product::create($attributes);

        return redirect(route('products.index'));
    }

    //Вывод формы изменения продукта
    public function edit($id) {
        //Вытаскиваем продукт из БД
        $product = Product::findOrFail($id);

        return view('layouts.products.edit', [
            'entity' => $product
        ]);
    }

    //
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $attributes = $request->only(['title','about','amount','price']);
        //var_dump($attributes);
        //Проводим обновления кортежа
        $product->update($attributes);
        //Перенаправляем на адрес products.edit
        return redirect(route('products.edit', [
            'id' => $product->id
        ]));
    }

    public function delete($id) {

        $product = Product::findOrFail($id);
        //Форма удаления
        return view('layouts.products.delete', [
            'entity' => $product
        ]);
    }

    public function destroy($id) {
        //Обработка удаления
        $product = Product::findOrFail($id);
        //var_dump($attributes);
        //Проводим удаления кортежа
        $product->delete($id);
        //Или
        //Product::destroy($id);
        //Перенаправляем на адрес products.edit
        return redirect(route('products.index'));
    }

    public function index() {
        //Вывод списка продуктов

        return view('layouts.products.index', [
            'products' => Product::orderBy('title', 'ASC')
                                    ->get()

        ]);
    }

}
