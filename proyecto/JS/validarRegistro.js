$(document).ready(function() {
    // Ocultamos los íconos de validación al inicio
    $("#validEmail").hide();
    $("#validUser").hide();

    // Validación del correo electrónico
    $("#email").change(function(){
        const campo = $("#email");
        const validEmail = $("#validEmail");
        campo[0].setCustomValidity("");

        // Validación HTML5 + dominio UCM
        const esCorreoValido = campo[0].checkValidity();
        if (esCorreoValido && correoValidoUCM(campo.val())) {
            // Correo válido
            validEmail.html("&#x2714;"); // Checkmark de la URL proporcionada
            validEmail.css("color", "green");
            validEmail.show();
            campo[0].setCustomValidity("");
        } else {            
            // Correo inválido
            validEmail.html("&#x274C;"); // X mark de la URL proporcionada
            validEmail.css("color", "red");
            validEmail.show();
            campo[0].setCustomValidity(
                "El correo debe ser válido y acabar por @ucm.es");
        }
    });

    // Validación del nombre de usuario
    $("#nombreUsuario").change(function(){
        console.log("Validando nombre de usuario...");
        var url = "../includes/clases/usuarios/comprobarUsuario.php?user=" + encodeURIComponent($("#nombreUsuario").val());
        $.get(url, usuarioExiste);
    });

    // Función para validar dominio UCM
    function correoValidoUCM(correo) {
        return correo.toLowerCase().endsWith("@ucm.es");
    }

    // Función que maneja la respuesta del servidor
    function usuarioExiste(data, status) {
        const campo = $("#nombreUsuario");
        const validUser = $("#validUser");
        console.log("Respuesta del servidor: " + data);
        console.log("Estado de la petición: " + status);

        if (status == "success") {
            if (data.trim() == "existe") {
                // Usuario no disponible
                validUser.html("&#x274C;");
                validUser.css("color", "red");
                validUser.show();
                alert("El nombre de usuario ya está reservado");
                campo[0].setCustomValidity("Usuario no disponible");
            } else if (data.trim() == "disponible") {
                // Usuario disponible
                validUser.html("&#x2714;");
                validUser.css("color", "green");
                validUser.show();
                campo[0].setCustomValidity("");
            }
        } else {
            // Error en la petición
            validUser.html("&#x274C;");
            validUser.css("color", "red");
            validUser.show();
            campo[0].setCustomValidity("Error al verificar usuario");
        }
    }
});