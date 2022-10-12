<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="row" >
        <div class="col-10" align="center">
        <h3>Reporte de Anticipos Cliente</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
        </div>
        <div class="col-2" align="right">
        <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250" height="85" >
        <p>NIT. 901383798-1 </p>
        </div>
</div><br>
<table class="paleBlueRows" width="100%">
	<thead>
		<tr>
			<th>TICKET</th>
			<th>FECHA</th>
			<th>PROVEEDOR</th>
			<th>BODEGA</th>
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
				<td>{{ $rows->centro->descripcion }}</td>
				<td>{{ $rows->producto->tipo_cafe }}</td>
				<td>{{ $rows->factor }}</td>
				<td>{{ $rows->cantidad_sacos }}</td>
				<td>{{ $rows->catidad_tulas }}</td>
				<td>{{ $rows->nombre_conductor }}</td>
				<td>{{ $rows->placa }}</td>
				<td>{{ number_format($rows->peso_entrada,2,'.',',') }}</td>
				<td>{{ number_format($rows->peso_salido,2,'.',',') }}</td>
				<td>{{ number_format($rows->peso_bruto,2,'.',',') }}</td>
				<td>{{ number_format($rows->peso_neto,2,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="10">TOTALES</td>
			<td>{{ $datos['total_peso_salida'] }}</td>
			<td>{{ $datos['total_peso_salida'] }}</td>
			<td>{{ $datos['total_peso_bruto'] }}</td>
			<td>{{ $datos['total_peso_neto'] }}</td>
		</tr>
	</tfoot>
</table>

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
  font-size: 11px;
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
p{
  font-size:17px;
  text-align:center;
  font-weight: bold;
}
</style>