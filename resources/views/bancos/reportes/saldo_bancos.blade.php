<meta charset='utf-8'>



<?php
if($excel==2){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Liquidaciones/entradas.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
?> 
<button class=" boton oculto" onclick="location.href = document.referrer; return false;">Volver</button>

<table width="100%">
            <tr>
				<td align="lefht" > 
				<h3>Informe bancos por saldo</h3> <br>
				  {{$fecha_actual}}{{date(" (H:i:s)",time())}}
				</td>
				<td align="right">
					<img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  > <br>
					NIT. 901383798-1 
				</td> 
            </tr>
</table><br>
<table class="paleBlueRows" width="100%" border=1>
	<thead>
        <tr style="background-color:#0B6FA4;color:white;font-size:70%; " >
          <th>Banco</th>
          <th>Cuenta No.</th>
          <th>Tipo Cuenta</th>
          <th>Valor</th>
        </tr>
	</thead>
  <tbody>
          @foreach($saldo_total as $rows)
            <tr style="background-color: #C1DFF4;font-size:70%;" >
            <td>{{$rows->entidad}}</td>
              
              <td>{{$rows->cuenta_No}}</td>
              <td>{{$rows->tipo_cuenta}}</td>
              @php try{ @endphp
              <td>{{number_format($rows->saldo,0,',','.') }}</th>
              @php }catch(\Exception $e){ @endphp
              <td>{{$rows->saldo}}</th>
              @php } @endphp
          @endforeach
          <tr  style="background:#ccc" width="75%" align="center">
                    <td colspan="3" align="right" ><b>Total saldo bancos</b></td>
                    <td >{{number_format($total,0,',','.') }}</td>
                </tr>
  </tbody>
</table> <br>
<button class=" boton oculto" onclick="location.href = document.referrer; return false;">Volver</button>

<style>


  .boton{
    text-decoration: none;
    padding: 10px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #1883ba;
    border-radius: 6px;
    border: 2px solid #0016b0;
  }

table.ventas {
  background-color: #D0E4F5;
}
table.tr.compras{
  background-color: #D0E4F5;

}
strong{
  font-size:15px;
  text-align:center;
}
p{
  font-size:17px;
  text-align:center;
  font-weight: bold;
}
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
  background-color: #D0E4F5;
}
table.paleBlueRows thead {
  background: #0B6FA4;
  border-bottom: 2px solid #000;
}
table.paleBlueRows thead th {
  font-size: 12px !important;
  font-weight: bold;
  color: white;
  text-align: center;
  padding: 5px;
  border-left: 2px solid #000;
}
	.totales td{
		background:#0B6FA4; color:white
	}
	
@media print {
	table.paleBlueRows thead th {
	  font-size: 11px !important;
	  font-weight: bold;
	  color: black;
	  text-align: center;
	  padding: 5px;
	  border-left: 2px solid #000;
	}
	table.paleBlueRows tfoot {
	  font-size: 12px;
	  font-weight: bold;
	  color: #333333;
	  background: #D0E4F5;
	  border-top: 2px solid #444444;
	}
	.totales td{
		background:#0B6FA4; color:black
	}
  .oculto {display:none}
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