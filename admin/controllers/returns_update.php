<?php
$id = $_POST['id'];

$stmt = $conn->prepare("SELECT * FROM returns WHERE id = ? LIMIT 1");
$stmt->execute(array($id));
$checkIfuser = $stmt->rowCount();
$data = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // Retrieve form values
    $serial_number = $_POST['serial_number'];
    $custody_number = $_POST['custody_number'];
    $device_location = $_POST['device_location'];
    $remarks = $_POST['remarks'];
    $storage_type = $_POST['storage_type'];
    $ram_type = $_POST['ram_type'];
    $device_name = $_POST['device_name'];
    $maintenance_count = $_POST['maintenance_count'];
    $maintenance_request_number = $_POST['maintenance_request_number'];
    $type = $_POST['type'];
    
    $formErrors = array();

    // Add validation if needed
    // Example validation:
    // if (empty($serial_number)) {
    //     $formErrors[] = "الرقم التسلسلي مطلوب";
    // }

    foreach ($formErrors as $error ) {
        ?>
        <div class="container">
            <?php
              echo '<div class="alert alert-danger" style="width: 50%;">' . $error . '</div>';
             ?>
        </div>
        <?php
        ?>
          <div class="container">
            <a href="returns.php?page=edit&id=<?php echo $id ?>">اضغط هنا للعودة الى اخر صفحة</a>
          </div>
        <?php
        // header('refresh:4;url=' . $_SERVER['HTTP_REFERER']);
    }

    if (empty($formErrors))
    {
        $stmt = $conn->prepare("
            UPDATE returns
            SET
                serial_number = ?,
                custody_number = ?,
                device_location = ?,
                remarks = ?,
                storage_type = ?,
                ram_type = ?,
                device_name = ?,
                maintenance_count = ?,
                maintenance_request_number = ?,
                type = ?
            WHERE id = ?
        ");

        // Execute the query with an array of values
        $stmt->execute(array(
            $serial_number,
            $custody_number,
            $device_location,
            $remarks,
            $storage_type,
            $ram_type,
            $device_name,
            $maintenance_count,
            $maintenance_request_number,
            $type,
            $id
        ));

        // Check if the record was updated successfully
        if ($stmt->rowCount() > 0) {
            echo "Record updated successfully.";
        } else {
            echo "No changes were made or an error occurred.";
        }
        
        header('location: returns.php?page=manage');
        exit;
    }
}
?>