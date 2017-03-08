@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">店铺优惠劵列表</h3>
        <a href="" class="am-btn am-btn-default am-fr am-btn-sm">刷新
        </a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>标题</th>
            <th>券类型</th>
            <th>所属店铺</th>
            <th>使用范围</th>
            <th>使用条件</th>
            <th>积分价值</th>
            <th>抵用金额</th>
            <th>折扣</th>
            <th>权重</th>
            <th>有效类型</th>
            <th>固定时长</th>
            <th>固定日期</th>
            <th>创建时间</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $coupon)
            <tr>
                <td>{{$coupon['title']}}</td>
                <td>{{$coupon['type_name']}}</td>
                <td>{{$coupon['shop_name']}}</td>
                <td>{{$coupon['scope']}}</td>
                <td>{{$coupon['condition']}}</td>
                <td>{{$coupon['integral']}}</td>
                <td>{{$coupon['money']}}</td>
                <td>{{$coupon['discount']}}</td>
                <td>{{$coupon['order']}}</td>
                <td>{{$coupon['time_type_name']}}</td>
                <td>{{$coupon['duration']}}</td>
                <td>{{$coupon['begin_time'].'至'.$coupon['begin_time']}}</td>
                <td>{{$coupon['created_at']}}</td>
                <td>{{$coupon['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.shop.page',['id'=>$coupon['id']])}}"
                       class="am-btn am-btn-warning am-btn-xs modal">权重
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection