$(document).on('change', '#region', function () {
    var region_id = $(this).val();
    var get_url = $('#base_url').val();
    $.ajax({
        type: 'get',
        url: get_url + '/ajax/get-city-by-region/' + region_id,
        async: true,
        beforeSend: function () {
            $("body").css("cursor", "progress");
        },
        success: function (res) {
            $('#city').empty();
            $('#city').append(res);
        },
        complete: function (data) {
            $("body").css("cursor", "default");
        }
    });
})
$(document).on('change', '#city', function () {
    var city_id = $(this).val();
    var get_url = $('#base_url').val();
    $.ajax({
        type: 'get',
        url: get_url + '/ajax/get-area-by-city/' + city_id,
        async: true,
        beforeSend: function () {
            $("body").css("cursor", "progress");
        },
        success: function (res) {
            $('#area').empty();
            $('#area').append(res);
        },
        complete: function (data) {
            $("body").css("cursor", "default");
        }
    });
})

$(document).on('change', '#area', function () {
    var area_id = $(this).val();
    $.ajax({
        type: 'get',
        url: get_url + '/ajax/get-subarea-by-area/' + area_id,
        async: true,
        beforeSend: function () {
            $("body").css("cursor", "progress");
        },
        success: function (res) {
            $('#subarea').empty();
            $('#subarea').append(res);
        },
        complete: function (data) {
            $("body").css("cursor", "default");
        }
    });
})