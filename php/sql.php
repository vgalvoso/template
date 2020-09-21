<?php
include "../connect.php";
    if(isset($_POST["call_members"])){
        $group_id = $_POST["group_id"];
        $sql = "SELECT * FROM calllists WHERE clid = $group_id ORDER BY level";
        $result = $conn->query($sql);
        if($result->num_rows > 0 ){
            while($rows = $result->fetch_assoc()){
                $old_level = $rows["level"];
                $member_id = $rows["id"];
                echo "<tr>";
                echo "  <td>".$rows["level"]."</td>";
                echo "  <td>".$rows["name"]."</td>";
                        $new_level = upLevel($old_level);
                echo "  <td>
                            <input type='submit' value='Top' 
                                    onclick='sortList($member_id,$old_level,1,$group_id,1)'/>
                        </td>";
                        $new_level = upLevel($old_level);
                echo "  <td><input type='submit' value='Up'
                                    onclick='sortList($member_id,$old_level,$new_level,$group_id,0)' /></td>";
                        $new_level = downLevel($old_level);
                echo "  <td><input type='submit' value='Down'
                                    onclick='sortList($member_id,$old_level,$new_level,$group_id,0)' /></td>";
                        $new_level = downLevel($old_level);
                echo "  <td><input type='submit' value='Bottom'
                                    onclick='sortList($member_id,$old_level,4,$group_id,2)'  /></td>";
                echo "</tr>
                <script src='../js/jquery-3.2.1.min.js'></script>
                <script src='../js/javascript.js'></script>";
            }
        }
    }

    if(isset($_POST["sort"])){
        //sort top
        $member_id = $_POST["member_id"];
        $group_id = $_POST["group_id"];
        $new_level = $_POST["new_level"];
        $old_level = $_POST["old_level"];
        $sort_type = $_POST["sort_type"];
        if($sort_type == 1){
            toTop($old_level,$group_id,$member_id);
        }
        else if($sort_type == 2){
            toBottom($old_level,$group_id,$member_id);
        }
        else
        {
            $sql1 = "UPDATE calllists SET level = $new_level WHERE level = $old_level AND clid = $group_id";
            $conn->query($sql1);

            $sql2 = "UPDATE calllists SET level = $old_level WHERE level = $new_level AND clid = $group_id AND id != $member_id";
            $conn->query($sql2);
        }
    }

    
    function toTop($old_level,$group_id,$member_id){
        include "../connect.php";
        $sql1 = "UPDATE calllists SET level = 1 WHERE level = $old_level AND clid = $group_id";
        $sql2 = "UPDATE calllists SET level = 2 WHERE level = 1 AND clid = $group_id AND id != $member_id";        
        $sql3 = "UPDATE calllists SET level = 3 WHERE level = 2 AND clid = $group_id AND id != $member_id";
        $sql4 = "UPDATE calllists SET level = 4 WHERE level = 3 AND clid = $group_id AND id != $member_id";
    
        $conn->query($sql1);
        $conn->query($sql4);
        $conn->query($sql3);
        $conn->query($sql2);
    }
    
    function toBottom($old_level,$group_id,$member_id){
        include "../connect.php";
        $sql1 = "UPDATE calllists SET level = 4 WHERE level = $old_level AND clid = $group_id";
        $sql2 = "UPDATE calllists SET level = 3 WHERE level = 4 AND clid = $group_id AND id != $member_id";       
        $sql3 = "UPDATE calllists SET level = 2 WHERE level = 3 AND clid = $group_id AND id != $member_id"; 
        $sql4 = "UPDATE calllists SET level = 1 WHERE level = 2 AND clid = $group_id AND id != $member_id";
    
        $conn->query($sql1);
        $conn->query($sql4);
        $conn->query($sql3);
        $conn->query($sql2);
    }

    function getId($level,$group_id){
        include "../connect.php";
        $sql = "SELECT id FROM calllists WHERE level = $level AND clid = $group_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $id = $row["id"];
        return $id;
    }

    function upLevel($level){
        $new_level = (int)$level - 1;
        if($new_level <= 0){
            $new_level = 1;
        }
        return $new_level;
    }

    function downLevel($level){
        $new_level = (int)$level + 1;
        if($new_level >= 4){
            $new_level = 4;
        }
        return $new_level;
    }