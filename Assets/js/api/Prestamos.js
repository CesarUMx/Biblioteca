document.addEventListener("DOMContentLoaded", function(){
    console.log("Prestamos.js cargado");
     // llenar datalist Matriculas con las matrigulas de los estudiantes que traigo por ajax a la base de datos
     const matriculas = document.getElementById('Matriculas_list');
     if (matriculas !== null) {
         const urlMatriculas = base_url + 'Estudiantes/matriculas';
         const http = new XMLHttpRequest();
         http.open("GET", urlMatriculas);
         http.send();
         http.onreadystatechange = function () {
             if (this.readyState == 4 && this.status == 200) {
                 const res = JSON.parse(this.responseText);
                 let html = '';
                 res.forEach(row => {
                     html += `<option value="${row.matricula}">`;
                 });
                 matriculas.innerHTML = html;
             }
         }
         //escuchar el enter o cambio de valor en el input matricula y mandar a llamr verificarEstudiante
         document.getElementById('estudiante').addEventListener('change', verificarEstudiante);
     }
 
     //llenar datalist con las claves de los libros
     const claves = document.getElementById('Claves');
     if (claves !== null) {
         const urlClaves = base_url + 'Libros/claves';
         const httpClaves = new XMLHttpRequest();
         httpClaves.open("GET", urlClaves);
         httpClaves.send();
         httpClaves.onreadystatechange = function () {
             if (this.readyState == 4 && this.status == 200) {
                 const res = JSON.parse(this.responseText);
                 let html = '';
                 res.forEach(row => {
                     html += `<option value="${row.clave}">`;
                 });
                 claves.innerHTML = html;
             }
         }
         //escuchar el enter o cambio de valor en el input clave y mandar a llamr verificarLibro
         document.getElementById('libro').addEventListener('change', verificarLibro);
     }
});

function frmPrestar() {
    document.getElementById("frmPrestar").reset();
    document.getElementById("btnAccion").textContent = "Prestar";
    document.getElementById("title").textContent = "Prestar Libro";
    document.getElementById("libro").disabled = false;
    document.getElementById("estudiante").disabled = false;
    document.getElementById("fecha_prestamo").disabled = false;
    $("#prestar").modal("show");
}
function btnEntregar(id) {
    Swal.fire({
        title: 'Recibir de libro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Prestamos/entregar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblPrestar.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
function registroPrestamos(e){
    e.preventDefault();
    const libro = document.getElementById("libro").value;
    const estudiante = document.getElementById("estudiante").value;
    const fecha_prestamo = document.getElementById("fecha_prestamo").value;
    const fecha_devolucion = document.getElementById("fecha_devolucion").value;
    if (libro == '' || estudiante == '' || fecha_prestamo == '' || fecha_devolucion == '') {
        alertas('Todo los campos son requeridos', 'warning');
    } else {
        const frm = document.getElementById("frmPrestar");
        const url = base_url + "Prestamos/registrar";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                tblPrestar.ajax.reload();
                $("#prestar").modal("hide");
                alertas(res.msg, res.icono);
                if (res.icono == 'success') {
                    setTimeout(() => {
                        window.open(base_url + 'Prestamos/ticked/'+ res.id, '_blank');
                    }, 3000);
                }
                
            }
        }
    }
}

function btnRenovar(id) {
    // editar l afecha de devolucion
    document.getElementById("title").textContent = "Renovar Libro";
    document.getElementById("libro").disabled = true;
    document.getElementById("estudiante").disabled = true;
    document.getElementById("fecha_prestamo").disabled = true;
    document.getElementById("btnAccion").textContent = "Renovar";
    //llamar los datos del prestamo
    const http = new XMLHttpRequest();
    const url = base_url + "Prestamos/getPrestamo/" + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("libro").value = res.clave;
            document.getElementById("estudiante").value = res.matricula;
            document.getElementById("fecha_prestamo").value = res.fecha_prestamo;
            document.getElementById("fecha_devolucion").value = res.fecha_devolucion;
            verificarEstudiante();
            verificarLibro();
            $("#prestar").modal("show");
        }
    }
}

function verificarLibro() {
    const libro = document.getElementById('libro').value;
    const http = new XMLHttpRequest();
    const url = base_url + 'Libros/verificar/' + libro;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res.icono == 'success') {
                document.getElementById('libroT').value = res.titulo;
            }else{
                alertas(res.msg, res.icono);
                return false;
            }
        }
    }      
}

function verificarEstudiante() {
    const estudiante = document.getElementById('estudiante').value;
    const http = new XMLHttpRequest();
    const url = base_url + 'Estudiantes/verificar/' + estudiante;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res.icono == 'success') {
                document.getElementById('estudianteN').value = res.nombre;
                document.getElementById('estudianteC').value = res.carrera;
                document.getElementById('estudianteM').value = res.modalidad;
            }else{
                alertas(res.msg, res.icono);
                return false;
            }
        }
    }
}