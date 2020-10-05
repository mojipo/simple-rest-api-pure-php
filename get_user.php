<?php
$error = false;

if (isset($_GET['id'])) {
    require_once("database/db.php");

    $id = $_GET['id'];

    try {
        $query = "SELECT name, username FROM users WHERE id = :id";
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($row) {
            $data = $row;
        } else {
            $error = true;
            $message = "User doesn't exist";
        }
    } catch (PDOException $exception) {
        $error = true;
        $message =  $exception->getMessage();
    }
} else {
    $error = true;
    $message = "Missing user ID";
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
