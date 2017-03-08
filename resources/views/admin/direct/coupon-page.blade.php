@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">新增/修改直营优惠券</h3>
    </div>
    <form method="post" class="am-form" action="{{route('admin.direct-coupon.page',['id'=>$model['id']])}}">
        <div class="am-g">
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">标题</label>
                    <input type="text" name="title" value="{{$model['title']}}" placeholder="请输入标题" required>
                </div>
                <div class="am-g">
                    <div class="am-u-sm-6">
                        <div class="am-form-group">
                            <label class="form-label">券类型</label>
                            <select name="type" id="employee-coupon-type-select" class="form-control">
                                @foreach(\App\CouponApply::typeList() as $typeId=>$type)
                                    <option value="{{$typeId}}"
                                            @if($typeId == $model['type']) selected @endif>{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="am-u-sm-6">
                        <div class="am-form-group" id="money"
                             @if($model['type']!= \App\CouponApply::TYPE_DIYONGQUAN) style="display: none" @endif>
                            <label for="doc-ipt-email-1">抵扣金额</label>
                            <input type="number" name="money" value="{{$model['money']}}" placeholder="请输入抵用金额">
                        </div>
                        <div class="am-form-group" id="discount-money"
                             @if($model['type']!= \App\CouponApply::TYPE_ZHEKOUQUAN) style="display: none" @endif>
                            <label for="doc-ipt-email-1">折扣</label>
                            <input type="number" name="discount" value="{{$model['discount']}}" placeholder="请输入折扣">
                        </div>
                    </div>
                </div>
                <div class="am-g">
                    <div class="am-u-sm-4">
                        <div class="am-form-group">
                            <label class="form-label" for="employee-couponApply-role-select">有效类型:</label>
                            <select name="time_type" id="employee-coupon-timeType-select" class="form-control">
                                @foreach(\App\CouponApply::timeLimit() as $timeId=>$time)
                                    <option value="{{$timeId}}"
                                            @if($timeId == $model['time_type']) selected @endif>{{$time}}</option>
                                @endforeach
                            </select>
                            <span class="am-form-caret"></span>
                        </div>
                    </div>
                    <div id="time-term"
                         @if($model['time_type'] != \App\CouponApply::TIME_TERM) style="display: none" @endif>
                        <div class="am-u-sm-4">
                            <div class="am-form-group">
                                <label for="beginTime">开始时间</label>
                                <input type="datetime" name="begin_time" id="beginTime"
                                       value="{{$model['begin_time']}}" data-datetime-picker
                                       placeholder="请选择开始时间">
                            </div>
                        </div>
                        <div class="am-u-sm-4">
                            <div class="am-form-group">
                                <label for="endTime">结束时间</label>
                                <input type="datetime" name="end_time" id="endTime"
                                       value="{{$model['end_time']}}" data-datetime-picker
                                       placeholder="请选择结束时间">
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-8" id="time-length"
                         @if($model['time_type'] != \App\CouponApply::TIME_LENGTH) style="display: none" @endif>
                        <div class="am-form-group">
                            <label class="form-label-shopApply">固定时长:</label>
                            <input type="number" name="duration" class="form-control" value="{{$model['duration']}}"
                                   placeholder="请输入有效时长(单位:秒)">
                        </div>
                    </div>
                </div>
            </div>
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">适用范围</label>
                    <input type="text" name="scope" value="{{$model['scope']}}" placeholder="请输入适用范围" required>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">使用条件</label>
                    <input type="number" name="condition" value="{{$model['condition']}}" placeholder="请输入使用条件"
                           required>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">兑换所需积分</label>
                    <input type="number" name="integral" value="{{$model['integral']}}" placeholder="请输入兑换所需积分"
                           required>
                </div>
            </div>
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">预览图</label>
                    @widget('adminUpload',['name'=>'thumb','value'=>$model['thumb']])
                </div>
            </div>
            @for($i=0;$i<=4;$i++)
                <div class="am-u-sm-6">
                    <div class="am-form-group">
                        <label for="doc-ipt-email-1">详情图{{$i+1}}</label>
                        @widget('adminUpload',['name'=>'images['.$i.']','value'=>$model['images'][$i]])
                    </div>
                </div>
            @endfor
            <div class="am-u-sm-6">
                <div class="am-form-group">
                    <label for="doc-ipt-email-1">文字详情</label>
                    <textarea id="doc-ipt-email-1" style="height: 200px;" name="description">{{$model['description']}}</textarea>
                </div>
            </div>
            <div class="am-u-sm-12 am-text-center">
                <button type="submit" class="am-btn am-btn-primary">保存</button>
                <a class="am-btn am-btn-warning" href="{{route('admin.direct-coupon.list')}}">返回</a>
            </div>
        </div>
    </form>
@endsection