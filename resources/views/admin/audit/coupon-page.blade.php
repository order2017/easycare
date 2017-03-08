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
                <td>标题：</td>
                <td>{{$model['title'] or '无'}}</td>
            </tr>
            <tr>
                <td>优惠类型：</td>
                <td>{{$model['type'] or '无'}}</td>
            </tr>
            <tr>
                <td>所属店铺：</td>
                <td>{{$model['shop_name'] or '无'}}</td>
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
                <td>标题：</td>
                <td>{{$apply['title'] }}</td>
            </tr>
            <tr>
                <td>优惠类型：</td>
                <td>{{$apply['type'] }}</td>
            </tr>
            <tr>
                <td>所属店铺：</td>
                <td>{{$apply['shop_name'] or '无'}}</td>
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
        <form class="am-form am-inline" action="{{route('admin.audits.coupon.approval',['id'=>$apply['id']])}}"
              method="post">
            {{csrf_field()}}
            <button type="submit" class="am-btn am-btn-success">通过</button>
        </form>
    </div>
    <div class="am-u-md-6">
        <form class="am-form am-inline" action="{{route('admin.audits.coupon.refusal',['id'=>$apply['id']])}}"
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



