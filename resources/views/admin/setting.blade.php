@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">系统参数设置</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <div class="am-g">
        <div class="am-u-sm-3">
            <form action="{{route('admin.setting')}}" method="post" class="am-form">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">积分兑换现金比例(多少积分换1RMB)</label>
                    <input type="number" name="{{\App\Setting::KEY_INTEGRAL_PROPORTION}}"
                           value="{{\App\Setting::integralProportion()}}" placeholder="请输入多少积分换1RMB">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">公众号二维码图片</label>
                    @widget('adminUpload',['name'=>App\Setting::KEY_WECHAT_BARCODE,'value'=>App\Setting::wechatBarcode()])
                </div>
                <button class="am-btn am-btn-primary">保存设置</button>
            </form>
        </div>
    </div>
@endsection
@section('afterJs')
    <script>
        $(function () {
            $('#doc-form-file').on('change', function () {
                var fileNames = '';
                $.each(this.files, function () {
                    fileNames += '<span class="am-badge">' + this.name + '</span> ';
                });
                $('#file-list').html(fileNames);
            });
        });
    </script>
@endsection