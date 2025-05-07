document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.card');
    const btnAceptar = document.getElementById('btnAceptar');
    let selectedCard = null;

    // Lógica de selección de libro
    cards.forEach(card => {
        card.addEventListener('click', () => {
            // Desmarcar todas las tarjetas
            cards.forEach(c => c.classList.remove('seleccionado'));
            
            // Marcar la tarjeta como seleccionada
            card.classList.add('seleccionado');

            // Obtener el radio button asociado a esta tarjeta
            const radio = card.querySelector('.input-libro');
            radio.checked = true;  // Asegurarse de que el radio esté seleccionado

            // Habilitar el botón de "Aceptar"
            btnAceptar.disabled = false;
            
            // Guardar la tarjeta seleccionada
            selectedCard = card;
        });
    });

    // Enviar el intercambio cuando el botón sea presionado
    btnAceptar.addEventListener('click', (e) => {
        const libroSeleccionadoInput = document.querySelector('input[name="libro_seleccionado"]:checked');
        const intercambioId = document.querySelector('input[name="intercambio_id"]').value;

        // Verificar que el libro esté seleccionado y el intercambio_id esté disponible
        if (libroSeleccionadoInput && intercambioId) {
            const libroId = libroSeleccionadoInput.value;

            // Redirigir a la página con los parámetros adecuados
            window.location.href = `includes/clases/intercambios/aceptarIntercambio.php?id_libro=${libroId}&id_intercambio=${intercambioId}`;
        } else {
            // Si no se selecciona ningún libro, muestra una alerta
            alert('Por favor, selecciona un libro antes de aceptar el intercambio.');
        }
    });
});
