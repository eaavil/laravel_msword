@extends('template.main')
@section('contenedor_principal')
@include('despachos.modals.detalle_despacho')
<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
			<div class="form-group col-2">
                        <label>Fecha Inicial</label>
                        <input type="date"   class="fi form-control">
             </div>
            <div class="form-group col-2">
                <label>Fecha Final</label>
                <input type="date"  class="ff form-control">
            </div>
            <div class=" pt-2 ">
            <br>
                <button class=" consultar btn btn-primary">Consultar</button>
            </div>
		    
            </div>
           
            <table id="main" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
				  <th>Despacho</th>
				  <th>Salida</th>
				  <th>Fecha</th>
                  <th>Kilogramos</th>
				  <th>Factor %</th>
                  <th>Factor despacho</th>
                  <th>Factor liquidacion</th>
                  <th>Diferencia Factor</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
		  <button type="button" class="despacho despacho-trigger" style="display:none" data-title="" data-weight="" ="" data-toggle="modal" data-target="#modal-lg"></button>
    </div>
@stop

@section('scripts-bottom')
    <script>
      function c(a)
    {
        a.checked='checked';
    }
         $(document).on('click',".revision",function (evt) {
            $('.trigger_form_esp_entrada').hide();
            let id = $(this).attr('data-id');
            let despachox = $(this).attr('data-title');
            let salidax = $(this).attr('data-salida');
            $('.titulo_despacho').html(salidax+' de Salida '+despachox);
            let kilogramos = $(this).attr('data-weight');
            let porcentaje = $(this).attr('data-porcentaje');
            let valor = $(this).attr('data-valor');
            let promedio = $(this).attr('data-promedio');
            $('.dt1').html(kilogramos);
            $('.dt2').val(porcentaje);
            $('.dt3').html(valor);
            $('.dt4').val(promedio);
            $('.id').val(id);
            $('.idx').val(1);
            $('.dt4').prop('readonly', true)
            $.get('{{ asset("") }}/despachos/detalle/'+id,function(data){
                $('.detalle_despacho').html('');
                $.each(data,function(i,v){
                    let html2 = '';
                    console.log(v.definitivo)
                    if(v.definitivo==1){
                        html2 = '<input style="width:100%" readonly type="number" required name="factor[]" step="0.01" value="'+v.factorx+'"/></td><td><input type="hidden" name="pendiente['+v.idx+']" value="0" /><input onchange="c(this)" onclick="c(this)" checked="checked" type="checkbox" name="pendiente['+v.idx+']" value="1" /></td>';
                    }else{
                        html2 = '<input style="width:100%; border:none" name="factor[]" readonly value="'+v.factorx+'" type="number" /></td><td><input type="hidden" name="pendiente['+v.idx+']" value="0" /></td>';
                    }
                    
                    let html = `
                    <tr>
                        <td><input type="hidden" name="id[]" value="`+v.idx+`">`+v.numero_ticket+`</td>
                        <td>`+v.nombre+`</td>
                        <td><input style="width:100%; border:none; text-align:center" readonly value="`+v.kilogramos+`" name="kilos[]" type="number" /></td>
                        <td>`+html2+`</td>
                        <td><input style="width:100%; border:none; text-align:center" readonly value="`+v.valor+`" name="resultado[]" type="number" /></td>
                    </tr>`;
                    $('.detalle_despacho').append(html);
                })

        });
        });
        
        
        $(document).on('click','.delete',function(){
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas eliminar el despacho seleccionado?')){
                    var id= $(this).attr('data-id');
                    window.location='{{ asset("despachos/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });
		/******************/
		/*   DATATABLE    */
		/******************/
		var tabla = $('#main').DataTable({
			serverSide:true,
            paging: true,
			pageLength: 20,
            ajax: {
                url: '{{ asset("/despachos/culminados/data") }}',
                dataSrc: 'data',
				type:'post',
            },
            columns: [
				{
					"data": null,name:'numero',
					"render": function (data) {
						if(data.definitivo==1){
							return '<h6>'+data.numero+' <i class="fa fa-exclamation-triangle" title="debe revisar el detalle del despacho para realizar ajustes"></i></h6>';
						}else{
							return '<h6>'+data.numero+' <i class="fa fa-check" title="lista para despacho"></i></h6>';
						}

					}
				},
				{
					"data": null,name:'numero_ticket',
					"render": function (data) {
						return '<h6>'+data.numero_ticket+'</h6>';
					}
				},
				{
					"data": null,name:'fecha',
					"render": function (data) {
						return data.fecha.substring(8,10)+'/'+data.fecha.substring(5,7)+'/'+data.fecha.substring(0,4);
					}
				},
				{
					"data": null,name:'kilogramos',
					"render": function (data) {
						return number_format(data.kilogramos,0,',','.');
					}
				},
				{
					"data": null,name:'factor_promedio',
					"render": function (data) {
						return data.factor_promedio;
					}
				},
                {
					"data": null,name:'factor_promedio_referencia',
					"render": function (data) {
						return data.factor_promedio_referencia;
					}
				},
                {
					"data": null,name:'factor_liquidacion',
					"render": function (data) {
						return data.factor_liquidacion+data.descuento_factor;
					}
				},
				{
					"data": null,name:'valor_despacho',
					"render": function (data) {
						return number_format(data.factor_promedio-(data.factor_liquidacion+data.descuento_factor),2,',','.');
					}
				},
                {
                  data:null,name:'003_despachos.id',
                    render: function (data){
                        return `
                        <button type="button" class="btn btn-primary revision" data-title="`+data.numero_ticket+`" data-salida="`+data.numero+`" data-weight="`+data.kilogramos+`" data-valor="`+data.valor_despacho+`" data-porcentaje="`+data.factor_promedio+`" data-promedio="`+data.factor_promedio_referencia+`" data-weight="`+data.kilogramos+`" data-id="`+data.idx+`" data-toggle="modal" data-target="#modal-lg-despacho"><i class="fa fa-edit" aria-hidden="true"></i> Revisar</button> 
                        <button type="button" class="btn btn-danger delete float-right mr-3" data-id="`+data.idx+`" ><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
						`;

                        }
                        
                        
                        /*if(data.pendiente==1){
                            
                        return 
                        `<button type="button" class="btn btn-primary revision verde" data-title="`+data.numero_ticket+`" data-salida="`+data.numero+`" data-weight="`+data.kilogramos+`" data-valor="`+data.valor_despacho+`" data-porcentaje="`+data.factor_promedio+`" data-promedio="`+data.factor_promedio_referencia+`" data-weight="`+data.kilogramos+`" data-id="`+data.idx+`" data-toggle="modal" data-target="#modal-lg-despacho"><i class="fa fa-edit" aria-hidden="true"></i> Revisar</button> 
                        <button type="button" class="btn btn-danger delete float-right mr-3" data-id="`+data.idx+`" ><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
							`;
							
						}else{
                            return 
                        `<button type="button" class="btn btn-primary revision" data-title="`+data.numero_ticket+`" data-salida="`+data.numero+`" data-weight="`+data.kilogramos+`" data-valor="`+data.valor_despacho+`" data-porcentaje="`+data.factor_promedio+`" data-promedio="`+data.factor_promedio_referencia+`" data-weight="`+data.kilogramos+`" data-id="`+data.idx+`" data-toggle="modal" data-target="#modal-lg-despacho"><i class="fa fa-edit" aria-hidden="true"></i> Revisar</button> 
                        <button type="button" class="btn btn-danger delete float-right mr-3" data-id="`+data.idx+`" ><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
							`;
						} */
                        
                   
                }
            ],
            drawCallback: function(settings, json) {
				$('.fa-exclamation-triangle').parent().parent().parent().css('background','#f5df74');
				$('.fa-check').parent().parent().parent().css('background','#bcf5bc');
			},
            language: langDataTable,
        });
        $(document).on('click','.consultar',function(){ 
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
            //let id=$('.prov option:selected').val();
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("despachos.culminados.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov=0').load();
                
			}else{
				alert('Ingrese fechas');
			}
		});
     </script>
@stop
