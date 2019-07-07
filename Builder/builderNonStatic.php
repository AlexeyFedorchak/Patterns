<?php
/**
 * builder
 * build select query [only where, order, limit are allowed || in where you may put only one condition]
 *
 */
// SELECT * FROM table WHERE id = 1;

namespace index\Builder;

interface Builder
{
    public function where(String $property, String $operator, $value);
    public function order(String $value, String $direction);
    public function limit($value);
}

class queryBuilder implements Builder
{
    private $quey;

    public function __construct(String $table)
    {
        $this->set($table);
    }

    public function set(String $table)
    {
        $this->query = new Query($table);
    }

    public function where(String $property, String $operator, $value)
    {
        $this->query->where = " WHERE " . $property . " " . $operator . " " . $value;
        return $this;
    }

    public function order(String $value, String $direction)
    {
        $this->query->order = " ORDER BY " . $value . " " . $direction;
        return $this;
    }

    public function limit($value)
    {
        $this->query->limit = " LIMIT " . $value;
        return $this;
    }

    public function get()
    {
        $queryString = $this->query->queryString();
        $this->set("");

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

$courses = new queryBuilder("courses");
echo $courses->where("id", "<", 56)
                ->order("id", "ASC")
                ->limit(20)
                ->get();
