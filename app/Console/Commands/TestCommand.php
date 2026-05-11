<?php

namespace App\Console\Commands;

use App\Imports\ProjectImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

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
        Excel::import(new ProjectImport(), 'files/projects.xlsx', 'public');
        dd('Test Command Success');
    }
}
