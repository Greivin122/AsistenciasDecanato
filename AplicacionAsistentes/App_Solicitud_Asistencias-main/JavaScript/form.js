function mostrarAsisEst(){

    if(document.getElementById('seleccionHorasAsistente').checked == true){
        document.getElementById('aprobado').setAttribute("min", "60");
    } else {
        document.getElementById('aprobado').setAttribute("min", "0");
    }
};

function mostrarInfoAsistencia(){

    if(document.getElementById("seleccionSiAsistencia").checked == true){
        document.getElementById('informacionAsistencias').style.display = 'block';
        document.getElementById('informacionBanco').style.display = 'none';
        document.getElementById('dondeAsistencia').required = true;
        document.getElementById('labores').required = true;
        document.getElementById('numeroCuenta').required = false;
        document.getElementById('informeBanco').required = false;

    } else {
        document.getElementById('informacionAsistencias').style.display = 'none';
        document.getElementById('informacionBanco').style.display = 'block';
        document.getElementById('dondeAsistencia').required = false;
        document.getElementById('labores').required = false;
        document.getElementById('numeroCuenta').required = true;
        document.getElementById('informeBanco').required = true;
        
    }
};

function enviarFormulario()
{
    const checkboxes = document.querySelectorAll('input[name="horario"]:checked');
    if(checkboxes.length <= 0){
        alert("Debe seleccionar el horario que le sirva");
        return false;
    }else{
        document.getElementById('datosPersonales').submit();
        return true;
    }
};