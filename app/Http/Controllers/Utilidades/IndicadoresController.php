<?php

namespace App\Http\Controllers\Utilidades;

use App\Http\Controllers\Controller;
use KubAT\PhpSimple\HtmlDomParser;
use Illuminate\Http\Request;

class IndicadoresController extends Controller
{
    public function comprobar_valores_economicos(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_URL, 'https://dolar.wilkinsonpc.com.co/widgets/gratis/indicadores-economicos-max.html');
        $html=curl_exec($curl);
        $dom = HtmlDomParser::str_get_html($html);
        $tabla = $dom->find('.tabla-indicadores_ind_todos',0);

        $registros = $tabla->find('tr td[align="right"]');
        $x=0;
        foreach($registros as $index => $info){
                if($x!=10){
                    $data[$x]['valor']=$info->children(0)->plaintext;
                    $data[$x]['tipo']=$info->children(0)->class;
                }
                $x++;
        }
        
        $registros = $tabla->find('tr td a');
        $x=0;
        foreach($registros as $index => $info){
                if($x!=10){
                    $data[$x]['titulo']=$info->plaintext;
                }
                $x++;
        }

        $data[3]['valor']=$data[3]['valor'].'<br>COP$'.round(str_replace(',','',substr($data[0]['valor'],2))*substr($data[3]['valor'],3),2);

        return array('data'=>$data);
    }
}
