<?php

namespace App\Models;

use App\Core\Model;

class Todo extends Model
{
    /**
     * @var string table associated with this model
     */
    protected $table = 'todos';

    /**
     * @var array list of safe properties
     */
    protected $fillable = ['name', 'email', 'description', 'status', 'edited'];

    /**
     * Get all records from db
     * @return array An array of Todo
     */
    public static function all($sort, $order, $page, $limit)
    { 

        $sort = white_list($sort, 'sort');
        $order = white_list($order, 'order');

        $db = resolve('db');
        $db->prepare('select * from todos order by ' . $sort . ' ' . $order . $limit);

        $db->execute();
        $result = $db->fetchAllAssociative();
        $modelList = [];
        // transform to array of models
        foreach ($result as $data) {
            $model = new Todo();
            $model->_fill($data);
            $modelList[] = $model;
        }

        return $modelList;
    }
    
    public static function count_all()
    {
    	$db = resolve('db');
    	$db->prepare("select * from todos");
    	$db->execute();
    	$count = $db->countRows();

        return $count;
    }    
}
