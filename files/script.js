var typed = new Typed(".text", {
    strings: ["Programación", "Ciberseguridad", "Desarrollo de Videojuegos"],
    typeSpeed: 120,
    backSpeed: 120,
    backDelay: 1000,
    loop: true
});

const toTop = document.querySelector(".top");
window.addEventListener("scroll", () => {
    if (window.pageYOffset > 100) {
        toTop.classList.add("active");
    } else {
        toTop.classList.remove("active");
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');

    contactForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar la acción predeterminada del formulario

        // Obtener los datos del formulario y crear un objeto JSON
        var formData = {
            nombre: document.getElementById('nombre').value,
            email: document.getElementById('email').value,
            mensaje: document.getElementById('mensaje').value
        };

        // Enviar datos mediante AJAX usando fetch
        fetch('http://localhost/EverSync/create.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            // Manejar la respuesta JSON
            console.log(data); // Imprimir respuesta en consola para depuración
        
            if (data.success) {
                document.getElementById('response').textContent = "Mensaje enviado correctamente";
                document.getElementById('contactForm').reset();
            } else {
                document.getElementById('response').textContent = "Error al enviar el mensaje";
            }
        })
        .catch(error => {
            console.error('Error:', error); // Imprimir detalles del error en consola
            document.getElementById('response').textContent = "Error de conexión";
        });
        
    });
});
