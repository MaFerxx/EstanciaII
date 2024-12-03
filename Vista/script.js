function iniciarMap() {
    // Crear el mapa y centrarlo en la primera empresa
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,  // Ajusta el zoom para ver un área más amplia
        center: { lat: parseFloat(empresas[0].latitud), lng: parseFloat(empresas[0].altitud) }  // Centra el mapa en la primera empresa
    });

    // Recorre el array de empresas para colocar un marcador para cada una
    empresas.forEach(function(empresa) {
        // Crear el marcador
        var marker = new google.maps.Marker({
            position: { lat: parseFloat(empresa.latitud), lng: parseFloat(empresa.altitud) },
            map: map,
            title: empresa.nombre_empresa  // Nombre de la empresa para el marcador
        });

        // Crear el contenido que se mostrará en el InfoWindow
        var infoContent = `
            <div>
                <h5>${empresa.nombre_empresa}</h5>
                <p><strong>Dirección:</strong> ${empresa.direccion_empresa}</p>
                <p><strong>Teléfono:</strong> ${empresa.telefono_empresa}</p>
                <p><strong>Correo:</strong> ${empresa.correo_empresa}</p>
            </div>
        `;

        // Crear un InfoWindow para mostrar la información de la empresa
        var infoWindow = new google.maps.InfoWindow({
            content: infoContent  // Establece el contenido del InfoWindow
        });

        // Asociar el InfoWindow al marcador, para que se muestre al hacer clic en el marcador
        marker.addListener("click", function() {
            infoWindow.open(map, marker);  // Muestra el InfoWindow
        });
    });
}




document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM cargado y script.js ejecutándose.');

    // Capturar los botones "Cancelar" y agregar evento
    const botonesCancelar = document.querySelectorAll('button[data-cancelar-cita]');

    if (botonesCancelar.length > 0) {
        botonesCancelar.forEach((boton) => {
            boton.addEventListener('click', (event) => {
                event.preventDefault(); // Detener envío automático del formulario
                const formulario = boton.closest('form'); // Obtener el formulario asociado
                const confirmar = confirm("¿Seguro que quiere cancelar esta cita?");
                if (confirmar && formulario) {
                    console.log("Cita confirmada para cancelar. Enviando formulario...");
                    formulario.submit(); // Enviar el formulario
                } else {
                    console.log("Cancelación de cita abortada.");
                }
            });
        });
    } else {
        console.warn('No se encontraron botones con el atributo "data-cancelar-cita" en el DOM.');
    }

    // Verificar elementos relacionados con login/registro (opcional, basado en tu script previo)
    const contenedorLogin = document.getElementById('contenedorLogin');
    const contenedorRegistro = document.getElementById('contenedorRegistro');
    const contenedorRegistroEmp = document.getElementById('contenedorRegistroEmp');

    const btnMostrarRegistro = document.getElementById('btnMostrarRegistro');
    const btnMostrarRegistroEmp = document.getElementById('btnMostrarRegistroEmp');
    const btnMostrarRegistroUsuarioE = document.getElementById('btnMostrarRegistroUsuarioE'); // Botón para mostrar registro de usuario desde el registro de empresa
    const btnMostrarLogin = document.querySelectorAll('#btnMostrarLogin'); // Selección múltiple para todos los botones "Iniciar Sesión"

    if (btnMostrarRegistro && btnMostrarLogin.length > 0 && btnMostrarRegistroEmp && btnMostrarRegistroUsuarioE) {
        btnMostrarRegistro.addEventListener('click', () => {
            console.log('Mostrando registro de usuario.');
            contenedorLogin.style.display = 'none';
            contenedorRegistro.style.display = 'block';
            contenedorRegistroEmp.style.display = 'none';
        });

        btnMostrarRegistroEmp.addEventListener('click', () => {
            console.log('Mostrando registro de empresa.');
            contenedorLogin.style.display = 'none';
            contenedorRegistro.style.display = 'none';
            contenedorRegistroEmp.style.display = 'block';
        });

        btnMostrarRegistroUsuarioE.addEventListener('click', () => {
            console.log('Mostrando registro de usuario desde el registro de empresa.');
            contenedorLogin.style.display = 'none';
            contenedorRegistro.style.display = 'block';
            contenedorRegistroEmp.style.display = 'none';
        });

        btnMostrarLogin.forEach(btn => {
            btn.addEventListener('click', () => {
                console.log('Mostrando login.');
                contenedorLogin.style.display = 'block';
                contenedorRegistro.style.display = 'none';
                contenedorRegistroEmp.style.display = 'none';
            });
        });
    } else {
        console.warn('Algunos elementos relacionados con login/registro no se encontraron en el DOM.');
    }
});
