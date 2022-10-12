<?php
if($excel==1){
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$titulo_reporte/Salidas.xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);}


?> 
@if($excel!=1)
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="row" align="center">
        <div class="col-10">
        <h3>{{$titulo_reporte}}</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
        </div>
        <div class="col-2">
        <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250" height="85" align="right">
        <p>NIT. 901383798-1 </p>
        </div>
</div><br>
@else
<h3 align="center">{{$titulo_reporte}}</h3>
@endif
<table class="paleBlueRows" width="70%" border=1 align="center">
	<thead>
	<tr style="background-color:#0B6FA4;color:white;font-size:80%; ">
          <th >Proveedor</th>
          <th>Fecha</th>
          <th>Entrada</th>
          <th>Placa</th>
          <th>Producto</th>
          <th>Total</th>
        </tr>
	</thead>
	<tbody>
	<tbody>  @php
           $totales=0;
           @endphp
        @foreach($data_reporte as $rows)
           @php
           $total_cliente=0;
           $long = count($rows['proveedor']['data']);
           @endphp
           <tr>
          <td rowspan="{{ $long }}" align="center">
					
							{{ $rows['proveedor']['info']->nombre }}
          </th>
           @foreach($rows['proveedor']['data'] as $index => $rowsx)
           @php
           $total_cliente+=$rowsx->peso_neto-$rowsx->liquidado;
           $totales+=$rowsx->peso_neto-$rowsx->liquidado;
           @endphp
           <td>{{ date('d/m/Y',strtotime($rowsx->fecha)) }}</th>
          <td><?php try{ ?> {{ $rowsx->entrada[0]->numero_ticket }} <?php }catch(\Exception $e){ ?> - <?php } ?></th>
          <td>{{ $rowsx->entrada[0]->placa }}</th>
          <td><?php try{ ?> {{ $rowsx->cafe->tipo_cafe }} <?php }catch(\Exception $e){ ?> - <?php } ?></th>
          <td>{{ number_format($rowsx->peso_neto-$rowsx->liquidado,0,',','.') }}</th>
                </tr>

            @endforeach

            <tr  style="background:#ccc" width="75%" >
                    <td colspan="5" align="center" >TOTALES</td>
                    <td >{{ number_format($total_cliente,0,',','.') }}</td>
                   
            </tr>

		@endforeach
	</tbody>

</table><br>
<table  style="background:#ccc" width="70%" align="center" >
	<thead>
    <tr>
    <td ><strong>Total kilos sin liquidar:</strong> {{number_format($totales,0,',','.')}} </td>
   
    </tr>
	</thead>
</table> <br>
<style>
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
