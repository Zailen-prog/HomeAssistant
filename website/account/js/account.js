$(document).ready(function () {
    show_info();
})

function show_info() {
    $.ajax({
        url: "php/get_account_info.php",
        method: "POST",
        dataType: 'json',
        success: function (data) {
            var jsonArray = data;
            $('#name').val(jsonArray.name);

            $('#last-name').val(jsonArray.lastname);

            $('#mail').val(jsonArray.email);
        },
    })
}

/**
 * po naciśnieciu przycisku save podczas edycji wykonuja ajax do pliku update_info.php
 * i zapisuje wszystkie dane w bazie danych jak i wyłącza możliwośc edycji
 */
$('#save_info').on('submit', function (event) {
    event.preventDefault();
    $.ajax({
        url: "php/update_info.php",
        method: "POST",
        data: $(this).serialize(),
        success: function (data) {
            $('#save_info').find(':input:not(.btn)').prop('disabled', true);
            $('#message').html(data);
        }
    })

});

$('#change-psw').on('submit', function (event) {
    event.preventDefault();
    $.ajax({
        url: "php/change_password.php",
        method: "POST",
        data: $(this).serialize(),
        success: function (data) {
            $('#message-psw').html(data);
        }
    })

});

/**
 * podcas kilknięcia edit, chowa przycisk edit i pokazuje przyciski save i cancel i 
 * umożliwia edytowanie 
 */
$('.edit').click(function () {
    $(this).hide();
    $(this).siblings('.save, .cancel').show();

    $('#save_info').find(':input').prop('disabled', false);
});

/**
 * podcas kilknięcia cancel, chowa przycisk save i cancel i pokazuje przycisk edit i
 * wyłącza moźliwość edycji jak i wykonuje funckje show_info która wypisuje poprzednie
 * dane  
 */
$('.cancel').click(function () {
    $(this).siblings('.edit').show();
    $(this).siblings('.save').hide();
    $(this).hide();

    $('#save_info').find(':input:not(.btn)').prop('disabled', true);

    show_info();
});

/**
 * podczas kliknięcia save chowa przycisk save i cancel i pokazuje przycisk edit
 */
$('.save').click(function () {
    $(this).siblings('.edit').show();
    $(this).siblings('.cancel').hide();
    $(this).hide();
});

/**
 * funcja sprawdza czy podczas rejestracji podane hasła są takie same 
 * jeśli nie to wyświetla komunikat "Passwords must match"
 */
function setPasswordConfirmValidity(str) {
    const password1 = document.getElementById('new-psw');
    const password2 = document.getElementById('new-psw-confirm');

    if (password1.value === password2.value) {
        password2.setCustomValidity('');
    } else {
        password2.setCustomValidity('Passwords must match');
    }
}