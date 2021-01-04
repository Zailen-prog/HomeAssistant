/**
 * funckja wykonująca ajax do pliku get_relay_info.php
 * który pobiera informacje o przekaźniku o danej nazwie
 * i zwraca je w postaci zmiennej json, następnie dane te
 * są wpisywane w odpowienie pola na stronie relays
 */
function show_data() {
    $.ajax({
        url: "php/get_relay_info.php",
        method: "POST",
        dataType: 'json',
        data: "show=" + show.text(),
        success: function (data) {
            var jsonArray = data;
            $('#name-relay').val(show.text());
            if (jsonArray.Temp_control == 1) {
                $('#temp-control').prop('checked', true);
            } else {
                $('#temp-control').prop('checked', false);
            }

            $('#temp-value-relay').val(jsonArray.Temp_value);

            if (jsonArray.Humi_control == 1) {
                $('#humi-control').prop('checked', true);
            } else {
                $('#humi-control').prop('checked', false);
            }
            $('#humi-value-relay').val(jsonArray.Humi_value);
            $('#description-relay').val(jsonArray.description);
        },
    })
}

var show = $('.nr-1').children('span');
var nr = 1;
/**
 * dla każdego przekaźnika zostaje wywołany ajax do pliku get_relay_names.php
 * który zwraca stan i nazwe przekaźnika o podanym numerze, następnie ta nazwa zostaje
 * wpisana na stronie
 */
$('.relays').each(function () {
    var relay = $(this).children('span');
    $.ajax({
        url: "../db_handlers/get_relay_names.php",
        method: "POST",
        data: "relay_nr=" + nr,
        dataType: 'json',
        success: function (data) {
            relay.html(data.name);
        }
    })
    nr = nr + 1;
    $(this).click(function () {
        show = $(this).children('span');
        show_data();
    });
});

/**
 * dla każdego przekaźnika zostaje wywołany ajax do pliku display_relay.php
 * który zwraca stan wyświetlania przekaźnika o podanym numerze,
 */
var nr_disp = 1;
$('.relay-btn').each(function () {
    var rel = $(this);
    $.ajax({
        url: "php/display_relay.php",
        method: "POST",
        data: "check=" + nr_disp,
        success: function (data) {
            if (data == 1) {
                rel.html("Active");
                rel.css("background-color", "rgba(0, 255, 8, 0.481)");
            }
            else {
                rel.html("Deactivated");
                rel.css("background-color", "rgba(255, 0, 0, 0.481)");
            }
        }
    })
    nr_disp = nr_disp + 1;
    $(this).click(function () {
        if ($(this).text() == "Active") {
            $(this).html("Deactivated");
            $(this).css("background-color", "rgba(255, 0, 0, 0.481)");
            $.ajax({
                url: "php/display_relay.php",
                method: "POST",
                data: "display=0" + "&name=" + $(this).parent().parent().find('span').text(),
            })
        } else {
            $(this).html("Active");
            $(this).css("background-color", "rgba(0, 255, 8, 0.481)");
            $.ajax({
                url: "php/display_relay.php",
                method: "POST",
                data: "display=1" + "&name=" + $(this).parent().parent().find('span').text(),
            })
        }

    });
});


/**
 * po naciśnieciu przycisku save podczas edycji wykonuja ajax do pliku update_relays.php
 * i zapisuje wszystkie dane w bazie danych jak i wyłącza możliwośc edycji
 */
$('#save_values').on('submit', function (event) {
    event.preventDefault();
    $.ajax({
        url: "php/update_relays.php",
        method: "POST",
        data: $(this).serialize() + "&update=" + show.text(),
        success: function () {
            show.html($('#name-relay').val());
            $(this).find(':input:not(.btn)').prop('disabled', true);
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
    $('form').each(function () {
        $(this).find(':input').prop('disabled', false);
    })
});

/**
 * podcas kilknięcia cancel, chowa przycisk save i cancel i pokazuje przycisk edit i
 * wyłącza moźliwość edycji jak i wykonuje funckje show_data która wypisuje poprzednie
 * dane  
 */
$('.cancel').click(function () {
    $(this).siblings('.edit').show();
    $(this).siblings('.save').hide();
    $(this).hide();
    $('form').each(function () {
        $(this).find(':input:not(.btn)').prop('disabled', true);
    })
    show_data();
});

/**
 * podczas kliknięcia save chowa przycisk save i cancel i pokazuje przycisk edit
 */
$('.save').click(function () {
    $(this).siblings('.edit').show();
    $(this).siblings('.cancel').hide();
    $(this).hide();
});


