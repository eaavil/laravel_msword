<aside class="modal" id="modalOrder" data-bs="modal.order" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <h5>Encargar producto</h5>
            <form id="formImaginex23" action="/form/save/encargar" method="post">
               <div class="form-group">
                  <input type="text" placeholder="nombre_producto" id="nombreproducto" name="nombreproducto" class="form-control" required="">
               </div>
               <div class="form-group">
                  <input type="text" placeholder="sku_producto" id="skuproducto" name="skuproducto" class="form-control" required="">
               </div>
               <div class="form-group"><input type="text" placeholder="enlace_producto" id="enlaceproducto" name="enlaceproducto" class="form-control" required=""></div>
               <div class="form-group"><input type="text" placeholder="Nombre" id="Nombre" name="Nombre" class="form-control" required=""></div>
               <div class="form-group"><input type="email" placeholder="E-mail" id="Email" name="E-mail" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="formato correo usuario@email.com" required=""></div>
               <div class="form-group"><textarea rows="3" name="Mensaje" id="Mensaje" class="form-control" placeholder="Mensaje" required=""></textarea></div>
               <div style="margin-bottom: 1em;"></div>
               <div class="form-group">
                  <button class="btn btn-primary button_form" type="submit" disabled="">Encargar</button>
               </div>
               <input type="hidden" name="g-recaptcha-response"> 
            </form>
            <style>.grecaptcha-badge{visibility:hidden}</style>
            <script>(function () {
               var script = document.createElement('script');
               
               var form = document.getElementById('formImaginex23');
               
               const URL_CONFIG_RECAPTCHA = 'https://www.google.com/recaptcha/api.js?render=6LdteuQUAAAAAGWuEEzND0N3Hw0ZDTsLkDz1bHqp';
               
               let verify = false;
               
               function loadFormData() {
                 var recaptcha = form.querySelector('[name="g-recaptcha-response"]');
                 form.querySelector('button[type="submit"]').removeAttribute('disabled');
                 form.onsubmit = function (e) {
                   e.preventDefault();
                   if (!recaptcha.value) grecaptcha.execute('6LdteuQUAAAAAGWuEEzND0N3Hw0ZDTsLkDz1bHqp', { action: 'form' }).then(function (token) {
                     recaptcha.value = token;
                     form.submit();
                   })
                 }
               }
               
               function loadFormClick23() {
                   if(verify === false) {
                     const scripts = Array.from(document.head.querySelectorAll('script'));
                     let loadSrc = scripts.find(s => s.src === URL_CONFIG_RECAPTCHA) || null;
               
                     if(loadSrc !== null){
                       loadFormData();
                     } else {
                       script.src = URL_CONFIG_RECAPTCHA;
                       script.onload = function () {
                         loadFormData();
                       };
                       document.head.appendChild(script);
                       console.log(script);
                     }
               
                     verify = true;
                   }
                 }
               
               form.addEventListener('click', loadFormClick23);
               
               })()
            </script>
         </div>
      </div>
   </div>
</aside>
