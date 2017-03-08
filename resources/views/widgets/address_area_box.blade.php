<div class="address-box" data-address-box data-url="{{route('widget.address')}}">
    <select name="province_id" class="form-control" data-type="province">
        @foreach($provinceList as $region)
            <option @if($region['id'] == $provinceId) selected
                    @endif value="{{$region['id']}}">{{$region['name']}}</option>
        @endforeach
    </select>
    <select name="city_id" class="form-control" data-type="city">
        @foreach($cityList as $region)
            <option @if($region['id'] == $cityId) selected
                    @endif value="{{$region['id']}}">{{$region['name']}}</option>
        @endforeach
    </select>
    <select name="county_id" class="form-control" data-type="county">
        @foreach($countyList as $region)
            <option @if($region['id'] == $countyId) selected
                    @endif value="{{$region['id']}}">{{$region['name']}}</option>
        @endforeach
    </select>
</div>