<div class="am-modal-hd">编辑管理员信息</div>
<form class="am-form " action="{{route('admin.administrator.page',['id'=>$model['id']])}}" method="post">

    <div class="am-form-group">
        <label for="doc-select-1">账号</label>
        <input type="text" name="username" value="{{$model['username']}}" placeholder="请输入账号" required disabled="true">
    </div>

    <div class="am-form-group">
        <label for="doc-select-1">姓名</label>
        <input type="text" name="name" value="{{$model['name']}}" placeholder="请输入姓名" required>
    </div>

    <div class="am-form-group">
        <label for="doc-select-1">手机</label>
        <input type="text" name="mobile" value="{{$model['mobile']}}" placeholder="请输入手机" required>
    </div>

    <button type="submit" class="am-btn am-btn-primary">保存</button>
    <button type="button" class="am-btn am-btn-warning" data-am-modal-close>取消</button>
</form>