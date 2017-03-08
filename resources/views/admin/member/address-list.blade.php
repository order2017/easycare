@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">收货地址列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>ID</th>
            <th>联系人</th>
            <th>联系电话</th>
            <th>省份</th>
            <th>城市</th>
            <th>镇区街道</th>
            <th>详细地址</th>
            <th>创建时间</th>
            <th>修改时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $user)
            <tr>
                <td>{{$user['id']}}</td>
                <td>{{$user['contact']}}</td>
                <td>{{$user['phone']}}</td>
                <td>{{$user['province_name']}}</td>
                <td>{{$user['city_name']}}</td>
                <td>{{$user['county_name']}}</td>
                <td>{{$user['address']}}</td>
                <td>{{$user['created_at']}}</td>
                <td>{{$user['updated_at']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection@extends('layouts.admin')