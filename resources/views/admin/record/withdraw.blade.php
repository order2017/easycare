@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">提现记录</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        {{--<a href="" data-toggle="modal"--}}
           {{--class="am-btn am-btn-secondary am-fr am-btn-sm">搜索--}}
        {{--</a>--}}
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>交易流水号</th>
            <th>用户ID</th>
            <th>提现积分</th>
            <th>兑换金额</th>
            <th>兑换比例</th>
            <th>微信订单号</th>
            <th>创建时间</th>
            <th>发放状态</th>
            <th>发放时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $line)
            <tr>
                <td>{{$line['serial_number']}}</td>
                <td>{{$line['user']['id']}}</td>
                <td>{{$line['integral']}}</td>
                <td>{{$line['money']}}</td>
                <td>{{$line['proportion']}}</td>
                <td>{{$line['wechat_order_number']}}</td>
                <td>{{$line['created_at']}}</td>
                <td>{{$line['status_text']}}</td>
                <td>{{$line['updated_at']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection
