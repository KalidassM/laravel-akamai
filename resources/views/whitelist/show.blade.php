@extends('layouts.app')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">View IP's Detail</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('whitelist.index') }}">IP's List</a></li>
            <li class="breadcrumb-item active">View IP's Detail</li>
        </ol>
      </div>
    </div>
  </div>
</section>


<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List</h3>
            <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-block bg-gradient-success btn-sm" href="{{ route('whitelist.index') }}">Back</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body p-0">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>IPV4</td>
                    <td>{{ $whitelist->ipv4 }}</td>
                </tr>
                <tr>
                    <td>IPV6</td>
                    <td>{{ $whitelist->ipv6 }}</td>
                </tr>
                <tr>
                    <td>Added By</td>
                    <td>
                     <?php $users = App\Models\User::find($whitelist->user_id); ?>
                     {{ $users->name }} 
                    </td>
                </tr>
                <tr>
                    <td>Created at</td>
                    <td>{{ $whitelist->created_at->format('d-M-Y H:i A') }} </td>
                </tr>
                <tr>
                    <td>Status</td>
                    @if ($whitelist->status == 1)
                        <td>IP ADDED, DO ACTIVATE</td>
                    @elseif ($whitelist->status == 2)
                        <td>INPROGRESS</td>
                    @elseif ($whitelist->status == 3)
                        <td>SUCCESS</td>
                    @endif
                </tr>
                <tr>
                    @if ($whitelist->status == 1)
                    <td></td>
                    <?php $activate = "/whitelist/activate/".$whitelist->id; ?>
                    <td>
                        <a class="btn btn-primary" href="{{ $activate }}">DO ACTIVATE</a>
                    </td>
                    @elseif ($whitelist->status == 2)
                        <!-- <td>ACTIVATE INPROGRESS</td> -->
                    @elseif ($whitelist->status == 3)
                        <!-- <td>ACTIVATION SUCCESS</td> -->
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
</section>


@endsection
