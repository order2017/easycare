<?php

namespace App\Jobs;

use App\Barcode;
use App\GenerateBarcodeTask;
use Exception;
use File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;
use Throwable;

class GenerateBarcodeJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $task;
    protected $baseNum;

    /**
     * GenerateBarcodeJob constructor.
     * @param GenerateBarcodeTask $task
     * @param $baseNum
     */

    public function __construct(GenerateBarcodeTask $task, $baseNum)
    {
        $this->task = $task;
        $this->baseNum = $baseNum;
    }

    /**
     * Execute the job.
     *
     * @throws Exception
     * @throws Throwable
     */
    public function handle()
    {
        if ($this->task->is_running || $this->task->is_wait) {
            $this->task->running();
            $filePath = $this->task->serial_number . '.txt';
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            $inputSteam = '';
            $less = $this->task->box_num * $this->task->box_unit;
            for ($box = ($this->baseNum + 1); $box <= ($this->task->box_num + $this->baseNum); $box++) {
                for ($unit = 1; $unit <= $this->task->box_unit; $unit++) {
                    $serialNumber = $this->task->product_model . str_pad($box, 6, 0, STR_PAD_LEFT) . str_pad($unit, 3, 0, STR_PAD_LEFT);
                    $inputSteam .= $serialNumber . ',https://ec28.cn/'
                        . $serialNumber . '/c/' . $this->randStr(3)
                        . ',https://ec28.cn/' . $serialNumber . '/p/' . $this->randStr(3) . "\r\n";
                    if (count($inputSteam) == 10000) {
                        Storage::append($filePath, $inputSteam);
                        $this->task->finish(10000);
                        $inputSteam = '';
                        $less -= 10000;
                    }
                }
            }
            Storage::append($filePath, $inputSteam);
            $this->task->finish($less);
        }
    }

    public function randStr($num)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $chars_max_index = strlen($chars) - 1;
        $str = '';
        for ($i = 1; $i <= $num; $i++) {
            $str .= $chars[mt_rand(0, $chars_max_index)];
        }
        return $str;
    }

}
