<?php
if($excel==2){
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=clientes.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);}
?> 

@if($excel!=2)
<table width="100%">
            <tr>
            <td align="lefth"  width="100%"><p >
          <h3>Reporte de clientes</h3>
					Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br><br>
					Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }} </p>
            </td><td><td ></td></td>
            <td align="right">
            <p >
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1 </p>
            </td> 
            </tr>
    </table>
@else
<h3 align="center">Reporte de clientes</h3>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial))}}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>
@endif <br>
<table class="paleBlueRows" style="font-size:80%;margin: 0 auto; " width="70%" border=1 >
	<thead>
	<tr style="background-color:#0B6FA4;color:white; " >
                  <th with="20%">Razon Social</th>
                  <th>Ciudad</th>
                  <th>Caracteristicas</th>
                  <th>Registrado</th>
                  <th>Actualizado</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($operaciones as $data)
                        <tr>
                            <td>{{ $data->nombre }}<br>Nit: {{ $data->nit }}-{{ $data->digito_verificacion_nit }}</td>
                            <td>{{ $data->nombre_ciudad }}, {{ $data->departamento }} </td>
                            <td>
                                @if($data->es_cliente)
                                    <span class="badge badge-primary" style="font-size:12px">Cliente</span>
                                @endif
                                @if($data->es_proveedor)
                                    <span class="badge badge-info" style="font-size:12px">Proveedor</span>
                                @endif
                                @if($data->es_propietario)
                                    <span class="badge badge-danger" style="font-size:12px">Facturador</span>
                                @endif
                                @if($data->es_tercero)
                                    <span class="badge badge-warning" style="font-size:12px">Tercero</span>
                                @endif                                
								@if($data->es_empresa_transporte)
                                    <span class="badge badge-warning" style="font-size:12px">Conductor</span>
                                @endif
                            </td>
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