<!DOCTYPE html>
<html lang="en">
<head>
 
  <title>Document</title>
</head>
<body>
  


<div >
          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tbody>
            <tr>
              <td width="510"><img src="data:image/png;base64,{{ $imagen }}" width="200" height="85"></td>
             
              <td width="442" align="right">
                <div>
                <h2>ORDEN DE COMPRA &nbsp;&nbsp;&nbsp;&nbsp;</h2>

                  <table class="paleBlueRows pre" border="1" style="background:#6BA6F8;font-weight: bold;" width="300" >
                    <tbody>
                      <tr >
                        <td>ORDEN DE COMPRA NO.</td>
                        <td>{{$contrato[0]['numero']}}
                         </td>
                      </tr>
                      <tr>
                        <td>FECHA EMISION</td>
                        <td>{{substr($contrato[0]['fecha_contrato'], 0, 10)}}</td>
                      </tr>
                    </tbody>
                    </div>
                  </table>
              </td>
            </tr>
          </tbody></table>
</div> <br>
    <table class="paleBlueRows" width="100%"  height="23" border="1" >
        <tbody>
        <tr class="bor" >
            <td colspan="4" style="background:#ccc; font-weight: bold;" ><div align="center">DATOS CLIENTE:
               
            </td>
          
        </tr>
        
        <tr class="bor">
          <td> PROVEEDOR: </td>
          <td>{{$contrato[0]['nombre']}}</td>
          <td>FONO:</td>
          <td>{{$contrato[0]['numero_telefono_1']}}</td>
        </tr>
        <tr class="bor">
        <td>CONTACTO:</td>
          <td>{{$contrato[0]['persona_contacto']}} </td>
          <td>EMAIL:</td>
          <td>{{$contrato[0]['email_empresa']}} </td>
        </tr>
        <tr class="bor">
        <td>DIRECCION:</td>
          <td>{{$contrato[0]['direccion']}} </td>
          <td>CIUDAD:</td>
          <td>{{$contrato[0]['nombre_ciudad']}} </td>
        </tr>
        
        <tr class="bor">
        <td>PROYECTO:</td>
          <td>{{$contrato[0]['direccion']}} </td>
          <td>COTIZACION:</td>
          <td>{{$contrato[0]['nombre_ciudad']}} </td>
        </tr>
      </tbody>
    </table>
    
   
    <br>

  <table class="paleBlueRows" width="100%"   >
	<thead >
        
	</thead>
	<tbody>
  <tr class="bor" style="background:#ccc; font-weight: bold;" border="1">
        <td class="bor" width="2%">ITEM</td>
          <td class="bor" width="50%">DESCRIPCION</td>
          <td class="bor">CANTIDAD</td>
          <td class="bor">VALOR UNIT.</td>
          <td class="bor">TOTAL</td>
        </tr>
  @php
         $cont=0;
         @endphp
        @foreach($articulos as $rowsx)
        @php
         $cont++;
         @endphp
        <tr  class="bor" >  
            <td class="bor" >{{$cont}}</th>
						<td class="bor" >{{ $rowsx->nombre}}</th>
            <td class="bor" >{{ $rowsx->disponible*-1 }}</th>
            <td class="bor" >{{ number_format($rowsx->valor_compra,0,',','.') }}</th>
						<td class="bor" >{{ number_format($rowsx->total_compra,0,',','.') }}</th>
</tr>

			

            @endforeach
            
            <tr  width="75%" align="center">
                 <td ></td>
                  <td ></td>
                  <td></td>
                    <td class="bor" style="background:#ccc" >NETO</td>
                    <td class="bor"  style="background:#ccc" >{{ number_format($contrato[0]['valor_neto'],0,',','.') }}</td>
                   
              </tr>
              <tr   width="75%" align="center">
                     <td ></td>
                   <td></td>
                    <td></td>
                    <td class="bor"  style="background:#ccc" >IVA 19%</td>
                    <td class="bor"  style="background:#ccc">{{$contrato[0]['valor_iva']}}</td>
                   
              </tr>
              <tr  width="75%" align="center">
              <td ></td>
                    <td></td>
                    <td></td>
                    <td class="bor"  style="background:#ccc">Total</td>
                    <td class="bor"  style="background:#ccc">{{ number_format($contrato[0]['valor_total'],0,',','.') }}</td>
                   
              </tr>

	</tbody>
 <tfoot>
</table> &nbsp;&nbsp;&nbsp;&nbsp;
<table class="paleBlueRows pre" border="1" style="font-weight: bold;" width="100%" >
                    <tbody>
                      <tr >
                        <td>USO INTERNO <br> <br>
DEPTO. ADMINISTRACION  <br> <br>
JEFE ADMINISTRATIVO <br>
                        </td>
                        <td> FIRMA AUTORIZADA
                         </td>
                      </tr>
                      <tr>
                      <td colspan="2">Nota: se solicita que todo despacho sea al domicilio y no a la agencia.
                      </td>
                      </tr>
                    
  </table>

  </body> <br>
  &nbsp;

Email: ventas@polariauto.cl Celular: +56 9 5867 3490 Sucursal Costanera Av. Edmundo Pérez Zujovic 4774

</html>


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
  @page {
    content: "Pág. " counter(page);
  }



</style>