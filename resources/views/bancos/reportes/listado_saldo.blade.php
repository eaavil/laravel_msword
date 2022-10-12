<?php
if($excel==1){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=movimientos_bancos.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
?>
@php
    $total=$saldo_acumulado;
    if(isset($_REQUEST['c01'])){
        $valor=$_REQUEST['c01'];
    }else{
        $valor =''; 
    }
@endphp
@if($excel!=1)
<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>Reporte de movimientos en {{$registros[0]->entidad}} numero de cuenta {{$registros[0]->cuenta}}</h3>
					Desde: {{ date('d/m/Y',strtotime($fecha_a)) }} <br><br>
					Hasta: {{ date('d/m/Y',strtotime($fecha_b)) }}{{date(" (H:i:s)",time())}} </p>
            </td><td><td ></td></td>
            <td align="right">
            <p >
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1 </p>
            </td> 
            </tr>
    </table>
@else
<h3 align="center">Reporte de movimientos</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_a))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_b)) }}</p>
@endif <br>


                <table  class="paleBlueRows" width="100%" border=1  align="center">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Fecha</th>
                        <th>Tercero</th>
                        <th>Factura / cheque</th>
                        <th>Concepto</th>
                        <th>Ingreso</th>
                        <th>Egreso</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registros as $item)
                    @php
                       
                        if($item->modo==1){
                            $total += $item->valor;
                        }else{
                            $total -= $item->valor;
                        }
                    @endphp
                        <tr>
                            <td>{{ $item->numero }}</td>
                            <td>{{ date('d/m/Y',strtotime($item->fecha_operacion)) }}</td>
                            <td>{{ $item->nombre_tercero }}</td>
                            @if($item->id_banco==3||strpos($item->numero,'E')!== false)
                            <td>{{ $item->numero_factura_remision}}</td>
                            @else
                            <td>{{ $item->numero_cheque_giro}}</td>
                            @endif
                            <td>{{ $item->descripcion_movimiento }}</td>
                            @if($item->modo==1)
                                <td align="right">{{ number_format($item->valor,2,',','.') }}</td>
                                <td></td>
                            @else
                                <td></td>
                                <td align="right">{{ number_format($item->valor,2,',','.') }}</td>
                            @endif
                            <td align="right">{{ number_format($total,2,',','.') }}</td>
                           
                        </tr>
                    @endforeach
                    <tr  style="background:#ccc"  align="center" >
                    <td colspan="5">TOTALES</td>
                    <td>{{ number_format($total_ingreso,2,',','.') }}</td>
                    <td>{{ number_format($total_egreso,2,',','.') }}</td>
                    <td>{{ number_format($total,2,',','.') }}</td>
                   
              </tr>
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
