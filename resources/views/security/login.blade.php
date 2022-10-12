
<!DOCTYPE html>
<html>

<head>
     <!-- desktop favicon -->
    <link rel="icon" type="image/png" sizes="16x16"     href="{{asset('Storage/logo.png?90')}}">
    <link rel="icon" type="image/png" sizes="32x32"     href="{{asset('Storage/logo.png?90')}}">
    <link rel="icon" type="image/png" sizes="48x48"     href="{{asset('Storage/logo.png?90')}}">
    <!-- android favicon -->
    <link rel="icon" type="image/png" sizes="192x192"   href="{{asset('Storage/logo.png?90')}}">
    <link rel="icon" type="image/png" sizes="512x512"   href="{{asset('Storage/logo.png?90')}}">
    <!-- apple ios -->
    <link rel="apple-touch-icon"      sizes="180x180"   href="{{asset('Storage/logo.png?90')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('APP_NAME') }} | Inicio de Sesion</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>

    .demo {
        background-image: url("{{ asset('dist/img/background-j.jpg') }}");
        background-size: cover;
        background-position: center center;    
    }
    .disconnect{
        background: rgb(69,69,69);
        background: linear-gradient(7deg, rgba(69,69,69,1) 0%, rgba(194,194,194,1) 100%);
        display:block;
        color: white;
        width: 32px;
        height:32px;
        text-align:center;
        padding-top:6px;
        position:fixed;
        border-radius:5px;
        top:50%;
        right:5px;
    }
     .disclaimer{
            visibility:hidden;
        }
    </style>
</head>

<body class="hold-transition login-page demo">
    <div class="login-box">
       
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body" style="text-align: center">
                <p class="login-box-msg" > <STRONG> <H2 style="font-family:Avenir;text-align: center">MAK & CIA ABOGADOS</H2></STRONG> INGRESO A USUARIOS</p>

                <form action="{{ route('login.auth') }}" method="post" class="login">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" name="auth_user" class="form-control" placeholder="Usuario">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="auth_pass" class="form-control" placeholder="Clave de Acceso">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesion</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="#" class="for">Olvido su Clave de Acceso?4</a>
                
                <form action="{{ asset('forgot') }}" style="display:none" class="forgot" method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control" placeholder="Correo Electronico">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Recuperar Clave</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <a href="#" class="log" style="display:none">Volver al Login</a>
                </form>
                <br/>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>

    $('.for').click(function(){
        $('.forgot').fadeIn();
        $('.login').hide();
        $('.for').hide();
        $('.log').fadeIn();
    });
    $('.log').click(function(){
        $('.login').fadeIn();
        $('.forgot').hide();
        $('.log').hide();
        $('.for').fadeIn();
    });

    @if(session('result')!==null)

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'warning',
                title: '&nbsp;{{ session("result") }}'
            })
        
    @endif
    </script>
</body>

</html>