document.addEventListener("DOMContentLoaded", function(){
    const librosContainer = document.getElementById("librosContainer");
    const addBookBtn = document.getElementById("addBookBtn");
    let libroCount = 1;
     // llenar datalist Matriculas con las matrigulas de los estudiantes que traigo por ajax a la base de datos
     const matriculas = document.getElementById('Matriculas_list');
     const matriculasEbook = document.getElementById('Matriculas_listEbook');
     if (matriculas !== null || matriculasEbook !== null) {
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
                matriculasEbook.innerHTML = html;
             }
         }
         //escuchar el enter o cambio de valor en el input matricula y mandar a llamr verificarEstudiante
         document.getElementById('estudiante').addEventListener('change', verificarEstudiante);
         document.getElementById('estudianteE').addEventListener('change', verificarEstudiante);
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
         };
     }

     const clavesEbook = document.getElementById('clavesEbook');
     if (clavesEbook !== null) {
         const urlClavesEbook = base_url + 'Ebook/claves';
         const httpClavesEbook = new XMLHttpRequest();
         httpClavesEbook.open("GET", urlClavesEbook);
         httpClavesEbook.send();
         httpClavesEbook.onreadystatechange = function () {
             if (this.readyState == 4 && this.status == 200) {
                 const res = JSON.parse(this.responseText);
                 let html = '';
                 res.forEach(row => {
                     html += `<option value="${row.clave}">`;
                 });
                 clavesEbook.innerHTML = html;
             }
         };
     }

    // Escuchar el primer campo de libro por defecto
    document.getElementById('libro1').addEventListener('change', function () {
        verificarLibro(this, document.getElementById('libroT1'));
    });
    // escuchar campo de clave del ebook
    document.getElementById('EBook').addEventListener('change', function () {
        verificarEbook(this);
    });

    // Agregar más libros dinámicamente
    addBookBtn.addEventListener("click", function () {
        if (libroCount < 4) {
            libroCount++;
            // Contenedor de la clave del libro
            const colClave = document.createElement("div");
            colClave.className = "col-md-4";
            colClave.innerHTML = `
                <div class="form-group">
                    <label for="libro${libroCount}">Clave del libro</label><br>
                    <input id="libro${libroCount}" name="libros[]" class="form-control libro-clave" list="Claves">
                    <datalist id="Claves">
                        <!-- Opciones llenadas dinámicamente -->
                    </datalist>
                </div>
            `;

            // Contenedor del título del libro
            const colTitulo = document.createElement("div");
            colTitulo.className = "col-md-8";
            colTitulo.innerHTML = `
                <div class="form-group">
                    <label for="libroT${libroCount}">Título</label><br>
                    <input id="libroT${libroCount}" class="form-control libro-titulo" type="text" value="" readonly>
                </div>
            `;

            // Agregar ambos contenedores al div principal
            librosContainer.appendChild(colClave);
            librosContainer.appendChild(colTitulo);

            // Vincular el nuevo campo al evento de cambio
            document.getElementById(`libro${libroCount}`).addEventListener('change', function () {
                verificarLibro(this, document.getElementById(`libroT${libroCount}`));
            });
        } else {
            alert("Solo puedes agregar hasta 4 libros.");
        }
    });
});

function frmPrestar() {
    resetLibrosContainer(); // Restablece el contenedor de libros
    document.getElementById("frmPrestar").reset();
    document.getElementById("frmPrestarEbook").reset();
    document.getElementById("btnAccion").textContent = "Prestar";
    document.getElementById("title").textContent = "Prestar Libro";
    document.getElementById("estudiante").disabled = false;
    document.getElementById("fecha_prestamo").disabled = false;
    document.getElementById("id").value = "";
    // abilitar boton con id addBookBtn
    document.getElementById("addBookBtn").style.display = "block";
    //agregar un br despues del boton para que se vea mejor
    document.getElementById("addBookBtn").insertAdjacentHTML("afterend", "<br>");
    $("#prestar").modal("show");
}

function frmPrestarEbook() {
    document.getElementById("frmPrestarEbook").reset();
    document.getElementById("frmPrestar").reset();
    document.getElementById("btnAccionE").textContent = "Prestar";
    document.getElementById("titleE").textContent = "Prestar Ebook";
    document.getElementById("estudianteE").disabled = false;
    document.getElementById("fecha_prestamoE").disabled = false;
    document.getElementById("idE").value = "";
    $("#prestarEbook").modal("show");
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
                    if (res.type) {
                        console.log(res);
                        alertas_L(res.msg, res.icono);
                    }else{
                        alertas(res.msg, res.icono);
                    }
                }
            }

        }
    })
}
function registroPrestamos(e) {
    e.preventDefault();

    // Obtener el id para manejar acciones específicas
    const id = document.getElementById("id").value.trim(); // Puede estar vacío o tener un valor

    // Obtener los datos comunes
    const estudiante = document.getElementById("estudiante").value.trim();
    console.log(estudiante);
    const fecha_prestamo = document.getElementById("fecha_prestamo").value.trim();
    console.log(fecha_prestamo);
    const fecha_devolucion = document.getElementById("fecha_devolucion").value.trim();
    console.log(fecha_devolucion);  

    // Obtener todas las claves de libros desde los inputs dinámicos
    const libros = Array.from(document.querySelectorAll(".libro-clave"))
        .map(input => input.value.trim())
        .filter(value => value !== "");
    console.log(libros);

    // Validación del lado del cliente
    if (estudiante === '' || fecha_prestamo === '' || fecha_devolucion === '' || libros.some(libro => libro === '')) {
        alertas('Todos los campos son requeridos', 'warning');
        return;
    }

    // Si el id tiene valor, desactivar `disabled` en los inputs
    if (id !== '') {
        document.getElementById("estudiante").disabled = false;
        document.getElementById("fecha_prestamo").disabled = false;
    }

    // Preparar los datos para enviar
    const data = new FormData();
    if (id !== '') data.append("id", id); // Agregar el id solo si no está vacío
    data.append("estudiante", estudiante);
    data.append("fecha_prestamo", fecha_prestamo);
    data.append("fecha_devolucion", fecha_devolucion);
    libros.forEach(libro => data.append("libros[]", libro));

    // Enviar la solicitud al servidor
    const url = base_url + "Prestamos/registrar";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);

    // Manejo de la respuesta del servidor
    http.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                try {
                    const res = JSON.parse(this.responseText);
                    if (res.icono === 'success') {
                        tblPrestar.ajax.reload();
                        $("#prestar").modal("hide");
                        alertas(res.msg, res.icono);
                    } else {
                        alertas(res.msg, res.icono);
                    }
                } catch (error) {
                    alertas('Error en la respuesta del servidor', 'error');
                    console.error('Error al procesar la respuesta del servidor: ', error);
                }
            } else {
                alertas('Error al conectar con el servidor', 'error');
                console.error('Error HTTP: ', this.status);
            }
        }
    };
}


function btnRenovar(id) {
    // editar l afecha de devolucion
    document.getElementById("title").textContent = "Renovar Libro";
    document.getElementById("libro1").disabled = true;
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
            document.getElementById("libro1").value = res.clave;
            document.getElementById("estudiante").value = res.matricula;
            document.getElementById("fecha_prestamo").value = res.fecha_prestamo;
            document.getElementById("fecha_devolucion").value = res.fecha_devolucion;
            verificarEstudiante();
            verificarLibro(document.getElementById("libro1"), document.getElementById("libroT1"));
            //ocultar boton con id addBookBtn
            document.getElementById("addBookBtn").style.display = "none";
            $("#prestar").modal("show");
        }
    }
}

function verificarLibro(ebookInput, tituloInput) {
    const ClaveE = ebookInput.value;
    const http = new XMLHttpRequest();
    const url = base_url + 'Ebook/verificar/' + ClaveE;

    http.open("GET", url);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res) {
                tituloInput.value = res.titulo;
                tituloInput.style.color = '#495057';
            } else {
                tituloInput.value = 'No encontrado';
                tituloInput.style.color = 'red';
            }
        }
    };
}

function verificarEbook(libroInput) {
    const libroClave = libroInput.value;
    console.log(libroClave);
    const titulo = document.getElementById("EBookT");
    const http = new XMLHttpRequest();
    const url = base_url + 'Ebook/verificar/' + libroClave;

    http.open("GET", url);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res) {
                titulo.value = res.titulo;
                titulo.style.color = '#495057';
            } else {
                titulo.value = 'No encontrado';
                titulo.style.color = 'red';
            }
        }
    };
}

function verificarEstudiante() {
    const estudiante = document.getElementById('estudiante').value;
    const estudianteE = document.getElementById('estudianteE').value;
    let estu = estudiante ? estudiante : estudianteE;
    const url = base_url + 'Estudiantes/verificar/' + estu;
    const http = new XMLHttpRequest();
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res != null) {
                if (estudiante) {
                    document.getElementById('estudianteN').value = res.nombre;
                    document.getElementById('estudianteN').style.color = '#495057';
                    document.getElementById('estudianteC').value = res.carrera;
                    document.getElementById('estudianteM').value = res.modalidad;
                } 
                if (estudianteE) {
                    document.getElementById('estudianteNE').value = res.nombre;
                    document.getElementById('estudianteNE').style.color = '#495057';
                    document.getElementById('estudianteCE').value = res.carrera;
                    document.getElementById('estudianteME').value = res.modalidad;
                }
                
            }else{
                document.getElementById('estudianteN').value = 'No encontrado';
                document.getElementById('estudianteNE').value = 'No encontrado';
                document.getElementById('estudianteN').style.color = 'red';
                document.getElementById('estudianteNE').style.color = 'red';
                document.getElementById('estudianteC').value = '';
                document.getElementById('estudianteCE').value = '';
                document.getElementById('estudianteM').value = '';
                document.getElementById('estudianteME').value = '';
            }
        }
    }
}

function resetLibrosContainer() {
    const librosContainer = document.getElementById("librosContainer");

    // Limpia el contenido actual
    librosContainer.innerHTML = "";

    // Agrega el primer libro por defecto
    const colClave = document.createElement("div");
    colClave.className = "col-md-4";
    colClave.innerHTML = `
        <div class="form-group">
            <label for="libro1">Clave del libro</label><br>
            <input id="libro1" name="libros[]" class="form-control libro-clave" list="Claves">
            <datalist id="Claves">
                <!-- Opciones llenadas dinámicamente -->
            </datalist>
        </div>
    `;

    const colTitulo = document.createElement("div");
    colTitulo.className = "col-md-8";
    colTitulo.innerHTML = `
        <div class="form-group">
            <label for="libroT1">Título</label><br>
            <input id="libroT1" class="form-control libro-titulo" type="text" value="" readonly>
        </div>
    `;

    // Agregar las columnas de clave y título al contenedor principal
    librosContainer.appendChild(colClave);
    librosContainer.appendChild(colTitulo);

    // Restablece el contador de libros
    libroCount = 1;

    // Vincula el evento de cambio para el primer libro
    cargarClaves();
    document.getElementById("libro1").addEventListener("change", function () {
        verificarLibro(this, document.getElementById("libroT1"));
    });
}

function cargarClaves() {
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
        };
    }
}

function registroPrestamosEbook(e) {
    e.preventDefault();
    const id = document.getElementById("idE").value.trim();
    const estudiante = document.getElementById("estudianteE").value.trim();
    const fecha_prestamo = document.getElementById("fecha_prestamoE").value.trim();
    const fecha_devolucion = document.getElementById("fecha_devolucionE").value.trim();
    const Ebook = document.getElementById("EBook").value.trim();

    // Validacion del lado del cliente
    if (estudiante === '' || fecha_prestamo === '' || fecha_devolucion === '' || Ebook === '') {
        alertas('Todos los campos son requeridos', 'warning');
        return;
    } 

    // Si el id tiene valor, desactivar `disabled` en los inputs
    if (id !== '') {
        document.getElementById("estudianteE").disabled = false;
        document.getElementById("fecha_prestamoE").disabled = false;
    }

    const data = new FormData();
    if (id !== '') data.append("id", id); // Agregar el id solo si no está vacío
    data.append("estudiante", estudiante);
    data.append("fecha_prestamo", fecha_prestamo);
    data.append("fecha_devolucion", fecha_devolucion);
    data.append("EBook", Ebook);

    // Enviar la solicitud al servidor
    const url = base_url + "Prestamos/registrarEbook";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);

    // Manejo de la respuesta del servidor
    http.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                try {
                    const res = JSON.parse(this.responseText);
                    if (res.icono === 'success') {
                        tblPrestar.ajax.reload();
                        $("#prestarEbook").modal("hide");
                        alertas(res.msg, res.icono);
                    } else {
                        alertas(res.msg, res.icono);
                    }
                } catch (error) {
                    alertas('Error en la respuesta del servidor', 'error');
                    console.error('Error al procesar la respuesta del servidor: ', error);
                }
            } else {
                alertas('Error al conectar con el servidor', 'error');
                console.error('Error HTTP: ', this.status);
            }
        }
    };

}

function copiarTexto(texto) {
    navigator.clipboard.writeText(texto).then(() => {
        alert("Texto copiado: " + texto);
    }).catch(err => {
        console.error("Error al copiar: ", err);
    });
}

function redirigir(url) {
    window.open(url, '_blank', 'noopener,noreferrer');
}