document.addEventListener("DOMContentLoaded", function(){
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

function frmEtiquetas() {
    document.getElementById("title").textContent = "Agregar Etiqueta";
    document.getElementById("btnAccion").textContent = "Agregar";
    document.getElementById("frmEtiqueta").reset();
    $("#nuevaEtiqueta").modal("show");
}

function agregarLibro(e) {
    e.preventDefault();
    const libro = document.getElementById("libro");

    if (libro.value == '') {
        alertas('Selecciona un libro', 'warning');
    } else {
        const url = base_url + "Etiquetas/registrar";
        const frm = document.getElementById("frmEtiqueta");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                $("#nuevaEtiqueta").modal("hide");
                tblEtiqueta.ajax.reload();
                frm.reset();
                alertas(res.msg, res.icono);
            }
        }
    }
}

function btnEliminarEtiqueta(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El libro se quitara de la lista de libros para etiquetar",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Etiquetas/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblEtiqueta.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
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
            if (res != null) {
                document.getElementById('libroT').value = res.titulo;
                document.getElementById('libroT').style.color = '#495057';
            }else{
                document.getElementById('libroT').value = 'No encontrado';
                document.getElementById('libroT').style.color = 'red';
            }
        }
    }      
}