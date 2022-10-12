<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Registrar persona</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
            <form action="{{ route('catalogo.registrar.clientes') }}" method="post" class="frm_0001" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <label>Razon Social</label>
                        <input type="text" style="text-transform:uppercase" name="c01" required autocomplete="name-in" class="form-control">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="row">
                        <div class="col-6">
                           <div class="form-group">
                              <label>Nit/cedula</label>
                              <div class="row">
                                 <div class="col-12" style="padding:0; padding-left:8px">
                                    <input type="text"  name="c02"  class="form-control" maxlength="10" style="width:95%">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="form-group">
                              <label>Telefono:</label>
                              <input type="text" name="c06" autocomplete="phone-in" class="form-control" maxlength="10">
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Representante:</label>
                        <input type="text" name="c17" style="text-transform:uppercase" autocomplete="dir1-in" class="form-control" readonly>
                     </div>
                     <div class="form-group">
                        <label>Entidad Financiera</label>
                        <select class="form-control combo" name="c09"  style="width: 100%;" disabled>
                           @foreach($bancos as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->entidad }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="c07" autocomplete="email-in" style="text-transform:uppercase" class="form-control email"  >
                     </div>
                  </div>
                  <div class="col-6">
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Tipo de Regimen</label>
                            <select class="form-control combo" name="c08"  style="width: 100%;" disabled>
                            @foreach($regimen as $rows)
                            <option value="{{ $rows->id }}">{{ $rows->tipo_regimen }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                              <label>Giro:</label>
                              <input type="text" name="giro"  class="form-control" style="text-transform:uppercase" readonly>
                           </div>
                    </div>
                     
                     <div class="row">
                        <div class="col-6">
                           <div class="form-group">
                              <label>Direccion:</label>
                              <input type="text" name="c04" style="text-transform:uppercase"   class="form-control">
                           </div>
                        </div>
                        <div class="form-group col-6">
                           <label>Ciudad:</label>
                           <input type="text" name="c05" style="text-transform:uppercase"  class="form-control" >

                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-6">
                            <label>Numero de Cuenta:</label>
                            <input type="text" name="c10"   class="form-control onumbers "  maxlength="15" disabled>
                        </div>
                        <div class="form-group col-6">
                            <label>Comuna:</label>
                            <input type="text" name="comuna" style="text-transform:uppercase"  class="form-control " maxlength="15" >
                        </div>
                     </div>
                     <div class="form-group ">
                        <label>Tipo de Cuenta</label>
                        <select class="form-control combo " required name="c11"  style="width: 100%;" disabled>
                          <option value="0">N/A</option>
                           <option value="6">CORRIENTE</option>
                           <option value="2">AHORROS</option>
                        </select>
                     </div>
                  </div>
               </div>
               <h4>Caracteristicas Adicionales</h4>
               <br>
               <div class="row">
                  <div class="col-3">
                     <div class="form-check form-check-inline">
                        <label class="form-check-label">
                        <input class="form-check-input" name="c12" type="checkbox"> Cliente
                        </label>
                     </div>
                  </div>
                  <div class="col-3">
                     <div class="form-check form-check-inline">
                        <label class="form-check-label">
                        <input class="form-check-input" name="c13" type="checkbox"> Empleado
                        </label>
                     </div>
                  </div>
                  <div class="col-3">
                     <div class="form-check form-check-inline">
                        <label class="form-check-label">
                        <input class="form-check-input" name="c14" type="checkbox"> Proveedor
                        </label>
                     </div>
                  </div>
                  <div class="col-3">
                     <div class="form-check form-check-inline">
                        <label class="form-check-label">
                        <input class="form-check-input" name="c15" type="checkbox"> Tercero
                        </label>
                     </div>
                  </div>
                 
               </div>
               <hr/>
               <div class="row">
               <div class="col-6">
					   <div class="form-group">
					   <li><a href="#" class="ver" num="hoja_de_vida" >Hoja de vida (.PDF)</a></li>
						  <input type="file" name="c03" class="form-control" accept="application/pdf"  multiple>
					   </div>
					</div> 
               
					<div class="col-6">
					   <div class="form-group">
					   <li ><a href="#" class="ver" num="firma" >Firma en imagen (.jpg o .png)</a></li>
						  <input type="file" name="c04"  class="form-control" accept="image/*"  multiple>
					   </div>
					</div>
               </div>
               <button style="display:none" class="act_form"></button>
            </form>
         </div>
         <div class="modal-footer justify-content-between">
            <span class="btn btn-block btn-primary trigger_formx" target="frm_0001">Procesar Registro</span>
         </div>
      </div>
   </div>
</div>