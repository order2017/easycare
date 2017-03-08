@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">消息推送记录</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        {{--<a href="" data-toggle="modal"--}}
        {{--class="am-btn am-btn-secondary am-fr am-btn-sm">搜索--}}
        {{--</a>--}}
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>推送编号</th>
            <th>消息ID</th>
            <th>消息内容</th>
            <th>推送渠道</th>
            <th>推送时间</th>
            <th>目标信息</th>
            <th>推送反馈</th>
            <th>状态</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $line)
            <tr>
                <td>{{$line['serial_number']}}</td>
                <td>{{$line['message_id']}}</td>
                <td>{{$line['message']['title']}}</td>
                <td>{{$line['send_method_text']}}</td>
                <td>{{$line['created_at']}}</td>
                <td>{{$line['to']}}</td>
                <td>{{$line['wechat_msg_id']}}</td>
                <td>{{$line['status']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection
