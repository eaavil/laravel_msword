

<button class=" boton oculto" onclick="location.href = document.referrer; return false;">Volver</button>

<br>
<table width="100%">
            <tr>
            <td align="lefth" >
            <h3>Corte de contratos de compra y venta</h3><br>
					Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }} <br> <br>
				Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}
            </td>
            <td align="right">
                <img class="pt-1" src="data:image/png;base64, {{ $imagen }}" width="250"  ><br>
                 NIT. 901383798-1
                </td> 
            </tr>
    </table><br>
<table class="paleBlueRows" width="100%" border=1>
	<thead>
        <tr style="background-color:#0B6FA4;color:white;font-size:70%; " >
          <th>Numero</th>
          <th>fecha </th>
          <th>Proveedor</th>
          <th>ID No.</th>
          <th>Mes entrega</th>
          <th>Año entrega</th>
          <th>Producto</th>
          <th>Kilos compromiso</th>
          <th>precio kilogramo</th>
          <th>precio arroba</th>
          <th>Valor Contrato</th>
        </tr>
	</thead>
  <tbody>{{$mes=""}}
        @if($kilos_compromiso_saldo!=null)
        <tr style="background-color: #EAD9AC ;font-size:70%;"> 
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>SALDO</td>
          <td>{{number_format($kilos_compromiso_saldo,0,',','.')}} </td>
          <td>{{number_format($precio_kilogramo_saldo,0,',','.')}}</td>
          <td>{{number_format($precio_arroba_saldo,0,',','.')}}</td>
          <td>{{number_format($valor_contrato_saldo,0,',','.')}}</td>
        </tr>
        @endif
        @foreach($contratos_compra as $rows)
          <tr style="background-color: #C1DFF4;font-size:70%;" >
          <td>{{$rows->numero}}</td>
             <td>{{date('d/m/Y',strtotime($rows->fecha_contrato))}}</td>
             <td>{{$rows->proveedor}}</td>
             <td> {{number_format($rows->proveedor_nit,0,',','.')}}</td>
             <?php
             switch(date("m", strtotime($rows->fecha_contrato)))
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
             <td>{{date("Y", strtotime($rows->fecha_contrato))}}</td>
             <td>{{$rows->tipo_cafe}}</td>
             <td>{{number_format($rows->kilos_compromiso,0,',','.')}}</td>
             
             @php try{ @endphp
            <td>{{number_format($rows->precio_kilogramo,0,',','.') }}</th>
            @php }catch(\Exception $e){ @endphp
            <td>{{$rows->precio_kilogramo}}</th>
            @php } @endphp
            
            @php try{ @endphp
            <td>{{number_format($rows->precio_arroba,0,',','.') }}</th>
            @php }catch(\Exception $e){ @endphp
            <td>{{$rows->precio_arroba}}</th>
            @php } @endphp
                <td>{{number_format($rows->valor_contrato,0,',','.') }}</td>
        @endforeach
        @foreach($contratos_venta as $rows)
          <tr style="background-color: #EBC1F4;font-size:70%;">
          <td >{{$rows->numero}}</td>
             <td >{{date('d/m/Y',strtotime($rows->fecha_contrato))}}</td>
             <td >{{$rows->cliente}}</td>
             <td >{{number_format($rows->cliente_nit,0,',','.')}}</td>
             <?php
             switch(date("m", strtotime($rows->fecha_contrato)))
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
             <td>{{date("Y", strtotime($rows->fecha_contrato))}}</td>
             <td>{{$rows->tipo_cafe}}</td>
             <td>{{number_format($rows->kilos_compromiso,0,',','.')}}</td>
              @php try{ @endphp
              <td>{{number_format($rows->precio_kilogramo,0,',','.') }}</th>
              @php }catch(\Exception $e){ @endphp
              <td>{{$rows->precio_kilogramo}}</th>
              @php } @endphp
              @php try{ @endphp
              <td>{{number_format($rows->precio_arroba,0,',','.') }}</th>
              @php }catch(\Exception $e){ @endphp
              <td>{{$rows->precio_arroba}}</th>
              @php } @endphp
                <td>{{number_format($rows->valor_contrato,0,',','.') }}</td>
              
        @endforeach
          
	</tbody>

 
</table> <br>


<table class="paleBlueRows"  style="background-color: #C1DFF4;font-size:80%;"  width="100%" border=1>
	<tbody>
        <tr>
          <th>Total contratos de compra en kilos: $ {{number_format($total_compra_kilos+$kilos_compromiso_saldo,0,',','.')}}</th>
          <th>Total valor contratos compras: $ {{number_format($total_compra_valor+$valor_contrato_saldo,0,',','.')}} </th>
          <th>Promedio compras: $ {{number_format($total_promedio_compra,0,',','.')}}</th>
    </tr>
	</tbody>
</table> <br>

<table class=" paleBlueRows" style="background-color: #EBC1F4;font-size:80%;"  width="100%" border="solid">
	<tbody>
    <tr>
          <th >Total contratos de venta en kilos: $ {{number_format($total_venta_kilos,0,',','.')}}</th>
          <th >Total valor contratos ventas: $ {{number_format($total_venta_valor,0,',','.')}}</th>
          <th >Promedio ventas: $ {{number_format($total_promedio_venta,0,',','.')}}</th>
    </tr>
	</tbody>
</table> <br>
<div  align="center"><strong >SALDOS Y PROMEDIOS ENTRE LAS COMPRAS Y VENTAS</strong>
</div>
<table class=" paleBlueRows" style="background-color: #9EFD8E ;font-size:80%;" width="20%" border=1 align="right">
	<tbody>
    <tr>
          <th>utilidad o perdida en el corte: $ {{number_format($total_promedio_venta-$total_promedio_compra,0,',','.')}}</th>
          
    </tr>
	</tbody>
</table> <br> <br>
<table class=" paleBlueRows" style="background-color: #EAD9AC ;font-size:80%;" width="100%" border=1>
	<tbody>
    <tr>
          <th>saldo en kilos de las compras menos las ventas: $ {{number_format(($total_compra_kilos-$total_venta_kilos)+$kilos_compromiso_saldo,0,',','.')}}</th>
          <th>Valor total contratos compras menos ventas: $ {{number_format($total_compra_valor-$total_venta_valor,0,',','.')}} </th>
          <th>Promedio total del valor: $ {{number_format($total_promedio_compra,0,',','.')}}</th>
    </tr>
	</tbody>
</table> <br>

<button class=" boton oculto" onclick="location.href = document.referrer; return false;">Volver</button>
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