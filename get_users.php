<?php
$error = false;

require_once("database/db.php");

try {
    $query = "SELECT id, name, username FROM users";
    $stmt = $con->prepare($query);
    $stmt->execute();

    $data = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user['id']   = $row['id'];
        $user['name']   = $row['name'];
        $user['username']   = $row['username'];
        $data[] = $user;
    }
} catch (PDOException $exception) {
    $error = true;
    $message =  $exception->getMessage();
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
