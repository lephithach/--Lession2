<?= require_once('layout/header.php'); ?>
<div class="container">
    <div class="row my-3">
        <div class="col-lg-12">
            <h3 class="text-center text-uppercase">Danh sách sản phẩm</h3>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-lg-12 d-flex justify-content-center">
            <a href="<?= "http://{$_SERVER['HTTP_HOST']}/lampart/product/create" ?>" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form action="#" method="post" id="formSearch">
                <div class="form-group">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Tìm kiếm"
                        name="search"
                        id="search"
                        value="<?= !empty($data['pagination']['search']) ? $data['pagination']['search'] : "" ?>"
                    />
                </div>
            </form>
        </div>
    </div>

    <script>
        const formSearch = document.querySelector('#formSearch');

        formSearch.addEventListener('submit', (e) => {
            e.preventDefault();

            window.location.href = `<?= "http://{$_SERVER['HTTP_HOST']}/lampart/product/page/1/" ?>${search.value}`;
        });
    </script>

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
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Tên SP</th>
                    <th scope="col">Danh mục</th>
                    <th scope="col">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        if(mysqli_num_rows($data['product']) > 0) {
                            while($row = mysqli_fetch_assoc($data['product'])) {
                    ?>

                    <tr class="text-center align-center">
                        <th scope="row"><?= $row['product_id'] ?></th>
                        <td><img src="<?= "http://{$_SERVER['HTTP_HOST']}/lampart/" . $row['image'] ?>" alt="<?= $row['product_name'] ?>" width="40" /></td>
                        <td><?= $row['product_name'] ?></td>
                        <td><?= $row['category_name'] ?></td>
                        <td>
                            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/lampart/product/show/<?= $row['product_id'] ?>" class="btn">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/lampart/product/copy/<?= $row['product_id'] ?>" class="btn">
                                <i class="bi bi-clipboard-plus-fill"></i>
                            </a>

                            <a href="#" data-id="<?= $row['product_id'] ?>" class="btn btn-delete">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </td>
                    </tr>

                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    <li class="page-item <?= $data['pagination']['currentPage'] == 1 ? "disabled" : "" ?>">
                        <a
                            class="page-link"
                            href="<?= $data['pagination']['previousPage'] ?>"
                        >Previous</a>
                    </li>

                    <?php 
                        if(!empty($data['pagination']) && $data['pagination']['totalPage'] > 0) {
                            for($i = 1; $i <= $data['pagination']['totalPage']; $i++) {

                                // Xử lý href
                                $href = "http://{$_SERVER['HTTP_HOST']}/lampart/product/page/${i}";
                                if(!empty($data['pagination']['search'])) {
                                    $href .= "/{$data['pagination']['search']}";
                                }

                    ?>
                        <li class="page-item <?= $i == $data['pagination']['currentPage'] ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $href ?>"><?= $i ?></a>
                        </li>

                    <?php
                            }
                        }
                    ?>

                    <li class="page-item <?= $data['pagination']['currentPage'] == $data['pagination']['totalPage'] ? "disabled" : "" ?>">
                        <a
                            class="page-link"
                            href="<?= $data['pagination']['nextPage'] ?>"
                        >Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    var btnDeleteList = document.querySelectorAll('.btn-delete');

    btnDeleteList.forEach(btnDelete => {
        btnDelete.addEventListener('click', e => {
            e.preventDefault();
            let id = 0;

            if(e.target.className == 'bi bi-trash-fill') {
                id = e.path['1'].getAttribute('data-id');
            } else {
                id = e.target.getAttribute('data-id');
            }

            let isComfirm = confirm(`Bạn có muốn xoá sản phẩm ID = ${id}`);

            if(isComfirm) {
                $.ajax({
                    type: "POST",
                    url: `http://<?= $_SERVER['HTTP_HOST'] ?>/lampart/product/destroy/${id}`,
                    data: {},
                    success: function(data, status){
                        if(status == "success"){
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
<?= require_once('layout/footer.php'); ?>