@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">新增/修改直营商品</h3>
    </div>
    <form method="post" class="am-form" action="">
        <div class="am-g">
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">商品名称</label>
                    <input type="text" name="name" value="{{$model['name']}}" placeholder="请输入商品名称" required>
                </div>
            </div>
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">兑换所需积分</label>
                    <input type="number" name="price" value="{{$model['price']}}" placeholder="请输入兑换所需积分"
                           required>
                </div>
            </div>
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <div class="am-form-group">
                        <label for="doc-ipt-email-1">原价</label>
                        <input type="number" name="original_price" value="{{$model['original_price']}}"
                               placeholder="请输入原价" required>
                    </div>
                </div>
            </div>
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <div class="am-form-group">
                        <label for="doc-ipt-email-1">库存数量</label>
                        <input type="number" name="inventory" value="{{$model['inventory']}}"
                               placeholder="请输入商品库存数量"
                               required>
                    </div>
                </div>
            </div>
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">预览图</label>
                    @widget('adminUpload',['name'=>'thumb','value'=>$model['thumb']])
                </div>
            </div>
            @for($i=0;$i<=4;$i++)
                <div class="am-u-sm-6">
                    <div class="am-form-group">
                        <label for="doc-ipt-email-1">详情图{{$i+1}}</label>
                        @widget('adminUpload',['name'=>'images['.$i.']','value'=>$model['images'][$i]])
                    </div>
                </div>
            @endfor
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">文字详情</label>
                    <textarea id="doc-ipt-email-1" style="height: 200px;" name="description">{{$model['description']}}</textarea>
                </div>
            </div>
            <div class="am-u-sm-12 am-text-center">
                <button class="am-btn am-btn-primary inline-block">保存</button>
                <a class="am-btn am-btn-default inline-block"
                   href="{{route('admin.direct-goods.list')}}">返回</a>
            </div>

        </div>
    </form>
@endsection