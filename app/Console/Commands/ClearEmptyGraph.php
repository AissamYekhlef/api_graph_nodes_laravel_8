<?php

namespace App\Console\Commands;

use App\Models\Graph;
use Illuminate\Console\Command;

class ClearEmptyGraph extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graph:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command delete all empty graphs.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $graphs = Graph::all();
        $nbrDeleted = 0;
        foreach ($graphs as $graph) {
            if($graph->nodes->count() == 0){
                $nbrDeleted ++;
            }
        }

        $this->info('Delete ' . $nbrDeleted . ' Graphs');
    }
}
