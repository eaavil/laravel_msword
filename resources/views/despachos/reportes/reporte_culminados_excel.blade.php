<?php
if($excel==1){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=despachos_culminados.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
?> 
@if($excel!=1)
<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>Reporte Despachos culminados</h3>
					Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br><br>
					Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}} </p>
            </td><td><td ></td></td>
            <td align="right">
            <p >
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1 </p>
            </td> 
            </tr>
    </table>
@else
<h3 align="center">Reporte Despachos culminados</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
@endif <br>
<table class="paleBlueRows"  style="font-size:85%; margin: 0 auto; " width="70%" border=1>
	<thead>
	<tr style="background-color:#0B6FA4; color:white;"  " >
  
                  <th>Cliente</th>
                  <th>Despacho</th>
                  <th>Salida</th>
                  <th>Fecha</th>
                  <th>Kilogramos</th>
                  <th>Factor %</th>
                  <th>Factor despacho</th>
                  <th>Factor liquidacion</th>
                  <th>Valor del Despacho</th>
                </tr>
                </thead>  @foreach($data_reporte as $rows)
                @php
                  $long = count($rows['proveedor']['data']);
                  $nombre=$rows['proveedor']['info'];
                @endphp
                @foreach($rows['proveedor']['data'] as $indice=>$rowsx)
               
                <tr>
                @if($indice==0 && $excel!=1)
                  <td rowspan="{{ $long }}">
                    @php try{ @endphp
                      {{ $nombre}}
                    @php }catch(\Exception $e){
                    echo $e->getMessage(); 
                    }
                    @endphp
                  </td>
                @endif
                @if($excel==1)
                <td>{{$nombre}}</td>
                @endif
                  <td>{{$rowsx->numero}}</td>
                  <td>{{$rowsx->numero_ticket}}</td>
                  <td> {{ date('d/m/Y',strtotime($rowsx->fecha)) }}</td>
                  <td>{{ number_format($rowsx->kilogramos,0,',','.') }}</td>
                  <td>{{$rowsx->factor_promedio}}</td>
                  <td>{{$rowsx->factor_promedio_referencia}}</td>
                  <td>{{$rowsx->factor_liquidacion+$rowsx->descuento_factor}}</td>
                  <td>{{number_format($rowsx->factor_promedio-($rowsx->factor_liquidacion+$rowsx->descuento_factor),2,',','.')}}</td>
                </tr>
                @endforeach
                @endforeach
                <tbody>
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

