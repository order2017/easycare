@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">标签扫描记录</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        {{--<a href="" data-toggle="modal"--}}
        {{--class="am-btn am-btn-secondary am-fr am-btn-sm">搜索--}}
        {{--</a>--}}
        <button type="button" data-am-modal="{target: '#modalbarcode-search'}"
                class="am-btn am-fr am-btn-primary am-btn-sm modal">搜索
        </button>
        <a href="{{route('admin.record.exportbarcode')}}" class="am-btn am-fr am-btn-sm am-btn-success modal" target="_blank">导出数据</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>条码编号</th>
            <th>用户ID</th>
            <th>扫描类型</th>
            <th>扫描时间</th>
            <th>是否已关注</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $line)
            <tr>
                <td>{{$line['barcode']['serial_number']}}</td>
                <td>{{$line['user']['id']}}</td>
                <td>{{$line['verify_type_text']}}</td>
                <td>{{$line['verified_at']}}</td>
                <td>{{$line['is_subscribe_text']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection

<div class="am-modal am-modal-no-btn" tabindex="-1" id="modalbarcode-search">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">搜索</div>
        <div class="am-modal-bd">
            <form class="am-form" data-normal action="" method="get">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">扫描时间</label>
                    <input type="text" name="verified_at" value="{{$search['verified_at']}}" id="doc-ipt-email-1">
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>