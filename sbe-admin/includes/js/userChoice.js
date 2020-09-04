var userSelect = document.getElementById("selectUser")
var emailSelect = document.getElementById("parentsEmail")
var parentInputs = document.getElementById("createParent")

userSelect.addEventListener("change", function () {
    if (userSelect.value == "adult") {
        emailSelect.style.display = "none"
        parentInputs.style.display = "none"

    }
    if (userSelect.value == "student") {
        emailSelect.style.display = "block"
        parentInputs.style.display = "none"

    }
    if (userSelect.value == "studentParent") {
        emailSelect.style.display = "none"
        parentInputs.style.display = "block"

    }
})


var userInputs = document.getElementById("transferUserPanel")
var transferButton = document.getElementById("createProfile")
$('#transfer-user').click(function () {
    if ($(this).is(':checked')) {
        userInputs.style.display = "block"
        transferButton.style.display = "inline-block"

    } else {
        userInputs.style.display = "none"
        transferButton.style.display = "none"
    }
});