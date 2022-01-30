window.onload = function() {
    addEventListenersProfile();
};

function addEventListenersProfile() {
    let addColleagueBtn = document.getElementById("add-friend");
    if (addColleagueBtn != null) {
        if (!addColleagueBtn.checked) {
            addColleagueBtn.addEventListener("click", sendColleagueRequest);
        }
    }

    var newPostInput = document.getElementById("new-post-input");
    
    if (newPostInput != null) {
        newPostInput.style.width = "102.5%";
    }
}

function sendColleagueRequest() {
    let id = document.getElementById("profile-pic").getAttribute("data-user");
    console.log(id);
    sendAjaxRequest("post", "/send-friendship-request/" + id, null, colleagueRequestHandler);
}

function colleagueRequestHandler() {
    let btn = document.getElementById("add-friend");

    btn.innerHTML = "Pedido Pendente"
}

