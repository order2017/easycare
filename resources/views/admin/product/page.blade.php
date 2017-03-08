<form class="am-form " action="{{route('admin.product.page',['id'=>$model['id']])}}" method="post">
    <div class="am-form-group">
        <label for="doc-select-1">产品型号</label>
        <input type="number" name="model" value="{{$model['model']}}" placeholder="请输入产品型号" required>
    </div>
    <div class="am-form-group">
        <label for="doc-ipt-email-1">产品名称</label>
        <input type="text" name="name" value="{{$model['name']}}" placeholder="请输入产品名称" required>
    </div>
    <div class="am-form-group">
        <label for="doc-ipt-email-1">基础积分</label>
        <input type="number" name="integral" value="{{$model['integral']}}" placeholder="请输入基础积分" required>
    </div>
    <div class="am-form-group">
        <label for="doc-ipt-email-1">基础佣金</label>
        <input type="number" name="commission" value="{{$model['commission']}}" placeholder="请输入基础佣金" step="0.01"
               required>
    </div>
    <button type="submit" class="am-btn am-btn-primary">保存</button>
    <button type="button" class="am-btn am-btn-warning" data-am-modal-close>取消</button>
</form>