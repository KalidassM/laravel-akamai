@extends('layouts.app')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">ADD IP</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('whitelist.index') }}">IP's List</a></li>
          <li class="breadcrumb-item active">ADD IP</li>
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
            <h3 class="card-title">Add IP</h3>
        </div>
        {!! Form::open(array('route' => 'whitelist.store','method'=>'POST')) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputName">IPV4 (49.206.114.181) </label>
                        {!! Form::text('ipv4', null, array('placeholder' => 'IPV4','class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <?php $id = Auth::user()->id; ?>
                        {{ Form::hidden('user_id',  $id)}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputName">IPV6 (2406:7400:ff03:700c::/64) </label>
                        {!! Form::text('ipv6', null, array('placeholder' => 'IPV6','class' => 'form-control')) !!}
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