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
                  <th>Rol</th>
                  <th>Descripcion</th>
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
    @include('acceso.roles.modals.registro')
    @include('acceso.roles.modals.edicion')
    @include('acceso.roles.modals.permisos')
@stop

@section('scripts-bottom')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>

    <script>

        $(document).on('click','.per',function(){
            var id= $(this).attr('data-id');
            $('.frmp_0001 input[name="id"]').val(id);
            var title= $(this).attr('data-title');
            $('.titt').text(title);
            $.get('{{ asset("admin/permissions") }}/'+id,function(d){
                $(".permisos").html('');
                $.each(d.data,function(i,v){
                    let html = '<li class="list-group-item"> \
                                    <div class="row"> \
                                        <div class="col-8">'+v.seccion+'</div> \
                                        <div class="col-1"><input '+(v.lectura==1 ? "" : "disabled")+' '+(v.permiso_lectura>0 ? "checked" : "")+' class="per_global" type="checkbox" name="p_l[]" value="'+v.id+'" /></div> \
                                        <div class="col-1"><input '+(v.escritura==1 ? "" : "disabled")+' '+(v.permiso_escritura>0 ? "checked" : "")+' type="checkbox" name="p_e[]" value="'+v.id+'" /></div> \
                                        <div class="col-1"><input '+(v.edicion==1 ? "" : "disabled")+' '+(v.permiso_edicion>0 ? "checked" : "")+' type="checkbox" name="p_a[]" value="'+v.id+'" /></div> \
                                        <div class="col-1"><input '+(v.eliminar==1 ? "" : "disabled")+' '+(v.permiso_eliminar>0 ? "checked" : "")+' type="checkbox" name="p_b[]" value="'+v.id+'" /></div> \
                                    </div> \
                                </li>';
                    $(".permisos").append(html);
                })
            },'json');
        });

        $(document).on('click','.per_global',function(){
            let target = $(this).val();
            if(!$(this).prop("checked")){
                $('input[value='+target+']').prop('checked',false);
            }
        })

        $(document).on('click','.edit',function(){
            var id= $(this).attr('data-id');
            var title= $(this).attr('data-title');
            console.log(title);
            $('.titt').text(title);
            $.get('{{ asset("admin/roles/get") }}/'+id,function(d){
                $(".frme_0001 input[name='c01']").val(d.nombre_rol);
                $(".frme_0001 input[name='c02']").val(d.descripcion).trigger('change');
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
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
                    url: '{{ route("dashboard.roles.data") }}',
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
                    {
                        "data": null,
                        "render": function (data) {
                            let html =''; 
                            if(data.estado==1){
                                html = '<span class="badge badge-success">Activo</span>';
                            }else{
                                html = '<span class="badge badge-danger">Inactivo</span>'
                            }
                            return data.nombre_rol+'<br>'+html;
                        }
                    },
                    { "data": "descripcion" },
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
                        "data": null,
                        "render": function (data) {

                            let buttons = '';

                            if(data.id==1){
                                buttons = '<button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lge" data-id="'+data.id+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>';
                            }else{
                                buttons ='<button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lge" data-id="'+data.id+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                                    <button style="width: 32px; padding: 3px 5px !important;" title="Cambiar Estado" data-id="'+data.id+'" class="btn btn-success state"><i class="fa fa-sync"></i></button> \
                                    <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lgexx" data-title="'+data.nombre_rol+'" data-id="'+data.id+'" class="btn btn-success per"><i class="fas fa-code-branch"></i></button> \
                                    <button style="width: 26px; height:26px; padding:0px" class="btn btn-danger delete" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>';
                            }
                            return buttons;
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
            window.location='{{ asset("admin/roles/delete") }}/'+id;
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
        $.post('{{ asset("admin/roles/check/name") }}/'+value,{'_token':'{{ csrf_token() }}'},function(d){
            if(parseInt(d)===1){
                $('.error_nit').html('El Rol proporciado ya esta registrado.');
                $('.error_nit').fadeIn();
                $('.nit').removeClass('is-valid');
                $('.nit').addClass('is-invalid');
            }else if(parseInt(d)===-1){
                $('.error_nit').html('El Rol es Invalido, verifique.');
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
        window.location="{{ asset('admin/roles/change') }}/"+id
    });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop