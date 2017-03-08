<form class="am-form" action="{{route('admin.department.page',['id'=>$model['id']])}}" method="post">
    <div class="am-form-group">
        <label for="doc-ipt-email-1">部门名称</label>
        <input type="text" name="name" placeholder="请输入部门名称" value="{{$model['name']}}">
    </div>
    <button type="submit" class="am-btn am-btn-primary">保存</button>
    <button type="button" class="am-btn am-btn-default" data-am-modal-close>取消</button>
</form>