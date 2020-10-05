<?php
$error = false;

$headers = apache_request_headers();

if (isset($headers['Authorization'])) {

    require_once("utils/token.php");

    $token = $headers['Authorization'];

    if (validate_token($token)) {

        if (isset($_POST['name']) && $_POST['name'] <> '' && isset($_POST['username']) && $_POST['username'] <> '' && isset($_POST['password']) && $_POST['password'] <> '') {
            require_once("database/db.php");

            $name = $_POST['name'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                $query = "SELECT id FROM users WHERE username = :username";
                $stmt = $con->prepare($query);
                $stmt->bindValue(':username', $username);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                $error = true;
                $message =  $exception->getMessage();
            }

            if ($row) {
                $error = true;
                $message = "Username already exist";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                try {

                    $query = "INSERT INTO users (name,username,password) VALUES (:name,:username,:password)";
                    $stmt = $con->prepare($query);

                    $stmt->bindValue(':name', $name);
                    $stmt->bindValue(':username', $username);
                    $stmt->bindValue(':password', $hashed_password);


                    if ($stmt->execute()) {

                        $user['id']   = $con->lastInsertId();
                        $user['name']   = $name;
                        $user['username']   = $username;

                        $data = $user;
                    } else {
                        $error = true;
                        $message = "Nothing inserted!";
                    }
                } catch (PDOException $exception) {
                    $error = true;
                    $message =  $exception->getMessage();
                }
            }
        } else {
            $error = true;
            $message = "Missing data";
        }
    } else {
        $error = true;
        $message = "Access Token is not valid or has expired";
    }
} else {
    $error = true;
    $message = "Authorization required!";
}
/* -------------------------------------------------------------------------- */
/*                                  Response                                  */
/* -------------------------------------------------------------------------- */
if ($error) {
    $out = json_encode(array(
        "status"   => "error",
        "message"   => $message
    ));
} else {
    $out = json_encode(array(
        "status"   => "success",
        "data"   => $data
    ));
}
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo $out;
