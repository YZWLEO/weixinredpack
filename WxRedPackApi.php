<?php

namespace app\common\wxpayapi\lib;
use app\common\BasePayment;

/**
 *
 * 接口访问类，包含所有微信红包API列表的封装，类中方法为static方法，
 * @author leo.yzw@foxmail.com
 *
 * 发放规则
 * 1.发送频率限制------默认1800/min
 * 2.发送个数上限------按照默认1800/min算
 * 3.金额上限------根据传入场景id不同默认上限不同，可以在商户平台产品设置进行设置和申请，最大不大于4999元/个
 * 4.其他的“量”上的限制还有哪些？------用户当天的领取上限次数,默认是10
 * 5.如果量上满足不了我们的需求，如何提高各个上限？------金额上限和用户当天领取次数上限可以在商户平台进行设置
 * 注意1-红包金额大于200时，请求参数scene_id必传，参数说明见下文。
 * 注意2-新申请商户号使用企业付款需要满足两个条件：1、入驻时间超过90天 2、连续正常交易30天。
 */
class WxRedPackApi extends BasePayment
{

    /**
     *
     * 普通红包发送
     * wxappid、mch_id、client_ip、nonce_str,total_num不需要填入
     * mch_billno,send_name,re_openid,total_amount,wishing,act_name,remark
     * @param WxRedPack $inputObj
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public static function sendredpack(WxRedPack $inputObj, $timeOut = 6) {
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        //检测必填参数
        if (!$inputObj->IsMch_billnoSet()) {
            throw new WxPayException("缺少必填参数mch_billno！");
        } else if (!$inputObj->IsSend_nameSet()) {
            throw new WxPayException("缺少必填参数send_name！");
        } else if (!$inputObj->IsRe_openidSet()) {
            throw new WxPayException("缺少必填参数re_opendid！");
        } else if (!$inputObj->IsTotal_amountSet()) {
            throw new WxPayException("缺少必填参数total_amount！");
        } else if (!$inputObj->IsWishingSet()) {
            throw new WxPayException("缺少必填参数wishing！");
        } else if (!$inputObj->IsAct_nameSet()) {
            throw new WxPayException("缺少必填参数act_name！");
        } else if (!$inputObj->IsRemarkSet()) {
            throw new WxPayException("缺少必填参数remark！");
        }
        //关联参数
        if ($inputObj->GetTotal_amount() > 20000 && !$inputObj->IsScene_idSet()) {
            throw new WxPayException("缺少必填参数scene_id！红包金额大于200时必传！");
        }
        $inputObj->SetWxappid(WxPayConfig::APPID);//公众账号ID
        $inputObj->SetMch_id(WxPayConfig::MCHID);//商户号
        $inputObj->SetClient_ip($_SERVER['REMOTE_ADDR']);
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串
        $inputObj->SetTotal_num(1);

        //签名
        $inputObj->SetSign();
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, true, $timeOut);
        $result = WxPayResults::Init($response);

        return $result;

    }

    /**
     *
     * 裂变红包发送
     * wxappid、mch_id、nonce_str,amt_type不需要填入
     * mch_billno,send_name,re_openid,total_amount,total_num,wishing,act_name,remark
     * @param WxRedPack $inputObj
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public static function sendgroupredpack(WxRedPack $inputObj, $timeOut = 6) {
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
        //检测必填参数
        if (!$inputObj->IsMch_billnoSet()) {
            throw new WxPayException("缺少必填参数mch_billno！");
        } else if (!$inputObj->IsSend_nameSet()) {
            throw new WxPayException("缺少必填参数send_name！");
        } else if (!$inputObj->IsRe_openidSet()) {
            throw new WxPayException("缺少必填参数re_opendid！");
        } else if (!$inputObj->IsTotal_amountSet()) {
            throw new WxPayException("缺少必填参数total_amount！");
        } else if (!$inputObj->IsTotal_numSet()) {
            throw new WxPayException("缺少必填参数total_num！");
        } else if (!$inputObj->IsWishingSet()) {
            throw new WxPayException("缺少必填参数wishing！");
        } else if (!$inputObj->IsAct_nameSet()) {
            throw new WxPayException("缺少必填参数act_name！");
        } else if (!$inputObj->IsRemarkSet()) {
            throw new WxPayException("缺少必填参数remark！");
        }

        $inputObj->SetWxappid(WxPayConfig::APPID);//公众账号ID
        $inputObj->SetMch_id(WxPayConfig::MCHID);//商户号
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串
        $inputObj->SetAct_name("ALL_RAND");

        //签名
        $inputObj->SetSign();
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, true, $timeOut);
        $result = WxPayResults::Init($response);

        return $result;
    }

    /**
     *
     * 用于商户对已发放的红包进行查询红包的具体信息，可支持普通红包和裂变包，
     * WxRedPack中mch_billno 必填
     * appid、mch_id 、nonce_str,bill_type不需要填入
     * @param WxRedPack $inputObj
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public static function redpackQuery(WxRedPack $inputObj, $timeOut = 6) {
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo";
        //检测必填参数
        if (!$inputObj->IsMch_billnoSet()) {
            throw new WxPayException("红包查询 mch_billno必填！");
        }
        $inputObj->SetAppid(WxPayConfig::APPID);//公众账号ID
        $inputObj->SetMch_id(WxPayConfig::MCHID);//商户号
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串
        $inputObj->SetBill_type('MCHT');

        $inputObj->SetSign();//签名
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, true, $timeOut);
        $result = WxPayResults::Init($response);
        return $result;
    }

    /**
     *
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public static function getNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml 需要post的xml数据
     * @param string $url url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second url执行超时时间，默认30s
     * @throws WxPayException
     */
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30) {
        self::logPay($xml, "WXRedPack_XML");
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        //如果有配置代理这里就设置代理
        if (WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0
        ) {
            curl_setopt($ch, CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch, CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);//严格校验
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if ($useCert == true) {
            $path = \Yii::getAlias('@webroot');
            $certPath = $path.'/../common/wxpayapi/cert/';
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, $certPath.WxPayConfig::SSLCERT_PATH);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, $certPath.WxPayConfig::SSLKEY_PATH);
            //curl_setopt($ch,CURLOPT_CAPATH,$certPath);
            curl_setopt($ch,CURLOPT_CAINFO,$certPath.WxPayConfig::SSLCA_PATH);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            self::logPay($data, "WXRedPack_XML_Response");
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }
}

