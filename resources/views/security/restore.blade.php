
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('APP_NAME') }} | Recuperar Clave de Acceso</title>
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
    </style>
</head>

<body class="hold-transition login-page demo">
    <div class="login-box">
   
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                 <p class="login-box-msg" > <STRONG> <H2 style="font-family:Avenir;text-align: center">MAK & CIA ABOGADOS</H2></STRONG> </p>
               

                <form action="{{ asset('processor_restore') }}" class="forgot" method="post">
                    {{ csrf_field() }}
                 
                    <input type="hidden" name="tik"  value="{{ base64_encode($user[0]->id) }}">  
                    <div class="input-group mb-3">
                        <input class="form-control em" required type="password" name="pass" placeholder="Nueva Contraseña">                
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                    <input class="form-control em2" required type="password" placeholder="Confirme su Contraseña">   
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                    </div>
                
                              
                
			  
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Reestablecer Contraseña</button>
                        </div>
                        <!-- /.col -->
                    </div>

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

    $(document).ready(function(){
        $('.em').keyup(function(){
            if($('.em').val()==$('.em2').val()){
                $('.em').addClass('iv');
                $('.em').removeClass('ii');
            }else{
                $('.em').addClass('ii');
                $('.em').removeClass('iv');
            }
        });

        $('.em2').keyup(function(){
            if($('.em').val()==$('.em2').val()){
                $('.em').addClass('iv');
                $('.em').removeClass('ii');
            }else{
                $('.em').addClass('ii');
                $('.em').removeClass('iv');
            }
        });

        $('.forgot').submit(function(e){
            if($('.em').hasClass('ii')){
                alert('error, passwords do not match');
                e.preventDefault();
            }else{
                if($('.em').val().length<8){
                    alert('error, the password must be at least 8 characters');
                    e.preventDefault();
                }else{
                    return true;
                }
            }
        })
    })
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