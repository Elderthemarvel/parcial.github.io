<?= $this->extend('layout')?>

<?=$this->section('contenido');?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Libros</h1>  
</div>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Nuevo Libro
    </button>
</div>
<?php if (!empty($libros) && is_array($libros)): 
    $n=1?>
<table id="libros" class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titulo</th>
      <th scope="col">Fecha de publicación</th>
      <th scope="col">Edutorial</th>
      <th scope="col">Email</th>
      <th scope="col">Isbn</th>
      <th scope="col">Precio</th>
      <th scope="col">opciones</th>
    </tr>
  </thead>
  <tbody>
        <?php foreach ($paises as $pais): ?>
        <tr>
        <th style="width: 50px;" scope="row">1</th>
        <td style="width: 50px;"><?= $pais['pais_id']?></td>
        <td><?= $pais['nombre']?></td>
        <td style="width: 30px;">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" onclick="eliminar(<?= $pais['pais_id']?>)" class="btn btn-danger"><span data-feather="trash"></span></button>
            </div>
        </td>
        </tr>
        <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
        <tr>
            <td colspan="4" class="text-center">No hay departamentos registrados.</td>
        </tr>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Nuevo Ciudadano</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  class="row g-3" action="" method="post" id="form_ciudadano">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" placeholder="Ingresa el título del libro" required>
        </div>

        <!-- Fecha de Publicación -->
        <div class="mb-3">
            <label for="fecha_publicacion" class="form-label">Fecha de Publicación</label>
            <input type="date" class="form-control" id="fecha_publicacion" required>
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" placeholder="Ingresa el precio del libro" required>
        </div>

        <!-- Editorial -->
        <div class="mb-3">
            <label for="editorial_id" class="form-label">Editorial</label>
            <select class="form-select" id="editorial_id" required>
                <option selected disabled>Selecciona una editorial</option>
                <option value="1">Editorial Alfa</option>
                <option value="2">Editorial Beta</option>
                <option value="3">Editorial Gamma</option>
                <!-- Puedes agregar más opciones según tus datos -->
            </select>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Ingresa tu correo electrónico" required>
        </div>

        <!-- ISBN -->
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="isbn" placeholder="Ingresa el ISBN del libro" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection()?>

<?=$this->section('script');?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    new DataTable('#libros', {
        layout: {
            topStart: 'info',
            bottom: 'paging',
            bottomStart: null,
            bottomEnd: null
        },
        
    });;
});
   

    document.getElementById('form_pais').addEventListener('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);
        
        axios.post("<?= base_url('/guardar_pais')?>", formData)
            .then(function (response) {
                if(!response.data.error){
                    Swal.fire({
                    title: "Campos Guardados!",
                    text: "Se a guardado el pais correctamente!",
                    icon: "success",
                    willClose: () => {
                        window.location.href = "<?= base_url('/paises')?>";
                    }
                    });
                }else{
                    Swal.fire({
                    title: "Opss!",
                    text: "No fue posible guardar los datos!",
                    icon: "error"
                    });
                }
            })
            .catch(function (error) {
                console.error('Error!', error);
            });
    });

    function eliminar(id) {

        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
        title: "Esta seguro?",
        text: "Esta a punto de eliminar definitivamente un registro!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminar!",
        cancelButtonText: "No, cancelar!",
        reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {

            axios.get("<?= base_url('/eliminar_pais/')?>"+id)
            .then(response => {
                console.log('Respuesta del servidor:', response.data);
                if(!response.data.error){
                    swalWithBootstrapButtons.fire({
                    title: "Eliminado!",
                    text: "El registro ha sido eliminado.",
                    icon: "success",
                    willClose: () => {
                        window.location.href = "<?= base_url('/paises')?>";
                    }
                });
                }else{
                    swalWithBootstrapButtons.fire({
                    title: "Opss!",
                    text: "El registro NO ha sido eliminado.",
                    icon: "error"
                });
                }
                
            })
            .catch(error => {
                console.error('Error al enviar el DPI:', error);
            });


            
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
            title: "Cancelado",
            text: "Tu registro esta asalbo :)",
            icon: "error"
            });
        }
        });
        
    }
</script>

<?= $this->endSection()?>