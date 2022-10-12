@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fa fa-file"></i> Reportes</button>
              <br><br><br><table class="tableData table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Numero Entrada</th>
                  <th>Contacto</th>
                  <th>Detalles Carga</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($operaciones as $registros)
                        <tr>
                            <td>
                                <h5>{{ $registros->numero_ticket }}</h5><br><br>
                                Creada el:<br>
                                {{ date('d/m/Y h:i:s',strtotime($registros->fecha_liquidacion)) }}<br><br>
                                Actualizada el:<br>
                                {{ date('d/m/Y h:i:s',strtotime($registros->updated_at)) }}
                            </td>
                            <td>
                                <h5>Proveedor</h5>
                                @if($registros->proveedor!=null)
                                {{ $registros->proveedor->nombre }}<br>
                                {{ $registros->proveedor->nit }}-{{ $registros->proveedor->digito_verificacion_nit }}<br><br>
                                @endif
                                <h5>Conductor</h5>
                                Nombre: {{ $registros->nombre_conductor }}<br>
                                Cedula: {{ $registros->cedula_conductor }}<br>
                                Placa Vehiculo: {{ $registros->placa }}
                            </td>
                            <td style="text-align:right">
                                <div class="row">
                                    <div class="col-6">
                                        Peso Entrada:
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->peso_salida,0,',','.') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Entrada:
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->peso_entrada,0,',','.') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Bruto:
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->peso_bruto,0,',','.') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tara:
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->tara,0,',','.') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Neto:
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->tara,0,',','.') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Factor:
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->factor,2,',','.') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Sacos:
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->cantidad_sacos,0,',','.') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tulas:
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->catidad_tulas,0,',','.') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <b>Liquidado:</b>
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->liquidados,0,',','.') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <b>Pendiente:</b>
                                    </div>
                                    <div class="col-6">
                                        {{ number_format($registros->pendientes,0,',','.') }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary liquidar" data-id="{{ $registros->id }}" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-money-bill" aria-hidden="true"></i></button>
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

    @include('liquidaciones.modals.registro_salida')
    @include('liquidaciones.modals.reporte_salidas')
    <style>
        .select2-drop li {
            white-space: pre;
        }
    </style>


@stop

@section('scripts-bottom')
    <script>


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

        $('.contrato').change(function(){
            let elemento = $('option:selected',this);
            $('.saldo').val(elemento.attr('data-value')+'00');
            $('.ref-saldo').val(elemento.attr('data-value'));
        })

        $('.valor').keyup(function(){
            $('.valor-espejo').val($(this).val().substring(1));
        })


        $('.liquidar').click(function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("liquidaciones/salida/detalle") }}/'+id,function(d){
                let html = `
                    <div class="row">
                        <div class="col-4">
                            Entrada: `+d[0].numero_ticket+`<br>
                            <b>Datos del Conductor</b><br>
                            Nombre: `+d[0].nombre_conductor+`<br>
                            Cedula: `+d[0].cedula_conductor+`<br>
                            Placa Vehiculo: `+d[0].placa+`<br>
                            <br>
                            Fecha: `+d[0].created_at+`
                        </div>
                        <div class="col-4">
                                <div class="row">
                                    <div class="col-6">
                                        Peso Salida:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_salida,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Entrada:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_entrada,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Bruto:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_bruto,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tara:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].tara,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Neto:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_neto,0,',','.')+`
                                    </div>
                                </div>
                        </div>
                        <div class="col-3">
                            Kilos Liquidados: `+number_format(d[0].liquidados,0,',','.')+`<br>
                            Kilos Pendientes: `+number_format(d[0].pendientes,0,',','.')+`
                        </div>
                    </div><br>
                `;
                $('.contenido').html(html);
                $('.limit').val(d[0].pendientes);
                $('.c01').attr('max',d[0].pendientes);
                $('.c02').val(d[0].factor);
                $('.entrada').val(d[0].id);
            },'json');
        });

        $('.x').keyup(function(){

            calcx();

        })

        function calcx(){
            let a1 = $('.c01');
            let a2 = $('.c02');
            let a3 = $('.c03');
            let a4 = $('.c04');
            let a5 = $('.c05');
            let a6 = $('.c06');
            let a7 = $('.c07');
            let a8 = $('.c08');
            let a9 = $('.c09');
            let a10 = $('.c10');
            let a11 = $('.c11');
            let a12 = $('.c12');
            let a13 = $('.c13');
            let a14 = $('.c14');
            let a15 = $('.c15');
            let a16 = $('.c16');

            let v1 = parseFloat($('.c01').val());
            let v2 = parseFloat($('.c02').val());
            let v3 = parseFloat($('.c03').val());
            let v4 = parseFloat($('.c04').val());
            let v5 = parseFloat($('.c05').val());
            let v6 = parseFloat($('.c06').val());
            let v7 = parseFloat($('.c07').val());
            let v8 = parseFloat($('.c08').val());
            let v10 = parseFloat($('.c10').val());
            let v12 = parseFloat($('.c12').val());
            let v14 = parseFloat($('.c14').val());

            oper1 = v2-v3; //descuento factor base
            a4.val(Math.round(oper1 * 100)/100);
            oper2 = (v1/12.5)*v5;  //cafe bruto
            a6.val(Math.round(oper2 * 100)/100);
            oper3 = v4*(oper2/100); //valor del descuento
            a7.val(Math.round(oper3 * 100)/100);
            oper4 = (oper3)*(v8/100); //valor del descuento
            a9.val(Math.round(oper4 * 100)/100);
            oper5 = ((oper3-oper4)*v10)/1000; //valor del descuento
            a11.val(Math.round(oper5 * 100)/100);
            oper6 = (oper3-oper5)*(v12/100); //valor del descuento
            a13.val(Math.round(oper6 * 100)/100);
            oper7 = (oper3-oper6)*(v14/100); //valor del descuento
            a15.val(Math.round(oper7 * 100)/100);

            a16.val((Math.round(oper3 * 100)/100)-(Math.round(oper4+oper5+oper6+oper7 * 100)/100))
        }


        $('.trigger_form_esp').click(function(){
            $('.act_form').trigger('click')
        })


        $('.delete').click(function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("giros/eliminar") }}/'+id;
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
