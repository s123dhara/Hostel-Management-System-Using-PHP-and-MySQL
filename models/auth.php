<?php 

function login($conn, $params) {

    extract($params);
    $sql = "select * from users where email = '$email'";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        $user = mysqli_fetch_assoc($res);
        $hash = $user['password'];

        if (password_verify($password, $hash)) {
            $result = array('status' => true, 'user' => $user);
        } else {
            $result = array('status' => false);
        }

    } else {
        $result = array('status' => false);
    }
    return $result;

}

?>