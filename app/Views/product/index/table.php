<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Precio</th>
        <th>Fecha de Creación</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $product): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= $product['title'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['created_at'] ?></td>
            <td>
                <button class="btn btn-xs btn-warning">Editar</button>
                <button class="btn btn-xs btn-danger" onclick="prepDeleteProduct(<?= $product['id'] ?>)">Eliminar</button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Paginador Bootstrap -->
<div class="d-flex justify-content-center">
    <?= $pagination ?>
</div>