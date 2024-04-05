@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-6 margin-tb">
                <div class="pull-left">
                    <h2>Product</h2>
                </div>
            </div>
            <div class="col-md-8 pb-2">
                <div class="text-left mb-2">
                    {{-- <select id='category' class="form-control" style="width: 200px" name="categorys">
                        <option value="" disabled selected>--Select Category--</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                        @endforeach
                    </select> --}}
                    <select id='status' class="form-control" style="width: 200px">
                        <option value="">--Select Status--</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                    </select>
                    <a class="btn btn-success" href="{{ route('products.create') }}"> Create Product</a>

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
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Product Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

        </div>

    </div>
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('products') }}",
                    data: function(d) {
                        // d.cat_name = $('#category').val()
                        // d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image'},
                    {data: 'cat_name', name: 'cat_name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            // $('#category').change(function(e) {
            //     // e.preventDefault();
            //     table.draw();
            // });

//             $('#category').change(function(){
//             var category_id = $('#category').val();
// alert(category_id);
//             $('#datatable-crud').DataTable().destroy();

//             table.draw();   
            // });
        });
        $(document).on('click', '#selectall', function() {
            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        });
        $(document).on('click', '#deleteAllSelectedRecord', function() {
            var id = [];
            if (confirm("Are you sure you want to Delete this data ?")) {
                $(".product_checkbox:checked").each(function() {
                    id.push($(this).val());
                });

                if (id.length > 0) {
                    // alert("success");

                    $.ajax({
                        url: "{{ route('product.removeAll') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
                        },
                        method: "get",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            console.log(data);
                            $('input[type=checkbox]').attr('checked', false);
                            $('#datatable-crud').DataTable().ajax.reload();
                        },
                        error: function(data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    });
                } else {
                    alert("Please select at least one checkbox");
                }
            }
        });
        $(document).ready(function() {
            $('body').on('click', '.delete', function() {

                if (confirm("Delete Record?") == true) {
                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('delete-product') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(res) {

                            var oTable = $('#datatable-crud').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                }

            });
        });
    </script>
@endsection
