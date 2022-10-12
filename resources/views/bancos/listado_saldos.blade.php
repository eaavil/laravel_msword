@extends('template.main')

@section('contenedor_principal')

@php
    $total=$saldo_acumulado;
    if(isset($_REQUEST['c01'])){
        $valor=$_REQUEST['c01'];
    }else{
        $valor =''; 
    }
    $session=session('role_id');
@endphp

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form class="frm-saldo" method="post" action="{{ route('bancos.saldo.procesar.reporte') }}">
                <div class="row">
                    <div class="col-4 pt-2">
                        <div class="form-group">
                            <label for="my-select">Cuenta Bancaria</label>
                            <select id="my-select" class="form-control" name="c01">
                                @foreach ($cuentas as $item)
                                    <option value="{{ $item->id_cuenta }}" 
                                        @if ($valor==$item->id_cuenta)
                                        selected
                                        @endif
                                    >{{ $item->cuenta }} / {{ $item->cliente }} {{ $item->documento_cliente }} | {{ $item->entidad }} - {{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <br><br>
                        <input type="text" class="form-control float-right" name="c02" id="customDateFilter">
                    </div>
                    <div class="col-2">
                        <br><br>
                        <button class="btn btn-primary">Consultar</button>
                    </div>
                    
                </div>
                {{ csrf_field() }}
            </form>
            <a target="__blank" href="{{ route('saldo.reporte') }}"  class="btn btn-secondary" style="float:left"><i class="fa fa-file"></i>Saldo por cuentas</a>
            <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fas fa-file"></i> Reporte general</button>
            <table id="main" class="table table-bordered table-striped" style="font-size:12px;">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Fecha</th>
                        <th>Forma Pago</th>
                        <th>Facturador</th>
                        <th>Tercero</th>
                        <th>Cuenta</th>
                        <th>Concepto</th>
                        <th>Factura / Cheque</th>
                        <th>Ingreso</th>
                        <th>Egreso</th>
                        <th>Saldo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registros as $item)
                    @php
                    
                        if($item->modo==1){
                            $total += $item->valor;
                        }else{
                            $total -= $item->valor;
                        }
                    @endphp
                        <tr>
                            <td>{{ $item->numero }}</td>
                            <td>{{ date('d/m/Y',strtotime($item->fecha_operacion)) }}</td>
                            <td>{{ $item->forma_pago }}</td>
                            <td>{{ $item->facturador }}</td>
                            <td>{{ $item->nombre_tercero }}</td>
                            <td>{{ $item->cuenta }}</td>
                            <td>{{ $item->descripcion_movimiento }}</td>
                            @if($item->id_banco==3||strpos($item->numero,'E')!== false)
                            <td>{{ $item->numero_factura_remision}}</td>
                            @else
                            <td>{{ $item->numero_cheque_giro}}</td>
                            @endif
                            @if($item->modo==1)
                                <td align="right">{{ number_format($item->valor,2,',','.') }}</td>
                                <td></td>
                            @else
                                <td></td>
                                <td align="right">{{ number_format($item->valor,2,',','.') }}</td>
                            @endif
                            <td align="right">{{ number_format($total,2,',','.') }}</td>
                            <td>
                                <a href="#" data-id="{{ $item->id_movimiento }}" class="btn btn-danger delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
           @if($inicio!=0)
            <div class="row">
                    <div class="col-4">
                       <h6> <b>Total Ingreso:</b> ${{number_format($total_ingreso,2,',','.')}} <span></span></h6>
                       <h6> <b>Total Egreso:</b> ${{number_format($total_egreso,2,',','.')}}  <span ></span></h6>
                    </div>
            </div>
           @endif
        </div>
    </div>
</div>
@include('bancos.modals.reporte_entradas')
@stop

<style>
	@media print{
		.esp{
			display:block !important;
		}
		.main-footer,.actv{
			display:none
		}
	}


</style>

@section('scripts-bottom')
    <script>
    
    
        var tabla = $('#main').DataTable({
            order:false,
            language: langDataTable,
        });
    
        $('.edit').click(function(){
            var id= $(this).attr('data-id');
            $.get('{{ asset("bancos/cuentas/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c01']").val(d.cuenta);
                $(".frme_0001 input[name='c02']").val(d.cliente);
                $(".frme_0001 input[name='c03']").val(d.documento_cliente);
                $(".frme_0001 select[name='c04']").val(d.id_banco);
                $(".frme_0001 select[name='c05']").val(d.id_tipo_cuenta);
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });

        $('.delete').click(function(){
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas eliminar el registro seleccionado?')){
                    var id= $(this).attr('data-id');
                window.location='{{ asset("bancos/cuentas/saldo/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });
		
		
        $('#customDateFilter').daterangepicker(
            {
                showDropdowns:true,
                locale: configDatepicker
            }
        );
		
		$('#customDateFilter').change(function(){
			$('.cc').submit();
		});

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
