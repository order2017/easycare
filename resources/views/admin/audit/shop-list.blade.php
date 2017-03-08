@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">待审核店铺列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>店名</th>
            <th>联系电话</th>
            <th>所属老板</th>
            <th>所属省份</th>
            <th>所属城市</th>
            <th>所属县镇</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $shop)
            <tr>
                <td>{{$shop['name']}}</td>
                <td>{{$shop['phone']}}</td>
                <td>{{$shop['boss_name']}}</td>
                <td>{{$shop['province_name']}}</td>
                <td>{{$shop['city_name']}}</td>
                <td>{{$shop['county_name']}}</td>
                <td>{{$shop['created_at']}}</td>
                <td>{{$shop['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.audits.shop.page',['id'=>$shop['id']])}}"
                       class="am-btn am-btn-xs am-btn-secondary modal">审核</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection