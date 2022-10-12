

<div >
          <table width="100%" border="0" cellspacing="0" cellpadding="0"    >
            <tbody>
            <tr>
              <td width="730"><img src="{{asset('Storage/logo.png')}}" width="190" height="160"></td>
             
              <td width="442" align="right">
                <div>

                  <table  border="0" width="330"  style="font-size: 40px !important;font-weight: bold;">
                    <tbody>
                      <tr >
                        <td><strong>OT NO.</strong></td>
                        <td>{{str_replace('OT-','',$orden[0]['numero'])}}</td>
                      </tr>
                      <tr>
                        <td>CIUDAD:</td>
                        <td>ANTOFAGASTA</td>
                      </tr>
                      <tr>
                        <td>EMISION:</td>
                        <td>{{substr($orden[0]['created_at'], 0, 10)}}</td>
                      </tr>
                      <tr>
                    </tbody>
                    </div>
                  </table>
              </td>
            </tr>
          </tbody></table>
</div>


<div >
    <table class="paleBlueRows"   width="100%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >DATOS CLIENTE</td>
                        
                      </tr>
                      <tr>
                            <td >CLIENTE - {{ $orden[0]['nombre'] }}</td>
                            
                      </tr>
                      <tr >
                          <td >RUT - {{ $orden[0]['nit']}}</td>
                      </tr>
                      
                      <tr >
                           <td >DIRECCION - {{ $orden[0]['direccion']}} </td>
                      </tr>
                      <tr >
                            <td >EMAIL - {{ $orden[0]['email_empresa']}}</td>
                      </tr>
                      <tr >
                             <td >TELEFONO - {{ $orden[0]['numero_telefono_1'] }}</td>
                      </tr>
                    </tbody>
          </table> </tbody>
     
 </div>  <br><br><br><br><br>
  
 <div  >
    <table class="paleBlueRows"   width="100%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >DETALLE FACTURA</td>
                        
                      </tr>
                      <tr>
                            <td > {{ $orden[0]['servicio']}}</td>
                            
                      </tr>
               
                    </tbody>
          </table> </tbody>
     
 </div>  <br><br><br><br><br>
  <div  >
    <table class="paleBlueRows"   width="100%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >OBSERVACIONES</td>
                        
                      </tr>
                      <tr>
                            <td > {{ $orden[0]['descripcion']}}</td>
                            
                      </tr>
               
                    </tbody>
          </table> </tbody>
     
 </div>  <br><br><br><br><br>
 
   <div  >
    <table class="paleBlueRows"   width="100%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >DETALLES OT</td>
                      </tr>
                      <tr>
                           <td >imagenes entrada: </td>
                      </tr>
                       <tr>
                           <td >imagenes salida: </td>
                      </tr>
                      <tr>
                           <td >Nombre: </td>
                      </tr>
                       <tr>
                           <td >Fecha entrada: </td>
                      </tr>
                       <tr>
                           <td >Fecha entrada: </td>
                      </tr>
                       <tr>
                           <td>
                           <img src={{asset('firmas/'. $orden[0]['id_cliente'].'.jpg?'.rand(1,100))}} width='500' height='400'>
                            <div class="linea" ></div>
	                        	<strong>FIRMA POLARIAUTO</strong>
	                      </div>
                           </td>
                           
                      </tr>
                       </tr>
                       <tr>
                           <td>
                           <img src={{asset('firmas/'. $orden[0]['id_cliente'].'.jpg?'.rand(1,100))}} width='500' height='400'>
                            <div class="linea" ></div>
	                        	<strong>FIRMA CLIENTE</strong>
	                      </div>
                           </td>
                           
                      </tr>
                    </tbody>
          </table> </tbody>
     
 </div>  
 
   <div  >
    
     
 </div>  

<style>

table.paleBlueRows {
  font-family: "Arial";
  text-align:center;
  border-collapse: collapse;
}
.bor {
  border: 1px solid #000;
}
table.pre tbody td{
  border: 1px solid #000;
}
table.paleBlueRows tbody td {
  font-size: 50px !important;
  font-weight: bold;
  padding: 5px;
  text-align: left;
}

table.paleBlueRows thead {
  background: #ccc;
  border-bottom: 2px solid #000;
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