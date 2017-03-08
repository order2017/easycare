@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">会员红包活动管理</h3>
        <a href="{{route('admin.activity.red-packet.page')}}" class="am-btn am-btn-secondary am-fr am-btn-sm">新增活动
        </a>
        <a href="" class="am-btn am-btn-default am-fr am-btn-sm">刷新
        </a>
        <button type="button" data-am-modal="{target: '#modalhb-search'}"
                class="am-btn am-fr am-btn-primary am-btn-sm modal">搜索
        </button>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>活动名称</th>
            <th>发放方式</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>奖励最小值</th>
            <th>奖励最大值</th>
            <th>已参加人数</th>
            <th>创建时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $line)
            <tr>
                <td>{{$line['title']}}</td>
                <td>{{$line['send_method_name']}}</td>
                <td>{{$line['begin_time']}}</td>
                <td>{{$line['end_time']}}</td>
                <td>{{$line['min']}}RMB</td>
                <td>{{$line['max']}}RMB</td>
                <td>{{$line['has_join_num']}}</td>
                <td>{{$line['created_at']}}</td>
                <td>{{$line['status_text']}}</td>
                <td>
                    <a href="{{route('admin.activity.red-packet.page',['id'=>$line['id']])}}"
                       class="am-btn am-btn-success am-btn-xs">修改</a>
                    <form action="{{route('admin.activity.red-packet.up-or-down',['id'=>$line['id']])}}" method="post"
                          class="am-inline">
                        {{method_field('PUT')}}
                        @if($line['is_down'])
                            <button class="am-btn am-btn-warning am-btn-xs">上架</button>
                        @else
                            <button class="am-btn am-btn-warning am-btn-xs">下架</button>
                        @endif
                    </form>
                    <form action="{{route('admin.activity.red-packet.delete',['id'=>$line['id']])}}" method="post"
                          class="am-inline" data-delete-confirm>
                        {{method_field('DELETE')}}
                        <button class="am-btn am-btn-danger am-btn-xs">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
<div class="am-modal am-modal-no-btn" tabindex="-1" id="modalhb-search">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">搜索</div>
        <div class="am-modal-bd">
            <form class="am-form" data-normal action="" method="get">
                <div class="am-form-group">
                    <label for="doc-select-1">活动名称</label>
                    <input type="text" name="title" value="{{$search['title']}}" id="doc-select-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">产品型号</label>
                    <select id="doc-select-1" name="products">
                        <option selected value="">请选择产品型号</option>
                        @foreach($products as $product)
                            <option value="{{$product['id']}}">{{$product['model']}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>