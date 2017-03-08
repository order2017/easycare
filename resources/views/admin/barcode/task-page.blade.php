<form class="am-form" action="{{route('admin.generate-barcode-task.page')}}" method="post">
    <div class="am-form-group">
        <label for="doc-select-1">产品型号</label>
        <select id="doc-select-1" name="product_id">
            <option selected value="0">请选择产品型号</option>
            @foreach($products as $product)
                <option value="{{$product['id']}}">{{$product['model']}}</option>
            @endforeach
        </select>
        <span class="am-form-caret"></span>
    </div>
    <div class="am-form-group">
        <label for="doc-ipt-email-1">包装规格</label>
        <input type="number" name="box_unit" placeholder="请输入每箱包装的数量">
    </div>
    <div class="am-form-group">
        <label for="doc-ipt-email-1">包装箱数量</label>
        <input type="number" name="box_num" placeholder="请输入需要生成的包装箱数量">
    </div>
    <button type="submit" class="am-btn am-btn-primary">提交任务</button>
    <button type="button" class="am-btn am-btn-default" data-am-modal-close>取消</button>
</form>