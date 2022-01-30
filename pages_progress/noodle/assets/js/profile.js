document.addEventListener("DOMContentLoaded", submitButton);

/*
    É preciso por aqui a parte em que preenchemos as caixas de input do modal.
    Não creio que seja difícil mas pronto.
*/

function submitButton() {
    let saveBtn = document.getElementById("save-profile");
    saveBtn.addEventListener("click", sendProfileUpdate);
};

function sendProfileUpdate() {
    let name, date, college, course, year, profilePhoto, headerPhoto;
    
    // It's working.
    name = document.getElementById("name-input").value;
    date = document.getElementById("date-input").value;
    profilePhoto = document.getElementById("profile-photo-input").value;
    headerPhoto = document.getElementById("header-photo-input").value;
    //college = document.getElementById("college-input").value; //doesn't exist anymore
    
    //Need to see how to check if User is Student or Docente-->can we use php?
    course = document.getElementById("course-input").value;
    year = document.getElementById("formControlRange").value;
    department = document.getElementById("department-input").value;
    education = document.getElementById("formation-input").value;
    profilePhoto = document.getElementById("profile-photo-input").value;
    headerPhoto = document.getElementById("header-photo-input").value;

};


function sendCreateProfileEstudanteRequest() {
    let id = this.closest("user").getAttribute("data-id");
    let email = document.getElementById("e-mail-input").value;
    let password = document.getElementById("psw-input").value;
    let name = document.getElementById("name-input").value;
    let date = document.getElementById("date-input").value;
    let course = document.getElementById("course-input").value;
    let year = document.getElementById("year-range").value;
    let media = document.getElementById("avg-range").value;
    let privacidade = document.querySelector('input[name="privacidade"]:checked').value;
    let profilePhoto = document.getElementById("data-id").value;

    if (email!="" && password!="" && name!="" && privacidade!=""){
        sendAjaxRequest("put", "/user/estudante/" + id, 
            { email: email, password: password, name: name, date: date,
              course: course, year: year, media: media, privacidade: privacidade, 
              profilePhoto: profilePhoto}, createProfileEstudanteHandler);
    }
}

function sendCreateProfileDocenteRequest() {
    let id = this.closest("user").getAttribute("data-id");
    let email = document.getElementById("e-mail-input").value;
    let password = document.getElementById("psw-input").value;
    let name = document.getElementById("name-input").value;
    let date = document.getElementById("date-input").value;
    let formacao = document.getElementById("formation-input").value;
    let departamento = document.getElementById("department-input").value;
    let privacidade = document.querySelector('input[name="privacidade"]:checked').value;
    let profilePhoto = document.getElementById("data-id").value;

    if (email!="" && password!="" && name!="" && privacidade!=""){
        sendAjaxRequest("put", "/user/estudante/" + id, 
            { email: email, password: password, name: name, date: date,
              formacao: formacao, departamento: departamento, privacidade: privacidade, 
              profilePhoto: profilePhoto}, createProfileDocenteHandler);
    }
}

function createProfileEstudanteHandler() {
    if (this.status != 200) {
        window.location = '/';
    }
    let profile = JSON.parse(this.responseText);
    let new_profile = addNewProfile();
    let new_profile_estudante = saveStudentSpecs();

    let profile = document.querySelector( + profile.id + );
}
