<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use App\Utils\Database\Database;

abstract class AbastractModel implements ModelInterface
{
    protected $table = "";
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db = $this->db->getConnection();
    }

    public function get($id = 0, $limit = 0, $orderBy = 'id', $order = 'ASC', $columns = ['*'], $where = [])
    {
        if (count($columns) > 0) {
            $columns = implode(', ', $columns);
        } else {
            $columns = '*';
        }

        $query = "SELECT {$columns} FROM $this->table WHERE 1 = 1";

        if ($id > 0) {
            $query .= " AND id = {$id}";
        }

        $conditionsCount = count($where);

        if ($conditionsCount > 0) {
            for ($i = 0; $i < $conditionsCount; $i++) {

                if ($i <= ($conditionsCount - 1))
                    $query .= " AND {$where[$i]['key']} {$where[$i]['operator']} '{$where[$i]['value']}'";
                else
                    $query .= " {$where[$i]['key']} {$where[$i]['operator']} {$where[$i]['value']}";
            }
        }

        $query .= " ORDER BY {$orderBy} {$order}";

        if ($limit > 0) {
            $query .= " LIMIT {$limit}";
        }

        $stmt = $this->db->prepare($query);

        try {
            $stmt->execute();
        }
        catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return [
            'success' => true,
            'message' => 'Data retrieved successfully.',
            'data' => $stmt->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }
    public function insert($data)
    {

        if (empty($data)) {
            return [
                'success' => false,
                'message' => 'Data cannot be empty.'
            ];
        }

        $columns = implode(', ', array_keys($data));

        $values = implode(', ', array_map(function ($value) {
            return ":{$value}";
        }, array_keys($data)));

        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";

        $stmt = $this->db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        try {
            $stmt->execute();

        }
        catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return [
            'success' => true,
            'message' => 'Data inserted successfully.',
            'data' => [
                'id' => $this->db->lastInsertId()
            ]
        ];
    }

    public function update($data, $where = []) {
        if (empty($data)) {
            return [
                'success' => false,
                'message' => 'Data cannot be empty.'
            ];
        }

        $query = "UPDATE {$this->table} SET ";

        $columns = array_keys($data);

        $columnsCount = count($columns);

        for ($i = 0; $i < $columnsCount; $i++) {
            if ($i < ($columnsCount - 1))
                $query .= "{$columns[$i]} = :{$columns[$i]}, ";
            else
                $query .= "{$columns[$i]} = :{$columns[$i]}";
        }

        $conditionsCount = count($where);

        if ($conditionsCount > 0) {
            $query .= " WHERE 1 = 1";

            for ($i = 0; $i < $conditionsCount; $i++) {

                if ($i <= ($conditionsCount - 1))
                    $query .= " AND {$where[$i]['key']} {$where[$i]['operator']} '{$where[$i]['value']}'";
                else
                    $query .= " {$where[$i]['key']} {$where[$i]['operator']} {$where[$i]['value']}";
            }
        }

        $stmt = $this->db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        try {
            $stmt->execute();
        }
        catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return [
            'success' => true,
            'message' => 'Data updated successfully.'
        ];
    }
    public function delete($id = 0, $where = [], $softDelete = true) {
        if($id <= 0 && empty($where)){
            return [
                'success' => false,
                'message' => 'Id or where cannot be empty.'
            ];
        }

        if($softDelete){
            $query = "UPDATE {$this->table} SET deleted_at = CURRENT_TIMESTAMP, is_activated = FALSE WHERE 1 = 1";
        }
        else {
            $query = "DELETE FROM {$this->table} WHERE 1 = 1";
        }

        if($id > 0){
            $query .= " AND id = {$id}";
        }

        $conditionsCount = count($where);

        if ($conditionsCount > 0) {
            for ($i = 0; $i < $conditionsCount; $i++) {

                if ($i <= ($conditionsCount - 1))
                    $query .= " AND {$where[$i]['key']} {$where[$i]['operator']} '{$where[$i]['value']}'";
                else
                    $query .= " {$where[$i]['key']} {$where[$i]['operator']} {$where[$i]['value']}";
            }
        }

        $stmt = $this->db->prepare($query);

        try {
            $stmt->execute();
        }
        catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return [
            'success' => true,
            'message' => 'Data deleted successfully.'
        ];
    }
}
