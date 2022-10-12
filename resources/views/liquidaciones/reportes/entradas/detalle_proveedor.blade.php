$hora=date(" (H:i:s)",time());
<table width="100%">
            <tr>
            <td align="center"  width="100%"><p >
            <h2>ENTRADAS POR KILOS EN BOGA DEL PROVEEDOR {{$proveedor}}</h2>
            </td><td><td ></td></td>
            <td align="right">
            <p >
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1 </p>
            </td> 
            </tr>
    </table>
<br>
<button class=" my-3 boton oculto" onClick="javascript: window.history.go(-1);">Volver</button>
<br><br>
<table class="paleBlueRows" width="100%">
	<thead>
        <tr>
          <th>Entrada</th>
          <th>fecha</th>
          <th>Conductor</th>
          <th>Placa</th>
          <th>Producto</th>
          <th>Sacos</th>
          <th>Tulas</th>
          <th>Peso/Entrada</th>
          <th>Peso/Salida</th>
          <th>Kilos/Brutos</th>
          <th>Kilos/Netos</th>
        </tr>
	</thead>
  <tbody>
        @foreach($liquidaciones as $rows)
          <tr>
             <td>{{$rows->numero_ticket}}</td>
             <td>{{date('d/m/Y',strtotime($rows->fecha_ticket))}}</td>
             <td>{{$rows->conductor}}</td>
             <td>{{$rows->placa}}</td>
             <td>{{$rows->tipo_cafe}}</td>
             <td>{{$rows->cantidad_sacos}}</td>
             <td>{{$rows->cantidad_tulas}}</td>
             <td>{{number_format($rows->peso_entrada,0,',','.')}}</td>
             <td>{{number_format($rows->peso_salida,0,',','.')}}</td>
            <td>{{number_format($rows->peso_bruto,0,',','.')}}</td>
            <td>{{number_format($rows->peso_neto-$rows->liquidado,0,',','.')}}</td>
          </tr>
        @endforeach
          <tr style="background:#ccc; color:black">
            <td colspan="10">TOTALES </td>
            <td>{{ number_format($Kilos_bodega,0,',','.') }}</td>
          </tr>
	</tbody>
</table><br>
<button class=" my-3 btn btn-primary oculto boton" onClick="javascript: window.history.go(-1);">Volver</button>
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
	  font-size: 11px !important;
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