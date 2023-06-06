<?php

namespace App\Controllers;

use App\Core\Http\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Session;
use App\Core\Utilities\FunctionInjector;
use App\Core\View;
use App\Models\Todo;
use voku\helper\Paginator;


class TodoController extends Controller
{
    /**
     * Display homepage
     * @throws \Exception
     */
    public function index($sort = 'id', $order = 'desc', $page = 1)
    {
        // create a new object
        $pages = new Paginator(3, 'page');

        // set the total records, calling a method to get the number of records from a model
        $pages->set_total(Todo::count_all());

        $todoList = Todo::all($sort, $order, $page, $pages->get_limit());

        foreach ($todoList as $todo) {
            $todos[] = $todo->toArray();
        }
        
        $view_data = compact('todos');
        $view_merge = array_merge(array('pagination' => $pages->page_links()), $view_data);
        
        return view('home', $view_merge);
    }

    /**
     * Delete a todo
     * @param null|int $id
     * @return string
     */
    public function delete(Session $session, $id = null)
    {
        $todo = Todo::delete($id);

        $errors[] = 'Запись удалена!';
        session()->setFlash('errors', $errors);

        return view('home', compact('todo'));
    }

    /**
     * Display edit form
     * @param Session $session
     * @param null|int $id
     * @return \App\Core\Http\Response
     * @throws \Exception
     */
    public function edit(Session $session, $id = null)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response_404();
        }

        return view('edit', compact('todo'));
    }

    /**
     * Update a todo
     * @param Request $request
     * @param null|int $id
     * @return \App\Core\Http\Response
     */
    public function save(Request $request, $id = null)
    {
        // get origin
        $todo = Todo::find($id);
        if (!$todo) {
            return response_404();
        }

        if (!isAdmin()) {
            return to_route('user.auth');
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
        return to_route('todo.edit', ['id' => $todo->id, '+query' => ['saved' => 1]]);
    }

    /**
     * Create a Todo
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // @TODO validate
        // pure validating
        $validation = $this->validate($request);
        if ($validation !== true) {
            return $validation;
        }
        // save
        $todo = new Todo($request->input());
        $todo->save();
        return to_route('todo.edit', ['id' => $todo->id, '+query' => ['saved' => 1]]);
    }

    /**
     * Validate request
     * @param Request $request
     * @param null|int $id Pass the id to redirect to edit page when errors occur, else go to create page
     * @return true|Response
     */
    protected function validate(Request $request, $id = null)
    {
        $name = trim($request->input('name'));
        $errors = [];
        if (empty($name)) {
            $errors[] = 'Имя не должно быть пустым';
        }
        $email = trim($request->input('email'));
        $errors = [];
        if (empty($email)) {
            $errors[] = 'Email не должно быть пустым';
        }
        // if has errors
        if (!empty($errors)) {
            session()->setFlash('errors', $errors);
            // save old input
            session()->setFlash('old', $request->input());
            if ($id) {
                return to_route('todo.edit', ['id' => $id]);
            } else {
                return to_route('todo.create');
            }
        }
        // else
        return true;
    }
}
