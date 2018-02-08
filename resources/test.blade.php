<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>接口测试工具</title>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 main">
            <h1 class="page-header">接口测试工具<a href="/docs/index.html" style="font-size: 20px">返回文档页面</a></h1>
            <h4 class="sub-header">{{$info["Name"] or "未命名的接口"}}</h4>
            <div class="table-responsive">
                <input type="hidden" id="url" value="/{{$info["request_path"]}}"/>
                <input type="hidden" id="method" value="{{$info["request_method"]}}"/>
                <p>{{$info["request_method"]}} {{$info["request_path"]}}</p>
                <blockquote>
                    <p>{{$info["Description"] or "没有描述"}}</p>
                </blockquote>


                <form class="form-inline">
                    <table class="table table-condensed">
                        <thead>
                        <th style="width: 30%">参数名称(鼠标覆盖查询描述)</th>
                        <th>参数值</th>
                        </thead>
                        <tbody>
                        @if(isset($info["Param"]))
                            @foreach($info["Param"] as $param)
                                <tr>
                                    <td><span class="pointer" title="参数{{$param["name"]}}描述"
                                              data-container="body" data-toggle="popover" data-placement="top"
                                              data-content="{{$param["value"]}}">{{$param["name"]}}</span></td>
                                    <td><input type="text" class="form-control param" name="{{$param["name"]}}" value="{{$param["ParamTest"] or ""}}" placeholder="填入参数值"></td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="2">不需要参数</td></tr>
                        @endif
                        </tbody>
                    </table>
                    <button type="button" id="sendreqeust" class="btn btn-default">发起请求</button>
                </form>
                <div class="response panel panel-default">
                    <div class="panel-heading">返回值</div>
                    <div class="panel-body">
                        <pre class="result">{}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="request.js"></script>

</body>
</html>