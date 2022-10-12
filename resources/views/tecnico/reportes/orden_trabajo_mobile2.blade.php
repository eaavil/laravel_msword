

<div >
          <table width="130%" border="0" cellspacing="0" cellpadding="0"    >
            <tbody>
            <tr>
              <td width="720"><img src="data:image/png;base64,{{ $imagen }}" width="600" height="180"></td>
             
              <td width="442" align="right">
                <div>

                  <table  border="0" width="330"  style="font-size: 45px !important;font-weight: bold;">
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
                        <td>{{$orden[0]['creacion_orden']}}</td>
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
    <table class="paleBlueRows"   width="130%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >DATOS CLIENTE</td>
                        
                      </tr>
                      <tr>
                            <td >Cliente: {{ $orden[0]['nombre'] }}</td>
                            
                      </tr>
                      <tr >
                          <td >Rut: {{ $orden[0]['nit']}}</td>
                      </tr>
                      
                      <tr >
                           <td >Direccion: {{ $orden[0]['direccion']}} </td>
                      </tr>
                      <tr >
                            <td >Email: {{ $orden[0]['email_empresa']}}</td>
                      </tr>
                      <tr >
                             <td >Solicitado: {{ $orden[0]['persona_contacto']}} </td>
                      </tr>
                      <tr >
                             <td >Telefono:{{ $orden[0]['numero_telefono_1'] }}</td>
                      </tr>
                       <tr >
                           <td >Cargo: {{ $orden[0]['cargo']}} </td>
                      </tr>
                      <tr >
                           <td >OC N째 {{ $orden[0]['telefono_2'] }}</td>
                      </tr>
                      <tr>
                          <td >Presupuesto N째 {{ $orden[0]['telefono_2']}} </td>
                      </tr>
                    </tbody>
          </table> </tbody>
     
 </div>  <br><br><br><br><br>
  
 <div >
    <table class="paleBlueRows "   width="130%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >TIPO DE TRABAJO</td>
                        
                      </tr>
                      <tr>
                            <td > {{ $orden[0]['servicio']}}</td>
                            
                      </tr>
               
                    </tbody>
          </table> </tbody>
     
 </div>  <br><br><br><br><br>
 <div  >
    <table class="paleBlueRows"   width="130%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >DESCRIPCION</td>
                        
                      </tr>
                      <tr>
                            <td> {{ $orden[0]['descripcion']}}</td>
                            
                      </tr>
               
                    </tbody>
          </table> </tbody>
     
 </div>  <br><br><br><br><br>
  <div  >
    <table class="paleBlueRows"   width="130%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >SUGERENCIAS</td>
                        
                      </tr>
                      <tr>
                            <td > </td>
                            
                      </tr>
               
                    </tbody>
          </table> </tbody>
     
 </div>  <br><br><br><br><br>
 <div>



 <table class="paleBlueRows"   width="130%" style="font-size:90%"  border="1" >
  
        <tbody >
        <tr style="background:#CCC;font-weight: bold;" >
            <td  >RETIRO MATERIALES</td>
            <td >CANTIDAD</td>
           
        </tr>
        @foreach($materiales_1 as $rows)
        <tr >
           <td > {{$rows->nombre}}</td>
            <td style="text-align:center;" > {{$rows->cantidad}}</td>
        </tr>
         @endforeach
         @foreach($materiales_2 as $rows)
        <tr >
           <td > {{$rows->nombre}}</td>
            <td style="text-align:center;"> {{$rows->cantidad}}</td>
        </tr>
         @endforeach
                     
          </tbody>
    </table> 

   <div><BR><BR><BR><B
 
   <div  >
    <table class="paleBlueRows"   width="130%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >EFECTUADO POR</td>
                      </tr>
                      @if($orden[0]['tecnico_1']!="")
                      <tr>
                        
                           <td >Tecnico_1: {{$orden[0]['nombre_tecnico_1']}} </td>
                      </tr>
                      @endif 
                      @if($orden[0]['tecnico_2']!="")
                      <tr>
                        
                           <td >Tecnico_2: {{$orden[0]['nombre_tecnico_2']}} </td>
                      </tr>
                      @endif 
                      @if($orden[0]['tecnico_3']!="")
                      <tr>
                        
                           <td >Tecnico_3: {{$orden[0]['nombre_tecnico_3'] }}</td>
                      </tr>
                      @endif
                       <tr>
                           <td >Fecha: {{ $orden[0]['fecha_firma']}} </td>
                      </tr>
                      <tr>
                           <td>
                             @php
                             $tecnico_firma=$orden[0]['tecnico_firma'];
                             
                             $id_tecnico_firma=$orden[0][$tecnico_firma];
                            
                             $ruta=asset('firmas/'.$id_tecnico_firma.'.jpg?'.rand(1,100));
                             @endphp
                           <img src={{$ruta}} width='500' height='400'>
                            <div class="linea" ></div>
	                        	<strong>Firma</strong>
                           </td>
                      </tr>
                    </tbody>
          </table> </tbody>
     
 </div>  
 <br><br><br><br><br>
 
   <div  >
    <table class="paleBlueRows"   width="130%" style="font-size:90%"  border="1" >
                    <tbody>
                      <tr >
                        <td style="background:#CCC;font-weight: bold;" colspan="4" >RECIBIDO POR</td>
                        
                      </tr>
                       <tr>
                           <td >Nombre: {{$orden[0]['recibido']}} </td>
                      </tr>
                       <tr>
                           <td >Fecha entrada: {{ $orden[0]['creacion_orden']}}</td>
                      </tr>
                       <tr>
                           <td >Fecha salida: {{ $orden[0]['fecha_firma']}}</td>
                      </tr>
                       <tr>
                           <td>
                           <img src={{asset('firmas_recibidos/'.$id.'.jpg?'.rand(1,100))}} width='500' height='400'>
                            <div class="linea" ></div>
	                        	<strong>Firma</strong>
                           </td>
                      </tr>
               
                    </tbody>
          </table> </tbody>
     
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