<div class="modal fade" id="create-comment" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Novo Comentário</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <p style="margin-bottom: 5px;">
                    <textarea id="new-comment-input" class="form-control" name="content" style="height: 159px;" placeholder="Corpo do Comentário (obrigatório)"></textarea>
                    @if ($errors->has('content'))
                    <span class="error">
                    {{ $errors->first('content') }}
                    </span>
                    @endif
                </p>
            <div class="modal-footer" style="margin-top: 10px;">
                <button id="new-comment-btn" class="btn btn-primary" data-bs-dismiss="modal">Comentar</button></div>
        </div>
    </div>
</div>
</div>
</div>