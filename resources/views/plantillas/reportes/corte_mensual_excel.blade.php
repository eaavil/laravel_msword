
<?php
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=corte_contratos.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
?>

<center><h3>Reporte corte de contratos de compra y venta</h3></center>
<p>Desde: {{ date('d/m/Y',strtotime($fecha_inicial)) }}</p>
<p>Hasta: {{ date('d/m/Y',strtotime($fecha_final)) }}</p>

<table class="paleBlueRows" width="100%" border=1>
	<thead>
        <tr style="background-color:#0B6FA4;color:white;font-size:70%; "  >
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
  <tbody >{{$mes=""}}
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
             <td >{{date('d/m/Y',strtotime($rows->fecha_contrato))}}</td>
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
              <td>{{number_format($rows->valor_contrato,0,',','.') }}</td>
              @php }catch(\Exception $e){ @endphp
              <td>{{$rows->valor_contrato}}</th>
              @php } @endphp
              </tr>
        @endforeach
        @foreach($contratos_venta as $rows)
          <tr style="background-color: #EBC1F4;font-size:70%;" >
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
               
              @php try{ @endphp
                <td>{{number_format($rows->valor_contrato,0,',','.') }}</td>
              @php }catch(\Exception $e){ @endphp
              <td>{{$rows->valor_contrato}}</th>
              @php } @endphp

              

          </tr>
        @endforeach
          
	</tbody>

 
</table><br><br>


<table class="paleBlueRows"  style="background-color: #C1DFF4;font-size:80%;"  width="20%" border=1>
	<thead>
        <tr>
          <th >Total contratos de<br>  compra  en <br>kilos: $ {{number_format($total_compra_kilos,0,',','.')}}</th>
          <th>Total valor contratos compras:<br> $ {{number_format($total_compra_valor,0,',','.')}} </th>
          <th>Promedio compras:<br> $ {{number_format($total_promedio_compra,0,',','.')}}</th>
    </tr>
	</thead>
</table> <br>

<table class="paleBlueRows"  style="background-color: #EBC1F4;font-size:80%;"  width="20%" border="solid">
	<thead>
    <tr >
          <th >Total contratos de <br> venta en<br> kilos:$ {{number_format($total_venta_kilos,0,',','.')}}</th>
          <th >Total valor <br>contratos ventas:<br>$ {{number_format($total_venta_valor,0,',','.')}}</th>
          <th >Promedio ventas:<br> $ {{number_format($total_promedio_venta,0,',','.')}}</th>
    </tr>
	</thead>
</table> <br><br>
<div  align="center"><strong >SALDOS Y PROMEDIOS ENTRE LAS COMPRAS Y VENTAS</strong>

<table class="paleBlueRows"  style="background-color: #9EFD8E ;font-size:80%;" width="20%" border=1 align="right">
	<thead>
    <tr >
          <th>utilidad o perdida<br> en el corte:<br> $ {{number_format($total_promedio_venta-$total_promedio_compra,0,',','.')}}</th>
          
    </tr>
	</thead>
</table> <br>
<table class="paleBlueRows"  style="background-color: #EAD9AC ;font-size:80%;" width="20%" border=1>
	<thead>
    <tr>
          <th>saldo en kilos de<br> las compras menos las ventas:<br>$ {{number_format(($total_compra_kilos-$total_venta_kilos)+$kilos_compromiso_saldo,0,',','.')}}</th>
          <th>Valor total contratos<br> compras menos ventas:<br>$ {{number_format($total_compra_valor-$total_venta_valor,0,',','.')}} </th>
          <th>Promedio total del valor:<br>$ {{number_format($total_promedio_compra,0,',','.')}}</th>
    </tr>
	</thead>
</table> 
