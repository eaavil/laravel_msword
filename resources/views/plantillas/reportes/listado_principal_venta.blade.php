<?php
if($excel==1){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=ventas.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
?>
@if($excel!=1)
<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>Reporte de contratos de ventas</h3>
					Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br><br>
					Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }} </p>
            </td><td><td ></td></td>
            <td align="right">
            <p>
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1 </p>
            </td> 
            </tr>
    </table>
@else
<h3 align="center">Reporte de Anticipos Cliente</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>
@endif <br>
<table class="paleBlueRows" width="100%" border="1">
	<thead >
        <tr style="background-color:#0B6FA4;color:white;font-size:70%; " >
        <th width="5%">Numero</th>
                  <th class="d">Fecha Operacion</th>
                  <th width="5%">Kilos Compromiso</th>
                  <th width="5%">Kilos Liquidados</th>
                  <th>Saldo</th>
                  <th>Tipo Producto</th>
                  <th>Valor Arroba</th>
                  <th>Cliente</th>
        </tr>
	</thead>
	<tbody>
  @foreach($consulta as $rows)
                         <tr style="font-size:70%;">
                           <td>{{$rows->numero}}</td>
                           <td>{{ date('d/m/Y',strtotime($rows->fecha_contrato)) }}</td>
                           @php try{ @endphp
                          <td>{{ number_format($rows->kilos_compromiso,0,',','.') }}</th>
                           @php }catch(\Exception $e){ @endphp
                          <td>{{$rows->kilos_compromiso }}</th>
                           @php } @endphp
                           @php try{ @endphp
                          <td>{{ number_format($rows->kilos_entregados,0,',','.') }}</th>
                           @php }catch(\Exception $e){ @endphp
                          <td>{{$rows->kilos_entregados}}</th>
                           @php } @endphp
                           @php try{ @endphp
                          <td>{{ number_format($rows->kilos_compromiso-$rows->kilos_entregados,0,',','.') }}</th>
                           @php }catch(\Exception $e){ @endphp
                          <td>{{$rows->kilos_compromiso-$rows->kilos_entregados}}</th>
                           @php } @endphp
                           <td>{{$rows->tipo_cafe}}</td>
                           @php try{ @endphp
                          <td>{{ number_format($rows->precio_arroba,0,',','.') }}</th>
                           @php }catch(\Exception $e){ @endphp
                          <td>{{$rows->precio_arroba}}</th>
                           @php } @endphp
                           <td>{{$rows->cliente}}<br>Nit:{{$rows->cliente_nit}}</th>
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





