<?php

namespace App\Http\Controllers;

use App\Models\Graph;
use App\Models\Node;
use App\Models\Relation;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GraphController extends Controller
{

    /**
     * GeneralTrait for use the same output JSON format for all methods
     */
    use GeneralTrait;

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $graphs = Graph::all();
        return $graphs;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:graphs',
            'description' => 'required|min:10',
        ]);

        if($validator->fails()){
            // return response()->json($validator->errors(), 400);
            return $this->returnError(
                $validator->errors()
            );
        }

        $new_graph = new Graph();
        $new_graph->name = $request->name;
        $new_graph->description = $request->description;

        $new_graph->save();

        return $this->returnData('new graph',$new_graph, 'Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Graph  $graph
     * @return \Illuminate\Http\Response
     */
    public function show(Graph $graph)
    {

        foreach ($graph->nodes as $node ) {
            // to show the relation of each node
            $node->relations(); 
        }

        return response()->json([
            'graph' => $graph
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Graph  $graph
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Graph $graph)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:graphs',
            'description' => 'required|min:10',
        ]);

        if($validator->fails()){
            // return response()->json($validator->errors(), 400);

            // or use the returnError GeneralTrait method
            return $this->returnError(
                $validator->errors()
            );
        }


        $graph->name = $request->name;
        $graph->description = $request->description;
        $graph->updated_at = now();

        $updated = $graph->save();

        if($updated){
            return $this->returnData(
                'updated', $graph, 
                'Updated Successfuly'
            ); 
        }else{
            return $this->returnError('Updating Unsuccessfuly');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Graph  $graph
     * @return \Illuminate\Http\Response
     */
    public function destroy($graph)
    {
        $graph = Graph::getIfExists($graph);
        if(! $graph){
            return $this->returnError('Graph id Not Found');
        }
        
        $deleted = $graph->delete();
        if($deleted){
            return $this->returnData(
                'item', $graph, 
                'Deleted Successful'
            );
        }else{
            return $this->returnError('Deleting Unsuccessful');
        }
    }

    public function addNode($graph, $node)
    {
        if(! Graph::getIfExists($graph)){
            return $this->returnError('Graph id Not Found');
        }
        $node = Node::find($node);
        $node->graph_id = $graph;

        $saved = $node->save();

        if($saved){
            return $this->returnData(
                'item', $node, 
                'Added Successful'
            );
        }
    }
    public function addRelation(Request $request, $graph)
    {
        $node_p = Node::find($request->parent_id)->graph_id;
        $node_c = Node::find($request->child_id)->graph_id;
        if($node_p != $node_c){
            return $this->returnError('the parent node and chlid node must be at the same graph!');
        }

        // check if the relation is already exists in the relations table.
        $r = Relation::where([
                            ['node_parent_id', '=' , $request->parent_id],
                            ['node_child_id', '=' , $request->child_id]
                            ])
                        ->get();

        if($r->count() > 0){
            return $this->returnError('This relation is Already Exists.');
        }

        // if there is no error, so create a relation between the parent and the child .
        $relation = new Relation();
        $relation->node_parent_id = $request->parent_id;
        $relation->node_child_id = $request->child_id;
        $relation->save();

        return $this->returnData('Relation', $relation, 'Added Successful');

    }
}
