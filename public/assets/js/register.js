document.addEventListener("DOMContentLoaded", regButton);
// Docente
let department, formation;
// Estudante
let year, course, average;

/*
    Provavelmente não era má ideia fazer com que os modais desaparecessem quando se clicasse no guardar.
    Ver isso depois.
*/

function regButton() {
    let regBtn = document.getElementById("reg-submit");
    regBtn.addEventListener("click", addNewProfile);
    
    let savStuBtn = document.getElementById("save-student");
    savStuBtn.addEventListener("click", saveStudentSpecs);
    
    let savTeaBtn = document.getElementById("save-teacher");
    savTeaBtn.addEventListener("click", saveTeacherSpecs);
};

function saveStudentSpecs() {
    course = document.getElementById("course-input").value;
    year = document.getElementById("year-range").value;
    average = document.getElementById("avg-range").value;
}

function saveTeacherSpecs() {
    course = document.getElementById("teacher-course-input").value;
    formation = document.getElementById("formation-input").value;
    department = document.getElementById("department-input").value;
}

function addNewProfile() {
    let email, password, name, date, privacy, userSpec, profilePhoto;
    
    if (document.getElementById("psw-input").value != document.getElementById("psw-input-confirm").value) {
        alert("As passwords não correspondem uma com a outra!");
        return;
    }
    
    email = document.getElementById("e-mail-input").value;
    password = document.getElementById("psw-input").value;
    name = document.getElementById("name-input").value;
    date = document.getElementById("date-input").value;
    profilePhoto = document.getElementById("profile-photo-input").value;
    userSpec = getUserSpecification();
};

function getUserSpecification() {
    if (document.getElementById("btnradio1").checked) {
        console.log("Public");
        return "public";
    }
    console.log("Private");
    return "private";
}