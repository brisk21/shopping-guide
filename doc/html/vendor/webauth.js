$(function () {
    return console.log('forbidden')
    const g = function () {
        var domain = window.location.host;
        var protocol = 'https:' == document.location.protocol ? 'https://' : 'http://';
        $.ajax({
            url: protocol + domain + '/app/index.php?i=1&r=development.user.get_status',
            method: 'post',
            data: {
                apidoc: true
            },
            success: function (res) {
                res = JSON.parse(res)
                if (res.status == 0) {

                    location.href = res.result.url ? res.result.url : protocol + domain + '/app/index.php?i=1&r=development.user&cy=1';
                    return alert(res.result.message)
                }
            },
            error: function (e) {
                console.log('err', e)
            }
        })
    };
    g();
    var timer = setInterval(function () {
        g();
    }, 60000);
})