function btnPagado(id) {
    document.getElementById("idPago").value = id;
    $("#pagoMulta").modal("show");
}

function btnCancelado(id) {
    document.getElementById("idMulta").value = id;
    $("#cancelarMulta").modal("show");
}

function cancelaMulta(e) {
    e.preventDefault();
    const id = document.getElementById("idMulta").value;
    const motivo = document.getElementById("motivo").value;

    if (id == "" || motivo == "") {
        alertas('Todos los campos son requeridos', 'warning');
    } else {
        const url = base_url + "Multas/cancelar";
        const http = new XMLHttpRequest();
        const frm = document.getElementById("frmMulta");
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                $("#cancelarMulta").modal("hide");
                tblMultas.ajax.reload();
                frm.reset();
                alertas(res.msg, res.icono);
            }
        }
    }
}

function toggleTextarea() {
    const formaPago = document.getElementById("formaPago").value;
    const donativoContainer = document.getElementById("donativoContainer");
    if (formaPago === "Condonacion") {
        donativoContainer.style.display = "block";
    } else {
        donativoContainer.style.display = "none";
    }
}

function pagoMultas(e) {
    e.preventDefault();
    const id = document.getElementById("idPago").value;
    const formaPago = document.getElementById("formaPago").value;
    const donativo = document.getElementById("donativo").value;
    let validacion;

    if (formaPago == "Condonacion") {
        if (donativo == "" || id == "") {
            alertas('todos los campos son requeridos', 'warning');
        } else {
            validacion = true;
        }
    } else {
        if (id == "") {
            alertas('Error al cargar la multa', 'warning');
        } else {
            validacion = true;
        }
    }

    if (validacion) {
        const url = base_url + "Multas/pagar";
        const http = new XMLHttpRequest();
        const frm = document.getElementById("frmPago");
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                $("#pagoMulta").modal("hide");
                tblMultas.ajax.reload();
                frm.reset();
                alertas(res.msg, res.icono);
            }
        }
    }
}