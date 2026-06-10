<?php

namespace App\Jobs;

use App\Imports\ProjectsDynamicImport;
use App\Imports\ProjectsImport;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjectExcelFileJob implements ShouldQueue
{
    use Queueable;

    private string $path;

    private Task $task;

    /**
     * Create a new job instance.
     */
    public function __construct($path, Task $task)
    {
        //
        $this->path = $path;
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->task->update([
            'status' => Task::STATUS_SUCCESS,
        ]);

        $methodName = 'import'.$this->task->type;
        $this->$methodName();

    }

    private function import1()
    {dump('import1');
        // disk='public':'s3'
        Excel::import(new ProjectsImport($this->task), $this->path, 'public');
    }

    private function import2()
    {
        dump('import2');
        // disk='public':'s3'
        Excel::import(new ProjectsDynamicImport($this->task), $this->path, 'public');
    }
}
