var x = document.getElementById("login");
var y = document.getElementById("register");
var z = document.getElementById("btn");
var err = document.getElementById("error_message");
var reg_mes = document.getElementById("message");
var form = document.getElementById("form-box");

function register() {
    x.style.left = "-400px";
    y.style.left = "50px";
    z.style.left = "110px";
    err.style.display = "none";
    form.style.height = "450px"
}

function login() {
    x.style.left = "50px";
    y.style.left = "450px";
    z.style.left = "0";
    reg_mes.style.display = "none";
    form.style.height = "320px"
}

function setPasswordConfirmValidity(str) {
    const password1 = document.getElementById('password1');
    const password2 = document.getElementById('password2');

    if (password1.value === password2.value) {
        password2.setCustomValidity('');
    } else {
        password2.setCustomValidity('Passwords must match');
    }
}

const rmCheck = document.getElementById("rememberMe"),
    loginInput = document.getElementById("loginL");

if (localStorage.checkbox && localStorage.checkbox !== "") {
    rmCheck.setAttribute("checked", "checked");
    loginInput.value = localStorage.username;
} else {
    rmCheck.removeAttribute("checked");
    loginInput.value = "";
}

function lsRememberMe() {
    if (rmCheck.checked && loginInput.value !== "") {
        localStorage.username = loginInput.value;
        localStorage.checkbox = rmCheck.value;
    } else {
        localStorage.username = "";
        localStorage.checkbox = "";
    }
}

$(document).ready(function () {
    $('#login').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "login.php",
            method: "POST",
            data: $(this).serialize(),
            success: function (data) {
                if (data != '') {
                    document.getElementById("error_message").style.display =
                        "block";;
                    $('#error_message').html(data);
                } else {
                    window.location = 'home.php';
                }
            }
        })

    });
});

$(document).ready(function () {
    $('#register').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "registration.php",
            method: "POST",
            data: $(this).serialize(),
            success: function (data) {
                if (data != '') {
                    document.getElementById("message").style.display = "block";
                    $('#message').html(data);
                }
            }
        })

    });
});



