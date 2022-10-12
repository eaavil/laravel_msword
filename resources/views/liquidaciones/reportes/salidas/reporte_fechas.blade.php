<?php
   if($excel==2){
   header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
   header("Content-Disposition: attachment; filename=Liquidaciones/Salidas.xls");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Cache-Control: private", false);}
   ?> 
@if($excel!=2)
<table width="95%">
   <tr>
      <td align="lefth"  width="95%">
         <p >
         <h3>Reporte de Liquidaciones de Salidas</h3>
         Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br><br>
         Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}</p>
      </td>
      <td>
      <td ></td>
      </td>
      <td align="right">
         <p >
            <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
            NIT. 901383798-1 
         </p>
      </td>
   </tr>
</table>
@else
<h3 align="center">Reporte de Liquidaciones de Salidas</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>
@endif <br>
<table class="paleBlueRows" width="80%" border=1 align="center">
   <thead>
      <tr style="background-color:#0B6FA4;color:white;font-size:70%; ">
         <th>Proveedor</th>
         <th>Fecha</th>
         <th>Liquidacion</th>
         <th>Giro</th>
         <th>Entrada</th>
         <th>Contrato</th>
         <th>Entrega</th>
         <th>Placa</th>
         <th>Producto</th>
         <th >Kilos Liquidación</th>
         <th >Descuento</th>
         <th>Valor Arroba</th>
         <th>Café Bruto</th>
         <th>Valor Descuento</th>
         <th>R/Fuente</th>
         <th>Total Café</th>
         <th>4xMil </th>
         <th>Descrpción</th>
         <th>Valor Giro</th>
         <th>Valor Liquidación</th>
         <th>Saldo Proveedor</th>
      </tr>
   </thead>
   <tbody>
      @foreach($data_reporte as $rows)
      @php
      $contador = 0;
      $long = count($rows['proveedor']['data']);
      $tot_a = 0;
      $tot_b = 0;
      $tot_c = 0;
      $tot_d = 0;
      $tot_e = 0;
      $tot_f = 0;
      $tot_g = 0;
      $tot_h = 0;
      if($esproveedor){
      $tot_i =$saldo_acomulado;
      }else{
      $tot_i =$rows['proveedor']['saldo_acomulado'];
      }
      $tot_j = 0;
      $tot_k = 0;
      @endphp
      @foreach($rows['proveedor']['data'] as $index => $rowsx)
      <tr>
         @if($contador==0&&$excel!=2)
         <td rowspan="{{ $long }}">
            @php try{ @endphp
            {{ $rows['proveedor']['info']->nombre }}
            @php }catch(\Exception $e){} @endphp
            </th>
            @endif 
            @if($excel==2)
         <td >
            @php try{ @endphp
            {{ $rows['proveedor']['info']->nombre }}
            @php }catch(\Exception $e){} @endphp</th>
            @endif
            <?php try{ ?>
            <?php $rowsx->entrada[0]->placa ?>
         <td>{{ date('d/m/Y',strtotime($rowsx->fecha_liquidacion)) }}</th>
         <td>{{ $rowsx->numero }}</th>
         <td>-</th>
         <td><?php try{ ?> {{ $rowsx->entrada[0]->numero_ticket }} <?php }catch(\Exception $e){ ?> - <?php } ?></th>
         <td><?php try{ ?> {{ $rowsx->contrato->numero }}<?php }catch(\Exception $e){ ?> - <?php } ?></th>
         <td><?php try{ ?> {{ $rowsx->centros->descripcion }} <?php }catch(\Exception $e){ ?> - <?php } ?></th>
         <td>{{ $rowsx->entrada[0]->placa }}</th>
         <td><?php try{ ?> {{ $rowsx->cafe->tipo_cafe }} <?php }catch(\Exception $e){ ?> - <?php } ?></th>
         <td>{{ number_format($rowsx->kilogramos,0,',','.') }}</th>
            @if($rowsx->descuento_factor<0)
         <td>{{ number_format(abs($rowsx->descuento_factor),2,',','.') }}</th>
            @else
         <td>-{{ number_format($rowsx->descuento_factor,2,',','.') }}</th>
            @endif
            @if($rowsx->contrato->precio_arroba==0)
         <td>{{ number_format($rowsx->valor_arroba,0,',','.') }}</th>
            @else
         <td>{{ number_format($rowsx->contrato->precio_arroba,0,',','.') }}</th>
            @endif
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
         <td>Valor Liquidacion</th>
         <td>0</th>
         <td>{{ number_format($rowsx->total,0,',','.') }}</th>
         <td>{{ number_format($tot_i-$rowsx->total,0,',','.') }}</th>
            <?php }catch(\Exception $e){ ?>
         <td>{{ date('d/m/Y',strtotime($rowsx->fecha_giro)) }}</th>
         <td></th>
         <td>GIR{{ $rowsx->id }}</th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td></th>
         <td>Valor Liquidacion</th>
            @php try{ @endphp
         <td>{{ number_format($rowsx->valor,0,',','.') }}</th>
            @php }catch(\Exception $e){ @endphp
         <td>{{ $rowsx->valor }}</th>
            @php } @endphp
         <td>0</th>
            @php try{ @endphp
         <td>{{ number_format($tot_i+$rowsx->valor,0,',','.') }}</th>
            @php }catch(\Exception $e){} @endphp
            <?php } ?>
      </tr>
      @php
      try{
      $rowsx->entrada[0]->numero_ticket;
      $tot_a+=$rowsx->kilogramos;
      $tot_b+=$rowsx->descuento_factor;
      $tot_c+=$rowsx->valor_arroba;
      if($rowsx->descuento_factor<0){
      $tot_d+=$rowsx->valor_bruta-$rowsx->valor_descuento;
      }else{
      $tot_d+=$rowsx->valor_bruta+$rowsx->valor_descuento;
      }
      if($rowsx->descuento_factor<0){
      $tot_e+=$rowsx->valor_descuento;
      }else{
      $tot_e-=$rowsx->valor_descuento;
      }
      $tot_f+=$rowsx->valor_retencion_fuente;
      $tot_g+=$rowsx->valor_bruta;
      $tot_h+=$rowsx->valor_retencion_4_mil;
      $tot_j+=$rowsx->total;
      $tot_i-=$rowsx->total;
      $tot_k-=0;
      }catch(\Exception $e){
      try{
      $tot_i+=$rowsx->valor;
      $tot_k+=$rowsx->valor;
      }catch(\Exception $e){}
      $tot_j+=0;
      }
      $contador++;
      @endphp
      @endforeach
      <tr  style="background:#ccc" width="75%" align="center">
         <td colspan="9">TOTALES</td>
         <td>{{ number_format($tot_a,0,',','.') }}</td>
         <td></td>
         <td></td>
         <td>{{ number_format($tot_d,0,',','.') }}</td>
         <td>{{ number_format($tot_e,0,',','.') }}</td>
         <td>{{ number_format($tot_f,0,',','.') }}</td>
         <td>{{ number_format($tot_g,0,',','.') }}</td>
         <td>{{ number_format($tot_h,0,',','.') }}</td>
         <td></td>
         <td>{{ number_format($tot_k,0,',','.') }}</td>
         <td>{{ number_format($tot_j,0,',','.') }}</td>
         <td>{{ number_format($tot_i,0,',','.') }}</td>
      </tr>
      @endforeach
   </tbody>
</table>
<br>
@if($operaciones!=null)
<h3 align="center">Contratos Pendientes:</h3>
<br>
<table  class="paleBlueRows" style="font-size:80%;margin: 0 auto; " width="80%" border=1 align="center">
   <thead>
      <tr style="background-color:#0B6FA4;color:white; " >
         <th >Cliente</th>
         <th width="11%">Numero</th>
         <th>Kilos Compromiso</th>
         <th>Kilos Liquidados</th>
         <th>Saldo</th>
         <th>Tipo Producto</th>
         <th>Valor Arroba</th>
      </tr>
   </thead>
   @php
   $total_saldo=0;
   @endphp 
   <tbody>
      @foreach($operaciones as $rows)
      @php
      $total_saldo+=$rows->kilos_compromiso-$rows->kilos_entregados;
      @endphp 
      <tr>
         <td>
            {{$rows->nombre}}<br>NIT:{{$rows->nit}}-{{$rows->digito_verificacion_nit}}
            <br>Actualizado el:{{date('d/m/Y',strtotime($rows->contrato_updated_at))}}
         </td>
         </td>
         <td>{{$rows->numero}} <br> Creado el:{{date('d/m/Y',strtotime($rows->fecha_contrato))}} <br>
         <td> {{number_format($rows->kilos_compromiso,0,',','.')}}</td>
         <td> {{number_format($rows->kilos_entregados,0,',','.')}}</td>
         <td> {{number_format($rows->kilos_compromiso-$rows->kilos_entregados,0,',','.')}}</td>
         <td>{{$rows->tipo_cafe}}</td>
         @php try{ @endphp
         <td>{{ number_format($rows->precio_arroba,0,',','.') }}</th>
            @php }catch(\Exception $e){ @endphp
         <td>{{ $rows->precio_arroba}}</th>
            @php } @endphp
      </tr>
      @endforeach 
      <tr  style="background:#ccc" width="75%" align="center">
         <td colspan="4">TOTAL SALDO</td>
         <td>{{ number_format($total_saldo,0,',','.') }}</td>
         <td></td>
         <td></td>
      </tr>
   </tbody>
   <tfoot>
   </tfoot>
</table>
@endif
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