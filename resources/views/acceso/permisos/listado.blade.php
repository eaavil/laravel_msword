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
                  <th>Transaccion</th>
                  <th>Cantidad</th>
                  <th>Tipo Empaque</th>
                  <th>Proveedor</th>
                  <th>Cliente</th>
                  <th>Fecha Operacion</th>
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
    @include('empaques.003_movimientos_empaque.modals.registro_entrada')
    @include('empaques.003_movimientos_empaque.modals.edicion_entrada')
@stop

@section('scripts-bottom')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>

    <script>


        $(document).on('click','.edit',function(){
            var id= $(this).attr('data-id');
            
            $.get('{{ asset("empaques/entrada/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c01']").val(d.cantidad);
                $(".frme_0001 select[name='c02']").val(d.id_tipo_empaque).trigger('change');
                $(".frme_0001 input[name='c03']").val(d.fecha_ingreso.substring(0,10));
                $(".frme_0001 select[name='c04']").val(d.id_catalogo_empresas_cliente).trigger('change');
                $(".frme_0001 select[name='c05']").val(d.id_catalogo_empresas_proveedor).trigger('change');
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
                    url: '{{ route("empaques.entradas.data") }}',
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
                    { "data": "cantidad" },
                    { "data": "tipo_empaque.tipo_empaque" },
                    { "data": "cliente.nombre" },
                    {
                        "data": "proveedor",
                        "render": function (data) {
                            return data.nombre+'<br>'+data.nit+'-'+data.digito_verificacion_nit;
                        }
                    },
                    {
                        "data": "fecha_ingreso",
                        "render": function (data) {
                            return data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4);
                        }
                    },
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
                ],
                /*"footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
        
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    
        
                    // Total over all pages
                    total = api
                        .column( 1 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                    // Total over this page
                    pageTotal = api
                        .column( 1, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                    // Update footer
                    $( api.column( 1 ).footer() ).html(
                        '$'+pageTotal +' de $'+ total +' total'
                    );
                }*/
            });
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop