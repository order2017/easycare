@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">直营优惠劵列表</h3>
        <a href="{{route('admin.direct-coupon.page')}}" class="am-btn am-btn-secondary am-fr am-btn-sm">添加优惠券
        </a>
        <button type="button" data-am-modal="{target: '#modal-search'}"
                class="am-btn am-fr am-btn-primary am-btn-sm modal">搜索
        </button>
        <a href="" class="am-btn am-btn-default am-fr am-btn-sm">刷新
        </a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>ID</th>
            <th>缩略图</th>
            <th>标题</th>
            <th>券类型</th>
            <th>使用范围</th>
            <th>使用条件</th>
            <th>兑换所需积分</th>
            <th>抵用金额/折扣</th>
            <th>有效类型</th>
            <th>有效期</th>
            <th>创建时间</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $coupon)
            <tr>
                <td>{{$coupon['id']}}</td>
                <td class="table-image"><img src="{{$coupon['thumb_url']}}" alt=""></td>
                <td>{{$coupon['title']}}</td>
                <td>{{$coupon['type_name']}}</td>
                <td>{{$coupon['scope']}}</td>
                <td>{{$coupon['condition']}}</td>
                <td>{{$coupon['integral']}}</td>
                <td>{{$coupon['money_or_discount']}}</td>
                <td>{{$coupon['time_type_name']}}</td>
                <td>{{$coupon['time_name']}}</td>
                <td>{{$coupon['created_at']}}</td>
                <td>{{$coupon['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.direct-coupon.page',['id'=>$coupon['coupon_applies_id']])}}"
                       class="am-btn am-btn-warning am-btn-xs ">修改</a>
                    <form action="{{route('admin.direct-coupon.delete',['id'=>$coupon['id']])}}" data-delete-confirm method="post"
                          class="am-inline">
                        {{method_field('DELETE')}}
                        <button class="am-btn am-btn-danger am-btn-xs">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
<div class="am-modal am-modal-no-btn" tabindex="-1" id="modal-search">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">搜索</div>
        <div class="am-modal-bd">
            <form class="am-form" data-normal action="" method="get">
                <div class="am-form-group">
                    <label for="doc-select-1">优惠劵ID</label>
                    <input type="number" name="id" value="{{$search['id']}}" id="doc-select-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">标题</label>
                    <input type="text" name="title" value="{{$search['title']}}" id="doc-ipt-email-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">使用范围</label>
                    <input type="text" name="scope" value="{{$search['scope']}}" id="doc-ipt-email-1">
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>
