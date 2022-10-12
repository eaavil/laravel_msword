<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Registrar persona</h4>
            <button type="button" enctype="multipart/form-data" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body container-fluid">
            <form action="{{ route('registrar_editar.empresa') }}" method="post" class="frm_0001">
               {{ csrf_field() }}
               <div class="row  form-group">
                  
                        <label>Nombre completo/Razon Social</label>
                        <input type="text" style="text-transform:uppercase" name="c01" required autocomplete="name-in" class="c01 form-control">
                     
               </div>
                 <div class="row  form-group">
                  
                        <label>Representante</label>
                        <input type="text" style="text-transform:uppercase" name="rep" required autocomplete="name-in" class="rep form-control">
                     
               </div>
               <div class="row">
                  <div class="col-3 form-group">
                              <label>Rut</label>
                                    <input type="text"  name="c02"  class="c02 form-control"  style="width:95%" required>
            
                  </div>
                       <div class="col-3 form-group">
                         
                              <label>Telefono</label>
                              <input type="text" name="c06"  class="c06 form-control" >
                        
                        </div>
                        <div class="form-group col-3">
                           <label>Ciudad</label>
                           <input type="text" name="c05" style="text-transform:uppercase" required  class="c05 form-control" >
                       </div>
                       <div class="form-group col-3">
                            <label>Comuna</label>
                            <input type="text" name="comuna" style="text-transform:uppercase"  class="comuna form-control " >
                        </div>
               </div>
               <div class="row">
                        <div class="col-6 form-group">
                          
                              <label>Direccion</label>
                              <input type="text" name="c04" style="text-transform:uppercase"  required  class="c04 form-control">
                        </div>
                        <div class=" col-6  form-group">
                           <label>Correo</label>
                           <input type="email" name="c07" autocomplete="email-in" style="text-transform:uppercase" class="c07 form-control email" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                      </div>
               </div>
               <hr>
               <h4>Caracteristicas Adicionales</h4>
               <br>
               <div class="row">
                  <div class="col-3">
                     <div class="form-check form-check-inline">
                        <label class="form-check-label">
                        <input class="form-check-input check_cliente c12" name="es_cliente" type="checkbox"> Cliente
                        </label>
                     </div>
                  </div>
                  <div class="col-3">
                     <div class="form-check form-check-inline">
                        <label class="form-check-label">
                        <input class="form-check-input c13" name="es_empleado" type="checkbox"> Empleado
                        </label>
                     </div>
                  </div>
                  <div class="col-3">
                     <div class="form-check form-check-inline">
                        <label class="form-check-label">
                        <input class="form-check-input check_proveedor c14" name="es_proveedor" type="checkbox"> Proveedor
                        </label>
                     </div>
                  </div>
                  <div class="col-3">
                     <div class="form-check form-check-inline">
                        <label class="form-check-label">
                        <input class="form-check-input c15" name="es_tecnico" type="checkbox"> Tecnico
                        </label>
                     </div>
                  </div>
               </div>
               <br>
                <div class="row" >

                    <div class="form-group col-6 proveedor" style="display:none">
                        <label>Representante</label>
                        <input type="text" name="c17" style="text-transform:uppercase" autocomplete="dir1-in" class="c17 form-control">
                     </div>
                     <div class="form-group  col-6 proveedor" style="display:none">
                        <label>Entidad Financiera</label>
                        <select class="form-control combo c09 " name="c09"  style="width: 100%;">
                           @foreach($bancos as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->entidad }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
               <div class="row " >
                       <div class="form-group col-6 proveedor " style="display:none">
                            <label>Numero de Cuenta</label>
                            <input type="text" name="c10"   class="form-control onumbers c10"   >
                        </div>
                     <div class="form-group col-6 proveedor" style="display:none">
                        <label>Tipo de Cuenta</label>
                        <select class="form-control combo c11 " name="c11"  style="width: 100%;" style="display:none">
                          <option value="0">N/A</option>
                           <option value="6">CORRIENTE</option>
                           <option value="2">AHORROS</option>
                        </select>
                     </div>

               </div>
               <hr/>
               <div class="row">
               <div class="col-6">
					   <div class="form-group">
					   <li><a href="#" class="ver" num="3" >Hoja de vida(.PDF)</a></li>
						  <input type="file"  class="form-control" accept="application/pdf"  multiple>
					   </div>
					</div> 
               
					<div class="col-6">
					   <div class="form-group">
					   <li ><a href="#" class="ver" num="4" >Firma en imagen(.jpg o .png)</a></li>
						  <input type="file"  class="form-control" accept="image/*"  multiple>
					   </div>
					</div>
            
               </div>
               <input type="hidden" class="id" name="id"  value=""/>
               <button style="display:none" class="act_form"></button>
            </form>
         </div>
         
         <div class="modal-footer justify-content-between">
            <span class="btn btn-block btn-primary trigger_formx" target="frm_0001">Guardar persona</span>
         </div>
      </div>
   </div>
</div>