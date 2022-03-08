<?php
class Controller{

    public function model($model){
        require_once "./mvc/models/".$model.".php";
        return new $model;
    }

    public function view($view, $data=[]){
        require_once "./mvc/views/".$view.".php";
    }

    public function except($arr, $except = []){
        foreach($arr as $key => $value) {
            if(in_array($key, $except)) {
                unset($arr[$key]);
            }
        }

        return $arr;
    }

    public function redirect($type="back", $message=[]){
        switch($type) {
            case "back":
                $_SESSION['message'] = $message;
                return header('Location: ' . $_SERVER['HTTP_REFERER']);

            default:
                break;
        }
    }
}