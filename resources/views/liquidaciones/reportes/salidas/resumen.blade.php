<table width="100%">
   <tr>
      <td align="center"  width="100%">
         <p >
         <h2>LISTADO RESUMEN POR CLIENTES</h2>
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
<br>
<input id="myInput" type="text" class="oculto" placeholder="Filtrar" style="float:right; margin:1%">
<table class="paleBlueRows" width="100%">
   <thead>
      <tr>
         <th>Cliente</th>
         <th>Kilos por Liquidar</th>
         <th>Kilos Liquidados</th>
         <th>Total Anticipos</th>
         <th>Total Liquidaciones</th>
         <th>Saldo Diferencia</th>
         <th>Kilos en Bodega</th>
         <th>Valor Kilos</th>
         <th>Saldo Real</th>
      </tr>
   </thead>
   <tbody>
      @php
      $tot_a = 0;
      $tot_b = 0;
      $tot_c = 0;
      $tot_d = 0;
      $tot_e = 0;
      $tot_f = 0;
      $tot_g = 0;
      $tot_h = 0;
      @endphp
      </th>
      @foreach($data as $registros)
      @php
      $saldo=0;
      if($registros->kilos_pendientes!=0){
      $saldo=$registros->valor_en_kilos;
      }else{
      $saldo=0;
      }
      $tot_h+=($registros->total_giros-$registros->total_valor_liquidaciones)-$saldo;
      @endphp
      @if(($registros->kilos_pendientes_scontrato+$registros->kilos_pendientes_ccontrato+$registros->kilos_liquidados+$registros->total_giros+($registros->total_giros-$registros->total_valor_liquidaciones)+($registros->valor_en_kilos)+($registros->valor_en_kilos-($registros->total_giros-$registros->total_valor_liquidaciones)))!=0)
      <tr>
         <td><a  href="{{route('liquidaciones.salidas.reporte.detalle')}}?id={{$registros->id}}&&cliente={{ $registros->nombre }}"  target="__blank"   style="float:left">{{ $registros->nombre }}</a></td>
         <td>{{ number_format($registros->kilos_pendientes_scontrato+$registros->kilos_pendientes_ccontrato,0,',','.') }}</td>
         <td>{{ number_format($registros->kilos_liquidados,0,',','.') }}</td>
         <td>{{ number_format($registros->total_giros,0,',','.') }}</td>
         <td>{{ number_format($registros->total_valor_liquidaciones,0,',','.') }}</td>
         <td>{{ number_format($registros->total_giros-$registros->total_valor_liquidaciones,0,',','.') }}</td>
         <td>
            {{ number_format($registros->kilos_pendientes,0,',','.') }}
         </td>
         <td>
            @if($registros->kilos_pendientes!=0)
            {{ number_format($registros->valor_en_kilos,0,',','.') }}
            @else
            0
            @endif
         <td>
            {{ number_format(($registros->total_giros-$registros->total_valor_liquidaciones)-$saldo,0,',','.') }}
      </tr>
      @php
      $tot_a+= ($registros->kilos_pendientes_scontrato+$registros->kilos_pendientes_ccontrato);
      $tot_b+= $registros->kilos_liquidados;
      $tot_c+= $registros->total_giros;
      $tot_d+= $registros->total_valor_liquidaciones;
      $tot_e+= $registros->total_giros-$registros->total_valor_liquidaciones;
      $tot_f+= $registros->kilos_pendientes;
      $tot_g+= $registros->valor_en_kilos;
      @endphp
      @endif
      @endforeach
      <tr class="totales">
         <td >TOTALES</td>
         <td>{{ number_format($tot_a,0,',','.') }}</td>
         <td>{{ number_format($tot_b,0,',','.') }}</td>
         <td>{{ number_format($tot_c,0,',','.') }}</td>
         <td>{{ number_format($tot_d,0,',','.') }}</td>
         <td>{{ number_format($tot_e,0,',','.') }}</td>
         <td>{{ number_format($tot_f,0,',','.') }}</td>
         <td>{{ number_format($tot_g,0,',','.') }}</td>
         <td>{{ number_format($tot_h,0,',','.') }}</td>
      </tr>
   </tbody>
</table>
<style>
   table.paleBlueRows {
   font-family: "Arial";
   font-weight:bold;
   border: 1px solid #000;
   text-align: center;
   border-collapse: collapse;
   }
   table.paleBlueRows td, table.paleBlueRows th {
   border: 1px solid #000;
   }
   table.paleBlueRows tbody td {
   font-size: 11px;
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
   .oculto {display:none}
   table.paleBlueRows thead th {
   font-size: 10px !important;
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
   font-size: 11px;
   }
   p{
   font-size:17px;
   text-align:center;
   font-weight: bold;
   }
</style>
<script
   src="https://code.jquery.com/jquery-3.5.1.min.js"
   integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
   crossorigin="anonymous"></script>
<script>
   $(document).ready(function(){
     $("#myInput").on("keyup", function() {
   	var value = $(this).val().toLowerCase(); 
      return value;
   	$(".paleBlueRows tbody tr").filter(function(e) {
   		console.log(e);
   	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
   	});
     });
   });
</script>