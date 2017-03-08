@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">会员店铺收藏列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>ID</th>
            <th>用户姓名</th>
            <th>店铺名称</th>
            <th>店铺介绍</th>
            <th>店铺地址</th>
            <th>创建时间</th>
            <th>修改时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $user)
            <tr>
                <td>{{$user['user']['id']}}</td>
                <td>{{$user['user']['name']}}</td>
                <td>{{$user['shop_name']}}</td>
                <td>{{$user['intro']}}</td>
                <td>{{$user['shop_address']}}</td>
                <td>{{$user['created_at']}}</td>
                <td>{{$user['updated_at']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection