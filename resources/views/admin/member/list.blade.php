@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">会员列表</h3>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
        <a href="{{route('admin.member.import')}}" class="am-btn am-fr am-btn-sm am-btn-success">从微信导入</a>
        <button type="button" data-am-modal="{target: '#modalcxl-search'}"
                class="am-btn am-fr am-btn-primary am-btn-sm modal">搜索
        </button>
        <a href="{{route('admin.member.export')}}" class="am-btn am-fr am-btn-sm am-btn-success modal" target="_blank">导出数据</a>
    </div>
    <div class="lion-content-header" style="border-bottom: none; padding-bottom:0;">
        <a href="javascript:" class="am-btn am-btn-warning am-btn-xs " onclick="checkAll(form1,status)">全选</a>
        <a href="javascript:" class="am-btn am-btn-warning am-btn-xs " onclick="switchAll(form1,status)">反选</a>
        <form action="{{route('admin.member.fore')}}"  method="post" class="am-inline">
            <input type="hidden" name="idd[]" id="for_id" value="">
            <button class="am-btn am-btn-warning am-btn-xs" onclick="fun()" >批量禁用</button>
        </form>
    </div>
    <div id="form1">
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>姓名</th>
            <th>性别</th>
            <th>生日</th>
            <th>手机号码</th>
            <th>孩子姓名</th>
            <th>孩子性别</th>
            <th>孩子生日</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $user)
            <tr>
                <td><input type="checkbox" name="id" value="{{$user['id']}}" ></td>
                <td>{{$user['id']}}</td>
                <td>{{$user['name']}}</td>
                <td>{{$user['sex_text']}}</td>
                <td>{{$user['birthday']}}</td>
                <td>{{$user['mobile']}}</td>
                <td>{{$user['childName']}}</td>
                <td>{{$user['childSex_text']}}</td>
                <td>{{$user['childBirthday']}}</td>
                <td>{{$user['created_at']}}</td>
                <td>{{$user['updated_at']}}</td>
                <td>
                    @if($user->status==20)
                            <button class="am-btn am-btn-default am-btn-xs">禁用</button>
                        @else
                            <form action="{{route('admin.member.forbidden',['id'=>$user['id'],'parameter'=>1])}}"  method="get" class="am-inline">
                                <button class="am-btn am-btn-warning am-btn-xs">禁用</button>
                            </form>
                    @endif
                    @if($user->status==10)
                            <button class="am-btn am-btn-default am-btn-xs">解除</button>
                        @else
                            <form action="{{route('admin.member.forbidden',['id'=>$user['id'],'parameter'=>2])}}"  method="get" class="am-inline">
                                <button class="am-btn am-btn-danger am-btn-xs">解除</button>
                            </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    {!! $list->render() !!}
@endsection
<div class="am-modal am-modal-no-btn" tabindex="-1" id="modalcxl-search">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">搜索</div>
        <div class="am-modal-bd">
            <form class="am-form" data-normal action="" method="get">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">姓名</label>
                    <input type="text" name="name" value="{{$search['name']}}" id="doc-ipt-email-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">孩子姓名</label>
                    <input type="text" name="childName" value="{{$search['childName']}}" id="doc-ipt-email-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">手机号</label>
                    <input type="text" name="mobile" value="{{$search['mobile']}}" id="doc-ipt-email-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">生日</label>
                    <input type="text" name="birthday" value="{{$search['birthday']}}" id="doc-ipt-email-1">
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">孩子生日</label>
                    <input type="text" name="childBirthday" value="{{$search['childBirthday']}}" id="doc-ipt-email-1">
                </div>
                <button type="submit" class="am-btn am-btn-primary am-btn-block">搜索</button>
                <button type="button" class="am-btn am-btn-default  am-btn-block" data-am-modal-close>取消</button>
            </form>
        </div>
    </div>
</div>