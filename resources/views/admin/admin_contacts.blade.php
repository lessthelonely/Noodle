@extends('layouts.admin')

@section('content')
<div class="container d-flex" style="margin-top: 7.5px; min-height: 600px;">

<div class="col-6" style="margin-right: 15px;">
        <iframe scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=41.177967,-8.5960284&amp;t=m&amp;z=15&amp;output=embed" width="550" height="400" frameborder="0"></iframe>
</div>
<div class="col-5">
        <h4>Contactos</h4>

<ul>
        <li style="margin-left: 15px; margin-right: 0px;">
                Mateus Silva
                <abbr title="Email"></abbr>
                <i title="Envelope" class="fa fa-envelope" style="margin-right: 1.5px;"></i>
        </li>
        <li style="margin-left: 15px;">
                Melissa Silva
                <abbr title="Email"></abbr>
                <i title="Envelope" class="fa fa-envelope" style="margin-right: 1.5px;"></i>
        </li>
        <li style="margin-left: 15px;">
                Cristina Pêra
                <abbr title="Email"></abbr>
                <i title="Envelope" class="fa fa-envelope" style="margin-right: 1.5px;"></i>
        </li>
        <li style="margin-left: 15px;">
                Luís Soares
                <abbr title="Email"></abbr>
                <i title="Envelope" class="fa fa-envelope" style="margin-right: 1.5px;"></i>
        </li>
</ul>
</div>


<div class="col">
        <div class="row">
                <div class="col">
                        <footer>
                                <a href="{{ route('login') }}">
                                        <i title="Início" class="fa fa-home" style="font-size: 25px;"></i>
                                </a>
                        </footer>
                </div>
        </div>
</div>
</div>

@endsection

