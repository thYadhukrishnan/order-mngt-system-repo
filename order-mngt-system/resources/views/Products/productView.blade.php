<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .w-10{
            width: 10%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row mt-5 d-flex justify-content-end">
            <a href="javascript:void(0)" class="btn btn-primary w-10 me-2" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</a>
            <a href="{{route('dashboard')}}" class="btn btn-secondary w-10">Back</a>
        </div>
        <div class="row mt-5">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$productData->isEmpty())
                        @foreach ($productData as $product)
                        <tr>
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->stock}}</td>
                            <td>{{$product->price}}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary edit-product-btn" data-id="{{$product->id}}" id="">Edit</a>
                                <a href="{{route('deleteProduct',['id'=>$product->id])}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align: center;">
                                No data found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{$productData->links()}}
        </div>
    </div>

    {{-- Add product model --}}

    <div class="modal" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Product Details</h5>
            </div>
            <form id="add-product-form" action="{{route('addProduct')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Stock:</label>
                        <input type="number" class="form-control" id="stock" name="stock">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Price:</label>
                        <input type="number" class="form-control" id="price" name="price">
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-btn">Save</button>
                </div>
            </form>
          </div>
        </div>
      </div>


      <div class="modal" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Product Details</h5>
            </div>
            <form id="edit-product-form" action="{{route('updateProduct')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="product_name" name="product_name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Stock:</label>
                        <input type="number" class="form-control" id="product_stock" name="product_stock">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Price:</label>
                        <input type="number" class="form-control" id="product_price" name="product_price">
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="product_description" name="product_description"></textarea>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="product_id" id="product_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-btn">Save</button>
                </div>
            </form>
          </div>
        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

      <script>
        $(document).ready(function(){
            $('#add-product-form').validate({
              rules:{
                  name: {
                      required:true,
                  },
                  price:{
                    required:true,
                  },
                  stock:{
                    required:true,
                  },
                  description:{
                    required:true,
                  },
              },
              messages:{
                required: 'This field required',
              },
              errorElement: "span",
              errorPlacement: function(error, element) {
                error.addClass("text-danger");
                element.closest(".form-group").append(error);
            },
          });
          $('#save-btn').click(function(){
            if($('#add-product-form').valid()){
                $('#add-product-form').submit();
            }
          });

          $('.edit-product-btn').click(function(){
            var id = $(this).data('id');
            $.ajax({
                url:'{{route('getProduct')}}',
                method: 'GET',
                data:{
                    id:id,
                },
                success:function(response){
                    $('#product_name').val(response.name);
                    $('#product_stock').val(response.stock);
                    $('#product_price').val(response.price);
                    $('#product_description').val(response.description);
                    $('#product_id').val(response.id);

                    $('#editProductModal').modal('show');
                }
            });
          });

          $('#edit-product-form').validate({
              rules:{
                  product_name: {
                      required:true,
                  },
                  product_price:{
                    required:true,
                  },
                  product_stock:{
                    required:true,
                  },
                  product_description:{
                    required:true,
                  },
              },
              messages:{
                required: 'This field required',
              },
              errorElement: "span",
              errorPlacement: function(error, element) {
                error.addClass("text-danger");
                element.closest(".form-group").append(error);
            },
          });
          $('#update-btn').click(function(){
            if($('#edit-product-form').valid()){
                $('#edit-product-form').submit();
            }
          });

        });
      </script>
</body>
</html>