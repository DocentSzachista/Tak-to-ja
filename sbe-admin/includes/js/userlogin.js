// Login generator

var submit = document.getElementById("createProfile")

function loginGenerator() {
    var userlogin = document.getElementById("userlogin")
    var lastname = document.getElementById("lastname")
    var firstname = document.getElementById("firstname")

    if (firstname == null || lastname == null || userlogin == null || submit == null) {
        console.log("error")
    } else {
        let firstPart = firstname.value
        firstPart = firstPart.toLowerCase()
        firstPart = firstPart.substring(0, 3)
        let secondPart = lastname.value
        secondPart = secondPart.toLowerCase()
        secondPart = secondPart.substring(0, 3)
        let randomNumbers = ""
        for (i = 0; i < 3; i++) {
            randomNumbers += Math.floor(Math.random() * 10)
        }
        let login = firstPart + secondPart + randomNumbers
        login = login.replace("ó", "o");
        login = login.replace("Ó", "o");
        login = login.replace("ł", "l");
        login = login.replace("Ł", "l");
        login = login.replace("ń", "n");
        login = login.replace("Ń", "n");
        login = login.replace("ż", "z");
        login = login.replace("Ż", "z");
        login = login.replace("ź", "z");
        login = login.replace("Ź", "z");
        login = login.replace("Ć", "c");
        login = login.replace("ć", "c");
        login = login.replace("ę", "e");
        login = login.replace("Ę", "e");
        login = login.replace("Ś", "s");
        login = login.replace("ś", "s");
        userlogin.value = login
    }
}
// Password generator
function passwordGenerator() {
    var userPasswordInput = document.getElementById("inputPassword")
    var teacherPasswordInput = document.getElementById("inputPasswordTeacher")

    var parentPasswordInput = document.getElementById("parentInputPassword")
    if (userPasswordInput != null) {
        // userPasswordInput.value = Math.random().toString(36).slice(-9);
        userPasswordInput.value = "Skyrocket15!"
    }
    if (parentPasswordInput != null) {
        // parentPasswordInput.value = Math.random().toString(36).slice(-9);
        parentPasswordInput.value = "Skyrocket15!"
    }
    if ( teacherPasswordInput != null) {
        // userPasswordInput.value = Math.random().toString(36).slice(-9);
        teacherPasswordInput.value = "SkyRocket18!"
    }
}

submit.onclick = function () {
    loginGenerator()
    passwordGenerator()
}


