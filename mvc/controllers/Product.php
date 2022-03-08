<?php

class Product extends Controller{
    public $limit = 10;
    
    public function startPage($page, $limit) {
        return ($page - 1) * $limit;
    }

    public function calcTotalPage($totalProduct, $limit) {
        $totalProduct = mysqli_fetch_assoc($totalProduct);
        return (int)ceil($totalProduct['total'] / $limit);
    }

    public function index($page = 1, $search = ""){
        $currentPage = (int)$page;
        $totalPage = $this->calcTotalPage($this->model('ProductModel')->countTotalProduct($search), $this->limit);

        if(!empty($search)) {
            $search = $search;
        }

        $previousPage = ($currentPage == 1) ? 1 : $currentPage - 1;
        $nextPage = ($currentPage == $totalPage) ? $totalPage : $currentPage + 1;

        $this->view('productList', [
            "product" => $this->model('ProductModel')->getProduct($this->startPage($page, $this->limit), $this->limit, $search),
            "pageTitle" => 'Danh sách sản phẩm',
            "pagination" => [
                "totalPage" => $totalPage,
                "currentPage" => $currentPage,
                "previousPage" => "http://{$_SERVER['HTTP_HOST']}/lampart/product/page/" . $previousPage . "/{$search}",
                "nextPage" => "http://{$_SERVER['HTTP_HOST']}/lampart/product/page/" . $nextPage . "/{$search}",
                "search" => $search
            ],
        ]);
    }

    public function create() {
        $this->view('productCreate', [
            "pageTitle" => "Thêm sản phẩm",
            "category" => $this->model('ProductModel')->getCategory(),
        ]);
    }

    public function uploadImages() {
        $isSuccess = false;
        $accept = ["jpg", "png", "jpeg"];
        
        $target_file = "./images/" . date('Y-m-d-H-i-s') . "-" . basename($_FILES["product_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $checkAccept = in_array($imageFileType, $accept);

        if($checkAccept) {
            $upload = move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);
            
            if($upload) {
                $isSuccess = true;
            }
        }

        return [
            "isSuccess" => $isSuccess,
            "targetFile" => $target_file
        ];
    }
    
    public function store() {
        $response = $_POST;

        $upload = $this->uploadImages();

        if($upload['isSuccess']) {
            $response['image'] = $upload['targetFile'];
            $result = $this->model('ProductModel')->insert('product', $response);
        }

        if($result) {
            $this->redirect('back', [
                'type' => 'success',
                'message' => 'Thêm sản phẩm thành công'
            ]);
        } else {
            $this->redirect('back', [
                'type' => 'danger',
                'message' => 'Thêm sản phẩm không thành công, vui lòng thử lại'
            ]);
        }
    }

    public function show($id){
        $this->view('productDetail', [
            "product" => $this->model('ProductModel')->getDetailProduct($id),
            "category" => $this->model('ProductModel')->getCategory(),
            "pageTitle" => 'Chi tiết sản phẩm'
        ]);
    }

    public function update($id){
        $response = $_POST;
        if(!empty($_FILES['product_image'])) {
            $upload = $this->uploadImages();

            if($upload['isSuccess']) {
                $response['image'] = $upload['targetFile'];
            }
        }

        $result = $this->model('ProductModel')->update('product', $id, $response);

        if($result) {
            $this->redirect('back', [
                'type' => 'success',
                'message' => 'Cập nhật thành công'
            ]);
        } else {
            $this->redirect('back', [
                'type' => 'danger',
                'message' => 'Cập nhật không thành công, vui lòng thử lại'
            ]);
        }
    }

    public function copy($id){
        // Láy toàn bộ thông tin của sản phẩm đã chọn
        $getProduct = $this->model('ProductModel')->getDetailProduct($id);

        // Loại trừ ra những trường không cần thiết 
        $arr = mysqli_fetch_assoc($getProduct);
        $arr = $this->except($arr, ['product_id', 'created_at', 'updated_at', 'category_name']);

        // Thực hiện copy
        $copy = $this->model('ProductModel')->insert('product', $arr);

        if($copy) {
            $this->redirect('back', [
                'type' => 'success',
                'message' => 'Nhân bản thành công sản phẩm'
            ]);
        } else {
            $this->redirect('back', [
                'type' => 'danger',
                'message' => 'Nhân bản không thành công, vui lòng thử lại'
            ]);
        }
    }

    public function destroy($id) {
        $delete = $this->model('ProductModel')->destroy('product', $id);

        if($delete) {
            $_SESSION['message'] = [
                'type' => 'success',
                'message' => "Xoá thành công sản phẩm ${id}"
            ];
        } else {
            $_SESSION['message'] = [
                'type' => 'danger',
                'message' => "Xoá sản phẩm ${id} không thành công, vui lòng thử lại"
            ];
        }

    }
}