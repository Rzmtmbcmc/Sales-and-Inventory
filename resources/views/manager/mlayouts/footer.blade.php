
<footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="#">Sales and Inventory</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>

{{--
<script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}



<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>


{{-- <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    function showPreview1(event){
    if(event.target.files.length > 0){
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("file-ip-1-preview");
      preview.src = src;
      preview.style.display = "block";
    }
  }
  </script>

<script>
    function showPreview(event){
    if(event.target.files.length > 0){
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("edit_file-ip-1-preview");
      preview.src = src;
      preview.style.display = "block";
    }
  }
  </script>


{{-- for add thesis/capstone --}}
  {{-- <script>
    $(document).ready(function(){

        ClassicEditor.create(document.querySelector("#editor1")).then(editor1 => instance1 = editor1);
        ClassicEditor.create(document.querySelector("#editor2")).then(editor2 => instance2 = editor2);

        $("#btn-submit").on('click', function(e){
            e.preventDefault();

            $.ajaxSetup({
               headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

               }
            });



             $('#category-error').html("");
             $('#department_id-error').html("");
             $('#curriculum_id-error').html("");
             $('#title-error').html("");
             $('#year-error').html("");
             $('#abstract-error').html("");
             $('#members-error').html("");
             $('#adviser-error').html("");
             $('#banner_path-error').html("");
             $('#document_path-error').html("");


             var category = $('#category option:selected').val();
           console.log("========================category========================");
           console.log(category);


           var department_id = $('#department_id option:selected').val();
           console.log("========================department_id========================");
           console.log(department_id);

           var curriculum_id = $('#curriculum_id option:selected').val();
           console.log("========================curriculum_id========================");
           console.log(curriculum_id);


           var title = $('#title').val();
           console.log("========================title========================");
           console.log(title);

           var year = $('#year option:selected').val();
           console.log("========================year========================");
           console.log(year);



           const abstract = document.querySelector("[id=editor_details1").value = instance1.getData();
           console.log("========================abstract========================");
            console.log(abstract);

            const members = document.querySelector("[id=editor_details2").value = instance2.getData();
           console.log("========================members========================");
           console.log(members);


           var adviser = $('#adviser').val();
           console.log("========================adviser========================");
           console.log(adviser);


           var banner_path = $('#file-ip-1').val();
           console.log("========================banner_path========================");
           console.log(banner_path);

           var document_path = $('#document_path').val();
           console.log("========================document_path========================");
           console.log(document_path);

           var student_id = $('#student_id').val();
           console.log("========================student_id========================");
           console.log(student_id);



           var data = new FormData(this.form);

               data.append('category', category);
               data.append('department_id', department_id);
               data.append('curriculum_id', curriculum_id);
               data.append('title', title);
               data.append('year', year);
               data.append('abstract', abstract);
               data.append('members', members);
               data.append('adviser', adviser);
               data.append('banner_path', $('#file-ip-1')[0].files[0]);
               data.append('document_path', $('#document_path')[0].files[0]);
               data.append('student_id', student_id);

           $.ajax({
                    url:"{{ route('student.submitproject') }}",
                    type:"post",
                    data:data,
                    cache:false,
                    contentType: false,
                    processData: false,
                    // dataType:"json",
                    success: function(response){

                        if(response.status == 200){
                            toastr.success('submitted successfully');
                            setTimeout(function (){
                                window.location.href ="{{ route('students.thesiscapstone') }}";

                              }, 1500);
                            }


                            if(response.errors){


                                  if(response.errors.category){
                                        $('#category-error').html(response.errors.category[0]);
                                      }
                                      if(response.errors.department_id){
                                        $('#department_id-error').html(response.errors.department_id[0]);
                                      }
                                      if(response.errors.curriculum_id){
                                        $('#curriculum_id-error').html(response.errors.curriculum_id[0]);
                                      }
                                      if(response.errors.title){
                                        $('#title-error').html(response.errors.title[0]);
                                      }
                                      if(response.errors.year){
                                        $('#year-error').html(response.errors.year[0]);
                                      }
                                      if(response.errors.abstract){
                                        $('#abstract-error').html(response.errors.abstract[0]);
                                      }
                                      if(response.errors.members){
                                        $('#members-error').html(response.errors.members[0]);
                                      }
                                      if(response.errors.adviser){
                                        $('#adviser-error').html(response.errors.adviser[0]);
                                      }
                                      if(response.errors.banner_path){
                                        $('#banner_path-error').html(response.errors.banner_path[0]);
                                      }
                                      if(response.errors.document_path){
                                        $('#document_path-error').html(response.errors.document_path[0]);
                                      }
                                      if(response.errors.student_id){
                                        $('#student_id-error').html(response.errors.student_id[0]);
                                      }


                            }

                        }


               });


        });

    });
</script>
{{--end for add thesis/capstone --}}

{{-- for edit thesis/capstone --}}
{{-- <script>
    $(document).ready(function(){

        ClassicEditor.create(document.querySelector("#edit_editor1")).then(editor1 => instance1 = editor1);
        ClassicEditor.create(document.querySelector("#edit_editor2")).then(editor2 => instance2 = editor2);

        $("#btn-updateProject").on('click', function(e){
            e.preventDefault();

            $.ajaxSetup({
               headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

               }
            });



             $('#category-error').html("");
             $('#department_id-error').html("");
             $('#curriculum_id-error').html("");
             $('#title-error').html("");
             $('#year-error').html("");
             $('#abstract-error').html("");
             $('#members-error').html("");
             $('#adviser-error').html("");
             $('#banner_path-error').html("");
             $('#document_path-error').html("");


             var category = $('#edit_category option:selected').val();
           console.log("========================category========================");
           console.log(category);


           var department_id = $('#edit_department_id option:selected').val();
           console.log("========================department_id========================");
           console.log(department_id);

           var curriculum_id = $('#edit_curriculum_id option:selected').val();
           console.log("========================curriculum_id========================");
           console.log(curriculum_id);


           var title = $('#edit_title').val();
           console.log("========================title========================");
           console.log(title);

           var year = $('#edit_year option:selected').val();
           console.log("========================year========================");
           console.log(year);



           const abstract = document.querySelector("[id=edit_editor_details1").value = instance1.getData();
           console.log("========================abstract========================");
            console.log(abstract);

            const members = document.querySelector("[id=edit_editor_details2").value = instance2.getData();
           console.log("========================members========================");
           console.log(members);


           var adviser = $('#edit_adviser').val();
           console.log("========================adviser========================");
           console.log(adviser);


           var banner_path = $('#add_file-ip-1').val();
           console.log("========================banner_path========================");
           console.log(banner_path);

           var default_banner_path = $('#edit_banner_path').val();
           console.log("========================default_banner_path========================");
           console.log(default_banner_path);


           var document_path = $('#add_document_path').val();
           console.log("========================document_path========================");
           console.log(document_path);



           var default_document_path = $('#edit_document_path').val();
           console.log("========================default_document_path========================");
           console.log(default_document_path);




           var student_id = $('#edit_student_id').val();
           console.log("========================student_id========================");
           console.log(student_id);

           var id = $('#id').val();
           console.log("========================id========================");
           console.log(id);




           var data = new FormData(this.form);

               data.append('category', category);
               data.append('department_id', department_id);
               data.append('curriculum_id', curriculum_id);
               data.append('title', title);
               data.append('year', year);
               data.append('abstract', abstract);
               data.append('members', members);
               data.append('adviser', adviser);
               data.append('banner_path', $('#add_file-ip-1')[0].files[0]);
               data.append('document_path', $('#add_document_path')[0].files[0]);
               data.append('default_banner_path', default_banner_path);
               data.append('default_document_path', default_document_path);
               data.append('student_id', student_id);
               data.append('id',id);

           $.ajax({
                    url:"{{ route('student.updateproject') }}",
                    type:"post",
                    data:data,
                    cache:false,
                    contentType: false,
                    processData: false,
                    // dataType:"json",
                    success: function(response){

                        if(response.status == 200){
                            toastr.success('updated successfully');
                            setTimeout(function (){
                                window.location.href ="{{ route('students.status') }}";

                              }, 1500);
                            }


                            if(response.errors){


                                  if(response.errors.category){
                                        $('#category-error').html(response.errors.category[0]);
                                      }
                                      if(response.errors.department_id){
                                        $('#department_id-error').html(response.errors.department_id[0]);
                                      }
                                      if(response.errors.curriculum_id){
                                        $('#curriculum_id-error').html(response.errors.curriculum_id[0]);
                                      }
                                      if(response.errors.title){
                                        $('#title-error').html(response.errors.title[0]);
                                      }
                                      if(response.errors.year){
                                        $('#year-error').html(response.errors.year[0]);
                                      }
                                      if(response.errors.abstract){
                                        $('#abstract-error').html(response.errors.abstract[0]);
                                      }
                                      if(response.errors.members){
                                        $('#members-error').html(response.errors.members[0]);
                                      }
                                      if(response.errors.adviser){
                                        $('#adviser-error').html(response.errors.adviser[0]);
                                      }
                                      if(response.errors.banner_path){
                                        $('#banner_path-error').html(response.errors.banner_path[0]);
                                      }
                                      if(response.errors.document_path){
                                        $('#document_path-error').html(response.errors.document_path[0]);
                                      }
                                      if(response.errors.student_id){
                                        $('#student_id-error').html(response.errors.student_id[0]);
                                      }


                            }

                        }


               });


        });

    });
</script> --}}

{{-- eit for edit thesis/capstone --}}


{{-- update profile --}}
{{-- <script>
    $(document).ready(function(){

        $("#btn-update-profile").on('click', function(e){
            e.preventDefault();
            $.ajaxSetup({
               headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

               }
            });

            var fullname = $('#fullname').val();
           console.log("========================fullname========================");
           console.log(fullname);

           var email = $('#email').val();
           console.log("========================email========================");
           console.log(email);

           var id = $('#id').val();
           console.log("========================id========================");
           console.log(id);



           $.ajax({
                    url:"{{ route('student.updateProfile') }}",
                    type:"post",
                    data:{
                        fullname: fullname,
                        email: email,
                        id: id,


                    },
                    dataType:"json",
                    success: function(res){

                        if(res.status == 200){
                            toastr.success('Information updated successfully.');
                            setTimeout(function (){
                                window.location.href ="{{ route('students.profile') }}";

                              }, 1500);
                            }



                            if(res.errors){

                                if(res.errors.fullname){
                                    $('#fullname-error').html(res.errors.fullname[0]);
                                    $('#fullname').removeClass("is-valid").addClass("is-valid");

                                }else{
                                    $('#fullname').removeClass("is-valid").addClass("is-valid");

                                }

                                if(res.errors.email){
                                    $('#email-error').html(res.errors.email[0]);
                                    $('#email').removeClass("is-valid").addClass("is-valid");

                                }else{
                                    $('#email').removeClass("is-valid").addClass("is-valid");

                                }



                            }

                        }


               });



        });

});
</script>
{{--end update profile --}}

{{-- for ranking --}}
{{-- <script type="text/javascript">
    $(document).ready(function(){

     load_data();
     var count = 1;
     function load_data(){

         $(document).on('click', '#btn-rank', function(e){
            e.preventDefault();
            $.ajaxSetup({
               headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

               }
            });
           var id  = $(this).data("id");
            console.log(id);

            var slug  = $(this).data("slug");
            console.log(slug);

            functionrank(id, slug);

         });

     }

      function  functionrank(id, slug){

          $.ajax({
                    url:"{{ route('students.rankcount') }}",
                    type:"post",
                    data:{
                        id: id,

                    },
                    dataType:"json",
                    success: function(res){

                        if(res.status == 200){
                            setTimeout(function (){
                                window.location.href ="{{ url('/viewmore') }}"+"/"+slug;

                              }, 100);
                            }

                        }

               });
          }

    });
</script>

<script>
      $(document).on('click', '#btn-deleteproject', function(e){
            e.preventDefault();
            $.ajaxSetup({
               headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

               }
            });

            let id = $(this).data('did');
            $('#del_id').val(id);

            let csrf = '{{ csrf_token() }}';
            if (!confirm('Are You sure want to delete this Project!')) {
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
                    url: '{{ route('project.deleteproject') }}',
                    success: function (res) {
                        if(res.status == 200){
                            setTimeout(function (){
                                window.location.href ="{{ route('students.status') }}";

                              }, 100);
                            }

                    }

            });

      }


});
</script>  --}}


</body>
</html>





{{--end for ranking --}}

