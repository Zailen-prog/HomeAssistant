
function show_data() {
    $.ajax({
        url: "save_relays.php",
        method: "POST",
        data: { show: show.text() },
        dataType: 'json',
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
        }
    })
}

var nr = 1;
$('.relays').each(function () {
    var relay = $(this).children('span');
    $.ajax({
        url: "get_relay_names.php",
        method: "POST",
        data: "relay_nr=" + nr,
        success: function (data) {
            relay.html(data);
        }
    })
    nr = nr + 1;
    $(this).click(function () {
        show = $(this).children('span');
        show_data();
    });
});

var show = $('.nr-1').children('span');
$(document).ready(function () {
    show_data();
});

$('#save_values').on('submit', function (event) {
    event.preventDefault();
    $.ajax({
        url: "save_relays.php",
        method: "POST",
        data: $(this).serialize() + "&update=" + show.text(),
        success: function (data) {
            show.html($('#name-relay').val());
            $(this).find(':input:not(.btn)').prop('disabled', true);
        }
    })

});

$('.edit').click(function () {
    $(this).hide();
    $(this).siblings('.save, .cancel').show();
    $('form').each(function () {
        $(this).find(':input').prop('disabled', false);
    })
});

$('.cancel').click(function () {
    $(this).siblings('.edit').show();
    $(this).siblings('.save').hide();
    $(this).hide();
    $('form').each(function () {
        $(this).find(':input:not(.btn)').prop('disabled', true);
    })
    show_data();
});

$('.save').click(function () {
    $(this).siblings('.edit').show();
    $(this).siblings('.cancel').hide();
    $(this).hide();
});


