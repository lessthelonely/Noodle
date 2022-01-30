document.addEventListener("DOMContentLoaded", saveButton);
// Estudante
let year, course, average;

/*
    Falta código para preencher todos os inputs com os valores presentes do user.
*/

function saveButton() {
    let saveBtn = document.getElementById("save-btn");
    saveBtn.addEventListener("click", saveProfile);
    
    let delBtn = document.getElementById("delete-btn");
    delBtn.addEventListener("click", deleteProfile);
};

function deleteProfile() {
    console.log("CLICASTE NO APAGAR");
    // do stuff here later.
}

function saveProfile() {
    let email, password, name, date, privacy, userSpec, profilePhoto, college, headerPhoto, year, course, average;
    name = document.getElementById("name-input").value;
    date = document.getElementById("date-input").value;
    profilePhoto = document.getElementById("profile-photo-input").value;
    headerPhoto = document.getElementById("header-photo-input").value;
    //college = document.getElementById("college-input").value;

    //Need to see how to check if User is Student or Docente-->can we use php?
    course = document.getElementById("course-input").value;
    year = document.getElementById("year-range").value;
    department = document.getElementById("department-input").value;
    education = document.getElementById("formation-input").value;
    
    privacy = getUserSpecification();
    console.log("CLICASTE NO GUARDAR");
};

function getUserSpecification() { 
    if (document.getElementById("btnradio1").checked) {
        console.log("Public");
        return "public";
    }
    
    if (document.getElementById("btnradio2").checked) {
        console.log("Private");
        return "private";
    }  
}