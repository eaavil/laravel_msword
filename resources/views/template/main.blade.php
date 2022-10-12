
<!DOCTYPE html>
<?php
date_default_timezone_set("America/Santiago");
?>
<html>

<head>
    
    
    <!DOCTYPE html>
<html lang="es">  
<!-- end meta generico -->
<!-- favicon-->

   


    <!--<title>Metaetiquetas útiles para acceso al escritorio</title>  
    <link rel="shortcut icon" href="https://www.eniun.com/wp-content/uploads/favicon.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="https://www.eniun.com/wp-content/uploads/emiun-apple.png">
    <meta name="description" content="Eniun. Diseño y desarrollo de webs corporativas. Servicios de marketing digital y social media. ¡Haz despegar tu negocio con nosotros! Consúltanos">
    <link rel="canonical" href="https://www.eniun.com/">
    <meta property="og:locale" content="es_ES">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Inicio - Eniun">
    <meta property="og:description" content="Eniun. Diseño y desarrollo de webs corporativas. Servicios de marketing digital y social media. ¡Haz despegar tu negocio con nosotros! Consúltanos">
    <meta property="og:url" content="https://www.eniun.com/">
    <meta property="og:site_name" content="Eniun">
    <meta property="og:image" content="https://www.eniun.com/wp-content/uploads/eniun-background-first-home.jpg">
    <meta property="og:image:secure_url" content="https://www.eniun.com/wp-content/uploads/eniun-background-first-home.jpg">
    <meta property="og:image:width" content="1913">
    <meta property="og:image:height" content="911">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:description" content="Eniun. Diseño y desarrollo de webs corporativas. Servicios de marketing digital y social media. ¡Haz despegar tu negocio con nosotros! Consúltanos">
    <meta name="twitter:title" content="Inicio - Eniun">
    <meta name="twitter:site" content="@eniun_es">
    <meta name="twitter:image" content="https://www.eniun.com/wp-content/uploads/eniun-background-first-home.jpg">
    <meta name="twitter:creator" content="@eniun_es">
   

     cierre etiquetas utiles -->
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('APP_NAME') }}</title>
   
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons 
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    -->
    
    <!-- Tempusdominus Bbootstrap 4 
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    -->
    
    <!-- iCheck 
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    -->
    

    <!-- JQVMap 
     <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    -->
   
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker 
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    -->
    
    <!-- summernote 
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    -->
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('dist/css/sanspro.css') }}">
    <!-- DataTables 
    
    -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/datatables.min.css') }}">
    <!-- Select2-->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- daterange picker
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    -->
    
    <!-- iCheck for checkboxes and radio inputs
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    -->
    
    <!-- Bootstrap Tour -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-tour/css/bootstrap-tour-standalone.css') }}">


    <style>
        .modal.fade{
            opacity: 1;
        }
        .preloader{
            background-color:white;
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:99999;
        }
        .loader {
            background: rgba(189,195,199,1);
            height: 3em;
            width: 3em;
            margin: 20% auto;
            animation: loadit 4s linear infinite;
            }
        .sub-item{
            background:#555f69 !important;
            margin-top:-4px;
            border-radius:2px
        }
        @keyframes loadit {
            55% {
                background: rgba(189,195,199,0.4);
                border-radius: 100%;
                transform: rotate(360deg);
                box-shadow: 7em 0 0 rgba(189,195,199,0.3),-7em 0 0 rgba(189,195,199,0.3),3em 0 0 rgba(189,195,199,0.3),-3em 0 0 rgba(189,195,199,0.3),0 7em 0 rgba(189,195,199,0.3),0 -7em 0 rgba(189,195,199,0.3),0 3em 0 rgba(189,195,199,0.3),0 -3em 0 rgba(189,195,199,0.3);
            }
        }
        .disclaimer{
            visibility:hidden;
        }
    </style>
    @yield('scripts-top')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="preloader">
        <div class="loader"></div>
    </div>
    <div class="wrapper">
        @include('template.navbar')

        @include('template.sidebar.main')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                 <div class="row principal ">
                        @yield('contenedor_principal')
                 </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
            
        </div>
        <!-- /.control-sidebar -->
    <!-- ./wrapper -->

    

    

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    -->
    
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip 
     <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>-->
   
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- ChartJS
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    -->
    
    <!-- Sparkline 
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    -->
    
    <!-- JQVMap 
    
        <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.colombia.js') }}"></script>
    -->

    <!-- jQuery Knob Chart 
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    -->
    
    <!-- daterangepicker
     <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    -->
   
    <!-- Tempusdominus Bootstrap 4
     <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    -->
   
    <!-- Summernote 
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    -->
    
    <!-- overlayScrollbars -->
     <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
   
    <!-- Bootstrap Tour 
    <script src="{{ asset('plugins/bootstrap-tour/js/bootstrap-tour-standalone.js') }}"></script>
    -->
    
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- Global Script Parameters App 
    
    -->
    <script src="{{ asset('dist/js/params.js') }}"></script>
    <!-- Global Functions Parameters App -->
    <script src="{{ asset('dist/js/helpers.js') }}"></script>
    <!-- Global Tours Parameters App -->
    <script src="{{ asset('dist/js/tours.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <!-- DataTables
    <script src="{{ asset('plugins/datatables-bs4/js/pdfmake.min.js') }}"></script> 
    
    -->
   <script src="{{ asset('plugins/datatables-bs4/js/datatables.min.js') }}"></script>
    
    <script src="{{ asset('plugins/datatables-bs4/js/vfs_fonts.js') }}"></script>
    <!-- AdminLTE for demo purposes 
     <script src="{{ asset('dist/js/demo.js') }}"></script>
    -->
   
    <!-- Input Mask 
    
    -->
    
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- Bootstrap Switch 
   
    -->
    
 <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script>
        $(document).ready(function() {

			function number_format (number, decimals, dec_point, thousands_sep) {
			    // Strip all characters but numerical ones.
			    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
			    var n = !isFinite(+number) ? 0 : +number,
			        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			        s = '',
			        toFixedFix = function (n, prec) {
			            var k = Math.pow(10, prec);
			            return '' + Math.round(n * k) / k;
			        };
			    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
			    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
			    if (s[0].length > 3) {
			        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
			    }
			    if ((s[1] || '').length < prec) {
			        s[1] = s[1] || '';
			        s[1] += new Array(prec - s[1].length + 1).join('0');
			    }
			    return s.join(dec);
			}

            $('.combo').select2({  theme: 'bootstrap4' })



           /* @if(\Request::route()->getName()=="dashboard")
                $.get('{{ route("utilidades.indicadores.tasas") }}',function(info){
                    $.each(info.data,function(i,v){

                        if(i!=2 && i!=9){


                        var color = "";
                        var icono = "";
                        var valor = v.valor;
                        var titulo = v.titulo;

                        if(v.tipo=='igual'){
                            color="#00a6d8";
                            icono="fa-equals";
                        }else if(v.tipo=='sube'){
                            color="#00d800";
                            icono="fa-arrow-up";
                        }else{
                            color="#d8005a";
                            icono="fa-arrow-down";
                        }

                        let html = '<div class="col-xs-6 col-md-3"> \
                                        <div class="small-box" style="background:#757575; display:block; text-align:left; color:white"> \
                                            <div class="inner"> \
                                                <h3 '+(i==3 ? 'style="font-size:23px"' : '')+' >'+valor+'</h3> \
                                                <p>'+titulo+'</p> \
                                            </div> \
                                            <div class="icon" style="display:block; color:'+color+'"> \
                                                <i class="fas '+icono+'"></i> \
                                            </div> \
                                        </div> \
                                    </div>';
                        $('.principal').append(html)

                        }
                    })
                    $('.loader-principal').fadeOut();
                })
                 let html = ' <br>\<div class="col-xs-6 col-md-3"> \
                                        <div class="small-box" style="background:#757575; display:block; text-align:left; color:white"> \
                                            <div class="inner"> \
                                                <h3 '+(3==3 ? 'style="font-size:23px"' : '')+' > PR97</h3> \
                                                <p>POLARIZADO</p> \
                                                <p>OT-001</p> \
                                                <p>$15.000</p> \
                                            </div> \
                                            <div class="icon" style="display:block; color:#00d800"> \
                                                <i class="fas fa-arrow-up"></i> \
                                            </div> \
                                        </div> \
                                    </div>';
                                    
                                    
                html+=   '<div class="col-xs-6 col-md-3"> \
                                        <div class="small-box" style="background:#757575; display:block; text-align:left; color:white"> \
                                            <div class="inner"> \
                                                <h3 '+(3==3 ? 'style="font-size:23px"' : '')+' > PR97 TIEMPO</h3> \
                                                <p>POLARIZADO</p> \
                                                <p>OT-001</p> \
                                                <p>$15.000</p> \
                                            </div> \
                                            <div class="icon" style="display:block; color:#d8005a"> \
                                                <i class="fas fa-arrow-down"></i> \
                                            </div> \
                                        </div> \
                                    </div>';                 
        $('.principal').append(html);
            $('.loader-principal').fadeOut();
            @endif
*/


            $('.help-main').click(function(){
                tourPrincipal.init();
                tourPrincipal.restart();
            })

            $('.fecha_esp').inputmask("99/9999",{
            });
            $('.precio').inputmask("$(999){+|1}",{
                placeholder:    "000000000",
                numericInput: true,
				groupSeparator: '.',
            });
			$('.numero_entero').inputmask({ 'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder':''});
			$('.numero_decimal').inputmask({ 'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'digits': 2, 'digitsOptional': false});
            /*$('.numeros').inputmask("(999){+|1}",{
                placeholder:    "000000000",
                numericInput: true
            });*/

            $('.precio-entero').inputmask("$(999){+|1}",{
                placeholder:    "000000000",
                numericInput: true
            });

            $('.preloader').fadeOut();

            $(document).on('click','.trigger_form',function(){
                id = $(this).attr('target');
                $('.'+id+' button.act_form').trigger('click');
            });

            $('.tableData').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false
            });



            $('.onumbers').keydown(function(event) {
                if (event.keyCode == 46 || event.keyCode == 8|| event.keyCode == 9)    {
                }
                else {
                        if (event.keyCode < 95) {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                                event.preventDefault();
                        }
                        }
                        else {
                            if (event.keyCode < 96 || event.keyCode > 105) {
                                event.preventDefault();
                            }
                        }
                    }
                });

            @if(session('result')!==null)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    type: '{{session("result")["type"]}}',
                    title: '&nbsp;{{session("result")["message"]}}'
                })
            @endif
        });
    </script>

	<style>
    .select2-drop li {
            white-space: pre;
        }
        th { font-size: 14px; }
        td { font-size: 14px; }
    
	</style>
    @yield('scripts-bottom')
    <div id="ultimo">
                
    </div>
</body>

</html>
