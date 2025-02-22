<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Add Customer</title>
</head>
<style>
    .w-10{
        width: 10%;
    }
</style>
<body>
    <div class="container mt-5">
        <div class="row mt-5 d-flex justify-content-end">
            <a href="javascript:void(0)" class="btn btn-primary w-10 me-2" data-bs-toggle="modal" data-bs-target="#addCustModal">Add Customer</a>
            <a href="{{route('dashboard')}}" class="btn btn-secondary w-10">Back</a>
        </div>

        <div class="row mt-5">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$customerData->isEmpty())
                        @foreach ($customerData as $cust)
                            <tr>
                                <td>{{$cust->name}}</td>
                                <td>{{$cust->email}}</td>
                                <td>{{$cust->phone}}</td>
                                <td>{{$cust->address}}</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-primary edit-cust-btn" data-id="{{$cust->id}}" id="">Edit</a>
                                    <a href="{{route('deleteCust',['id'=>$cust->id])}}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center">
                                No data found !!
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{$customerData->links()}}
        </div>
    </div>

    {{-- Add Customer Modal --}}

    <div class="modal" id="addCustModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Customer Details</h5>
            </div>
            <form id="add-cust-form" action="{{route('saveCust')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="custname" name="custname">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Email:</label>
                        <input type="email" class="form-control" id="custmail" name="custmail">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Phone:</label>
                        <input type="number" class="form-control" id="custphone" name="custphone">
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Address:</label>
                        <textarea class="form-control" id="custaddress" name="custaddress"></textarea>
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

      {{-- Edit customer modal --}}

      <div class="modal" id="editCustModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Customer Details</h5>
            </div>
            <form id="edit-cust-form" action="{{route('updateCust')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="editcustname" name="editcustname">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Email:</label>
                        <input type="email" class="form-control" id="editcustmail" name="editcustmail">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Phone:</label>
                        <input type="number" class="form-control" id="editcustphone" name="editcustphone">
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Address:</label>
                        <textarea class="form-control" id="editcustaddress" name="editcustaddress"></textarea>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="custid" id="custid">
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
            $('#add-cust-form').validate({
              rules:{
                  custname: {
                      required:true,
                  },
                  custmail:{
                    required:true,
                    remote:{
                        url:'{{route('checkMail')}}',
                        method:'GET',
                        data:{
                            mail:function(){
                                return $('#custmail').val();
                            },
                            from:'add',
                        }
                    }
                  },
                  custphone:{
                    required:true,
                  },
                  custaddress:{
                    required:true,
                  },
              },
              messages:{
                required: 'This field required',
                remote: 'Mail already exist',
              },
              errorElement: "span",
              errorPlacement: function(error, element) {
                error.addClass("text-danger");
                element.closest(".form-group").append(error);
            },
          });
          $('#save-btn').click(function(){
            if($('#add-cust-form').valid()){
                $('#add-cust-form').submit();
            }
          });

            $('.edit-cust-btn').click(function(){
            var id = $(this).data('id');
            $.ajax({
                url:'{{route('getCustData')}}',
                method: 'GET',
                data:{
                    id:id,
                },
                success:function(response){
                    $('#editcustname').val(response.name);
                    $('#editcustmail').val(response.email);
                    $('#editcustphone').val(response.phone);
                    $('#editcustaddress').val(response.address);
                    $('#custid').val(response.id);

                    $('#editCustModal').modal('show');
                }
            });
            });


          $('#edit-product-form').validate({
              rules:{
                  editcustname: {
                      required:true,
                  },
                  editcustmail:{
                    required:true,
                    remote:{
                        url:'{{route('checkMail')}}',
                        method:'GET',
                        data:{
                            mail:function(){
                                return $('#custmail').val();
                            },
                            from:'edit',
                            id:function(){
                                return $('#custid').val();
                            }
                        }
                    }
                  },
                  editcustphone:{
                    required:true,
                  },
                  editcustaddress:{
                    required:true,
                  },
              },
              messages:{
                required: 'This field required',
                remote: 'Mail already exist',
              },
              errorElement: "span",
              errorPlacement: function(error, element) {
                error.addClass("text-danger");
                element.closest(".form-group").append(error);
            },
          });
          $('#update-btn').click(function(){
            if($('#edit-cust-form').valid()){
                $('#edit-cust-form').submit();
            }
          });
        });

      </script>
</body>
</html>