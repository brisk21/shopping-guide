## API 调用规则
每次请求 API 接口时，均需要提供 http请求头headers，具体如下：

名称 | 类型 | 说明
--- | --- | ---
```bs_token``` | String | 登录获取的token，登录、注册接口或者无需登录接口可不填

jq 的ajax实例：
```javascript
$.ajax({
        url:url,
        async:false,
        dataType:'json',
        data:data,
        type:type?type:'post',
        headers: {
            //本地登录缓存的token
            'BSTOKEN': localStorage.getItem('user_token')
        },
        beforeSend:function (request) {
            //或者这里设置请求头
            // request.setRequestHeader('BSTOKEN', ocalStorage.getItem('user_token'));
        },
        success:function (res) {
            //401需要重新登录
            if (res.code == '401' && res.data.login_url ){
                return location.href = res.data.login_url;
            }
            if (typeof callback =='function'){
                callback(res)
            }
        },
        error:function () {
            if (typeof callback =='function'){
                callback()
            }
        }
    })
```