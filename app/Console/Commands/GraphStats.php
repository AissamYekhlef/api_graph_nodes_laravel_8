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
    protected $signature = 'graph:stats {--graphId=1}';

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

        $graph = Graph::where('id', '=', $id)->first();
        
        if(!$graph){
            $this->error('The graphId must be exists');
            return 0;
        }

        $rows = [];
        $row[0] = $graph->id;
        $row[1] = $graph->name; 
        $row[2] = $graph->description; 
        $row[3] = $graph->nodes->count(); 
        $row[4] = $graph->nodes->count() * 2;  // need to confirm    
        $rows[] = $row;

        $headers = ['Id', 'Name', 'Description', 'Nodes Number', 'Relation Number'];
        $this->table($headers, $rows);   

    }
}
