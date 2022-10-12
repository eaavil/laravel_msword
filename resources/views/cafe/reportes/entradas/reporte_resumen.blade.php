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
			<h3>Informe resumido existencias pergamino e inferiores</h3> <br>
					Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br> <br>
					Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }} {{date(" (H:i:s)",time())}}<br> 
            </td>
            <td align="right">
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  >
                 <p>NIT. 901383798-1 </p>
                </td> 
            </tr>
    </table>
@else
<h3 align="lefth">Informe resumido existencias pergamino e inferiores</h3>
<p >Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
<p >Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
@endif
<table class="paleBlueRows" width="70%" align="center">
	<thead>
		<tr>
			<th>INGRESOS DE CAFE PERGAMINO</th>
      
		</tr>
	</thead>
	<tfoot>
	<tr  style="background:#ccc" width="75%" align="right">
			<td  HEIGHT="26">Total ingresos de cafe:  {{ number_format($entradas,0,',','.') }}  </td>
			
		
		</tr>
	</tfoot>
</table><br>
<table class="paleBlueRows" width="70%" align="center" >
	<thead>
		<tr>
			<th >SALIDAS DE CAFE PERGAMINO</th>
		</tr>
	</thead>
	<tfoot>
	<tr  style="background:#ccc" width="100%" align="center">
			<td align="right"  HEIGHT="26">Total despachos de cafe: {{ number_format($salidas,0,',','.') }} </td>
  </tr>
    <tr><td></td></tr>
    <tr> <td align="right"  HEIGHT="26">Total existencias de cafe:  {{ number_format($entradas-$salidas,0,',','.') }}</td></tr>
	</tfoot>
</table><br><br><br>
<table class="paleBlueRows" width="70%" align="center">
	<thead>
		<tr>
			<th >INGRESOS DE CAFE INFERIORES</th>
		</tr>
	</thead>
	<tfoot>
	<tr  style="background:#ccc" width="100%" align="center">
			<td align="right" HEIGHT="26" >Total ingresos de cafe: {{ number_format($inferiores_entradas,0,',','.') }} </td>
  </tr>
	</tfoot>
</table>
<br>
<table class="paleBlueRows" width="70%" align="center">
	<thead>
		<tr>
			<th >SALIDAS DE CAFE INFERIORES</th>
		</tr>
	</thead>
	<tfoot>
	<tr  style="background:#ccc" width="100%" HEIGHT="26" align="center">
			<td align="right" HEIGHT="26" >Total despachos de cafe: {{ number_format($inferiores_salidas,0,',','.') }} </td>
  </tr>
    <tr><td></td></tr>
    <tr>   <td align="right" HEIGHT="26">Total existencias de cafe: {{ number_format($inferiores_entradas-$inferiores_salidas,0,',','.') }}</td></tr>
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
  font-size: 14px;
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
  font-size: 14px;
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
  font-size: 14px;
  font-weight: bold;
  color: #333333;
  background: #D0E4F5;
  border-top: 2px solid #444444;
}
table.paleBlueRows tfoot td {
  font-size: 14px;
}
</style>