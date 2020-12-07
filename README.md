# Cofing Challeng api laravel  

It's an Laravel API for generate a graph and the nodes and the relation between the nodes.   

### Models

- Graphs with attributes id, name, description, created_at and updated_at
- Nodes with attributes id, graph_id
- Relations with attributes node_parent_id, node_child_id
  
### Endpoints

- GET /graphs and /nodes
- DELETE /graphs/ and /nodes/
- POST /graphs and /nodes
- PATCH /graphs/ and /nodes/

### Tests

- One test for success behavior of each endpoint
- One test for error behavior of each endpoint
- At least two tests of admin access

## Getting Started

### How to use
- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- npm __install__
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan jwt:secret__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- Run the Application __php artisan serve__

## Testing
To run the tests, run
```
php artisan test
```

# API Reference 

## Getting Started 

- **Base URL**: Base URL: Actually, this app can be run locally . The backend app is hosted at the default, `http://127.0.0.1:8000/`, which is set as a proxy in the frontend configuration.
- you can change the default port by __php artisan serve --port=8888__
- **Authentication**: This version of the application require authentication or API keys using Auth0 (Ps: The setup is givin in setup Auth0 section)

## Artisan commands: Created

### 1. Generate a random graph
__php artisan graph:gen --nbNodes={$nbNodes}__

This command create a random graph with $nbNodes nodes and random relations.

### 2. Clear empty graphs
__php artisan graph:clear__
This command delete all empty graphs.

### 3. Graph stats
__php artisan graph:stats --gid={$graphId}__

This command display graphs stats (display the graph meta data, number of nodes, number of relations) by graph id.

## Error Handling

Errors are returned as JSON object in the following format:

```json
{
    "success": False,
    "error": 400,
    "message": "bad request"
}
```
The API will return four(04) error types when requests fail:

- 400: Bad Request
- 404: Resource Not Found
- 405: Method Not allowed
- 422: Not Processable
- 401: AuthError Unauthorized error
- 403: AuthError Permission not found

## Endpoints

- GET '/graphs'
- GET '/nodes'
- GET '/graphs/{graph}'
- GET '/nodes/{node}'
- POST '/graphs/create'
- POST '/nodes/create'
- PATCH '/graphs/{graph}/update'
- PATCH '/nodes/{node}/update'
- DELETE '/graphs/{graph}'
- DELETE '/nodes/{node}'

### GET /graphs

- Returns a list of actors

```php
return response()->json({
        'success': True,
        'graphs': $graphs
    })
```

Here is a returned sample fromat meta data (name, description)

```json
[
    {
        "id": 1,
        "name": "first graph",
        "description": "description content"
    },
    {
        "id": 2,
        "name": "second graph",
        "description": "second description"
    },
    {
        "id": 4,
        "name": "third graph",
        "description": "third description"
    }
]
```

### GET /graphs/{graph}

- Returns a specific graph and it's proprities

```php
 return response()->json([
            'graph' => $graph
        ]);
```

Here is a returned sample fromat to a specific graph
```json
{
    "graph": {
        "id": 2,
        "name": "second graph",
        "description": "second description",
        "nodes": [
            {
                "id": 4,
                "graph_id": 2,
                "parents": [
                    {
                        "id": 5,
                        "node_parent_id": 3,
                        "node_child_id": 4
                    }
                ],
                "childs": [
                    {
                        "id": 6,
                        "node_parent_id": 4,
                        "node_child_id": 3
                    }
                ]
            }
        ]
    }
}
```

### POST /graphs

- Create a new row in the graphs table
returns status code 200 and json `{"success": True, "graphs": graph}` where graph an array containing only the newly created graph or appropriate status code indicating reason for failure.

Here is a result sample format:

```json
{
    "status": true,
    "message": "Updated Successfuly",
    "options": [],
    "updated": {
        "id": 2,
        "name": "updated_name",
        "description": "updated_description"
    }
}
```
if the name is Alreaty taken return 400 error , like This exaample

```json
{
    "status": false,
    "errNum": "Error",
    "message": {
        "name": [
            "The name has already been taken."
        ]
    }
}
```


### PATCH /actors/<actor_id>

- Require the 'patch:actors' permission
- Update an existing row in the actors table
- Contain the actor.get_actor data representation
returns status code 200 and json `{"success": True, "actors": actor}` where actor an array containing only the updated actor
or appropriate status code indicating reason for failure

He is a sample for a  modified actor in a format:

```json
{
  "actors": [
    {
      "age": 25,
      "gender": "female",
      "id": 1,
      "name": "Updated Actor 1"
    }
  ],
  "success": true
}
```

### DELETE /graphs/<graph_id>

- Delete the corresponding row for `<graph_id>` where `<graph_id>` is the existing model id
- Respond with a 404 error if `<graph_id>` is not found
- Returns status code 200 and json `{"success": True, "deleted": graph_id}` where id is the id of the deleted record
or appropriate status code indicating reason for failure

```json
return $this->returnData(
                'item', $graph, 
                'Deleted Successful'
            );
```
the result return

```json
{
    "status": true,
    "message": "Deleted Successful",
    "options": [],
    "item": {
        "id": 20,
        "name": "Torey Christiansen",
        "description": "Quos ut et."
    }
}
```

### POST graphs/{graph}/add/nodes/{node} 

```json
return $this->returnData(
                'item', $node, 
                'Added Successful'
            );
```
### POST graphs/{graph}/add/relation

body must has two value parent_id, child_id

```json
return $this->returnData(
        'Relation', $relation, 
        'Added Successful'
        );
```
## from Mobidal-projects

