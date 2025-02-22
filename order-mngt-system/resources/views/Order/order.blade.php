<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .w-10{
            width: 10%;
        }
        .a-c-c{
            align-content: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row mt-5 d-flex justify-content-end">
            <a href="javascript:void(0)" class="btn btn-primary w-10 me-2" data-bs-toggle="modal" data-bs-target="#addOrderModal">Add New Order</a>
            <a href="{{route('dashboard')}}" class="btn btn-secondary w-10 a-c-c">Back</a>
        </div>
        <div class="row mt-5">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$orderDetails->isEmpty())
                    @foreach ($orderDetails as $order)
                        <tr>
                            <td>{{$order->customer->name}}</td>
                            <td>{{$order->total_amount}}</td>
                            <td>{{$order->status}}</td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="3" style="text-align: center;">
                                No data found!!
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{$orderDetails->links()}}
        </div>

    </div>

    <div class="modal" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Order Details</h5>
            </div>
            <form id="add-order-form" action="{{route('addOrder')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Select  Customer:</label>
                        <select class="form-select" aria-label="Select Customer" name="customerName">
                            <option selected value="">--Select--</option>
                            @foreach ($customers as $cust)
                                <option value="{{$cust->id}}">{{$cust->name}}</option>
                            @endforeach
                          </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Select Products:</label>
                        <div class="row">
                            @foreach ($products as $product)
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input productCheck" type="checkbox" value="{{$product->id}}" name="product[]">
                                            <label class="form-check-label" for="">
                                              {{$product->name}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 countDiv">
                                        {{-- <input type="number" name="count[]" style="width: 55px;" value="0"> --}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
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

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

      <script>
        $(document).ready(function(){
            $('#add-order-form').validate({
                ignore:[],
              rules:{
                  customerName: {
                      required:true,
                  },
                 "product[]":{
                    required:true,
                  },
                  "count[]":{
                    required:true,
                    min:1,
                  },
              },
              messages:{
                required: 'This field required',
                "count[]":{
                    required: 'Please enter the cout',
                    min: 'Please enter a value greater than 0',
                }
              },
              errorElement: "span",
              errorPlacement: function(error, element) {
                error.addClass("text-danger");
                element.closest(".form-group").append(error);
            },
          });
          $('#save-btn').click(function(){
            if($('#add-order-form').valid()){
                $('#add-order-form').submit();
            }
          });

          $('.productCheck').click(function(){
            if($(this).is(':checked')){
                var countInput = '<input type="number" name="count[]" style="width: 55px;" value="">';
                $(this).parent().parent().parent().find('.countDiv').html(countInput);
                console.log($(this).parent().parent().parent())
            }else{
                $(this).parent().parent().parent().find('.countDiv').html("");
            }
          });
        });
      </script>
</body>
</html>