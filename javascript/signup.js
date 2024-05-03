const form = document.querySelector(".signup form"),
    continueBtn = form.querySelector(".button input"),
    errorTxt = form.querySelector(".error-text");

form.onsubmit = (e) => {
    e.preventDefault(); // Preventing the form from submitting
}

continueBtn.onclick = () => {
    // AJAX
    let xhr = new XMLHttpRequest(); // XML object
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data === "success") {

                } else {
                    errorTxt.textContent = data;
                    errorTxt.style.display = "block";
                }
            }
        }
    }
    // Sending the form data through ajax to php
    let formData = new FormData(form)  // Creating a new form data object
    xhr.send(formData); // Sending formData to php

}