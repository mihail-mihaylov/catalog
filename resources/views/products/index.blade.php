@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Products</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#create_product_modal">Add Product</button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-bordered table-hover" id="products_table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Active</th>
                    <th>Price</th>
                    <th class="col-lg-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>


    @include('products.partials.create')
    @include('products.partials.edit')

@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            var table = $("#products_table tbody");
            var createForm = $(".create_product_form");
            var editForm = $(".edit_product_form");

            $.ajaxSetup({
                cache:  false,
                async:  true,
                headers: {
                    "X-CSRF-TOKEN" : '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
            });

            loadProducts();

            function loadProducts() {
                $.ajax({
                    method: "GET",
                    url:    "http://catalog/api/products",
                    success: function(result) {
                        table.empty();
                        $.each(result, function (idx, element) {
                            addRow(element);
                        });
                    },
                });
            }

            function addRow(row) {
                table.append(
                    '<tr class="product_'+row.id+'"\>' +
                    '<td class="name">'+row.name+"</td>" +
                    '<td class="description">' + row.description+'</td>' +
                    '<td class="active">' + (row.active ? "Active" : "NonActive") + "</td>" +
                    '<td class="price">' + row.price + "</td>" +
                    '<td data-id=\"'+row.id+'\" >' +
                    '<button data-toggle="modal" data-target="#edit_product_modal" class="btn btn-primary edit_product">Edit</button> ' +
                    '<button class="btn btn-danger remove_product">Delete</button>' +
                    '</td></tr>'
                );
            }

            // Create
            createForm.submit(function (e) {
                e.preventDefault();
                createProduct();
                createForm[0].reset();
                $(".modal").modal('hide');
            });

            function createProduct() {
                var product = {
                    name: $('.create_product_form .name').val(),
                    description: $('.create_product_form .description').val(),
                    price: $('.create_product_form .price').val(),
                };

                $.ajax({
                    method: "POST",
                    url:    "http://catalog/api/products",
                    data: product,
                    success: function(data) {
                        addRow(data);
                    },
                });
            }

            // Edit
            editForm.submit(function (e) {
                e.preventDefault();
                updateProduct();
                editForm[0].reset();
                $(".modal").modal('hide');
            });

            function updateProduct() {
                var id = editForm.find("input[name='id']").val();

                var product = {
                    id: id,
                    name: editForm.find("input[name='name']").val(),
                    description: editForm.find("textarea[name='description']").val(),
                    price: editForm.find("input[name='price']").val(),
                };

                $.ajax({
                    method: "PUT",
                    url:    "http://catalog/api/products/" + id,
                    data: product,
                    dataType: 'json',
                    success: function(data) {
                        var tr = table.find(".product_" + id);
                        // console.log(tr.find('.name').val());
                        tr.find(".name").html(data.name);
                        tr.find(".description").html( data.description);
                        tr.find(".price").html(data.price);
                    },
                });
            }

            $("body").on("click",".edit_product",function() {
                var id = $(this).parent("td").data('id');
                var name = $(this).parents("tr").find('.name').text();
                var description = $(this).parents("tr").find(".description").text();
                var price = $(this).parents("tr").find(".price").text();
                editForm.find("input[name='id']").attr('value', id);
                editForm.find("input[name='name']").attr('value', name);
                editForm.find("textarea[name='description']").html( description);
                editForm.find("input[name='price']").attr('value', price);
            });

            // Delete
            $("body").on("click",".remove_product",function() {
                var id = $(this).parent("td").data('id');
                var product = $(this).parents("tr");
                $.ajax({
                    dataType: 'json',
                    type:'delete',
                    url:    "http://catalog/api/products/" + id,
                }).done(function(data) {
                    console.log('done');
                    product.remove(0);
                });
            });
        });
    </script>
@endsection

