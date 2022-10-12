<?php
if($excel==1){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Inventario.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
?>
@if($excel!=1)
<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>Reporte de Inventario:</h3>
          @if($fecha_inicial && $fecha_final)
					Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br><br>
					Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }} </p>
          @endif
            </td><td><td ></td></td>
            <td align="right">
            <p>
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
            </td> 
            </tr>
    </table>
@else
<h3 align="center">Reporte de Iventario:</h3>
@if($fecha_inicial && $fecha_final)
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>
@endif
@endif <br>
<table class="paleBlueRows" width="100%" border="1">
	<thead >
        <tr style="background-color:#0B6FA4;color:white;font-size:70%; " >
                  <th>Fecha Ingreso</th>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Categoria</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
        </tr>
	</thead>
	<tbody>
  @foreach($consulta as $rows)
                         <tr style="font-size:70%;">
                         <td>{{ date('d/m/Y',strtotime($rows->created_at)) }}</td>
                         <td>{{$rows->codigo}}</td>
                         <td>{{$rows->nombre}}</td>
                         <td>{{$rows->rutas}}</td>
                        <td>{{$rows->stock}}</td>
                        <td>{{number_format($rows->valor,0,',','.')}}</td>
                        
                          </tr>     
                       @endforeach
	</tbody>

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
	  font-size: 12px !important;
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









