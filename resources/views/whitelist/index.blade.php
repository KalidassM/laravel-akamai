

@extends('layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" rel="stylesheet">


@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">IP's LIST</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">IP's LIST</li>
        </ol>
      </div>
    </div>
    @if ($suc_message = Session::get('success'))
      <div class="row mb-3 mt-4">
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-check"></i> Success!</h5>
          {{ $suc_message }}
        </div>
      </div>
    @endif

    @if ($err_message = Session::get('error'))
      <div class="row mb-3 mt-4">
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> Error!</h5>
          {{ $err_message }}
        </div>
      </div>
    @endif

   <?php 
      $bothmessage = Session::get('bothmessage');
      if(isset($bothmessage) && !empty($bothmessage)) {
      foreach($bothmessage['both_message'] as $mes) { 
        if($mes['status'] == 'success') {
          $sts = 'alert-success';
          $heading = '<h5><i class="icon fas fa-check"></i> Success!</h5>';
        } else {
          $sts = 'alert-danger';
          $heading = '<h5><i class="icon fas fa-exclamation-triangle"></i> Error!</h5>';
        }
      if($mes['key'] == 'ipv4') { ?>
        <div class="row mb-3 mt-4"> 
          <div class="alert <?php print $sts; ?> alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php print $heading; ?> - IPV4 - 
            <?php print $mes['message']; ?>
          </div>
        </div>
      <?php }
      if($mes['key'] == 'ipv6') { ?>
        <div class="row mb-3 mt-4">
          <div class="alert <?php print $sts; ?> alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php print $heading; ?> - IPV6 - 
            <?php print $mes['message']; ?>
          </div>
        </div>
      <?php }
      }
     }
   ?>
  </div>
</section>


<section class="content">
   <div class="card">
      <div class="card-header">
        <h3 class="card-title">IP's List</h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="btn btn-block bg-gradient-success btn-sm" href="{{ route('whitelist.create') }}">ADD IP</a>
              </li>
            </ul>
        </div>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
          <thead>
            <tr>
              <th style="width: 10%"> #</th>
              <th style="width: 15%">IPV4</th>
              <th style="width: 20%">IPV6</th>
              <th style="width: 15%">ADDED BY</th>
              <th style="width: 18%">CREATED AT</th>
              <th style="width: 12%">STATUS</th>
              <th style="width: 10%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; ?>
            @foreach ($whitelists as $list)
              <?php $users = App\Models\User::find($list->user_id); ?>
                <tr>
                  <td># <?php print $i; ?></td>
                  <td><a>{{ $list->ipv4 }}</a></td>
                  <td><a>{{ $list->ipv6 }}</a></td>
                  <td>{{ $users->name }} </td>
                  <td>{{ $users->created_at->format('d-M-Y') }} </td>
                  @if ($list->status == 1)
                    <td>IP ADDED, DO ACTIVATE</td>
                  @elseif ($list->status == 2)
                    <td>INPROGRESS</td>
                  @elseif ($list->status == 3)
                    <td>SUCCESS</td>
                  @endif
                  <td class="project-actions text-right">
                      <a class="btn btn-primary btn-sm" href="{{ route('whitelist.show',$list->id) }}">
                      <i class="fas fa-folder"></i> View
                      </a>
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
    // $(".alert-dismissible").fadeTo(2500, 2500).slideUp(2500, function(){
    //   $(".alert-dismissible").alert('close');
    // });
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