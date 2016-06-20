<?php
//session_start();
include_once '../config/connect.php';
require_once("password_compatibility_library.php");
switch ($_POST['type']) {
    case 'loadinfo':
        loadinfo();
        break;
    case 'changepassword':
        changepassword();
        break;
    case 'changeinfo_update':
        changeinfo_update();
        break;
    case 'changeinfo_delete':
        changeinfo_delete();
        break;
}
function loadinfo(){
    $_agentid=$_POST['aid'];
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM agent WHERE aid = '{$_agentid}'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        echo 'load agent information</br>';
        ?>
<script>
        $(document).ready(function() {
            $("#agentid").val("<?php echo $_agentid;?>");
            $("#changeinfo_firstname").val("<?php echo $row['afirst_name'];?>");
            $("#changeinfo_lastname").val("<?php echo $row['alast_name'];?>");
            $("#changeinfo_address").val("<?php echo $row['aaddress'];?>");
            $("#changeinfo_city").val("<?php echo $row['acity'];?>");
            $("#changeinfo_province").val("<?php echo $row['aprovince'];?>");
            $("#changeinfo_zip").val("<?php echo $row['azip'];?>");
            $("#changeinfo_phone").val("<?php echo $row['aphone'];?>");
            $("#changeinfo_email").val("<?php echo $row['aemail'];?>");
            $("#changeinfo_level").prop("selectedIndex",function(){
            	var cp='<?php echo $row['alevel'];?>';
            	switch(cp){
            	case '0' :return 0;break;
        		case '30':return 1;break;
        		case '35':return 2;break;
        		case '40':return 3;break;
        		case '45':return 4;break;
        		case '50':return 5;break;
            	}
            });
        });
        </script>
<?php 
    }else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
function changepassword()
{
    $_agentid=$_POST['aid'];
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $newpassword = $_POST['changepassword_newpassword'];
    $oldpassword = $_POST['changepassword_oldpassword'];
    $user_newpassword_hash = password_hash($newpassword, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM agent WHERE aid = '{$_agentid}'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($oldpassword, $row["auser_password"])) {
            // echo 'ok';
            $sql = "UPDATE agent SET auser_password='{$user_newpassword_hash}' WHERE aid={$row['aid']}";
            
            if ($conn->query($sql) === TRUE) {
                echo "New Password updated successfully, password changed";
            } else {
                echo "Error updating record: " . $conn->error;
            }
            // insert to database agent table
        } else {
            echo 'Password NOT CHANGED, please verify old password';
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
function changeinfo_update(){
    $_agentid=$_POST['aid'];
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $afirstname = str_replace("'", "''", $_POST['changeinfo_firstname']);
    $alastname = str_replace("'", "''", $_POST['changeinfo_lastname']);
    $address = str_replace("'", "''", $_POST['changeinfo_address']);
    
    $sql = "UPDATE agent SET
    afirst_name='{$afirstname}',
    alast_name='{$alastname}',
    aaddress='{$address}',
    acity='{$_POST['changeinfo_city']}',
    aprovince='{$_POST['changeinfo_province']}',
    azip='{$_POST['changeinfo_zip']}',
    aphone='{$_POST['changeinfo_phone']}',
    alevel='{$_POST['changeinfo_level']}',
    aemail='{$_POST['changeinfo_email']}'
    WHERE aid='$_agentid'";
    if ($conn->query($sql) === TRUE) {
        echo "agent updated successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
function changeinfo_delete(){
    $_agentid=$_POST['aid'];
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE agent SET astatus=0 WHERE aid='$_agentid'";
    if ($conn->query($sql) === TRUE) {
        echo "agent deleted successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>