<div class="am-modal-hd">迁移所属员工名下信息</div>
<form class="am-form " action="{{route('admin.employee.page',['id'=>$model['id']])}}" method="post">
    <div class="am-form-group">
        <label for="doc-select-1">请选择员工姓名</label>
        <select id="doc-select-1" name="employees_id">
            @foreach($employee as $line)
                @if($line->id != $model->id)
            <option selected="" value="{{$line['id']}}">{{$line['name']}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <button type="submit" class="am-btn am-btn-primary">确定</button>
    <button type="button" class="am-btn am-btn-warning" data-am-modal-close>取消</button>
</form>