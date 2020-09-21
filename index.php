<?php
include "connect.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title> Exam Sort table </title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/javascript.js"></script>
</head>
<body>
    <table>
        <caption> Groups </caption>
        <?php
            $sql = "SELECT * FROM callgroups";
            $result = $conn->query($sql);
            if($result->num_rows > 0 ){
                while($rows = $result->fetch_assoc()){
                    $group_id = $rows["id"];
                    echo "<tr onclick='callMembers($group_id)'>";
                    echo "  <td>".$rows["groupname"];
                    echo "</tr>";
                }
            }
        ?>
    </table>
    <table>
        <tr>
            <th>  Level </th>
            <th>  Name </th>
            <th colspan="3">  Action </th>
        </tr>
        <tbody id="member_tbl">
        </tbody>
    </table>
</body>
</html>