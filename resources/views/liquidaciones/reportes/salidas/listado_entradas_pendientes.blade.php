<?php
if($excel==2){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=liquidaciones/reporte.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
?>

@if($excel!=2)
<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>{{$titulo}}</h3>
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
<h3 align="center">{{$titulo}}</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>
@endif <br>
<table class="paleBlueRows" style="font-size:80%;margin: 0 auto;" width="70%" border=1>
	<thead>
	<tr style="background-color:#0B6FA4;color:white; " >
                  <th>Cliente</th>
                  <th>Numero Entrada</th>
                  <th>creado</th>
                  <th>Actualizado</th>
                  <th>Tipo cafe</th>
                  <th>Pendientes</th>
                </tr>
                </thead>
                <tbody>
                @php
                $tot_l=0;
                @endphp
                @foreach($data_reporte as $rows)
            @php
               $contador = 0;
                $long = count($rows['proveedor']['data']);
                $tot_k = 0;
            @endphp
            @foreach($rows['proveedor']['data'] as $index => $rowsx)
            @php
            if($rowsx->pendientes>0){
            $tot_k+=$rowsx->pendientes;
            $tot_l+=$rowsx->pendientes;
            }
            @endphp
                <tr>
                    @if($contador==0)
                        <td rowspan="{{ $long }}">
                    @php try{ @endphp
                      {{ $rows['proveedor']['info']->nombre }}
                    @php }catch(\Exception $e){} @endphp
						        </th>
                    @endif
                    <td>{{$rowsx->numero_ticket}}</td>
                    <td>{{date('d/m/Y',strtotime($rowsx->entradas_salidas_cafe_created_at))}} </td>
                    <td>{{date('d/m/Y',strtotime($rowsx->entradas_salidas_cafe_updated_at))}} </td>
                    <td>{{$rowsx->tipo_cafe}} </td>
                    <td> {{number_format($rowsx->pendientes,0,',','.')}}</td>
                       
                       @php
                       $contador++;
                       @endphp

            @endforeach

						<tr  style="background:#ccc"  align="center" >
                    <td colspan="5">TOTAL</td>
                    <td>{{ number_format($tot_k,0,',','.') }}</td>
                   
              </tr>

		@endforeach
    <tr  style="background:#ccc"  align="center" >
                    <td colspan="5">TOTAL GENERAL</td>
                    <td>{{ number_format($tot_l,0,',','.') }}</td>
                   
              </tr>

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
    </div>
    
    
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
  font-size: 15px;
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
  font-size: 15px !important;
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
  font-size:12px;
}
p{
  font-size:17px;
  text-align:center;
  font-weight: bold;
}
</style>


