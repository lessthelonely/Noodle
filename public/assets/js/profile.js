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