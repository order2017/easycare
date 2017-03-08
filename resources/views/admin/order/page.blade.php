<div class="am-modal-hd">请输入快递单号</div>
<form class="am-form " action="{{route('admin.order.page',['id'=>$model['id']])}}" method="post">
    <div class="am-form-group">
        <input type="text" name="number" value="{{$model['number']}}" placeholder="请输入快递单号" required>
    </div>
    <button type="submit" class="am-btn am-btn-primary">保存</button>
    <button type="button" class="am-btn am-btn-warning" data-am-modal-close>取消</button>
</form>