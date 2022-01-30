<div class="modal fade" role="dialog" tabindex="-1" id="estudante">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Estudante</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="student-register" action="{{ route('new_student') }}">
                    @csrf
                    <div class="mb-3">
                        <div style="margin-bottom: 10px;">
                            <label for="course-input" style="margin-bottom: 3px;">Curso (obrigatório)</label>
                            <input class="form-control" type="text" id="course-input" name="course" style="width: 100%;color: #0c1618;">

                            @if ($errors->has('course'))
                            <span class="error">
                                {{ $errors->first('course') }}
                            </span>
                            @endif
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="year-range" style="margin-bottom: 3px;">Ano Corrente (obrigatório)</label>
                            <input class="form-range" type="range" name="year" id="year-range" default=1 min=1 max=5 onchange="document.getElementById('year').innerHTML = this.value;">

                            @if ($errors->has('year'))
                            <span class="error">
                                {{ $errors->first('year') }}
                            </span>
                            @endif
                            <output id="year">1</output>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="avg-range" style="margin-bottom: 3px;">Média (obrigatório)</label>
                            <input type="range" class="form-range" name="media" id="avg-range" default=10.0 min=0.0 max=20.0 step=0.1 onchange="document.getElementById('avg').innerHTML = this.value;">
                            @if ($errors->has('media'))
                            <span class="error">
                                {{ $errors->first('media') }}
                            </span>
                            @endif
                            <output id="avg">10.0</output>
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