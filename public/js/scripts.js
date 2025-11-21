$(document).ready(function () {


    $("#show-register").click(function () {
        $("#register-modal").modal("show");
    });

    $("#modify-form").submit(function (event) {
        event.preventDefault();
        alert("Información actualizada correctamente.");
        $("#modifyModal").modal("hide");
    });
    

    $('#editar-profesor').on('show.bs.modal', function(event) {
        let btn = $(event.relatedTarget);
        $('#edit-id').val(btn.data('id'));
        $('#edit-nombre').val(btn.data('nombre'));
        $('#edit-cedula').val(btn.data('cedula'));
        $('#edit-telefono').val(btn.data('telefono'));
        $('#edit-correo').val(btn.data('correo'));
        $('#edit-especialidad').val(btn.data('especialidad'));
    });

        $('#editar-estudiante').on('show.bs.modal', function(event) {
        let btn = $(event.relatedTarget);
        $('#edit-id').val(btn.data('id'));
        $('#edit-nombre').val(btn.data('nombre'));
        $('#edit-cedula').val(btn.data('cedula'));
        $('#edit-fecha_nacimiento').val(btn.data('fecha_nacimiento'));
        $('#edit-grado').val(btn.data('grado'));
        $('#edit-escuela').val(btn.data('escuela'));
    });

    $('#eliminar-profesor').on('show.bs.modal', function(event) {
        let btn = $(event.relatedTarget);
        $('#delete-id').val(btn.data('id'));
        $('#delete-nombre').text(btn.data('nombre'));
    });

        $('#eliminar-estudiante').on('show.bs.modal', function(event) {
        let btn = $(event.relatedTarget);
        $('#delete-id').val(btn.data('id'));
        $('#delete-nombre').text(btn.data('nombre'));
    });
    
});

document.getElementById("btn-mostrar").addEventListener("click", function() {
    document.querySelectorAll(".extra-curso").forEach(el => el.classList.remove("d-none"));
    this.style.display = "none";
});




