<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
//end



// Routes

$app->get('/allbuy', function ($request, $response, $args) {
    $sql = $this->db->prepare("SELECT * FROM buy"); 
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_ASSOC); // Fetch data as associative array
    return $response->withJson($data, 200); // Return data directly
});


        $app->get('/buy/{id}', function ($request, $response, $args) {
            $buyId = $args['id'];
            // Prepare SQL query with a parameter for the homestay ID
            $sql = $this->db->prepare("SELECT * FROM buy WHERE id = :id");
            // Bind the homestay ID parameter
            $sql->bindParam(':id', $buyId);
            // Execute the query
            $sql->execute();
            // Fetch the homestay data
            $buy = $sql->fetch();
            // Check if homestay exists
            if (!$buy) {
                // Return a 404 Not Found response if homestay does not exist
                return $response->withStatus(404)->withJson(['error' => 'buy not found']);
            }        
            // Return the homestay data as JSON
            return $response->withHeader('Content-Type', 'application/json')
                            ->withHeader('Access-Control-Allow-Origin', '*')
                            ->withJson($buy);
        });


        $app->post('/buy/add', function (Request $request, Response $response, array $args) {
            $input = $request->getParsedBody();
        
            // Validate that the 'car_buy' field is present and not empty
            if (!isset($input['car_buy']) || empty($input['car_buy'])) {
                return $response->withJson(['error' => 'The car_buy field is required'], 400);
            }
        
            $db = $this->get('db'); // Retrieve the database connection from the container
            
            // Prepare the SQL query
            $sql = 'INSERT INTO buy (name, email, phone_num, car_buy, payment) VALUES (:name, :email, :phone_num, :car_buy, :payment)';
            $stmt = $db->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':name', $input['name']); 
            $stmt->bindParam(':email', $input['email']); 
            $stmt->bindParam(':phone_num', $input['phone_num']); 
            $stmt->bindParam(':car_buy', $input['car_buy']); 
            $stmt->bindParam(':payment', $input['payment']); 
            
            // Execute the query
            $stmt->execute();
            
            // Return success response
            return $response->withJson(['message' => 'buy added successfully'], 200);
        });

        $app->put('/buy/update/{id}', function (Request $request, Response $response, array $args) {
            $input = $request->getParsedBody();
            $db = $this->get('db'); // Retrieve the database connection from the container
            
            
            // Prepare the SQL query
            $sql = 'UPDATE buy SET name = :name, email = :email, phone_num = :phone_num, car_buy = :car_buy, payment = :payment WHERE id = :id';
            $stmt = $db->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':name', $input['name']);
            $stmt->bindParam(':email', $input['email']);
            $stmt->bindParam(':phone_num', $input['phone_num']);
            $stmt->bindParam(':car_buy', $input['car_buy']);
            $stmt->bindParam(':payment', $input['payment']);
            $stmt->bindParam(':id', $args['id']);
            
            // Execute the query
            $stmt->execute();
            
            // Return success message
            return $response->withJson(['message' => 'buy updated successfully']);
        });


        $app->delete('/buy/del/{id}', function (Request $request, Response $response, array $args) {
            $db = $this->get('db'); // Retrieve the database connection from the container
            
            // Prepare the SQL query
            $sql = 'DELETE FROM buy WHERE id = :id';
            $stmt = $db->prepare($sql);
            
            // Bind parameter
            $stmt->bindParam(':id', $args['id']);
            
            // Execute the query
            $stmt->execute();
            
            // Return success message
            return $response->withJson(['message' => 'buy deleted successfully']);
        });

        

        $app->get('/rent', function ($request, $response, $args) {
            $sql = $this->db->prepare("SELECT * FROM rental"); 
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC); // Fetch data as associative array
            return $response->withJson($data, 200); // Return data directly
        });


                $app->get('/rent/{id}', function ($request, $response, $args) {
                    $rentId = $args['id'];
                    // Prepare SQL query with a parameter for the homestay ID
                    $sql = $this->db->prepare("SELECT * FROM rental WHERE id = :id");
                    // Bind the homestay ID parameter
                    $sql->bindParam(':id', $rentId);
                    // Execute the query
                    $sql->execute();
                    // Fetch the homestay data
                    $rent = $sql->fetch();
                    // Check if homestay exists
                    if (!$rent) {
                        // Return a 404 Not Found response if homestay does not exist
                        return $response->withStatus(404)->withJson(['error' => 'Homestay not found']);
                    }        
                    // Return the homestay data as JSON
                    return $response->withHeader('Content-Type', 'application/json')
                                    ->withHeader('Access-Control-Allow-Origin', '*')
                                    ->withJson($rent);
                });


                $app->post('/rent/add', function (Request $request, Response $response, array $args) {
                    $input = $request->getParsedBody();
                
                    $db = $this->get('db'); // Retrieve the database connection from the container
                    
                    // Prepare the SQL query
                    $sql = 'INSERT INTO rental (name, email, phone_num, car_rent, days) VALUES (:name, :email, :phone_num, :car_rent, :days)';
                    $stmt = $db->prepare($sql);
                    
                    // Bind parameters
                    $stmt->bindParam(':name', $input['name']); 
                    $stmt->bindParam(':email', $input['email']); 
                    $stmt->bindParam(':phone_num', $input['phone_num']); 
                    $stmt->bindParam(':car_rent', $input['car_rent']); 
                    $stmt->bindParam(':days', $input['days']); 
                    
                    // Execute the query
                    $stmt->execute();
                    
                    // Return success response
                    return $response->withJson(['message' => 'rent added successfully'], 200);
                });
                    


                $app->put('/rent/update/{id}', function (Request $request, Response $response, array $args) {
                    $input = $request->getParsedBody();
                    $db = $this->get('db'); // Retrieve the database connection from the container
                    
                    
                    // Prepare the SQL query
                    $sql = 'UPDATE rental SET name = :name, email = :email, phone_num = :phone_num, car_rent = :car_rent, days = :days WHERE id = :id';
                    $stmt = $db->prepare($sql);
                    
                    // Bind parameters
                    $stmt->bindParam(':name', $input['name']);
                    $stmt->bindParam(':email', $input['email']);
                    $stmt->bindParam(':phone_num', $input['phone_num']);
                    $stmt->bindParam(':car_rent', $input['car_rent']);
                    $stmt->bindParam(':days', $input['days']);
                    $stmt->bindParam(':id', $args['id']);
                    
                    // Execute the query
                    $stmt->execute();
                    
                    // Return success message
                    return $response->withJson(['message' => 'rental updated successfully']);
                });


                $app->delete('/rent/del/{id}', function (Request $request, Response $response, array $args) {
                    $db = $this->get('db'); // Retrieve the database connection from the container
                    
                    // Prepare the SQL query
                    $sql = 'DELETE FROM rental WHERE id = :id';
                    $stmt = $db->prepare($sql);
                    
                    // Bind parameter
                    $stmt->bindParam(':id', $args['id']);
                    
                    // Execute the query
                    $stmt->execute();
                    
                    // Return success message
                    return $response->withJson(['message' => 'rental deleted successfully']);
                });







