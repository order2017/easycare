@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">管理员列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-primary model"
           data-toggle='page'>新增</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>账号</th>
            <th>姓名</th>
            <th>手机</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $line)
            <tr>
                <td>{{$line['username']}}</td>
                <td>{{$line['name']}}</td>
                <td>{{$line['mobile']}}</td>
                <td>{{$line['status_text']}}</td>
                <td>{{$line['created_at']}}</td>
                <td>{{$line['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.administrator.page',['id'=>$line['id']])}}" class="am-btn am-btn-xs am-btn-success modal">编辑</a>
                    <a href="" class="am-btn am-btn-xs am-btn-secondary">权限配置</a>
                    @if($line['is_lock'])
                        <a href="" class="am-btn am-btn-xs am-btn-danger">解冻</a>
                    @else
                        <a href="" class="am-btn am-btn-xs am-btn-danger">冻结</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection