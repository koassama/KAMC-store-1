<?php
$mysqli = new mysqli("localhost", "root", "", "stor");

$res = $mysqli->query("SELECT * FROM reports");
if(mysqli_num_rows($res)>0){
    echo '
    <table>
        <tr>
            <th scope="col">اسم الجهاز</th>
                              <th scope="col">مصدر الجهاز </th>
                              <th scope="col">نوع العقد  </th>

                              <th scope="col">serial number </th>
                              <th scope="col">رقم العهدة</th>

                              <th scope="col">الادارة</th>

                              <th scope="col">نوع التقرير </th>
        </tr>
    ';
    $num_row = 1;
    while($row = $res->fetch_assoc()){
        echo '
        <tr>
            <td>'.$num_row.'</td>
            <td>'.$row["Device_Type"].'</td>
            <td>'.$row["type_aa"].'</td>
            <td>'.$row["sr"].'</td>
            <td>'.$row["custody"].'</td>
            <td>'.$row["Installation_Department"].'</td>
            <td>'.$row["type"].'</td>
        </tr>
        ';
        $num_row++;
    }
    echo '</table>';
}

header('Content-Type: application/xls');
header('Content-Disposition:attachment; filename=report.xls');

    $mysqli -> close();
?>
