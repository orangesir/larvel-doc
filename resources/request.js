var formatJson = function (json, options) {
    var reg = null,
        formatted = '',
        pad = 0,
        PADDING = '    ';
    options = options || {};
    options.newlineAfterColonIfBeforeBraceOrBracket = (options.newlineAfterColonIfBeforeBraceOrBracket === true) ? true : false;
    options.spaceAfterColon = (options.spaceAfterColon === false) ? false : true;
    if (typeof json !== 'string') {
        json = JSON.stringify(json);
    } else {
        json = JSON.parse(json);
        json = JSON.stringify(json);
    }
    reg = /([\{\}])/g;
    json = json.replace(reg, '\r\n$1\r\n');
    reg = /([\[\]])/g;
    json = json.replace(reg, '\r\n$1\r\n');
    reg = /(\,)/g;
    json = json.replace(reg, '$1\r\n');
    reg = /(\r\n\r\n)/g;
    json = json.replace(reg, '\r\n');
    reg = /\r\n\,/g;
    json = json.replace(reg, ',');
    if (!options.newlineAfterColonIfBeforeBraceOrBracket) {
        reg = /\:\r\n\{/g;
        json = json.replace(reg, ':{');
        reg = /\:\r\n\[/g;
        json = json.replace(reg, ':[');
    }
    if (options.spaceAfterColon) {
        reg = /\:/g;
        json = json.replace(reg, ':');
    }
    (json.split('\r\n')).forEach(function (node, index) {
            var i = 0,
                indent = 0,
                padding = '';

            if (node.match(/\{$/) || node.match(/\[$/)) {
                indent = 1;
            } else if (node.match(/\}/) || node.match(/\]/)) {
                if (pad !== 0) {
                    pad -= 1;
                }
            } else {
                indent = 0;
            }

            for (i = 0; i < pad; i++) {
                padding += PADDING;
            }

            formatted += padding + node + '\r\n';
            pad += indent;
        }
    );
    return formatted;
};

$(function () {
    $("[data-toggle='popover']").hover(function(obj){
        $(obj.currentTarget).popover('show')
    },function(obj){
        $(obj.currentTarget).popover('hide')
    });
});

$("#sendreqeust").click(function(){
    console.log("开始查询");
    $(".result").html("doing....");
    var url = $("#url").val();
    var method = $("#method").val();
    var param = {}
    $(".param").each(function(data, obj){
        console.log(data);
        console.log(obj);
        param[$(obj).attr("name")] = $(obj).val();
    });
    param["_method"] = method;
    if(method!="GET") {
        method = "POST";
    }

    $.ajax(url,{
        data:param,
        type:method,
        dataType:"text",
        complete:function(data, status) {
            $(".result").html("原始数据:\n"+data.responseText);
            var resultJson = formatJson(data.responseText);
            if(resultJson) {
                $(".result").html(resultJson);
            }
        }
    });
});