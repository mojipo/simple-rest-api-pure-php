<?php
$error = false;

if (isset($_POST['username']) && $_POST['username'] <> '' && isset($_POST['password']) && $_POST['password'] <> '') {

    require_once("database/db.php");
    require_once("utils/token.php");

    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $query = "SELECT id,password FROM users WHERE username = :username";
        $stmt = $con->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        $error = true;
        $message =  $exception->getMessage();
    }

    if ($row) {

        if (password_verify($password, $row['password'])) {
            $data = ['token' => generate_token($row['id'])];
        } else {
            $error = true;
            $message = "Wrong password!";
        }
    } else {
        $error = true;
        $message = "User doesn't exist";
    }
} else {
    $error = true;
    $message = "Missing data";
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
