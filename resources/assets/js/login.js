var time;
function verifyToken(token) {
    $.ajax({
        url: '/admin/login/' + token,
        dataType: 'json',
        success: function (result) {
            if (result.code) {
                window.location.href = result.data;
            }
        }
    })
}
$("#close-login-code").bind('click', function () {
    $(".login-form").show();
    $(".login-code .tips").next().remove();
    $(".login-code").hide();
    $("button").removeAttr("disabled");
    clearInterval(time);
});
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("body").delegate('#login-form', 'submit', function () {
        clearInterval(time);
        var error = $(".login-error");
        var form = $(this);
        error.html('');
        $("button").attr("disabled", "disabled");
        $.ajax({
            type: 'post',
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function (result) {
                if (result.code) {
                    $(".login-form").hide();
                    $(".login-code .tips").after('<img src="' + result.data.image + '" />');
                    $(".login-code").show();
                    time = setInterval(function () {
                        verifyToken(result.data.token);
                    }, 3000);
                } else {
                    error.html(result.message);
                    $("button").removeAttr("disabled");
                }
            },
            error: function (error) {
                error.html('服务器繁忙，请稍候再试');
                $("button").removeAttr("disabled");
            }
        });
        return false;
    });
});
