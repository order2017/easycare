<div class="am-modal-hd">批量作废</div>
<form class="am-form" action="{{route('admin.generate-barcode-cancel.page')}}" method="post">
    <div class="am-form-group">
        <label for="doc-select-1">产品型号</label>
        <select id="doc-select-1" name="product_id">
            <option selected value="">请选择产品型号</option>
            @foreach($products as $product)
                <option value="{{$product['id']}}">{{$product['model']}}</option>
            @endforeach
        </select>
        <span class="am-form-caret"></span>
    </div>
    <div class="am-form-group">
        <label for="doc-select-1">任务状态</label>
        <select id="doc-select-1" name="id">
            <option selected value="">请选择任务产品型号</option>
            @foreach($generate as $generate)
                <option value="{{$generate['id']}}">{{$generate['product_model']}}</option>
            @endforeach
        </select>
        <span class="am-form-caret"></span>
    </div>
    <button type="submit" class="am-btn am-btn-primary">确定</button>
    <button type="button" class="am-btn am-btn-default" data-am-modal-close>取消</button>
</form>