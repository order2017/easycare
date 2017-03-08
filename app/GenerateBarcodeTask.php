<?php

namespace App;

use App\Jobs\GenerateBarcodeJob;
use App\Jobs\ImportBarcodeJob;
use App\Jobs\TestJob;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use SplFileObject;

/**
 * App\GenerateBarcodeTask
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $product_id
 * @property string $product_model
 * @property integer $box_unit
 * @property integer $box_num
 * @property integer $total
 * @property integer $finish_num
 * @property boolean $status
 * @property string $finished_at
 * @property string $serial_number
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereProductModel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereBoxUnit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereBoxNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereFinishNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereFinishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereDeletedAt($value)
 * @property-read \App\Product $product
 * @property string $running_at
 * @property-read mixed $is_cancel
 * @property-read mixed $is_finish
 * @property-read mixed $is_fail
 * @property-read mixed $is_running
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereRunningAt($value)
 * @property-read mixed $is_wait
 * @property-read mixed $status_text
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BarcodeExport[] $exportTask
 * @property string $import_num
 * @property-read mixed $can_cancel
 * @property-read mixed $is_import_ing
 * @property-read mixed $is_import_wait
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereSerialNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GenerateBarcodeTask whereImportNum($value)
 */
class GenerateBarcodeTask extends Model
{

    const STATUS_WAIT = 10;
    const STATUS_RUNNING = 20;
    const STATUS_FINISH = 30;
    const STATUS_FAIL = 40;
    const STATUS_CANCEL = 50;
    const STATUS_IMPORT_WAIT = 55;
    const STATUS_IMPORT_ING = 60;
    const STATUS_IMPORT_FINISH = 70;
    const STATUS_IMPORT_FAIL = 80;
    const STATUS_IMPORT_CANCEL = 80;

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->total = $model->box_num * $model->box_unit;
            $model->product_model = $model->product->model;
            $model->serial_number = md5(microtime());
        });
        self::registerModelEvent('updating', function (self $model) {
            if ($model->finish_num == $model->total && $model->status == self::STATUS_RUNNING) {
                $model->status = self::STATUS_FINISH;
                $model->finished_at = Carbon::now();
            }
            if ($model->import_num == $model->total && $model->status == self::STATUS_IMPORT_ING) {
                $model->status = self::STATUS_IMPORT_FINISH;
                \Storage::delete($model->serial_number . '.txt');
            }
        });
        self::registerModelEvent('updated', function (self $model) {
            if ($model->status == self::STATUS_IMPORT_WAIT && $model->isDirty('status')) {
                $model->pushImportTaskToQueue();
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
            self::STATUS_IMPORT_WAIT => '等待导入',
            self::STATUS_IMPORT_ING => '导入中',
            self::STATUS_IMPORT_FINISH => '导入完成',
            self::STATUS_IMPORT_FAIL => '导入失败',
            self::STATUS_IMPORT_CANCEL => '已取消导入',
        ];
    }

    protected $fillable = [
        'product_id',
        'box_unit',
        'box_num',
    ];

    protected $attributes = [
        'status' => self::STATUS_WAIT
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function getIsCancelAttribute()
    {
        return $this->status === self::STATUS_CANCEL;
    }

    public function getIsFinishAttribute()
    {
        return $this->status === self::STATUS_FINISH;
    }

    public function getCanCancelAttribute()
    {
        return in_array($this->status, [self::STATUS_WAIT, self::STATUS_RUNNING, self::STATUS_IMPORT_ING, self::STATUS_IMPORT_WAIT]);
    }

    public function getIsFailAttribute()
    {
        return $this->status === self::STATUS_FAIL;
    }

    public function getIsRunningAttribute()
    {
        return $this->status === self::STATUS_RUNNING;
    }

    public function getIsImportIngAttribute()
    {
        return $this->status === self::STATUS_IMPORT_ING;
    }

    public function getIsImportWaitAttribute()
    {
        return $this->status === self::STATUS_IMPORT_WAIT;
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

    public function runImport()
    {
        if ($this->status === self::STATUS_IMPORT_WAIT) {
            $this->status = self::STATUS_IMPORT_ING;
            $this->saveOrFail();
        }
    }

    public function failImport()
    {
        if ($this->status === self::STATUS_IMPORT_ING) {
            $this->status = self::STATUS_IMPORT_FAIL;
            $this->saveOrFail();
        }
    }

    public function finishImport($num)
    {
        if ($this->status === self::STATUS_IMPORT_ING) {
            $this->import_num += $num;
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
        if ($this->status > self::STATUS_FINISH && $this->status !== self::STATUS_IMPORT_CANCEL) {
            $this->status = self::STATUS_IMPORT_CANCEL;
            $this->saveOrFail();
        } else if ($this->status !== self::STATUS_CANCEL) {
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

    public function import()
    {
        if ($this->status == self::STATUS_FINISH) {
            $this->status = self::STATUS_IMPORT_WAIT;
            $this->saveOrFail();
        }
    }


    protected function pushTaskToQueue()
    {
        $baseNum = self::whereProductId($this->product_id)->where('id', '!=', $this->id)->sum('box_num');
        dispatch(new GenerateBarcodeJob($this, $baseNum));
    }

    protected function pushImportTaskToQueue()
    {
        $file = storage_path('upload/' . $this->serial_number . '.txt');
        $count = 0;
        $fh = fopen($file, "r");
        while (!feof($fh)) {
            fgets($fh);
            $count++;
        }
        fclose($fh);
        $count = $count - 1;
        $unit = 10000;
        $step = $count % $unit == 0 ? ($count / $unit) + 1 : ceil($count / $unit);
        for ($i = 0; $i < $step; $i++) {
            $begin = $i * $unit;
            $end = ($i + 1) * $unit;
            $end = $end > $count ? $count : $end;
            dispatch(new ImportBarcodeJob($this, $begin, $end));
        }
    }

    public function exportTask()
    {
        return $this->hasMany('App\BarcodeExport');
    }

}

