<?= require_once('layout/header.php'); ?>
<div class="container">
    <div class="row my-3">
        <div class="col-lg-12">
            <h3 class="text-center text-uppercase">Chi tiết sản phẩm</h3>
        </div>
    </div>

    <?php
        if(isset($_SESSION['message']) && count($_SESSION['message']) > 0) {
    ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-<?= $_SESSION['message']['type'] ?> text-center"><?= $_SESSION['message']['message'] ?></div>
        </div>
    </div>

    <?php
        unset($_SESSION['message']);
        }
    ?>

    <?php                
        if (mysqli_num_rows($data['product']) > 0) {
            while($row = mysqli_fetch_assoc($data['product'])) {
                $product = [
                    "product_id" => $row['product_id'],
                    "product_name" => $row['product_name'],
                    "image" => $row['image'],
                    "category_id" => $row['category_id'],
                    "category_name" => $row['category_name'],
                ];
            }
        }
    ?>

    <div class="row">
        <div class="col-lg-12">
            <form action="http://<?= $_SERVER['HTTP_HOST'] ?>/lampart/product/update/<?= $product['product_id'] ?>" method="post" enctype="multipart/form-data">
                <div class="form-group text-center">
                    <img src="<?= "http://{$_SERVER['HTTP_HOST']}/lampart/" . $product['image'] ?>" alt="<?= $product['product_name'] ?>" width="200">
                    <input type="file" name="product_image" id="product_image" class="form-control" accept=".jpg, .png, .jpeg" />
                </div>

                <div class="form-group">
                    <label for="product_name" class="form-label">Tên SP</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" value="<?= $product['product_name'] ?>" />
                </div>

                <div class="form-group">
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <?php 
                            if (mysqli_num_rows($data['category']) > 0) {
                                while($row = mysqli_fetch_assoc($data['category'])) {
                                    $category = [
                                        "category_id" => $row['category_id'],
                                        "category_name" => $row['category_name'],
                                    ];
                        ?>
                            <option
                                value="<?= $category['category_id'] ?>"
                                <?= $product['category_id'] == $category['category_id'] ? 'selected' : '' ?>
                            >
                                <?= $category['category_name'] ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= require_once('layout/footer.php'); ?>