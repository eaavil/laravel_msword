<?php
$total_general_sacos=0;
$total_general_tulas=0;
if($excel==2){
  header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
  header("Content-Disposition: attachment; filename=Empaques clientes.xls");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);
  $tamaño=4;
}else{
  $tamaño=3;
}
$hora=date("(H:i:s)",time());

?> 

@if($excel!=2)
<table width="100%">
            <tr>
            <td align="lefth"  width="90%"><p >
          <h3>Reporte de movimiento de Empaques</h3>
					Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br><br>
					Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }} {{$hora}}</p>
            <td align="right">
            <p >
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1 </p>
            </td> 
            </tr>
    </table><br>
@else
<h3 align="center">Reporte de movimimentos de Empaques</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
@endif <br>
<table class="paleBlueRows" width="100%" border=1>
	<thead>
	<tr style="background-color:#0B6FA4;color:white;font-size:70%; ">
          <th>Proveedor</th>
          <th>fecha operacion</th>
          <th>Operacion</th>
          <th>Numero ticket</th>
          <th>Tipo empaque</th>
          <th>Saldo Inicial</th>
          <th>Cantidad</th>
          <th>Saldo Final</th>
  </tr>
	</thead>
	<tbody>
        @foreach($data_reporte as $rows)
          @php
            $long = $rows['proveedor']['tamaño'];
            $primera_fila=0;
          @endphp
          
          @if(isset($rows['proveedor']['sacos']))
          @php 
            $contador=0;
            $mostrar_total=0; 
            $saldo_inicial=0;
            $cantidad=0;
            $saldo_final=0;
          @endphp
            @foreach($rows['proveedor']['sacos'] as $indice=>$rowsx)
            @if(date("Y-m-d", strtotime($rowsx->created_at))>=$fecha_inicial && date("Y-m-d", strtotime($rowsx->created_at))<=$fecha_final)
                
            <tr>
                    @if($contador==0)
                    @php 
                          $mostrar_total=1; 
                          $saldo_inicial=$rowsx->total_sacos;
                          $contador++; 
                    @endphp
                    @if($excel!=2 && $primera_fila==0)
                     @php $primera_fila++;  @endphp
                      <td rowspan="{{ $long }}">
                        {{ $rows['proveedor']['info']->nombre }}
                      </td>
                    @endif
                    @endif
                    @if($excel==2)
                    <td>{{ $rows['proveedor']['info']->nombre }}</td>
                    @endif
                    <td>{{$rowsx->created_at}}</td>
                    @if($rowsx->tipo_operacion==1)
                    <td>Egreso</td>
                    <td>movimiento empaque</td>
                    @else
                    <td>Ingreso</td>
                    <td>{{$rowsx->numero_ticket}}</td>
                    @endif
                    <td>Sacos</td>
                    <td>{{number_format($rowsx->total_sacos,0,',','.')}}</td>
                    @if($rowsx->tipo_operacion==1)
                    <td>-{{number_format($rowsx->cantidad,0,',','.')}}</td>
                    @php
                      $cantidad-=$rowsx->cantidad;
                    @endphp
                    @else
                    <td>{{number_format($rowsx->cantidad,0,',','.')}}</td>
                    @php 
                      $cantidad+=$rowsx->cantidad;
                    @endphp
                    @endif
                    <td>{{number_format($rowsx->saldo_sacos,0,',','.')}}</td>
                  </tr> 
              @endif
              @endforeach
              @if($mostrar_total==1)
              <tr  style="background:#ccc" width="75%">
                      <td colspan={{$tamaño}} ></td>
                      <td align="center">TOTAL</td>
                      <td>{{number_format($saldo_inicial,0,',','.')}}</td>
                      <td>{{number_format($cantidad,0,',','.')}}</td>
                      <td>{{number_format($saldo_inicial+$cantidad,0,',','.')}}</td>
                      @php $total_general_sacos+=$saldo_inicial+$cantidad; @endphp
              </tr>
              @endif
            @endif
            @if(isset($rows['proveedor']['tulas']))
            @php 
              $contador=0;
              $mostrar_total=0; 
              $saldo_inicial=0;
              $cantidad=0;
              $saldo_final=0;
            @endphp
            @foreach($rows['proveedor']['tulas'] as $indice=>$rowsx)
            @if(date("Y-m-d", strtotime($rowsx->created_at))>=$fecha_inicial && date("Y-m-d", strtotime($rowsx->created_at))<=$fecha_final)
                <tr>
                    @if($contador==0)
                      @php 
                            $mostrar_total=1; 
                            $saldo_inicial=$rowsx->total_tulas;
                            $contador++;
                      @endphp
                      @if($excel!=2 && $primera_fila==0)
                      @php $primera_fila++;  @endphp
                        <td rowspan="{{ $long }}">
                            {{ $rows['proveedor']['info']->nombre }}
                        </td>
                      @endif
                    @endif
                    @if($excel==2)
                    <td>{{ $rows['proveedor']['info']->nombre }}</td>
                    @endif
                    <td>{{$rowsx->created_at}}</td>
                    @if($rowsx->tipo_operacion==1)
                    <td>Egreso</td>
                    <td>movimiento empaque</td>
                    @else
                    <td>Ingreso</td>
                    <td>{{$rowsx->numero_ticket}}</td>
                    @endif
                    <td>Tulas</td>
                    <td>{{number_format($rowsx->total_tulas,0,',','.')}}</td>
                    @if($rowsx->tipo_operacion==1)
                    <td>-{{number_format($rowsx->cantidad,0,',','.')}}</td>
                    @php
                      $cantidad-=$rowsx->cantidad;
                    @endphp
                    @else
                    <td>{{number_format($rowsx->cantidad,0,',','.')}}</td>
                    @php 
                      $cantidad+=$rowsx->cantidad;
                    @endphp
                    @endif
                    <td>{{number_format($rowsx->saldo_tulas,0,',','.')}}</td>
                 </tr>
                @endif
                
              @endforeach
              @if($mostrar_total==1)
              <tr  style="background:#ccc" width="75%">
                      <td colspan={{$tamaño}} ></td>
                      <td align="center">TOTAL</td>
                      <td>{{number_format($saldo_inicial,0,',','.')}}</td>
                      <td>{{number_format($cantidad,0,',','.')}}</td>
                      <td>{{number_format($saldo_inicial+$cantidad,0,',','.')}}</td>
                      @php $total_general_tulas+=$saldo_inicial+$cantidad; @endphp
              </tr>
              @endif
            @endif
        @endforeach
        <tr  style="background:#ccc" width="75%">
           <td colspan={{7}} align="right" > TOTAL GENERAL SACOS</td>
           
          <td>{{number_format($total_general_sacos,0,',','.')}}</td>
        </tr>
        <tr  style="background:#ccc" width="75%">
          <td colspan={{7}} align="right"> TOTAL GENERAL TULAS</td>
          <td>{{number_format($total_general_tulas,0,',','.')}}</td>
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
  .paleBlueRows {
    width="70%";
  
}

	table.paleBlueRows thead th {
	  font-size: 11px !important;
	  font-weight: bold;
	  color: black;
	  text-align: center;
	  padding: 1px;
	  border-left: 2px solid #000;
    width="5%";
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
  font-size:14px;
  text-align:center;
  font-weight: bold;
}
</style>
