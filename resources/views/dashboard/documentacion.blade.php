@extends('template.main')

@section('contenedor_principal')

<h2><span class="badge badge-info">POST</span> https://api.libellum.com.co/rest/billing/add</h2>


    
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive p-2">
                <div class="form-group">
                    <label>Tu Api Key</label>
                    <span class="form-control key">

                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body table-responsive p-2">
                <p><h2>Objeto JSON de Muestra</h2></p>
                <pre style="background:#333;height: 1080px;">
                    <code style="font-size:14px; color:#00ff00; ">
    {
	"codigo_empresa_encTot": 1,
	"codigo_SUC_encTot": 1,
	"divisa_encTot": "COP",
	"fechaDocumento_encTot": "07/12/2019 18:50",
	"tipoDocumento_encTot": "FV",
	"prefijo_encTot": "FA",
	"numeroDocumento_encTot": 112202,
	"factura_encTot": "FA12202",
	"fechaVencimiento_encTot": "06/01/2020 00:00",
	"periodicidadFactura_encTot": "CREDITO",
	"numerosCuotasFactura_encTot": "2",
	"condicionProntoPago_encTot": 0,
	"descripcionCondicionPago_encTot": 2,
	"codigoVendedor_encTot": 8,
	"cedulaVendedor_encTot": "23",
	"nombreVendedor_encTot": "AC",
	"numeroOrdenCompra_encTot": "12100919",
	"numeroRemision_encTot": "",
	"numeroOrdenVenta_encTot": "",
	"numeroCargue_encTot": "",
	"codigoTercero_encTot": 860037900,
	"sucursalTercero_encTot": "",
	"nitTercero_encTot": 860037900,
	"digitoVerificacion_encTot": 4,
	"apellido1_encTot": "23",
	"apellido2_encTot": "23",
	"nombreTercero_encTot": "32",
	"tipoTercero_encTot": 1,
	"tipoIdentificacion_encTot": 31,
	"codigoPaisTercero_encTot": "CO",
	"codigoDepartamentoTercero_encTot": 76,
	"codigoCiudadTercero_encTot": 76001,
	"direccion1_encTot": "CALLE 29 NORTE No 6 B N 22",
	"direccion2_encTot": "32",
	"telefono1_encTot": "6619999 4865000",
	"telefono2_encTot": "32",
	"fax_encTot": "3",
	"claseClienteTercero_encTot": "2",
	"email_encTot": "demo@democ.com",
	"barrio_encTot": "",
	"vendedorAsociadoCliente_encTot": "32",
	"condicionPagoCliente_encTot": "32",
	"cupoCredigoCliente_encTot": "32",
	"criterio1Cliente_encTot": "32",
	"criterio2Cliente_encTot": "32",
	"criterio3Cliente_encTot": 0,
	"razonSocial_encTot": "CONSTRUCTORA BOLIVAR CALI S.A.",
	"nombreEstablecimiento_encTot": "CONSTRUCTORA BOLIVAR CALI S.A.",
	"vlrBrutoF_encTot": 4248640.22,
	"vlrDctoLinea1F_encTot": 0.00,
	"vlrDctoLinea2F_encTot": 0,
	"vlrDctoGlobal1F_encTot": 0,
	"vlrDctoGlobal2F_encTot": 0,
	"vlrIvaF_encTot": 807242,
	"vlrImpoconsumo1F_encTot": 0,
	"vlrImpoconsumo2F_encTot": 0,
	"vlrNetoF_encTot": 4795865,
	"porceDctoGlobal1F_encTot": 0,
	"porceDctoGlobal2F_encTot": 0,
	"vlrDctoGlobalCapturado_encTot": 0,
	"vlrRetencionesF_encTot": 0,
	"vlrEfectivoF_encTot": 0,
	"vlrChequesAlDiaF_encTot": 0,
	"vlrCarteraF_encTot": 0,
	"vlrChequePosfechado_encTot": 0,
	"vlrTarjetaCreditoF_encTot": 0,
	"vlrTarjetaDebitoF_encTot": 0,
	"vlrAnticipo_encTot": 0,
	"montoEscrito1_encTot": "Cuatro millones setecientos noventa y cinco mil ochocientos sesenta y cinco pesos mcte.",
	"montoEscrito2_encTot": "",
	"vlrBruto_encTot": 4248640,
	"vlrDctoLinea1Y2_encTot": 0,
	"vlrSub_encTot": 4248640,
	"vlrDctoImpoconsumo_encTot": 0,
	"vlrTotalF_encTot": 5055882,
	"totalCantidad1_encTot": 0,
	"totalCantidad2_encTot": 0,
	"vlrReteFuente_encTot": 106216,
	"vlrReteIva_encTot": 121086,
	"vlrReteIca_encTot": 32715,
	"vlrBrutoNoGravadoSinDcto_encTot": 0,
	"vlrBrutoGravadosSinDcto_encTot": 4248640,
	"vlrBrutoNoGravadosMenosDcto_encTot": 0,
	"vlrBrutoGravadoMenosDcto_encTot": 4248640,
	"vlrProntoPago_encTot": 0,
	"fechaProntoPago_encTot": "06/01/2020 00:00",
	"netoSinAnticipos_encTot": 4795865,
	"detalleDocumento1_encTot": "RM 8933 - 2001229519 / MANZANARES DE CIUDAD DEL VALLE",
	"detalleDocumento2_encTot": "",
	"detalleDocumento3_encTot": "",
	"detalleDocumento4_encTot": "",
	"tipoNotaCredito_encTot": 0,
	"documentoReferencia_encTot": "",
	"fechaReferencia_encTot": "01/01/2000 00:00",
	"estadoProcesado_encTot": 3,
	"estado_encTot": 1,
	"detalles": [
            {
                "codigo": 27201,
                "tip_documento_detalle": "FV",
                "prefijo_detalle": "FA",
                "factura_detalle": 12202,
                "referenciaItem": 27201,
                "codigoExtensionItem": "A",
                "descripcionExtensionItem": "CABALLETE ART VENT INFERIOR 1000",
                "descripcionItem": "CABALLETE ART VENT INFERIOR 1000",
                "unidadMedida": "UND",
                "bodegaMovimiento": "0",
                "serial": "0",
                "fechaSerial": "01/01/1999",
                "loteItemMovimiento": "0",
                "fechaVencimientoLote": "01/01/1999",
                "cantidad": 80,
                "costoTotalMovimiento": "0",
                "precioUnitario": 26554,
                "vlrBrutoTotalMovimiento": 2124320,
                "vlrBruto_Descuento": 2124320,
                "porcentajeDescuento_1": "0",
                "vlrDescuento_1": "0",
                "porcentajeIva": 19,
                "vlrIva": 403620.8,
                "vlrNetoMovimiento": 2124320,
                "porcentajeDescuento_2": "0",
                "Descuento_2": "0",
                "pesoItem": 6.46,
                "vlrIcoUnitario": "0",
                "vlrIcoTotal": "0",
                "estado": "0",
                "campo1_adicional": "x",
                "campo2_adicional": "x",
                "campo3_adicional": "x",
                "campo4_adicional": "x",
                "campo5_adicional": "x",
                "campo6_adicional": "x",
                "campo7_adicional": "x",
                "campo8_adicional": "x",
                "campo9_adicional": "x",
                "campo10_adicional": "x",
                "cantidad2": "0",
                "porcentajeDescuento_3": "0",
                "vlrDescuento_3": "0",
                "porcentajeDescuento_4": "0",
                "vlrDescuento_4": "0"
            },
            {
                "codigo": 27201,
                "tip_documento_detalle": "FV",
                "prefijo_detalle": "FA",
                "factura_detalle": 12202,
                "referenciaItem": 27201,
                "codigoExtensionItem": "A",
                "descripcionExtensionItem": "CABALLETE ART VENT SUPERIOR 1000",
                "descripcionItem": "CABALLETE ART VENT SUPERIOR 1000",
                "unidadMedida": "UND",
                "bodegaMovimiento": "0",
                "serial": "0",
                "fechaSerial": "01/01/1999",
                "loteItemMovimiento": "0",
                "fechaVencimientoLote": "01/01/1999",
                "cantidad": 80,
                "costoTotalMovimiento": "0",
                "precioUnitario": 26554,
                "vlrBrutoTotalMovimiento": 2124320,
                "vlrBruto_Descuento": 2124320,
                "porcentajeDescuento_1": "0",
                "vlrDescuento_1": "0",
                "porcentajeIva": 19,
                "vlrIva": 403620.8,
                "vlrNetoMovimiento": 2124320,
                "porcentajeDescuento_2": "0",
                "Descuento_2": "0",
                "pesoItem": 7.5,
                "vlrIcoUnitario": "0",
                "vlrIcoTotal": "0",
                "estado": "0",
                "campo1_adicional": "x",
                "campo2_adicional": "x",
                "campo3_adicional": "x",
                "campo4_adicional": "x",
                "campo5_adicional": "x",
                "campo6_adicional": "x",
                "campo7_adicional": "x",
                "campo8_adicional": "x",
                "campo9_adicional": "x",
                "campo10_adicional": "x",
                "cantidad2": "0",
                "porcentajeDescuento_3": "0",
                "vlrDescuento_3": "0",
                "porcentajeDescuento_4": "0",
                "vlrDescuento_4": "0"
            }
        ]
    }
                    </code>
                </pre>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body table-responsive p-2">
                <h5>Respuestas:</h5>

                200: Factura ya Registrada
                <pre style="background:#333">
                    <code style="font-size:14px; color:#00ff00; ">
{
    "message": "El documento xxxxxx ya se encuentra registrado",
    "type": "success"
}
                    </code>
                </pre>
                200: Factura Creada
                <pre style="background:#333; padding:0px">
                    <code style="font-size:14px; color:#00ff00; ">
{
    "message": "El documento xxxxxx ya se encuentra registrado",
    "type": "success"
}
                    </code>
                </pre>
                400: Factura sin detalle: el cuerpo de la factura esta correcto sin embargo no anexo los objetos de detalle de factura. objetos minimos 1 Objeto.
                <pre style="background:#333; padding:0px">
                    <code style="font-size:14px; color:#00ff00; ">
{
    "message": "La factura recibida no contiene detalles, verifique e intente de nuevo.",
    "type": "error",
    "result": "E002"
}
                    </code>
                </pre>
                400: Api Key Invalida: El formato de autenicacion con la api es correcto pero este no coincide con el registrado para su empresa. puede generar una nueva key a traves de esta aplicacion e intentar de nuevo.
                <pre style="background:#333; padding:0px">
                    <code style="font-size:14px; color:#00ff00; ">
{
    "message": "Api Key Invalida",
    "type": "error",
    "result": "EA01"
}
                    </code>
                </pre>
                401: Autorizacion Invalida: no se ha proporcionado cabecera de consulta [Authorization], este debe cumplir con el siguiente formato: Authorization: Bearer XXXXXXXXTUXAPIXKEYXXXXXXX
                <pre style="background:#333; padding:0px">
                    <code style="font-size:14px; color:#00ff00; ">
{
    "message": "Autorizacion Invalida",
    "type": "error",
    "result": "E001"
}
                    </code>
                </pre>
            </div>
        </div>
    </div>
</div>


<div class="row">
<div class="col-12">
   <div class="card">

      <!-- /.card-header -->
      <div class="card-body table-responsive p-2">
        <p><h2>Descripcion del Objeto Factura</h2></p>
         <table class="tableData table table-hover">
            <thead>
               <tr>
                  <th>Campo</th>
                  <th>Tipo</th>
                  <th>Longitud</th>
                  <th>Requerido</th>
                  <th> Descripcion</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>codigo_empresa_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Codigo de la empresa</td>
               </tr>
               <tr>
                  <td>codigo_SUC_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Codigo de la sucursal</td>
               </tr>
               <tr>
                  <td>divisa_encTot</td>
                  <td>VARCHAR</td>
                  <td>5</td>
                  <td>Si</td>
                  <td>Codigo de la divisa</td>
               </tr>
               <tr>
                  <td>fechaDocumento_encTot</td>
                  <td>DATETIME</td>
                  <td>19</td>
                  <td>Si</td>
                  <td>Fecha del documento Con la Hora del Documento</td>
               </tr>
               <tr>
                  <td>tipoDocumento_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Tipo de documento (Factura de Venta, Nota Credito, Nota Debito)</td>
               </tr>
               <tr>
                  <td>prefijo_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Prefijo del documento</td>
               </tr>
               <tr>
                  <td>numeroDocumento_encTot</td>
                  <td>INT</td>
                  <td>11</td>
                  <td>Si</td>
                  <td>Numero del documento</td>
               </tr>
               <tr>
                  <td>factura_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Concatenacion prefijo mas el numero de la factura</td>
               </tr>
               <tr>
                  <td>fechaVencimiento_encTot</td>
                  <td>DATETIME</td>
                  <td>19</td>
                  <td>Si</td>
                  <td>Fecha de vencimiento del documento, Si es Contado misma fecha de generacion Documento</td>
               </tr>
               <tr>
                  <td>periodicidadFactura_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Periocidad de la factura Si es Credito</td>
               </tr>
               <tr>
                  <td>numerosCuotasFactura_encTot</td>
                  <td>VARCHAR</td>
                  <td>10</td>
                  <td>No</td>
                  <td>Codigo Dian Medio Pago(10:Efectivo)</td>
               </tr>
               <tr>
                  <td>condicionProntoPago_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Condicion de pronto pago</td>
               </tr>
               <tr>
                  <td>descripcionCondicionPago_encTot</td>
                  <td>VARCHAR</td>
                  <td>255</td>
                  <td>Si</td>
                  <td>Condigo Descripcion Pago Dian (1:Contado,2:Credito)</td>
               </tr>
               <tr>
                  <td>codigoVendedor_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Codigo del vendedor</td>
               </tr>
               <tr>
                  <td>cedulaVendedor_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Cedula del vendedor</td>
               </tr>
               <tr>
                  <td>nombreVendedor_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Nombre del vendedor</td>
               </tr>
               <tr>
                  <td>numeroOrdenCompra_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Numero de orden de compra</td>
               </tr>
               <tr>
                  <td>numeroRemision_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Numero de remision</td>
               </tr>
               <tr>
                  <td>numeroOrdenVenta_encTot</td>
                  <td>VARCHAR</td>
                  <td>255</td>
                  <td>No</td>
                  <td>NumeroOrdenVenta_encTot</td>
               </tr>
               <tr>
                  <td>numeroCargue_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Numero de cargue</td>
               </tr>
               <tr>
                  <td>codigoTercero_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Codigo del tercero</td>
               </tr>
               <tr>
                  <td>sucursalTercero_encTot</td>
                  <td>VARCHAR</td>
                  <td>255</td>
                  <td>No</td>
                  <td>Sucursal del tercero</td>
               </tr>
               <tr>
                  <td>nitTercero_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Nit del tercero el mismo que el codigo del tercero</td>
               </tr>
               <tr>
                  <td>digitoVerificacion_encTot</td>
                  <td>INT</td>
                  <td>11</td>
                  <td>Si</td>
                  <td>Digito de verificacion de la empresa, Cero si no tiene</td>
               </tr>
               <tr>
                  <td>apellido1_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>1er Apellido del cliente</td>
               </tr>
               <tr>
                  <td>apellido2_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>2do Apellido del cliente</td>
               </tr>
               <tr>
                  <td>nombreTercero_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Nombre del cliente</td>
               </tr>
               <tr>
                  <td>tipoTercero_encTot</td>
                  <td>VARCHAR</td>
                  <td>100</td>
                  <td>Si</td>
                  <td>Tipo de tercero Codigo Dian (Naturaleza persona juridica o persona natural) (1:Persona Juridica,2:Persona Natural)</td>
               </tr>
               <tr>
                  <td>tipoIdentificacion_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Tipo de identificacion (Cedula, Nit Etc..) Se hace comparacion se pone el del ERP </td>
               </tr>
               <tr>
                  <td>codigoPaisTercero_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Codigo del pais del tercero</td>
               </tr>
               <tr>
                  <td>codigoDepartamentoTercero_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Codigo del departamento del tercero Según Tabla Dian</td>
               </tr>
               <tr>
                  <td>codigoCiudadTercero_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Codigo de la ciudad del tercero Según Tabla Dian</td>
               </tr>
               <tr>
                  <td>direccion1_encTot</td>
                  <td>VARCHAR</td>
                  <td>200</td>
                  <td>No</td>
                  <td>Direccion 1</td>
               </tr>
               <tr>
                  <td>direccion2_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Direccion 2</td>
               </tr>
               <tr>
                  <td>telefono1_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Telefono 1</td>
               </tr>
               <tr>
                  <td>telefono2_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Telefono 2</td>
               </tr>
               <tr>
                  <td>fax_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Fax del tercero</td>
               </tr>
               <tr>
                  <td>claseClienteTercero_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Regimen del cliente</td>
               </tr>
               <tr>
                  <td>email_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>Si</td>
                  <td>Email del tercero</td>
               </tr>
               <tr>
                  <td>barrio_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Bario del tercero</td>
               </tr>
               <tr>
                  <td>vendedorAsociadoCliente_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Vendedor asociado al cliente</td>
               </tr>
               <tr>
                  <td>condicionPagoCliente_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Condicion de pago cliente</td>
               </tr>
               <tr>
                  <td>cupoCredigoCliente_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Cupo del credito</td>
               </tr>
               <tr>
                  <td>criterio1Cliente_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Criterio 1</td>
               </tr>
               <tr>
                  <td>criterio2Cliente_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Criterio 2</td>
               </tr>
               <tr>
                  <td>criterio3Cliente_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>criterio 3</td>
               </tr>
               <tr>
                  <td>razonSocial_encTot</td>
                  <td>VARCHAR</td>
                  <td>255</td>
                  <td>Si</td>
                  <td>Razon social</td>
               </tr>
               <tr>
                  <td>nombreEstablecimiento_encTot</td>
                  <td>VARCHAR</td>
                  <td>255</td>
                  <td>Si</td>
                  <td>Nombre del establecimiento (Nombre Comercial Empresa)</td>
               </tr>
               <tr>
                  <td>vlrBrutoF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>Si</td>
                  <td>Valor bruto de la factura</td>
               </tr>
               <tr>
                  <td>vlrDctoLinea1F_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrDctoLinea2F_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrDctoGlobal1F_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor De Primer descuento, Si la factura tiene Descuento, si no tiene debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrDctoGlobal2F_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor De Segundo descuento, Si la factura tiene Descuento, si no tiene debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrIvaF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>Si</td>
                  <td>Valor del Iva de la factura</td>
               </tr>
               <tr>
                  <td>vlrImpoconsumo1F_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor del impoconsumo 1</td>
               </tr>
               <tr>
                  <td>vlrImpoconsumo2F_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor del impoconsumo 2</td>
               </tr>
               <tr>
                  <td>vlrNetoF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor neto factura debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>porceDctoGlobal1F_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>porceDctoGlobal2F_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrDctoGlobalCapturado_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor descuento Si la factura tiene Descuento</td>
               </tr>
               <tr>
                  <td>vlrRetencionesF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor de la retencion de la factura</td>
               </tr>
               <tr>
                  <td>vlrEfectivoF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>valor efectivo de la factura</td>
               </tr>
               <tr>
                  <td>vlrChequesAlDiaF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrCarteraF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrChequePosfechado_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrTarjetaCreditoF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrTarjetaDebitoF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrAnticipo_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>montoEscrito1_encTot</td>
                  <td>VARCHAR</td>
                  <td>100</td>
                  <td>Si</td>
                  <td>Valor En Letras de la factura</td>
               </tr>
               <tr>
                  <td>montoEscrito2_encTot</td>
                  <td>VARCHAR</td>
                  <td>100</td>
                  <td>No</td>
                  <td>Monto escrito 2</td>
               </tr>
               <tr>
                  <td>vlrBruto_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>Si</td>
                  <td>Valor bruto</td>
               </tr>
               <tr>
                  <td>vlrDctoLinea1Y2_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrSub_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>Si</td>
                  <td>Valor subtotal</td>
               </tr>
               <tr>
                  <td>vlrDctoImpoconsumo_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrTotalF_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>Si</td>
                  <td>Valor total de la factura</td>
               </tr>
               <tr>
                  <td>totalCantidad1_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>totalCantidad2_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Debe de ir en Cero</td>
               </tr>
               <tr>
                  <td>vlrReteFuente_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor de la retefuente</td>
               </tr>
               <tr>
                  <td>vlrReteIva_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor retencion iva</td>
               </tr>
               <tr>
                  <td>vlrReteIca_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor retencion ica</td>
               </tr>
               <tr>
                  <td>vlrBrutoNoGravadoSinDcto_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor bruto no gravado sin descuento</td>
               </tr>
               <tr>
                  <td>vlrBrutoGravadosSinDcto_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor bruto gravado sin descuento</td>
               </tr>
               <tr>
                  <td>vlrBrutoNoGravadosMenosDcto_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor bruto no gravado menos descuento</td>
               </tr>
               <tr>
                  <td>vlrBrutoGravadoMenosDcto_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>Si</td>
                  <td>Valor bruto gravado menos descuento (Base sobre la cual se calculan los impuestos)</td>
               </tr>
               <tr>
                  <td>vlrProntoPago_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Valor del pronto pago</td>
               </tr>
               <tr>
                  <td>fechaProntoPago_encTot</td>
                  <td>DATETIME</td>
                  <td>19</td>
                  <td>Si</td>
                  <td>Fecha del pronto pago misma fecha Vencimiento</td>
               </tr>
               <tr>
                  <td>netoSinAnticipos_encTot</td>
                  <td>DECIMAL</td>
                  <td>17</td>
                  <td>No</td>
                  <td>Neto sin anticipos</td>
               </tr>
               <tr>
                  <td>detalleDocumento1_encTot</td>
                  <td>VARCHAR</td>
                  <td>100</td>
                  <td>No</td>
                  <td>Detalle del documento 1</td>
               </tr>
               <tr>
                  <td>detalleDocumento2_encTot</td>
                  <td>VARCHAR</td>
                  <td>100</td>
                  <td>No</td>
                  <td>Detalle del documento 2</td>
               </tr>
               <tr>
                  <td>detalleDocumento3_encTot</td>
                  <td>VARCHAR</td>
                  <td>100</td>
                  <td>No</td>
                  <td>Detalle del documento 3</td>
               </tr>
               <tr>
                  <td>detalleDocumento4_encTot</td>
                  <td>VARCHAR</td>
                  <td>100</td>
                  <td>No</td>
                  <td>Detalle del documento 4</td>
               </tr>
               <tr>
                  <td>tipoNotaCredito_encTot</td>
                  <td>INT</td>
                  <td>11</td>
                  <td>No</td>
                  <td>Tipo de Nota Credito (Codigo Dian 2 Anulacion de factura) si no es una nota debe de ser cero</td>
               </tr>
               <tr>
                  <td>documentoReferencia_encTot</td>
                  <td>VARCHAR</td>
                  <td>45</td>
                  <td>No</td>
                  <td>Documento de referencia Al que se le aplica Nota Credito</td>
               </tr>
               <tr>
                  <td>fechaReferencia_encTot</td>
                  <td>DATETIME</td>
                  <td>19</td>
                  <td>No</td>
                  <td>Referencia del documento Documento que se le aplica la nota credito</td>
               </tr>
               <tr>
                  <td>estadoProcesado_encTot</td>
                  <td>INT</td>
                  <td>11</td>
                  <td>Si</td>
                  <td>Estado procesado debe de ser Cero</td>
               </tr>
               <tr>
                  <td>estado_encTot</td>
                  <td>INT</td>
                  <td>11</td>
                  <td>Si</td>
                  <td>Estado  Debe de ser Cero</td>
               </tr>
            </tbody>
         </table>
      </div>
      <!-- /.card-body -->
   </div>



<div class="row">
   <div class="col-12">
      <div class="card">
         
         <!-- /.card-header -->
         <div class="card-body table-responsive p-2">
         <p><h2>Descripcion del Objeto Detalle de Factura</h2></p>
            <table class="tableData table table-hover">
               <thead>
                    <tr>
                        <th>Campo</th>
                        <th>Tipo</th>
                        <th>Longitud</th>
                        <th>Requerido</th>
                        <th> Descripcion</th>
                    </tr>
               </thead>
               <tbody>
                    <tr>
                     <td>codigo</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:0</td>
                     <td>Codigo del Producto</td>
                  </tr>
                  <tr>
                     <td>tip_documento_detalle</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:1</td>
                     <td>Tipo de documento de la Factura</td>
                  </tr>
                  <tr>
                     <td>prefijo_detalle</td>
                     <td>VARCHAR</td>
                     <td>10</td>
                     <td>1:1</td>
                     <td>Prefijo del detalle</td>
                  </tr>
                  <tr>
                     <td>factura_detalle</td>
                     <td>INT</td>
                     <td>11</td>
                     <td>1:1</td>
                     <td>Num factura</td>
                  </tr>
                  <tr>
                     <td>referenciaItem</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:0</td>
                     <td>Referencia del item</td>
                  </tr>
                  <tr>
                     <td>codigoExtensionItem</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:0</td>
                     <td>Codigo de extension</td>
                  </tr>
                  <tr>
                     <td>descripcionExtensionItem</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:1</td>
                     <td>Descripcion extension del item</td>
                  </tr>
                  <tr>
                     <td>descripcionItem</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:1</td>
                     <td>Descripcion del item</td>
                  </tr>
                  <tr>
                     <td>unidadMedida</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:1</td>
                     <td>Unidad de medida, en letras</td>
                  </tr>
                  <tr>
                     <td>bodegaMovimiento</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:0</td>
                     <td>Bodega de moviemiento</td>
                  </tr>
                  <tr>
                     <td>serial</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:0</td>
                     <td>Serial</td>
                  </tr>
                  <tr>
                     <td>fechaSerial</td>
                     <td>DATE</td>
                     <td>10</td>
                     <td>1:0</td>
                     <td>Fecha del serial</td>
                  </tr>
                  <tr>
                     <td>loteItemMovimiento</td>
                     <td>VARCHAR</td>
                     <td>45</td>
                     <td>1:0</td>
                     <td>Lote item movimiento</td>
                  </tr>
                  <tr>
                     <td>fechaVencimientoLote</td>
                     <td>DATE</td>
                     <td>10</td>
                     <td>1:0</td>
                     <td>Fecha de vencimiento del lote</td>
                  </tr>
                  <tr>
                     <td>cantidad</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:1</td>
                     <td>Cantidad</td>
                  </tr>
                  <tr>
                     <td>costoTotalMovimiento</td>
                     <td>DECIMAL</td>
                     <td>12</td>
                     <td>1:0</td>
                     <td>Costo total del movimiento</td>
                  </tr>
                  <tr>
                     <td>precioUnitario</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:1</td>
                     <td>Precio unitario</td>
                  </tr>
                  <tr>
                     <td>vlrBrutoTotalMovimiento</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:1</td>
                     <td>Valor bruto total movimiento</td>
                  </tr>
                  <tr>
                     <td>vlrBruto_Descuento</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:1</td>
                     <td>Valor bruto Menos descuento si tiene descuento</td>
                  </tr>
                  <tr>
                     <td>porcentajeDescuento_1</td>
                     <td>DECIMAL</td>
                     <td>12</td>
                     <td>1:0</td>
                     <td>Porcentaje descuento </td>
                  </tr>
                  <tr>
                     <td>vlrDescuento_1</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:0</td>
                     <td>Valor del descuento </td>
                  </tr>
                  <tr>
                     <td>porcentajeIva</td>
                     <td>DECIMAL</td>
                     <td>12</td>
                     <td>1:0</td>
                     <td>Porcentaje iva</td>
                  </tr>
                  <tr>
                     <td>vlrIva</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:1</td>
                     <td>Valor del iva</td>
                  </tr>
                  <tr>
                     <td>vlrNetoMovimiento</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:1</td>
                     <td>Valor neto movimiento Valor Total Item</td>
                  </tr>
                  <tr>
                     <td>porcentajeDescuento_2</td>
                     <td>DECIMAL</td>
                     <td>12</td>
                     <td>1:0</td>
                     <td>Porcentaje descuento 2</td>
                  </tr>
                  <tr>
                     <td>Descuento_2</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:0</td>
                     <td>Descuento 2</td>
                  </tr>
                  <tr>
                     <td>pesoItem</td>
                     <td>DECIMAL</td>
                     <td>12</td>
                     <td>1:0</td>
                     <td>Peso del item</td>
                  </tr>
                  <tr>
                     <td>vlrIcoUnitario</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:0</td>
                     <td>Valor ico unitario</td>
                  </tr>
                  <tr>
                     <td>vlrIcoTotal</td>
                     <td>DECIMAL</td>
                     <td>17</td>
                     <td>1:0</td>
                     <td>Valor ico total</td>
                  </tr>
                  <tr>
                     <td>estado</td>
                     <td>INT</td>
                     <td>11</td>
                     <td>1:1</td>
                     <td>Debe de ser Cero</td>
                  </tr>
                  <tr>
                     <td>campo1_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 1</td>
                  </tr>
                  <tr>
                     <td>campo2_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 2</td>
                  </tr>
                  <tr>
                     <td>campo3_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 3</td>
                  </tr>
                  <tr>
                     <td>campo4_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 4</td>
                  </tr>
                  <tr>
                     <td>campo5_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 5</td>
                  </tr>
                  <tr>
                     <td>campo6_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 6</td>
                  </tr>
                  <tr>
                     <td>campo7_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 7</td>
                  </tr>
                  <tr>
                     <td>campo8_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 8</td>
                  </tr>
                  <tr>
                     <td>campo9_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 9</td>
                  </tr>
                  <tr>
                     <td>campo10_adicional</td>
                     <td>VARCHAR</td>
                     <td>100</td>
                     <td>1:0</td>
                     <td>campo adicional 10</td>
                  </tr>
                  <tr>
                     <td>cantidad2</td>
                     <td>DECIMAL</td>
                     <td>17.2</td>
                     <td>1:0</td>
                     <td>segunda cantidad si la tiene</td>
                  </tr>
                  <tr>
                     <td>porcentajeDescuento_3</td>
                     <td>DECIMAL</td>
                     <td>17.2</td>
                     <td>1:0</td>
                     <td>Equivale al porcentaje en decimal del descuento global1 de la factura</td>
                  </tr>
                  <tr>
                     <td>vlrDescuento_3</td>
                     <td>DECIMAL</td>
                     <td>17.2</td>
                     <td>1:0</td>
                     <td>Equivale al valor del descuendo  global1 sobre el item de la factura, este valor afecta la base imponible</td>
                  </tr>
                  <tr>
                     <td>porcentajeDescuento_4</td>
                     <td>DECIMAL</td>
                     <td>17.2</td>
                     <td>1:0</td>
                     <td>Equivale al porcentaje en decimal del descuento global2 de la factura</td>
                  </tr>
                  <tr>
                     <td>vlrDescuento_4</td>
                     <td>DECIMAL</td>
                     <td>17.2</td>
                     <td>1:0</td>
                     <td>Equivale al valor del descuendo  global2 sobre el item de la factura, este valor afecta la base imponible</td>
                  </tr>
               </tbody>
            </table>
         </div>
         <!-- /.card-body -->
      </div>
      <!-- /.card -->
   </div>
</div>

<script>
      $(document).ready(function(){
         $.get('{{ asset("key/get") }}/',function(d){
            $('.key').html(d)
         });
      });
    </script>

@stop


