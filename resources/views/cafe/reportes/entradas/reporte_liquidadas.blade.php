<?php
if($excel==1){
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$titulo_reporte.xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);}


?> 

@if($excel!=1)
<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>{{$titulo_reporte}} </h3>
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
<h3 align="center">{{$titulo_reporte}}</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>
@endif <br>
<table class="paleBlueRows" width="75%" border=1 align="center">
	<thead>
	<tr style="background-color:#0B6FA4;color:white;font-size:80%; ">
          <th width="50%">Proveedor</th>
          <th>Fecha</th>
          <th>Liquidacion</th>
          <th>Entrada</th>
          <th>Contrato</th>
          <th>Placa</th>
          <th>Producto</th>
          <th>Kilos Liquidación</th>
          <th>Descuento</th>
          <th>Valor Arroba</th>
          <th>Café Bruto</th>
          <th>Valor Descuento</th>
          <th>R/Fuente</th>
          <th>Total Café</th>
          <th>4xMil </th>
          <th>Valor Liquidación</th>
        
        </tr>
	</thead>
	<tbody>  @php
           $total_kilos=0;
           $total_valor=0;
          
           @endphp
        @foreach($data_reporte as $rows)
           @php
           $long = count($rows['proveedor']['data']);
           $total_kilo_proveedor=0;
           $total_valor_proveedor=0;
           @endphp
           <tr>
          <td rowspan="{{ $long }}">
					
							{{ $rows['proveedor']['info']->nombre }}
          </th>
           @foreach($rows['proveedor']['data'] as $index => $rowsx)
           @php
         
           $total_kilos+=$rowsx->kilogramos;
           $total_valor+=$rowsx->total;
           $total_kilo_proveedor+=$rowsx->kilogramos;
           $total_valor_proveedor+=$rowsx->total;
           @endphp
           <td>{{ date('d/m/Y',strtotime($rowsx->fecha)) }}</th>
           <td>{{ ($rowsx->numero)}}</th>
          <td><?php try{ ?> {{ $rowsx->entrada[0]->numero_ticket }} <?php }catch(\Exception $e){ ?> - <?php } ?></th>
          <td><?php try{ ?> {{ ($rowsx->contrato->numero)}} <?php }catch(\Exception $e){ ?> - <?php } ?></th>

          <td>{{ $rowsx->entrada[0]->placa }}</th>

          <td><?php try{ ?> {{ $rowsx->cafe->tipo_cafe }} <?php }catch(\Exception $e){ ?> - <?php } ?></th>
          <td>{{ number_format($rowsx->kilogramos,0,',','.') }}</th>
          @if($rowsx->descuento_factor<0)
          <td>{{ number_format(abs($rowsx->descuento_factor),2,',','.') }}</th>
          @else
          <td>-{{ number_format($rowsx->descuento_factor,2,',','.') }}</th>
          @endif
          <?php try{ ?> 
          @if($rowsx->contrato->precio_arroba==0)
          <td>{{ number_format($rowsx->valor_arroba,0,',','.') }}</th>
          @else
          <td>{{ number_format($rowsx->contrato->precio_arroba,0,',','.') }}</th>
          @endif
          <?php }catch(\Exception $e){ ?> - <?php } ?>
          @if($rowsx->descuento_factor<0)
          <td>{{ number_format($rowsx->valor_bruta-$rowsx->valor_descuento,0,',','.') }}</th>
          @else
          <td>{{ number_format($rowsx->valor_bruta+$rowsx->valor_descuento,0,',','.') }}</th>
          @endif
          @if($rowsx->descuento_factor<0)
          <td>{{ number_format($rowsx->valor_descuento,0,',','.') }}</th>
          @else
          <td>-{{ number_format($rowsx->valor_descuento,0,',','.') }}</th>
          @endif
          <td>{{ number_format($rowsx->valor_retencion_fuente,0,',','.') }}</th>
          @if($rowsx->descuento_factor<0)
          <td>{{ number_format($rowsx->valor_bruta,0,',','.') }}</th>
          @else
          <td>{{ number_format($rowsx->valor_bruta,0,',','.') }}</th>
          @endif
          <td>{{ number_format($rowsx->valor_retencion_4_mil,0,',','.') }}</th>
          <td>{{ number_format($rowsx->total,0,',','.') }}</th>
          </tr>

          @endforeach

            <tr  style="background:#ccc" width="75%" align="center">
                    <td colspan="7">TOTALES</td>
                    <td>{{ number_format($total_kilo_proveedor,0,',','.') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($total_valor_proveedor,0,',','.') }}</td>
                   
            </tr>

		@endforeach
	</tbody>

</table><br>
<table  style="background:#ccc" width="75%" align="center" >
	<thead>
    <tr>
    <td align="right" width="52%" ><strong>Total kilos liquidacion:</strong> {{number_format($total_kilos,0,',','.')}} </td>
    <td align="right"><strong>Total valor liquidacion:</strong> {{number_format($total_valor,0,',','.')}} </td>
    </tr>
	</thead>
</table> <br>
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
