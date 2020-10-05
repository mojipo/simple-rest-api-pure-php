<?php
$error = false;

$headers = apache_request_headers();

if (isset($headers['Authorization'])) {

    require_once("utils/token.php");

    $token = $headers['Authorization'];

    if (validate_token($token)) {

        if (isset($_GET['id'])) {
            require_once("database/db.php");

            $id = $_GET['id'];

            try {
                $query = "DELETE FROM users WHERE id = :id";
                $stmt = $con->prepare($query);
                $stmt->bindValue(':id', $id);

                if ($stmt->execute() &&  $stmt->rowCount()) {
                    $data =  $stmt->rowCount() . " row(s) deleted";
                } else {
                    $error = true;
                    $message = "Nothing deleted!";
                }
            } catch (PDOException $exception) {
                $error = true;
                $message =  $exception->getMessage();
            }
        } else {
            $error = true;
            $message = "Missing user ID";
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
