
document.addEventListener("DOMContentLoaded", addEventListenersAdmin);

function addEventListenersAdmin() {
    //Admin Dashboard
    let userDeleteIcons = document.querySelectorAll(".card-user i.fa.fa-trash");
    if (userDeleteIcons.length != 0) {
        [].forEach.call(userDeleteIcons, function (deleteIcon) {
            deleteIcon.addEventListener("click", sendDeleteUserRequest);
        });
    }

    let userBanIcons = document.querySelectorAll(".admin-links i.fa.fa-ban");
    console.log(userBanIcons);
    if (userBanIcons.length != 0) {
        [].forEach.call(userBanIcons, function (banIcon) {
            banIcon.addEventListener("click", sendBanUserRequest);
        });
    }

    let userUnbanIcons = document.querySelectorAll(".admin-links2 i.fa.fa-ban");
    console.log(userUnbanIcons);
    if (userUnbanIcons.length != 0) {
        [].forEach.call(userUnbanIcons, function (unbanIcon) {
            unbanIcon.addEventListener("click", sendUnbanUserRequest);
        });
    }
}

function sendDeleteUserRequest() {
    let id = this.closest(".card-user").getAttribute("data-id");

    sendAjaxRequest("delete", "/admin/delete-user/" + id, null, userDeletedHandler(id));
}

function userDeletedHandler(id) {
    var el = document.querySelector('.card-user[data-id="' + id + '"]');
    el.remove();
}

function sendBanUserRequest() {
    let id = this.closest(".card-user").getAttribute("data-id");
    console.log("BAN USER " + id);
    sendAjaxRequest("post", "/admin/ban-users/" + id, null, userBannedHandler(id));
}

function userBannedHandler(id) {
    let icon = document.querySelector('.card-user[data-id="' + id + '"] i.fa.fa-ban');
    icon = icon.parentElement;
    icon.setAttribute("class", "admin-links2");
    addEventListenersAdmin();
}

function sendUnbanUserRequest() {
    let id = this.closest(".card-user").getAttribute("data-id");
    console.log("UNBAN USER " + id);
    sendAjaxRequest("post", "/admin/unban-users/" + id, null, userUnbannedHandler(id));
}

function userUnbannedHandler(id) {
    let icon = document.querySelector('.card-user[data-id="' + id + '"] i.fa.fa-ban');
    icon = icon.parentElement;
    icon.setAttribute("class", "admin-links");
    addEventListenersAdmin();
}