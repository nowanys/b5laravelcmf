<a class="btn btn-success" onclick="$.operate.add('@if(isset($widget_data['opid'])) {{$widget_data['opid']}} @endif',this)"  data-width="@if(isset($widget_data['width'])){{$widget_data['width']}}@endif" data-height="@if(isset($widget_data['height'])){{$widget_data['height']}}@endif">
    <i class="fa fa-plus"></i> {{$widget_data['title']?:'新增'}}
</a>

