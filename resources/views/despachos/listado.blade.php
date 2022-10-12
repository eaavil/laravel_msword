
@extends('template.main')

@section('contenedor_principal')
@include('despachos.modals.detalle_despacho')
@include('despachos.modals.reporte_entradas')

<div class="col-12">
    
	          <div class="row">
					<div class="col-2 mx-3">
					   <div class="form-group">
						  <label>Fecha Inicial</label>
						  <input type="date"   class="fi form-control">
					   </div>
					</div>
					<div class="col-2">
					   <div class="form-group">
						  <label>Fecha Final</label>
						  <input type="date"  class="ff form-control">
					   </div>
					</div>
					<div class="col-2 pt-2 ">
                        <br>
                        <button class=" consultar btn btn-primary">Consultar</button>
                    </div>
					<div  class="col-2" >
				    </div>
					<div  class="col-3" >
						<span style="float:left"><label>Cliente:</label><br>
							<select class="form-control combo prov">
								<option value="-1">Todos</option>
								@foreach($clientes as $rows)
									<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
								@endforeach
							</select>
					   </span>
				    </div>
					
			  </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fa fa-file"></i> Reportes</button>
			  <table id="main" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
				  <th>Despacho</th>
				  <th>Salida</th>
				  <th>Cliente</th>
				  <th>Fecha</th>
                  <th>Kilogramos</th>
				  <th>Factor %</th>
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
  
@stop

@section('scripts-bottom')
    <script>
          var con_tentativo=0;

		/***********************/
		/*   MODAL REGISTRO    */
		/***********************/
        $('.trigger_form_esp_entrada').click(function(){
            let id = $(this).attr('target');
			if($('.definitivo').val()==0&&con_tentativo>0){
				alert('debe agregar un factor');
                
			}else{
				$('.'+id+' > .act_form').trigger('click');
			
			}
           
        })
		$('.prov').change(function(){
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
			let id = $('option:selected',this).val();
			if(id!=-1){
				tabla.ajax.url('{{ asset("despachos/listado/data") }}?id_prov='+id).load();
			}else{
				tabla.ajax.url('{{ asset("despachos/listado/data") }}').load();
			}
            if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("despachos.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}
            tabla.draw();
		})
		$(document).on('click',".revision",function (evt) {
			
           
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
			
			$.get('{{ asset("") }}/despachos/detalle/'+id,function(data){
				$('.detalle_despacho').html('');
				$.each(data,function(i,v){
					let html2 = '';
					if(v.definitivo==1){
						html2 = '<input class="definitivo" style="width:100%" type="number"  name="factor[]" step="0.01" value="'+v.factorx+'"  aria-required="true"/></td><td><input type="hidden" name="pendiente['+v.idx+']" value="0" required /><input type="checkbox" name="pendiente['+v.idx+']" value="1" required /></td>';
						con_tentativo++;
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

		$(document).on('click',".culminar",function (evt) {
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
			$('.idx').val(0);
			
			$.get('{{ asset("") }}/despachos/detalle/'+id,function(data){
				$('.detalle_despacho').html('');
				$.each(data,function(i,v){
					let html = `
					<tr>
						<td>`+v.numero_ticket+`</td>
						<td>`+v.nombre+`</td>
						<td>`+v.kilogramos+`<input style="display:none" value="`+v.kilogramos+`" name="kilos[]" type="number" /></td>
						<td>`+v.factor+`<input  style="display:none" name="factor[]" readonly value="`+v.factor+`" type="number" /></td>
						<td>n/a</td>
						<td>`+v.valor+`</td>
					</tr>`;
					$('.detalle_despacho').append(html);
				})
			})
		});


		$(document).on('change',"[type='number']",function (evt) {
			var max = parseInt($(this).attr('max'));
			var min = parseInt($(this).attr('min'));
			if ($(this).val() > max)
			{
				$(this).val(max);
			}
			else if ($(this).val() < min)
			{
				$(this).val(min);
			}
			totalizar_despacho()
		});

		function totalizar_despacho(){
			let t1 = $('.dt3');
			let t2 = $('.dt2');
			let total1 = 0;
			let total2 = 0;
			let total3 = 0;
			$.each($('.tabla_detalle_despacho tbody tr'),function(i,v){
				console.log(parseInt($(this).find('input[name="kilos[]"]').val()));
				total1+= parseInt($(this).find('input[name="kilos[]"]').val());
			})
			$.each($('.tabla_detalle_despacho tbody tr'),function(i,v){
				var temp = (parseInt($(this).find('input[name="kilos[]"]').val())/total1)*parseFloat($(this).find('input[name="factor[]"]').val()).toFixed(2);
				console.log(temp);
				$(this).find('input[name="resultado[]"]').val(((temp * 100) / 100).toFixed(2))
				total2+= temp;
			})

			t1.html(total1);
             
			t2.val(((total2 * 100) / 100).toFixed(2));
		}

		/******************/
		/*   DATATABLE    */
		/******************/
		var tabla = $('#main').DataTable({
			serverSide:true,
            paging: true,
			pageLength: 20,
            ajax: {
                url: '{{ asset("despachos/listado/data") }}',
                dataSrc: 'data',
				type:'post'
            },
            columns: [
				{
					"data": null,name:'numero',
					"render": function (data) {
						if(data.pendiente==1){
							return '<h6>'+data.numero+' <i class="fa fa-exclamation-triangle" title="debe revisar el detalle del despacho para realizar ajustes"></i></h6>';
						}else{
							return '<h6>'+data.numero+' <i class="fa fa-check" title="lista para despacho"></i></h6>';
						}

					}
				},
				{
					"data": null,name:'003_entradas_salidas_cafe.numero_ticket',
					"render": function (data) {
						return '<h6>'+data.numero_ticket+'</h6>';
					}
				},
				{
					"data": null,name:"000_catalogo_empresas.nombre",
					"render": function (data) {
						return data.nombre;
					}
				},
				{
					"data": null,name:"fecha",
					"render": function (data) {
						return data.fecha.substring(8,10)+'/'+data.fecha.substring(5,7)+'/'+data.fecha.substring(0,4);
					}
				},
				{
					"data": null,name:"kilogramos",
					"render": function (data) {
						return number_format(data.kilogramos,0,',','.');
					}
				},
				{
					"data": null,name:"factor_promedio",
					"render": function (data) {
						return data.factor_promedio;
					}
				},
                {
                    data: null,name:"pendiente",
                    render: function (data){
						if(data.pendiente==1){
							return `
								<button type="button" class="btn btn-primary revision" data-title="`+data.numero_ticket+`" data-salida="`+data.numero+`" data-weight="`+data.kilogramos+`" data-valor="`+data.valor_despacho+`" data-porcentaje="`+data.factor_promedio+`" data-promedio="`+data.factor_promedio_referencia+`" data-weight="`+data.kilogramos+`" data-id="`+data.idx+`" data-toggle="modal" data-target="#modal-lg-despacho"><i class="fa fa-edit" aria-hidden="true"></i> Revisar</button> 
								<button type="button" class="btn btn-danger delete" data-id="`+data.idx+`" ><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
							`;
						}else 
						if(data.pendiente==2){
							return'';
						}else{
							return `
								<button type="button" class="btn btn-success culminar" data-title="`+data.numero_ticket+`" data-salida="`+data.numero+`" data-weight="`+data.kilogramos+`" data-valor="`+data.valor_despacho+`" data-porcentaje="`+data.factor_promedio+`" data-promedio="`+data.factor_promedio_referencia+`" data-id="`+data.idx+`" data-toggle="modal" data-target="#modal-lg-despacho"><i class="fa fa-check" aria-hidden="true"></i> Finalizar</button> <button type="button" class="btn btn-danger delete" data-id="`+data.idx+`" ><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
							`;
						}

                    }
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
            let id=$('.prov option:selected').val();
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("despachos.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}else{
				alert('Ingrese fechas');
			}
		});


    </script>
@stop
