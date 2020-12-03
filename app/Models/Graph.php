<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    use HasFactory;


    protected $casts = [
        // 'key' => 'array',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    /**
     * The nodes that belong to the graph.
     */
    public function nodes(){
        return $this->hasMany(Node::class);
    }

    public static function getIfExists($id){
        $graph = Graph::find($id);
        if($graph == null){
            return false;
        }else{
            return $graph;
        }
    }
}
