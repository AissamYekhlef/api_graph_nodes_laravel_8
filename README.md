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





## from Mobidal-projects

