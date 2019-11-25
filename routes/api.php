<?php

use Illuminate\Http\Request;

/*
|---------------------------------------------------------------------|
|                              API Routes                             |
|---------------------------------------------------------------------|
| GET /api/products/ - список товаров                                 |
| GET /api/products/12345/ – информация о товаре                      |
| POST /api/products/ + JSON – добавить новый товар                   |
| PUT /api/products/12345/ + JSON – обновить существующий товар       |
| DELETE /api/products/12345/ – удалить товар                         |
|---------------------------------------------------------------------|
*/

Route::get('/products', 'ProductsController@index');

Route::get('/products/{id}', 'ProductsController@show');

Route::post('/products', 'ProductsController@store');

Route::put('/products/{id}', 'ProductsController@update');

Route::delete('/products/{id}', 'ProductsController@destroy');
