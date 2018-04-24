// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
      
      "columnDefs": [
        { "width": "60%", "targets": 0 },
        { "width": "12%", "targets": 4 },
        { "width": "5%", "targets": 3 }
      ],

        "language": {
            "lengthMenu": "Mostrar _MENU_ filas por pagina",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontraron resultados",
            "search": "Buscar",
            "paginate": { 
              "search": "Buscar",
              "first": "Primero",
              "last": "Ultimo",
              "next": "Siguiente",
              "previous": "Anterior"
            },
            "infoFiltered": "(filtrado de _MAX_ registros totales)"
        }
  });

  $("#sidenavToggler").trigger("click"); // oculta automaticamente el sidebar

});
