<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url('css/main.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/product/index.css') ?>">

</head>
<body>
<main>

    <?php include(APPPATH . 'Views/components/sidebar/sidebar.php') ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success message-crud" id="message-type-success" role="alert"
                     style="display: none">
                    <span id="message-type-text-success"></span>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary"  onclick="openModalAddProduct()">
                    Agregar Producto
                </button>
            </div>
            <div class="col-12 mt-5">
                <form id="filterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="title" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titleFilter" name="title">
                        </div>

                        <div class="col-md-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="priceFilter" name="price">
                        </div>
                        <div class="col-md-3">
                            <label for="created_at" class="form-label">Fecha creacion</label>
                            <input type="text" class="form-control" id="createdFilter" name="createdFilter"
                                   placeholder="yyyy-MM-dd HH:mm">
                        </div>
                        <div class="col-md-3" style="margin-top: 30px;">
                            <button type="button" class="btn btn-primary" onclick="loadProductTable({page: 1})">
                                Filtrar
                            </button>
                            <a href="/producto" class="btn btn-secondary">Limpiar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div id="table-container"></div>

        </div>

    </div>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('js/product/index.js') ?>"></script>
<script src="<?= base_url('js/product/crud.js') ?>"></script>

<?php include(APPPATH . 'Views/components/product/modalCreateProduct.php') ?>
<?php include(APPPATH . 'Views/components/product/modalEditProduct.php') ?>
<?php include(APPPATH . 'Views/components/product/modalDeleteProduct.php') ?>

</body>
</html>
