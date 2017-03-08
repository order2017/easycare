@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">部门列表</h3>
        <a href="{{route('admin.department.page')}}" class="am-btn am-fr am-btn-sm am-btn-secondary modal">添加</a>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default">刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>名称</th>
            <th>创建时间</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $line)
            <tr>
                <td>{{$line['name']}}</td>
                <td>{{$line['created_at']}}</td>
                <td>{{$line['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.department.page',['id'=>$line['id']])}}"
                       class="am-btn am-btn-xs am-btn-primary modal">编辑</a>
                    <form action="{{route('admin.department.delete',['id'=>$line['id']])}}" data-delete-confirm method="post"
                          class="am-inline">
                        {{method_field('delete')}}
                        <button class="am-btn am-btn-xs am-btn-danger">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection