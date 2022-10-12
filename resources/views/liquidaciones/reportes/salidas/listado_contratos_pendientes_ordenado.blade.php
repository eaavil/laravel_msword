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
<table  class="paleBlueRows" style="font-size:100%;margin: 0 auto; " width="70%" border=1>
	<thead>
	<tr style="background-color:#0B6FA4;color:white; " >
                 <th >Cliente</th>
                 <th width="11%">Numero</th>
                  <th>Fecha Operacion</th>
                  <th>Kilos Compromiso</th>
                  <th>Kilos Liquidados</th>
                  <th>Saldo</th>
                  <th>Tipo Producto</th>
                  <th>Valor Arroba</th>
                  <th>Valor Contrato</th>
                  
                  
                </tr>
                </thead> 
                <tbody>@php
                $total_j=0;
                $total_k=0;
                $total_l=0;
                @endphp
        @foreach($data_reporte as $rows)
            @php
               $contador = 0;
                $long = count($rows['proveedor']['data']);
                $tot_j = 0;
                $tot_k = 0;
                $tot_l = 0;
            @endphp
            @foreach($rows['proveedor']['data'] as $index => $rowsx)
            @php
            $tot_j+=$rowsx->kilos_compromiso;
            $total_j+=$rowsx->kilos_compromiso;
            $tot_k+=$rowsx->valor_contrato;
            $total_k+=$rowsx->valor_contrato;
            $tot_l+=$rowsx->kilos_compromiso-$rowsx->kilos_entregados;
            $total_l+=$rowsx->kilos_compromiso-$rowsx->kilos_entregados;
            @endphp
                <tr>
                    @if($contador==0)
                        <td rowspan="{{ $long }}">
                    @php try{ @endphp
                      {{ $rows['proveedor']['info']->nombre }}
                    @php }catch(\Exception $e){} @endphp
						        </th>
                    @endif
                    <td>{{$rowsx->numero}} </td>
                    <td>{{date('d/m/Y',strtotime($rowsx->fecha_contrato))}} </td>
                        <td> {{number_format($rowsx->kilos_compromiso,0,',','.')}}</td>
                        <td> {{number_format($rowsx->kilos_entregados,0,',','.')}}</td>
                        <td> {{number_format($rowsx->kilos_compromiso-$rowsx->kilos_entregados,0,',','.')}}</td>
                        <td>{{$rowsx->tipo_cafe}}</td>
                        <td>{{number_format($rowsx->precio_arroba,0,',','.')}}</td>
                        <td>{{number_format($rowsx->valor_contrato,0,',','.')}} </td>
                       @php
                       $contador++;
                       @endphp

            @endforeach

						<tr  style="background:#ccc"  align="center" >
                    <td colspan="3">TOTAL</td>
                   
                    <td>{{ number_format($tot_j,0,',','.') }}</td>
                    <td ></td>
                    <td >{{ number_format($tot_l,0,',','.') }}</td>
                    <td ></td>
                    <td ></td>
                    <td>{{ number_format($tot_k,0,',','.') }}</td>
                   
              </tr>

		@endforeach
    
    <tr  style="background:#ccc"  align="center" >
                    <td colspan="3">TOTAL GENERAL</td>
                   
                    <td>{{ number_format($total_j,0,',','.') }}</td>
                    <td ></td>
                    <td >{{ number_format($total_l,0,',','.') }}</td>
                    <td ></td>
                    <td ></td>
                    <td>{{ number_format($total_k,0,',','.') }}</td>
                   
              </tr>
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
  font-size:13px;
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
  font-size: 13px !important;
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
	  font-size: 13px !important;
	  font-weight: bold;
	  color: black;
	  text-align: center;
	  padding: 5px;
	  border-left: 2px solid #000;
	}
	table.paleBlueRows tfoot {
	  font-size: 13px;
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
  font-size: 13px;
  font-weight: bold;
  color: #333333;
  background: #D0E4F5;
  border-top: 2px solid #444444;
}
table.paleBlueRows tfoot td {
  font-size:13px;
}
p{
  font-size:17px;
  text-align:center;
  font-weight: bold;
}
</style>
