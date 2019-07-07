<?php
/**
	* This file devoted to the amazing PHP pattern ***Builder***
	* Author: Fedorchak Oleksiy
	* e-mail: atilla3@ukr.net
	* example: query builder for select quieries
	*
*/

//declare namespace
namespace Index\Builder;

//OOP part
interface Builder
{
    public static function where(String $property, String $operator, $value);
    public static function order(String $value, String $direction);
    public static function limit($value);
}

class queryBuilder implements Builder
{
    private $query;
    private static $self;

    private $declarations = [
        "where" => 0,
        "order" => 0
    ];

    public static function set(String $table)
    {
        self::$self = new self;
        self::$self->query = new Query($table);
        return self::$self;
    }

    public static function where(String $property, String $operator, $value)
    {
        self::$self->declarations["where"] === 0 ? $where = "WHERE " : $where = "AND ";
        self::$self->declarations["where"]++;

        self::$self->query->where .= " " . $where . $property . " " . $operator . " " . $value;
        return self::$self;
    }

    public static function order(String $value, String $direction)
    {
        self::$self->declarations["order"] === 0 ? $order = " ORDER BY " : $order = ",";
        self::$self->declarations["order"]++;

        self::$self->query->order .= $order . " " . $value . " " . $direction;
        return self::$self;
    }

    public static function limit($value)
    {
    	self::$self->query->limit = " LIMIT " . $value;
        return self::$self;
    }

    public static function get()
    {
        $queryString = self::$self->query->queryString();
        self::set("");
        echo $queryString . "\r\n";
        return $queryString;
    }
}

class Query
{
    public $queryString;
    public $where;
    public $order;
    public $limit;

    private $table;

    public function __construct(String $table)
    {
        $this->table = $table;
    }

    public function queryString()
    {
        $this->queryString = "SELECT * FROM " . $this->table;
        $this->queryString .= $this->where;
        $this->queryString .= $this->order;
        $this->queryString .= $this->limit;

        return $this->queryString;
    }
}



// Client's code

queryBuilder::set("courses")
      ->where("id", "!=", "NULL")
      ->where("user_id", "=", "12")
      ->order("id", "asc")
      ->order("user_id", "DESC")
      ->limit(22)
      ->limit(45)
      ->get();





/**
 * Hope you will find it useful. 
 * Thanks in advance for any tips about improving or correction the code!
 */
