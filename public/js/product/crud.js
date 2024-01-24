const setNewMessage = (message, type) => {
    $('.message-crud').hide();
    $(`#message-type-text-${type}`).html(`${message}`);
    $(`#message-type-${type}`).show(true);

    if (type === 'success') {
        setTimeout(closeMessage, 3500);
    }
}
const closeMessage = () => {
    $('.message-crud').hide("slow");
}

function saveProduct(productData) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/producto',
            type: 'POST',
            data: productData,
            dataType: 'json',
            success: function (response) {
                resolve(response);
            },
            error: function (xhr) {
                reject(xhr.responseJSON);
            }
        });
    });
}

function editProduct(id, productData) {
    console.log("asdasd")
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/producto/update/${id}`,
            type: 'POST',
            data: productData,
            dataType: 'json',
            success: function (response) {
                resolve(response);
            },
            error: function (xhr) {
                reject(xhr.responseJSON);
            }
        });
    });
}

$(document).on('submit', '#addProductForm', function (event) {
    event.preventDefault();

    var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

    var productData = {
        title: $('#title').val(),
        price: $('#price').val()
    };
    productData[csrfName] = csrfHash;

    // Guardar el producto
    saveProduct(productData)
        .then(function (response) {
            $("#addProductModal").modal('hide')
            setNewMessage(response.message, 'success');
            loadProductTable({page: 1});
        })
        .catch(function (error) {
            var errors = '';
            if (typeof error.errors !== 'undefined') {
                errors += '<ul>';
                $.each(error.errors, function (field, error) {
                    errors += `<li>${error} </li>`;
                });
                errors += `</ul>`;
            } else {
                errors = error.message;
            }

            setNewMessage(errors, 'danger');
        });
});

$(document).on('submit', '#editProductForm', function (event) {
    event.preventDefault();

    var csrfName = $('.txt_csrfname_edit').attr('name'); // CSRF Token name
    var csrfHash = $('.txt_csrfname_edit').val(); // CSRF hash

    var productData = {
        title: $('#title_edit').val(),
        price: $('#price_edit').val()
    };
    productData[csrfName] = csrfHash;

    var idEdit = $("#id_edit").val();

    // Guardar el producto
    editProduct(idEdit, productData)
        .then(function (response) {
            $("#editProductModal").modal('hide')
            setNewMessage(response.message, 'success');
            loadProductTable({page: 1});
        })
        .catch(function (error) {
            var errors = '';
            if (typeof error.errors !== 'undefined') {
                errors += '<ul>';
                $.each(error.errors, function (field, error) {
                    errors += `<li>${error} </li>`;
                });
                errors += `</ul>`;
            } else {
                errors = error.message;
            }

            setNewMessage(errors, 'danger-edit');
        });
});

function prepEditProduct(id) {
    $('#id_edit').val(id);

    getDataEditProduct(id)
        .then(function (response) {
            $("#title_edit").val(response.data.title);
            $("#price_edit").val(response.data.price);
            $('#editProductModal').modal('show');
        })
        .catch(function (error) {

        });
}

function getDataEditProduct(id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/producto/edit/${id}`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                resolve(response);
            },
            error: function (xhr) {
                reject(xhr.responseJSON);
            }
        });
    });
}

function prepDeleteProduct(id) {
    $('#confirmDeleteBtn').attr('data-item-id', id);
    $('#deleteModal').modal('show');
}

function deleteProduct(id) {
    var csrfName = $('.txt_csrfname_delete').attr('name'); // CSRF Token name
    var csrfHash = $('.txt_csrfname_delete').val(); // CSRF hash

    var dataSend = {};
    dataSend[csrfName] = csrfHash;
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/producto/delete/${id}`,
            type: 'POST',
            data: dataSend,
            dataType: 'json',
            success: function (response) {
                resolve(response);
            },
            error: function (xhr) {
                reject(xhr.responseJSON);
            }
        });
    });
}

function confirmDeleteBtn(id) {
    deleteProduct(id)
        .then(function (response) {
            $('#deleteModal').modal('hide');
            setNewMessage(response.message, 'success');
            loadProductTable({page: 1});
        })
        .catch(function (error) {
            setNewMessage(error.message, 'danger');
        })
}