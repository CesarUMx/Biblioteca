let tblUsuarios, tblEst, tblMateria, tblLibros, tblPrestar;
document.addEventListener("DOMContentLoaded", function () {
  const language = {
    decimal: "",
    emptyTable: "No hay información",
    info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
    infoFiltered: "(Filtrado de _MAX_ total entradas)",
    infoPostFix: "",
    thousands: ",",
    lengthMenu: "Mostrar _MENU_ Entradas",
    loadingRecords: "Cargando...",
    processing: "Procesando...",
    search: "Buscar:",
    zeroRecords: "Sin resultados encontrados",
    paginate: {
      first: "Primero",
      last: "Ultimo",
      next: "Siguiente",
      previous: "Anterior",
    },
  };
  const buttons = [
    {
      //Botón para Excel
      extend: "excel",
      footer: true,
      title: "Archivo",
      filename: "Export_File",

      //Aquí es donde generas el botón personalizado
      text: '<button class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>',
    },
    //Botón para PDF
    {
      extend: "pdf",
      footer: true,
      title: "Archivo PDF",
      filename: "reporte",
      text: '<button class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></button>',
      orientation: "landscape", // Cambiar a orientación horizontal
      pageSize: "LETTER", // Configurar tamaño de página
      customize: function (doc) {
        doc.defaultStyle.fontSize = 10; // Ajusta el tamaño de fuente
        doc.styles.tableHeader.fontSize = 12; // Tamaño de fuente para encabezados
        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('auto'); // Ajustar ancho automático de columnas
      },
    },
    //Botón para print
    {
      extend: "print",
      footer: true,
      title: "Reportes",
      filename: "Export_File_print",
      text: '<button class="btn btn-info"><i class="fa fa-print"></i></button>',
    },
  ];

  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: base_url + "Usuarios/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "usuario" },
      { data: "nombre" },
      { data: "puesto" },
      { data: "estado" },
      { data: "acciones" },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
  });
  //Fin de la tabla usuarios
  tblEst = $("#tblEst").DataTable({
    ajax: {
      url: base_url + "Estudiantes/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "matricula" },
      {
        data: "matricula",
        render: function (data, type, row) {
          return data + "@mondragonmexico.edu.mx";
        },
      },
      { data: "nombre" },
      { data: "modalidad" },
      { data: "carrera" },
      { data: "semestre" },
      { data: "telefono" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
  });
  //Fin de la tabla Estudiantes
  tblMateria = $("#tblMateria").DataTable({
    ajax: {
      url: base_url + "Materia/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id", },
      { data: "materia", },
      { data: "estado", },
      { data: "acciones", },
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
  });
  //Fin de la tabla Materias
  tblLibros = $("#tblLibros").DataTable({
    ajax: {
      url: base_url + "Libros/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id", visible: false, },
      { data: "clave", },
      { data: "clasificacion", },
      { data: "isbn", visible: false, },
      { data: "titulo", },
      { data: "autores", },
      { data: "editorial", },
      { data: "anio_edicion", },
      { data: "num_pagina", visible: false, },
      { data: "adquisicion", visible: false, },
      { data: "materia", },
      { data: "descripcion", },
      { data: "estado", },
      { data: "acciones", },
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
  });
  //fin Libros

  tblMultas = $("#tblMultas").DataTable({
    ajax: {
      url: base_url + "Multas/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id", visible: false },
      { data: "matricula", },
      { data: "nomenclatura", visible: false },
      { data: "nombre", },
      { data: "clave", },
      { data: "titulo", },
      { data: "dias", },
      { data: "c_multa", },
      { data: "fecha_devolucion", visible: false },
      { data: "fecha_create"},
      { data: "recibe", visible: false },
      { data: "acciones", },
      { data: "obs", visible: false },
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
  });
  //fin Libros

  tblEtiqueta = $("#tblEtiquetas").DataTable({
    ajax: {
      url: base_url + "Etiquetas/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id", visible: false },
      { data: "clave" },
      { data: "clasificacion" },
      { data: "isbn" },
      { data: "titulo" },
      { data: "autores" },
      { data: "editorial" },
      { data: "acciones" },
    ],
    language,
  });
  //fin Etiquetas

  tblPrestar = $("#tblPrestar").DataTable({
    ajax: {
      url: base_url + "Prestamos/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id", visible: false },
      { data: "clave" },
      { data: "titulo" },
      { data: "matricula" },
      { data: "nomenclatura", visible: false },
      { data: "nombre" },
      { data: "fecha_prestamo" },
      { data: "fecha_devolucion" },
      { data: "observacion" },
      { data: "prestador", visible: false },
      { data: "renovador", visible: false },
      { data: "recibe", visible: false },
      { data: "estado" },
      { data: "acciones" },
    ],
    columnDefs: [
      {
        targets: 7,
        width: "13%",
        render: function (data, type, row) {
          return data ? data : "&nbsp;";
        },
      },
      {
        targets: 9,
        width: "8%",
      }, // Aquí especificas el ancho para la columna de observaciones
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
    resonsieve: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    //pendiente por aprobar
    rowCallback: function (row, data, index) {
      if (data.estado === '<span class="badge badge-success">Devuelto</span>') {
        $(row).hide();
      }
    },
  });
  //Fin de la tabla Prestamos
});
