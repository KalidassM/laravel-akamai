<x-laravel-ui-adminlte::adminlte-layout>


<body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ url('/home') }}"><img src="{{ asset('images/cohesity_logo_black.svg') }}" alt="AdminLTE Logo" class="brand-image"></a>
            </div>

            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Verify Your Email Address</p>
                    
                    <div class="box-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">A fresh verification link has been sent to
                                your email address
                            </div>
                        @endif
                        <p>Before proceeding, please check your email for a verification link.If you did not receive
                            the email,</p>
                            <a href="#" class="btn btn-info btn-sm"
                               onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                                click here to request another.
                            </a>
                            <form id="resend-form" action="{{ route('verification.resend') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                    </div>
                </div>
                <!-- /.form-box -->
            </div><!-- /.card -->

            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
