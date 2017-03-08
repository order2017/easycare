@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">员工列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机</th>
            <th>工作地址</th>
            <th>所属部门</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $line)
            <tr>
                <td>{{$line['name']}}</td>
                <td>{{$line['mobile']}}</td>
                <td>{{$line['full_address']}}</td>
                <td>{{$line['department_name']}}</td>
                <td>{{$line['status_text']}}</td>
                <td>{{$line['created_at']}}</td>
                <td>{{$line['updated_at']}}</td>
                <td>

                    <a href="{{route('admin.employee.page',['id'=>$line['id']])}}"
                       class="am-btn am-btn-warning am-btn-xs modal">迁移
                    </a>

                    @if($line['is_leave'])
                        <form action="{{route('admin.employee.list',['id'=>$line['id'],'parameter'=>2])}}"  method="get" class="am-inline">
                            <button class="am-btn am-btn-xs am-btn-danger">复职</button>
                        </form>
                    @else
                        <form action="{{route('admin.employee.list',['id'=>$line['id'],'parameter'=>1])}}"  method="get" class="am-inline">
                            <button class="am-btn am-btn-xs am-btn-success">离职</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection