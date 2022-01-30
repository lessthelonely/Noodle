{{--https://www.codewall.co.uk/how-to-show-validation-errors-in-laravel-views/--}}
@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 752px; margin-top: 7.5px;">
    <h4>Registo</h4>

    <p style="margin-bottom: 5px;">Qual destes dois és?</p>
    <div id="user-spec" class="btn-group" role="group">
        <input type="radio" class="btn-check" data-bs-toggle="modal" data-bs-target="#estudante" name="btnradio" id="btnradio5" autocomplete="off" value="student" />
        <label class="btn btn-outline-primary" for="btnradio5" data-bs-toogle="tooltip" data-bs-placement="top" data-bs-title="Se és um aluno da FEUP, esta é a opção indicada para ti.">Estudante</label>

        <input type="radio" class="btn-check" data-bs-toggle="modal" data-bs-target="#docente" name="btnradio" id="btnradio6" value="teacher" autocomplete="off" />
        <label class="btn btn-outline-primary" for="btnradio6" data-bs-toogle="tooltip" data-bs-placement="top" data-bs-title="Se és um docente da FEUP, esta é a opção indicada para ti.">Docente</label>

    </div>
    @include('partials.create_docente')
    @include('partials.create_estudante')
</div>
@endsection