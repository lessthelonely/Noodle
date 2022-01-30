document.addEventListener("DOMContentLoaded", newPost);

function newPost() {
    let newPostBtn = document.getElementById("new-post-btn");
    newPostBtn.addEventListener("click", addNewPost);
    
    let editPostBtn = document.getElementById("edit-post-btn");
    editPostBtn.addEventListener("click", editPost);
}

function addNewPost() {
    let postText = document.getElementById("new-post-body-input").value;
    let anexo = document.getElementById("new-post-annex-input").value;
}

function editPost() {
    let editedText = document.getElementById("edit-post-body-input1").value;
    let anexo = document.getElementById("edit-post-annex-input").value;
}
