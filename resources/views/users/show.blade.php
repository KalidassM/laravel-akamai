@extends('layouts.app')


@section('content')


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">View User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users Management</a></li>
            <li class="breadcrumb-item active">View User</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Users</h3>
            <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-block bg-gradient-success btn-sm" href="{{ route('users.index') }}">Back</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body p-0">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>Roles</td>
                    <td>
                        @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                                <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
        
@endsection