

- weixinredpack
- 微信红包类
- 基于以前做的一个内部支付系统的微信部分红包类封装及简单使用
- 本项目采用容器化微服务处理，是企业内部的一个公共支付通道
- 以下是简单微信红包使用demo
```
public function actionRedpack(){
    $inputObj = new WxRedPack();
    $inputObj->SetMch_billno("REDPACK".date("ymd").time());
    $inputObj->SetRe_openid('on9r51P0GuwCfizNdERZFsd725wo');
    $inputObj->SetSend_name('高兴舅好');
    $inputObj->SetTotal_amount(100);
    $inputObj->SetWishing('恭喜尼，祝福尼，舅服尼！');
    $inputObj->SetAct_name("舅爱活动");
    $inputObj->SetRemark('赞点红包去划船,淘气的诗和远方');
    $rst = WxRedPackApi::sendredpack($inputObj);
    echo '<pre>';

    print_r($rst);

}
```

