<div class="modal fade" role="dialog" tabindex="-1" id="docente">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Docente</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="teacher-register" action="{{ route('new_teacher') }}">
                    @csrf
                    <div class="mb-3" style="margin-bottom: 0px;">
                        <div style="margin-bottom: 10px;">
                            <label for="formation-input" style="margin-bottom: 3px;">Formação (obrigatório)</label>
                            <input class="form-control" type="text" id="formation-input" name="formation" style="width: 100%;color: #0c1618;">

                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="department-input" style="margin-bottom: 3px;">Departamento (obrigatório)</label>
                            <input class="form-control" type="text" id="department-input" name="department" style="width: 100%;color: #0c1618;">

                        </div>
                        <div class="modal-footer" style="margin-top: 10px;">
                            <button class="btn btn-primary" data-bs-dismiss="modal" id="reg-submit" type="submit">Registar</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>