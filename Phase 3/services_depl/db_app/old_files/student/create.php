<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/students.php';
 
$database = new Database();
$db = $database->getConnection();
 
$student = new Student($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->id) &&
    !empty($data->name) &&
    !empty($data->surname) &&
    !empty($data->fathername) &&
    !empty($data->grade) &&
    !empty($data->mobilenumber) &&
    !empty($data->birthday)
){
 
    // set product property values
    $student->id = $data->id;
    $student->name = $data->name;
    $student->surname = $data->surname;
    $student->fathername = $data->fathername;
    $student->grade = $data->grade;
    $student->mobilenumber = $data->mobilenumber;
    $student->birthday = $data->birthday;
 
    // create the product
    if($student->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Student was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create student."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create student. Data is incomplete."));
}
?>