@extends('layouts.admin')
@section('content')
    <div class="lion-content-header am-cf">
        <h3 class="am-fl">收货地址列表</h3>
        <a href="{{route('admin.banner.page')}}"  class="am-btn am-btn-secondary am-fr am-btn-sm">上传广告图
        </a>
        <a href="" class="am-btn am-fr am-btn-sm am-btn-default"
           data-toggle='page'>刷新</a>
    </div>
    <table class="am-table am-table-bordered am-animation-slide-bottom am-table-striped am-table-hover am-table-compact am-table-centered">
        <thead>
        <tr>
            <th>图片</th>
            <th>顺序</th>
            <th>链接</th>
            <th>创建时间</th>
            <th>修改时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $banner)
            <tr>
                <td class="table-image"><img src="{{$banner['image_url']}}" alt=""></td>
                <td>{{$banner['order']}}</td>
                <td>{{$banner['link']}}</td>
                <td>{{$banner['created_at']}}</td>
                <td>{{$banner['updated_at']}}</td>
                <td>
                    <a href="{{route('admin.banner.page',['id'=>$banner['id']])}}"
                       class="am-btn am-btn-warning am-btn-xs ">修改</a>
                    <form action="{{route('admin.banner.delete',['id'=>$banner['id']])}}" data-delete-confirm method="post"
                          class="am-inline">
                        {{method_field('DELETE')}}
                        <button class="am-btn am-btn-danger am-btn-xs">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $list->render() !!}
@endsection@extends('layouts.admin')