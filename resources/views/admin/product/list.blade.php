@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">产品列表</h3>
        <a href="{{route('admin.product.page')}}" class="am-btn am-btn-secondary am-fr am-btn-sm modal">添加产品
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
            <th>产品型号</th>
            <th>产品名称</th>
            <th>基础积分</th>
            <th>基础佣金</th>
            <th>创建时间</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $product)
            <tr>
                <td>{{$product['model']}}</td>
                <td>{{$product['name']}}</td>
                <td>{{$product['integral']}}</td>
                <td>{{$product['commission']}}</td>
                <td>{{$product['created_at']}}</td>
                <td>{{$product['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.product.page',['id'=>$product['id']])}}"
                       class="am-btn am-btn-warning am-btn-xs modal">修改</a>
                    <form action="{{route('admin.product.delete',['id'=>$product['id']])}}" data-delete-confirm
                          method="post"
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
                    <label for="doc-select-1">产品型号</label>
                    <input type="number" name="model" value="{{$search['model']}}" id="doc-select-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">产品名称</label>
                    <input type="text" name="name" value="{{$search['name']}}" id="doc-ipt-email-1">
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>
