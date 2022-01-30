<div class="row">
    <div class="col align-top">
        <input 
            type="text"
            id="new-post-input"
            class="flex-grow-1"
            style="border-color: rgba(118,118,118,0);
                   background: rgb(232,232,232);
                   color: #0c1618;
                   border-radius: 10px;
                   height: 60px;
                   margin-bottom: 10px;
                   width: 100%;"
            data-bs-toggle="modal"
            data-bs-target="#new-post">
    </div>
</div>
@include('partials.create_post_modal_group',array('id_group'=>$id_group))