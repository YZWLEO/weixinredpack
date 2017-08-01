<?php

namespace app\controllers;

use app\common\Fun;
use app\common\wxpayapi\lib\WxPayConfig;
use app\common\wxpayapi\lib\WxRedPack;
use app\common\wxpayapi\lib\WxRedPackApi;
use app\common\WxPayment;
use app\components\BaseController;
use app\logics\ServicePaymentDone;
use app\logics\UnionOrder;
use app\logics\WxNotify;
use app\models\AccountLedger;
use app\models\Order;
use app\models\Prepaid;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Response;

class TestController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
        ];
    }


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

}
