function alert_box(message) {
    $("#alert-message").stop().html(message).fadeIn(500).delay(1500).fadeOut(500);
}
function confirm(message, success, fail, success_text, fail_text) {
    var box = $("#alert-confirm");
    box.html('<div class="alert-confirm-box"> <div class="alert-confirm-text"></div> <button class="confirm">' + success_text + '</button> <button class="cancel">' + fail_text + '</button> </div>');
    box.find(".alert-confirm-text").html(message);
    box.find(".confirm").click(function () {
        success();
        box.hide();
    }.bind(this));
    box.find(".cancel").click(function () {
        fail();
        box.hide();
    }.bind(this));
    box.show();
}
function banner(box) {
    var imageList = box.find(".banner-image-list li");
    var iconList = box.find(".banner-icon dd");
    var len = imageList.length;
    var index = 0;
    iconList.eq(index).addClass("active");
    imageList.eq(index).fadeIn();
    function switchBanner() {
        index = index + 1;
        if (index == len) {
            index = 0;
        }
        iconList.eq(index).addClass("active").siblings().removeClass("active");
        imageList.eq(index).fadeIn().siblings().fadeOut();
    }

    setInterval(switchBanner, 3000);
}
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    banner($("#banner-box"));
    $(document).delegate("[data-toggle='share-box']", 'click', function () {
        $("#share-box").toggleClass("active");
    });
    $(document).delegate("#share-box", "click", function () {
        $("#share-box").removeClass("active");
    });
    $(document).delegate("form:not([data-normal])", 'submit', function () {
        var btn = $(".btn");
        var form = $(this);
        form.find(".form-group").removeClass("error");
        btn.attr("disabled", "disabled");
        $.ajax({
            url: form.attr("action"),
            data: form.serialize(),
            type: form.attr("method"),
            dataType: 'json',
            error: function (error) {
                form.trigger('beforeSubmitError', error);
                switch (error.status) {
                    case 422:
                        var message = '';
                        $.each(error.responseJSON, function (k, msg) {
                            $("#" + k).addClass("error");
                            message = msg;
                        });
                        alert_box(message);
                        break;
                    case 200:
                        $(document).undelegate("form:not([data-normal])", 'submit');
                        form.submit();
                        return true;
                    default:
                        alert_box('服务器繁忙，请稍候再试');
                }
                btn.removeAttr("disabled", "disabled");
                form.trigger('afterSubmitError', error);
            }
        });
        return false;
    });
    $(document).delegate("#employee-apply-role-select", "change", function () {
        if ($(this).val() == 40) {
            $("#boss_id").show();
        } else {
            $("#boss_id").hide();
        }
    });
    $(document).delegate("#employee-coupon-type-select", "change", function () {  //券类型选择
        if ($(this).val() == 40) {
            $("#money").show();
            $("#discount-money").hide();
        } else if ($(this).val() == 50) {
            $("#discount-money").show();
            $("#money").hide();
        }
    });
    $(document).delegate("[data-order-confirm]", "submit", function () {
        confirm('确定兑换此优惠劵？', function () {
            $.ajax({
                url: $(this).attr("action"),
                type: 'post',
                success: function (result) {
                    if (result.code) {
                        alert_box(result.message);
                        window.location.href = result.data;
                    } else {
                        alert_box(result.message);
                    }
                },
                error: function () {
                    alert_box('服务器繁忙，请稍后再试。');
                }
            })
        }.bind(this), function () {
            return false;
        }.bind(this), '确定', '取消');
        return false;
    });
    $(document).delegate("#employee-couponApply-role-select", "change", function () {
        if ($(this).val() == 10) {
            $("#time-term").show();
            $("#time-length").hide();
        } else if ($(this).val() == 20) {
            $("#time-length").show();
            $("#time-term").hide();
        }

    });
    $(".comment-score-input").delegate("i", "click", function () {
        $(this).addClass("active").siblings().removeClass("active");
        $(this).prevAll().addClass("active");
        $("#comment-score").val($(".comment-score-input .active").length);
    });
    $(document).delegate("[data-address-box]", "change", function (event) {
        var select = $(event.target);
        var type = select.data('type');
        if (type == 'province' || type == 'city') {
            $(this).find("select").attr("disabled", true);
            $.ajax({
                url: $(this).data("url"),
                data: {id: select.val(), type: type},
                dataType: 'json',
                method: 'post',
                success: function (result) {
                    if (result.data[0] != undefined) {
                        $(this).find("select").eq(2).empty();
                        $.each(result.data[0], function (key, obj) {
                            console.log(obj);
                            $(this).find("select").eq(2).append('<option value="' + obj.id + '">' + obj.name + '</option>');
                        }.bind(this));
                    }
                    if (result.data[1] != undefined) {
                        $(this).find("select").eq(1).empty();
                        $.each(result.data[1], function (key, obj) {
                            $(this).find("select").eq(1).append('<option value="' + obj.id + '">' + obj.name + '</option>');
                        }.bind(this));
                    }
                    $(this).find("select").removeAttr("disabled");
                }.bind(this), error: function () {
                    $(this).find("select").removeAttr("disabled");
                }.bind(this)
            });
        }
    });
    $(document).delegate(".employee-list", "click", function () {
        $(this).siblings().removeClass("active");
        $(this).toggleClass("active");
    });
    $(document).delegate("[data-tab-switch] a", "click", function () {
        $(this).addClass("active").siblings().removeClass("active");
        $("[data-tab-box]").find(".tab").eq($(this).index("[data-tab-switch] a")).addClass("active").siblings().removeClass("active");
    });
    $(document).delegate(".order-address-box-empty", "click", function () {
        $("#address-write-box").show();
    });
    // $(document).delegate(".order-address-box", "click", function () {
    //     $("#address-write-box").show();
    // });
    $(document).delegate("#address-write-box form", "submit", function () {
        $(this).find(".form-group").removeClass("error");
        $.ajax({
            url: $(this).attr("action"),
            dataType: 'json',
            type: 'post',
            data: $(this).serialize(),
            success: function (result) {
                if (result.code == 1) {
                    $("input[name='address_id']").val(result.data.id);
                    $("#address-box-contact").html(result.data.contact);
                    $("#address-box-phone").html(result.data.contact);
                    $("#address-box-address").html(result.data.province_name + result.data.city_name + result.data.cunty_name + result.data.address);
                    $(".order-address-box").show();
                    $(".order-address-box-empty").hide();
                    $("#address-write-box").hide();
                } else {
                    alert_box('保存失败');
                }
            },
            error: function (error) {
                switch (error.status) {
                    case 422:
                        var message = '';
                        $.each(error.responseJSON, function (k, msg) {
                            $("#" + k).addClass("error");
                            message = msg;
                        });
                        alert_box(message);
                        break;
                    default:
                        alert_box('服务器繁忙，请稍候再试');
                }
            }
        });
        return false;
    });
});
wx.ready(function () {
    $(".shop-upload-box").delegate(".image-upload-box", "click", function () {
        if ($(this).hasClass("active")) {
            confirm("你想做什么操作？", function () {
                wx.chooseImage({
                    count: 1,
                    sizeType: ['original', 'compressed'],
                    sourceType: ['album', 'camera'],
                    success: function (res) {
                        wx.uploadImage({
                            localId: res.localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
                            isShowProgressTips: 1, // 默认为1，显示进度提示
                            success: function (upload) {
                                $(this).addClass('active');
                                $(this).find("img").remove();
                                $(this).find('input').val(upload.serverId);
                                $(this).append("<img src='" + res.localIds[0] + "' />");
                            }.bind(this)
                        });
                    }.bind(this)
                });
            }.bind(this), function () {
                $(this).find("img").remove();
                $(this).find('input').val('');
                $(this).removeClass("active");
            }.bind(this), '修改', '删除');
        } else {
            wx.chooseImage({
                count: 1,
                sizeType: ['original', 'compressed'],
                sourceType: ['album', 'camera'],
                success: function (res) {
                    wx.uploadImage({
                        localId: res.localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
                        isShowProgressTips: 1, // 默认为1，显示进度提示
                        success: function (upload) {
                            $(this).addClass('active');
                            $(this).find("img").remove();
                            $(this).find('input').val(upload.serverId);
                            $(this).append("<img src='" + res.localIds[0] + "' />");
                        }.bind(this)
                    });
                }.bind(this)
            });
        }
    });
    $(document).delegate("#location", "click", function () {
        wx.getLocation({
            type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                $.ajax({
                    type: 'post',
                    url: $(this).data('url'),
                    data: {location: res.latitude + ',' + res.longitude},
                    success: function () {

                    }
                })
            }.bind(this)
        });
    });
});