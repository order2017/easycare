@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">消息记录</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        {{--<a href="" data-toggle="modal"--}}
        {{--class="am-btn am-btn-secondary am-fr am-btn-sm">搜索--}}
        {{--</a>--}}
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>消息内容</th>
            <th>接收用户ID</th>
            <th>消息类型</th>
            <th>发送时间</th>
            <th>发送渠道</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $line)
            <tr>
                <td>{{$line['title']}}</td>
                <td>{{$line['to_user_id']}}</td>
                <td>{{$line['type_text']}}</td>
                <td>{{$line['created_at']}}</td>
                <td>{{$line['send_type_text']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection
