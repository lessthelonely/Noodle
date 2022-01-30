<div id="edit-comment" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Comentário</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="margin-bottom: 5px;">
                    <textarea id="edit-comment-input" class="form-control" style="height: 159px;" name="comment" placeholder="Corpo do Comentário"></textarea>
                    @if ($errors->has('comment'))
                    <span class="error">
                        {{ $errors->first('comment') }}
                    </span>
                    @endif
                </p>
                <div class="modal-footer">
                    <button id="edit-comment-btn" class="btn btn-primary" type="button" data-bs-dismiss="modal">Atualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>