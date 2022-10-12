<?php
if($excel==1){
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=existencias_pergamino_inferiores.xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);}
?> 
@if($excel!=1)
<table width="100%">
            <tr>
            <td align="lefth" >
			<h3>Inventario general en existencias detallado</h3>
					<p >Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
					<p >Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
					<h3  >Entradas de Cafe pergamino:</h3>
            </td>
            <td align="right">
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  >
                 <p>NIT. 901383798-1 </p>
                </td> 
            </tr>
    </table>
@else
<h3 align="lefth">Inventario general en existencias detallado</h3>
<p >Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
<p >Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
<h3  >Entradas de Cafe pergamino</h3>
@endif
@if($entradas['registros']!=0)
<table class="paleBlueRows" width="100%" border=1>
	<thead>
		<tr>
			<th>TICKET</th>
			<th>FECHA</th>
			<th>PROVEEDOR</th>
			<th>PRODUCTO</th>
			<th>FACTOR</th>
			<th>SACOS</th>
			<th>TULAS</th>
			<th>CONDUCTOR</th>
			<th>PLACA</th>
			<th>KILOS ENTRADAS</th>
			<th>KILOS SALIDA</th>
			<th>KILOS BRUTO</th>
			<th>KILOS NETO</th>
		</tr>
	</thead>
	<tbody>
		@foreach($entradas['rows'] as $rows)
			<tr>
				<td>{{ $rows->numero_ticket }}</td>
				<td>{{ date('d/m/Y',strtotime($rows->fecha_ticket)) }}</td>
				<td>@php try{ @endphp {{ $rows->proveedor->nombre }} @php }catch(\Exception $e){  } @endphp</td>
				<td>{{ $rows->producto->tipo_cafe }}</td>
				<td>{{ $rows->factor }}</td>
				<td>{{ $rows->cantidad_sacos }}</td>
				<td>{{ $rows->catidad_tulas }}</td>
				<td>{{ $rows->nombre_conductor }}</td>
				<td>{{ $rows->placa }}</td>
				<td>{{ number_format($rows->peso_entrada,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_salido,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_bruto,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_neto,0,',','.') }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
	<tr  style="background:#ccc" align="center" HEIGHT="26">
			<td colspan="9">TOTALES</td>
			<td>{{ $entradas['total_peso_entrada'] }}</td>
			<td>{{ $entradas['total_peso_salida'] }}</td>
			<td>{{ $entradas['total_peso_bruto'] }}</td>
			<td>{{ $entradas['total_peso_neto'] }}</td>
		</tr>
	</tfoot>
</table>
@endif
@if($salidas['registros']!=0)
<h3>Salidas de Cafe pergamino:</h3>
<table class="paleBlueRows" width="100%" border=1>
	<thead>
		<tr>
			<th>TICKET</th>
			<th>FECHA</th>
			<th>PROVEEDOR</th>
			<th>PRODUCTO</th>
			<th>FACTOR</th>
			<th>SACOS</th>
			<th>TULAS</th>
			<th>CONDUCTOR</th>
			<th>PLACA</th>
			<th>KILOS ENTRADAS</th>
			<th>KILOS SALIDA</th>
			<th>KILOS BRUTO</th>
			<th>KILOS NETO</th>
		</tr>
	</thead>
	<tbody>
		@foreach($salidas['rows'] as $rows)
			<tr>
				<td>{{ $rows->numero_ticket }}</td>
				<td>{{ date('d/m/Y',strtotime($rows->fecha_ticket)) }}</td>
				<td>@php try{ @endphp {{ $rows->proveedor->nombre }} @php }catch(\Exception $e){  } @endphp</td>
				<td>{{ $rows->producto->tipo_cafe }}</td>
				<td>{{ $rows->factor }}</td>
				<td>{{ $rows->cantidad_sacos }}</td>
				<td>{{ $rows->catidad_tulas }}</td>
				<td>{{ $rows->nombre_conductor }}</td>
				<td>{{ $rows->placa }}</td>
				<td>{{ number_format($rows->peso_entrada,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_salido,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_bruto,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_neto,0,',','.') }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
	<tr  style="background:#ccc" width="75%" align="center" HEIGHT="26">
			<td colspan="9">TOTALES</td>
			<td>{{ $salidas['total_peso_entrada'] }}</td>
			<td>{{ $salidas['total_peso_salida'] }}</td>
			<td>{{ $salidas['total_peso_bruto'] }}</td>
			<td>{{ $salidas['total_peso_neto'] }}</td>
		</tr>
	</tfoot>
</table>
@endif
@if($inferiores_entradas['registros']!=0)
<h3>Ingresos de cafe Inferiores:</h3>
<table class="paleBlueRows" width="100%" border=1>
	<thead>
		<tr>
			<th>TICKET</th>
			<th>FECHA</th>
			<th>PROVEEDOR</th>
			<th>PRODUCTO</th>
			<th>FACTOR</th>
			<th>SACOS</th>
			<th>TULAS</th>
			<th>CONDUCTOR</th>
			<th>PLACA</th>
			<th>KILOS ENTRADAS</th>
			<th>KILOS SALIDA</th>
			<th>KILOS BRUTO</th>
			<th>KILOS NETO</th>
		</tr>
	</thead>
	<tbody>
		@foreach($inferiores_entradas['rows'] as $rows)
			<tr>
				<td>{{ $rows->numero_ticket }}</td>
				<td>{{ date('d/m/Y',strtotime($rows->fecha_ticket)) }}</td>
				<td>@php try{ @endphp {{ $rows->proveedor->nombre }} @php }catch(\Exception $e){  } @endphp</td>
				<td>{{ $rows->producto->tipo_cafe }}</td>
				<td>{{ $rows->factor }}</td>
				<td>{{ $rows->cantidad_sacos }}</td>
				<td>{{ $rows->catidad_tulas }}</td>
				<td>{{ $rows->nombre_conductor }}</td>
				<td>{{ $rows->placa }}</td>
				<td>{{ number_format($rows->peso_entrada,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_salido,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_bruto,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_neto,0,',','.') }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
	<tr  style="background:#ccc" align="center" HEIGHT="26">
			<td colspan="9">TOTALES</td>
			<td>{{ $inferiores_entradas['total_peso_entrada'] }}</td>
			<td>{{ $inferiores_entradas['total_peso_salida'] }}</td>
			<td>{{ $inferiores_entradas['total_peso_bruto'] }}</td>
			<td>{{ $inferiores_entradas['total_peso_neto'] }}</td>
		</tr>
	</tfoot>
</table>
@endif
@if($inferiores_salidas['registros']!=0)
<h3 >Salidas de cafe inferiores:</h3>
<table class="paleBlueRows" width="100%" border=1>
	<thead>
		<tr>
			<th>TICKET</th>
			<th>FECHA</th>
			<th>PROVEEDOR</th>
			<th>PRODUCTO</th>
			<th>FACTOR</th>
			<th>SACOS</th>
			<th>TULAS</th>
			<th>CONDUCTOR</th>
			<th>PLACA</th>
			<th>KILOS ENTRADAS</th>
			<th>KILOS SALIDA</th>
			<th>KILOS BRUTO</th>
			<th>KILOS NETO</th>
		</tr>
	</thead>
	<tbody>
		@foreach($inferiores_salidas['rows'] as $rows)
			<tr>
				<td>{{ $rows->numero_ticket }}</td>
				<td>{{ date('d/m/Y',strtotime($rows->fecha_ticket)) }}</td>
				<td>@php try{ @endphp {{ $rows->proveedor->nombre }} @php }catch(\Exception $e){  } @endphp</td>
				<td>{{ $rows->producto->tipo_cafe }}</td>
				<td>{{ $rows->factor }}</td>
				<td>{{ $rows->cantidad_sacos }}</td>
				<td>{{ $rows->catidad_tulas }}</td>
				<td>{{ $rows->nombre_conductor }}</td>
				<td>{{ $rows->placa }}</td>
				<td>{{ number_format($rows->peso_entrada,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_salido,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_bruto,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_neto,0,',','.') }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
	<tr  style="background:#ccc" width="75%" HEIGHT="26" align="center">
			<td colspan="9">TOTALES</td>
			<td>{{ $inferiores_salidas['total_peso_entrada'] }}</td>
			<td>{{ $inferiores_salidas['total_peso_salida'] }}</td>
			<td>{{ $inferiores_salidas['total_peso_bruto'] }}</td>
			<td>{{ $inferiores_salidas['total_peso_neto'] }}</td>
		</tr>
	</tfoot>
</table>
@endif
<style>

table.paleBlueRows {
  font-family: "Arial";
  border: 1px solid #000;
  text-align: center;
  border-collapse: collapse;
}
table.paleBlueRows td, table.paleBlueRows th {
  border: 1px solid #000;
}
table.paleBlueRows tbody td {
  font-size: 12px;
  padding: 5px;
}
table.paleBlueRows tr:nth-child(even) {
  background: #D0E4F5;
}
table.paleBlueRows thead {
  background: #0B6FA4;
  border-bottom: 2px solid #000;
}
table.paleBlueRows thead th {
  font-size: 12px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  padding: 5px;
  border-left: 2px solid #000;
}
table.paleBlueRows thead th:first-child {
  border-left: none;
}

table.paleBlueRows tfoot {
  font-size: 12px;
  font-weight: bold;
  color: #333333;
  background: #D0E4F5;
  border-top: 2px solid #444444;
}
table.paleBlueRows tfoot td {
  font-size: 12px;
}
</style>