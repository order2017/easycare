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
                <td>店名：</td>
                <td>{{$model['name'] or '无'}}</td>
            </tr>
            <tr>
                <td>电话：</td>
                <td>{{$model['phone'] or '无'}}</td>
            </tr>
            <tr>
                <td>店铺地址：</td>
                <td>{{$model['full_address'] or '无'}}</td>
            </tr>
            <tr>
                <td>所属老板：</td>
                <td>{{$model['boss_name'] or '无'}}</td>
            </tr>
            <tr>
                <td>所属员工：</td>
                <td>{{$model['employees_name'] or '无'}}</td>
            </tr>
            </tbody>
            <thead>
            <tr>
                <th colspan="2">图片审核</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="2">
                    <div class="shop-list-img">
                        <img src="{{$model['thumb'] or '无'}}" alt="">
                    </div>
                </td>
            </tr>
            @if(isset($model['images']))
            @foreach($model['images'] as $val)
            <tr>
                <td colspan="2">
                    <div class="shop-list-img">
                        <img src="{{$val['images'] or '无'}}" alt="">
                    </div>
                </td>
            </tr>
            @endforeach
                @endif
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
                <td>店名：</td>
                <td>{{$apply['name'] }}</td>
            </tr>
            <tr>
                <td>电话：</td>
                <td>{{$apply['phone'] }}</td>
            </tr>
            <tr>
                <td>店铺地址：</td>
                <td>{{$apply['full_address'] }}</td>
            </tr>
            <tr>
                <td>所属老板：</td>
                <td>{{$apply['boss_name'] or '无'}}</td>
            </tr>
            <tr>
                <td>所属员工：</td>
                <td>{{$apply['employees_name'] or '无'}}</td>
            </tr>
            </tbody>
            <thead>
            <tr>
                <th colspan="2">图片审核</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="2">
                    <div class="shop-list-img">
                        <img src="{{$apply['thumb'] or '无'}}" alt="">
                    </div>
                </td>
            </tr>
            @foreach($apply['images'] as $vel)
            <tr>
                <td colspan="2">
                    <div class="shop-list-img">
                            <img src="{{$vel['images'] or '无'}}" alt="">
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="am-g">
    <div class="am-u-md-3">
        <form class="am-form am-inline" action="{{route('admin.audits.shop.approval',['id'=>$apply['id']])}}"
              method="post">
            {{csrf_field()}}
            <button type="submit" class="am-btn am-btn-success">通过</button>
        </form>
    </div>
    <div class="am-u-md-6">
        <form class="am-form am-inline" action="{{route('admin.audits.shop.refusal',['id'=>$apply['id']])}}"
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



