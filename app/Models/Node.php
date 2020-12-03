<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory;
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the graph that owns the node.
     */
    public function graph()
    {
        return $this->belongsTo(Graph::class);
    }

    public function parents()
    {
        return $this->hasMany(Relation::class, 'node_child_id', 'id');
    }

    public function childs()
    {
        return $this->hasMany(Relation::class, 'node_parent_id', 'id');
    }

    public function relations()
    {
        return [
            'parents' => $this->parents, 
            'childs' => $this->childs
        ];
    }

}
