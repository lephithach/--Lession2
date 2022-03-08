<?php

class ProductModel extends DB{
    public function getProduct($start, $limit, $where = "") {
        $sql = 'SELECT * FROM product JOIN category ON category.category_id = product.category_id';

        if(!empty($where)) {
            $sql .= " WHERE category.category_name LIKE '%${where}%' OR product.product_name LIKE '%${where}%'";
        }

        $sql .= " ORDER BY product.product_id desc";

        $sql .= " LIMIT ${start}, {$limit}";

        return mysqli_query($this->conn, $sql);
    }

    public function countTotalProduct($where = "") {
        $sql = 'SELECT count(*) as total FROM product JOIN category ON category.category_id = product.category_id';

        if(!empty($where)) {
            $sql .= " WHERE category.category_name LIKE '%${where}%' OR product.product_name LIKE '%${where}%'";
        }

        return mysqli_query($this->conn, $sql);
    }

    public function getDetailProduct($id) {
        $sql = 'SELECT * FROM product JOIN category ON category.category_id = product.category_id WHERE product.product_id='.$id;
        return mysqli_query($this->conn, $sql);
    }

    public function getCategory(){
        $sql = 'SELECT * FROM category';
        return mysqli_query($this->conn, $sql);
    }

    public function insert($table, $arr = []) {
        $arr['created_at'] = $arr['updated_at'] = date('Y-m-d H:i:s');
        $totalArr = count($arr);
        $countForeach = 0;
        $sql = "INSERT INTO ${table}(";
        
        foreach($arr as $key => $value) {
            $countForeach++;

            if($countForeach == $totalArr) {
                $sql .= "${key})";
            } else {
                $sql .= "${key},";
            }
        }

        $countForeach = 0;
        $sql .= " VALUES(";

        foreach($arr as $key => $value) {
            $countForeach++;

            if($countForeach == $totalArr) {
                $sql .= "'${value}')";
            } else {
                $sql .= "'${value}',";
            }
        }

        return mysqli_query($this->conn, $sql);
    }

    public function update($table, $id, $response = []){
        $response['updated_at'] = date('Y-m-d H:i:s');
        $totalResponse = count($response);
        $countForeach = 0;
        
        $sql = "UPDATE ${table} SET ";
        foreach($response as $key => $value) {
            $countForeach++;

            if($totalResponse == $countForeach) {
                $sql .= "${key} = '${value}' ";
            } else {
                $sql .= "${key} = '${value}', ";
            }
        }

        $sql .= " WHERE ${table}_id=${id}";

        return mysqli_query($this->conn, $sql);
    }

    public function destroy($table, $id) {
        $sql = "DELETE FROM ${table} WHERE product_id=${id}";

        return mysqli_query($this->conn, $sql);
    }
}