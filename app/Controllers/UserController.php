<?php

namespace App\Controllers;

use App\Core\Http\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Session;
use App\Core\Utilities\FunctionInjector;
use App\Core\View;
use App\Models\User;


class UserController extends Controller
{

    /**
     * Display edit form
     * @param Session $session
     * @param null|int $id
     * @return \App\Core\Http\Response
     * @throws \Exception
     */
    public function auth(Session $session, $id = null)
    {
        return view('auth');
    }

    public function save(Request $request, $id = null)
    {
        // get origin
        $todo = Todo::find($id);
        if (!$todo) {
            return response_404();
        }

        // pure validating
        $validation = $this->validate($request, $id);
        if ($validation !== true) {
            return $validation;
        }

        // fill new data to model
        $todo->fill($request->input());
        $todo->save();
        // back
        return to_route('user.auth', ['id' => $todo->id, '+query' => ['saved' => 1]]);
    }    

    /**
     * Login
     * @param Request $request
     * @param null|int $id
     * @return \App\Core\Http\Response
     */
    public function login(Request $request, $id = null)
    {
        // pure validating
        $validation = $this->validate($request, $id);
        if ($validation !== true) {
            return $validation;
        }
        
        session()->set('login', true);

        // back
        return redirect('/');
    }

    /**
     * Logoff
     * @param Request $request
     * @param null|int $id
     * @return \App\Core\Http\Response
     */
    public function logoff(Request $request, $id = null)
    {

        session()->delete('login');

        $errors[] = 'Вы успешно вышли';
        if (!empty($errors)) {
            session()->setFlash('errors', $errors);
                return to_route('user.auth');
        }    	
 
    }

    /**
     * Validate request
     * @param Request $request
     * @param null|int $id Pass the id to redirect to edit page when errors occur, else go to create page
     * @return true|Response
     */
    protected function validate(Request $request, $id = null)
    {
        $login = trim($request->input('login'));
        $password = trim($request->input('password'));
        $errors = [];
        if (empty($login)) {
            $errors[] = 'Логин не может быть пустым';
        }
        if (empty($password)) {
            $errors[] = 'Пароль не может быть пустым';
        }
        if ($password != '123') {
            $errors[] = 'Пароль неправильный';
        }
        if ($login != 'admin') {
            $errors[] = 'Логин неправильный';
        }        // if has errors
        if (!empty($errors)) {
            session()->setFlash('errors', $errors);
                return to_route('user.auth');
        }
        // else
        return true;
    }
}
