<h3>Reporte de Anticipos por Tranporte Particular</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>

@foreach($grupo_tercero as $registros)

<table class="paleBlueRows" width="100%">
	<thead>
		<tr>
			<th width="20%">ITEM</th>
			<th width="20%">TERCERO Y/O TRANSPORTADOR</th>
			<th width="20%">ANTICIPO</th>
			<th width="20%">FECHA</th>
			<th width="20%">VALOR</th>
		</tr>
	</thead>
	<tbody>
        @php
            $colspan = count($registros);
        @endphp
        @foreach($registros as $indice => $row)
            @php
                $id_tercero = $row->tercero[0]->id;
            @endphp
            <tr>
                <td>{{ $indice+1 }}</td>
                @if($indice ==0)
                    <td rowspan="{{ $colspan}}">
                        <b>Nombre: </b> {{ $row->tercero[0]->nombre }}<br>
                        <b>Nit: </b> ${{ number_format($row->tercero[0]->nit,0,',','.') }}
                    </td>
                @endif
                <td>ANTT-{{ str_pad($row->id,5,'0',STR_PAD_LEFT) }}</td>
                <td>{{ date('d/m/Y',strtotime($row->fecha_giro)) }}</td>
                <td>${{ number_format($row->valor,2,',','.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">TOTALES</td>
            <td >${{ number_format($totales_tercero[$id_tercero],2,',','.') }}</td>
        </tr>
	</tbody>

</table><br>

@endforeach

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
</style>
