<?php

namespace Core\Table;


use Core\Database\MysqlDatabase;

/**
 * Class Table
 * 
 * find in Table, you can use heritage for specificities in tables
 */
class Table
{

    protected $table;
    protected $database;

    public function __construct(MysqlDatabase $database)
    {
        $this->database = $database;
        if ($this->table === null) {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Table', '', $class_name)) . 's';
        }
    }


    public function all()
    {
        return $this->query('SELECT * FROM ' . $this->table);
    }


    public function find($colId, ?string $field = 'id')
    {
        return $this->query("SELECT * FROM {$this->table} WHERE $field = ?", [$colId], true);
    }

    public function update($colId, $fields)
    {
        $sql_parts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $colId;
        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE {$this->table} SET $sql_part WHERE id = ?", $attributes, true);
    }

    public function extract($key, $value)
    {
        $records = $this->all();
        $return = [];
        foreach ($records as $v) {
            $return[$v->$key] = $v->$value;
        }
        return $return;
    }

    public function query($statement, $attributes = null, $one = false)
    {
        if ($attributes) {
            return $this->database->prepare(
                $statement,
                $attributes,
                str_replace('Table', 'Entity', get_class($this)),
                $one
            );
        }
        return $this->database->query(
            $statement,
            str_replace('Table', 'Entity', get_class($this)),
            $one
        );
    }
    public function create($fields)
    {
        $sql_parts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO {$this->table} SET $sql_part", $attributes, true);
    }

    public function delete($colId)
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$colId], true);
    }

    public function countTable()
    {
        return $this->query("SELECT COUNT(id) as id FROM {$this->table}");
    }

    public function count($key, $value)
    {
        return $this->query("SELECT COUNT(*) AS $key  FROM {$this->table} WHERE $key = ?", [$value], true);
    }
}
