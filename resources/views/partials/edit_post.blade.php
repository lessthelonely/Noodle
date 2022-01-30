<div class="modal fade" role="dialog" tabindex="-1" id="edit-post">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Publicação</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="margin-bottom: 5px;">
                    <textarea class="form-control" name="body" id="edit-post-body-input" style="height: 159px;" placeholder="Novo Corpo de Publicação"></textarea>
                    @if ($errors->has('body'))
                    <span class="error">
                    {{ $errors->first('body') }}
                    </span>
                    @endif
                </p>
                <div class="modal-footer">
                    <button id="update-post" class="btn btn-primary" data-bs-dismiss="modal">Atualizar</button>
                </div>
            </div>

        </div>
    </div>
</div>