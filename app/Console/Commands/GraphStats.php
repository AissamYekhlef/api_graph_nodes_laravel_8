<?php

namespace App\Console\Commands;

use App\Models\Graph;
use Illuminate\Console\Command;

class GraphStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = ' graph:stats {--graphId=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command display graphs stats (display the graph meta data, number of nodes, number of relations) by graph id.   ';

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
        $id = $this->option('graphId');

        $graph = Graph::find($id);
        if(!$graph){
            $this->error('The graphId must be exists');
            return 0;
        }

        foreach ($graph->nodes as $node) {
            $node->relations();
        }

        $this->info($graph);
    }
}
