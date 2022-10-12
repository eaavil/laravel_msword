@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nuevo Anticipo</button>
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fa fa-file"></i> Reportes</button>
              <br><br><br>
              <table class="tableData table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Numero</th>
                  <th>Tercero<br>Transportador</th>
                  <th>Concepto</th>
                  <th>Valor</th>
                  <th>Fecha Giro</th>
                  <th>Forma Pago</th>
                  <th>Numero Cheque<br>Transaccion</th>
                  <th>Cuenta</th>
                  <th>Creado</th>
                  <th>Actualizado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($registros as $data)
                        <tr>
                            <td>ANTT-{{ str_pad($data->id,4,'0',STR_PAD_LEFT) }}</td>
                            <td>
                                    {{ $data->tercero->nombre }}<br>
                                    Nit: {{ number_format($data->tercero->nit,0,',','.') }}<br>
                                    Placa: {{ $data->placa }}<br>
                            </td>
                            <td>
                                {{ $data->producto_servicio }}<br>
                                Observaciones: {{ $data->observaciones }}
                            </td>
                            <td>{{ number_format($data->valor,2,',','.') }}</td>
                            <td>{{ date('d/m/Y',strtotime($data->fecha_giro)) }}</td>
                            <td>{{ $data->forma_pago }}</td>
                            <td>{{ $data->numero_cheque }}</td>
                            <td>{{ $data->cuenta->cuenta }}<br>{{ $data->cuenta->cliente }}</td>
                            <td>{{ ($data->created_at!=null)?date('d/m/Y h:i:s a',strtotime($data->created_at)):'' }}</td>
                            <td>{{ ($data->updated_at!=null)?date('d/m/Y h:i:s a',strtotime($data->updated_at)):'' }}</td>
                            <td>
                                <button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.eliminar',session('role_id'))) delete @endif" data-id="{{ $data->id }}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
    </div>
    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.registrar',session('role_id')))
        @include('giros_anticipos.modals.registro_anticipos_transporte')
    @endif
	@include('giros_anticipos.modals.reporte_anticipos_transporte')
    <style>
        .select2-drop li {
            white-space: pre;
        }
    </style>


@stop

@section('scripts-bottom')
    <script>

        $('.contrato').change(function(){
            let elemento = $('option:selected',this);
            $('.saldo').val(elemento.attr('data-value')+'00');
            $('.ref-saldo').val(elemento.attr('data-value'));
        })

        $('.valor').keyup(function(){
            $('.valor-espejo').val($(this).val().substring(1));
        })


        $('.edit').click(function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("bancos/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c02']").val(d.entidad);
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });

        $('.trigger_form_esp').click(function(){
            let id = $(this).attr('target');
            //comienzo validacion

            if(parseInt($('.valor-espejo').val())>parseInt($('.ref-saldo').val())){
                alert('El valor ingresado supera al saldo restante en el contrato seleccionado');
            }else{
                $('.'+id).trigger('submit');
            }

        })


        $('.delete').click(function(){
            if(confirm('Estas seguro que deseas eliminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("anticipos/transporte/eliminar") }}/'+id;
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
