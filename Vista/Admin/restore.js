$(document).ready(function () {
    // Registrar usuario
    $('#restoringBD').click(function () {
        var data = new FormData($('#formRestoreBD')[0]);

        $.ajax({
            url: '../../Controlador/Restore.php',
            type: 'POST',
            data: data,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (res) {
            switch (res) {
                case 'No se ha seleccionado ningún archivo.':
                case 'La Base de Datos no se restauró.':
                    Swal.fire({
                        text: res,
                        icon: 'warning',
                        confirmButtonColor: '#e74c3c',
                        confirmButtonText: 'Cerrar'
                    });
                    break;
                case 'La extensión del archivo no es permitida.':
                    Swal.fire({
                        title: res,
                        text: "Inténtelo de nuevo con archivos .SQL",
                        icon: 'warning',
                        confirmButtonColor: '#e74c3c',
                        confirmButtonText: 'Cerrar'
                    });
                    break;
                case '¡Base de Datos restaurada!':
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    });
                    swalWithBootstrapButtons.fire(
                        '¡Restaurada!',
                        res,
                        'success'
                    );
                    $('#backup_file').val('');
                    break;
            }
        });

    });
})