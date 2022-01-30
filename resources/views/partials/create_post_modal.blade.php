<div class="modal fade" role="dialog" tabindex="-1" id="new-post">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nova Publicação</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="create-post">
                <form method="POST" action = "{{route('create_post')}}" enctype="multipart/form-data" style="margin: 0px;margin-bottom: 10px;">
                 @csrf
                    <p style="margin-bottom: 5px;">
                        <textarea class="form-control" id="new-post-body-input" name="body" style="height: 159px; width: 100%;" placeholder="Corpo da publicação (obrigatório)"></textarea>
                        @if ($errors->has('body'))
                        <span class="error">
                        {{ $errors->first('body') }}
                        </span>
                         @endif
                    </p>
                    <p style="margin-bottom: 5px;">Anexo
                        <input class="form-control" id="new-post-annex-input" type="file" name="annex" style="width: 100%;">
                        @if ($errors->has('annex'))
                        <span class="error">
                        {{ $errors->first('annex') }}
                        </span>
                        @endif
                    </p>
                    <div class="modal-footer">
                        <button id="add-post" class="btn btn-primary" data-bs-dismiss="modal" type="submit">Publicar</button>
                    </div>
                </form>
                </div>
            </div>

        </div>
    </div>
</div>