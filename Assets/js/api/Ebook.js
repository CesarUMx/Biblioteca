document.addEventListener("DOMContentLoaded", function(){
    const materia = document.getElementById('MateriaList');
     if (materia !== null) {
         const urlMateria = base_url + 'Materia/buscarMateria';
         const httpMateria = new XMLHttpRequest();
         httpMateria.open("GET", urlMateria);
         httpMateria.send();
         httpMateria.onreadystatechange = function () {
             if (this.readyState == 4 && this.status == 200) {
                 const res = JSON.parse(this.responseText);
                 let html = '';
                 res.forEach(row => {
                     html += `<option value="${row.materia}">`;
                 });
                 materia.innerHTML = html;
             }
         }
     }
});

function frmEbooks() {
    document.getElementById("title").textContent = "Nuevo Ebook";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmEbook").reset();
    document.getElementById("id").value = "";
    $("#nuevoEbook").modal("show");
}

function registrarEbook(e) {
    e.preventDefault();
    const clasificacion = document.getElementById("clasificacion");
    const titulo = document.getElementById("titulo");
    const autor = document.getElementById("autor");
    const editorial = document.getElementById("editorial");
    const materia = document.getElementById("materia");

    //campos requeridos
    if (titulo.value == '' || clasificacion.value == '' || autor.value == '' || editorial.value == '' || materia.value == '') {
        alertas('Todo los campos son requeridos', 'warning');
    } else {
        const url = base_url + "Ebook/registrarEbook";
        const frm = document.getElementById("frmEbook");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                $("#nuevoEbook").modal("hide");
                tblEbooks.ajax.reload();
                frm.reset();
                alertas(res.msg, res.icono);
            }
        }
    }
}

function btnEditarEbook(id) {
    document.getElementById("title").textContent = "Actualizar Ebook";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "Ebook/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
              document.getElementById("id").value = res.id;
              document.getElementById("clasificacion").value = res.clasificacion;
              document.getElementById("titulo").value = res.titulo;
              document.getElementById("autor").value = res.autores;
              document.getElementById("editorial").value = res.editorial;
              document.getElementById("materia").value = res.materia;
              
            $("#nuevoEbook").modal("show");
            // ocultar campo de cantidad
        }
    }
    
}

function btnEliminarEbook(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El libro no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Ebook/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblEbooks.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }
        }
    })
}
