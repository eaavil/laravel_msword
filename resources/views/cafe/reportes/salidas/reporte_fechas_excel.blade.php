
<?php
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=salidas_cafe.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
?>

<h3>Reporte de Salidas de Cafe</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>

<table style="font-size:80%; " width="70%" border=1>
	<thead>
	<tr style="background-color:#0B6FA4;color:white; " >
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
		@foreach($datos['rows'] as $rows)
			<tr>
				<td>{{ $rows->numero_ticket }}</td>
				<td>{{ date('d/m/Y',strtotime($rows->fecha_ticket)) }}</td>
				<td>{{ $rows->proveedor->nombre }}</td>
				<td>{{ $rows->producto->tipo_cafe }}</td>
				<td>{{ $rows->factor }}</td>
				<td>{{ $rows->cantidad_sacos }}</td>
				<td>{{ $rows->catidad_tulas }}</td>
				<td>{{ $rows->nombre_conductor }}</td>
				<td>{{ $rows->placa }}</td>
				<td>{{ number_format($rows->peso_entrada,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_salido,0,',','.') }}</td>
				<td>{{ number_format($rows->peso_bruto,0,',','.')  }}</td>
				<td>{{ number_format($rows->peso_neto,0,',','.')  }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
	<tr  style="background:#ccc" width="75%" align="center">
			<td colspan="9">TOTALES</td>
			<td>{{ $datos['total_peso_salida'] }}</td>
			<td>{{ $datos['total_peso_salida'] }}</td>
			<td>{{ $datos['total_peso_bruto'] }}</td>
			<td>{{ $datos['total_peso_neto'] }}</td>
		</tr>
	</tfoot>
</table>
