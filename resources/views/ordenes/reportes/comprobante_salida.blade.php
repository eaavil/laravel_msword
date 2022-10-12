<div >
          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tbody>
            <tr>
              <td width="510"><img src="data:image/png;base64,{{ $imagen }}" width="200" height="85"></td>
             
              <td width="442" align="right">
                <div>
                <h2>PRESUPUESTO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>

                  <table class="paleBlueRows pre" border="1" style="background:#6BA6F8;font-weight: bold;" width="300" >
                    <tbody>
                      <tr >
                        <td>FECHA</td>
                        <td>{{substr($contrato[0]['fecha_contrato'], 0, 10)}}
                         </td>
                      </tr>
                      <tr>
                        <td>PRESUPUESTO</td>
                        <td>{{$contrato[0]['numero']}}</td>
                      </tr>
                      <tr>
                        <td>VALIDO HASTA</td>
                        <td>{{$contrato[0]['validez']}}</td>
                      </tr>
                      <tr>
                      <td>CIUDAD</td>
                        <td>ANTOFAGASTA</td>
                      </tr>
                    </tbody>
                    </div>
                  </table>
              </td>
            </tr>
          </tbody></table>
</div>
<div align="LEFT">
    <table  width="310" height="23" border="0" >
      <tbody>
      <tr>
        <td  style="background:#ccc; font-weight: bold;" ><div align="center">DATOS EJECUTIVO:
            </div>
        </td>
      
      </tr>
      <tr>
      <td><div align="left" >NOMBRE:PAOLA AVILES <br>TELEFONO: 9 62084318<br>CORREO: ventastecnorempresas@gmail.com
            </div>
        </td>
      </tr>
    </tbody>
  </table>
</div><BR>
<div align="LEFT" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tbody>
    <tr>

    <td>
    <table  width="600" height="23" border="0" >
        <tbody>
        <tr>
            <td  style="background:#ccc; font-weight: bold;" ><div align="center">DATOS CLIENTE:
                </div>
            </td>
          
        </tr>
        <tr>
          <td><div align="left" >NOMBRE:{{$contrato[0]['nombre']}} <br>REPRESENTANTE:{{$contrato[0]['persona_contacto']}} <br>DIRECCION:{{$contrato[0]['direccion']}} <BR>CIUDAD:{{$contrato[0]['id_poblacion']}}
                </div>
            </td>
        </tr>
      </tbody>
    </table>
    </td>
    <td width="442" align="right">
    <table class="paleBlueRows pre" border="1" style="background:#6BA6F8;font-weight: bold;" width="300" >
                    <tbody>
                      <tr >
                        <td>TIPO DE OBRA</td>
                        
                      </tr>
                      <tr>
                        <td>{{$contrato[0]['id_categoria']}}</td>
                      </tr>
                    </tbody>
                    </div>
                  </table>
              </td>
            </tr>
          </tbody></table>


    </td>

    </tr>
</div>     <br>

   <table class="paleBlueRows" width="100%"  align="LEFT" >
	<thead >
        <tr class="bor" style="background-color:#ccc;color:black;font-size:70%; " >
		
          <th  width="70%">DESCRIPCION</th>
          @if($contrato[0]->tipo_servicio==2)
          <th>VALOR UF</th>
          @endif
          <th>VALOR $</th>
          <th>CANTIDAD</th>
          <th>TOTAL</th>
        </tr>
	</thead>
	<tbody>
        @foreach($articulos as $rowsx)
        <tr  class="bor" >  
						<td class="bor" >{{ $rowsx->nombre}}<br>
            @if($rowsx->tipo_servicio!=2 && $rowsx->comentario!=null)
            comentario:{{$rowsx->comentario}}
            @endif
           </th>
            @if($contrato[0]->tipo_servicio==2)
            <td>{{$rowsx->total_uf}} UF</td>
            @endif
            @php
            $aumento=$rowsx->valor*$rowsx->aumento;
            if($rowsx->aumento==5){
            $aumento=$rowsx->valor*0.5;
            }
            if($rowsx->aumento==8){
            $aumento=$rowsx->valor*0.8;
            }
            @endphp
            <td class="bor" >{{ number_format($rowsx->total/$rowsx->cantidad,0,',','.') }}</th>
            <td class="bor" >{{ $rowsx->cantidad }}</th>
            <td class="bor" >{{ number_format($rowsx->total,0,',','.') }}</th>
</tr>

			

            @endforeach

            <tr  width="75%" align="center">
                  <td ></td>
                  <td></td>
                  @if($contrato[0]->tipo_servicio==2)
                  <td></td>
                  @endif
                    <td class="bor" style="background:#ccc" >Neto</td>
                    <td class="bor"  style="background:#ccc" >{{ number_format($contrato[0]['valor_neto'],0,',','.') }}</td>
                   
              </tr>
              @if($contrato[0]['es_tercero']==0)
              <tr   width="75%" align="center">
                   <td></td>
                   @if($contrato[0]->tipo_servicio==2)
                  <td></td>
                  @endif
                    <td></td>
                    <td class="bor"  style="background:#ccc" >iva</td>
                    <td class="bor"  style="background:#ccc">{{ number_format($contrato[0]['valor_iva'],0,',','.') }}</td>
              </tr>
              
              
              
              <tr  width="75%" align="center">
                    <td></td>
                    <td></td>
                    @if($contrato[0]->tipo_servicio==2)
                    <td></td>
                    @endif
                    <td class="bor"  style="background:#ccc">Total</td>
                    
                    <td class="bor"  style="background:#ccc">{{ number_format($contrato[0]['valor_total'],0,',','.') }}</td>
                   
              </tr>
              @endif

	</tbody>
 <tfoot>
</table> 
<div> <br><br></div>
<div align="LEFT" > 
<table  border="0"  >
    <tbody>
    <tr>

    <td>
<table class="paleBlueRows pre" border="1"  >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;">NOTA</td>
                        
                      </tr>
                      <tr>
                        <td style="font-size:90%">SE REGUIERE 220 volt.En el punto de istalacion de los equipos. <br>Fecha de inicio: a convenir. <br> Plazo de entrega: 10 dias <br>
                        condiones de pago: a convenir <br>
                        GARANTIA 6 MESES POR EQUIPOS NUEVOS DE FABRICA SIN <br>
                        TENER SELLOS ROTOS. <br>
                        </td>
                      </tr>
                    </tbody>
                    </div>
                  </table>
          </td>
    <td  >
    <table class="paleBlueRows pre" border="1"   >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;">EMITIR ORDEN DE COMPRA</td>
                        
                      </tr>
                      <tr>
                        <td style="font-size:90%">Nombre: Tecnor Industrial Limitada <br>
Rut: 77.650.720-2 <br>
Direcci贸n: Punta Brava N潞144, Antofagasta <br>
Fono: 9 9969-7734/ 9 6208-4318/ 9 99697737 <br>
Giro: Automatizaci贸n <br>
Emitir Cheque Nominativo y Cruzado a nombre de Tecnor <br>
Industrial Limitada. <br>
                        </td>
                      </tr>
                    </tbody>
          </table> </tbody>
      </table>  
      <div aling="right" >
      <p style="font-size:17px"> Atentamente, <br>
 <b>PAOLA AVILES</b> <br>
EJECUTIVA DE VENTAS
</div>  </p>
    </td>
    </tr>
    </tbody>
    </table>
 
</div>
<style>

table.paleBlueRows {
  font-family: "Arial";
  text-align: center;
  border-collapse: collapse;
}
.bor {
  border: 1px solid #000;
}
table.pre tbody td{
  border: 1px solid #000;
}
table.paleBlueRows tbody td {
  font-size: 14px;
  padding: 5px;
}

table.paleBlueRows thead {
  background: #ccc;
  border-bottom: 2px solid #000;
}
table.paleBlueRows thead th {
  font-size: 14px !important;
  font-weight: bold;
  color: black;
  text-align: center;
  padding: 5px;
  border-left: 2px solid #000;
}
	.totales td{
		background:#0B6FA4; color:white
	}


</style>