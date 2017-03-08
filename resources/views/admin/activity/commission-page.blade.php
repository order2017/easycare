@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">新增/修改活动</h3>
    </div>
    <form method="post" class="am-form" action="">
        <input type="hidden" name="type" value="{{\App\ProductActivity::TYPE_SALE_COMMISSION}}">
        <div class="am-g">
            <div class="am-u-sm-6">
                <fieldset>
                    <legend>基础信息</legend>
                    <div class="am-alert am-alert-warning">
                        注意：<br>
                        1.奖励方式里面的“单独”是指活动奖励发放时与基础奖励分开产生奖励记录，即会产生两条奖励记录。<br>
                        2.奖励方式里面的“跟随(合并)”是指活动奖励与基础奖励合并成一条奖励记录。<br>
                        3.一个产品只能同时参与相同“活动类型”+不同“奖励类型”的活动，不能参与相同“活动类型”+相同“奖励类型”的活动。
                    </div>
                    <div class="am-g">
                        <div class="am-u-sm-4">
                            <div class="am-form-group">
                                <label for="doc-ipt-email-1">名称</label>
                                <input type="text" name="title" id="doc-ipt-email-1" value="{{$model['title']}}"
                                       placeholder="请输入活动名称">
                            </div>
                        </div>
                        <div class="am-u-sm-4">
                            <div class="am-form-group">
                                <label for="product-activity-send_method">发放方式</label>
                                <select id="product-activity-send_method" name="send_method">
                                    @foreach(\App\ProductActivity::sendMethodLabelList() as $k=>$item)
                                        <option value="{{$k}}"
                                                @if($k == $model['send_method']) selected @endif >{{$item}}</option>
                                    @endforeach
                                </select>
                                <span class="am-form-caret"></span>
                            </div>
                        </div>
                        <div class="am-u-sm-4">
                            <div class="am-form-group">
                                <label for="doc-ipt-email-1">活动总人数</label>
                                <input type="text" name="rules[total]" id="doc-ipt-email-1"
                                       value="{{$model['rules']['total']}}"
                                       placeholder="请输入活动总人数">
                            </div>
                        </div>
                        <div class="am-u-sm-6">
                            <div class="am-form-group">
                                <label for="beginTime">开始时间</label>
                                <input type="datetime" name="begin_time" id="beginTime"
                                       value="{{$model['begin_time']}}" data-datetime-picker data-activity-begin
                                       placeholder="请选择活动开始时间" @if(!empty($model['begin_time'])) readonly @endif>
                            </div>
                        </div>
                        <div class="am-u-sm-6">
                            <div class="am-form-group">
                                <label for="endTime">结束时间</label>
                                <input type="datetime" name="end_time" id="endTime"
                                       value="{{$model['end_time']}}" data-datetime-picker data-activity-end
                                       placeholder="请选择活动结束时间" @if(!empty($model['begin_time'])) readonly @endif>
                            </div>
                        </div>
                    </div>
                    <div class="am-g">
                        <div class="am-u-sn-12">
                            <div class="am-form-group">
                                <label for="product-activity-products">选择参与的产品</label>
                                <select class="am-selected" name="products[]" data-select2-box data-activity-product
                                        id="product-activity-products"
                                        multiple="multiple" data-url="{{route('admin.activity.products')}}"
                                        @if(empty($model['begin_time']) || empty($model['end_time'])) disabled @endif >
                                    @if(!empty($model['products']))
                                        @foreach($model->getProducts($model['type'],$model['begin_time'],$model['end_time'],$model['id']) as $item)
                                            <option value="{{$item['id']}}"
                                                    @if(in_array($item['id'],isset($model['products']) ? $model['products'] : [])) selected @endif>{{$item['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="am-u-sm-6">
                <fieldset>
                    <legend>规则设置</legend>
                    <div class="am-alert am-alert-warning">
                        奖励数计算方式：<br>
                        1.当基础奖励为0时，系统直接按(奖励数*1RMB)发放奖励。<br>
                        2.当基础奖励不为0时，系统按(基础奖励*奖励数%)发放奖励。<br>
                        3.假如计算后奖励低于1RMB，按1RMB发放(这是微信限制最低发放1RMB)。<br>
                    </div>
                    <div class="am-g am-margin-bottom-sm">
                        <div class="am-u-sm-4">
                            <label for="doc-ipt-email-1">奖品数量</label>
                        </div>
                        <div class="am-u-sm-3">
                            <label for="doc-ipt-email-1">奖励数</label>
                        </div>
                        <div class="am-u-sm-3">
                            <label for="doc-ipt-email-1">已参加人数</label>
                        </div>
                        <div class="am-u-sm-2">
                            <button type="button" id="product-activity-add-rule"
                                    data-rules="{{$model['rules_max']}}"
                                    class="am-btn am-btn-secondary">增加
                            </button>
                        </div>
                    </div>
                    <div id="product-activity-rules-box">
                        @if(empty($model['rules']['list']))
                            <div class="am-g" data-product-activity-rule>
                                <div class="am-u-sm-4">
                                    <div class="am-form-group">
                                        <input type="number" name="rules[list][0][winning_rate]" placeholder="请输入奖品数量">
                                    </div>
                                </div>
                                <div class="am-u-sm-3">
                                    <div class="am-form-group">
                                        <input type="number" name="rules[list][0][rewards]" placeholder="请输入奖励数">
                                    </div>
                                </div>
                                <div class="am-u-sm-3">
                                    <div class="am-form-group">
                                        <input type="number" name="rules[list][0][has]" value="0" readonly
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="am-u-sm-2">
                                    <button type="button" class="am-btn am-btn-danger"
                                            data-product-activity-delete-rules>
                                        删除
                                    </button>
                                </div>
                            </div>
                        @else
                            @foreach($model['rules']['list'] as $k=>$rule)
                                <div class="am-g" data-product-activity-rule>
                                    <div class="am-u-sm-4">
                                        <div class="am-form-group">
                                            <input type="number" name="rules[list][{{$k}}][winning_rate]"
                                                   value="{{$rule['winning_rate']}}"
                                                   placeholder="请输入奖品数量">
                                        </div>
                                    </div>
                                    <div class="am-u-sm-3">
                                        <div class="am-form-group">
                                            <input type="number" name="rules[list][{{$k}}][rewards]"
                                                   value="{{$rule['rewards']}}"
                                                   placeholder="请输入奖励数">
                                        </div>
                                    </div>
                                    <div class="am-u-sm-3">
                                        <div class="am-form-group">
                                            <input type="number" name="rules[list][{{$k}}][has]"
                                                   value="{{$rule['has']}}"
                                                   readonly placeholder="">
                                        </div>
                                    </div>
                                    <div class="am-u-sm-2">
                                        <button type="button" class="am-btn am-btn-danger"
                                                data-product-activity-delete-rules
                                                @if($rule['has'] > 0) disabled @endif>
                                            删除
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </fieldset>
            </div>
            <div class="am-u-sm-12 am-text-center">
                <button class="am-btn am-btn-primary inline-block">保存活动</button>
                <a class="am-btn am-btn-default inline-block" href="{{route('admin.activity.commission.list')}}">返回</a>
            </div>
        </div>
    </form>
@endsection