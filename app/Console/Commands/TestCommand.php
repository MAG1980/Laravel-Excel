<?php

namespace App\Console\Commands;

use App\Imports\ProjectsDynamicImport;
use App\Models\Task;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Command\Command as CommandAlias;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // Название команды для вызова из консоли.
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $task = Task::create([
            'user_id' => 1,
            'file_id' => 1,
            'status' => Task::STATUS_IN_PROGRESS,
            'type' => 2,
        ]);
        Excel::import(new ProjectsDynamicImport($task), 'files/projects2.xlsx', 'public');
        dump('Test Command Success');
        return CommandAlias::SUCCESS;
    }
}
