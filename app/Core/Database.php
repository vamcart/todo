<?php

namespace App\Core;

use App\Core\Http\Response;
use \PDO;

class Database
{
    /**
     * Connection PDO object
     */
    protected $connection;

    /**
     * @var \PDOStatement PDOStatement Object
     */
    private $statement = null;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $dbConfigs = Config::get('database');
        try {
            $this->connection = new PDO(
                sprintf(
                    '%1$s:host=%2$s;dbname=%3$s;port=%4$s;charset=utf8',
                    $dbConfigs['type'],
                    $dbConfigs['host'],
                    $dbConfigs['db'],
                    $dbConfigs['port']
                ),
                $dbConfigs['user'],
                $dbConfigs['password']
            );
        } catch (\Exception $ex) {
            (new Response('Could not establish a database connection', [], 500))->output();
            die;
        }
    }

    /**
     * Close pdo connection
     * @return void
     */
    public function close()
    {
        $this->connection = null;
    }

    /**
     * Prepares a SQL query for execution and assign a statement object to $this->statement
     * @param  string  $query
     */
    public function prepare($query)
    {
        $this->statement = $this->connection->prepare($query);
    }

    /**
     * Binds a value to a parameter.
     * @param   string  $param
     * @param   mixed   $value
     */
    public function bindValue($param, $value)
    {
        $type = self::getPDOType($value);
        $this->statement->bindValue($param, $value, $type);
    }

    /**
     * Binds an array of values to parameters.
     * @param   array  $params
     */
    public function bindValues(array $params)
    {
        foreach ($params as $name => $value) {
            $this->bindValue($name, $value);
        }
    }

    /**
     * Executes a prepared statement
     * @access public
     * @param   array $arr  Array of values to be bound in SQL query, All values are treated as PDO::PARAM_STR.
     * @return  boolean Returns TRUE on success or FALSE on failure.
     */
    public function execute($arr = null)
    {
        if ($arr === null) {
            return $this->statement->execute();
        } else {
            return $this->statement->execute($arr);
        }
    }

    /**
     * To fetch the result data in form of [0-indexed][key][value] array.
     *
     * @return array    empty array if no data returned
     */
    public function fetchAllAssociative()
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * To fetch Only the next row from the result data in form of [key][value] array.
     *
     * @return array|bool   false on if no data returned
     */
    public function fetchAssociative()
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Returns the ID of the last inserted row or sequence value
     * @return integer  The ID of the last inserted row of Auto-incremented primary key.
     * @see http://php.net/manual/en/pdo.lastinsertid.php
     */
    public function lastInsertedId()
    {
        return $this->connection->lastInsertId();
    }

    /**
     * Returns the number of rows affected by the last SQL statement
     * @see http://php.net/manual/en/pdostatement.rowcount.php
     */
    public function countRows()
    {
        return $this->statement->rowCount();
    }

    /**
     * Determine the PDOType of a passed value.
     * @param   mixed  $value
     * @return  integer PDO Constants
     */
    private static function getPDOType($value)
    {
        switch ($value) {
            case is_int($value):
                return PDO::PARAM_INT;
            case is_bool($value):
                return PDO::PARAM_BOOL;
            case is_null($value):
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }
}
