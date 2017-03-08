<?php

namespace App;

use App\Jobs\ExportBarcodeJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\BarcodeExport
 *
 * @property integer $id
 * @property integer $generate_barcode_task_id
 * @property integer $total
 * @property integer $finish_num
 * @property string $file
 * @property boolean $status
 * @property string $running_at
 * @property string $finished_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereGenerateBarcodeTaskId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereFinishNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereFile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereRunningAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereFinishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeExport whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read \App\GenerateBarcodeTask $generate
 * @property-read mixed $is_cancel
 * @property-read mixed $is_finish
 * @property-read mixed $is_fail
 * @property-read mixed $is_running
 * @property-read mixed $is_wait
 * @property-read mixed $status_text
 */
class BarcodeExport extends Model
{
    const STATUS_WAIT = 10;
    const STATUS_RUNNING = 20;
    const STATUS_FINISH = 30;
    const STATUS_FAIL = 40;
    const STATUS_CANCEL = 50;

    protected $attributes = [
        'status' => self::STATUS_WAIT
    ];

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->total = $model->generate->total;
            $model->file = date('YmdHis') . '.txt';
        });
        self::registerModelEvent('updating', function (self $model) {
            if ($model->finish_num == $model->total) {
                $model->status = self::STATUS_FINISH;
                $model->finished_at = Carbon::now();
            }
        });
        self::registerModelEvent('created', function (self $model) {
            $model->pushTaskToQueue();
        });
    }

    public static function statusLabelList()
    {
        return [
            self::STATUS_WAIT => '等待执行',
            self::STATUS_RUNNING => '执行中',
            self::STATUS_FINISH => '已完成',
            self::STATUS_CANCEL => '已取消',
            self::STATUS_FAIL => '执行失败',
        ];
    }

    public function getIsCancelAttribute()
    {
        return $this->status === self::STATUS_CANCEL;
    }

    public function getIsFinishAttribute()
    {
        return $this->status === self::STATUS_FINISH;
    }

    public function getIsFailAttribute()
    {
        return $this->status === self::STATUS_FAIL;
    }

    public function getIsRunningAttribute()
    {
        return $this->status === self::STATUS_RUNNING;
    }

    public function getIsWaitAttribute()
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function getStatusTextAttribute()
    {
        return self::statusLabelList()[$this->status];
    }

    public function running()
    {
        if ($this->status === self::STATUS_WAIT) {
            $this->status = self::STATUS_RUNNING;
            $this->running_at = Carbon::now();
            $this->saveOrFail();
        }
    }

    public function fail()
    {
        if ($this->status === self::STATUS_RUNNING) {
            $this->status = self::STATUS_FAIL;
            $this->saveOrFail();
        }
    }

    public function cancel()
    {
        if ($this->status !== self::STATUS_CANCEL) {
            $this->status = self::STATUS_CANCEL;
            $this->saveOrFail();
        }
    }

    public function finish($num)
    {
        if ($this->status === self::STATUS_RUNNING) {
            $this->finish_num += $num;
            $this->saveOrFail();
        }
    }

    protected function pushTaskToQueue()
    {
        dispatch(new ExportBarcodeJob($this));
    }

    public function generate()
    {
        return $this->belongsTo('App\GenerateBarcodeTask', 'generate_barcode_task_id');
    }
}
