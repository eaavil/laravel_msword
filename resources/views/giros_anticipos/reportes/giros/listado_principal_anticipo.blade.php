<?php
if($excel==1){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=anticipos.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
?> 

@if($excel!=1)
<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>Reporte de Anticipos Cliente </h3>
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
<h3 align="center">Reporte de Anticipos Cliente</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>
@endif <br>
<table class="paleBlueRows"  width="100%" border="1"  >
	<thead >
        <tr style="background-color:#0B6FA4;color:white;font-size:70%; " >
                  <th>Numero</th>
                  <th>Cliente</th>
                  <th>Valor</th>
                  <th>Fecha Giro</th>
                  <th>Forma Pago</th>
                  <th>Numero Cheque<br>Transaccion</th>
                  <th>Cuenta</th>
                  <th>Creado</th>
                  <th>Actualizado</th>
        </tr>
	</thead>
	<tbody>
  @foreach($consulta as $data)
                         <tr style="font-size:70%;">
                         
                            <td>ANT-{{ str_pad($data->id,4,'0',STR_PAD_LEFT) }}</td>
                            <td>
								@php try { @endphp
                  {{ $data->nombre }}<br>
                                Nit:{{ $data->nit }}
								@php }catch(\Exception $e){} @endphp
                            </td>
                            <td>@php try{ echo number_format($data->valor,2,',','.'); }catch(\Exception $e){} @endphp</td>
                            <td>{{ date('d/m/Y',strtotime($data->fecha_giro)) }}</td>
                            <td>{{ $data->forma_pago }}</td>
                            <td>{{ $data->numero_cheque }}</td>
                            @if($data->cuenta!=null)
                                <td ALIGN=left>
                                    {{ $data->cuenta }}<br>
                                    {{ $data->cliente }}<br>
                                    {{ $data->entidad }}
                                </td>
                            @else
                                <td>
                                        Sin Cuenta Asociada
                                </td>
                            @endif

                            <td>{{ ($data->created_at!=null)?date('d/m/Y h:i:s a',strtotime($data->created_at)):'' }}</td>
                            <td>{{ ($data->updated_at!=null)?date('d/m/Y h:i:s a',strtotime($data->updated_at)):'' }}</td>
                            
                        </tr>
                    @endforeach
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
  font-size: 12px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  padding: 5px;
  border-left: 2px solid #000;
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
</style>


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
  font-size: 12px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  padding: 5px;
  border-left: 2px solid #000;
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




