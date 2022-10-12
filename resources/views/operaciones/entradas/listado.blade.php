@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nueva Entrada</button>
                <br>
              <table id="example" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Login</th>
                  <th>Email</th>
                  <th>Rol</th>
                  <th>Creado</th>
                  <th>Actualizado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->          
    </div>
    @include('operaciones.entradas.modals.registro')
    @include('operaciones.entradas.modals.edicion')
@stop

@section('scripts-bottom')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>

    <script>


        $(document).on('click','.edit',function(){
            var id= $(this).attr('data-id');
            
            $.get('{{ asset("admin/users/get") }}/'+id,function(d){
                $(".frme_0001 input[name='c01']").val(d.nombres);
                $(".frme_0001 input[name='c02']").val(d.apellidos).trigger('change');
                $(".frme_0001 input[name='c03']").val(d.login.substring(0,10));
                $(".frme_0001 input[name='c04']").val(d.email).trigger('change');
                $(".frme_0001 select[name='c05']").val(d.id_rol).trigger('change');
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });

        
        $('.delete').click(function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("bancos/eliminar") }}/'+id;
            }
        });

        $(document).ready(function(){

            function Padder(len, pad) {
                if (len === undefined) {
                    len = 1;
                } else if (pad === undefined) {
                    pad = '0';
                }

                var pads = '';
                while (pads.length < len) {
                    pads += pad;
                }

                this.pad = function(what) {
                    var s = what.toString();
                    return pads.substring(0, pads.length - s.length) + s;
                };
            }

            $('title').html('{{ $titulo }}');
            $('#example').DataTable({
                processing: true,
                paging: true,
                ajax: {
                    url: '{{ route("dashboard.users.data") }}',
                    dataSrc: 'data'
                },
                columnDefs: [
                    {
                    pageLength: 5,
                    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]]
                    }
                ],
                "columns": [
                    {
                        "data": "id",
                        "render": function (data){
                            let id =new Padder(4);
                            return id.pad(data);
                        }
                    },
                    { "data": "nombres" },
                    { "data": "apellidos" },
                    {
                        "data": null,
                        "render": function (data) {
                            let html =''; 
                            if(data.estado==1){
                                html = '<span class="badge badge-success">Activo</span>';
                            }else{
                                html = '<span class="badge badge-danger">Inactivo</span>'
                            }
                            return data.login+'<br>'+html;
                        }
                    },
                    { "data": "email" },
                    { "data": "rol.nombre_rol" },
                    {
                        "data": "created_at",
                        "render": function (data) {
                            return data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4)+' '+data.substring(11);
                        }
                    },
                    {
                        "data": "updated_at",
                        "render": function (data) {
                            return data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4)+' '+data.substring(11);
                        }
                    },
                    {
                        "data": "id",
                        "render": function (data) {
                            return '<button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lge" data-id="'+data+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                                    <button style="width: 32px; padding: 3px 5px !important;" title="Cambiar Estado" data-id="'+data+'" class="btn btn-success state"><i class="fa fa-sync"></i></button> \
                                    <button style="width: 26px; height:26px; padding:0px" class="btn btn-danger delete" data-id="'+data+'"><i class="fa fa-trash"></i></button>';
                        }
                    }
                ],
                lengthMenu: [[10, 25, 50, "Todos"]],
                "lengthChange": true,
                dom: 'Bfrtip',
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
                    "infoFiltered": "(Filtrado de _MAX_ total registros)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Registros",
                    "loadingRecords": '<br><br><br><br><br><br><br><br><br><br>',
                    "processing": '<img src="{{ asset("dist/img/loader.gif") }}" width="15%" /> Obteniendo Datos',
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    buttons: {
                        copyTitle: 'Copiado al Portapapeles',
                        copySuccess: {
                            _: 'Se Copiaron %d Registros to Portapapeles',
                        }
                    }
                },
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="far fa-copy"></i> Copiar',
                        copySuccess: {
                            1: "Copiado al Portapapeles",
                            _: "Se Copiaros %d Registros to Portapapeles"
                        },
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5],
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5],
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> Pdf',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5],
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Imprimir',
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5],
                            modifier: {
                                page: 'current'
                            }
                        }
                    }
                ]
            });
        });

        			
        $('.numeros').inputmask("9999999999",{ 
            placeholder:    "",
            numericInput: true 
        });	
        
        $('.texto').inputmask({ regex: "[a-zA-Z- ]*" },{ 
            placeholder:    ""
        });


        
    $(document).on('click','.delete',function(){
        if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
            var id= $(this).attr('data-id');
            window.location='{{ asset("admin/users/delete") }}/'+id;
        }
    });

    $('.login').focusout(function(){
        var value = $(this).val();
        if(value==''){
            $('.error_nit').html('Debe proporcionar el numero nit sin digito de verificacion.');
            $('.nit').removeClass('is-valid');
            $('.nit').addClass('is-invalid');
            $('.error_nit').fadeIn();
            return ;
        }
        $.post('{{ asset("admin/users/check/login") }}/'+value,{'_token':'{{ csrf_token() }}'},function(d){
            if(parseInt(d)===1){
                $('.error_nit').html('El Login proporciado ya esta registrado.');
                $('.error_nit').fadeIn();
                $('.nit').removeClass('is-valid');
                $('.nit').addClass('is-invalid');
            }else if(parseInt(d)===-1){
                $('.error_nit').html('El Login es Invalido, verifique.');
                $('.error_nit').fadeIn();
                $('.nit').removeClass('is-valid');
                $('.nit').addClass('is-invalid');
            }else{
                $('.nit').removeClass('is-invalid');
                $('.nit').addClass('is-valid');
                $('.error_nit').fadeOut();
            }
        })
    });

    $('.email').focusout(function(){
        var value = $(this).val();
        if(value==''){
            $('.error_email').html('Debe proporcionar el correo electronico.');
            $('.email').removeClass('is-valid');
            $('.email').addClass('is-invalid');
            $('.error_email').fadeIn();
            return ;
        }
        $.post('{{ asset("admin/users/check/email") }}/'+value,{'_token':'{{ csrf_token() }}'},function(d){
            if(parseInt(d)===1){
                $('.error_email').html('El Correo electronico ya esta registrado.');
                $('.error_email').fadeIn();
                $('.email').removeClass('is-valid');
                $('.email').addClass('is-invalid');
            }else if(parseInt(d)===-1){
                $('.error_email').html('El Correo electronico es Invalido, verifique.');
                $('.error_email').fadeIn();
                $('.email').removeClass('is-valid');
                $('.email').addClass('is-invalid');
            }else{
                $('.email').removeClass('is-invalid');
                $('.email').addClass('is-valid');
                $('.error_email').fadeOut();
            }
        })
    });

    $('select').on('change',function(){
        var element = $(this);
        var target = $(this).attr('data-target');
        if(element.prop('required')==true){
          if($('option:selected',element).val()==''){
            element.removeClass('is-valid'); 
            element.addClass('is-invalid');
            $('.'+target).fadeIn();
          }else{
            element.removeClass('is-invalid'); 
            element.addClass('is-valid');
            $('.'+target).fadeOut();
          }
        }
      })
      
    $('input:not(input[type=button], input[type=submit], input[type=reset], input[type=file])').on('focusout',function(){
        var element = $(this);
        var target = $(this).attr('data-target');
        if(element.prop('required')==true){
          if(element.val()==''){
            element.removeClass('is-valid'); 
            element.addClass('is-invalid');
            $('.'+target).fadeIn();
          }else{
            element.removeClass('is-invalid'); 
            element.addClass('is-valid');
            $('.'+target).fadeOut();
          }
        }
    });
    $('.trigger_formx').click(function(){
        var target = $(this).attr('target');
        var invalido = 1;
        $.each($('.'+target),function(i,v){
          if(!$(this).find(':input[required]').hasClass('is-invalid') && !$(this).find(':input[required]').hasClass('is-valid')){
            $(this).find(':input[required]').addClass('is-invalid');
          }else if($(this).find(':input[required]').hasClass('is-invalid')){
			$(this).find(':input[required]').addClass('is-invalid');
            invalido++;
          }else{
            invalido--;
          }
        });
        if(invalido>0){
          alert('Debe de verificar los campos para poder realizar el registro.');
        }else{
			//alert(invalido);
            $('.'+target).submit();
        }
    });
    $(document).on('click','.state',function(){
        var id= $(this).attr('data-id');
        window.location="{{ asset('admin/users/change') }}/"+id
    });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop