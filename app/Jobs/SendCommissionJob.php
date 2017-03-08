<?php

namespace App\Jobs;

use App\CommissionBlotter;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCommissionJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $model;

    public function __construct(CommissionBlotter $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->model->status == CommissionBlotter::STATUS_WAIT) {
            $this->model->running();
            if ($this->model->numerical > 200) {
                if ($result = app('wechat')->merchant_pay->send([
                    'partner_trade_no' => $this->model->serial_number,
                    'openid' => $this->model->user->openid,
                    'check_name' => 'NO_CHECK',
                    'amount' => $this->model->numerical * 100,
                    'desc' => $this->model->remark,
                    'spbill_create_ip' => '192.168.1.1',
                ])
                ) {
                    if ($result['result_code'] == 'SUCCESS') {
                        $this->model->success($result['payment_no']);
                    } elseif ($result['err_code'] == 'FREQ_LIMIT') {
                        $this->delay(15);
                        $this->model->retry();
                    } else {
                        $this->model->fail($result['err_code_des']);
                    }
                } else {
                    $this->model->fail('请求错误');
                }
            } else {
                if ($result = app('wechat')->lucky_money->send([
                    'mch_billno' => $this->model->serial_number,
                    'send_name' => '伊斯卡尔',
                    're_openid' => $this->model->user->openid,
                    'total_num' => 1,
                    'total_amount' => $this->model->numerical * 100,
                    'wishing' => $this->model->remark,
                    'act_name' => $this->model->remark,
                    'remark' => $this->model->remark,
                ], \EasyWeChat\Payment\LuckyMoney\API::TYPE_NORMAL)
                ) {
                    if ($result['result_code'] == 'SUCCESS') {
                        $this->model->success($result['send_listid']);
                    } elseif ($result['err_code'] == 'FREQ_LIMIT') {
                        $this->delay(3600);
                        $this->model->retry();
                    } else {
                        $this->model->fail($result['err_code_des']);
                    }
                } else {
                    $this->model->fail('请求错误');
                }
            }
        }
    }
}
