<?php
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=despachos_registrados.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
?>


<h3>Reporte Despachos de Cafe</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
   <table  width="100%" border="1"  >
	<thead >
        <tr style="background-color:#0B6FA4;color:white;font-size:70%; " >
		  <th>Despacho</th>
            <th>cliente</th>
		  <th>Factor Promedio</th>
          <th>Factor Despacho</th>
          <th>Entrada</th>
          <th>Proveedor</th>
          <th>Kilogramos</th>
          <th>Factor</th>
          <th>Factor %</th>
        </tr>
	</thead>
	<tbody>
        @foreach($data_reporte as $rows)
            @php
                $contador = 0;
                $long = count($rows->detalle);
                foreach($rows->cliente_despacho as $clientex){
                $cliente=$clientex->nombre;}
                
                $tot_a = 0;
                $tot_b = 0;
                $tot_c = 0;
                $tot_d = 0;
                $tot_e = 0;
                $tot_f = 0;
                $tot_g = 0;
                $tot_h = 0;
                $tot_i = 0;
                $tot_j = 0;
                $tot_k = 0;
            @endphp
            @foreach($rows->detalle as $index => $rowsx)
                <tr>
                    @if($contador==0)
                        <td rowspan="{{ $long }}">
						@php try{ @endphp
							{{ $rows->numero }}
						@php }catch(\Exception $e){} @endphp
						</th>
            <td rowspan="{{ $long }}">
						@php try{ @endphp
							{{$cliente }}
						@php }catch(\Exception $e){} @endphp
						</th>
						<td rowspan="{{ $long }}">
						@php try{ @endphp
							{{ $rows->factor_promedio }}
						@php }catch(\Exception $e){} @endphp
						</th>
						<td rowspan="{{ $long }}">
						@php try{ @endphp
							{{ $rows->factor_promedio_referencia }}
						@php }catch(\Exception $e){} @endphp
						</th>
                    @endif
						<td>{{ $rowsx->numero_ticket }}</th>
                        <td>{{ $rowsx->nombre }}</th>
						<td>{{ number_format($rowsx->kilogramos_despacho,0,',','.') }}</th>
						<td>{{ $rowsx->factor_despacho }}</th>
						<td>{{ $rowsx->factor_promedio_despacho }}</th>




                </tr>

				@php $tot_a = $tot_a+$rowsx->kilogramos_despacho; $contador++; @endphp

            @endforeach

            <tr  style="background:#ccc" width="75%" align="center">
                    <td colspan="5"></td>
                    <td >TOTALES</td>
                    <td>{{ number_format($tot_a,0,',','.') }}</td>
                    <td></td>
                    <td></td>
                </tr>

		@endforeach
	</tbody>

</table>

