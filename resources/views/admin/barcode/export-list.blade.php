@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">标签导出任务列表</h3>
        <a href="{{route('admin.generate-barcode-task.list')}}"
           class="am-btn am-btn-secondary am-fr am-btn-sm">新建任务
        </a>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>产品型号</th>
            <th>包装规格</th>
            <th>包装箱数</th>
            <th>总数</th>
            <th>已完成</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>开始时间</th>
            <th>完成时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $task)
            <tr>
                <td>{{$task['generate']['product_model']}}</td>
                <td>{{$task['generate']['box_unit']}}</td>
                <td>{{$task['generate']['box_num']}}</td>
                <td>{{$task['total']}}</td>
                <td>{{$task['finish_num']}}</td>
                <td>{{$task['status_text']}}</td>
                <td>{{$task['created_at']}}</td>
                <td>{{$task['running_at']}}</td>
                <td>{{$task['finished_at']}}</td>
                <td>
                    @if($task['is_finish'])
                        <a href="{{route('admin.export-barcode-task.download',['id'=>$task['id']])}}" target="_blank"
                           class="am-btn am-btn-xs am-btn-success">下载</a>
                    @endif
                    @if($task['is_running'] || $task['is_wait'])
                        <form class="am-inline"
                              action="{{route('admin.export-barcode-task.cancel',['id'=>$task['id']])}}" method="post">
                            {{method_field('DELETE')}}
                            <button class="am-btn am-btn-xs am-btn-danger">取消</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection