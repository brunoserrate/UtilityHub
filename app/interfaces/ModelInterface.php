<?php

namespace App\Interfaces;

interface ModelInterface {
    public function get($id = 0, $limit = 0, $orderBy = 'id', $order = 'ASC', $columns = ['*'], $where = []);
    public function insert($data);
    public function update($data, $where = []);
    public function delete($id, $where = [], $softDelete = true);
}