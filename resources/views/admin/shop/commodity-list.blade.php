@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">店铺商品列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>商品名</th>
            <th>现价</th>
            <th>原价</th>
            <th>权重</th>
            <th>产品介绍</th>
            <th>所属店铺</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $goods)
            <tr>
                <td>{{$goods['name']}}</td>
                <td>{{$goods['price']}}</td>
                <td>{{$goods['original_price']}}</td>
                <td>{{$goods['order']}}</td>
                <td>{{$goods['intro']}}</td>
                <td>{{$goods['shop_name']}}</td>
                <td>{{$goods['created_at']}}</td>
                <td>{{$goods['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.shop.commodity.page',['id'=>$goods['id']])}}"
                       class="am-btn am-btn-warning am-btn-xs modal">权重
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection