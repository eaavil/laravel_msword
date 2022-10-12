<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;
use App\Models\Recepcion;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ParametrosModulos;
use SoapClient;

class Controller extends BaseController
{   
  
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   


    
    public function autenticar(){
        //*SOLICITAR TOKET
        //Desahabilitar cache
        ini_set("soap.wsdl_cache_enabled", "0");
        //Parametros de entrada
        /*
        RUTACCESOAPI         = RUT EMPRESA REGISTRADA.
        PASSWORDACCESOAPI    = PASSWORD OBTENIDA CON EL METODO RegistraCedente.
        */
        
        //Establecer parametros de envío Ejemplo:
        $parametros = array("RUTACCESOAPI" => "77650720-2","PASSWORDACCESOAPI" => "lQ4JtP0ZMx"); 
        
        //Dirección donde se encuentra el servicio
        $client = new SoapClient("http://www.appoctava.cl/ws/WebService.php?wsdl");
        //ObtenerToken
        try{
          //iniciar cliente soap    
          $resultado = $client->__SoapCall("ObtenerToken", $parametros);
          //Parametros de salida
          /*$DescripcionResultado=$resultado[0]->DescripcionResultado;
          
          $FechaHoraToken=$resultado[0]->FechaHoraRegistro;
          $TiempoEjecucion=$resultado[0]->TiempoEjecucion;*/
          //Si hay algún problema intermedio ser atrapado aquí.
          $Token=$resultado[0]->Token;
          }catch (SoapFault $e){
              echo "Ups!! hubo un problema y no pudimos recuperar los datos.<br/>$e<hr/>";
          }  
          //*VALIDAR TOKEN
          //Desahabilitar cache
          ini_set("soap.wsdl_cache_enabled", "0");
    
          //Dirección donde se encuentra el servicio
        $client = new SoapClient("http://www.appoctava.cl/ws/WebService.php?wsdl");
    
          //Parametros de entrada
          /*  TOKEN         = TOKEN OBTENIDO EN MÉTODO ObtenerToken      */
          
          // $TokenObtenido = valor obtenido por el método ObtenerToken.
          $parametros = array("TOKEN" => $Token);      
          
          try{
          //iniciar cliente soap    
          $client->__SoapCall("ValidarTokenExt", $parametros);
          //parametro de salida
          /*$DescripcionResultado = $resultado[0]->DescripcionResultado;
          $TiempoEjecucion=$resultado[0]->TiempoEjecucion;*/
          
          //echo $DescripcionResultado."<br/>";
          //Si hay algún problema intermedio ser atrapado aquí.
          }catch (SoapFault $e){
              echo "Ups!! hubo un problema y no pudimos recuperar los datos.<br/>$e<hr/>";
          }  
        
    return $Token;}
    
    public function procesar_DTE($xml_dte,$xml_adicional){
      $Token=$this->autenticar();
         //Desahabilitar cache
      ini_set("soap.wsdl_cache_enabled", "0");
      //Dirección donde se encuentra el servicio
      $client = new SoapClient("http://www.appoctava.cl/ws/WebService.php?wsdl");
      
      
      /*
      ASIGNAFOLIO   = True: ASIGA CORRELATIVO OCTAVA SOFTWARE- False: ASIGNA CORRELATIVO SEGUN NODO <Folio></Folio> EN EL XML DTE.
      TIPO IMPRESO = 1:COPIA ORIGINAL - 2:COPIA CEDIBLE.
      AMBIENTE = 1:PRODUCCIÓN - 0:PRUEBAS
      */
      
      // $Token = TOKEN OBTENIDO POR EL MÉDOTO INICIAL.
      
      $parametros = array("STRINGXML" => $xml_dte,"STRINGXMLADICIONAL" => $xml_adicional,"ASIGNAFOLIO" => "True","TIPOIMPRESO" => "1-2","AMBIENTE" => "1","TOKEN" => $Token);
      
      try{
        //iniciar cliente soap    
        $resultado = $client->__SoapCall("ProcesaDte", $parametros);
        /*$ResultadoFE =$resultado[0]->ResultadoFE;
       
        $IdResultadoFE =$resultado[0]->IdResultadoFE;
        
        return $DescripcionResultado=$resultado[0]->DescripcionResultado;
        //$FolioAsignado =$resultado[0]->FolioAsignado;
        
        $TiempoEjecucion=$resultado[0]->TiempoEjecucion;*/
        $UrlPdf=$resultado[0]->UrlPdf;
        $ResultadoFE =$resultado[0]->ResultadoFE;
      /* echo $DescripcionResultado."<br/>";
        echo $IdResultadoFE."<br/>";
        echo $ResultadoFE."<br/>";
        //echo $FolioAsignado."<br/>";
        echo $UrlPdf."<br/>";*/
        //Si hay algún problema intermedio será atrapado aquí.
      }catch (SoapFault $e){
          echo "Ups!! hubo un problema y no pudimos recuperar los datos.<br/>$e<hr/>";
      }   
      $respuesta=[$UrlPdf,$ResultadoFE];
    return $respuesta;}

    public function mes_actual(){

        switch(date('m')){   
          case 01:
          $mes = "ENERO";
          break;
          case 02:
          $mes= "FEBRERO";
          break;
          case 03:
          $mes = "MARZO";
          break;
          case 04:
          $mes = "ABRIL";
          break;
          case 05:
          $mes = "MAYO";
          break;
          case 06:
          $mes = "JUNIO";
          break;
          case 07:
          $mes = "JULIO";
          break;
          case 8:
          $mes = "AGOSTO";
          break;
          case 9:
          $mes = "SEPTIEMBRE";
          break;
          case 10:
          $mes = "OCTUBRE";
          break;
          case 11:
          $mes = "NOVIEMBRE";
          break;
          case 12:
          $mes = "DICIEMBRE";
          break;
        }
    return $mes;}

    public function calcular_indicador($tipo){
      
      date_default_timezone_set("America/Santiago");
      $fecha_actual = date("Y-m-d");
      $base=ParametrosModulos::where('id',20);
      if($tipo==1){
          $indicador=$base->select('dolar')->value('dolar');
      }
      if($tipo==2){
        $indicador=$base->select('uf')->value('uf');;
      } 
      // se calcula indicador una vez al dia
      if($fecha_actual!=$base->select('parametro')->value('parametro')){ 
       
      try {
        
       
          //Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
         /*
         $apiUrl = 'https://mindicador.cl/api';
         if ( ini_get('allow_url_fopen' )) {
              $json = file_get_contents($apiUrl);
             
          } else {
              //De otra forma utilizamos cURL
              $curl = curl_init($apiUrl);
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              $json = curl_exec($curl);
              curl_close($curl);
          }*/
                $apiUrl = 'https://mindicador.cl/api';
                $curl = curl_init($apiUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($curl);
                curl_close($curl);
                $dailyIndicators = json_decode($json);
               
                if(isset($dailyIndicators->uf->valor)){
                  $contador = ParametrosModulos::find(20);
                  $contador->parametro = $fecha_actual;
                  $contador->dolar = $dailyIndicators->dolar->valor;
                  $contador->uf =  $dailyIndicators->uf->valor;
                  $contador->save();
                  if($tipo==1){
                      $indicador= $dailyIndicators->dolar->valor;
                  }
                  if($tipo==2){
                    $indicador= $dailyIndicators->uf->valor;
                  }
              //$indicador=35271;
                }else{
                    if($tipo==1){
                    $indicador= 801;
                }
                  if($tipo==2){
                    $indicador=30000;
                  } 
                }
        /*  echo 'El valor actual del Dólar observado es $' . $dailyIndicators->dolar->valor;
            echo 'El valor actual del Dólar acuerdo es $' . $dailyIndicators->dolar_intercambio->valor;
            echo 'El valor actual del Euro es $' . $dailyIndicators->euro->valor;
            echo 'El valor actual del IPC es ' . $dailyIndicators->ipc->valor;
            echo 'El valor actual de la UTM es $' . $dailyIndicators->utm->valor;
            echo 'El valor actual del IVP es $' . $dailyIndicators->ivp->valor;
            echo 'El valor actual del Imacec es ' . $dailyIndicators->imacec->valor;
                echo inverso(5) . "\n";
                echo inverso(0) . "\n";*/
      }catch (Exception $e) {
          echo 'No se ecuentra conectado a intenert, ingrese indicadores de forma manual ';
      }
    }
    return $indicador;}
      
    
  
   
     
    /*public function calcular_indicador($tipo){
     
          if($tipo==1){
              $indicador= 816;
          }
          if($tipo==2){
            $indicador=30042;
          }
      return $indicador;
    }*/
    public function cargar_folios(Request $request){
      
      $Token=$this->autenticar();
          //Desahabilitar cache
        ini_set("soap.wsdl_cache_enabled", "0");
        
        //Dirección donde se encuentra el servicio
        $client = new SoapClient("http://www.appoctava.cl/ws/WebService.php?wsdl");
         $url = Storage::url($request->folio);
       $contenido = file_get_contents($request->file('folio')->getPathname());

        /*$p= new Despachos;
        $p->id_contrato=$contenido;
        $p->save();*/
        $stringcaf = '<AUTORIZACION>
          <CAF version="1.0">
            <DA>
              <RE>99999999-9</RE>
              <RS>demo</RS>
              <TD>61</TD>
              <RNG>
                <D>1</D>
                <H>1000</H>
              </RNG>
              <FA>2015-02-03</FA>
              <RSAPK>
                <M>uDa0w829Kpc3mgTipZFM045+74IT86I0CYXJv+qjq4gpocRCsG8gpVA+h4QwXw6KEgzcfQU9sfTyplZT8zHAfQ==</M>
                <E>Aw==</E>
              </RSAPK>
              <IDK>100</IDK>
            </DA>
            <FRMA algoritmo="SHA1withRSA">XaLXfU0CCMc68/5iMQwsz6UxLh6VDLWZCaHIsBVbXDNsMWdzbcIR8IYj9mXP4TsNyw8xS6UuzO+sEMwdlfpHLw==</FRMA>
          </CAF>
          <RSASK>-----BEGIN RSA PRIVATE KEY-----
        MIIBOgIBAAJBALg2tMPNvSqXN5oE4qWRTNOOfu+CE/OiNAmFyb/qo6uIKaHEQrBv
        IKVQPoeEMF8OihIM3H0FPbH08qZWU/MxwH0CAQMCQHrPIy0z03G6JRFYlxkLiI0J
        qfUBYqJsIrED29VHF8eu+Jl3ts5DK8HsSSvEuTwSlf/gN74FFY2Mv82+VDEB+isC
        IQDxSFOAvvI3VQ6zc+Q1GvMVBoBVj9ypMxsAExIKmj8U8QIhAMNzPS+8GCetXx1R
        +OVp/5QLvDNQIPQqhtLepssPb7RNAiEAoNriVdSheji0d6KYI2dMuK8AOQqTG3dn
        VWIMBxF/Y0sCIQCCTNN1KBAac5S+NqXuRqpisn13isCixwSMlG8yCkp4MwIhAM8F
        HtEbN4/3xezHqdpfRdNj782tEfXqb24N0GHiqpgW
        -----END RSA PRIVATE KEY-----
        </RSASK>
          <RSAPUBK>-----BEGIN PUBLIC KEY-----
        MFowDQYJKoZIhvcNAQEBBQADSQAwRgJBALg2tMPNvSqXN5oE4qWRTNOOfu+CE/Oi
        NAmFyb/qo6uIKaHEQrBvIKVQPoeEMF8OihIM3H0FPbH08qZWU/MxwH0CAQM=
        -----END PUBLIC KEY-----
        </RSAPUBK>
        </AUTORIZACION>';
        /*
        STRINGCAF  = STRING DEL XML CAF.
        AMBIENTE = 1:PRODUCCIÓN - 0:PRUEBAS
        */
        
        // $Token = TOKEN OBTENIDO POR EL MÉDOTO INICIAL.
        
        $parametros = array("STRINGCAF" => $contenido,"AMBIENTE" => "1","TOKEN" => $Token);
        
        try{
      //iniciar cliente soap    
      $resultado = $client->__SoapCall("CargaFolio", $parametros);
      
      $DescripcionResultado=$resultado[0]->DescripcionResultado;
      $IdResultadoFE =$resultado[0]->IdResultadoFE;
      $ResultadoFE =$resultado[0]->ResultadoFE;
      $TiempoEjecucion=$resultado[0]->TiempoEjecucion;
      
      $DescripcionResultado."<br/>";
       $IdResultadoFE."<br/>";
       $ResultadoFE."<br/>";
    
      
      //Si hay algún problema intermedios será atrapado aquí.
      }catch (SoapFault $e){
          return "Ups!! hubo un problema y no pudimos recuperar los datos.<br/>$e<hr/>";
      }  
    return $ResultadoFE;}

    public function consultar_recepcion_SII(){
        //Desahabilitar cache
        ini_set("soap.wsdl_cache_enabled", "0");
        //Parametros de entrada

        /*
        FECHAINICIO = FECHA DE INICIO CONSULTA EN FORMATO YYYY-MM-DD
        FECHATERMINO = FECHA DE TÉRMINO CONSULTA EN FORMATO YYYY-MM-DD
        AMBIENTE = 1:PRODUCCIÓN - 0:PRUEBAS
        */
        //$Token = TOKEN OBTENIDO POR EL MÉDOTO INICIAL.
        $Token=$this->autenticar();
        //Establecer parametros de envío Ejemplo:
        $parametros = array("FECHAINICIO" => "2020-06-01","FECHATERMINO" => date('Y-m-d'),"AMBIENTE" => "1","TOKEN" => $Token);
        //Dirección donde se encuentra el servicio
        $client = new SoapClient("http://www.appoctava.cl/ws/WebService.php?wsdl");
        //ObtenerToken
        
        try{
          //iniciar cliente soap    
          $resultado = $client->__SoapCall("ConsultaDtesRecibidos", $parametros);
          $DescripcionResultado=$resultado[0]->DescripcionResultado;
          $IdResultadoFE =$resultado[0]->IdResultadoFE;
          $ResultadoFE =$resultado[0]->ResultadoFE;
          $XmlEmitidos=$resultado[0]->XmlEmitidos;
          // return simplexml_load_string($XmlEmitidos);
          //Si hay algún problema intermedio será atrapado aquí.

          }catch (SoapFault $e){

              echo "Ups!! hubo un problema y no pudimos recuperar los datos.<br/>$e<hr/>";

          } 
           $i=1;
           $recepcio_sii=[];
           $criterio=['>','</'];
           //extraer xml
            foreach( explode('FILA',$XmlEmitidos) as $data){
             //Si la fila es par
             if($i%2==0){
               $folio=str_replace($criterio,"",explode('FOLIODTE', $data)[1]);//TOMAMOS LA POCIICON 1 Y SE ELIMINAN LAS ETIQUETAS DEL NOD0
               $rut_emisor=str_replace($criterio,"",explode('RUTEMISOR', $data)[1]);
               if(Recepcion::where('folio_dte',$folio)->where('rut_emisor',$rut_emisor)->select('folio_dte')->value('folio_dte')==""){
                 //almacenar en db
                    $recepcion=new Recepcion;
                    $recepcion->tipo_dte=str_replace($criterio,"",explode('TIPODTE', $data)[1]);
                    $recepcion->folio_dte=$folio;
                    $recepcion->rut_emisor=$rut_emisor;
                    $recepcion->fecha_emision=str_replace($criterio,"",explode('FECHAEMISION', $data)[1]);
                    $recepcion->neto=str_replace($criterio,"",explode('NETO', $data)[1]);
                    $recepcion->iva=str_replace($criterio,"",explode('IVA', $data)[1]);
                    $recepcion->total=str_replace($criterio,"",explode('TOTAL', $data)[1]);
                    $recepcion->save();
                }

            } 
            $i++;
            }
         // return $recepcio_sii;
    
    }

     public function consultar_mobile(){
     //$direccion_anterior=$_SERVER['HTTP_REFERER'];
      $movil=0;
          $tablet_browser = 0;
              $mobile_browser = 0;
              $body_class = 'desktop';
      
      if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
          $tablet_browser++;
          $body_class = "tablet";
      }
      
      if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
          $mobile_browser++;
          $body_class = "mobile";
      }
      
      if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
          $mobile_browser++;
          $body_class = "mobile";
      }
      
      $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
      $mobile_agents = array(
          'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
          'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
          'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
          'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
          'newt','noki','palm','pana','pant','phil','play','port','prox',
          'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
          'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
          'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
          'wapr','webc','winw','winw','xda ','xda-');
      
      if (in_array($mobile_ua,$mobile_agents)) {
          $mobile_browser++;
      }
      
      if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
          $mobile_browser++;
          //Check for tablets on opera mini alternative headers
          $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
          if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
            $tablet_browser++;
          }
      }
      if ($tablet_browser > 0) {
      // Si es tablet has lo que necesites
         $movil=1;
      }
      else if ($mobile_browser > 0) {
      // Si es dispositivo mobil has lo que necesites
         $movil=1;
      }
      else {
      // Si es ordenador de escritorio has lo que necesites
      }  
      //para el modo firmar documento
      
     
     return $movil;}
    }