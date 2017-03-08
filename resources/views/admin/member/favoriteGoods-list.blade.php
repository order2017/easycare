@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">会员商品收藏列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>ID</th>
            <th>用户姓名</th>
            <th>商品ID</th>
            <th>商品名称</th>
            <th>商品介绍</th>
            <th>创建时间</th>
            <th>修改时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $user)
            <tr>
                <td>{{$user['user']['id']}}</td>
                <td>{{$user['user']['name']}}</td>
                <td>{{$user['goods_id']}}</td>
                <td>{{$user['goods_name']}}</td>
                <td>{{$user['goods_intro']}}</td>
                <td>{{$user['created_at']}}</td>
                <td>{{$user['updated_at']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection