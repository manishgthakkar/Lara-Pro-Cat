@extends('layouts.app')
@section('content')

<div class="container mt-2">
  <div class="row">
    <div class="col-md-6 margin-tb">
      <div class="pull-left">
        <h2>Category</h2>
      </div>
    </div>
    <div class="col-md-8 pb-2">
      <div class="text-left mb-2">
        <a class="btn btn-success" href="{{ route('categories.create') }}"> Create Category</a>
      
        <a href="#" class="btn btn-danger" id="deleteAllSelectedRecord">Delete</a>
      </div>
    </div>
</div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card-body">

        <table class="table table-bordered" id="datatable-crud">
           <thead>
              <tr>
                {{-- <th>id</th> --}}
                 <th><input type="checkbox" class="checkbox_ids" name="ids" id="selectall"></th>
                 <th>Category Name</th>
                 <th>Category Image</th>
                 <th>Parent Category</th>
                 <th>Action</th>
              </tr>
           </thead>
        </table>

    </div>
   
</div>
<script type="text/javascript">
$(document).on('click','#selectall', function() {
	$("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});
  $(document).on('click','#deleteAllSelectedRecord', function() {
    var id = [];
    if(confirm("Are you sure you want to Delete this data ?")){
      $(".category_checkbox:checked").each(function(){
        id.push($(this).val());
      });
      
      if(id.length > 0){
        // alert("success");

        $.ajax({
          url: "{{route('category.removeAll')}}",
          headers: {'X-CSRF-TOKEN' : $('meta[name = "csrf-token"]').attr('content')},
          method: "get",
          data: {id: id},
          success : function(data){
            console.log(data);
            $('input[type=checkbox]').attr('checked', false);
            $('#datatable-crud').DataTable().ajax.reload();
          },
          error: function(data){
            var errors= data.responseJSON;
            console.log(errors);
          }
        });
      }else{
        alert("Please select at least one checkbox");
      }
    }
  });
     
 $(document).ready( function () {
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    $('#datatable-crud').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('categories') }}",
           columns: [
            // { data: 'id', name: 'id' },
                    { data: 'checkbox', name: 'checkbox',orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'image', name: 'image' },
                    { data: 'parent_cat', name: 'parent_cat' },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                 ],
                 order: [[0, 'desc']]
       });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-category') }}",
            data: { id: id},
            dataType: 'json',
            success: function(res){

              var oTable = $('#datatable-crud').dataTable();
              oTable.fnDraw(false);
           }
        });
       }

     });
  });

</script>
@endsection