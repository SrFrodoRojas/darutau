<div class="btn-group btn-group-sm">
    <a href="{{ route('admin.' . $route . '.show', $model->id) }}" class="btn btn-info" title="Ver">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.' . $route . '.edit', $model->id) }}" class="btn btn-primary" title="Editar">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-danger btn-delete" data-id="{{ $model->id }}" data-route="{{ $route }}" title="Eliminar">
        <i class="fas fa-trash"></i>
    </button>
    <form id="delete-form-{{ $model->id }}" action="{{ route('admin.' . $route . '.destroy', $model->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
</script>
