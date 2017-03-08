<div class="am-g">
    <div class="am-u-md-6">
        <table class="am-table am-table-bordered am-table-striped am-table-hover am-table-compact am-table-centered">
            <thead>
            <tr>
                <th colspan="2">现有资料</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>姓名：</td>
                <td>{{$model['name'] or '无'}}</td>
            </tr>
            <tr>
                <td>电话：</td>
                <td>{{$model['mobile'] or '无'}}</td>
            </tr>
            <tr>
                <td>所属区域：</td>
                <td>{{$model['region'] or '无'}}</td>
            </tr>
            <tr>
                <td>所属员工：</td>
                <td>{{$model['employee_name'] or '无'}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="am-u-md-6">
        <table class="am-table am-table-bordered am-table-striped am-table-hover am-table-compact am-table-centered">
            <thead>
            <tr>
                <th colspan="2">最新提交资料</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>姓名：</td>
                <td>{{$apply['name']}}</td>
            </tr>
            <tr>
                <td>电话：</td>
                <td>{{$apply['mobile']}}</td>
            </tr>
            <tr>
                <td>所属区域：</td>
                <td>{{$apply['region']}}</td>
            </tr>
            <tr>
                <td>所属员工：</td>
                <td>{{$apply['employee_name']}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="am-g">
    <div class="am-u-md-3">
        <form class="am-form am-inline" action="{{route('admin.audits.sale.approval',['id'=>$apply['id']])}}"
              method="post">
            {{csrf_field()}}
            <button type="submit" class="am-btn am-btn-success">通过</button>
        </form>
    </div>
    <div class="am-u-md-6">
        <form class="am-form am-inline" action="{{route('admin.audits.sale.refusal',['id'=>$apply['id']])}}"
              method="post">
            {{csrf_field()}}
            <div class="am-input-group">
                <input type="text" class="reason" name="reason" placeholder="不通过的原因"/>
                  <span class="am-input-group-btn">
                    <button type="submit" class="am-btn am-btn-warning">不通过</button>
                  </span>
            </div>
        </form>
    </div>
    <div class="am-u-md-3">
        <button type="button" class="am-btn am-btn-default" data-am-modal-close>取消</button>
    </div>
</div>



