var counter = 0;
var phoneInput = document.getElementById('phoneInput');
phoneInput.addEventListener('blur', (event) => {
    var splitString = phoneInput.value
    splitString = splitString.split("/")
    var formatedString = ""
    for (k = 0; k < splitString.length; k++) {
        if (splitString.length > 1) {
            if (phoneInput.value.length < 21) {
                var phoneValue = splitString[k]
                var a = new Array();
                var i = 3;
                do {
                    a.push(phoneValue.substring(0, i));
                    a.push("-")
                } while ((phoneValue = phoneValue.substring(i, phoneValue.length)) != "");
                a.pop()
                for (j = 0; j < a.length; j++) {

                    formatedString += a[j];
                }
                if (splitString.length-1 > k) {
                    formatedString += "/"
                }
                phoneInput.value = formatedString
            }
        } else {
            if (phoneInput.value.length < 11) {
                var phoneValue = splitString[k]
                var a = new Array();
                var i = 3;
                do {
                    a.push(phoneValue.substring(0, i));
                    a.push("-")
                } while ((phoneValue = phoneValue.substring(i, phoneValue.length)) != "");
                a.pop()
                for (j = 0; j < a.length; j++) {
                    formatedString += a[j];
                }
                phoneInput.value = formatedString
            }

        }
    }
})

