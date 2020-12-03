<?php

namespace App\Console\Commands;

use App\Models\Graph;
use App\Models\Node;
use Faker\Factory;
use Illuminate\Console\Command;

class GenerateRandomGraph extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graph:gen {--nbNodes=10}';

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
        // $graph = new Graph();

        $graph = Graph::factory()->create();
        $nodes = Node::factory()->count($nbNodes)->create(['graph_id' => $graph->id]);



        $this->info($nodes->count());
    }
}
