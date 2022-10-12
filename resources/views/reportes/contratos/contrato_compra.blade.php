<!DOCTYPE html>
<html lang="es">  
  <head>    
    <title>Contrato {{ $data[0]->numero }}</title>    
    <meta charset="ISO-5899-1">
    <meta name="title" content="Título de la WEB">
    <meta name="description" content="Descripción de la WEB">    
    <style>
        html{
            margin:0px;
        }
        body{
            text-align:justify; 
            font-family:Verdana, Arial, Helvetica, sans-serif; 
            font-size:13px;
            margin: 0.5cm 1cm;
        }
        p{
            text-align:justify; 
        }
        .tg{
            border-collapse:collapse;
            border-spacing:0;
        }
        .tgx{
            border-collapse:collapse;
            border-spacing:0;
        }
        .tg td{
            font-family:Arial, sans-serif;
            font-size:14px;
            padding:10px 5px;
            border-style:solid;
            border-width:1px;
            overflow:hidden;
            word-break:normal;
            border-color:black;
        }
        .tgx td{
            font-family:Arial, sans-serif;
            font-size:14px;
            padding:5px;
            border-style:solid;
            border-width:1px;
            overflow:hidden;
            word-break:normal;
            border-color:white;
            text-align:justify
        }
        .tg th{
            font-family:Arial, sans-serif;
            font-size:14px;
            font-weight:normal;
            padding:10px 5px;
            border-style:solid;
            border-width:1px;
            overflow:hidden;
            word-break:normal;
            border-color:black;
        }
    </style>
  </head>  
  <body>
  <table border="0" width="100%">
        <tr style="font-weight:bold">
            <td>Dosquebradas, {{ date('d/m/Y',strtotime($data[0]->fecha_contrato)) }}</td>
            <td style="text-align:right">Contrato {{ $data[0]->numero }}</td>
        </tr>
  </table>
  <br/><br/>
  <br/><br/>
  <b style="text-align:center; display:block">CONTRATO DE COMPRAVENTA DE CAFÉ ENTRE: COFFEE GOLD Y {{ $data[0]->proveedor[0]->nombre }}</b>
  <br/><br/>
  <br/><br/>
  <p>
Los suscritos a saber, por una parte, <b>FELIPE ANDRES MORENO JARAMILLO</b>, identificado con la cédula de ciudadanía: <b>18.518.175</b>
de <b>Pereira</b>, en su condición de representante legal de <b>COFFEEGOLD</b>, con domicilio en la <b>Cra 5 no. 3-20</b> en 
la ciudad de <b>Aranzazu Caldas</b>, identificado con NIT No.: <b>900.938.916-2</b>, quien en adelante y para efectos de este 
documento se denomina <b>COMPRADOR</b> y por otra parte <b>{{ $data[0]->proveedor[0]->nombre }} </b>, identificado con cédula de ciudadanía
número <b>{{ $data[0]->proveedor[0]->nit }}-{{ $data[0]->proveedor[0]->digito_verificacion_nit }}</b>, con domicilio principal en la ciudad de <b>{{ $data[0]->proveedor[0]->ubicacion[0]->nombre_ciudad }},{{ $data[0]->proveedor[0]->ubicacion[0]->departamento }}</b>,  quien en adelante se denominara y obrara en 
calidad de <b>VENDEDOR</b>, hemos acordado celebrar el presente contrato de compraventa, el cual se regirá por las siguientes
cláusulas y lo previsto por la legislación civil y comercial, disponen lo siguiente:</p>
  

    
    <p>
        <b>PRIMERO: OBJETO Y DESCRIPCIÓN DEL PRODUCTO:</b> Las partes se disponen a celebrar el siguiente negocio jurídico y contrato bilateral, donde el <b>VENDEDOR</b> se obliga con el <b>COMPRADOR</b> a entregar el producto que a continuación se describe:
    </p>

    <p>
        <b>CANTIDAD DEL CAFÉ: {{ number_format($data[0]->kilos_compromiso,0,',','.') }} KILOGRAMOS.</b>
    </p>

    <p>
        <b>DECRIPCIÓN DEL PRODUCTO: {{ strtoupper($data[0]->tipo_cafe->tipo_cafe) }}</b>
    </p>

    <p>
        <b>TAZA: LIMPIA</b>
    </p>

    <p>
        <b>PRECIO DEFINIDO: $ {{ number_format($data[0]->precio_kilogramo,0,',','.') }} </b>
    </p>    

    <p><strong>SEGUNDO: OBLIGACIONES DEL VENDEDOR: </strong>Sin perjuicio de las obligaciones legalmente establecidas por la Ley y las que se encuentran estipuladas, el <strong>VENDEDOR</strong> se obliga a:</p>
    Garantizar la calidad del producto y que corresponde a lo presentado en las muestras previas entregadas al&nbsp;&nbsp; <strong>COMPRADOR</strong>.
    <div>
        <ol>
            <li>Entregar al<strong> COMPRADOR</strong> con base en la cl&aacute;usula cuarta, la cantidad de caf&eacute; estipulada en la cl&aacute;usula primera y al precio pactado en la cl&aacute;usula quinta del presente contrato de compraventa.</li>
            <li>Entregar el producto de acuerdo a las indicaciones t&eacute;cnicas.</li>
        </ol>
    </div>
    <p><strong>TERCERO: OBLIGACIONES DEL COMPRADOR. </strong>Sin perjuicio de las obligaciones legalmente establecidas por la Ley y las que se encuentran en el presente  contrato el <strong>COMPRADOR </strong>se obliga a pagar al <strong>VENDEDOR</strong>    el precio pactado dentro del t&eacute;rmino fijado en la cl&aacute;usula quinta del presente contrato.</p>
    <p><strong>CUARTO: LUGAR Y FECHA DE LA ENTREGA DEL PRODUCTO.</strong>El<strong> COMPRADOR </strong>retirar&aacute; el caf&eacute; que ser&aacute; entregado por el <strong>VENDEDOR</strong> en un plazo m&aacute;ximo de <strong>30</strong>    d&iacute;as contados a partir de la fecha de la firma del presente contrato en la ciudad de Dosquebradas.</p>
    <p>La entrega del producto f&iacute;sico ser&aacute;n concertados entre las partes y podr&aacute;n realizarse entregas parciales si ambas partes lo disponen de com&uacute;n acuerdo.</p>

    <p><strong>PAR&Aacute;GRAFO:</strong> Se entiende incluido el trasporte dentro del negocio jur&iacute;dico, por lo tanto, el COMPRADOR, no adeudar&aacute; pago alguno por este concepto.</p>
    <p><strong>QUINTO: PRECIO:&nbsp;</strong>El precio total del caf&eacute; objeto de compraventa ser&aacute; el equivalente a la suma de:<strong>$&nbsp;{{ number_format($data[0]->valor_contrato,0,',','.') }}&nbsp;</strong>({{ \NumeroALertas::convertir($data[0]->valor_contrato, 'pesos colombianos', 'centimos') }} m/cte.)</p>
    <p><strong>D&Eacute;CIMOTERCERO: CL&Aacute;USULA COMPROMISORIA:&nbsp;</strong>Toda controversia o diferencia relativa a este convenio ser&aacute; resuelta de manera directa y amigable entre las partes; si ello no fuere posible, esta diferencia se resolver&aacute;
        por un tribunal de Arbitramento designado por la C&aacute;mara de Comercio de Dosquebradas, el cual se sujetara a lo dispuesto en las normas vigentes sobre la Materia, de acuerdo con las siguientes reglas:</p>

    <div>
        <ol>
            <li>El Tribunal estar&aacute; integrado por tres (3) &aacute;rbitros, designados directamente por la c&aacute;mara de Comercio, sin que le sea permitido a alguna de las partes, oponerse a &eacute;l.La organizaci&oacute;n interna del Tribunal se sujetara
                a las reglas previstas en el Centro de Conciliaci&oacute;n y Arbitraje.El Tribunal decidir&aacute; en derecho.</li>
            <li>El Tribunal funcionara en el Centro de Conciliaci&oacute;n y Arbitraje de la C&aacute;mara de Comercio de Dosquebradas.</li>
        </ol>
    </div>
    <p><strong>D&Eacute;CIMO CUARTO: DOMICILIO CONTRACTUAL:</strong> Para todos los efectos legales, las partes podr&aacute;n ser ubicadas y recibir&aacute;n las notificaciones en los siguientes dato:<strong>&nbsp;&nbsp;</strong></p>

    @include('reportes.contratos.contrato_compra.address_actors')

    <div>
        <p><strong>D&Eacute;CIMO CUARTO: M&Eacute;RITO EJECUTIVO.</strong>El presente documento presta m&eacute;rito ejecutivo para exigir el cumplimiento de las obligaciones pactadas sin necesidad de requerimientos previos o constituci&oacute;n en mora para
            hacer exigible la obligaci&oacute;n pactada.&nbsp;<strong><br>
            D&Eacute;CIMO QUINTO: VALIDEZ Y PERFECC<a name="_GoBack"></a>IONAMIENTO:</strong> El presente contrato requiere para su perfeccionamiento la firma de las partes<br><br><br><br>Para constancia se firma
            en la ciudad de Dosquebradas a los (<strong>{{ date('d',strtotime($data[0]->fecha_contrato)) }}</strong>) d&iacute;as del mes&nbsp;(<strong>{{ date('m',strtotime($data[0]->fecha_contrato)) }}</strong>)&nbsp;del a&ntilde;o (<strong>{{ date('Y',strtotime($data[0]->fecha_contrato)) }}</strong>). </p>
    </div>

    @include('reportes.contratos.contrato_compra.sign_actors')
    
    <script type="text/php">
        if (isset($pdf)) {
            $text = "{PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width);
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
    </body>  
</html>

