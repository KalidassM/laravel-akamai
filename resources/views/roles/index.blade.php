@extends('layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Role Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Role Management</li>
        </ol>
      </div>
    </div>
    @if ($message = Session::get('success'))
      <div class="row mb-3 mt-4">
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-check"></i> Success!</h5>
          {{ $message }}
        </div>
      </div>
    @endif
  </div>
</section> 

<section class="content">
   <div class="card">
      <div class="card-header">
        <h3 class="card-title">Role Management</h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="btn btn-block bg-gradient-success btn-sm" href="{{ route('roles.create') }}">Create New Role</a>
              </li>
            </ul>
        </div>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
          <thead>
              <tr>
                <th style="width: 8%">Sno</th>
                <th style="width: 20%">Role Name</th>
                <th style="width: 30%">Action</th>
              </tr>
          </thead>
          <tbody>
              <?php $i=1; ?>
              @foreach ($roles as $key => $role)
              <tr>
                <td># <?php print $i; ?></td>
                <td>
                  <a>{{ $role->name }}</a>
                </td>

                <td class="project-actions">
                  <a class="btn btn-primary btn-sm" href="{{ route('roles.show',$role->id) }}">
                    <i class="fas fa-folder"></i>View
                  </a>
                  @can('role-edit')
                  <a class="btn btn-info btn-sm" href="{{ route('roles.edit',$role->id) }}">
                    <i class="fas fa-pencil-alt"></i> Edit
                  </a>
                  @endcan
                  @can('role-delete')
                  <form method="POST" action="roles/{{$role->id}}" style='display:inline'>
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger btn-sm show-alert-delete-box">
                      <i class="fas fa-trash"></i> Delete
                    </button>
                  </form>
                  @endcan
                </td>
              </tr>
              <?php $i++; ?>
            @endforeach
          </tbody>
        </table>
      </div>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script type="text/javascript">
    $(".alert-dismissible").fadeTo(2000, 2000).slideUp(500, function(){
      $(".alert-dismissible").alert('close');
    });
    $('.show-alert-delete-box').click(function(event){
        var form =  $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: "Are you sure you want to delete this record?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            type: "warning",
            buttons: ["Cancel","Yes!"],
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
    $(function () {
        $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

@endsection