<?php 


function connect_to_database() {
    return mysqli_connect(
    "localhost",
    "dvirgiliochavero_dessert_hunter",
    "DessertHunters",
    "dvirgiliochavero_dessert_hunters"
    );
}

function send_query($var){
    $connection = connect_to_database();
    return mysqli_query($connection,$var);
}

function get_info($result,$multiple=""){
    if(!$multiple=='multiple'){
        return mysqli_fetch_assoc($result);
    }
    $info = [];
   while($array=mysqli_fetch_assoc($result)){
    $info[]=$array;
   }
    return $info;
}

function get_assoc_array_where($table,$column,$value){
    $connection = connect_to_database();
    $validColumn = mysqli_real_escape_string($connection,$column);
    $validValue = mysqli_real_escape_string($connection,$value);
    $query="SELECT * FROM `$table` WHERE `$validColumn`='$validValue';";
    $result= mysqli_query($connection,$query);
    $array = get_info($result,'multiple');
    return $array;
}
function get_array_where($table,$column,$value){
    $connection = connect_to_database();
    $validColumn = mysqli_real_escape_string($connection,$column);
    $validValue = mysqli_real_escape_string($connection,$value);
    $query="SELECT * FROM `$table` WHERE `$validColumn`='$validValue';";
    $result= mysqli_query($connection,$query);
    return mysqli_fetch_assoc($result);
}


// Having given username and password, it returns an array with the hashed password from the database and a verification variable. 
function verify_password($username,$password){
    $array = get_array_where("users","username",$username);
    if(!$array){
        return null;
    }
    $passwordFromDB = $array["password"];
    $verification = password_verify($password,$passwordFromDB);
    return [
        'password'=>$passwordFromDB,        //string
        'verification' => $verification      // Boolean | Null
    ];
}

function get_user($password){
    $array = get_array_where("users","password",$password);
    if($array){
        $name = $array["username"];
        return $name;
    }else{
        return FALSE;
    }
}


function create_new_user($username,$password){
    $connection= connect_to_database();
    $validUsername = mysqli_real_escape_string($connection,$username);
    $options = ['cost'=>12];
    $hashedPassword = password_hash($password,PASSWORD_BCRYPT,$options);
    $query = "INSERT INTO `users` (`username`, `password`) VALUES ('$validUsername', '$hashedPassword');";
    $send = mysqli_query($connection,$query);
    return $hashedPassword;
}



?>