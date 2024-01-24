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

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container mt-4">
            <div class="alert alert-success message-crud" id="message-type-success" role="alert" style="display: none">
                <span id="message-type-text-success"></span>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Agregar Producto
            </button>
            <div id="table-container" ></div>
        </div>
    </main>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('js/product/index.js') ?>"></script>
<script src="<?= base_url('js/product/crud.js') ?>"></script>

<?php include(APPPATH . 'Views/components/product/modalCreateProduct.php') ?>
<?php include(APPPATH . 'Views/components/product/modalDeleteProduct.php') ?>

</body>
</html>
