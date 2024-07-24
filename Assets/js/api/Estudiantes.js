//Inicio Estudiante

//validar si existe el elemnto con el id modalidad
if (document.getElementById('modalidad')) {
    document.getElementById('modalidad').addEventListener('change', function() {
        cargarCarreras(this.value);
    });
}

//funcion para cargar las option de un select id = carrera
async function cargarCarreras(modalidad) {
    if (!modalidad) {
        //limpiar select
        document.getElementById('carrera').innerHTML = '';
        return;
    }
    const url = base_url + 'Estudiantes/carreras?modalidad=' + modalidad;
    try {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const res = await response.json();
        let html = '';
        res.forEach(row => {
            html += `<option value="${row.id}">${row.nombre}</option>`;
        });
        document.getElementById('carrera').innerHTML = html;
    } catch (error) {
        console.error('Fetch error:', error);
    }
    if (modalidad > 6) {
        //cambiar valor de semestre a 0
        document.getElementById('sem').value = 0;
    }
}

function frmEstudiante() {
    document.getElementById("title").textContent = "Nuevo Estudiante";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmEstudiante").reset();
    document.getElementById("id").value = "";
    $("#nuevoEstudiante").modal("show");
}

function registrarEstudiante(e) {
    e.preventDefault();

    const matricula = document.getElementById("matricula").value.trim();
    const nombre = document.getElementById("nombre").value.trim();
    const carrera = document.getElementById("carrera").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const semestre = document.getElementById("sem").value.trim();

    // Validación del lado del cliente
    if (matricula === "") {
        alertas('El campo "matrícula" es requerido', 'warning');
        return;
    }
    if (nombre === "") {
        alertas('El campo "nombre" es requerido', 'warning');
        return;
    }
    if (carrera === "") {
        alertas('El campo "carrera" es requerido', 'warning');
        return;
    }
    if (semestre === "") {
        alertas('El campo "semestre" es requerido', 'warning');
        return;
    }

    const url = base_url + "Estudiantes/registrar";
    const frm = document.getElementById("frmEstudiante");
    const http = new XMLHttpRequest();
    
    http.open("POST", url, true);
    http.send(new FormData(frm));

    http.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                try {
                    const res = JSON.parse(this.responseText);
                    $("#nuevoEstudiante").modal("hide");
                    frm.reset();
                    tblEst.ajax.reload();
                    alertas(res.msg, res.icono);
                } catch (error) {
                    alertas('Error al procesar la respuesta del servidor', 'error');
                    console.error('Error al analizar la respuesta del servidor: ', error);
                }
            } else {
                alertas('Error en la conexión con el servidor', 'error');
                console.error('Error HTTP: ', this.status);
            }
        }
    };
}


async function btnEditarEst(id) {
    document.getElementById("title").textContent = "Actualizar estudiante";
    document.getElementById("btnAccion").textContent = "Modificar";
    
    const url = base_url + "Estudiantes/editar/" + id;

    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const res = await response.json();
        
        document.getElementById("id").value = res.id;
        document.getElementById("matricula").value = res.matricula;
        document.getElementById("sem").value = res.semestre;
        document.getElementById("nombre").value = res.nombre;
        document.getElementById("modalidad").value = res.modalidad;

        await cargarCarreras(res.modalidad);

        document.getElementById("carrera").value = res.id_carrera;

        document.getElementById("telefono").value = res.telefono;
        $("#nuevoEstudiante").modal("show");
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

function btnEliminarEst(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El estudiante no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Estudiantes/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblEst.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}

function btnReingresarEst(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Estudiantes/reingresar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblEst.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
//Fin Estudiante