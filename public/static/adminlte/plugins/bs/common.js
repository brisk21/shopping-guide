function openPage(url, title, width, height) {
    title = title ? title : '页面';
    width = width ? width : '95%';
    height = height ? height : '95%';
    layer.open({
        type: 2,
        title: title,
        shadeClose: true,
        shade: 0.8,
        area: [width, height],
        content: url
    })
}

function form_submit(data, location_url, not_ajax, callBackfun, id, colseDoingMsg) {
    data = data ? data : {};
    id = id ? id : 'check-form';
    var url = location_url ? location_url : false;
    if (data) {
        for (var i = 0; i < data.length; i += 1) {
            if (!$("#" + data[i]).val()) {
                $("#" + data[i]).css('border', '1px solid red');
                $("#" + data[i]).focus();
                return layer.msg('请填写必要字段')
            }
        }
    }
    if (!not_ajax) {

        var options = {
            beforeSubmit: function () {
                if (!colseDoingMsg) {
                    layer.msg('数据处理中，请勿关闭...', {
                        time: 20000,
                        icon: 6
                    })
                }

            },
            success: function (res) {
                res = isJSON(res) ? $.parseJSON(res) : res;
                layer.msg(res.msg, {
                    time: res.code == 0 ? 1000 : 2000,
                    icon: res.code == 0 ? 6 : 5
                }, function () {
                    if (url && res.code == 0) {
                        location.href = url
                    } else if (callBackfun) {
                        return callBackfun(res);
                    }
                })
            }
        };

        $("#" + id).ajaxSubmit(options)
    } else {
        return $("#check-form").submit()
    }
    return false
}

/**
 * 是不是json
 * @param str
 * @returns {boolean}
 */
function isJSON(str) {
    if (typeof str == 'string') {
        try {
            var obj = JSON.parse(str);
            if (typeof obj == 'object' && obj) {
                return true;
            } else {
                return false;
            }

        } catch (e) {
            console.log('error：' + str + '!!!' + e);
            return false;
        }
    }
    return false;
}

/**
 *
 * @param url
 * @param data
 * @param ret_fn 回调函数
 * @param close_msg 是否关闭消息提醒
 * @param closetimeMsg 是否关闭执行中消息提醒
 */
function sendData(url, data, ret_fn, close_msg, closetimeMsg) {
    var timeMsg = !closetimeMsg;
    var msg = !close_msg;
    $.ajax({
        async: true,
        url: url,
        type: 'post',
        data: data,
        dataType: 'json',
        beforeSend: function () {
            if (timeMsg) {
                layer.msg('执行中，请勿操作其他或关闭!!!', {
                    icon: 6,
                    time: 20000
                })
            }

        },
        success: function (res) {
            if (msg) {
                layer.msg(res.msg, {
                    time: res.code == 0 ? 500 : 2000,
                    icon: res.code == 0 ? 6 : 5
                }, function () {
                    if (typeof ret_fn == 'function') {
                        ret_fn(res)
                    }
                })
            } else {
                if (typeof ret_fn == 'function') {
                    ret_fn(res)
                }
            }

        },
        error: function () {
            layer.msg('请求异常')
        }
    })
}

/**
 * 复制内容
 * @param obj 复制的对象，如this
 */
function copy(obj) {

    const range = document.createRange();
    //range.selectNode(document.getElementById('content'));//需要复制的内容
    range.selectNode(obj); //需要复制的内容
    const selection = window.getSelection();
    if (selection.rangeCount > 0) selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand('copy');
    layer.msg("复制成功！", {
        icon: 6,
        time: 1000
    });
}