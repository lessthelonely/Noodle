document.addEventListener("DOMContentLoaded", loginButton);
/*
    Provavelmente não era má ideia fazer com que os modais desaparecessem quando se clicasse no guardar.
    Ver isso depois.
*/
function loginButton() {
    let loginBtn = document.getElementById("login-form-button");
    loginBtn.addEventListener("click", loginProfile);
};

function login() {
    let email, password;
    email = document.getElementById("e-mail-input").value;
    password = document.getElementById("psw-input").value;
}
