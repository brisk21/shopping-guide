# openapi-sdk-php

#### 介绍
大淘客开放平台SDK PHP版

#### 安装教程
```composer require dtk-developer/openapi-sdk-php```
#### 使用实例
```
    include 'vendor/autoload.php';

    //线报api
    $client = new GetTipList();

    $client->setAppKey('5ff42cda0fd35');
    $client->setAppSecret('28318c5c2ea7b5c57fa7fab0a990db7f');
    $client->setVersion('v3.0.0');

    $res = $client->setParams([])->request();
    var_dump($res);

```

#### 参与贡献

1.  Fork 本仓库
2.  新建 Feat_xxx 分支
3.  提交代码
4.  新建 Pull Request


#### 特技

1.  使用 Readme\_XXX.md 来支持不同的语言，例如 Readme\_en.md, Readme\_zh.md
2.  Gitee 官方博客 [blog.gitee.com](https://blog.gitee.com)
3.  你可以 [https://gitee.com/explore](https://gitee.com/explore) 这个地址来了解 Gitee 上的优秀开源项目
4.  [GVP](https://gitee.com/gvp) 全称是 Gitee 最有价值开源项目，是综合评定出的优秀开源项目
5.  Gitee 官方提供的使用手册 [https://gitee.com/help](https://gitee.com/help)
6.  Gitee 封面人物是一档用来展示 Gitee 会员风采的栏目 [https://gitee.com/gitee-stars/](https://gitee.com/gitee-stars/)
