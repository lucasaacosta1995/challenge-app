/* global bootstrap: false */
(function () {
    'use strict'
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl)
    })
})()


function loadProductTable(page) {
    $.ajax({
        url: 'ajax/producto/get-product-table',
        method: 'GET',
        data: page,
        dataType: 'html',
        success: function (data) {
            $('#table-container').html(data);
            $('#pagination-container').html(data.pagination);
        },
        error: function (error) {
            console.error('Error al cargar los datos de la tabla:', error);
        }
    });
}

$(document).ready(function () {
    loadProductTable({page: 1});
});

$(document).on('input', '#search-input', function () {
    var search = $(this).val();
    loadProductTable({page: 1});
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var href = $(this).attr('href');
    var a = document.createElement('a');
    a.href = href;

    var urlParams = new URLSearchParams(a.search);
    var params = Object.fromEntries(urlParams.entries())

    loadProductTable(params);
});