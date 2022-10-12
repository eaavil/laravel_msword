@extends('template.main')
@section('contenedor_principal')


<div class="ordenes">
    <table id="2" width="130%"  class="origen texto4" border=1 cellspacing="0" cellpadding="0"  >
         <thead >
            <tr border="1"  >
               <th width="40%" ><h4><STRONG>OT</STRONG></h4> </th>
               <th><h4><STRONG>ACCIONES</STRONG></h4> </th>
            </tr>
         </thead>
         <tbody  >
             @foreach($ordenes as $rows)
                <tr>
                  <td width="30%"> <h4>{{$rows->id}}-{{date('d/m',strtotime($rows->created_at))}}</h4> </td>
                  <td>	
                  
                  <a role="button" class="mostrar_listas" onclick="mostrar_listas({{$rows->id}})" ><i  style='font-size:35px;color:white' class="fas fa-list-alt"></i></a>
                  <a role="button" href="{{asset('editar_orden/'.$rows->id)}}"><i  style='font-size:35px;color:white' class="fas fa-pencil-alt"></i></a>
                  <a role="button" href="{{asset('eliminar/orden/'.$rows->id)}}"><i  style='font-size:35px;color:white' class="fas fa-trash-alt"></i></a>
                  <a role="button" class="print" data-id="{{$rows->id}}"><i  style='font-size:35px;color:white' class="fas fa-print"></i></a>
                  
                      
                   </td>
                </tr>
            @endforeach
               
                
         </tbody>
    </table>
</div>
<div class="seleccionar_listas" style="display:none">
  @foreach($ordenes as $rows){  
     
    <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
   }
     @endforeach
</div>
<script>




function mostrar_listas(id) {
    $('.ordenes').css('display','none');
    $('.seleccionar_listas').css('display','block');
    //mostrar solo primerra lista
      
}

 $(document).on('click','.print',function(){
        var id= $(this).attr('data-id');
        window.open('{{ asset("imprimir_orden") }}/'+id);
    });
</script>
<style>
       ::placeholder {
  	color: White;
	font-weight: bold;
	font-size: 1.5em;
}
.letra_cursiva{
	font-family: garamond; 
	src: url('garamond-italic.ttf'); 
	font-style: italic;
 
}

 .estilotextarea {
	 width:280px;
	 height:300px;
	 background-color:black;
 }
 
 

   .texto{
     border-style:outset;
     font-size: 15pt; 
     color:white; 
     font-weight:bolder;
     height:40px; 
     width:280px;
     background-color:black;
 }
 
 .texto4{    
     color:white; 
     background-color:black;
     text-align: center;
     font-size:15pt;
     /*-webkit-text-stroke: 1px white; PARA CAMBIAR EL ESILO DE LETRA */
    
    
 }
 
 .texto3{    
    border-style:outset;
     font-size: 18pt; 
     color:red; 
     font-weight:bolder;
     height:40px; 
     width:280px;
    }
   </style>
   

   
@stop





