function cambioSeleccionIdentificacion(element)
{
    if(element.value=="nacionalResidente")
    {
        document.getElementById('inpttxt_Cedula').setAttribute("pattern", "\\d{9}");
        document.getElementById('inpttxt_Cedula').disabled=false;
    }
    else if(element.value=="extranjero")
    {
        document.getElementById('inpttxt_Cedula').removeAttribute('pattern');
        document.getElementById('inpttxt_Cedula').disabled=false;
    }
    else
    {
        document.getElementById('inpttxt_Cedula').removeAttribute('pattern');
        document.getElementById('inpttxt_Cedula').disabled=true;
    }
};

function toggleFormularios()
{
    if(document.getElementById('solicitud_asistencia_form').style.display != 'none')
    {
        document.getElementById('solicitud_asistencia_form').style.display = 'none';
        document.getElementById('solicitud_modificar_form').style.display = 'block';
    } else {
        document.getElementById('solicitud_asistencia_form').style.display = 'block';
        document.getElementById('solicitud_modificar_form').style.display = 'none';
    }

};