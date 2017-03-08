@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">订单列表</h3>
        <a href="" class="am-btn am-btn-default am-fr am-btn-sm">刷新
        </a>
        <button type="button" data-am-modal="{target: '#modalorder-search'}"
                class="am-btn am-fr am-btn-primary am-btn-sm modal">搜索
        </button>
        <a href="{{route('admin.order.export')}}" class="am-btn am-fr am-btn-sm am-btn-success modal" target="_blank">导出数据</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>订单号</th>
            <th>订单状态</th>
            <th>快递单号</th>
            <th>用户名称</th>
            <th>商品名称</th>
            <th>所属店铺</th>
            <th>积分</th>
            <th>购买时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $order)
            <tr>
                <td>{{$order['order_number']}}</td>
                <td>{{$order['order_type']}}</td>
                <td>{{$order['number']}}</td>
                <td>{{$order['user']['name']}}</td>
                <td>{{$order['goods']['name']}}</td>
                <td>{{$order['shop_name']}}</td>
                <td>{{$order['goods']['price']}}</td>
                <td>{{$order['created_at']}}</td>
                <td>
                    <a href="{{route('admin.order.page',['id'=>$order['id']])}}"
                       class="am-btn am-btn-warning am-btn-xs modal">输入运单号
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

<div class="am-modal am-modal-no-btn" tabindex="-1" id="modalorder-search">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">搜索</div>
        <div class="am-modal-bd">
            <form class="am-form" data-normal action="" method="get">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">订单号</label>
                    <input type="text" name="order_number" value="{{$search['order_number']}}" id="doc-ipt-email-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">购买时间</label>
                    <input type="text" name="created_at" value="{{$search['created_at']}}" id="doc-ipt-email-1">
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>