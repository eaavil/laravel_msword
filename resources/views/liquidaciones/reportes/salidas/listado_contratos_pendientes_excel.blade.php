<?php
if($excel==2){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=liquidaciones/pendientes.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
?> 
@if($excel!=2)
<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>Contratos pendientes por liquidar</h3>
					Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br><br>
					Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}} </p>
            <td align="right">
            <p >
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1 </p>
            </td> 
            </tr>
    </table><br>
@else
<h3 align="center">Contratos pendientes por liquidar</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>
@endif <br>
<table  class="paleBlueRows" style="font-size:80%;margin: 0 auto; " width="70%" border=1>
	<thead>
	<tr style="background-color:#0B6FA4;color:white; " >
                 <th >Cliente</th>
                  <th>Fecha Operacion</th>
                  <th>Kilos Compromiso</th>
                  <th>Kilos Liquidados</th>
                  <th>Saldo</th>
                  <th>Tipo Producto</th>
                  <th>Valor Arroba</th>
                  <th width="11%">Numero</th>
                  
                </tr>
                </thead> 
                <tbody>@foreach($operaciones as $rows)
                    <tr>  <td>
                            {{$rows->nombre}}<br>NIT:{{$rows->nit}}-{{$rows->digito_verificacion_nit}}
                            <br>Actualizado el:{{date('d/m/Y',strtotime($rows->contrato_updated_at))}}</td>
                        </td>
                        
                        <td>{{$rows->fecha_contrato}} </td>
                        <td> {{number_format($rows->kilos_compromiso,0,',','.')}}</td>
                        <td> {{number_format($rows->kilos_entregados,0,',','.')}}</td>
                        <td> {{number_format($rows->kilos_compromiso-$rows->kilos_entregados,0,',','.')}}</td>
                        <td>{{$rows->tipo_cafe}}</td>
                        <td>{{number_format($rows->precio_arroba,0,',','.')}}</td>
                        <td>{{$rows->numero}} <br> Creado el:{{date('d/m/Y',strtotime($rows->fecha_contrato))}} <br>

                    </tr>
                    @endforeach

                </tbody>
                <tfoot>
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
  font-size:12px;
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
  font-size: 10px !important;
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
	  font-size: 10px !important;
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
  font-size:12px;
}
p{
  font-size:17px;
  text-align:center;
  font-weight: bold;
}
</style>
