const form = document.querySelector(".signup form"),
    continueBtn = form.querySelector(".button input");

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
                console.log(data);
            }
        }
    }
    // Sending the form data through ajax to php
    xhr.send();

}