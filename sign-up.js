document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const username = form.querySelector('input[name="txt"]').value.trim();
        const email = form.querySelector('input[name="email"]').value.trim();
        const password = form.querySelector('input[name="pswd"]').value.trim();

        if (username === '' || email === '' || password === '') {
            alert('Por favor, complete todos los campos.');
            return;
        }

        // Envía los datos al backend utilizando fetch API
        fetch('./sign-up.php', {  // Asegúrate de tener el './' para indicar la ruta relativa
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `txt=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&pswd=${encodeURIComponent(password)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud al servidor.');
            }
            return response.text();
        })
        .then(responseText => {
            alert(responseText); // Muestra la respuesta del servidor
        })
        .catch(error => {
            alert(error.message);
        });
    });
});

