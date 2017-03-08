@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">新增/修改会员红包活动</h3>
    </div>
    <form method="post" class="am-form" action="">
        <input type="hidden" name="type" value="{{\App\ProductActivity::TYPE_MEMBER_RED_PACKETS}}">
        <div class="am-g">
            <div class="am-u-sm-6">
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
                            <label for="beginTime">开始时间</label>
                            <input type="datetime" name="begin_time" id="beginTime"
                                   value="{{$model['begin_time']}}" data-datetime-picker data-activity-begin
                                   placeholder="请选择活动开始时间" @if(!empty($model['begin_time'])) readonly @endif>
                        </div>
                    </div>
                    <div class="am-u-sm-4">
                        <div class="am-form-group">
                            <label for="endTime">结束时间</label>
                            <input type="datetime" name="end_time" id="endTime"
                                   value="{{$model['end_time']}}" data-datetime-picker data-activity-end
                                   placeholder="请选择活动结束时间" @if(!empty($model['begin_time'])) readonly @endif>
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
                            <label for="doc-ipt-email-1">区间最小值</label>
                            <div class="am-input-group">
                                <input type="number" step="0.01" name="rules[min]" id="doc-ipt-email-1"
                                       value="{{$model['min']}}" min="1"
                                       placeholder="请输入奖励倍数">
                                <span class="am-input-group-label">RMB</span>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-4">
                        <div class="am-form-group">
                            <label for="doc-ipt-email-1">区间最大值</label>
                            <div class="am-input-group">
                                <input type="number" step="0.01" name="rules[max]" id="doc-ipt-email-1"
                                       value="{{$model['max']}}" min="1"
                                       placeholder="请输入奖励倍数">
                                <span class="am-input-group-label">RMB</span>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12">
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
                <div class="am-u-sm-12 am-text-center">
                    <button class="am-btn am-btn-primary inline-block">保存活动</button>
                    <a class="am-btn am-btn-default inline-block"
                       href="{{route('admin.activity.red-packet.list')}}">返回</a>
                </div>
            </div>
        </div>
    </form>
@endsection