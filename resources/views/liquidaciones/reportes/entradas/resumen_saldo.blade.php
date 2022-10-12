<?php
   if($excel==2){
   header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
   header("Content-Disposition: attachment; filename=liquidaciones/pendientes.xls");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Cache-Control: private", false);}
   ?>
@if($excel!=2)
<table width="95%">
   <tr>
      <td align="lefth"  width="95%">
         <p >
         <h3>Reporte saldo diferencial detallado</h3>
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
<h3 align="center">Reporte saldo diferencal detallado</h3>
@endif <br>
<table  class="paleBlueRows" style="font-size:100%;margin: 0 auto; " width="70%" border=1>
   <thead>
      <tr style="background-color:#0B6FA4;color:white; " >
         <th >Cliente</th>
         <th width="11%">Numero</th>
         <th>Fecha Operacion</th>
         <th>valor</th>
         <th>saldo</th>
      </tr>
   </thead>
   <tbody>
      @php
      $total_j=0;
      @endphp
      @foreach($data_reporte as $rows)
      @if(isset($rows['proveedor']['giros']))
      @php
      $contador = 0;
      $long = count($rows['proveedor']['giros']);
      $tot_j=0;
      $saldo=0;
      $cont=0;
      $saldo_2=$rows['proveedor']['saldo'];
      $saldo=$rows['proveedor']['saldo'];
      $total_j+=$rows['proveedor']['saldo'];
      @endphp
      @foreach($rows['proveedor']['giros'] as $index => $rowsx)
      @php
      $tot_j+=$rowsx->valor;
      $saldo_2-=$rowsx->valor;
      @endphp
      <tr>
         @if($contador==0)
         <td rowspan="{{ $long }}">
            @php try{ @endphp
            {{ $rows['proveedor']['info']->nombre }}
            @php }catch(\Exception $e){} @endphp
            </th>
            @endif
         <td>GIR-{{ str_pad($rowsx->id,4,'0',STR_PAD_LEFT) }}</td>
         <td>{{date('d/m/Y',strtotime($rowsx->fecha_giro))}} </td>
         <td> {{number_format($rowsx->valor,0,',','.')}}</td>
         <td> {{number_format($rowsx->saldo,0,',','.')}}</td>
         @php
         $contador++;
         @endphp
         @endforeach
      <tr  style="background:#ccc"  align="center" >
         <td colspan="4">TOTAL SALDO</td>
         <td>{{ number_format($saldo,0,',','.') }}</td>
      </tr>
      @endif
      @endforeach
      <tr  style="background:#ccc"  align="center" >
         <td colspan="4">TOTAL GENERAL</td>
         <td>{{ number_format($total_j,0,',','.') }}</td>
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