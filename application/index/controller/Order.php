<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/30
 * Time: 上午10:14
 */

namespace app\index\controller;

class Order extends Base
{

    public function index()
    {

        $id = input('id', 0, 'intval');
        $deal = model('Deal')->get($id);

        return $this->fetch('', [
            'title' => '订单确认页',
            'controller' => 'pay',
            'deal' => $deal
        ]);
    }

    //确认则调用支付宝接口进行支付
    public function orderconfirm()
    {
        $postData = input('post.');
        
        $deal = model('Deal')->get($postData['id']);

        //订单号规则: 10位的时间戳+用户ID+4位随机数
        $data = [
            'trade_id' => time() . $this->account->id . mt_rand(1000, 10000),
            'user_id' => $this->account->id,
            'deal_id' => $postData['id'],
            'description' => $deal->description,
            'last_ip' => get_client_ip(),
            'bis_id' => $deal->bis_id,
            'buy_count' => $postData['buy_count'],
            'total_price' => $postData['total_price']
        ];

        //存入数据库
        $res = model('Order')->save($data);

        if(!$res){
           return $this->error('订单生成失败');
        }

        //前往支付页面,引入支付宝接口
        //构造支付参数,键值按如下填写
        $payData = [
            'out_trade_no' => $data['trade_id'],
            'subject' => 'hello kitty',
            'total_amount' => $data['total_price'],
        ];

        \alipay\Pagepay::pay($payData);

    }

    //提供给支付宝的用来支付成功后的跳转页面,不能保证一定成功
    public function finishPay(){
//        print_r($_GET);
        if(!empty($_GET))
        {
            //订单号
            $trade_id = $_GET['out_trade_no'];
            //更新订单状态
            $res = model('Order')->save(['status'=>1],['trade_id' => $trade_id]);

            if(!$res) {
                $this->error('订单更新失败');
            }

            $this->success('订单更新成功',url('index/index'),'',1);
        }
    }

    //notify_url
//    public function finish_notify(){
//
//    }
}