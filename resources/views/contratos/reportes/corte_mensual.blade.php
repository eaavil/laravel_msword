@php
if($tipo_archivo==2){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=corte_entradas/salidas.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
}
@endphp

<button class=" boton oculto" onclick="location.href = document.referrer; return false;">Volver</button>

<br>
<table width="100%">
            <tr>
            <td align="lefth" >
            <h3>Corte de contratos de ingresos y Egresos</h3><br>
					   Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br> <br>
				     Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}
            </td>
            
            <td align="right">
                  @if($tipo_archivo!=2)
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1
                 @endif
                </td> 
            </tr>
    </table><br>
<table class="paleBlueRows" width="100%" border=1>
	<thead>
        <tr style="background-color:#0B6FA4;color:white;font-size:70%; " >
          <th>Numero</th>
          <th>fecha </th>
          <th>Proveedor</th>
          <th>valor</th>
          <th>observaciones</th>
          
        </tr>
	</thead>
  <tbody>
       @php
         $total=0;
       @endphp
        @foreach($ingresos as $rows)
        @php
        
        $total+=$rows->total;
        @endphp
          <tr style="background-color: #C1DFF4;font-size:70%;" >
          <td>{{$rows->numero}}</td>
          <td>{{$rows->created_at}}</td>
          <td>{{$rows->nombre}}</td>
          <td>{{number_format($rows->total,0,',','.') }}</td>
            <td>{{$rows->observacion}}</td>
        @endforeach
        <tr style="background-color: #EAD9A<C ;font-size:70%;"> 
          <td colspan="3">TOTAL</td>
          <td>{{number_format($total,0,',','.')}}</td>
          <td></td>
        </tr>
      
        @php
        $total_egreso=0;
       @endphp
        @foreach($egresos as $rows)
        @php
        
        $total_egreso+=$rows->valor_total;
        @endphp
          <tr style="background-color: #EAD9AC;font-size:70%;" >
          <td>{{$rows->numero}}</td>
          <td>{{$rows->fecha_contrato}}</td>
          <td>{{$rows->nombre}}</td>
          <td>{{$rows->observacion}}</td>
            <td>{{number_format($rows->valor_total,0,',','.') }}</td>
        @endforeach
        
        <tr style="background-color: #EAD9AC ;font-size:70%;"> 
          <td colspan="3">TOTAL</td>
          <td>{{number_format($total_egreso,0,',','.')}}</td>
          <td></td>
        </tr>
      
          
	</tbody>

 
</table> <br>


<table class="paleBlueRows"  style="background-color: #C1DFF4;font-size:80%;"  width="100%" border=1>
	<tbody>
        <tr>
          <th>Total Ingreso $ {{number_format($total,0,',','.')}}</th>
          <th>Total Egreso: ${{number_format($total_egreso,0,',','.')}} </th>
          <th>Saldo: ${{number_format($total-$total_egreso,0,',','.')}}</th>
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
  font-size: 12px;
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
  .oculto {display:none}
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