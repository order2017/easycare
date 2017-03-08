@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">积分记录</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        <button type="button" data-am-modal="{target: '#modalinte-search'}"
                class="am-btn am-fr am-btn-primary am-btn-sm modal">搜索
        </button>
        <a href="{{route('admin.record.export')}}" class="am-btn am-fr am-btn-sm am-btn-success modal" target="_blank">导出数据</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>交易流水号</th>
            <th>用户ID</th>
            <th>积分</th>
            <th>来源条码</th>
            <th>参与活动</th>
            <th>中奖规则</th>
            <th>消费订单</th>
            <th>发放后用户余额</th>
            <th>备注</th>
            <th>创建时间</th>
            <th>发放状态</th>
            <th>发放时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $task)
            <tr>
                <td>{{$task['serial_number']}}</td>
                <td>{{$task['user']['id']}}</td>
                <td>{{$task['numerical']}}</td>
                <td>{{$task['barcode']['serial_number']}}</td>
                <td>{{$task['product_activity']}}</td>
                <td>{{$task['product_activity_rule']}}</td>
                <td>{{$task['order']}}</td>
                <td>{{$task['balance']}}</td>
                <td>{{$task['remark']}}</td>
                <td>{{$task['created_at']}}</td>
                <td>{{$task['status_text']}}</td>
                <td>{{$task['updated_at']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection

<div class="am-modal am-modal-no-btn" tabindex="-1" id="modalinte-search">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">搜索</div>
        <div class="am-modal-bd">
            <form class="am-form" data-normal action="" method="get">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">交易流水号</label>
                    <input type="text" name="serial_number" value="{{$search['serial_number']}}" id="doc-ipt-email-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">创建时间</label>
                    <input type="text" name="created_at" value="{{$search['created_at']}}" id="doc-ipt-email-1">
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>