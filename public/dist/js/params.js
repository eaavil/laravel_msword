var timeInit = null;
var timeEnd = null;
var buscadorFechas = false;

var configDatepicker = {
    "format": "DD/MM/YYYY",
    "separator": " al ",
    "applyLabel": "Aplicar",
    "cancelLabel": "Cancelar",
    "fromLabel": "De",
    "toLabel": "Hasta",
    "customRangeLabel": "Custom",
    "daysOfWeek": ["Dom","Lun","Mar","Mie","Jue","Vie","Sab"],
    "monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
    "firstDay": 0
};

var langDataTable = {
    "decimal": "",
    "emptyTable": "No hay información",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
    "infoFiltered": "(Filtrado de _MAX_ total registros)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar _MENU_ Registros",
    "loadingRecords": '<br><br><br><br><br><br><br><br><br><br>',
    "processing": '<i clasS="fa fa-sync fa-spin"></i> &nbsp;&nbsp;Obteniendo Datos',
    "search": "Buscar:",
    "zeroRecords": "Sin resultados encontrados",
    "paginate": {
        "first": "Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    buttons: {
        copyTitle: 'Copiado al Portapapeles',
        copySuccess: {
            _: 'Se Copiaron %d Registros to Portapapeles',
        }
    }
};

