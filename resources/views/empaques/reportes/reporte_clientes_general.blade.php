<?php
$total_general_sacos=0;
$total_general_tulas=0;
if($excel==2){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Empaques clientes.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
$hora=date(" (H:i:s)",time());
?> 

@if($excel!=2)
<table width="100%">
            <tr>
            <td align="lefth"  width="90%"><p >
          <h3>Reporte de general de Empaques</h3>
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
          <th>CLiente</th>
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
            $cont=0;
          @endphp
          
          @if(isset($rows['proveedor']['sacos']))
            
                <tr>  @if($excel!=2 )
                      <td rowspan="{{ $long }}">
                        @php try{ @endphp
                          {{ $rows['proveedor']['info']->nombre }}
                        @php }catch(\Exception $e){
                        echo $e->getMessage(); 
                        }
                        $cont++;
                        @endphp
                      </td>
                    @endif
                    @if($excel==2)
                    <td>{{ $rows['proveedor']['info']->nombre }}</td>
                    @php
                    $cont++;
                    @endphp
                    @endif
                      <td >Sacos</td>
                      <td>{{number_format($rows['proveedor']['saldo_sacos']-$rows['proveedor']['cantidad_sacos'],0,',','.')}}</td>
                      <td>{{number_format($rows['proveedor']['cantidad_sacos'],0,',','.')}}</td>
                      <td>{{number_format($rows['proveedor']['saldo_sacos'],0,',','.')}}</td>
                      @php $total_general_sacos+=$rows['proveedor']['saldo_sacos']; @endphp
                    </tr>
            @endif
            @if(isset($rows['proveedor']['tulas']))
            
                <tr>@if($excel!=2 && $cont==0)
                      <td rowspan="{{ $long }}">
                        @php try{ @endphp
                          {{ $rows['proveedor']['info']->nombre }}
                        @php }catch(\Exception $e){
                        echo $e->getMessage(); 
                        }
                        @endphp
                      </td>
                    @endif
                    @if($excel==2)
                    <td>{{ $rows['proveedor']['info']->nombre }}</td>
                    @endif
                      <td>Tulas</td>
                      <td>{{number_format($rows['proveedor']['saldo_tulas']-$rows['proveedor']['cantidad_tulas'],0,',','.')}}</td>
                      <td>{{number_format($rows['proveedor']['cantidad_tulas'],0,',','.')}}</td>
                      <td>{{number_format($rows['proveedor']['saldo_tulas'],0,',','.')}}</td>
                      @php $total_general_tulas+=$rows['proveedor']['saldo_tulas']; @endphp
                      
                  
              </tr>
            @endif
        @endforeach
        <tr  style="background:#ccc" width="75%">
          <td colspan=4 align="right" > TOTAL GENERAL SACOS</td>
          <td>{{number_format($total_general_sacos,0,',','.')}}</td>
        </tr>
        <tr  style="background:#ccc" width="75%">
          <td colspan=4 align="right"> TOTAL GENERAL TULAS</td>
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
