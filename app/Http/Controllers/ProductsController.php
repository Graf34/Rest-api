<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //Список товаров
    {
        //SQL запрос на вывод всех товаров
        $results = DB::select('select *  from products;'); 
        if ($results) {
            //Вывод JSON ответа
            return $results; 
        } 
        else {
            //Вывод ответ ошибки
            http_response_code(204);
            echo json_encode(["Error"]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Получение данных запроса
        $json = (json_decode($request->json));
        $row = DB::select('select * from products where id=?', [$json[0]->id]);
        //Существует ли запись с таким ID
        if (!$row) {
            //Добавление записи 
            $created = DB::insert('INSERT INTO `products` (`id`, `title`, `price`, `quantity`) VALUES (?, ?, ?, ?);', [$json[0]->id, $json[0]->title, $json[0]->price, $json[0]->quantity]);
            if ($created) {
                http_response_code(201);
                echo json_encode(["Product successfully added"]);
            } else {
                //Вывод ответ ошибки
                http_response_code(400);
                echo json_encode(["Error"]);
            }
        } else {
            //Ошибка, товар с таким ID уже существует
            http_response_code(400);
            echo json_encode(["A product with this id already exists"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //SQL запрос на вывод товара с введённым ID 
        $results = DB::select('select * from products where id=?', [$id]);
        if ($results) {
            return $results;
        } else {
            //Ошибка, товар с таким ID не существует
            http_response_code(400);
            echo json_encode(["Product with this identifier does not exist"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Получение данных запроса
        $json = (json_decode($request->json));
        //Существует ли запись с таким ID
        if (DB::select('select * from products where id=?', [$id])) {
            //Обновить запись
            $results = DB::update('UPDATE `products` SET `id` = ?, `title` = ?, `price` = ?, `quantity` = ? WHERE `products`.`id` = ?;',  [$json[0]->id, $json[0]->title, $json[0]->price, $json[0]->quantity, $id]);
            if ($results) {
                //Успешное обновление
                http_response_code(201);
                echo json_encode(["Product updated successfully"]);
            } else {
                //Обновление не удалось
                http_response_code(400);
                echo json_encode(["Update failed"]);
            }
        } else {
            //Продукт с этим ID не найден
            http_response_code(404);
            echo json_encode(["Product with this ID not found"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Существует ли запись с таким ID
        if (DB::select('select * from products where id=?', [$id])) {
            //Удаление записи
            if (DB::delete('delete from products where id=?', [$id])) {
                //Элемент успешно удален
                return ["Item successfully deleted"];
            }
        } else {
            //Продукт с этим ID не найден
            http_response_code(404);
            echo json_encode(["Product with this ID not found"]);
        }
    }
}
