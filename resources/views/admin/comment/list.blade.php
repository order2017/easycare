@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">订单评论列表</h3>
        <a href="" class="am-btn am-btn-default am-fr am-btn-sm">刷新
        </a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>订单号</th>
            <th>评论内容</th>
            <th>用户评分</th>
            <th>评论时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $order)
            <tr>
                <td>{{$order['order']['order_number']}}</td>
                <td>{{$order['content']}}</td>
                <td>{{$order['point']}}</td>
                <td>{{$order['created_at']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection