<?php
if ($_SESSION['type'] == 2)
{
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: returns.php');
    $stmt = $conn->prepare("SELECT * FROM returns WHERE id = ? LIMIT 1");
    $stmt->execute(array($id));
    $check = $stmt->rowCount();

    if ($check > 0 )
    {
        $stmt = $conn->prepare("DELETE FROM returns WHERE id = :zid");
        $stmt->bindParam(":zid", $id);
        $stmt->execute();
        header('location: returns.php');
        exit;
    }
    else {
        header('location: returns.php');
        exit;
    }
}
else {
    header('location: returns.php');
    exit;
}
?>