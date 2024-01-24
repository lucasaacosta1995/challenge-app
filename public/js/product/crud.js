
const setNewMessage = (message, type) => {
    $('.message-crud').hide();
    $(`#message-type-text-${type}`).html(`${message}`);
    $(`#message-type-${type}`).show(true);

    if(type == 'success') {
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

$(document).on('submit', '#addProductForm', function (event) {
    event.preventDefault();

    var productData = {
        title: $('#title').val(),
        price: $('#price').val(),
    };

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

function prepDeleteProduct(id) {
    $('#confirmDeleteBtn').attr('data-item-id', id);
    $('#deleteModal').modal('show');
}

function deleteProduct(id)
{
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/producto/delete/${id}`,
            type: 'POST',
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

function confirmDeleteBtn(id)
{
    deleteProduct(id)
        .then(function(response) {
            $('#deleteModal').modal('hide');
            setNewMessage(response.message, 'success');
            loadProductTable({page: 1});
        })
        .catch(function (error) {
            setNewMessage(error.message, 'danger');
        })
}