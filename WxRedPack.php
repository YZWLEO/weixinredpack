<?php

namespace app\common\wxpayapi\lib;

use app\common\wxpayapi\lib\WxPayConfig;
use app\common\wxpayapi\lib\WxPayException;
use app\common\wxpayapi\lib\WxPayDataBase;

/**
 *支付系统
 *微信红包 封装类
 * @link https://pay.weixin.qq.com/wiki/doc/api/tools/cash_coupon.php?chapter=13_4&index=3
 * @author leo.yzw@foxmail.com
 *
 */
class WxRedPack extends WxPayDataBase
{


    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
     * @param string $value
     **/
    public function SetNonce_str($value) {
        $this->values['nonce_str'] = $value;
    }

    /**
     * 获取随机字符串，不长于32位。推荐随机数生成算法的值
     * @return 值
     **/
    public function GetNonce_str() {
        return $this->values['nonce_str'];
    }

    /**
     * 判断随机字符串，不长于32位。推荐随机数生成算法是否存在
     * @return true 或 false
     **/
    public function IsNonce_strSet() {
        return array_key_exists('nonce_str', $this->values);
    }

    /**
     * 设置微信分配的公众账号ID
     * @param string $value
     **/
    public function SetWxappid($value) {
        $this->values['wxappid'] = $value;
    }

    /**
     * 获取微信分配的公众账号ID的值
     * @return 值
     **/
    public function GetWxappid() {
        return $this->values['wxappid'];
    }

    /**
     * 判断微信分配的公众账号ID是否存在
     * @return true 或 false
     **/
    public function IsWxappidSet() {
        return array_key_exists('wxappid', $this->values);
    }


    /**
     * 设置微信支付分配的商户号
     * @param string $value
     **/
    public function SetMch_id($value) {
        $this->values['mch_id'] = $value;
    }

    /**
     * 获取微信支付分配的商户号的值
     * @return 值
     **/
    public function GetMch_id() {
        return $this->values['mch_id'];
    }

    /**
     * 判断微信支付分配的商户号是否存在
     * @return true 或 false
     **/
    public function IsMch_idSet() {
        return array_key_exists('mch_id', $this->values);
    }


    public function SetMch_billno($value) {
        $this->values['mch_billno'] = $value;
    }

    public function GetMch_billno() {
        return $this->values['mch_billno'];
    }

    public function IsMch_billnoSet() {
        return array_key_exists('mch_billno', $this->values);
    }

    public function SetSend_name($value) {
        $this->values['send_name'] = $value;
    }

    public function GetSend_name() {
        return $this->values['send_name'];
    }

    public function IsSend_nameSet() {
        return array_key_exists('send_name', $this->values);
    }

    public function SetRe_openid($value) {
        $this->values['re_openid'] = $value;
    }

    public function GetRe_openid() {
        return $this->values['re_openid'];
    }

    public function IsRe_openidSet() {
        return array_key_exists('re_openid', $this->values);
    }

    /**
     * 设置订单总金额，只能为整数，详见支付金额
     * @param string $value
     **/
    public function SetTotal_amount($value) {
        $this->values['total_amount'] = $value;
    }

    /**
     * 获取订单总金额，只能为整数，详见支付金额的值
     * @return 值
     **/
    public function GetTotal_amount() {
        return $this->values['total_amount'];
    }

    /**
     * 判断订单总金额，只能为整数，详见支付金额是否存在
     * @return true 或 false
     **/
    public function IsTotal_amountSet() {
        return array_key_exists('total_amount', $this->values);
    }

    public function SetTotal_num($value) {
        $this->values['total_num'] = $value;
    }

    public function GetTotal_num() {
        return $this->values['total_num'];
    }

    public function IsTotal_numSet() {
        return array_key_exists('total_num', $this->values);
    }

    public function SetWishing($value) {
        $this->values['wishing'] = $value;
    }

    public function GetWishing() {
        return $this->values['wishing'];
    }

    public function IsWishingSet() {
        return array_key_exists('wishing', $this->values);
    }

    public function SetClient_ip($value) {
        $this->values['client_ip'] = $value;
    }

    public function GetClient_ip() {
        return $this->values['client_ip'];
    }

    public function IsClient_ipSet() {
        return array_key_exists('client_ip', $this->values);
    }

    public function SetAct_name($value) {
        $this->values['act_name'] = $value;
    }

    public function GetAct_name() {
        return $this->values['act_name'];
    }

    public function IsAct_nameSet() {
        return array_key_exists('act_name', $this->values);
    }

    public function SetRemark($value) {
        $this->values['remark'] = $value;
    }

    public function GetRemark() {
        return $this->values['remark'];
    }

    public function IsRemarkSet() {
        return array_key_exists('remark', $this->values);
    }

    /**
     * 发放红包使用场景，红包金额大于200时必传
     * PRODUCT_1:商品促销
     * PRODUCT_2:抽奖
     * PRODUCT_3:虚拟物品兑奖
     * PRODUCT_4:企业内部福利
     * PRODUCT_5:渠道分润
     * PRODUCT_6:保险回馈
     * PRODUCT_7:彩票派奖
     * PRODUCT_8:税务刮奖
     */
    public function SetScene_id($value) {
        $this->values['scene_id'] = $value;
    }

    public function GetScene_id() {
        return $this->values['scene_id'];
    }

    public function IsScene_idSet() {
        return array_key_exists('scene_id', $this->values);
    }

    public function SetRisk_info($value) {
        $this->values['risk_info'] = $value;
    }

    public function GetRisk_info() {
        return $this->values['risk_info'];
    }

    public function IsRisk_infoSet() {
        return array_key_exists('risk_info', $this->values);
    }

    public function SetConsume_mch_id($value) {
        $this->values['consume_mch_id'] = $value;
    }

    public function GetConsume_mch_id() {
        return $this->values['consume_mch_id'];
    }

    public function IsConsume_mch_idSet() {
        return array_key_exists('consume_mch_id', $this->values);
    }

    public function SetAmt_type($value) {
        $this->values['amt_type'] = $value;
    }

    public function GetAmt_type() {
        return $this->values['amt_type'];
    }

    public function IsAmt_typeSet() {
        return array_key_exists('amt_type', $this->values);
    }

    public function SetBill_type($value) {
        $this->values['bill_type'] = $value;
    }

    public function GetBill_type() {
        return $this->values['bill_type'];
    }

    public function IsBill_typeSet() {
        return array_key_exists('bill_type', $this->values);
    }

    /**
     * 设置微信分配的公众账号ID
     * @param string $value
     **/
    public function SetAppid($value) {
        $this->values['appid'] = $value;
    }

    /**
     * 获取微信分配的公众账号ID的值
     * @return 值
     **/
    public function GetAppid() {
        return $this->values['appid'];
    }

    /**
     * 判断微信分配的公众账号ID是否存在
     * @return true 或 false
     **/
    public function IsAppidSet() {
        return array_key_exists('appid', $this->values);
    }

}
