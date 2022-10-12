@extends('template.main')

@section('contenedor_principal')


@include('empaques.modals.reporte_clientes')   
<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                
            <div class="row">
                    <div class="col-1">
                        <label>Sacos Bodega
                        <input  type="text"  name="total_sacos" readonly  min="1" max="50000" class="form-control total_sacos numero_entero" style="width:110%;"></label>

                    </div>
                    <div class="col-1">
                        <label>Tulas Bodega
                        <input  type="text"  name="total_sacos" readonly  min="1" max="50000" class="form-control total_tulas numero_entero" style="width:110%;"></label>
                    </div>
                    <div class="col-3"><br>
                                <button class="btn btn-info float-lefth" data-toggle="modal" data-target="#modal-lginv"><i class="fa fa-plus"></i>Actualizar totales bodega</button>
                                <button  class="btn btn-secondary" data-toggle="modal" data-target="#modal-lgrs"><i class="fas fa-file"></i> Reportes</button><br>
                    </div>
                    <div  class="col-7"><br>
                        <button class="btn btn-info float-right"  data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nueva Entrada</button>

                    </div>
                 
               </div>
                <br>

              <table id="example" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                <th>Fecha Operacion</th>
                  <th>Proveedor</th>
                  <th>Tipo Operacion</th>
                  <th>Tipo Empaque</th>
                  <th>Saldo inicial</th>
                  <th>Cantidad</th>
                  <th>Saldo final</th>
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
   
@include('empaques.modals.registro_entrada_inventario')
 @include('empaques.modals.registro_salida')
@stop

@section('scripts-bottom')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>

    <script>
        $(document).on('click','.delete',function(){
            var id= $(this).attr('data-id');
            if(@json($session)==1){
                if(confirm('Estas Seguro de Eliminar el Registro Seleccionado?')){
                    window.location='{{ asset("empaques/salida/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });
        $(document).on('click','.edit',function(){
            var id= $(this).attr('data-id');
            let tipo_empaque="";
            $.get('{{ asset("empaques/entrada/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c01']").val(d.cantidad);
                $(".frme_0001 select[name='c02']").val(d.id_tipo_empaque).trigger('change');
                if(d.id_tipo_empaque==1){
                     tipo_empaque='Sacos';
                }else{
                    tipo_empaque='Tulas';  
                }
                $(".tipo_empaque").val(tipo_empaque);
                $(".frme_0001 input[name='c03']").val(d.fecha_ingreso.substring(0,10));
                $(".frme_0001 select[name='c04']").val(d.id_catalogo_empresas_cliente).trigger('change');
                $(".frme_0001 select[name='c05']").val(d.id_catalogo_empresas_proveedor).trigger('change');
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });

        $('.tipo_reporte').change(function(){
            
            if($('option:selected',this).val()==2){
                $(".f1").val(@json(date('Y-m-d', strtotime('first day of January', time()))));
                $(".f2").val(@json(date('Y-m-d')));
            }
        });

 
        $('.delete').click(function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("bancos/eliminar") }}/'+id;
            }
        });
        $(document).ready(function(){
            $('.cliente').change(function(){
                    
                    let id = $('option:selected',this).val();//obtener opcion seleccionada
                    if(id==""){
                        $(".saldo_sacos").val("");
                        $(".saldo_tulas").val("");
                        $(".total_sacos_prov").val("");
                        $(".total_tulas_prov").val("");
                    }
                    $.get('{{ asset("empaques/salida/general") }}/'+id,function(d){
                        $(".saldo_sacos").val(d.saldo_sacos);
                        $(".saldo_tulas").val(d.saldo_tulas);
                        $(".total_sacos_prov").val(d[0].total_sacos);
                        $(".total_tulas_prov").val(d.total_tulas);
                        },'json');
            });

            $('title').html('{{ $titulo }}');
                    
            var tabla= $('#example').DataTable({
                        serverSide: true,
                        paging: true,
                        order: false,
                        ajax: { 
                            url: '{{ route("empaques.salidas.data") }}',
                            dataSrc: 'data',
                            type:'post'
                        },
                        columnDefs: [
                            {
                            pageLength: 5,
                            lengthMenu: [[5,50,100 -1], [5, 50, 100, "Todos"]]
                            }
                        ],
                        "columns": [
                            {"data":'fecha_ingreso',name:'fecha_ingreso', 
                            "render": function (data) {
                                return  data;
                              }
                            },
                            {"data":'nombre',name:'000_catalogo_empresas.nombre'},
                            
                            {"data":'tipo_operacion',name:'tipo_operacion',
                                    "render": function (data) {
                                    if(data==2){
                                        return 'Ingreso';
                                    }else{
                                        return 'Egreso';
                                    }
                                }
                                
                            },
                            
                            {"data":'id_tipo_empaque',name:'id_tipo_empaque',
                            
                            "render": function (data) {
                                if(data==1){
                                    return 'Sacos';
                                }else{
                                    return 'Tulas';
                                }
                            }
                        
                        },
                        {"data":null,name:'cantidad',
                                "render": function (data) {
                                    if(data.total_sacos!=null){
                                        return number_format(data.total_sacos);
                                    }else{
                                        return number_format(data.total_tulas);
                                    }
                            }},
                            {"data":null,name:'cantidad',
                                "render": function (data) {
                                    if(data.tipo_operacion==1){
                                         return number_format(data.cantidad);
                                    }else{
                                        return '-'+number_format(data.cantidad);
                                    }
                            }},
                            {"data":null,name:'cantidad',
                                "render": function (data) {
                                    if(data.saldo_sacos!=null){
                                        return number_format(data.saldo_sacos);
                                    }else{
                                        return number_format(data.saldo_tulas);
                                    }
                            }},
                            {
                                "data": null,name:'numero_ticket',
                                "render": function (data) {
                                    
                                    if(data.tipo_operacion==1){
                                        return data.numero_ticket;
                                        }else{
                                             return '<button style="width: 26px; height:26px; padding:0px" data-nombre="'+data.nombre+'" data-id="'+data.id+'" class="btn btn-danger delete"><i class="fa fa-trash"></i></button>';
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
        
        
        $(function(){
        $('.total_sacos').val(@json($inventario[0]->total_sacos));
        $('.total_tulas').val(@json($inventario[0]->total_tulas));
        $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
