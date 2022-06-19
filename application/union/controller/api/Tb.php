<?php


namespace app\union\controller\api;


use app\server\GuideServer;
use think\Controller;

class Tb extends DgApiBase
{
    public function getSuperClassify()
    {
        $data = json_decode('[{"data":[{"next_name":"裙装","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1ZDEToIKfxu4jSZPfXXb3dXXa","son_name":"连衣裙"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1VEK5Nlr0gK0jSZFnXXbRRXXa","son_name":"雪纺裙"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1VBi7NXP7gK0jSZFjXXc5aXXa","son_name":"半身裙"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1IYGDakcx_u4jSZFlXXXnUFXa","son_name":"印花裙"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1xvyZNkY2gK0jSZFgXXc5OFXa","son_name":"吊带裙"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1SqqVNbr1gK0jSZFDXXb9yVXa","son_name":"纯色裙"}]},{"next_name":"套装","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1NoiINkL0gK0jSZFtXXXQCXXa","son_name":"两件套"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1_4HbdRBh1e4jSZFhXXcC9VXa","son_name":"夏季套装"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1gTIToIKfxu4jSZPfXXb3dXXa","son_name":"大码女装"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1rILbeP39YK4jSZPcXXXrUFXa","son_name":"妈妈装"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1gmSTNaL7gK0jSZFBXXXZZpXa","son_name":"婚纱"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1I8m7NXP7gK0jSZFjXXc5aXXa","son_name":"小香风"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1v9SFcBFR4u4jSZFPXXanzFXa","son_name":"运动套装"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1BCSFcBFR4u4jSZFPXXanzFXa","son_name":"雪纺套装"}]},{"next_name":"T恤","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1ose1Nhv1gK0jSZFFXXb0sXXa","son_name":"T恤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB16x5NNhD1gK0jSZFsXXbldVXa","son_name":"一字肩"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1qU1MNeL2gK0jSZPhXXahvXXa","son_name":"印花雪纺"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1iy6TdDM11u4jSZPxXXahcXXa","son_name":"吊带T恤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB12NLbdRBh1e4jSZFhXXcC9VXa","son_name":"娃娃衫"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1sV0gd79l0K4jSZFKXXXFjpXa","son_name":"情侣T恤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1dbODakcx_u4jSZFlXXXnUFXa","son_name":"白衬衣"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1gsaUNoH1gK0jSZSyXXXtlpXa","son_name":"短袖T恤"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1uGCVNbr1gK0jSZFDXXb9yVXa","son_name":"纯色T恤"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1yS1RNeH2gK0jSZJnXXaT1FXa","son_name":"蕾丝拼接"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1cTuLNXY7gK0jSZKzXXaikpXa","son_name":"蕾丝衫"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1GNTbdRBh1e4jSZFhXXcC9VXa","son_name":"防晒衫"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1zZiUNoY1gK0jSZFCXXcwqXXa","son_name":"露肩上衣"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB17RCONoz1gK0jSZLeXXb9kVXa","son_name":"长袖T恤"}]},{"next_name":"内搭","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1FEKINkL0gK0jSZFtXXXQCXXa","son_name":"喇叭袖"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1c_iTNaL7gK0jSZFBXXXZZpXa","son_name":"开衫"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1qrjaXdTfau8jSZFwXXX1mVXa","son_name":"打底毛衣"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1mtbbeP39YK4jSZPcXXXrUFXa","son_name":"毛衣"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1E6rTdDM11u4jSZPxXXahcXXa","son_name":"针织衫"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1WIdLXODsXe8jSZR0XXXK6FXa","son_name":"高领"}]},{"next_name":"外套","info":[{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1ojaUNkL0gK0jSZFAXXcA9pXa","son_name":"卫衣"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1NzaTNXT7gK0jSZFpXXaTkpXa","son_name":"夹克"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB16DKLNXY7gK0jSZKzXXaikpXa","son_name":"棉服"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB160EhXCslXu8jSZFuXXXg7FXa","son_name":"毛呢"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1tcuUNoH1gK0jSZSyXXXtlpXa","son_name":"牛仔"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1wEOINkL0gK0jSZFtXXXQCXXa","son_name":"皮衣"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1hYh.bSR26e4jSZFEXXbwuXXa","son_name":"短外套"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1FsuUNoH1gK0jSZSyXXXtlpXa","son_name":"羽绒"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1iJe8NeT2gK0jSZFvXXXnFXXa","son_name":"西装"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1WVe6Nlr0gK0jSZFnXXbRRXXa","son_name":"风衣"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1Crh.bSR26e4jSZFEXXbwuXXa","son_name":"马甲"}]},{"next_name":"裤子","info":[{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1zGJ.bSR26e4jSZFEXXbwuXXa","son_name":"休闲裤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1AZ.hXCslXu8jSZFuXXXg7FXa","son_name":"哈伦裤"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1FXiMNbY1gK0jSZTEXXXDQVXa","son_name":"棉麻裤"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1ErJLXODsXe8jSZR0XXXK6FXa","son_name":"牛仔裤"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1TaJ.bSR26e4jSZFEXXbwuXXa","son_name":"短裤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Ci4HbsVl614jSZKPXXaGjpXa","son_name":"破洞牛仔裤"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1sCOTNaL7gK0jSZFBXXXZZpXa","son_name":"裤子"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1OaPaXdTfau8jSZFwXXX1mVXa","son_name":"阔腿裤"}]}],"main_name":"女装","cid":1},{"data":[{"next_name":"内搭","info":[{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1ihqZNkT2gK0jSZFkXXcIQFXa","son_name":"长袖T恤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB11SZToIKfxu4jSZPfXXb3dXXa","son_name":"polo衫"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB16mZToIKfxu4jSZPfXXb3dXXa","son_name":"T恤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB17jiTNoY1gK0jSZFMXXaWcVXa","son_name":"卫衣"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1kMiZNkT2gK0jSZFkXXcIQFXa","son_name":"短袖T恤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1OKSZNkY2gK0jSZFgXXc5OFXa","son_name":"衬衣"}]},{"next_name":"外套","info":[{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1mhqZNkT2gK0jSZFkXXcIQFXa","son_name":"马甲"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1AX8.bSR26e4jSZFEXXbwuXXa","son_name":"呢大衣"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1uH6beP39YK4jSZPcXXXrUFXa","son_name":"夹克"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1JyjTdDM11u4jSZPxXXahcXXa","son_name":"棉衣"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1YSCLNXY7gK0jSZKzXXaikpXa","son_name":"棒球服"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1Jb6beP39YK4jSZPcXXXrUFXa","son_name":"牛仔外套"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1Th5TNXT7gK0jSZFpXXaTkpXa","son_name":"皮衣"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1ESBCc2zO3e4jSZFxXXaP_FXa","son_name":"羽绒服"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1cCEca3gP7K4jSZFqXXamhVXa","son_name":"西装"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1XWX.bSR26e4jSZFEXXbwuXXa","son_name":"风衣"}]},{"next_name":"下装","info":[{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1FAyONoz1gK0jSZLeXXb9kVXa","son_name":"七分裤"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1UIYJaipE_u4jSZKbXXbCUVXa","son_name":"九分裤"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB16zmTNoY1gK0jSZFMXXaWcVXa","son_name":"休闲裤"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1dm7ToIKfxu4jSZPfXXb3dXXa","son_name":"哈伦裤"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1a0e7NeL2gK0jSZFmXXc7iXXa","son_name":"工装裤"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB12AyONoz1gK0jSZLeXXb9kVXa","son_name":"沙滩裤"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1wwmZNkT2gK0jSZFkXXcIQFXa","son_name":"牛仔裤"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1Gh9TNXT7gK0jSZFpXXaTkpXa","son_name":"短裤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1lmeFcBFR4u4jSZFPXXanzFXa","son_name":"西裤"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1X9eTNaL7gK0jSZFBXXXZZpXa","son_name":"运动裤"}]},{"next_name":"针织衫","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB11ynTdDM11u4jSZPxXXahcXXa","son_name":"套头"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1WN9TNXT7gK0jSZFpXXaTkpXa","son_name":"开衫"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1o9eTNaL7gK0jSZFBXXXZZpXa","son_name":"毛衣"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1pUmMNeL2gK0jSZPhXXahvXXa","son_name":"羊毛衫"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1BXSVNbr1gK0jSZFDXXb9yVXa","son_name":"针织衫"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1XEOLNbY1gK0jSZTEXXXDQVXa","son_name":"高领"}]}],"main_name":"男装","cid":2},{"data":[{"next_name":"内衣","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1NXSVNbr1gK0jSZFDXXb9yVXa","son_name":"保暖背心"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1virTdDM11u4jSZPxXXahcXXa","son_name":"内衣套装"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1LSeRNeH2gK0jSZJnXXaT1FXa","son_name":"内裤女"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1MDKINkL0gK0jSZFtXXXQCXXa","son_name":"内裤男"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1qS.ToIKfxu4jSZPfXXb3dXXa","son_name":"打底裤"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1C.OLNbY1gK0jSZTEXXXDQVXa","son_name":"文胸"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1PESJNhz1gK0jSZSgXXavwpXa","son_name":"塑身衣"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1_RWIbjMZ7e4jSZFOXXX7epXa","son_name":"秋裤"}]},{"next_name":"睡衣","info":[{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1raaPNfb2gK0jSZK9XXaEgFXa","son_name":"保暖睡衣"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1UcEhXCslXu8jSZFuXXXg7FXa","son_name":"卡通睡衣"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1WcbbeP39YK4jSZPcXXXrUFXa","son_name":"夹棉睡衣"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1P9JCc2zO3e4jSZFxXXaP_FXa","son_name":"女士睡衣"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB16QO7NXP7gK0jSZFjXXc5aXXa","son_name":"情侣睡衣"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1ZZ6JaipE_u4jSZKbXXbCUVXa","son_name":"珊瑚绒"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1CbG1Nhv1gK0jSZFFXXb0sXXa","son_name":"男士睡衣"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1MR1IbjMZ7e4jSZFOXXX7epXa","son_name":"睡袍"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1xieTNXT7gK0jSZFpXXaTkpXa","son_name":"睡裙"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1UbG1Nhv1gK0jSZFFXXb0sXXa","son_name":"短袖睡衣"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1nCNCc2zO3e4jSZFxXXaP_FXa","son_name":"长袖睡衣"}]},{"next_name":"袜子","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1xWnaXdTfau8jSZFwXXX1mVXa","son_name":"女袜"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB16I_JaipE_u4jSZKbXXbCUVXa","son_name":"棉袜"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB14YyUNoH1gK0jSZSyXXXtlpXa","son_name":"男袜"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1ysMhXCslXu8jSZFuXXXg7FXa","son_name":"裤袜"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1Bt_ldWNj0u4jSZFyXXXgMVXa","son_name":"长筒袜"}]}],"main_name":"内衣","cid":3},{"data":[{"next_name":"个人护理","info":[{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1mOeNNhD1gK0jSZFsXXbldVXa","son_name":"头发造型"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1uuLldWNj0u4jSZFyXXXgMVXa","son_name":"护发素"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1kiWUNkL0gK0jSZFAXXcA9pXa","son_name":"染发膏"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1t0AhXCslXu8jSZFuXXXg7FXa","son_name":"沐浴露"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1y6nTdDM11u4jSZPxXXahcXXa","son_name":"洗发水"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1r6tHbsVl614jSZKPXXaGjpXa","son_name":"清洁剂"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB128u4NoT1gK0jSZFrXXcNCXXa","son_name":"刷子"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB18IXLXODsXe8jSZR0XXXK6FXa","son_name":"私处护理"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1uDeFcBFR4u4jSZFPXXanzFXa","son_name":"足浴"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1HN_bdRBh1e4jSZFhXXcC9VXa","son_name":"足贴"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1.tPJaipE_u4jSZKbXXbCUVXa","son_name":"香薰"}]},{"next_name":"美妆","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1qnxCc2zO3e4jSZFxXXaP_FXa","son_name":"BB霜"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1wS9TNaL7gK0jSZFBXXXZZpXa","son_name":"乳液"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1sy1UNkL0gK0jSZFAXXcA9pXa","son_name":"卸妆"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1cpeNNeL2gK0jSZPhXXahvXXa","son_name":"唇膏"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1OQiTNoY1gK0jSZFMXXaWcVXa","son_name":"彩妆品盘"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB19NeZNkT2gK0jSZFkXXcIQFXa","son_name":"洁面仪"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1Vs18NeT2gK0jSZFvXXXnFXXa","son_name":"洗面奶"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1Sd97NeL2gK0jSZFmXXc7iXXa","son_name":"爽肤水"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1WRuONoz1gK0jSZLeXXb9kVXa","son_name":"男士护理"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1Y99RNeH2gK0jSZJnXXaT1FXa","son_name":"眼线"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1mqdgd79l0K4jSZFKXXXFjpXa","son_name":"眼霜"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1kHbaXdTfau8jSZFwXXX1mVXa","son_name":"睫毛膏"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1hnBCc2zO3e4jSZFxXXaP_FXa","son_name":"粉底液"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1cH5Dakcx_u4jSZFlXXXnUFXa","son_name":"精华"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1VpeNNeL2gK0jSZPhXXahvXXa","son_name":"精油"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1hTaFcBFR4u4jSZFPXXanzFXa","son_name":"纤体"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1yI6beP39YK4jSZPcXXXrUFXa","son_name":"脱毛"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1PO5TNXT7gK0jSZFpXXaTkpXa","son_name":"腮红"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1vo95Nlr0gK0jSZFnXXbRRXXa","son_name":"身体护理"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1C1a7NeL2gK0jSZFmXXc7iXXa","son_name":"防晒"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1lUGINkL0gK0jSZFtXXXQCXXa","son_name":"隔离霜"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1by9TNXT7gK0jSZFpXXaTkpXa","son_name":"面膜"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1Tea7NeL2gK0jSZFmXXc7iXXa","son_name":"面霜"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1k5qNNhD1gK0jSZFsXXbldVXa","son_name":"香水"}]},{"next_name":"营养保健","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1ihqTNXT7gK0jSZFpXXaTkpXa","son_name":"B族维生素"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB19Uxfd79l0K4jSZFKXXXFjpXa","son_name":"大豆异黄酮"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1FnCMNeL2gK0jSZPhXXahvXXa","son_name":"左旋"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1IR1LNXY7gK0jSZKzXXaikpXa","son_name":"氨基葡萄糖"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1jhNHbsVl614jSZKPXXaGjpXa","son_name":"维生素"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1CD5LNbY1gK0jSZTEXXXDQVXa","son_name":"维生素C"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1rjS4NoT1gK0jSZFrXXcNCXXa","son_name":"胶原蛋白"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB12RuRNeH2gK0jSZJnXXaT1FXa","son_name":"葡萄籽"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1N.Bfd79l0K4jSZFKXXXFjpXa","son_name":"螺旋藻"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Y3KNNhD1gK0jSZFsXXbldVXa","son_name":"褪黑素"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1jWxLXODsXe8jSZR0XXXK6FXa","son_name":"软骨素"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1KzS4NoT1gK0jSZFrXXcNCXXa","son_name":"辅酶Q10"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Z7qTNoY1gK0jSZFMXXaWcVXa","son_name":"酵素"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1ihqTNXT7gK0jSZFpXXaTkpXa","son_name":"B族维生素"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB17sfJaipE_u4jSZKbXXbCUVXa","son_name":"DHA"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB19Uxfd79l0K4jSZFKXXXFjpXa","son_name":"大豆异黄酮"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1FnCMNeL2gK0jSZPhXXahvXXa","son_name":"左旋"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1PWtLXODsXe8jSZR0XXXK6FXa","son_name":"月见草油"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1IR1LNXY7gK0jSZKzXXaikpXa","son_name":"氨基葡萄糖"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1JBuRNeH2gK0jSZJnXXaT1FXa","son_name":"玛咖"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1WeeZNkY2gK0jSZFgXXc5OFXa","son_name":"益生菌"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1jhNHbsVl614jSZKPXXaGjpXa","son_name":"维生素"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1CD5LNbY1gK0jSZTEXXXDQVXa","son_name":"维生素C"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1rjS4NoT1gK0jSZFrXXcNCXXa","son_name":"胶原蛋白"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB12RuRNeH2gK0jSZJnXXaT1FXa","son_name":"葡萄籽"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1N.Bfd79l0K4jSZFKXXXFjpXa","son_name":"螺旋藻"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Y3KNNhD1gK0jSZFsXXbldVXa","son_name":"褪黑素"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1jWxLXODsXe8jSZR0XXXK6FXa","son_name":"软骨素"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1KzS4NoT1gK0jSZFrXXcNCXXa","son_name":"辅酶Q10"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Z7qTNoY1gK0jSZFMXXaWcVXa","son_name":"酵素"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1E.aJNhz1gK0jSZSgXXavwpXa","son_name":"钙"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB19MrbdRBh1e4jSZFhXXcC9VXa","son_name":"鱼油"}]}],"main_name":"美妆","cid":4},{"data":[{"next_name":"帽子","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1XLaZNkY2gK0jSZFgXXc5OFXa","son_name":"套头帽"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1ttq7NeL2gK0jSZFmXXc7iXXa","son_name":"毛线帽"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1FhjbdRBh1e4jSZFhXXcC9VXa","son_name":"渔夫帽"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1LXtgd79l0K4jSZFKXXXFjpXa","son_name":"爵士帽"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1PXtgd79l0K4jSZFKXXXFjpXa","son_name":"盆帽"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Ndq7NeL2gK0jSZFmXXc7iXXa","son_name":"礼帽"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1e3CZNkT2gK0jSZFkXXcIQFXa","son_name":"贝雷帽"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1LYCUNoH1gK0jSZSyXXXtlpXa","son_name":"针织帽"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1hYpLXODsXe8jSZR0XXXK6FXa","son_name":"鸭舌帽"}]},{"next_name":"配饰","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1xSWLNXY7gK0jSZKzXXaikpXa","son_name":"半指手套"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1UHCUNoH1gK0jSZSyXXXtlpXa","son_name":"手套"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1LrOUNoY1gK0jSZFCXXcwqXXa","son_name":"真皮腰带"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1pqzaXdTfau8jSZFwXXX1mVXa","son_name":"腰带"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1qONHbsVl614jSZKPXXaGjpXa","son_name":"触屏手套"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1NbtLXODsXe8jSZR0XXXK6FXa","son_name":"雨伞"}]},{"next_name":"围巾","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1cYqDakcx_u4jSZFlXXXnUFXa","son_name":"披肩围巾"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1Bcq8NeT2gK0jSZFvXXXnFXXa","son_name":"棉麻围巾"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1C_oToIKfxu4jSZPfXXb3dXXa","son_name":"真丝围巾"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1FToToIKfxu4jSZPfXXb3dXXa","son_name":"羊毛围巾"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB14iHTdDM11u4jSZPxXXahcXXa","son_name":"羊绒围巾"}]}],"main_name":"配饰","cid":5},{"data":[{"next_name":"男鞋","info":[{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1bCGRNeH2gK0jSZJnXXaT1FXa","son_name":"乐福鞋"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1nEC5Nlr0gK0jSZFnXXbRRXXa","son_name":"休闲鞋"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1kSGRNeH2gK0jSZJnXXaT1FXa","son_name":"凉鞋"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1XiTTdDM11u4jSZPxXXahcXXa","son_name":"增高鞋"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1vmmIbjMZ7e4jSZFOXXX7epXa","son_name":"帆布鞋"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB11JG7NeL2gK0jSZFmXXc7iXXa","son_name":"板鞋"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1DnaLNXY7gK0jSZKzXXaikpXa","son_name":"网布鞋"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1q3SZNkT2gK0jSZFkXXcIQFXa","son_name":"豆豆鞋"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB13qiVNbr1gK0jSZFDXXb9yVXa","son_name":"运动鞋"}]},{"next_name":"女鞋","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1zgSZNkT2gK0jSZFkXXcIQFXa","son_name":"中跟鞋"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1TLqZNkY2gK0jSZFgXXc5OFXa","son_name":"乐福鞋"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1KpiKNhz1gK0jSZSgXXavwpXa","son_name":"低跟鞋"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB10CmIbjMZ7e4jSZFOXXX7epXa","son_name":"妈妈鞋"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1RqF.bSR26e4jSZFEXXbwuXXa","son_name":"小白鞋"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1EcC8NeT2gK0jSZFvXXXnFXXa","son_name":"帆布鞋"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1CdK7NeL2gK0jSZFmXXc7iXXa","son_name":"平底凉鞋"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1RXNgd79l0K4jSZFKXXXFjpXa","son_name":"平底鞋"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB18gSZNkT2gK0jSZFkXXcIQFXa","son_name":"松糕厚底"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1h_cca3gP7K4jSZFqXXamhVXa","son_name":"猫跟鞋"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1OHCDakcx_u4jSZFlXXXnUFXa","son_name":"玛丽珍鞋"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1o3WZNkT2gK0jSZFkXXcIQFXa","son_name":"豆豆鞋"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1iuvldWNj0u4jSZFyXXXgMVXa","son_name":"运动鞋"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1wwWZNkT2gK0jSZFkXXcIQFXa","son_name":"高跟鞋"}]}],"main_name":"鞋品","cid":6},{"data":[{"next_name":"单肩包","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1izOTNoY1gK0jSZFMXXaWcVXa","son_name":"单肩包"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1MpaKNhz1gK0jSZSgXXavwpXa","son_name":"妈妈包"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1druDakcx_u4jSZFlXXXnUFXa","son_name":"宽肩带包"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1POuTNXT7gK0jSZFpXXaTkpXa","son_name":"小方包"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1zIu8NeT2gK0jSZFvXXXnFXXa","son_name":"斜挎包"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1gmiIbjMZ7e4jSZFOXXX7epXa","son_name":"水桶包"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1bkW4NoT1gK0jSZFrXXcNCXXa","son_name":"波士顿包"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1j.KMNeL2gK0jSZPhXXahvXXa","son_name":"贝壳包"}]},{"next_name":"功能箱包","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1eaB.bSR26e4jSZFEXXbwuXXa","son_name":"手拿包"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB10iuUNkL0gK0jSZFAXXcA9pXa","son_name":"手提包"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1YDsToIKfxu4jSZPfXXb3dXXa","son_name":"旅行箱"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1zYWUNoY1gK0jSZFCXXcwqXXa","son_name":"腰包"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1SCCTNaL7gK0jSZFBXXXZZpXa","son_name":"迷你包"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1HYWUNoY1gK0jSZFCXXcwqXXa","son_name":"钱包"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1Zr11Nhv1gK0jSZFFXXb0sXXa","son_name":"链条包"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1O5PTdDM11u4jSZPxXXahcXXa","son_name":"零钱包"}]},{"next_name":"双肩包","info":[{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1JrBLXODsXe8jSZR0XXXK6FXa","son_name":"双肩包"}]}],"main_name":"箱包","cid":7},{"data":[{"next_name":"其他","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1DVB.bSR26e4jSZFEXXbwuXXa","son_name":"描红本"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1T99INkL0gK0jSZFtXXXQCXXa","son_name":"早教机"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1iFyPNfb2gK0jSZK9XXaEgFXa","son_name":"自行车"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1PauDakcx_u4jSZFlXXXnUFXa","son_name":"学习用品"}]},{"next_name":"玩具","info":[{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1qZG7NeL2gK0jSZFmXXc7iXXa","son_name":"户外玩具"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1wJnldWNj0u4jSZFyXXXgMVXa","son_name":"积木"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1q88Cc2zO3e4jSZFxXXaP_FXa","son_name":"亲子玩具"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1qq51Nhv1gK0jSZFFXXb0sXXa","son_name":"玩具"}]},{"next_name":"服饰","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1cgvbdRBh1e4jSZFhXXcC9VXa","son_name":"亲子装"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1SDGMNeL2gK0jSZPhXXahvXXa","son_name":"女童外套"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1PVx.bSR26e4jSZFEXXbwuXXa","son_name":"女童裤子"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1F_9LNbY1gK0jSZTEXXXDQVXa","son_name":"女童鞋"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1Dru8NeT2gK0jSZFvXXXnFXXa","son_name":"帽子"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1pXuPNfb2gK0jSZK9XXaEgFXa","son_name":"打底裤"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1rz1ONoz1gK0jSZLeXXb9kVXa","son_name":"演出服"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB16YZhXCslXu8jSZFuXXXg7FXa","son_name":"男童外套"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1UEFfd79l0K4jSZFKXXXFjpXa","son_name":"男童裤子"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1T0jldWNj0u4jSZFyXXXgMVXa","son_name":"男童鞋"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB19Hu8NeT2gK0jSZFvXXXnFXXa","son_name":"连衣裙"}]}],"main_name":"儿童","cid":8},{"data":[{"next_name":"婴儿用品","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1dB5FcBFR4u4jSZFPXXanzFXa","son_name":"体温计"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB16rm1Nhv1gK0jSZFFXXb0sXXa","son_name":"奶嘴"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB19R1TNaL7gK0jSZFBXXXZZpXa","son_name":"奶瓶"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Cp6aXdTfau8jSZFwXXX1mVXa","son_name":"婴儿床"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1ESUToIKfxu4jSZPfXXb3dXXa","son_name":"婴儿抱被"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1C7qONoz1gK0jSZLeXXb9kVXa","son_name":"学步车"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB12EyLNbY1gK0jSZTEXXXDQVXa","son_name":"推车"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1sEaMNeL2gK0jSZPhXXahvXXa","son_name":"新生儿"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1rSwca3gP7K4jSZFqXXamhVXa","son_name":"睡袋"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1KVWPNfb2gK0jSZK9XXaEgFXa","son_name":"纸尿布"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1HUaMNeL2gK0jSZPhXXahvXXa","son_name":"连体睡衣"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1lH2beP39YK4jSZPcXXXrUFXa","son_name":"隔尿垫"}]},{"next_name":"孕妇用品","info":[{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1hI97NeL2gK0jSZFmXXc7iXXa","son_name":"吸奶器"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1LmyLNXY7gK0jSZKzXXaikpXa","son_name":"哺乳文胸"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1ub18NeT2gK0jSZFvXXXnFXXa","son_name":"孕妇内裤"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB17RKIbjMZ7e4jSZFOXXX7epXa","son_name":"孕妇营养品"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1yXXgd79l0K4jSZFKXXXFjpXa","son_name":"孕妇裤"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1aUeMNeL2gK0jSZPhXXahvXXa","son_name":"孕妇连衣裙"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB17OfTdDM11u4jSZPxXXahcXXa","son_name":"待产包"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1aSAca3gP7K4jSZFqXXamhVXa","son_name":"月子服"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1aEKJNhz1gK0jSZSgXXavwpXa","son_name":"防溢乳垫"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1nKSZNkY2gK0jSZFgXXc5OFXa","son_name":"防辐射"}]}],"main_name":"母婴","cid":9},{"data":[{"next_name":"布艺软饰","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1k4GTNXT7gK0jSZFpXXaTkpXa","son_name":"十字绣"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1jRKRNeH2gK0jSZJnXXaT1FXa","son_name":"墙贴"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1q9eLNXY7gK0jSZKzXXaikpXa","son_name":"挂钟"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1b0vldWNj0u4jSZFyXXXgMVXa","son_name":"沙发"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1HneINkL0gK0jSZFtXXXQCXXa","son_name":"沙发垫"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1NBKRNeH2gK0jSZJnXXaT1FXa","son_name":"浴室垫"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1qdvldWNj0u4jSZFyXXXgMVXa","son_name":"照片墙"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1SNYTdDM11u4jSZPxXXahcXXa","son_name":"盖巾"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1_pmVNbr1gK0jSZFDXXb9yVXa","son_name":"相框"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1M7i7NXP7gK0jSZFjXXc5aXXa","son_name":"缝纫机"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1zQaONoz1gK0jSZLeXXb9kVXa","son_name":"花瓶"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1OSEToIKfxu4jSZPfXXb3dXXa","son_name":"门垫"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1dSgca3gP7K4jSZFqXXamhVXa","son_name":"门帘"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1xuyZNkY2gK0jSZFgXXc5OFXa","son_name":"靠垫"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1xmiLNXY7gK0jSZKzXXaikpXa","son_name":"香炉"}]},{"next_name":"生活用品","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1DIiUNoY1gK0jSZFCXXcwqXXa","son_name":"卫生巾"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1k4aZNkT2gK0jSZFkXXcIQFXa","son_name":"卷纸"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1nFyMNbY1gK0jSZTEXXXDQVXa","son_name":"厨房清洁"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1qG6aXdTfau8jSZFwXXX1mVXa","son_name":"成人纸尿裤"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1STsca3gP7K4jSZFqXXamhVXa","son_name":"抽纸"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1aoyINkL0gK0jSZFtXXXQCXXa","son_name":"洗手液"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1gLOZNkY2gK0jSZFgXXc5OFXa","son_name":"洗衣液"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1Kd57NeL2gK0jSZFmXXc7iXXa","son_name":"漱口水"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB13ZW8NeT2gK0jSZFvXXXnFXXa","son_name":"牙膏"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1t0AhXCslXu8jSZFuXXXg7FXa","son_name":"沐浴露"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1y6nTdDM11u4jSZPxXXahcXXa","son_name":"洗发水"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1r6tHbsVl614jSZKPXXaGjpXa","son_name":"清洁剂"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB128u4NoT1gK0jSZFrXXcNCXXa","son_name":"牙刷"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB18IXLXODsXe8jSZR0XXXK6FXa","son_name":"私处护理"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1uDeFcBFR4u4jSZFPXXanzFXa","son_name":"足浴"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1HN_bdRBh1e4jSZFhXXcC9VXa","son_name":"足贴"}]},{"next_name":"家纺","info":[{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1by5TNoY1gK0jSZFMXXaWcVXa","son_name":"乳胶枕"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1xCgca3gP7K4jSZFqXXamhVXa","son_name":"儿童床品"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1ji5TNoY1gK0jSZFMXXaWcVXa","son_name":"冬被"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1Ea9UNoY1gK0jSZFCXXcwqXXa","son_name":"床四件套"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1nFTaXdTfau8jSZFwXXX1mVXa","son_name":"枕头"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1MomLNbY1gK0jSZTEXXXDQVXa","son_name":"毯子"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1hW5UNoH1gK0jSZSyXXXtlpXa","son_name":"磨毛四件套"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1GhKUNkL0gK0jSZFAXXcA9pXa","son_name":"羽绒枕"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB14Cgca3gP7K4jSZFqXXamhVXa","son_name":"羽绒被"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB18Cgca3gP7K4jSZFqXXamhVXa","son_name":"蚕丝被"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1uFuVNbr1gK0jSZFDXXb9yVXa","son_name":"被子"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB14bLbeP39YK4jSZPcXXXrUFXa","son_name":"记忆枕"}]},{"next_name":"家居","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB19.Vfd79l0K4jSZFKXXXFjpXa","son_name":"书架"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1PD1MNeL2gK0jSZPhXXahvXXa","son_name":"儿童床"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1fClCc2zO3e4jSZFxXXaP_FXa","son_name":"床垫"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1yoqLNbY1gK0jSZTEXXXDQVXa","son_name":"收纳"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1HMPbdRBh1e4jSZFhXXcC9VXa","son_name":"椅子"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1Y.uJNhz1gK0jSZSgXXavwpXa","son_name":"沙发"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB16_mINkL0gK0jSZFtXXXQCXXa","son_name":"碗套装"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1L0DldWNj0u4jSZFyXXXgMVXa","son_name":"花架"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1v7e4NoT1gK0jSZFrXXcNCXXa","son_name":"鞋柜"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB16Qq7NXP7gK0jSZFjXXc5aXXa","son_name":"高低床"}]}],"main_name":"居家","cid":10},{"data":[{"next_name":"零食","info":[{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1yW9UNoH1gK0jSZSyXXXtlpXa","son_name":"干果"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1t.yJNhz1gK0jSZSgXXavwpXa","son_name":"干货"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1oVV.bSR26e4jSZFEXXbwuXXa","son_name":"月饼"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1M8WTNaL7gK0jSZFBXXXZZpXa","son_name":"速食"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1HDqINkL0gK0jSZFtXXXQCXXa","son_name":"零食"}]},{"next_name":"饮品","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1mF2aXdTfau8jSZFwXXX1mVXa","son_name":"茶饮"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB13BCIbjMZ7e4jSZFOXXX7epXa","son_name":"酒水"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1zEuLNbY1gK0jSZTEXXXDQVXa","son_name":"饮料"}]},{"next_name":"生鲜菜类","info":[{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1nWSDakcx_u4jSZFlXXXnUFXa","son_name":"土鸡蛋"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1mTW5Nlr0gK0jSZFnXXbRRXXa","son_name":"大米"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1sDW5Nlr0gK0jSZFnXXbRRXXa","son_name":"大闸蟹"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1JB1FcBFR4u4jSZFPXXanzFXa","son_name":"新鲜水果"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1lybTdDM11u4jSZPxXXahcXXa","son_name":"海鲜"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1e3aZNkT2gK0jSZFkXXcIQFXa","son_name":"燕窝"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB16o4fd79l0K4jSZFKXXXFjpXa","son_name":"米饭"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1JB1TNaL7gK0jSZFBXXXZZpXa","son_name":"肉类"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1MuKZNkY2gK0jSZFgXXc5OFXa","son_name":"食用油"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1kzeTNoY1gK0jSZFMXXaWcVXa","son_name":"鸭蛋"}]},{"next_name":"营养保健","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Z7qTNoY1gK0jSZFMXXaWcVXa","son_name":"酵素"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB17sfJaipE_u4jSZKbXXbCUVXa","son_name":"DHA"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1PWtLXODsXe8jSZR0XXXK6FXa","son_name":"月见草油"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1JBuRNeH2gK0jSZJnXXaT1FXa","son_name":"玛咖"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1WeeZNkY2gK0jSZFgXXc5OFXa","son_name":"益生菌"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1E.aJNhz1gK0jSZSgXXavwpXa","son_name":"钙"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB19MrbdRBh1e4jSZFhXXcC9VXa","son_name":"鱼油"}]}],"main_name":"美食","cid":11},{"data":[{"next_name":"配件","info":[{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1vCyTNaL7gK0jSZFBXXXZZpXa","son_name":"保护壳"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1QQWONoz1gK0jSZLeXXb9kVXa","son_name":"耳机"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1XZvbeP39YK4jSZPcXXXrUFXa","son_name":"苹果配件"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1isZhXCslXu8jSZFuXXXg7FXa","son_name":"鼠标键盘"}]},{"next_name":"设备","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1nKjldWNj0u4jSZFyXXXgMVXa","son_name":"无人机"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1NYW1Nhv1gK0jSZFFXXb0sXXa","son_name":"电脑主机"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1ansToIKfxu4jSZPfXXb3dXXa","son_name":"音响"}]}],"main_name":"数码","cid":12},{"data":[{"next_name":"个护健康","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1GVHaXdTfau8jSZFwXXX1mVXa","son_name":"剃须刀"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1CR8Cc2zO3e4jSZFxXXaP_FXa","son_name":"卷发"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB13ka7NXP7gK0jSZFjXXc5aXXa","son_name":"吹风机"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1gEeLNbY1gK0jSZTEXXXDQVXa","son_name":"按摩器"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1C_OMNeL2gK0jSZPhXXahvXXa","son_name":"美容仪"}]},{"next_name":"生活电器","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1aHC8NeT2gK0jSZFvXXXnFXXa","son_name":"加湿器"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1ChCTNXT7gK0jSZFpXXaTkpXa","son_name":"取暖器"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1g3DbdRBh1e4jSZFhXXcC9VXa","son_name":"吸尘器"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1HCaLNXY7gK0jSZKzXXaikpXa","son_name":"扫地机器人"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB10TOMNeL2gK0jSZPhXXahvXXa","son_name":"榨汁机"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1b9XCc2zO3e4jSZFxXXaP_FXa","son_name":"烤箱"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1v0rldWNj0u4jSZFyXXXgMVXa","son_name":"电热毯"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1GAe7NXP7gK0jSZFjXXc5aXXa","son_name":"电饭锅"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB16XF.bSR26e4jSZFEXXbwuXXa","son_name":"空气净化器"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1NHDbeP39YK4jSZPcXXXrUFXa","son_name":"豆浆机"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1RHDbeP39YK4jSZPcXXXrUFXa","son_name":"足浴"}]}],"main_name":"家电","cid":13},{"data":[{"next_name":"汽车美容","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1zbOPNfb2gK0jSZK9XXaEgFXa","son_name":"玻璃水"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1H0i1Nhv1gK0jSZFFXXb0sXXa","son_name":"补漆笔"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1ma4gd79l0K4jSZFKXXXFjpXa","son_name":"擦车巾"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1uAdHbsVl614jSZKPXXaGjpXa","son_name":"车衣"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1gdm1Nhv1gK0jSZFFXXb0sXXa","son_name":"车用香水"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1EISDakcx_u4jSZFlXXXnUFXa","son_name":"车用香薰"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1sGyMNbY1gK0jSZTEXXXDQVXa","son_name":"防冻液"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1XD5RNeH2gK0jSZJnXXaT1FXa","son_name":"机油"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1ImqONoz1gK0jSZLeXXb9kVXa","son_name":"汽油"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1NUtCc2zO3e4jSZFxXXaP_FXa","son_name":"洗车水枪"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1Mq8gd79l0K4jSZFKXXXFjpXa","son_name":"雨刮器"}]},{"next_name":"内饰品","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1K.UToIKfxu4jSZPfXXb3dXXa","son_name":"摆件"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1r5eZNkT2gK0jSZFkXXcIQFXa","son_name":"车载手机座"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1zqGKNhz1gK0jSZSgXXavwpXa","son_name":"方向盘套"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1CSm4NoT1gK0jSZFrXXcNCXXa","son_name":"脚垫"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1x9C7NXP7gK0jSZFjXXc5aXXa","son_name":"汽车贴纸"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1aewhXCslXu8jSZFuXXXg7FXa","son_name":"头枕"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1Mt2beP39YK4jSZPcXXXrUFXa","son_name":"腰靠"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1An9FcBFR4u4jSZFPXXanzFXa","son_name":"钥匙包"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1gRmTNoY1gK0jSZFMXXaWcVXa","son_name":"钥匙扣"}]}],"main_name":"车品","cid":15},{"data":[{"next_name":"文具品类","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1r.cToIKfxu4jSZPfXXb3dXXa","son_name":"笔记本"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1s1m7NeL2gK0jSZFmXXc7iXXa","son_name":"彩泥"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1NbnaXdTfau8jSZFwXXX1mVXa","son_name":"订书机"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1EjeUNkL0gK0jSZFAXXcA9pXa","son_name":"钢笔"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB11YnaXdTfau8jSZFwXXX1mVXa","son_name":"计算器"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1yFuNNeL2gK0jSZPhXXahvXXa","son_name":"记号笔"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB18Gpgd79l0K4jSZFKXXXFjpXa","son_name":"圆珠笔"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1AzzTdDM11u4jSZPxXXahcXXa","son_name":"中性笔"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Pp1KNhz1gK0jSZSgXXavwpXa","son_name":"马克笔"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1acpLXODsXe8jSZR0XXXK6FXa","son_name":"铅笔"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1oHiPNfb2gK0jSZK9XXaEgFXa","son_name":"书包"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1REgToIKfxu4jSZPfXXb3dXXa","son_name":"贴纸"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB14jFHbsVl614jSZKPXXaGjpXa","son_name":"玩具车"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1b_uFcBFR4u4jSZFPXXanzFXa","son_name":"文件袋"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1RvbldWNj0u4jSZFyXXXgMVXa","son_name":"文件夹"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1_hCZNkT2gK0jSZFkXXcIQFXa","son_name":"文具盒"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1UcmDakcx_u4jSZFlXXXnUFXa","son_name":"相册"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1hV5MNbY1gK0jSZTEXXXDQVXa","son_name":"修正带"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB14IGUNoH1gK0jSZSyXXXtlpXa","son_name":"胶水"}]},{"next_name":"体育用品","info":[{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1pYaVNbr1gK0jSZFDXXb9yVXa","son_name":"臂力器"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1VvfldWNj0u4jSZFyXXXgMVXa","son_name":"健身器材"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1XfjldWNj0u4jSZFyXXXgMVXa","son_name":"篮球"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1_ZOUNoH1gK0jSZSyXXXtlpXa","son_name":"羽毛球"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB10fnldWNj0u4jSZFyXXXgMVXa","son_name":"乒乓球"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB15n9LNXY7gK0jSZKzXXaikpXa","son_name":"乒乓球板"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1BwqZNkY2gK0jSZFgXXc5OFXa","son_name":"足球"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1w07hXCslXu8jSZFuXXXg7FXa","son_name":"双肩包"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1u2rldWNj0u4jSZFyXXXgMVXa","son_name":"跳绳"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1PnmIbjMZ7e4jSZFOXXX7epXa","son_name":"握力器"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1rICDakcx_u4jSZFlXXXnUFXa","son_name":"哑铃"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB13DmIbjMZ7e4jSZFOXXX7epXa","son_name":"腰包"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1JR9ONoz1gK0jSZLeXXb9kVXa","son_name":"运动护具"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1EUAToIKfxu4jSZPfXXb3dXXa","son_name":"运动毛巾"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1PZJLXODsXe8jSZR0XXXK6FXa","son_name":"跑步机"}]}],"main_name":"文体","cid":16},{"data":[{"next_name":"宠物食品","info":[{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1RPCUNkL0gK0jSZFAXXcA9pXa","son_name":"狗零食"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1G0G8NeT2gK0jSZFvXXXnFXXa","son_name":"狗主粮"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB19c91Nhv1gK0jSZFFXXb0sXXa","son_name":"猫零食"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1R51NNhD1gK0jSZFsXXbldVXa","son_name":"猫主粮"}]},{"next_name":"清洁用品","info":[{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1zoEToIKfxu4jSZPfXXb3dXXa","son_name":"吹风机"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1ftK8NeT2gK0jSZFvXXXnFXXa","son_name":"猫砂"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1kHN.bSR26e4jSZFEXXbwuXXa","son_name":"尿片"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1pUhCc2zO3e4jSZFxXXaP_FXa","son_name":"香波浴液"}]},{"next_name":"日用品","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1N0K8NeT2gK0jSZFvXXXnFXXa","son_name":"床"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Jmm7NXP7gK0jSZFjXXc5aXXa","son_name":"垫子"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1eWqMNbY1gK0jSZTEXXXDQVXa","son_name":"笼子"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1BV1NNeL2gK0jSZPhXXahvXXa","son_name":"猫碗"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1PpO6Nlr0gK0jSZFnXXbRRXXa","son_name":"钳"},{"imgurl":"http://img02.taobaocdn.com:80/tfscom/TB1Nc5UNoH1gK0jSZSyXXXtlpXa","son_name":"项圈"},{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1Wp1NNeL2gK0jSZPhXXahvXXa","son_name":"药品"}]},{"next_name":"猫玩具","info":[{"imgurl":"http://img03.taobaocdn.com:80/tfscom/TB1PgCZNkY2gK0jSZFgXXc5OFXa","son_name":"逗猫棒"},{"imgurl":"http://img01.taobaocdn.com:80/tfscom/TB1ZgCZNkY2gK0jSZFgXXc5OFXa","son_name":"猫爬架"},{"imgurl":"http://img04.taobaocdn.com:80/tfscom/TB1lpS6Nlr0gK0jSZFnXXbRRXXa","son_name":"猫抓板"}]}],"main_name":"宠物","cid":17}]', true);

        data_return('ok', 0, $data);
    }

    public function superSearch()
    {
        $arg['keyword'] = !empty($this->params['keyWords']) ? $this->params['keyWords'] : '';
        $arg['hasCoupon'] = !empty($this->params['withCoupon']) ? 1 : 0;

        $sort = !empty($this->params['sort']) ? $this->params['sort'] : 0;
        $arg['pageId'] = !empty($this->params['pageId']) ? $this->params['pageId'] : 1;
        $arg['pageSize'] = !empty($this->params['pageSize']) ? $this->params['pageSize'] : 20;
        if ($sort == 'total_sales_des') {
            $arg['sort'] = 1;
        } elseif ($sort == 'renqi') {
            $arg['sort'] = 0;
        } elseif ($sort == 'price_asc') {
            $arg['sort'] = 6;
        } elseif ($sort == 'price_des') {
            $arg['sort'] = 5;
        }

        $req = $this->dtk->tb_goods_super_search($arg);

        if (empty($req['totalNum'])) {
            data_return('ok', 0, [
                'goodsList' => [],
                'totalNum' => 0
            ]);
        }
        $goodsList = [];
        foreach ($req['list'] as $item) {
            $goodsList[] = [
                'mainPic' => $item['mainPic'],
                'imageList' => $item['smallImages'],
                'desc' => $item['desc'],
                'couponLink' => $item['couponLink'],
                'monthSales' => $item['monthSales'],
                'actualPrice' => $item['actualPrice'],
                'backmoney' => sprintf('%.02f', $item['actualPrice'] * $item['commissionRate'] / 100),
                'buMoney' => 0,
                'title' => $item['title'],
                'dtitle' => $item['dtitle'],
                'shopName' => $item['shopName'],

                'goodsId' => $item['goodsId'],
                'couponPrice' => $item['couponPrice'],
                'useEndTime' => $item['couponEndTime'],
                'useStartTime' => $item['couponStartTime'],

                'originalPrice' => $item['originalPrice'],
                'commissionRate' => $item['commissionRate'],
                'searchSource' => 1,
                'shopType' => $item['shopType'],//店铺类型，1-天猫，0-淘宝
            ];
        }

        data_return('ok', 0, [
            'goodsList' => $goodsList,
            'totalNum' => $req['totalNum']
        ]);
    }

    //顶部分类
    public function getTopClass()
    {
        $parentId = !empty($this->params['parentId']) ? $this->params['parentId'] : 0;
        $key = md5(__FILE__ . __FUNCTION__ . $parentId);
        $data = cache($key);
        if (!$data) {
            $data = $this->dtk->tb_super_category();
            if ($data) {
                cache($key, $data, 86400 * 30);
            }
            data_return('ok', 0, $data);
        } else {
            if (!empty($parentId)) {
                $all = array_column($data, null, 'cid');
                $sub = $all[$parentId]['subcategories'];
                $data = [];
                foreach ($sub as $item) {
                    $data[] = [
                        'cid' => $item['subcid'],
                        'cpic' => $item['scpic'],
                        'cname' => $item['subcname'],
                        'parentId' => $parentId,
                    ];
                }
            }
        }
        data_return('ok', 0, $data);
    }

    //首页热区
    public function getMQD()
    {
        //全天榜单
        $reqZdm = $this->dtk->tb_ranking_goods(
            [
                'rankType' => 2,
                'pageId' => 1,
                'pageSize' => 30
            ]
        );
        $zdm = $phb = [];
        if (!empty($reqZdm)) {
            foreach ($reqZdm as $item) {
                $zdm[] = GuideServer::format_tb_item($item);
            }
        }
        //实时疯抢榜单
        $reqPhb = $this->dtk->tb_ranking_goods(
            [
                'rankType' => 1,
                'pageId' => 1,
                'pageSize' => 30
            ]
        );
        if (!empty($reqPhb)) {
            foreach ($reqPhb as $item) {
                $phb[] = GuideServer::format_tb_item($item);
            }
        }
        data_return('ok', 0, [
            'zdm' => $zdm,
            'phb' => $phb,
            'dygoods' => []
        ]);
    }

    //榜单
    public function getRankingGoods()
    {
        $arg['rankType'] = !empty($this->params['rankingType']) ? $this->params['rankingType'] : 1;
        $arg['page'] = !empty($this->params['pageId']) ? $this->params['pageId'] : 1;
        $arg['pageSize'] = !empty($this->params['pageSize']) ? $this->params['pageSize'] : 20;
        //全天榜单
        $req = $this->dtk->tb_ranking_goods($arg);

        $data = [];
        if (!empty($req)) {
            if ($arg['rankType'] == 6) {
                foreach ($req as $value) {
                    if (!empty($value['goodsList'])) {
                        foreach ($value['goodsList'] as $g){
                            $data[] = GuideServer::format_tb_item($g);
                        }
                    }
                }
            } else {
                foreach ($req as $item) {
                    $data[] = GuideServer::format_tb_item($item);
                }
            }

        }

        data_return('ok', 0, ['goodsList' => $data]);

    }

    //首页底部推荐列表
    public function getGoodThing()
    {
        $goodsList = [];
        $type = !empty($this->params['type']) ? $this->params['type'] : 1;
        $arg['page'] = !empty($this->params['pageId']) ? $this->params['pageId'] : 1;
        $arg['pageSize'] = !empty($this->params['pageSize']) ? $this->params['pageSize'] : 20;

        if ($type == 3) {
            //猜你喜欢
            $pddReq = $this->pdd->get_recommend_goods([
                'type' => 4,
                'page' => $arg['page'],
            ]);
            if (!empty($pddReq['data']['list'])) {
                foreach ($pddReq['data']['list'] as $item) {
                    $goodsList[] = [
                        'goodsId' => $item['goods_id'],
                        'goodsSign' => $item['goods_sign'],
                        'title' => $item['goods_name'],
                        'dtitle' => $item['goods_name'],
                        'desc' => $item['goods_desc'],
                        'actualPrice' => round($item['min_group_price'] / 100 - $item['coupon_discount'] / 100, 2),
                        'originalPrice' => round($item['min_normal_price'] / 100, 2),
                        'shopName' => $item['mall_name'],
                        'couponPrice' => round($item['coupon_discount'] / 100, 2),
                        'searchSource' => 2,
                        'shopType' => null,
                        'monthSales' => $item['sales_tip'],
                        'mainPic' => $item['goods_thumbnail_url'],
                        'commissionRate' => round($item['promotion_rate'] / 10, 2),
                        //返现
                        'backmoney' => round(round($item['min_group_price'] / 100 - $item['coupon_discount'] / 100, 2) * $item['promotion_rate'] / 1000, 2),
                        //补贴金额
                        'buMoney' => 0,
                    ];
                }
            }
        } elseif ($type == 6) {
            //美食推荐
            $arg['cids'] = 6;
            $arg['from'] = 'dgapp';
            $req = $this->dtk->goods_tb_list($arg);
            if (empty($req['totalNum'])) {
                data_return('ok', 0);
            }

            foreach ($req['list'] as $item) {
                $goodsList[] = GuideServer::format_tb_item($item);
            }
        } elseif ($type == 4) {
            //日用百货
            $arg['cids'] = 4;
            $arg['from'] = 'dgapp';
            $req = $this->dtk->goods_tb_list($arg);
            if (empty($req['totalNum'])) {
                data_return('ok', 0);
            }

            foreach ($req['list'] as $item) {
                $goodsList[] = GuideServer::format_tb_item($item);
            }
        } elseif ($type == 966) {
            //高佣精选
            $req = $this->dtk->tb_height_commission_goods($arg);
            if (empty($req['totalNum'])) {
                data_return('ok-nodata', 0);
            }

            foreach ($req['list'] as $item) {
                $goodsList[] = GuideServer::format_tb_item($item);
            }
        } else {
            //每日爆品推荐
            $req = $this->dtk->tb_explosive_goods($arg);
            if (empty($req['totalNum'])) {
                data_return('ok', 0);
            }

            foreach ($req['list'] as $item) {
                $goodsList[] = GuideServer::format_tb_item($item);
            }
        }


        data_return('ok', 0, $goodsList);

    }

    //商品列表--点击分类
    public function getGoodsList()
    {
        $arg['page'] = !empty($this->params['pageId']) ? $this->params['pageId'] : 1;
        $arg['pageSize'] = !empty($this->params['pageSize']) ? $this->params['pageSize'] : 20;
        $from = !empty($this->params['from']) ? $this->params['from'] : '';
        $arg['subcid'] = !empty($this->params['cids']) ? $this->params['cids'] : 0;
        if ($arg['subcid'] <= 14) {
            $arg['cids'] = $arg['subcid'];
            $arg['subcid'] = 0;
        }
        $arg['sort'] = !empty($this->params['sort']) ? $this->params['sort'] : 0;

        $arg['from'] = 'dgapp';
        $req = $this->dtk->goods_tb_list($arg);

        if (empty($req['totalNum'])) {
            data_return('ok', 0, [
                'goodsList' => null,
                'topGoodsList' => null,
            ]);
        }
        $goodsList = [];
        foreach ($req['list'] as $item) {
            $goodsList[] = [
                'goodsId' => $item['goodsId'],
                'title' => $item['title'],
                'dtitle' => $item['dtitle'],
                'desc' => $item['desc'],
                'actualPrice' => $item['actualPrice'],
                'originalPrice' => $item['originalPrice'],
                'shopName' => $item['shopName'],
                'couponPrice' => $item['couponPrice'],
                'searchSource' => 1,
                'shopType' => $item['shopType'],
                'monthSales' => $item['monthSales'],
                'mainPic' => $item['mainPic'],
                'commissionRate' => $item['commissionRate'],
                //返现
                'backmoney' => round($item['commissionRate'] / 100 * $item['actualPrice'], 2),
                //补贴金额
                'buMoney' => 0,
            ];
        }
        $topGoodsList = [];
        //每日爆品推荐
        if ($arg['page'] == 1 && $from == 'oneCategory') {

            $req = $this->dtk->tb_explosive_goods([
                'page' => 1,
                'pageSize' => 3,
                'cids' => $arg['subcid'],
            ]);
            if (!empty($req['totalNum'])) {
                foreach ($req['list'] as $item) {
                    $topGoodsList[] = GuideServer::format_tb_item($item);
                }
            }
        }


        data_return('ok', 0, [
            'goodsList' => $goodsList,
            'topGoodsList' => $topGoodsList,
        ]);
    }

    //热词
    public function getHotKey()
    {
        $key = md5(__FILE__ . __FUNCTION__);
        $data = cache($key);
        if ($data) {
            data_return('ok-cache', 0, $data);
        }
        $req = $this->dtk->tb_hot_keyword([
            'type' => 1
        ]);
        $data = [];
        $words = !empty($req['hotWords']) ? $req['hotWords'] : [];
        if (count($words) > 10) {
            $keys = array_rand($words, 10);
            foreach ($words as $k => $v) {
                if (in_array($k, $keys)) {
                    $data [] = $v;
                }
            }
        } else {
            $data = $words;
        }
        cache($key, $data, 7200);
        data_return('ok', 0, $data);

    }

    //联想搜索
    public function searchSuggestion()
    {
        $keyword = input('keyWords', '') ?: '';
        $req = $this->dtk->tb_suggestion([
            'type' => 2,
            'keyWords' => $keyword
        ]);

        data_return('ok', 0, $req);
    }

    //转链
    public function getPrivilegeLink()
    {
        $this->tb_check_auth();
        $req = $this->dtk->link_tb([
            'goodsId' => $this->params['goodsId'],
            'channelId' => $this->defaultTbRelationId,
        ]);
        if (empty($req['shortUrl'])) {
            data_return('网络正忙，请稍后', -1);
        }

        data_return('ok', 0, $req);
    }

    public function getGoodsDetails()
    {
        $req = $this->dtk->goods_tb_detail([
            'goodsId' => $this->params['goodsId']
        ]);

        if (empty($req['goodsId'])) {
            data_return('商品已售罄', -1);
        }

        $data = [
            'cid' => $req['cid'],
            'commissionRate' => $req['commissionRate'],
            //返现
            'backmoney' => round($req['commissionRate'] / 100 * $req['actualPrice'], 2),
            //补贴金额
            'buMoney' => 0,
            'couponEndTime' => $req['couponEndTime'],
            'couponStartTime' => $req['couponStartTime'],
            'couponPrice' => $req['couponPrice'],
            'desc' => $req['desc'],
            'descScore' => $req['descScore'],
            'detailPics' => empty($req['detailPics']) ? [] : array_column(json_decode($req['detailPics'], true), 'img'),
            'dtitle' => $req['dtitle'],
            'goodsId' => $req['goodsId'],
            'id' => $req['id'],
            'imgs' => empty($req['imgs']) ? [] : explode(',', $req['imgs']),
            'isCollection' => null,
            'itemLink' => $req['itemLink'],
            'mainPic' => $req['mainPic'],
            'marketingMainPic' => $req['marketingMainPic'],
            'monthSales' => $req['monthSales'],
            'actualPrice' => $req['actualPrice'],
            'originalPrice' => $req['originalPrice'],
            'searchSource' => 1,
            'sellerId' => $req['sellerId'],
            'serviceScore' => $req['serviceScore'],
            'shipScore' => $req['shipScore'],
            'shopName' => $req['shopName'],
            'shopType' => $req['shopType'],
            'title' => $req['title'],
            'video' => $req['video'],
            'shopLogo' => !empty($req['shopLogo'])?$req['shopLogo']:'',
        ];

        data_return('ok', 0, $data);
    }

    //相似商品
    public function getSimilerGoods()
    {
        $req = $this->dtk->tb_similar_goods([
            'goodsId' => $this->params['goodsId'],
            'size' => 10
        ]);
        if (empty($req)) {
            data_return('ok', 0, null);
        }
        $data = [];
        foreach ($req as $item) {
            $data[] = [
                'actualPrice' => $item['actualPrice'],
                'commissionRate' => $item['commissionRate'],
                'couponPrice' => $item['couponPrice'],
                'couponmoney' => $item['couponPrice'],
                'dtitle' => $item['dtitle'],
                'goodsId' => $item['goodsId'],
                'itemendprice' => $item['actualPrice'],
                'itemid' => $item['goodsId'],
                'itempic' => $item['mainPic'],
                'itemprice' => $item['originalPrice'],
                'itemshorttitle' => $item['dtitle'],
                'itemtitle' => $item['title'],
                'mainPic' => $item['mainPic'],
                'monthSales' => $item['monthSales'],
                'originalPrice' => $item['originalPrice'],
                'searchSource' => 1,
                'shopName' => $item['shopName'],
                'title' => $item['title'],
                'video' => null,
                //返现
                'backmoney' => round($item['commissionRate'] / 100 * $item['actualPrice'], 2),
                //补贴金额
                'buMoney' => 0,
            ];
        }
        data_return('ok', 0, $data);
    }

    //9.9包邮
    public function getNineGoods()
    {
        //-1-精选，1 -5.9元区，2 -9.9元区，3 -19.9元区
        $arg['nineCid'] = !empty($this->params['nineCid']) ? $this->params['nineCid'] : -1;
        $arg['page'] = !empty($this->params['pageId']) ? $this->params['pageId'] : 1;
        $arg['pageSize'] = !empty($this->params['pageSize']) ? $this->params['pageSize'] : 20;
        $req = $this->dtk->tb_nine_goods($arg);
        if (empty($req['list'])) {
            data_return('ok-nodata', 0, null);
        }
        $goodsList = [];
        foreach ($req['list'] as $item) {
            $goodsList[] = GuideServer::format_tb_item($item);
        }
        data_return('ok', 0, [
            'goodsList' => $goodsList
        ]);
    }

    //辣妈优选
    public function optimusMaterial()
    {
        $data = \GuzzleHttp\json_decode('{"cache":false,"code":0,"data":[{"goodsId":"564865933717","title":"宝宝心语胎心监护监测仪器家用孕妇充电听胎心仪听诊测胎动计数器","dtitle":"宝宝心语胎心监护监测仪器家用孕妇充电听胎心仪听诊测胎动计数器","actualPrice":"89","originalPrice":"119","shopName":"孕康医疗器械专营店","couponPrice":"30","monthSales":"1.0万","mainPic":"http://gw.alicdn.com/bao/uploaded/i4/3172291471/O1CN0139S8ib1MjlLuWM1p3_!!3172291471.jpg","video":null,"commissionRate":"0.6","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"39361808010","title":"十月结晶待产包春季入院母子全套孕产妇备产后坐月子用品大全夏季","dtitle":"十月结晶待产包春季入院母子全套孕产妇备产后坐月子用品大全夏季","actualPrice":"99","originalPrice":"129","shopName":"十月结晶靖瑶专卖店","couponPrice":"30","monthSales":"9000","mainPic":"http://gw.alicdn.com/bao/uploaded/i2/2077080843/O1CN01qj8ozF1I68dVGH0te_!!2077080843.jpg","video":null,"commissionRate":"0.9","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"41903729069","title":"听胎心监护仪器孕妇家用专用多普勒充电测胎儿监测胎动无听诊辐射","dtitle":"听胎心监护仪器孕妇家用专用多普勒充电测胎儿监测胎动无听诊辐射","actualPrice":"69","originalPrice":"79","shopName":"亚洲大药房旗舰店","couponPrice":"10","monthSales":"1000","mainPic":"http://gw.alicdn.com/bao/uploaded/i3/764934870/O1CN01Dw2haS1lqVaQNq3aY_!!0-item_pic.jpg","video":null,"commissionRate":"1.8","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"546413214356","title":"爱孕孕妇枕护腰侧睡枕头托腹侧卧u型枕孕期睡觉神器用品夏季抱枕","dtitle":"爱孕孕妇枕护腰侧睡枕头托腹侧卧u型枕孕期睡觉神器用品夏季抱枕","actualPrice":"399","originalPrice":"499","shopName":"爱孕旗舰店","couponPrice":"100","monthSales":"1000","mainPic":"http://gw.alicdn.com/bao/uploaded/i4/1911098847/O1CN01iZxTsS2FDykN9UDMT_!!0-item_pic.jpg","video":null,"commissionRate":"4.5","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"562481791945","title":"婴儿恒温调奶器智能保温冲奶温奶泡奶暖奶家用热奶电水壶热水神器","dtitle":"婴儿恒温调奶器智能保温冲奶温奶泡奶暖奶家用热奶电水壶热水神器","actualPrice":"59","originalPrice":"79","shopName":"全安堂旗舰店","couponPrice":"20","monthSales":"3.0万","mainPic":"http://gw.alicdn.com/bao/uploaded/i3/2189150695/O1CN01uGGd8K1H0M18y7tRd_!!0-item_pic.jpg","video":null,"commissionRate":"0.45","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"548373750266","title":"樱舒婴儿理发器静音自动吸发宝宝剃头发新生儿童超电推子剃发神器","dtitle":"樱舒婴儿理发器静音自动吸发宝宝剃头发新生儿童超电推子剃发神器","actualPrice":"79","originalPrice":"119","shopName":"樱舒旗舰店","couponPrice":"40","monthSales":"1.0万","mainPic":"http://gw.alicdn.com/bao/uploaded/i2/1781251386/O1CN01mrjo7b1M6ph7okied_!!0-item_pic.jpg","video":null,"commissionRate":"4.5","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"572036499707","title":"婴儿背带宝宝腰凳轻便四季多功能前抱式前后两用夏季外出抱娃神器","dtitle":"婴儿背带宝宝腰凳轻便四季多功能前抱式前后两用夏季外出抱娃神器","actualPrice":"39","originalPrice":"69","shopName":"爱心兔旗舰店","couponPrice":"30","monthSales":"4000","mainPic":"http://gw.alicdn.com/bao/uploaded/i1/3896553743/O1CN01a9D7961dWLBqIlQvo_!!0-item_pic.jpg","video":null,"commissionRate":"1.5","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"521599501257","title":"vitabiotics孕妇专用dha钙铁叶酸pregnacare复合孕期营养品维生素","dtitle":"vitabiotics孕妇专用dha钙铁叶酸pregnacare复合孕期营养品维生素","actualPrice":"158","originalPrice":"198","shopName":"Vitabiotics海外旗舰店","couponPrice":"40","monthSales":"1000","mainPic":"http://gw.alicdn.com/bao/uploaded/i3/2634475204/O1CN01OhHY7B1oJTsa1279M_!!0-item_pic.jpg","video":null,"commissionRate":"6.0","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"562141927461","title":"贝适邦大宝宝吸管奶瓶1岁以上2岁3岁防胀气鸭嘴奶瓶ppsu耐摔6个月","dtitle":"贝适邦大宝宝吸管奶瓶1岁以上2岁3岁防胀气鸭嘴奶瓶ppsu耐摔6个月","actualPrice":"19.9","originalPrice":"49.9","shopName":"贝尼母婴专营店","couponPrice":"30","monthSales":"4000","mainPic":"http://gw.alicdn.com/bao/uploaded/i1/474591763/O1CN01h9DWLk1OtV10P5jd2_!!0-item_pic.jpg","video":null,"commissionRate":"6.0","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"547314147886","title":"喂奶神器哺乳枕垫夏季护腰椅婴儿抱娃睡躺抱抱新生托坐抱枕头坐着","dtitle":"喂奶神器哺乳枕垫夏季护腰椅婴儿抱娃睡躺抱抱新生托坐抱枕头坐着","actualPrice":"49.9","originalPrice":"59.9","shopName":"小西米木母婴旗舰店","couponPrice":"10","monthSales":"3000","mainPic":"http://gw.alicdn.com/bao/uploaded/i1/1096750240/O1CN01BV8ZHq1DdxnB5c0cC_!!0-item_pic.jpg","video":null,"commissionRate":"0.9","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"561216572664","title":"多普勒胎心监测仪器孕妇家用听胎心监护胎动无充电听诊辐射检测仪","dtitle":"多普勒胎心监测仪器孕妇家用听胎心监护胎动无充电听诊辐射检测仪","actualPrice":"69","originalPrice":"79","shopName":"深圳瑞康医疗器械专营店","couponPrice":"10","monthSales":"3000","mainPic":"http://gw.alicdn.com/bao/uploaded/i2/3433790201/O1CN01QSj0Cy1DM6LwxjOYq_!!0-item_pic.jpg","video":null,"commissionRate":"1.5","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"525906883467","title":"红色小象奶瓶清洗剂婴儿专用新生宝宝果蔬玩具清洁剂正品天然植萃","dtitle":"红色小象奶瓶清洗剂婴儿专用新生宝宝果蔬玩具清洁剂正品天然植萃","actualPrice":"29","originalPrice":"39","shopName":"红色小象旗舰店","couponPrice":"10","monthSales":"2000","mainPic":"http://gw.alicdn.com/bao/uploaded/i2/2707252427/O1CN01zxi3of1Tnc0Q6E3yC_!!2707252427.jpg","video":null,"commissionRate":"6.0","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"553568487612","title":"新加坡原装进口hegen新生婴儿多功能PPSU奶瓶礼盒一大一小储存盖","dtitle":"新加坡原装进口hegen新生婴儿多功能PPSU奶瓶礼盒一大一小储存盖","actualPrice":"593","originalPrice":"643","shopName":"hegen旗舰店","couponPrice":"50","monthSales":"7000","mainPic":"http://gw.alicdn.com/bao/uploaded/i2/2989413114/O1CN01gWArLX1YsG6MS0EQe_!!0-item_pic.jpg","video":null,"commissionRate":"1.95","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"562561260287","title":"小壮熊家用恒温烧水壶婴儿冲奶调奶器热水保温泡奶粉温奶暖奶神器","dtitle":"小壮熊家用恒温烧水壶婴儿冲奶调奶器热水保温泡奶粉温奶暖奶神器","actualPrice":"88","originalPrice":"108","shopName":"小壮熊旗舰店","couponPrice":"20","monthSales":"4.0万","mainPic":"http://gw.alicdn.com/bao/uploaded/i2/2927925268/O1CN018gtcEN1omnE5zbFHM_!!0-item_pic.jpg","video":null,"commissionRate":"0.6","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"39950296315","title":"可么多么官方旗舰店正品comotomo奶瓶新生婴儿硅胶0到6个月防胀气","dtitle":"可么多么官方旗舰店正品comotomo奶瓶新生婴儿硅胶0到6个月防胀气","actualPrice":"269","originalPrice":"424","shopName":"可么多么旗舰店","couponPrice":"155","monthSales":"1000","mainPic":"http://gw.alicdn.com/bao/uploaded/i3/2114975158/O1CN01sKbUJH1nyPet1jasf_!!0-item_pic.jpg","video":null,"commissionRate":"4.5","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"556372047071","title":"碧c婴儿湿巾纸新生幼儿宝宝手口屁专用湿纸巾家庭实惠大包装特价","dtitle":"碧c婴儿湿巾纸新生幼儿宝宝手口屁专用湿纸巾家庭实惠大包装特价","actualPrice":"14.99","originalPrice":"19.99","shopName":"碧c旗舰店","couponPrice":"5","monthSales":"1.0万","mainPic":"http://gw.alicdn.com/bao/uploaded/i4/2378275931/O1CN01Iihl2K1tgRnAdarr9_!!0-item_pic.jpg","video":null,"commissionRate":"6.0","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"543778357702","title":"博朗红外耳温枪IRT6520德国进口品牌婴幼儿专用体温计温度计测温","dtitle":"博朗红外耳温枪IRT6520德国进口品牌婴幼儿专用体温计温度计测温","actualPrice":"369","originalPrice":"379","shopName":"阿里健康大药房海外店","couponPrice":"10","monthSales":"1000","mainPic":"http://gw.alicdn.com/bao/uploaded/i3/2978398582/O1CN01B4rHUC2DGbmn0tK28_!!2978398582-0-sm.jpg","video":null,"commissionRate":"2.1","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"573722120732","title":"babycare云柔巾成人系列柔抽纸乳霜保湿纸巾S码108抽*6包婴儿可用","dtitle":"babycare云柔巾成人系列柔抽纸乳霜保湿纸巾S码108抽*6包婴儿可用","actualPrice":"34.9","originalPrice":"47.9","shopName":"babycare旗舰店","couponPrice":"13","monthSales":"3.0万","mainPic":"http://gw.alicdn.com/bao/uploaded/i4/2275046294/O1CN01vyRZMY1wMhalJQDoJ_!!0-item_pic.jpg","video":null,"commissionRate":"6.0","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"40689917502","title":"欧孕宝宝夏季薄睡袋婴儿恒温睡袋纯棉儿童春秋分腿防踢被四季通用","dtitle":"欧孕宝宝夏季薄睡袋婴儿恒温睡袋纯棉儿童春秋分腿防踢被四季通用","actualPrice":"79","originalPrice":"129","shopName":"欧孕母婴旗舰店","couponPrice":"50","monthSales":"1000","mainPic":"http://gw.alicdn.com/bao/uploaded/i1/2112306610/O1CN016zqG7K1yhQjrcieAE_!!0-item_pic.jpg","video":null,"commissionRate":"0.45","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"562786267338","title":"温奶器消毒二合一婴儿母乳三合一暖奶器热奶恒温加热奶瓶保温自动","dtitle":"温奶器消毒二合一婴儿母乳三合一暖奶器热奶恒温加热奶瓶保温自动","actualPrice":"49","originalPrice":"89","shopName":"全安堂旗舰店","couponPrice":"40","monthSales":"3000","mainPic":"http://gw.alicdn.com/bao/uploaded/i4/2189150695/O1CN01x523R51H0M0sMBT9i_!!0-item_pic.jpg","video":null,"commissionRate":"0.6","searchSource":"1","shopType":"1","tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null}],"message":"操作成功"}', true);
        data_return('ok', 0, $data['data']);
    }


    //辣妈优选分类
    public function optimusMaterialCategory()
    {
        $data = \GuzzleHttp\json_decode('{"cache":false,"code":0,"data":[{"id":769,"parentId":0,"cid":4040,"cname":"备孕","cpic":null,"sort":null,"status":0,"isDelete":0,"createTime":null,"updateTime":null,"ctype":7},{"id":770,"parentId":0,"cid":4041,"cname":"0至6个月","cpic":null,"sort":null,"status":0,"isDelete":0,"createTime":null,"updateTime":null,"ctype":7},{"id":771,"parentId":0,"cid":4042,"cname":"7至12个月","cpic":null,"sort":null,"status":0,"isDelete":0,"createTime":null,"updateTime":null,"ctype":7},{"id":772,"parentId":0,"cid":4043,"cname":"1至3岁","cpic":null,"sort":null,"status":0,"isDelete":0,"createTime":null,"updateTime":null,"ctype":7},{"id":773,"parentId":0,"cid":4044,"cname":"4至6岁","cpic":null,"sort":null,"status":0,"isDelete":0,"createTime":null,"updateTime":null,"ctype":7},{"id":774,"parentId":0,"cid":4045,"cname":"7至12岁","cpic":null,"sort":null,"status":0,"isDelete":0,"createTime":null,"updateTime":null,"ctype":7}],"message":"操作成功"}', true);
        data_return('ok', 0, $data['data']);
    }

}