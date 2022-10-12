<?php
   if($excel==2){
   header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
   header("Content-Disposition: attachment; filename=corte_entradas/salidas_cafe.xls");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Cache-Control: private", false);}
   ?> 

@if($excel!=2)
<button class=" boton oculto" onclick="location.href = document.referrer; return false;">Volver</button>
<table width="100%">
   <tr>
      <td align="lefth">
         <h3>Corte de entradas y salidas de cafe</h3>
         <br>
         Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br> <br>
         Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}{{date(" (H:i:s)",time())}}
      </td>
      <td align="right">
         <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
         NIT. 901383798-1
      </td>
   </tr>
</table>
<br>
@else

<h3 align="lefth">Corte de entradas y salidas de cafe</h3>
<p >Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
<p >Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>
@endif
<table class="paleBlueRows" width="100%" border=1>
   <thead>
      <tr style="background-color:#0B6FA4;color:white;font-size:70%; " >
         <th>Numero</th>
         <th>fecha </th>
         <th>Proveedor/Cliente</th>
         <th>Mes entrega</th>
         <th>Año entrega</th>
         <th>Producto</th>
         <th>Factor</th>
         <th>kilos Netos</th>
         <th>Porcentaje del factor</th>
      </tr>
   </thead>
   <tbody>
      {{$mes=""}}
      @if($saldo_ant!=null&&$saldo_ant>0)
      <tr style="background-color: #EAD9AC ;font-size:70%;">
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td>SALDO</td>
         <td>{{$factor_saldo}}</td>
         <td>{{number_format($saldo_ant,0,',','.')}} </td>
         <td>{{$total_factor_aportante_saldo}} </td>
      </tr>
      @endif
      @foreach($entradas_cafe as $rows)
      <tr style="background-color: #C1DFF4;font-size:70%;" >
         <td>{{$rows->numero_ticket}}</td>
         <td>{{date('d/m/Y',strtotime($rows->fecha_ticket))}}</td>
         <td>{{$rows->nombre}}</td>
         <?php
            switch(date("m", strtotime($rows->fecha_ticket)))
                       {   
                         case 01:
                         $mes = "Enero";
                         break;
                         case 02:
                         $mes= "Febrero";
                         break;
                         case 03:
                         $mes = "Marzo";
                         break;
                         case 04:
                         $mes = "Abril";
                         break;
                         case 05:
                         $mes = "Mayo";
                         break;
                         case 06:
                         $mes = "Junio";
                         break;
                         case 07:
                         $mes = "Julio";
                         break;
                         case 8:
                         $mes = "Agosto";
                         break;
                         case 9:
                         $mes = "Septiembre";
                         break;
                         case 10:
                         $mes = "Octubre";
                         break;
                         case 11:
                         $mes = "Noviembre";
                         break;
                         case 12:
                         $mes = "Diciembre";
                         break;
                       }
            ?>
         <td>{{$mes}}</td>
         <td>{{date("Y", strtotime($rows->created_at))}}</td>
         <td>{{$rows->tipo_cafe}}</td>
         <td>{{$rows->factor}}</td>
         @php try{ @endphp
         <td>{{number_format($rows->peso_neto,0,',','.') }}</th>
            @php }catch(\Exception $e){ @endphp
         <td>{{$rows->peso_neto}}</th>
            @php } @endphp
         <td>{{$rows->factor_aportante}}</th>
            @endforeach
            @foreach($salidas_cafe as $rows)
      <tr style="background-color: #EBC1F4;font-size:70%;">
         <td>{{$rows->numero_ticket}}</td>
         <td>{{date('d/m/Y',strtotime($rows->fecha_ticket_salida))}}</td>
         <td>{{$rows->nombre}}</td>
         <?php
            switch(date("m", strtotime($rows->fecha_ticket_salida)))
                       {   
                         case 01:
                         $mes = "Enero";
                         break;
                         case 02:
                         $mes= "Febrero";
                         break;
                         case 03:
                         $mes = "Marzo";
                         break;
                         case 04:
                         $mes = "Abril";
                         break;
                         case 05:
                         $mes = "Mayo";
                         break;
                         case 06:
                         $mes = "Junio";
                         break;
                         case 07:
                         $mes = "Julio";
                         break;
                         case 8:
                         $mes = "Agosto";
                         break;
                         case 9:
                         $mes = "Septiembre";
                         break;
                         case 10:
                         $mes = "Octubre";
                         break;
                         case 11:
                         $mes = "Noviembre";
                         break;
                         case 12:
                         $mes = "Diciembre";
                         break;
                       }
            ?>
         <td>{{$mes}}</td>
         <td>{{date("Y", strtotime($rows->fecha_ticket_salida))}}</td>
         <td>{{$rows->tipo_cafe}}</td>
         <td>{{$rows->factor_liquidacion}}</td>
         @php try{ @endphp
         <td>{{number_format($rows->peso_neto,0,',','.') }}</th>
            @php }catch(\Exception $e){ @endphp
         <td>{{$rows->peso_neto}}</th>
            @php } @endphp
         <td>{{$rows->factor_aportante}}</th>
            @endforeach
   </tbody>
</table>
<br>
<table class=" paleBlueRows"  style="background-color: #C1DFF4;font-size:90%;"  width="100%" border=1>
   <tbody>
      <tr>
         <th width="51.5%" >Total kilos entradas de cafe: {{number_format($total_kilos_netos,0,',','.')}}</th>
         <th>Total porcentaje del factor: {{$total_factor_aportante}} </th>
      </tr>
   </tbody>
</table>
<br>
<table class="paleBlueRows" style="background-color: #EBC1F4;font-size:90%;"  width="100%" border="solid">
<tbody>
   <tr>
      <th width="51.5%" >Total kilos salidas de cafe: {{number_format($total_kilos_netos_salidas,0,',','.')}}</th>
      <th >Total porcentaje del factor: {{$total_factor_aportante_salida}}</th>
   </tr>
</tbody>
<br>
</table class=" paleBlueRows"> <br>
<div  align="center"><strong >SALDOS Y PROMEDIOS ENTRE ENTRADA Y SALIDA DE CAFE</strong></div>
<table class=" paleBlueRows" style="background-color: #9EFD8E ;font-size:90%;" width="20%" border=1 align="right">
   <thead>
      <tr>
      </tr>
   </thead>
</table>
<br>
<table class=" paleBlueRows" style="background-color: #EAD9AC ;font-size:90%;" width="100%" border=1>
   <tbody>
      <tr>
         <th width="51.5%">saldo en kilos de entradas menos salidas: {{number_format($total_kilos_netos-$total_kilos_netos_salidas,0,',','.')}}</th>
         <th>porcentaje del factor de las entradas menos las salidas: {{round($total_factor_aportante-$total_factor_aportante_salida,2)}}  </th>
      </tr>
   </tbody>
</table>
<button class=" oculto btn boton" onclick="location.href = document.referrer; return false;">Volver</button>
<style>
   .boton{
   text-decoration: none;
   padding: 10px;
   font-weight: 600;
   font-size: 20px;
   color: #ffffff;
   background-color: #1883ba;
   border-radius: 6px;
   border: 2px solid #0016b0;
   }
   table.pale {
   font-family: "Arial";
   border: 1px solid #000;
   text-align: center;
   border-collapse: collapse;
   }
   table.ventas {
   background-color: #D0E4F5;
   }
   table.tr.compras{
   background-color: #D0E4F5;
   }
   strong{
   font-size:15px;
   text-align:center;
   }
   p{
   font-size:17px;
   text-align:center;
   font-weight: bold;
   }
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
   background-color: #D0E4F5;
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
   .oculto {display:none}
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
</style>