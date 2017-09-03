<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Список товаров</h1>

    <a href="{{ route('products.create') }}">
        Создать новый продукт
    </a>

    <table>
        <tr>
            <td>Название товара</td>
            <td>О товаре</td>
            <td>Количество товара</td>
            <td>Цена товара</td>
        </tr>
    @foreach($products as $p)

        <tr>
            <td> {{ $p->title }} </td>
            <td> {{ $p->about }} </td>
            <td> {{ $p->amount }} </td>
            <td> {{ $p->price }} </td>
            <td><a href="{{ route('products.edit', [
                    'id' => $p->id]) }}">
                    Редактировть
                </a>
            </td>
            <td><a href="{{ route('products.delete', [
                    'id' => $p->id]) }}">
                    Удалить
                </a>
            </td>
        </tr>

    @endforeach
    </table>
</body>
</html>