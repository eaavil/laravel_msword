
<table width="100%">
            <tr >
                <td align="right"><h3>Reporte de Giros por Proveedor</h3>
<p >Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
<p >Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
                </td>
                <td align="center">
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250" height="85" >
                 <p>NIT. 901383798-1 </p>
                </td> 
            </tr>
    </table>
<?php $total=0; ?>

        @foreach($registros as $row)
		
        @php if(count($row->giros)==0){ continue;} $t=0;  @endphp
        <table class="paleBlueRows" width="75%" align="center">
            <thead>
                <tr>
                    <th width="30%">PROVEEDOR</th>
                    <th width="15%">GIRO</th>
                    <th width="15%">FECHA</th>
                    <th width="15%">VALOR</th>
                </tr>
            </thead>
            <tbody>
            <td rowspan="{{ count($row->giros)+1 }}">{{ $row->nombre }}</td>
            @foreach($row->giros as $indicex => $rowx)
                <tr>
                    <td>GIR-{{ str_pad($rowx->id,5,'0',STR_PAD_LEFT) }}</td>
                    <td>{{ date('d/m/Y',strtotime($rowx->fecha_giro)) }}</td>
                    <td>{{ number_format($rowx->valor,0,',','.') }}</td>
                    @php $t+=$rowx->valor; $total+= $rowx->valor; @endphp
                </tr>
            @endforeach
            <tr style="background:#ccc; color:black">
                <td colspan="2">TOTALES</td>
                <td>{{ number_format($t,0,',','.') }}</td>
            </tr>
        </tbody>

    </table><br>
        @endforeach

        <table  style="background:#ccc" width="75%" align="center">
            <thead>
                <tr>
                    <th width="50%" style="color:black">TOTAL</th>
                    <th width="50%" style="color:black">{{ number_format($total,0,',','.') }}</th>
                </tr>
            </thead>
		</table><br>


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
