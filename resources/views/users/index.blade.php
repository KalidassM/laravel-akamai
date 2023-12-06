@extends('layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" rel="stylesheet">


@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Users Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Users Management</li>
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
        <h3 class="card-title">Users</h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="btn btn-block bg-gradient-success btn-sm" href="{{ route('users.create') }}">Create New User</a>
              </li>
            </ul>
        </div>
      </div>
      <div class="card-body">
          <table id="example1" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
            <thead>
               <tr>
                  <th style="width: 8%">
                    #
                  </th>
                  <th style="width: 20%">
                    Name 
                  </th>
                  <th style="width: 30%">
                    Email
                  </th>
                  <th>
                    Role
                  </th>
                  <!-- <th style="width: 5%" class="text-center">
                     Status
                  </th> -->
                  <th class="text-center" style="width: 30%">Action</th>
               </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @foreach ($data as $key => $user)
               <tr>
                  <td># <?php print $i; ?></td>
                  <td>
                    <a>{{ $user->name }}</a>
                    <br>
                    <small>Created on {{ $user->created_at->format('M. Y') }}</small>
                  </td>
                  <td>
                    {{ $user->email }}
                  </td>
                  <td class="project_progress">
                  @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                      <label class="badge bg-success">{{ $v }}</label>
                    @endforeach
                  @endif
                  </td>
                  <!-- <td class="project-state">
                    <span class="badge badge-success">Success</span>
                  </td> -->
                  <td class="project-actions text-right">
                    <a class="btn btn-primary btn-sm" href="{{ route('users.show',$user->id) }}">
                     <i class="fas fa-folder"></i> View
                    </a>
                    <a class="btn btn-info btn-sm" href="{{ route('users.edit',$user->id) }}">
                      <i class="fas fa-pencil-alt"></i> Edit
                    </a>
                     <!-- {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                     {!! Form::close() !!} -->

                    <form method="POST" action="users/{{$user->id}}" style='display:inline'>
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-danger btn-sm show-alert-delete-box">
                        <i class="fas fa-trash"></i> Delete
                      </button>
                    </form>

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