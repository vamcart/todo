<?php

$router = resolve('router');

$router->get('/', 'TodoController@index')->name('home');

$router->get('/sort/{sort}/order/{order}', 'TodoController@index')->name('home');

$router->get('/user/auth', 'UserController@auth')->name('user.auth');
$router->post('/user/login', 'UserController@login')->name('user.login');
$router->get('/user/logoff', 'UserController@logoff')->name('user.logoff');

// create
$router->get('/todo/create', function (\App\Core\Http\Request $request, \App\Core\Session $session) {
    $todo = new App\Models\Todo();
    return view('edit', compact('todo'));
})->name('todo.create');
$router->post('/todo/create', 'TodoController@store');
// edit
$router->get('/todo/{id}/edit', 'TodoController@edit')->name('todo.edit');
// save edit
$router->put('/todo/{id}', 'TodoController@save')->name('todo.save');
