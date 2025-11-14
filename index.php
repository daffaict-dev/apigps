<?php

require __DIR__ . "/config/Database.php";
require __DIR__ . "/core/Response.php";
require __DIR__ . "/core/Router.php";
require __DIR__ . "/models/SensorModel.php";
require __DIR__ . "/controllers/SensorController.php";


// Connect DB
$db = new Database();
$conn = $db->connect();
$model = new SensorModel($conn);

// Init Router
$router = new Router();

// =======================
// ROUTES
// =======================

// INSERT / STORE
$router->post("/sensor/store", function() use ($model) {
    SensorController::store($model);
});

// GET ALL DATA
$router->get("/sensor", function() use ($model) {
    SensorController::index($model);
});

// GET DETAIL BY ID
$router->get("/sensor/{id}", function($id) use ($model) {
    SensorController::show($model, $id);
});

// DELETE BY ID
$router->delete("/sensor/{id}", function($id) use ($model) {
    SensorController::destroy($model, $id);
});
$router->get("/", function() {
    Response::json(["status" => "success", "message" => "API GPS Active"]);
});


// RUN
$router->run();
