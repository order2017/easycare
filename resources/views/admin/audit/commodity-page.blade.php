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
                <td>商品名：</td>
                <td>{{$model['name'] or '无'}}</td>
            </tr>
            <tr>
                <td>现价：</td>
                <td>{{$model['price'] or '无'}}</td>
            </tr>
            <tr>
                <td>原价：</td>
                <td>{{$model['original_price'] or '无'}}</td>
            </tr>
            <tr>
                <td>库存：</td>
                <td>{{$model['inventory'] or '无'}}</td>
            </tr>

            <tr>
                <td>店名：</td>
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
                <td>商品：</td>
                <td>{{$apply['name'] }}</td>
            </tr>
            <tr>
                <td>现价：</td>
                <td>{{$apply['price'] }}</td>
            </tr>
            <tr>
                <td>原价：</td>
                <td>{{$apply['original_price'] }}</td>
            </tr>
            <tr>
                <td>库存：</td>
                <td>{{$apply['inventory'] }}</td>
            </tr>
            <tr>
                <td>店名：</td>
                <td>{{$apply['shop_name'] }}</td>
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
        <form class="am-form am-inline" action="{{route('admin.audits.commodity.approval',['id'=>$apply['id']])}}"
              method="post">
            {{csrf_field()}}
            <button type="submit" class="am-btn am-btn-success">通过</button>
        </form>
    </div>
    <div class="am-u-md-6">
        <form class="am-form am-inline" action="{{route('admin.audits.commodity.refusal',['id'=>$apply['id']])}}"
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



