@extends('layouts.app')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Role</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles Management</a></li>
          <li class="breadcrumb-item active">Edit Role</li>
        </ol>
      </div>
    </div>
    @if (count($errors) > 0)
        <div class="row mb-3 mt-4">
            <div class="alert alert-danger alert-dismissible">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        </div>
    @endif
  </div>
</section>

<section class="content">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Role</h3>
        </div>
        {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputName">Role Name</label>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputName">Permission</label>
                        @foreach($permission as $value)
                            <div class="custom-checkbox">
                                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                {{ $value->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-default float-right">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>

@endsection