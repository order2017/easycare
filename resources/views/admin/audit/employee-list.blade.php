@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">待审核员工列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机号码</th>
            <th>电子邮箱</th>
            <th>所属省份</th>
            <th>所属城市</th>
            <th>所属县镇</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $user)
            <tr>
                <td>{{$user['name']}}</td>
                <td>{{$user['mobile']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{$user['province_name']}}</td>
                <td>{{$user['city_name']}}</td>
                <td>{{$user['county_name']}}</td>
                <td>{{$user['created_at']}}</td>
                <td>{{$user['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.audits.employee.page',['id'=>$user['id']])}}"
                       class="am-btn am-btn-xs am-btn-secondary modal">审核</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection