@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">直营商品列表</h3>
        <a href="{{route('admin.direct-goods.page')}}" class="am-btn am-btn-secondary am-fr am-btn-sm">添加商品
        </a>
        <button type="button" data-am-modal="{target: '#modal-search'}"
                class="am-btn am-fr am-btn-primary am-btn-sm modal">搜索
        </button>
        <a href="" class="am-btn am-btn-default am-fr am-btn-sm">刷新
        </a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>ID</th>
            <th>缩略图</th>
            <th>商品名称</th>
            <th>原积分</th>
            <th>现积分</th>
            <th>库存</th>
            <th>创建时间</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $goods)
            <tr>
                <td>{{$goods['id']}}</td>
                <td class="table-image"><img src="{{$goods['thumbUrl']}}" alt=""></td>
                <td>{{$goods['name']}}</td>
                <td>{{$goods['price']}}</td>
                <td>{{$goods['original_price']}}</td>
                <td>{{$goods['inventory']}}</td>
                <td>{{$goods['created_at']}}</td>
                <td>{{$goods['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.direct-goods.page',['id'=>$goods['goods_apply_id']])}}"
                       class="am-btn am-btn-warning am-btn-xs">修改</a>
                    <form action="{{route('admin.direct-goods.delete',['id'=>$goods['id']])}}" data-delete-confirm method="post"
                          class="am-inline">
                        {{method_field('DELETE')}}
                        <button class="am-btn am-btn-danger am-btn-xs">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
<div class="am-modal am-modal-no-btn" tabindex="-1" id="modal-search">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">搜索</div>
        <div class="am-modal-bd">
            <form class="am-form" data-normal action="" method="get">
                <div class="am-form-group">
                    <label for="doc-select-1">商品ID</label>
                    <input type="number" name="id" value="{{$search['id']}}" id="doc-select-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">商品名称</label>
                    <input type="text" name="name" value="{{$search['name']}}" id="doc-ipt-email-1">
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>
