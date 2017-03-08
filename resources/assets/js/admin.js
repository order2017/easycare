$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
$(document).ajaxStart(function () {
    $.AMUI.progress.start();
}).ajaxStop(function () {
    $.AMUI.progress.done();
});
$(document).pjax('a:not(.modal)', '#content');
$(document).on("pjax:success", function (event) {
    event.preventDefault();
    initPage();
});
$(document).on("pjax:timeout", function (event) {
    event.preventDefault();
});
function initPage() {
    $("[data-select2-box]").select2();
    $('[data-datetime-picker]').datetimepicker();
    $.each($(".admin-upload-box"), function (k, obj) {
        singleUpload($(obj).find("[type='hidden']"), $(obj).data("url"), {'_token': $('meta[name="csrf-token"]').attr('content')}, 'file');
    });
}
function singleUpload(input, upload_url, options, file_key) {
    var hidden_input = $(input);
    var file_input = hidden_input.next();
    var box = file_input.parents(".admin-upload-box");
    var chose_box = box.find(".admin-upload-new");
    var progress = box.find(".am-progress-bar");
    var image_base;
    file_input.removeAttr("name");
    box.on('click', ".admin-upload-new", function () {
        if (box.attr("uploading") == undefined) {
            file_input.trigger("click");
        }
    });
    box.on('click', ".admin-upload-refresh", function () {
        if (box.attr("uploading") == undefined) {
            file_input.trigger("click");
        }
    });
    box.on('click', ".admin-upload-clear", function () {
        hidden_input.val('');
        box.removeClass("active");
        chose_box.html('点击上传文件');
    });
    file_input.on("change", function () {
        var file = $(this).prop('files')[0];
        read_file(file);
        $(this).val('');
    });
    function read_file(file) {
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            image_base = this.result;
            upload_file(file);
        }
    }

    function reset_progress() {
        progress.css("width", 0);
        box.removeClass("active").addClass("uploading");
    }

    function upload_error() {
        chose_box.html('上传失败，请重新选择文件上传');
        box.removeClass("active").removeClass("uploading");
    }

    function upload_success() {
        chose_box.html('<img src="' + image_base + '" />');
        box.addClass("active").removeClass("uploading");
    }

    function upload_file(file) {
        box.attr("uploading", true);
        reset_progress();
        var xhr = new XMLHttpRequest();
        var formData = new FormData();
        formData.append(file_key, file);//添加文件
        for (o_key in options) {
            formData.append(o_key, options[o_key]);
        }
        xhr.open('post', upload_url); // url 为提交的后台地址
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");//添加ajax头
        xhr.upload.addEventListener("progress", handle_progress, false);//处理进度条
        xhr.addEventListener("load", handle_success, false); // 处理上传完成
        xhr.addEventListener("error", handle_error, false); // 处理上传失败
        xhr.send(formData);
    }

    function handle_progress(e) {
        var percentage = e.loaded / e.total * 100;
        progress.css('width', percentage + '%');
    }

    function handle_success(e) {
        var responseText = e.currentTarget.responseText;
        if (responseText == '') {
            upload_error();
        } else {
            var result = $.parseJSON(responseText);
            if (result.key != undefined) {
                hidden_input.val(result.key);
                upload_success();
            } else {
                alert(result.error);
            }
        }
        box.removeAttr("uploading");
    }

    function handle_error() {
        upload_error();
        box.removeAttr("uploading");
    }
}

function ajaxForm($form){
    var $btn = $form.find("button[type='submit']");
    $btn.button('loading');
    toastr.clear();
    $.ajax({
        url: $form.attr("action"),
        dataType: 'json',
        type: $form.attr('method'),
        data: $form.serialize(),
        success: function (result) {
            if (result.code) {
                toastr.success(result.message, '', {positionClass: 'toast-top-center'});
                $("#modal-write-box").modal("close");
                $.pjax.reload("#content", {url: result.url});
            } else {
                toastr.error(result.message, '', {positionClass: 'toast-top-center'});
            }
            $btn.button('reset');
        },
        error: function (error) {
            console.log(error);
            switch (error.status) {
                case 422:
                    var key = Object.keys(error.responseJSON);
                    toastr.error(error.responseJSON[key[0]][0], '', {positionClass: 'toast-top-center'});
                    break;
                default:
                    toastr.error('服务器繁忙', '', {positionClass: 'toast-top-center'});
            }
            $btn.button('reset');
        }
    });
}

$(document).ready(function () {
    initPage();
    $(document).delegate("a.modal", 'click', function () {
        if ($(this).attr("target") == '_blank') {
            return true;
        }
        var $btn = $(this);
        $btn.button('loading');
        toastr.clear();
        $.ajax({
            url: $btn.attr("href"),
            success: function (html) {
                $("#modal-write-box .am-modal-bd").html(html);
                $("#modal-write-box").modal("open");
                $btn.button('reset');
            },
            error: function () {
                toastr.error('页面加载失败', '', {positionClass: 'toast-top-center'});
                $btn.button('reset');
            }
        });
        return false;
    });
    $(document).delegate("form:not([data-normal]) ", "submit", function () {
        var $form = $(this);
        if($form.is("[data-delete-confirm]")){
            $('#delete-confirm').modal({
                relatedTarget: this,
                onConfirm: function() {
                    ajaxForm($form);
                }
            });
        }else{
            ajaxForm($form);
        }
        return false;
    });
    $(".lion-sidebar-menu").delegate("span", "click", function () {
        $(".lion-sidebar-menu li").removeClass("active");
        $(this).parent().addClass("active");
    });
    $(".lion-sidebar-menu").delegate("a", "click", function () {
        $(".lion-sidebar-menu li").removeClass('current');
        $(this).parent().parent().parent().addClass("current");
        $(this).parent().addClass("current");
    });
    $(document).delegate('#product-activity-add-rule', 'click', function () {
        $("#product-activity-rules-box").append('<div class="am-g" data-product-activity-rule><div class="am-u-sm-4"><div class="am-form-group"><input type="number" name="rules[list][' + $(this).attr("data-rules") + '][winning_rate]" placeholder="请输入奖品数量"></div></div>'
            + '<div class="am-u-sm-3"><div class="am-form-group"><input type="number" name="rules[list][' + $(this).attr("data-rules") + '][rewards]" placeholder="请输入奖励数"></div></div><div class="am-u-sm-3"> <div class="am-form-group"> <input type="number" name="rules[list][' + $(this).attr("data-rules") + '][has]" value="0" readonly > </div> </div><div class="am-u-sm-2">'
            + '<button type="button" class="am-btn am-btn-danger" data-product-activity-delete-rules>删除</button></div></div>');
        $(this).attr("data-rules", (Number($(this).attr('data-rules')) + 1));
    });
    $(document).delegate('[data-product-activity-delete-rules]', "click", function () {
        if (window.confirm('您确定需要删除规则？')) {
            $(this).parents("[data-product-activity-rule]").remove();
        }
    });
    $(document).delegate("[data-activity-begin]", "dp.hide", function () {
        getProduct();
    });
    $(document).delegate("[data-activity-end]", "dp.hide", function () {
        getProduct();
    });
    function getProduct() {
        var beginTime = $("[data-activity-begin]").val();
        var endTime = $("[data-activity-end]").val();
        var select = $("[data-activity-product]");
        if (beginTime != '' && endTime != '') {
            select.attr("disabled");
            $.ajax({
                url: select.data('url'),
                type: 'post',
                data: {
                    beginTime: beginTime,
                    endTime: endTime,
                    type: $("[name='type']").val()
                },
                dataType: 'json',
                success: function (result) {
                    select.empty();
                    result.map(function (item) {
                        select.append("<option value='" + item.id + "'>" + item.model + "</option>");
                    });
                    select.removeAttr("disabled");
                }
            });
        } else {
            select.attr("disabled");
        }
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

$(document).delegate("#employee-coupon-timeType-select", "change", function () {  //有效期类型选择
    if ($(this).val() == 10) {
        $("#time-term").show();
        $("#time-length").hide();
    } else if ($(this).val() == 20) {
        $("#time-length").show();
        $("#time-term").hide();
    }
});


function checkAll(form1,status)		//全选
{
    var elements = form1.getElementsByTagName('input');
    for(var i=0; i<elements.length; i++)
    {
        if(elements[i].type == 'checkbox')
        {
            if(elements[i].checked==false){
                elements[i].checked=true;
            }
        }
    }
}

function switchAll(form1,status)			//反选
{
    var elements = form1.getElementsByTagName('input');
    for(var i=0; i<elements.length; i++)
    {
        if(elements[i].type == 'checkbox')
        {
            if(elements[i].checked==true){
                elements[i].checked=false;
            }else if(elements[i].checked==false){
                elements[i].checked=true;
            }
        }
    }
}

function fun(){
    obj = document.getElementsByName("id");
    check_val = [];
    for(k in obj){
        if(obj[k].checked)
            check_val.push(obj[k].value);
    }
    document.getElementById('for_id').value=check_val;
}


