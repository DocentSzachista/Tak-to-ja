var checkboxArray = document.getElementsByClassName("form-check-input")
let g
if (checkboxArray != null) {
    for (g = 0; g < checkboxArray.length; g++) {
        if (checkboxArray[g].value == 1) {
            checkboxArray[g].checked = true
        }
    }
}