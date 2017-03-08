<?php

namespace App\Jobs;

use App\Barcode;
use App\BarcodeExport;
use App\GenerateBarcodeTask;
use Exception;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SplFileObject;
use Throwable;

class ImportBarcodeJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $task;
    protected $beginLine;
    protected $endLine;

    /**
     * GenerateBarcodeJob constructor.
     * @param GenerateBarcodeTask $task
     * @param $beginLine
     * @param $endLine
     */

    public function __construct(GenerateBarcodeTask $task, $beginLine, $endLine)
    {
        $this->task = $task;
        $this->beginLine = $beginLine;
        $this->endLine = $endLine;
    }

    /**
     * Execute the job.
     *
     * @throws \Exception
     */
    public function handle()
    {
        if ($this->task->is_import_ing || $this->task->is_import_wait) {
            $this->task->runImport();
            \DB::beginTransaction();
            try {
                foreach ($this->getList() as $line) {
                    $info = explode(",", $line);
                    Barcode::create([
                        'generate_barcode_task_id' => $this->task->id,
                        'product_id' => $this->task->product_id,
                        'serial_number' => $info[0],
                        'commission_password' => md5(substr(str_replace("\r\n", "", $info[1]), -3)),
                        'integral_password' => md5(substr(str_replace("\r\n", "", $info[2]), -3)),
                    ]);
                }
                \DB::commit();
                $this->task->finishImport($this->endLine - $this->beginLine);
            } catch (Exception $e) {
                \DB::rollBack();
                $this->task->failImport();
                throw $e;
            } catch (Throwable $e) {
                \DB::rollBack();
                $this->task->failImport();
                throw $e;
            }
        }
    }

    protected function getList()
    {
        $fp = new SplFileObject(storage_path('upload/' . $this->task->serial_number . '.txt'), 'r');
        $fp->seek($this->beginLine);
        $content = [];
        for ($i = 0; $i < $this->endLine - $this->beginLine; ++$i) {
            $content[] = $fp->current();// current()获取当前行内容
            $fp->next();// 下一行
        }
        $fp = null;
        return $content;
    }
}
