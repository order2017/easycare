<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Withdraw;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WithdrawJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $model;

    /**
     * WithdrawJob constructor.
     * @param Withdraw $model
     */
    public function __construct(Withdraw $model)
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
        if ($this->model->status == Withdraw::STATUS_WAIT) {
            $this->model->running();
            if ($result = app('wechat')->merchant_pay->send([
                'partner_trade_no' => $this->model->serial_number,
                'openid' => $this->model->user->openid,
                'check_name' => 'NO_CHECK',
                'amount' => $this->model->money * 100,
                'desc' => $this->model->integral .'积分提现',
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
        }
    }
}
