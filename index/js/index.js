var x = document.getElementById("login");
var y = document.getElementById("register");
var z = document.getElementById("btn");
var err = document.getElementById("error_message");
var reg_mes = document.getElementById("message");
var form = document.getElementById("form-box");

/**
 * funkcje obsługujące przechodzenie pomiędzy rejestracją a logowaniem i
 * wyświetlanie potencjalnego komunikatu podczas logowania czy rejestracji
 */
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

/**
 * funcja sprawdza czy podczas rejestracji podane hasła są takie same 
 * jeśli nie to wyświetla komunikat "Passwords must match"
 */
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
/**
 * sprawdza czy w localStorage mamy zapisany login (Remeber Me)
 * jeśli tak to zaznaczy checkboxa i wypisuje login
 */
if (localStorage.checkbox && localStorage.checkbox !== "") {
    rmCheck.setAttribute("checked", "checked");
    loginInput.value = localStorage.username;
} else {
    rmCheck.removeAttribute("checked");
    loginInput.value = "";
}
/**
 * funckja obsługująca checkboxa Remeber Me
 * jeśli podczas logowania jest zaznaczony to zapisuje
 * login do localStorage
 */
function lsRememberMe() {
    if (rmCheck.checked && loginInput.value !== "") {
        localStorage.username = loginInput.value;
        localStorage.checkbox = rmCheck.value;
    } else {
        localStorage.username = "";
        localStorage.checkbox = "";
    }
}

/**
 * funkcja która się wykonuje podczas logowania
 * wywołuje ajax do pliku login.php
 * i sprawdza czy plik ten zwrócił jakąś wiadomośc jeśli tak to
 * wypisuje ją w oknie logowania, jeśli nie to następuje zalogowanie i przekierowanie
 * na strone home
 */
$(document).ready(function () {
    $('#login').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "index/php/login.php",
            method: "POST",
            data: $(this).serialize(),
            success: function (data) {
                if (data != '') {
                    document.getElementById("error_message").style.display =
                        "block";;
                    $('#error_message').html(data);
                } else {
                    window.location = 'home/home.php';
                }
            }
        })

    });
});

/**
 * funkcja która się wykonuje podczas rejetracji
 * wywołuje ajax do pliku registracion.php
 * następnie wypisuje wiadomość zwracaną przez ten plik 
 * w oknie rejestracji
 */
$(document).ready(function () {
    $('#register').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "index/php/registration.php",
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



