@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">标签扫描记录</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        <a href="" data-toggle="modal"
           class="am-btn am-btn-secondary am-fr am-btn-sm">搜索
        </a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>二维码序列号</th>
            <th>用户ID</th>
            <th>用户名</th>
            <th>产品名</th>
            <th>类型</th>
            <th>创建时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $task)
            <tr>
                <td>{{$task['barcode']['serial_number']}}</td>
                <td>{{$task['user']['id']}}</td>
                <td>{{$task['user']['name']}}</td>
                <td>{{$task['barcode']['product_name']}}</td>
                <td>{{$task['verify_type']}}</td>
                <td>{{$task['created_at']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection
