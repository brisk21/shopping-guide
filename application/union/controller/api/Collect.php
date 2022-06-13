<?php


namespace app\union\controller\api;


class Collect extends DgApiBase
{
    public function tbGoodsIsCollect()
    {
        data_return('ok',0,[
            'isCollect' => 'Y'
        ]);
    }

    public function saveCollect()
    {
        data_return('未登录',-1,input());
    }

    public function cancelCollect()
    {
        data_return('未登录',-1,input());
    }

    public function getList()
    {
        $data = json_Decode('{"cache":false,"code":0,"data":{"listId":"b84e2155-e543-461e-a933-0791ead712e5","searchId":"b84e2155-e543-461e-a933-0791ead712e5","totalNum":"837","goodsList":[{"goodsId":"332671220811","title":"春秋季外套韩版潮流青少年夹克宽松港风ins潮百搭印花学生棒球服","dtitle":"春秋季外套韩版潮流青少年夹克宽松港风ins潮百搭印花学生棒球服","actualPrice":"4.9","originalPrice":"14.9","shopName":"邦美男装","couponPrice":"10","monthSales":"1万","mainPic":"https://img.pddpic.com/gaudit-image/2022-03-11/cda1657883820798e52e92dfd6dca7db.jpeg","video":null,"commissionRate":"1.4","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"232664511296","title":"防晒衣男冰丝夏天超薄款透气韩版运动风衣防紫外线防晒服夹克外套","dtitle":"防晒衣男冰丝夏天超薄款透气韩版运动风衣防紫外线防晒服夹克外套","actualPrice":"27.9","originalPrice":"29.9","shopName":"佐莱珂官方旗舰店","couponPrice":"2","monthSales":"10万+","mainPic":"https://t00img.yangkeduo.com/goods/images/2021-04-08/d9210a7f6884dbf89cbbd86fb6e6be55.jpeg","video":null,"commissionRate":"3.6","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"218998431416","title":"春秋男士外套潮流韩版工装夹克青少年学生上衣服休闲连帽男装褂子","dtitle":"春秋男士外套潮流韩版工装夹克青少年学生上衣服休闲连帽男装褂子","actualPrice":"17.8","originalPrice":"17.8","shopName":"寻想官方旗舰店","couponPrice":"0","monthSales":"10万+","mainPic":"https://img.pddpic.com/gaudit-image/2022-02-14/5e7ef443d1499b679a2a7c8f1e6f2f36.jpeg","video":null,"commissionRate":"14.4","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"320008783036","title":"2022破洞春秋季牛仔夹克男浅色新款春装上衣韩版潮流褂子学生外套","dtitle":"2022破洞春秋季牛仔夹克男浅色新款春装上衣韩版潮流褂子学生外套","actualPrice":"15.9","originalPrice":"19.9","shopName":"穿越新时尚服饰","couponPrice":"4","monthSales":"4807","mainPic":"https://img.pddpic.com/gaudit-image/2022-01-03/b1d4ed2ccb278243ba3ae34847fcdd1c.jpeg","video":null,"commissionRate":"1.4","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"292051725989","title":"vintage棒球服外套男春秋季潮流韩版港风宽松ins百搭夹克休闲上衣","dtitle":"vintage棒球服外套男春秋季潮流韩版港风宽松ins百搭夹克休闲上衣","actualPrice":"4.95","originalPrice":"12.95","shopName":"型男馆","couponPrice":"8","monthSales":"6676","mainPic":"https://img.pddpic.com/gaudit-image/2021-12-19/8b5679a497074ec49ad08eda14c196a2.jpeg","video":null,"commissionRate":"1.4","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"221267993155","title":"夏季防晒衣男外套薄款透气速干防晒服男学生夹克防紫外线皮肤衣女","dtitle":"夏季防晒衣男外套薄款透气速干防晒服男学生夹克防紫外线皮肤衣女","actualPrice":"11.36","originalPrice":"12.36","shopName":"雅仕莱服饰箱包","couponPrice":"1","monthSales":"10万+","mainPic":"https://t00img.yangkeduo.com/goods/images/2021-02-25/d170c702ae4c480ee42c3940eb6e7431.jpeg","video":null,"commissionRate":"7.2","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"80037153075","title":"富贵鸟高档中老年春秋外套男商务男士大码男装秋冬中年夹克爸爸装","dtitle":"富贵鸟高档中老年春秋外套男商务男士大码男装秋冬中年夹克爸爸装","actualPrice":"58","originalPrice":"71","shopName":"杰定慧服装专营店","couponPrice":"13","monthSales":"4.1万","mainPic":"https://img.pddpic.com/gaudit-image/2021-11-08/a52796e29ef3be1a0bb7ea9c1fabd380.jpeg","video":null,"commissionRate":"14.4","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"323612570987","title":"春秋季2022新款情侣装棒球服外套男潮流帅气宽松ins百搭痞帅夹克","dtitle":"春秋季2022新款情侣装棒球服外套男潮流帅气宽松ins百搭痞帅夹克","actualPrice":"11","originalPrice":"12","shopName":"艺凤女装服饰","couponPrice":"1","monthSales":"10万+","mainPic":"https://img.pddpic.com/gaudit-image/2022-04-19/5f8338b1b94b075ebb0bf56c38a6d9a2.jpeg","video":null,"commissionRate":"4.3","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"335582331351","title":"【啄木鸟PLOVER】冰丝夏季防晒衣男士外套宽松潮流防晒服透气男装","dtitle":"【啄木鸟PLOVER】冰丝夏季防晒衣男士外套宽松潮流防晒服透气男装","actualPrice":"18.8","originalPrice":"19.8","shopName":"帝轩男装专营店","couponPrice":"1","monthSales":"2.8万","mainPic":"https://img.pddpic.com/gaudit-image/2022-04-19/55133a25295d1a33200bbb9a3f691975.jpeg","video":null,"commissionRate":"1.4","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null},{"goodsId":"225736470281","title":"花花公子贵宾防晒衣男轻薄夹克男外套时尚防晒衣服男学生外套","dtitle":"花花公子贵宾防晒衣男轻薄夹克男外套时尚防晒衣服男学生外套","actualPrice":"14.9","originalPrice":"14.9","shopName":"雪屋鸟男装专营店","couponPrice":"0","monthSales":"5.5万","mainPic":"https://img.pddpic.com/gaudit-image/2022-02-28/ff00d61c136101b5178c125af8402dec.jpeg","video":null,"commissionRate":"0.7","searchSource":"2","shopType":null,"tchaoshi":null,"imageList":null,"useStartTime":null,"useEndTime":null}]},"message":"操作成功"}',true);
        data_return('ok',0,$data['data']['goodsList']);
    }
}