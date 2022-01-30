document.addEventListener("DOMContentLoaded", addEventListeners);
let doc = document;

function addEventListeners() {
    //Notifications
    let notificationCheckedBtn = document.querySelectorAll(
        ".notifications .fa.fa-check"
    );
    if (notificationCheckedBtn.length != 0) {
        [].forEach.call(notificationCheckedBtn, function (checkBtn) {
            checkBtn.addEventListener("click", sendCheckNotificationRequest);
        });
    }

    let acceptRequestBtn = document.querySelectorAll(".frs .fa.fa-check-circle");
    if (acceptRequestBtn.length != 0) {
        [].forEach.call(acceptRequestBtn, function (acceptReq) {
            acceptReq.addEventListener("click", sendAcceptFriendRequest);
        });
    }

    let rejectRequestBtn = document.querySelectorAll(".frs .fa.fa-times-circle");
    if (rejectRequestBtn.length != 0) {
        [].forEach.call(rejectRequestBtn, function (rejectReq) {
            rejectReq.addEventListener("click", sendRejectFriendRequest);
        });
    }

    //Post
    let postEditorBtn = document.getElementById("update-post");
    if (postEditorBtn != null) {
        postEditorBtn.addEventListener("click", sendEditPostRequest);
    }

    let postEditorsIcons = document.querySelectorAll("a .fa.fa-pencil");
    if (postEditorsIcons.length != 0) {
        [].forEach.call(postEditorsIcons, function (editorIcon) {
            editorIcon.addEventListener("click", addEditedFlag);
        });
    }

    let postDeleters = document.querySelectorAll(".delete-post .fa.fa-trash");
    if (postDeleters.length != 0) {
        [].forEach.call(postDeleters, function (deleter) {
            deleter.addEventListener("click", sendDeletePostRequest);
        });
    }

    /*let postCreatorBtn = document.getElementById("add-post");
    if (postCreatorBtn != null) {
        postCreatorBtn.addEventListener("click", sendNewPostRequest);
    }*/

    //Comment
    let commentDeleters = document.querySelectorAll(".delete-com .fa.fa-trash");
    if (commentDeleters.length != 0) {
        [].forEach.call(commentDeleters, function (deleter) {
            deleter.addEventListener("click", sendDeleteCommentRequest);
        });
    }

    let commentEditorBtn = document.getElementById("edit-comment-btn");
    if (commentEditorBtn != null) {
        commentEditorBtn.addEventListener("click", sendEditCommentRequest);
    }

    let commentCreatorIcons = document.querySelectorAll(
        ".new-com .fa.fa-comment"
    );

    if (commentCreatorIcons.length != 0) {
        [].forEach.call(commentCreatorIcons, function (editorIcon) {
            editorIcon.addEventListener("click", addCommentFlag);
        });
    }

    let commentCreatorBtn = document.getElementById("new-comment-btn");
    if (commentCreatorBtn != null) {
        commentCreatorBtn.addEventListener("click", sendNewCommentRequest);
    }

    //Likes
    let likePostBtn = document.querySelectorAll(
        "div.posts .fa.fa-thumbs-up.black"
    );
    if (likePostBtn.length != 0) {
        [].forEach.call(likePostBtn, function (likePost) {
            likePost.addEventListener("click", sendLikePostRequest);
        });
    }

    let unlikePostBtn = document.querySelectorAll(
        "div.posts .fa.fa-thumbs-up.yellow"
    );
    if (unlikePostBtn.length != 0) {
        [].forEach.call(unlikePostBtn, function (unlikePost) {
            unlikePost.addEventListener("click", sendUnlikePostRequest);
        });
    }

    let likeCommentBtn = document.querySelectorAll(
        "div.comments .fa.fa-thumbs-up.black"
    );
    if (likeCommentBtn.length != 0) {
        [].forEach.call(likeCommentBtn, function (likeComment) {
            likeComment.addEventListener("click", sendLikeCommentRequest);
        });
    }

    let unlikeCommentBtn = document.querySelectorAll(
        "div.comments .fa.fa-thumbs-up.yellow"
    );
    if (unlikeCommentBtn.length != 0) {
        [].forEach.call(unlikeCommentBtn, function (unlikeComment) {
            unlikeComment.addEventListener("click", sendUnlikeCommentRequest);
        });
    }

    //Unfriend
    let breakUpBtn = document.querySelectorAll(".fa.fa-frown-o");
    if (breakUpBtn.length != 0) {
        [].forEach.call(breakUpBtn, function (breakUpBtn) {
            breakUpBtn.addEventListener("click", sendBreakUpRequest);
        });
    }

    let deleteUserGroupBtn = document.querySelectorAll(".fa.fa-user-times");
    if (deleteUserGroupBtn.length != 0) {
        [].forEach.call(deleteUserGroupBtn, function (delUserGroupBtn) {
            delUserGroupBtn.addEventListener(
                "click",
                sendDeleteUserFromGroupRequest
            );
        });
    }

    //Groups
    let acceptGroupMemberBtn = document.querySelectorAll(".fa.fa-user-plus");
    if (acceptGroupMemberBtn.length != 0) {
        [].forEach.call(acceptGroupMemberBtn, function (addMember) {
            addMember.addEventListener("click", sendAcceptGroupMemberRequest);
        });
    }

    let rejectGroupMemberBtn = document.querySelectorAll(".fa.fa-times");
    if (rejectGroupMemberBtn.length != 0) {
        [].forEach.call(rejectGroupMemberBtn, function (rejectMember) {
            rejectMember.addEventListener(
                "click",
                sendRejectGroupMemberRequest
            );
        });
    }

    let sendEnterGroupRequestBtn = document.getElementById("group-member");
    if (
        sendEnterGroupRequestBtn != null &&
        sendEnterGroupRequestBtn.getAttribute("data-can-join")
    ) {
        sendEnterGroupRequestBtn.addEventListener(
            "click",
            sendEnterGroupRequest
        );
    }

    let moderatorInviteBtn = document.querySelectorAll(".mod-request-check .fa.fa-check-circle");
    console.log(moderatorInviteBtn);
    if (moderatorInviteBtn.length != 0) {
        [].forEach.call(moderatorInviteBtn, function (inviteMember) {
            inviteMember.addEventListener("click", sendModeratorGroupInviteRequest);
        })
    }

    let moderatorAcceptInviteBtn = document.querySelectorAll(".mod-request .fa.fa-check-circle");
    console.log(moderatorAcceptInviteBtn);
    if (moderatorAcceptInviteBtn.length != 0) {
        [].forEach.call(moderatorAcceptInviteBtn, function (acceptInvite) {
            acceptInvite.addEventListener("click", sendAcceptModeratorGroupInviteRequest);
        })
    }

    let moderatorRejectInviteBtn = document.querySelectorAll(".mod-request .fa.fa-times-circle");
    console.log(moderatorRejectInviteBtn);
    if (moderatorRejectInviteBtn.length != 0) {
        [].forEach.call(moderatorRejectInviteBtn, function (rejectInvite) {
            rejectInvite.addEventListener("click", sendRejectModeratorGroupInviteRequest);
        })
    }

    //Contextual Help
    var tooltipTriggerList = [].slice.call(document.querySelectorAll("label"));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    alignComments();
    checkComments();
}

function sendAcceptModeratorGroupInviteRequest() {
    var id = this.closest(".notifications").getAttribute("data-id");

    sendAjaxRequest("post", "/group/accept-invite/" + id, null, groupInviteAnsweredHandler(id));
}

function sendRejectModeratorGroupInviteRequest() {
    var id = this.closest(".notifications").getAttribute("data-id");

    sendAjaxRequest("post", "/group/reject-invite/" + id, null, groupInviteAnsweredHandler(id));
}

function groupInviteAnsweredHandler(id) {
    var requests = document.querySelectorAll('.notifications[data-id="' + id + '"]');
    [].forEach.call(requests, function (req) {
        req.remove();
    });
}

function sendModeratorGroupInviteRequest() {
    var id = this.closest(".card-user").getAttribute("data-id");
    var groupId = this.closest(".card-user").getAttribute("data-group-id");

    sendAjaxRequest("post", "/group/" + groupId + "/invite/" + id, null, moderatorGroupInviteHandler(id));
}

function moderatorGroupInviteHandler(id) {
    document.querySelector('.card-user[data-id="' + id + '"]').remove();
}

function sendEnterGroupRequest() {
    let idGroup = document
        .getElementById("group-member")
        .getAttribute("data-id-group");

    sendAjaxRequest(
        "post",
        "/group-ask-to-join/" + idGroup,
        null,
        sendEnterGroupRequestHandler
    );
}

function sendEnterGroupRequestHandler() {
    document.getElementById("group-member").innerHTML = "À espera de resposta ao seu pedido";
}


function sendRejectGroupMemberRequest() {
    let userId = this.closest("div.notifications").getAttribute("data-id-user");
    let groupId =
        this.closest("div.notifications").getAttribute("data-id-group");

    sendAjaxRequest(
        "post",
        "/group/" + groupId + "/reject/" + userId,
        null,
        memberRequestToGroupHandler(userId)
    );
}

function sendAcceptGroupMemberRequest() {
    let userId = this.closest("div.notifications").getAttribute("data-id-user");
    let groupId =
        this.closest("div.notifications").getAttribute("data-id-group");

    sendAjaxRequest(
        "post",
        "/group/" + groupId + "/add/" + userId,
        null,
        memberRequestToGroupHandler(userId)
    );
}

function memberRequestToGroupHandler(id) {
    document
        .querySelector('div.notifications[data-id-user="' + id + '"]')
        .remove();
}

function sendDeleteUserFromGroupRequest() {
    let id = this.closest("div.card-user").getAttribute("data-id");
    let idGroup = this.closest("div.card-user").getAttribute("data-group-id");
    sendAjaxRequest(
        "delete",
        "/group/" + idGroup + "/delete/" + id,
        null,
        deleteUserFromGroupHandler(id)
    );
}

function deleteUserFromGroupHandler(id) {
    document.querySelector('.card-user[data-id="' + id + '"]').remove();
}

function sendBreakUpRequest() {
    let id = this.closest(".card-user").getAttribute("data-id");
    sendAjaxRequest(
        "delete",
        "/breakup/" + id,
        null,
        breakUpFriendshipHandler(id)
    );
}

function breakUpFriendshipHandler(id) {
    document.querySelector('.card-user[data-id="' + id + '"]').remove();
}

function sendAcceptFriendRequest() {
    let id = this.closest(".frs").getAttribute("data-id");
    sendAjaxRequest("post", "/accept_friend/" + id, null, friendRequestAnsweredHandler(id));
}

function sendRejectFriendRequest() {
    let id = this.closest(".frs").getAttribute("data-id");
    sendAjaxRequest("post", "/reject_friendship_request/" + id, null, friendRequestAnsweredHandler(id));
}

function friendRequestAnsweredHandler(id) {
    var requests = document.querySelectorAll('.frs[data-id="' + id + '"]');
    [].forEach.call(requests, function (req) {
        req.remove();
    });
}

function reload() {
    window.location.reload();
}

function addCommentFlag() {
    var temp = this.closest(".posts");
    var modal = document.getElementById("create-comment");

    if (modal.getAttribute("add-comment-to") != null) {
        document
            .getElementById("create-comment")
            .removeAttribute("add-comment-to");
    }

    modal.setAttribute("add-comment-to", temp.getAttribute("data-id"));
}

function addEditedFlag() {
    var temp = document.querySelector(".posts i[edited=true]");
    if (temp != null) {
        temp.removeAttribute("edited");
    }
    this.setAttribute("edited", true);
}

function addEditedFlagComment() {
    var temp = document.querySelector(".comments i[edited=true]");
    if (temp != null) {
        temp.removeAttribute("edited");
    }
    this.setAttribute("edited", true);
}

function encodeForAjax(data) {
    if (data == null) return null;

    return Object.keys(data)
        .map(function (k) {
            return encodeURIComponent(k) + "=" + encodeURIComponent(data[k]);
        })
        .join("&");
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();
    request.open(method, url, true);
    request.setRequestHeader(
        "X-CSRF-TOKEN",
        document.querySelector('meta[name="csrf-token"]').content
    );
    request.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
    );
    request.addEventListener("load", handler);
    request.send(encodeForAjax(data));
}

function sendCheckNotificationRequest() {
    let id = this.closest(".notifications").getAttribute("data-id");
    sendAjaxRequest(
        "post",
        "/notifications-viewed/" + id,
        null,
        notificationCheckedHandler(id)
    );
}

function notificationCheckedHandler(id) {
    var nots = document.querySelectorAll('.notifications[data-id="' + id + '"]');
    [].forEach.call(nots, function (arg) {
        arg.remove();
    });
}

function sendDeletePostRequest() {
    let id = this.closest("div").getAttribute("data-id");
    sendAjaxRequest("delete", "/api/post/" + id, null, postDeletedHandler);
}

function sendEditPostRequest() {
    var temp = document.querySelector(".posts i[edited=true]");
    let id = temp.closest("div.posts").getAttribute("data-id");
    let conteudo = document.getElementById("edit-post-body-input").value;

    if (conteudo.includes('<script')) {
        alert("Boa tentativa. Não podemos deixar-te publicar isso, contudo.");
        window.reload();
    } else {
        document.getElementById("edit-post-body-input").value = "";
        sendAjaxRequest("post", "/api/post/" + id, { body: conteudo }, postEditedHandler);
    }
}

function sendDeleteCommentRequest() {
    let id;

    if (!(window.location.href.includes("search-results"))) {
        id = this.closest("div.comments").getAttribute("data-id");
    } else {
        id = this.closest("div.comments-results").getAttribute("data-id");
    }

    sendAjaxRequest("delete", "/api/comment/" + id, null, commentDeletedHandler);
}

function sendEditCommentRequest() {
    let temp, id, conteudo;

    if (!(window.location.href.includes("search-results"))) {
        temp = document.querySelector(".comments i[edited=true]");
        id = temp.closest("div.comments").getAttribute("data-id");

    } else {
        temp = document.querySelector(".comments-results i[edited=true]");
        id = temp.closest("div.comments-results").getAttribute("data-id");
    }

    conteudo = document.getElementById("edit-comment-input").value;

    if (conteudo.includes('<script')) {
        alert("Boa tentativa. Não podemos deixar-te comentar isso, contudo.");
        window.reload();
    } else {
        document.getElementById("edit-comment-input").value = "";
        sendAjaxRequest("post", "/api/comment/" + id, { comment: conteudo }, commentEditedHandler);
    }
}

function sendNewCommentRequest(event) {
    let conteudo = document.getElementById("new-comment-input").value;

    if (conteudo.includes('<script')) {
        alert("Boa tentativa. Não podemos deixar-te comentar isso, contudo.");
        window.reload();
    } else {
        let id = document.getElementById("create-comment").getAttribute("add-comment-to");

        if (conteudo != "") {
            sendAjaxRequest("post", "/api/comment/create/" + id, { content: conteudo }, commentCreatedHandler);
        }
    }
}

function sendLikePostRequest() {
    let id = this.closest("div.posts").getAttribute("data-id");
    sendAjaxRequest(
        "post",
        "/api/like/create-post/" + id,
        null,
        likeHandler("post", id)
    );
}

function sendUnlikePostRequest() {
    let idPost = this.closest("div.posts").getAttribute("data-id");
    sendAjaxRequest(
        "delete",
        "/api/like/delete-post/" + idPost,
        null,
        unlikeHandler("post", idPost)
    );
}

function sendLikeCommentRequest() {
    let id = this.closest("div.comments").getAttribute("data-id");
    sendAjaxRequest(
        "post",
        "/api/like/create-comment/" + id,
        null,
        likeHandler("comment", id)
    );
}

function sendUnlikeCommentRequest() {
    let idComment = this.closest("div.comments").getAttribute("data-id");
    sendAjaxRequest(
        "delete",
        "/api/like/delete-comment/" + idComment,
        null,
        unlikeHandler("comment", idComment)
    );
}

function likeHandler(type, id) {
    switch (type) {
        case "post":
            doc.querySelector(
                "div." + type + 's[data-id="' + id + '"] .fa.fa-thumbs-up.black'
            ).removeEventListener("click", sendLikePostRequest);
            break;
        default:
            doc.querySelector(
                "div." + type + 's[data-id="' + id + '"] .fa.fa-thumbs-up.black'
            ).removeEventListener("click", sendLikeCommentRequest);
            break;
    }
    doc.querySelector(
        "div." + type + 's[data-id="' + id + '"] .fa.fa-thumbs-up.black'
    ).setAttribute("class", "fa fa-thumbs-up yellow");
    addEventListeners();
}

function unlikeHandler(type, id) {
    switch (type) {
        case "post":
            doc.querySelector(
                "div." +
                    type +
                    's[data-id="' +
                    id +
                    '"] .fa.fa-thumbs-up.yellow'
            ).removeEventListener("click", sendUnlikePostRequest);
            break;
        default:
            doc.querySelector(
                "div." +
                    type +
                    's[data-id="' +
                    id +
                    '"] .fa.fa-thumbs-up.yellow'
            ).removeEventListener("click", sendUnlikeCommentRequest);
            break;
    }
    doc.querySelector(
        "div." + type + 's[data-id="' + id + '"] .fa.fa-thumbs-up.yellow'
    ).setAttribute("class", "fa fa-thumbs-up black");
    addEventListeners();
}

function postEditedHandler() {
    let post = JSON.parse(this.responseText);
    let element = document.querySelector(
        'div.posts[data-id="' + post.id + '"] .p-1.px-0'
    );
    element.innerHTML = post.conteudo;
}

function postDeletedHandler() {
    let post = JSON.parse(this.responseText);
    let element = document.querySelector(
        'div.posts[data-id="' + post.id + '"]'
    );
    element.remove();
    let comments = document.querySelectorAll(
        'div.comments[data-post-id="' + post.id + '"]'
    );
    [].forEach.call(comments, function (el) {
        el.remove();
    });
}

function commentCreatedHandler() {
    // Clean the modal up.
    document.getElementById("new-comment-input").value = "";

    var idPost = parseInt(doc.getElementById("create-comment").getAttribute("add-comment-to"));
    let commentsPost = Array.prototype.slice.call(doc.querySelectorAll('.col .comments[data-post-id="' + idPost + '"]')), commentNode, postNode, postScrollKids, index;
    if (commentsPost.length != 0) {
        commentNode = commentsPost[commentsPost.length - 1].parentElement.parentElement;
        postScrollKids = Array.prototype.slice.call(doc.querySelector(".post-scroll").children);
        index = postScrollKids.indexOf(commentNode) + 1;
    } else {
        postNode = doc.querySelector('.posts[data-id="' + idPost + '"]').parentElement.parentElement;
        postScrollKids = Array.prototype.slice.call(doc.querySelector(".post-scroll").children);
        index = postScrollKids.indexOf(postNode) + 1;
    }


    let row = document.createElement("div");
    row.setAttribute("class", "row");
    row.setAttribute("style", "width: 100%;");
    let col = document.createElement("div");
    col.setAttribute("class", "col");
    row.append(col);
    let comment = JSON.parse(this.responseText),
        new_comment = createComment(comment);
    col.append(new_comment);

    doc.querySelector(".post-scroll").insertBefore(row, doc.querySelector(".post-scroll").children[index]);

    addEventListeners();

    if (window.location.href.includes("profile")) {
        addEventListenersProfile();
    }
}

function commentEditedHandler() {
    if (!(window.location.href.includes("search-results"))) {
        let comment = JSON.parse(this.responseText);
        let element = document.querySelector('div.comments[data-id="' + comment.id + '"]');
        element.children[1].innerHTML = comment.conteudo;
    } else {
        let comment = JSON.parse(this.responseText);
        let element = document.querySelector('div.comments-results[data-id="' + comment.id + '"]');
        element.children[1].innerHTML = comment.conteudo;
    }
}

function commentDeletedHandler() {
    let comment, element;
    if (!(window.location.href.includes("search-results"))) {
        comment = JSON.parse(this.responseText);
        element = document.querySelector('div.comments[data-id="' + comment.id + '"]');
    } else {
        comment = JSON.parse(this.responseText);
        element = document.querySelector('div.comments-results[data-id="' + comment.id + '"]');
    }
    element.remove();
}

function likedPostHandler() {
    addEventListeners();
}

function likeDeletedHandler() {
    let like = JSON.parse(this.responseText);
    let element = document.querySelector("div.likes[data-id=" + like.id + '"]');
    element.remove();
}

function createComment(comment) {
    let new_comment = document.createElement("div");
    new_comment.classList.add("comments", "align-self-end");

    new_comment.setAttribute("data-id", comment.id);
    new_comment.setAttribute("data-post-id", comment.idpublicacao);
    var src = "../" + comment.member.fotoperfil;
    new_comment.innerHTML =
        `
        <header class="d-flex flex-row align-items-center" style="margin-bottom: 5px; margin-left: 5px; margin-top: 5px;">
        <a style="color: #0c1618; text-decoration: none" href="{{ route('show_profile', ['id' => $idUtilizador]) }}">
            <img alt="Foto de Perfil" class="post-user" src="` +
        src +
        `">
        </a>
        <a href="{{ route('show_profile', ['id' => $idUtilizador]) }}" style="color: #0c1618; text-decoration: none;">
            <h1 class="post-author" style="vertical-align: middle;margin: 0px;margin-top: -2px; color: #0c1618;">${comment.member.nome}</h1>
        </a>
    </header>
        <p class="d-flex flex-row align-items-center" style="margin-top: 5px; margin-left: 5px; margin-right: 5px; margin-bottom: 5px;">
            ${comment.conteudo}
        </p>
        <div class="footer">
            <a href="#like" style="padding: 5px; text-decoration: none;">
                <i title="Não Gosto" class="fa fa-thumbs-up black"></i>
            </a>
            <a class="edit-com" href="#" style="padding: 5px; text-decoration: none">
                <i title="Editar Comentário" class="fa fa-pencil" style="margin-right: 15px;" data-bs-toggle="modal" data-bs-target="#edit-comment"></i>
            </a>

            <a class="delete-com" style="padding: 5px; text-decoration: none" href="#">
                <i title="Apagar Comentário" class="fa fa-trash" type="submit"></i>
            </a>
        </div>`;
    return new_comment;
}

window.onload = alignComments();

function alignComments() {
    if (window.location.href.includes("groups") && document.getElementById("new-post-input") != undefined) {
        document.getElementById("new-post-input").style.width = "102.5%";

        var comments = document.querySelectorAll('.comments');
        [].forEach.call(comments, function (arg) {
            arg.style.marginRight = "-21.5px";
        });
    } else if (window.location.href.includes("genfeed")) {
        var comments = document.querySelectorAll('.comments');
        [].forEach.call(comments, function (arg) {
            arg.style.width = "85%";
        });
    }
}

function checkComments() {
    if (window.location.href.includes("search-results")) {
        let commentIcons = document.querySelectorAll('a.new-com .fa.fa-comment');
        [].forEach.call(commentIcons, function (arg) {
            arg.remove();
        })
    }
}
