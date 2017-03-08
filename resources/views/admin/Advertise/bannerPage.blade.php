@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">新增/修改广告图</h3>
    </div>
    <form method="post" class="am-form" action="{{route('admin.banner.page',['id'=>$model['id']])}}">
        <div class="am-g">
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">展示位置</label>
                    <select name="type">
                        @foreach(\App\Advertising::typeLabelList() as $key=>$type)
                            <option value="{{$key}}" @if($model['type'] == $key) selected @endif>{{$type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">图片</label>
                    @widget('adminUpload',['name'=>'image','value'=>$model['image']])
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">URL</label>
                    <input type="text" name="link" value="{{$model['link']}}" placeholder="请输入链接地址" required>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">排序</label>
                    <input type="number" name="order" value="{{$model['order']}}" placeholder="请输入排序权重" required>
                </div>
                <div class="am-u-sm-6 am-text-center">
                    <button type="submit" class="am-btn am-btn-primary">保存</button>
                    <a class="am-btn am-btn-warning" href="{{route('admin.banner')}}">返回</a>
                </div>
            </div>

        </div>
    </form>
@endsection