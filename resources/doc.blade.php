<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>docapi文档</title>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                @foreach($apiinfo as $info)
                    @if($info["type"]=="group")
                        <li><a href="#{{$info["id"]}}" class="text-muted">{{$info["Name"] or "未命名的接口"}}</a></li>
                    @else
                        <li><a href="#{{$info["id"]}}" class="nav-mitem">{{$info["Name"] or "未命名的接口"}}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            @foreach ($apiinfo as $info)
                @if($info["depth"]==0)
                    <h1 class="page-header" id="{{$info["id"]}}">{{$info["Name"] or "未命名的接口"}}</h1>
                @endif
                @if($info["depth"]>0)
                    @if($info["type"]=="group")
                        <h2 class="page-header" id="{{$info["id"]}}">{{$info["Name"] or "未命名的分组"}}</h2>
                    @else
                            <h4 class="sub-header" id="{{$info["id"]}}">{{$info["Name"] or "未命名的接口"}} <a href="tests/{{$info["id"]}}.html">使用测试工具</a></h4>
                        <div class="table-responsive">
                            <p>{{$info["request_method"]}} {{$info["request_path"]}}</p>
                            <blockquote>
                                <p>{{$info["Description"] or "没有描述"}}</p>
                            </blockquote>
                            <div class="panel panel-default">
                                <div class="panel-heading">参数列表</div>
                                <table class="table">
                                    <tr>
                                        <th>参数名</th>
                                        <th>参数描述</th>
                                    </tr>
                                    @if(isset($info["Param"]))
                                        @foreach($info["Param"] as $param)
                                        <tr>
                                            <td>{{$param["name"]}}</td>
                                            <td>{{$param["value"]}}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="2">不需要参数</td></tr>
                                    @endif
                                </table>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">返回值描述</div>
                                <div class="panel-body">
                                    <pre>{{$info["Response"]}}</pre>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>