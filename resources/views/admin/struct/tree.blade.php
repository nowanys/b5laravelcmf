@extends('admin.public.layout')

@include('widget.asset.ztree')

@section('content')
    <style>
        body {
            height: auto;
            font-family: "Microsoft YaHei";
            background-color: #fff !important;
        }

        button {
            font-family: "SimSun", "Helvetica Neue", Helvetica, Arial;
        }
    </style>
    @render('iframe',['name'=>'input','extend'=>['name'=>'treeId','id'=>'treeId','type'=>'hidden','value'=>$structId]])
    @render('iframe',['name'=>'input','extend'=>['name'=>'treeName','id'=>'treeName','type'=>'hidden','value'=>'']])
    <div class="wrapper">
        <div class="treeShowHideButton" onclick="$.tree.toggleSearch();">
            <label id="btnShow" title="显示搜索" style="display:none;">︾</label>
            <label id="btnHide" title="隐藏搜索">︽</label>
        </div>
        <div class="treeSearchInput" id="search">
            <label for="keyword">关键字：</label><input type="text" class="empty" id="keyword" maxlength="50">
            <button class="btn" id="btn" onclick="$.tree.searchNode()"> 搜索</button>
        </div>
        <div class="treeExpandCollapse">
            <a href="javascript:;" onclick="$.tree.expand()">展开</a> /
            <a href="javascript:;" onclick="$.tree.collapse()">折叠</a>
        </div>
        <div id="tree" class="ztree treeselect"></div>
    </div>
@endsection


@section('script')
    <script>
        var ismult = "{{$ismult??''}}";
        $(function () {
            var options = {
                url: aUrl,
                expandLevel: 2,
                ismult:ismult=='1'?true:false
            };
            $.tree.init(options);
        });


    </script>
@stop
