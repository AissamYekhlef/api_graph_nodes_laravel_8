<?php

namespace App\Console\Commands;

use App\Models\Graph;
use App\Models\Node;
use App\Models\Relation;
use Faker\Factory;
use Faker\Provider\Base;
use Illuminate\Console\Command;

class GenerateRandomGraph extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graph:gen {--nbNodes=6}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create a random graph with $nbNodes nodes and random relations.';

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
        $nbNodes = $this->option('nbNodes');
        // create the graph with fake data

        $graph = Graph::factory()->create();

        $nodes = Node::factory()->count($nbNodes)->create(['graph_id' => $graph->id]);

        $array_id = Node::where('graph_id', '=', $graph->id)->get('id');

        for ($i=0; $i < $nbNodes; $i++) { 
            Relation::factory()
                        ->create([
                        'node_parent_id' => Base::randomElement($array_id),
                        'node_child_id' => Base::randomElement($array_id)
                        ]);
        }
        if ($nodes->count() == $nbNodes) {
            $this->info('Create new graph with id = ' . $graph->id . ', and '.$nodes->count(). ' Nodes Successful');
        }else {
            $this->error('There is an error');
        }
        
    }
}
