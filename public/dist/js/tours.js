// Instance the tour
var tourPrincipal = new Tour({
    smartPlacement: true,
    keyboard: true,
    debug: true,
    storage: window.localStorage,
    backdrop: true,
    basePath: "",
    template: " <div class='popover tour'> \
                    <div class='arrow'></div> \
                    <h3 class='popover-title'></h3> \
                    <div class='popover-content'></div> \
                    <div class='popover-navigation'> \
                        <button class='btn btn-info' data-role='prev'><i class='fa fa-chevron-left'></i></button> \
                        <span data-role='separator'>|</span> \
                        <button class='btn btn-info' data-role='next'><i class='fa fa-chevron-right'></i></button> \
                        <button class='btn btn-success' data-role='end'>Terminar Tutorial</button> \
                    </div> \
                </div>",
    steps: [
        {
            element: "#notifications",
            title: "Notificaciones",
            content: "Aqui Recibira cualquier informacion relevante, solo pulse el icono de la campana",
            placement:'left',
        },
        {
            element: "#logout",
            title: "Salir del Sistema",
            content: "Aqui puede cerrar en cualquier momento su sesion",
            placement:'left',
        }
    ]
});