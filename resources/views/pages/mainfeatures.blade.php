@extends('layouts.app')
@section('content')
<div class="container" style="margin-top: 7.5px; min-height: 650px;">
   <h4>Funcionalidades Principais</h4>
   <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>
         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="6" aria-label="Slide 7"></button>
      </div>
      <div class="carousel-inner">
         <div class="carousel-item">
            <img src="assets/img/2.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
               <h5>Publicações, Comentários, Gostos, Feed</h5>
               <p>
                  É possível criar publicações e comentários <i title="Comentário" class="fa fa-comment"></i> e editá-los
                  após publicação! Pode-se interagir com estes elementos<br> através de gostos
                  <i title="Gosto" class="fa fa-thumbs-up"></i>. Para tal, podes ver tudo nos feeds geral de
                  tendências <i title="Tendências" class="fa fa-arrow-up"></i> e no personalizado.
               </p>
            </div>
         </div>
         <div class="carousel-item active">
            <img src="assets/img/1.png"  class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block" style="color:#0c1618;">
              <h5>Notificações</h5>
              <p> 
                Existem notificações enviadas a cada utilizador para muitos eventos específicos,
                tais como: pedido para se tornar colega, gostos <i title="Gosto" class="fa fa-thumbs-up"></i> 
                (em publicações ou comentários <i title="Comentário" class="fa fa-comment"></i>),
                comentários (em publicações) ou até quando um colega publica algo novo!
              </p>
            </div>
         </div>
         <div class="carousel-item">
            <img src="assets/img/3.png"  class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
               <h5>Grupos</h5>
               <p>Utilizadores podem criar espaços onde se reúnem com outros que partilhem os mesmos interesses.
                  <br>É possível editar as configurações destes espaços, criar diversas publicações e comentários.
               </p>
            </div>
         </div>
         <div class="carousel-item">
            <img src="assets/img/7.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Moderadores de Grupos</h5>
               <p>
                 Moderadores de Grupos têm a capacidade de manter a ordem
                 <br>num grupo, podendo retirar-lhe membros ou adicionar-lhos.</p>
            </div>
         </div>
         <div class="carousel-item">
            <img src="assets/img/4.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
               <h5>Pesquisa</h5>
               <p> Pesquisa de utilizadores, grupos, publicações e comentários <i title="Comentário" class="fa fa-comment"></i>.<br>
                  Utilizadores autenticados têm a opção de usar filtros para ter uma pesquisa mais focada.
               </p>
            </div>
         </div>
         <div class="carousel-item">
            <img src="assets/img/5.png" class="d-block w-100" alt="...">
         </div>
         <div class="carousel-item">
            <img src="assets/img/6.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
               <h5>Administrador</h5>
               <p>
                  Para garantir a segurança e ordem no Noodle, administradores<br>
                  têm a capacidade de banir, apagar e voltar instituir utilizadores.
               </p>
            </div>
         </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Seguinte</span>
      </button>
   </div>
   <a href="{{ route('login') }}">
   <i title="Início" class="fa fa-home" style="font-size: 25px;"></i>
   </a>
</div>
@endsection