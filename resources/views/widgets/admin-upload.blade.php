<div class="admin-upload-box @if(!empty($value)) active @endif" data-url="{{route('admin.widget.upload')}}">
    <div class="admin-upload-new">
        @if(!empty($value))
            <img src="{{route('widget.images',['name'=>$value])}}" alt="">
        @else
            点击上传图片
        @endif
    </div>
    <div class="am-progress am-progress-sm">
        <div class="am-progress-bar"></div>
    </div>
    <input type="hidden" name="{{$name}}" value="{{$value}}">
    <input type="file">
    <div class="admin-upload-action">
        <button class="am-btn am-btn-success admin-upload-refresh" type="button">重新上传</button>
        <button class="am-btn am-btn-danger admin-upload-clear" type="button">删除</button>
    </div>
</div>