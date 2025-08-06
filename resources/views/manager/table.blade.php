@extends('admin.alayouts.main')
@section('content')


<div class="content-wrapper">
  <div id="loader"></div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <h1>Dashboard</h1> --}}
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Home</a></li>
              {{-- <li class="breadcrumb-item">Dashboard</li> --}}
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-10"><h2><b>List of Department</b></h2></div>
                    <div class="col-md-2"><button type="button" class="btn btn-success"
                         data-toggle="modal" data-target="#modal-adddepartment">Add Department</button></div>
                    @include('admin.modal.adddepartment')
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-hover data-table3">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th width="100px">Action</th>

                        </tr>
                    </thead>
                     <tbody>
                    </tbody>
                </table>
              </div>
            </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
 @include('admin.modal.editdepartment')


  @endsection
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




  <script type="text/javascript">

  $(document).ready(function(){

    //view all archive

      var table = $('.data-table3').DataTable({


          processing: true,

          serverSide: true,

          ajax: "{{ route('admin.departmentlist') }}",

          columns: [

              {data: 'id', name: 'id'},

              {data: 'name', name: 'name'},

              {data: 'description', name: 'description'},

              {data: 'action', name: 'action', orderable: false, searchable: false},

          ]

      });

         //end view all archive


    //add  department



        $('body').on('click', '#btn-adddepartment', function(e){

                e.preventDefault();
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                $('#name-error').html("");
                $('#description-error').html("");

                let name = $('#name').val();
                let description = $('#description').val();

                $.ajax({
                    url: '{{ route("admin.adddepartment") }}',
                    method: 'post',
                    data: {
                        name: name,
                        description: description,

                    },
                    success: function(data){

                        console.log(data);
                            if(data.errors) {
                                if(data.errors.name){
                                    $('#name-error').html(data.errors.name[0]);
                                }
                                if(data.errors.description){
                                    $('#description-error').html(data.errors.description[0]);
                                }

                            }
                        // console.log(response.status == "Success");
                        if(data.status == 200){

                        $('#mgs').html('<div class="alert alert-success">Add Department Successfully!</div>');
                            setTimeout(function(){
                                $('.data-tabl3').DataTable().ajax.reload();
                                $("#modal-adddepartment").modal('hide');
                                window.location.reload();
                            }, 2000);
                    }
                    if(data.errors) {
                        console.log("Failed");

                    }

                },
              });
         });
      //end add  department

      ///get id


      $('.modelClose').on('click', function(){
                $('#modal-viewstudent').hide();
            });


         var name
         var description
         var id

        $('body').on('click', '.btn-editdepartment', function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            name = $(this).data('name');
            console.log("=================name===============");
            console.log(name);

            description = $(this).data('desc');
            console.log("=================description===============");
            console.log(description);


            id = $(this).data('id');
            console.log("=================id===============");
            console.log(id);


            $('#edit_name').val(name);
            $('#edit_description').val(description);
            $('#edit_id').val(id);


        });

        ///end get id


          //edit edit department
          $('body').on('click', '#btn-updatedepartment', function(e){

                e.preventDefault();
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                let name = $('#edit_name').val();
                let description = $('#edit_description').val();
                let id =  $('#edit_id').val();


                $.ajax({
                    url: '{{ route("admin.updatedepartment") }}',
                    method: 'post',
                    data: {
                        name: name,
                        description: description,
                        id: id
                    },
                    success: function(response){
                        // console.log(response.status == "Success");
                        if(response.status == 200){

                           $('#mgs').html('<div class="alert alert-success">Update Department Successfully!</div>');
                             setTimeout(function(){
                                $('.data-tabl3').DataTable().ajax.reload();
                                $("#modal-editdepartment").modal('hide');
                                window.location.reload();
                            }, 2000);
                    }
                    if(response.errors) {
                        console.log("Failed");

                    }

                },
             });
          });
         //end edit department

          //delete department
          $('body').on('click', '.btn-deleteDepartment', function (e) {

                let id = $(this).data('del');
                $('#del_id').val(id);

                let csrf = '{{ csrf_token() }}';
                if (!confirm('Are You sure want to delete this Department!')) {
                    e.preventDefault();
                }else{

                    $.ajax({
                        type: "DELETE",
                        data: {
                                id: id,
                                _token: csrf
                            },
                        cache: false,
                        dataType: 'json',
                        url: '{{ route("admin.deletedepartment") }}',
                        success: function (res) {
                            if (res.status == 200) {
                                toastr.success('Delete Department Successfully!', 'Success!', {timeOut: 2000})
                                $('.data-table3').DataTable().ajax.reload();
                            }
                        }

                    });

                }
          });

//end delete department


    });

  </script>