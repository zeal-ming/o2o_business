<?php
namespace app\index\controller;

class Index extends Base
{
    public function index()
    {
        //获取首页轮播图推荐位的信息
        $featureBig = model('Featured')->getAllNormalFeatured();

        //获取右侧小图推荐位
        $featureSmall = model('Featured')->getAllNormalFeatured(1)[0];

        //获取首页商品数据
        $foodData = model('Deal')->getNormalDealByCategoryId(1,10,$this->city->id);

        //查询美食栏目下的4个子分类
        $foodSeData = model('Category')->getCategoryByParentId(1,4);

//        dump($this->city->id);
//        dump($foodData);

//        dump($featureSmall);
        return $this->fetch('',[
            'featuredBig' => $featureBig,
            'featuredSmall' => $featureSmall,
            'foodData' => $foodData,
            'food_seData' => $foodSeData,
        ]);
    }
}
