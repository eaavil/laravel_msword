<div >
          <table width="100%" border="0" cellspacing="0" cellpadding="0"    >
            <tbody>
            <tr>
              <td width="30%"><img src="data:image/png;base64,{{ $imagen }}" width="250" height="80"></td>
            
              <td  align="right">
                

                  <table  border="0"   style="font-size: 18px !important;">
                    <tbody>
                      <tr style="font-weight: bold;">
                         
                        <td  >
                        @if($orden[0]['estado']==3)
                             PRESUPUESTO NO.
                        @else
                            ORDEN DE TRABAJO NO.
                        @endif
                        </td>
                        
                        <td  align="right">{{str_replace('OT-','',$orden[0]['numero'])}}</td>
                      </tr>
                      <tr>
                        <td>CIUDAD:</td>
                        <td align="right">ANTOFAGASTA</td>
                      </tr>
                      <tr>
                        <td>FECHA/HORA DE EMISION:</td>
                        <td align="right">{{$orden[0]['creacion_orden']}}</td>
                      </tr>
                      <tr>
                    </tbody>
                  
                  </table>
              </td>
            </tr>
          </tbody></table>
</div>


<div >
    <table class="paleBlueRows"   width="100%" 
     border="1" >
    <thead >
       <tr>
          <td style="background:#CCC;" colspan="4" >DATOS CLIENTE</td>
                        
      </tr>
    </thead >
        <tbody >
                    
              <tr>
                  <td width="50%">Cliente: {{ $orden[0]['nombre'] }}</td>
                  <td>Rut: {{ $orden[0]['nit']}}</td>
              </tr>
              <tr>
                    <td width="50%">Fono contacto: {{ $orden[0]['numero_telefono_1']}} </td>
                    <td >Email: {{ $orden[0]['email_empresa']}}</td>
              </tr>
              <tr >
                    <td width="50%">Modelo: {{ $orden[0]['modelo']}} </td>
                    <td >Patente: {{ $orden[0]['patente']}}</td>   
              </tr>
              <tr >
                    <td width="50%">Fecha/hora ingreso: {{ $orden[0]['created_at']}} </td>
                    <td >Fecha/hora salida: {{ $orden[0]['fecha_salida']}}</td>   
              </tr> 
              <tr >
                    <td width="50%">Forma pago: {{ $orden[0]['forma_pago']}}</td>
                    <td></td>   
              </tr> 
            
                     
                    </tbody>
          </table> </tbody>
     
 </div>  
 <div > <br>
 <table class="paleBlueRows" width="100%"  align="LEFT" border=0>
	<thead >
        <tr class="bor" style="background-color:#ccc;color:black;font-size:70%; " >
		
          <th  width="70%">DESCRIPCION</th>
          <th>VALOR</th>
          <th>CANTIDAD</th>
          <th>TOTAL</th>
        </tr>
	</thead>
	<tbody>
	    @php
	    $neto=0;
	    @endphp
        @foreach($detalles as $rowsx)
        <tr  class="bor" >  
						<td class="bor" >{{ $rowsx->nombre}}<br>
            @if($rowsx->comentario!=null)
            
            comentario:{{$rowsx->comentario}}
            $neto+=$rowsx->valor*$rowsx->cantidad;
            @endif
           </th>
            @php
          
            @endphp
            <td class="bor" >{{ number_format($rowsx->valor,0,',','.') }}</th>
            <td class="bor" >{{ $rowsx->cantidad }}</th>
            <td class="bor" >{{ number_format($rowsx->valor*$rowsx->cantidad,0,',','.') }}</th>
</tr>
@endforeach

<tr  width="75%" align="center" height="5" >
  <td colspan=2 rowspan="4">

      <p style="font-size: 12px;text-align: justify"> <strong>NOTA:</strong>En caso de que el presupuesto no sea aceptado el cliente pagar?? exclusivamente el costo de la revison o diagnostico del servicio. El polarizado NO reglamentario sera exclusiva responsabilidad
      del cliente frente a situaciones legales. Cualquier devolucion de dinero sera dentro de los 05 dias habiles. De la misma forma el cliente <strong>ACEPTA</strong> la recepcion del vehiculo, en su entera satisfaccion, eximiendo a PolariAuto de toda responsabilidad posterior al retiro, sin reparo alguno
      donde firma y acepta su recepcion. PolariAuto no se hace responsable de cualquier perdida dentro del vehiculo.
      </p>  
  </td>
        @php
        $neto=0;
        $iva=0;
        $descuento=0;
        $total=0;
        if($orden[0]['es_iva']!=0 and $orden[0]['descuento']!=0){
          $neto=$orden[0]['neto'];
          $iva=$orden[0]['neto']*0.19;
          $descuento=$orden[0]['total']*$orden[0]['descuento'];
          $total=$orden[0]['neto']+$iva-$descuento;
        }

        if($orden[0]['es_iva']==0 and $orden[0]['descuento']!=0){
          $descuento=0;
          $neto=$orden[0]['neto'];
          $descuento=$orden[0]['total']*$orden[0]['descuento'];
          $total=$orden[0]['total_des'];
          
          $iva=0;
        }

        if($orden[0]['es_iva']!=0 and $orden[0]['descuento']==0){
          $neto=$orden[0]['neto'];
          $iva=$orden[0]['neto']*0.19;
          $total=$orden[0]['neto']+$orden[0]['neto']*0.19;
        }
        if($orden[0]['es_iva']==0 and $orden[0]['descuento']==0){
          $neto=$orden[0]['total'];
        }
        @endphp
        <td class="bor" style="background:#ccc" >Neto</td>
        <td class="bor"  style="background:#ccc" >{{ number_format($neto,0,',','.') }}</td>
        
  </tr>
  
  <tr   width="75%" align="center">
        
        @if($iva!=0)
        <td class="bor"  style="background:#ccc" >Iva</td>
        <td class="bor"  style="background:#ccc">{{ number_format($iva,0,',','.') }}</td>
        @else
        <td class="bor"  style="background:#ccc" >--</td>
        <td class="bor"  style="background:#ccc">--</td>
        @endif
  </tr>
  <tr   width="75%" align="center">
       
        
        @if($descuento!=0)
        <td class="bor"  style="background:#ccc" >Descuento</td>
        <td class="bor"  style="background:#ccc">{{ number_format($descuento,0,',','.') }}</td>
        @else
        <td class="bor"  style="background:#ccc">--</td>
        <td class="bor"  style="background:#ccc">--</td>
        @endif
  </tr>
  
  
  
  <tr  width="75%" align="center">
     
        @if($total!=0)
        <td class="bor"  style="background:#ccc">Total</td>
        
        <td class="bor"  style="background:#ccc">{{ number_format($total,0,',','.') }}</td>
       @else
       <td class="bor"  style="background:#ccc">--</td>
        
        <td class="bor"  style="background:#ccc">--</td>
       @endif
  </tr>
  <tr>
  <td>

      <p style="font-size:22px;text-align: justify"> <strong>OBSERVACIONES:</strong> {{$orden[0]['observacion']}}.
      </p>  
</td>
</tr>
</tbody>

</table>  
 </div> 

 <div><br>

 <table class="paleBlueRows"   width="100%" style="font-size:90%" border="0"  >
    
        <tbody > 
          <tr >
              <td width="50%">
                             @php
                             $vendedor=$orden[0]['id_vendedor'];
                             
                             $id_orden=$orden[0]["id"];
                            
                             $ruta=asset('firmas/'.$vendedor.'.jpg?'.rand(1,100));
                             @endphp
                           <img src={{$ruta}} width='63%' height='120'>
                            <div class="linea" ></div>
	                        	<strong>Nombre y Rut Polariauto</strong>
                           </td>
                           <td>
                           <img src={{asset('firmas/'. $id.'.jpg?'.rand(1,100))}} width='63%' height='120'>
                            <div class="linea" ></div>
	                        	<strong>Nombre Cliente</strong>
                </td>     
              </tr>
                     
          </tbody>
    </table> <br>
  &nbsp;

Email: ventas@polariauto.cl Celular: +56 9 5867 3490 Sucursal Costanera Av. Edmundo P??rez Zujovic 4774

   <div> 
 

<style>

table.paleBlueRows {
  font-family: "Arial";
  text-align:center;
  border-collapse: collapse;
}
.bor{
  border: 1px solid #000;
}
table.pre tbody td{
  font-size: 10px;
  border: 1px solid #000;
}
table.paleBlueRows tbody td {
  font-size: 18px !important;
  padding: 5px;
  text-align: left;
}

table.paleBlueRows thead {
  background: #ccc;
  font-size: 19px !important;
  border-bottom: 2px solid #000;
  font-weight: bold;
}

table.paleBlueRows thead th {
  font-size: 18px !important;
  font-weight: bold;
  color: black;
  text-align: center;
  padding: 5px;
  border-left: 2px solid #000;
}

.totales td{
	background:#0B6FA4; color:white
}

.linea {
  border-top: 2px solid black;
  height: 2px;
  width: 40%;
  padding: 0;
}

.centrado{
	text-align: center;
}

</style>