<div class="am-modal-hd">权重</div>
<form class="am-form " action="{{route('admin.shop.page',['id'=>$model['id']])}}" method="post">
    <div class="am-form-group">
        <input type="number" name="order" value="{{$model['order']}}" placeholder="请输入权重号" required>
    </div>
    <button type="submit" class="am-btn am-btn-primary">保存</button>
    <button type="button" class="am-btn am-btn-warning" data-am-modal-close>取消</button>
</form>