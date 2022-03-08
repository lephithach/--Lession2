<?= require_once('layout/header.php'); ?>
<div class="container">
    <div class="row my-3">
        <div class="col-lg-12">
            <h3 class="text-center text-uppercase">Thêm sản phẩm</h3>
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

    <div class="row">
        <div class="col-lg-12">
            <form action="http://<?= $_SERVER['HTTP_HOST'] ?>/lampart/product/store/" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="product_image">Ảnh sản phẩm</label>
                    <input type="file" name="product_image" id="product_image" class="form-control" accept=".jpg, .png, .jpeg" />
                </div>

                <div class="form-group">
                    <label for="product_name" class="form-label">Tên SP</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" value="" />
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
                            <option value="<?= $category['category_id'] ?>">
                                <?= $category['category_name'] ?>
                            </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= require_once('layout/footer.php'); ?>