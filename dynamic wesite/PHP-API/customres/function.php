 
<?php

require '../inc/dbcon.php';

function error422($message){

    $data =[
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}
function storeCustomer($cutomerInput){
    global $conn;

    $name = mysqli_real_escape_string($conn,$cutomerInput['name']);
   // $email = mysqli_real_escape_string($conn,$cutomerInput['email']);
    $phone = mysqli_real_escape_string($conn,$cutomerInput['phone']);
    $address = mysqli_real_escape_string($conn,$cutomerInput['address']);
    $amount = mysqli_real_escape_string($conn,$cutomerInput['amount']);
    $status = mysqli_real_escape_string($conn,$cutomerInput['status']);
    $fundnumber = mysqli_real_escape_string($conn,$cutomerInput['fundnumber']);

    if(empty(trim($name))){
        return error422('Enter your name');
    }
    // elseif(empty(trim($email))){

    //     return error422('Enter your phone');
    // }
    elseif(empty(trim($phone))){

        return error422('Enter your phone');
    }
    elseif(empty(trim($address))){

        return error422('Enter your address ');

    }elseif(empty(trim($amount))){

        return error422('Enter your amount');

    }elseif(empty(trim($status))){

        return error422('Enter your status');

    }elseif(empty(trim($fundnumber))){

        return error422('Enter your fundnumber');

    }
    else {
        $query="INSERT INTO customer1 (name,phone,address,amount,status,fundnumber) VALUES ('$name','$phone','$address','$amount','$status','$fundnumber')";
       //$query="INSERT INTO customer (name,email,phone) VALUES ('$name','$email','$phone');
        $result = mysqli_query($conn,$query);

        if($result){
            $data=[
                'status' =>201,
                'message' =>'Customer Created Successfully',
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);

        }else{
            $data=[
                'status' =>500,
                'message' =>'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
function getCustomerList(){
    global $conn;

    $query="SELECT * FROM customer1";
    $query_run = mysqli_query($conn,$query);

    if($query_run){

        if(mysqli_num_rows($query_run)>0){

            $res =mysqli_fetch_all($query_run,MYSQLI_ASSOC);

            $data=[
                'status' =>200,
                'message' =>'Customer List Fetched Successfully',
                'data' => $res 
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
            

        }else{
            $data=[
                'status' =>404,
                'message' =>'No Customer Found',
            ];
            header("HTTP/1.0 405 No Customer Found");
            return json_encode($data);
        }

    }else{
        $data=[
            'status' =>500,
            'message' =>'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}


function getCustomer($customerParams){ 
    global $conn;

    if($customerParams['id'] == null){
        return error422('Enter your customer id');
    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $query ="SELECT * FROM customer1 WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn,$query);

    if($result){

        if(mysqli_num_rows($result) == 1){
            $res = mysqli_fetch_assoc($result);

            $data=[
                'status' =>200,
                'message' =>'Customer Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 ok");
            return json_encode($data);

        }else{
            $data=[
                'status' =>404,
                'message' =>'NO Customer Found',
            ];
            header("HTTP/1.0 500 Not Found");
            return json_encode($data);

        }

    }else{
        $data=[
            'status' =>500,
            'message' =>'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
function updateCustomer($customerInput,$customerParams){
    global $conn;

    if(!isset($customerParams['id'])){
        return error422('customer id not found in url');
    }elseif($customerParams['id'] == null){
        return error422('Enter your customer id');

    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $name = mysqli_real_escape_string($conn,$customerInput['name']);
    $phone = mysqli_real_escape_string($conn,$customerInput['phone']);
    $address = mysqli_real_escape_string($conn,$customerInput['address']);
    $amount = mysqli_real_escape_string($conn,$customerInput['amount']);
    $status = mysqli_real_escape_string($conn,$customerInput['status']);
    $fundnumber = mysqli_real_escape_string($conn,$customerInput['fundnumber']);

    if(empty(trim($name))){
        return error422('Enter your name');
    }elseif(empty(trim($phone))){

        return error422('Enter your phone');
    }elseif(empty(trim($address))){

        return error422('Enter your address');

    }elseif(empty(trim($amount))){

        return error422('Enter your amount');

    }elseif(empty(trim($status))){

        return error422('Enter your status');

    }elseif(empty(trim($fundnumber))){

        return error422('Enter your fundnumber');

    }
    else{
        $query="UPDATE customer1 SET name='$name',phone='$phone',address='$address',amount='$amount',status='$status',fundnumber='$fundnumber' WHERE id='$customerId' LIMIT 1 ";
        $result = mysqli_query($conn,$query);

        if($result){
            $data=[
                'status' =>200,
                'message' =>'Customer Updated Successfully',
            ];
            header("HTTP/1.0 201 Success");
            return json_encode($data);

        }else{
            $data=[
                'status' =>500,
                'message' =>'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

function deleteCustomer($customerParams){
    global $conn;

    if(!isset($customerParams['id'])){
        return error422('customer id not found in url');
    }elseif($customerParams['id'] == null){
        return error422('Enter your customer id');

    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $query ="DELETE FROM customer1 WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data=[
            'status' =>200,
            'message' =>'customer Deleted Successfully',
        ];
        header("HTTP/1.0 200 Ok");
        return json_encode($data);

    }else{
        $data=[
            'status' =>404,
            'message' =>'customer not found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);

    }


}

?>