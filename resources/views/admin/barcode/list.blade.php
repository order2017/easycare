@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">标签列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        <button type="button" data-am-modal="{target: '#modalcxlb-search'}"
                class="am-btn am-fr am-btn-primary am-btn-sm modal">搜索
        </button>
        <a href="{{route('admin.generate-barcode-cancel.page')}}"
           class="am-btn am-btn-secondary am-fr am-btn-sm modal">批量作废
        </a>
        <a href="{{route('admin.barcode.export')}}" class="am-btn am-fr am-btn-sm am-btn-success modal" target="_blank">导出数据</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>产品型号</th>
            <th>条形码</th>
            <th>佣金状态</th>
            <th>佣金次数</th>
            <th>佣金数目</th>
            <th>佣金首次时间</th>
            <th>佣金领取人</th>
            <th>积分状态</th>
            <th>积分次数</th>
            <th>积分数目</th>
            <th>积分首次时间</th>
            <th>积分领取人</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $task)
            <tr>
                <td>{{$task['product']['model']}}</td>
                <td>{{$task['serial_number']}}</td>
                <td>{{$task['commission_status_text']}}</td>
                <td>{{$task['commission_verify_times']}}</td>
                <td>{{$task['commission_send_number']}}</td>
                <td>{{$task['commission_first_time']}}</td>
                <td>{{$task['commission_used_user']}}</td>
                <td>{{$task['integral_status_text']}}</td>
                <td>{{$task['integral_verify_times']}}</td>
                <td>{{$task['integral_send_number']}}</td>
                <td>{{$task['integral_first_time']}}</td>
                <td>{{$task['integral_used_user']}}</td>
                <td>{{$task['created_at']}}</td>
                <td>
                    <form action="{{route('admin.barcode.cancel',['id'=>$task['id']])}}"  method="get" class="am-inline">
                        <button class="am-btn am-btn-danger am-btn-xs">作废</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection
<div class="am-modal am-modal-no-btn" tabindex="-1" id="modalcxlb-search">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">搜索</div>
        <div class="am-modal-bd">
            <form class="am-form" data-normal action="" method="get">
                <div class="am-form-group">
                    <label for="doc-select-1">产品型号</label>
                    <select id="doc-select-1" name="product_id">
                        <option selected value="0">请选择产品型号</option>
                        @foreach($products as $product)
                            <option value="{{$product['id']}}">{{$product['model']}}</option>
                        @endforeach
                    </select>
                    <span class="am-form-caret"></span>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">条形码</label>
                    <input type="text" name="serial_number" value="{{$search['serial_number']}}" id="doc-ipt-email-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">佣金领取人</label>
                    <input type="text" name="commission_used_user" value="" id="doc-ipt-email-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">积分领取人</label>
                    <input type="text" name="integral_used_user" value="" id="doc-ipt-email-1">
                </div>

                <div class="am-form-group">
                    <label for="doc-select-1">佣金状态</label>
                    <select id="doc-select-1" name="commission_status">
                        <option selected value="0">请选择佣金状态</option>
                        @foreach($status as $commission)
                            <option value="{{$commission['stname']}}">{{$commission['stname']}}</option>
                        @endforeach
                    </select>
                    <span class="am-form-caret"></span>
                </div>

                <div class="am-form-group">
                    <label for="doc-select-1">积分状态</label>
                    <select id="doc-select-1" name="integral_status">
                        <option selected value="0">请选择积分状态</option>
                        @foreach($status as $integral)
                            <option value="{{$integral['stname']}}">{{$integral['stname']}}</option>
                        @endforeach
                    </select>
                    <span class="am-form-caret"></span>
                </div>

                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>