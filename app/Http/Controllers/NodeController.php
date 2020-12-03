<?php

namespace App\Http\Controllers;

use App\Models\Graph;
use App\Models\Node;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodes = Node::all();
        return $nodes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
        $node = new Node;    
        if($request->graph_id != null){

            if(! Graph::getIfExists($request->graph_id)){

                return $this->returnError('Graph id Not Found');

            }else{

                $node->graph_id = $request->graph_id;

            }    
        }

        $saved = $node->save();

        if($saved){
            return $this->returnData('Node', $node, 'Created Successful');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function show(Node $node)
    {
        // if we need to show the relations of this node 
        $node->relations();

        // return node
        return $node;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Node $node)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function destroy(Node $node)
    {
        $deleted = $node->delete();

        if($deleted){
            return $this->returnData('node_id', $node->id, 'Deleted Successful');
        }


    }
}
