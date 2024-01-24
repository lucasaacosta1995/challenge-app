
<!-- Modal para agregar producto -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger  message-crud" id="message-type-danger" role="alert"
                     style="display: none">
                    <span id="message-type-text-danger"></span>
                </div>
                <!-- Contenido del formulario para agregar el producto -->
                <form id="addProductForm">
                    <!-- Campos del formulario -->
                    <div class="mb-3">
                        <label for="productName" class="form-label">Titulo del Producto</label>
                        <input type="text" name="title" class="form-control" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Precio</label>
                        <input type="number" name="price" class="form-control" id="price" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Producto</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>