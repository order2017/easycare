@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">待审核导购列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        <button type="button" data-am-modal="{target: '#modal-searchshop'}"
                class="am-btn am-fr am-btn-primary am-btn-sm modal">搜索
        </button>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机号码</th>
            <th>所属老板</th>
            <th>所属区域</th>
            <th>所属员工</th>
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
                <td>{{$user['boss_name']}}</td>
                <td>{{$user['region']}}</td>
                <td>{{$user['employee_name']}}</td>
                <td>{{$user['created_at']}}</td>
                <td>{{$user['updated_at']}}</td>
                <td>
                    <form action="{{route('admin.sale.delete',['id'=>$user['user_id']])}}" data-delete-confirm
                          method="post"
                          class="am-inline">
                        {{method_field('DELETE')}}
                        <button class="am-btn am-btn-danger am-btn-xs">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection
<div class="am-modal am-modal-no-btn" tabindex="-1" id="modal-searchshop">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">搜索</div>
        <div class="am-modal-bd">
            <form class="am-form" data-normal action="" method="get">
                <div class="am-form-group">
                    <label for="doc-select-1">姓名</label>
                    <input type="text" name="name" value="{{$search['name']}}" id="doc-select-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">手机号</label>
                    <input type="text" name="mobile" value="{{$search['mobile']}}" id="doc-ipt-email-1">
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>