@extends('layouts.app')


@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">View Role</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles Management</a></li>
            <li class="breadcrumb-item active">View Role</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">View Role</h3>
            <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-block bg-gradient-success btn-sm" href="{{ route('roles.index') }}">Back</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body p-0">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>Role Name</td>
                    <td>{{ $role->name }}</td>
                </tr>
                <tr>
                    <td>Permissions</td>
                    <td>
                        
                        @if(!empty($rolePermissions))
                            @foreach($rolePermissions as $v)
                                <label class="badge badge-success">{{ $v->name }}</label>
                            @endforeach
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

@endsection