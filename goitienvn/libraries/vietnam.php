<?php
// initial all temp session ID
include_once '../config/connect.php';
switch ($_POST['type']) {
    // localview/////////////////////////////
    case 'vnview_mophieu':
        vnview_mophieu();
        break;
    case 'vnview_dongphieu':
        vnview_dongphieu();
        break;
    case 'vnview_inphieu':
        vnview_inphieu();
        break;
    case 'vnview_phieu_update':
        vnview_phieu_update();
        break;
    
    case 'vnview_thanhtoan':
        vnview_thanhtoan();
        break;
}

function vnview_mophieu()
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
    $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where transaction.transaction_status=2 order by transaction.created_date ASC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // ----------------------------------------        ?>
<style>
td {
	padding: 4px;
}

.rheader {
	text-transform: uppercase;
	font-weight: bold;
	background-color: #f4f4f4;
	box-shadow: 1px 1px 5px #888888;
	padding: 0px 10px 2px 3px;
}

.row {
	padding: 3px 0px 2px 2px;
	vertical-align: middle;
	cursor: hand;
	cursor: pointer;
}

._R {
	text-align: right;
}

._L {
	text-align: left;
	padding: 0px 10px 2px 3px;
}

._RR {
	text-align: right;
	font-weight: bold;
}

.hoveron {
	color: #990000;
	background-color: #f1f1f1;
}

.selected {
	color: #fff;
	background-color: #69230C;
}
</style>
<script>
        $(document).ready(function() {
        $( ".row" ).bind( "mouseenter mouseleave", function() {
        	$( this ).toggleClass( "hoveron" );
        	});
        });
        $(".row").click(function(){
        	$( this ).toggleClass( "selected" );
        	var selectedrow=$(this).attr("class");
        	if (selectedrow=="row hoveron selected"){
            	$("#selected_transactionid").val($(this).attr('id'));
            	$("#selected_transaction_co_no").val($(this).attr('co'));
            	var selectedtransactionid=$("#selected_transactionid").val();
        		//alert(selectedtransactionid);
        		if(selectedtransactionid==0){
        			alert('Xin vui lòng chọn phiếu để gữi, Cám ơn');
        		}else{
        			//alert(selectedtransactionid);
        			$.ajax({
                		type : "POST",
                		url : "libraries/vietnam.php",
                		data : {
                			type : "vnview_inphieu",tid:selectedtransactionid,status:"guiphieu"
                		},
                		cache : false,
                		success : function(result) {
                			$("#dialog_guiphieu").html(result);
                		}
                	});
        			$("#dialog_guiphieu").dialog('option', 'title', 'Phiếu số: '+$("#selected_transaction_co_no").val());
        			$("#dialog_guiphieu").dialog("open");
        		}
        	}
        });
        </script>
<table width="800" border="0" cellspacing="2" cellpadding="2">
	<tr class="rheader">
		<td>Số Phiếu</td>
		<td>người gữi</td>
		<td>người nhận</td>
		<td>hối xuất</td>
		<td>tiền nhận</td>
		<td>tiền giao</td>
		<td>time</td>
		<td>status</td>
	</tr>
        <?php
        // ------------------------------------------------------
        
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr class=\"row\" id=" . $row["id"] . " co=" . $row["confirmation_no"] . ">
                        <td class=\"_L\">" . $row["confirmation_no"] . "</td>
                        <td class=\"_L\">" . $row["cfirst_name"] . " " . $row["clast_name"] . " </td>
                        <td class=\"_L\">" . $row["rfirst_name"] . " " . $row["rlast_name"] . "</td>
                        <td class=\"_R\">" . _f($row["exchange_rate"]) . "</td>
                        <td class=\"_R\"> " . _f($row["local_amount"]) . "</td>
                        <td class=\"_R\">" . _f($row["foreign_amount"]) . "</td>
                        <td class=\"_R\">" . $row["created_date"] . "</td>
                        <td class=\"_R\">" . _status($row["transaction_status"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
}
function vnview_dongphieu()
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
    $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where transaction.transaction_status=3 order by transaction.created_date ASC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
            // ----------------------------------------        ?>
    <style>
    td {
    	padding: 4px;
    }
    
    .rheader {
    	text-transform: uppercase;
    	font-weight: bold;
    	background-color: #f4f4f4;
    	box-shadow: 1px 1px 5px #888888;
    	padding: 0px 10px 2px 3px;
    }
    
    .row {
    	padding: 3px 0px 2px 2px;
    	vertical-align: middle;
    	cursor: hand;
    	cursor: pointer;
    }
    
    ._R {
    	text-align: right;
    }
    
    ._L {
    	text-align: left;
    	padding: 0px 10px 2px 3px;
    }
    
    ._RR {
    	text-align: right;
    	font-weight: bold;
    }
    
    .hoveron {
    	color: #990000;
    	background-color: #f1f1f1;
    }
    
    .selected {
    	color: #fff;
    	background-color: #69230C;
    }
    </style>
    <script>
            $(document).ready(function() {
            $( ".row" ).bind( "mouseenter mouseleave", function() {
            	$( this ).toggleClass( "hoveron" );
            	});
            });
            $(".row").click(function(){
            	$( this ).toggleClass( "selected" );
            	var selectedrow=$(this).attr("class");
            	if (selectedrow=="row hoveron selected"){
                	$("#selected_transactionid").val($(this).attr('id'));
                	$("#selected_transaction_co_no").val($(this).attr('co'));
                	var selectedtransactionid=$("#selected_transactionid").val();
            		//alert(selectedtransactionid);
            		if(selectedtransactionid==0){
            			alert('Xin vui lòng chọn phiếu để gữi, Cám ơn');
            		}else{
            			//alert(selectedtransactionid);
            			$.ajax({
                    		type : "POST",
                    		url : "libraries/vietnam.php",
                    		data : {
                    			type : "vnview_inphieu",tid:selectedtransactionid,status:"guiphieu"
                    		},
                    		cache : false,
                    		success : function(result) {
                    			$("#dongphieu_detail").html(result);
                    		}
                    	});
            			$("#dialog_dongphieu").dialog('option', 'title', 'Phiếu số: '+$("#selected_transaction_co_no").val());
            			$("#dialog_dongphieu").dialog("open");
            		}
            	}
            });
            </script>
    <table width="800" border="0" cellspacing="2" cellpadding="2">
    	<tr class="rheader">
    		<td>Số Phiếu</td>
    		<td>người gữi</td>
    		<td>người nhận</td>
    		<td>hối xuất</td>
    		<td>tiền nhận</td>
    		<td>tiền giao</td>
    		<td>time</td>
    		<td>status</td>
    	</tr>
            <?php
            // ------------------------------------------------------
            
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row\" id=" . $row["id"] . " co=" . $row["confirmation_no"] . ">
                            <td class=\"_L\">" . $row["confirmation_no"] . "</td>
                            <td class=\"_L\">" . $row["cfirst_name"] . " " . $row["clast_name"] . " </td>
                            <td class=\"_L\">" . $row["rfirst_name"] . " " . $row["rlast_name"] . "</td>
                            <td class=\"_R\">" . _f($row["exchange_rate"]) . "</td>
                            <td class=\"_R\"> " . _f($row["local_amount"]) . "</td>
                            <td class=\"_R\">" . _f($row["foreign_amount"]) . "</td>
                            <td class=\"_R\">" . $row["created_date"] . "</td>
                            <td class=\"_R\">" . _status($row["transaction_status"]) . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
    
}

function vnview_inphieu()
{
    $tid = $_POST['tid'];
    $phieu_status = $_POST['status'];
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
    $sql = "select customer.*, receiver.*, transaction.* from transaction
inner join customer on customer.cid = transaction.customer_id
inner join receiver on receiver.rid = transaction.receiver_id
where transaction.id ='{$tid}'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>
        <style>
.t {
	font: bold 14px "Courier New", Courier, monospace;
	padding: 3px;
}

.w {
	font: bold 10px Georgia, "Times New Roman", Times, serif;
	color: red;
	text-transform: uppercase;
	align: center;
}
</style>
        <?php
        $out = "";
        // display phieu status
        /*
        if ($phieu_status == "guiphieu" && $row['transaction_status'] == 1) {
            $out .= "<div class=\"w\">Phiếu NOT APPROVED - xin vui lòng xem lại</div>";
        } else 
            if ($phieu_status == "guiphieu" && $row['transaction_status'] == 3) {
                $out .= "<div class=\"w\">Phiếu đang gữi - xin vui lòng xem lại</div>";
            } else 
                if ($phieu_status == "guiphieu" && $row['transaction_status'] == 4) {
                    $out .= "<div class=\"w\">Phiếu đã nhận - xin vui lòng xem lại</div>";
                } else 
                    if ($phieu_status == "guiphieu" && $row['transaction_status'] == 5) {
                        $out .= "<div class=\"w\">Phiếu đã đóng - xin vui lòng xem lại</div>";
                    } else 
                        if ($phieu_status == "dongphieu" && $row['transaction_status'] == 1) {
                            $out .= "<div class=\"w\">Phiếu NOT APPROVED, xin vui lòng xem lại trước khi đóng</div>";
                        } else 
                            if ($phieu_status == "dongphieu" && $row['transaction_status'] == 2) {
                                $out .= "<div class=\"w\">Phiếu chưa gữi - xin vui lòng xem lại</div>";
                            } else 
                                if ($phieu_status == "dongphieu" && $row['transaction_status'] == 4) {
                                    $out .= "<div class=\"w\">Phiếu đã nhận - xin vui lòng xem lại</div>";
                                } else 
                                    if ($phieu_status == "dongphieu" && $row['transaction_status'] == 5) {
                                        $out .= "<div class=\"w\">Phiếu đã đóng - xin vui lòng xem lại</div>";
                                    }*/
        
        $out .= "<table cellpadding=\"3\">";
        $out .= "<tr><td class=\"t\">Người gữi</br>" . $row['cfirst_name'] . " " . $row['clast_name'] . ". " . $row['cphone'] . "</br>
	           " . $row['caddress'] . " " . $row['ccity'] . " " . $row['cprovince'] . " " . $row['ccountry'] . ".</td></tr>";
        $out .= "<tr><td class=\"t\">Người Nhận</br>" . $row['rfirst_name'] . " " . $row['rlast_name'] . ". " . $row['rphone1'] . "</br>
        	    " . $row['rdiachi'] . " " . $row['rtp_tinh'] . " " . $row['rcountry'] . ".</td></tr>";
        $out .= "<tr><td class=\"t\">Chi tiết</br>" . "Ngày Gữi : " . $row['created_date'] . "</br>" . "Tiền Gữi : " . $row['local_amount'] . " " . $row['local_currency_type'] . "</br>" . "Tiền Nhận: " . $row['foreign_amount'] . " " . $row['foreign_currency_type'] . "</td></tr>";
        $out .= "</table>";
        echo ($out);
    } else {
        echo "0 results";
    }
    $conn->close();
}

function vnview_phieu_update()
{
    $tid = $_POST['tid'];
    $status=$_POST['status'];
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE transaction SET transaction_status='{$status}' WHERE id='{$tid}'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();
}



function vnview_thanhtoan()
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
    $sql = "select customer.*, receiver.*, transaction.* from transaction
inner join customer on customer.cid = transaction.customer_id
inner join receiver on receiver.rid = transaction.receiver_id
where transaction.transaction_status=4
order by transaction.transaction_status ASC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // ----------------------------------------        ?>
    <style>
.rheader {
	text-transform: uppercase;
	font-weight: bold;
	background-color: #f4f4f4;
	box-shadow: 1px 1px 5px #888888;
	padding: 0px 10px 2px 3px;
}

.row {
	padding: 3px 0px 2px 2px;
	vertical-align: middle;
	cursor: hand;
	cursor: pointer;
}

._R {
	text-align: right;
}

._L {
	text-align: left;
	padding: 0px 10px 2px 3px;
}

._RR {
	text-align: right;
	font-weight: bold;
}

.entered {
	color: #990000;
	background-color: #f1f1f1;
}

.selected {
	color: #fff;
	background-color: #3A4061;
}
.d{
    padding:3px 0px 3px 0px;
	border-bottom:solid 1px #333;
}
</style>
	<script>
        $(document).ready(function() {
        $( ".row" ).bind( "mouseenter mouseleave", function() {
        	$( this ).toggleClass( "entered" );
        	});
        });
        </script>
	<table width="80%" border="0" cellspacing="2" cellpadding="2">
		<tr class="rheader">
			<td>Số Phiếu</td>
			<td>người gữi</td>
			<td>người nhận</td>
			<td>hối xuất</td>
			<td>tiền nhận</td>
			<td>tiền giao</td>
			<td>time</td>
			<td>status</td>
		</tr>
        <?php
        // ------------------------------------------------------
        
        // output data of each row
        $out = "";
        while ($row = $result->fetch_assoc()) {
            $out.= "<tr class=\"row\" id=" . $row["id"] . " co=" . $row["confirmation_no"] . ">
                        <td class=\"_L\">" . $row["confirmation_no"] . "</td>
                        <td class=\"_L\">" . $row["cfirst_name"] . " " . $row["clast_name"] . " </td>
                        <td class=\"_L\">" . $row["rfirst_name"] . " " . $row["rlast_name"] . "</td>
                        <td class=\"_R\">" . _f($row["exchange_rate"]) . "</td>
                        <td class=\"_R\"> " . _f($row["local_amount"]) . "</td>
                        <td class=\"_R\">" . _f($row["foreign_amount"]) . "</td>
                        <td class=\"_R\">" . $row["created_date"] . "</td>
                        <td class=\"_R\">" . _status($row["transaction_status"]) . "</td></tr>";
                       
       
        }
        // get sum data
        $sql = "select  
        	           sum(local_amount) as Slocalamount,
        	           sum(foreign_amount) as Sdeliveryamount
        	    from transaction where transaction_status=4";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $out.=  "<tr class=\"row\">
                        <td></td>
                        <td></td><td></td>
                        <td></td><td class=\"_RR\"> " . _f($row["Slocalamount"]) . "</td>
                        <td class=\"_RR\"> " . _f($row["Sdeliveryamount"]) . "</td>
                        <td></td><td></td></tr>";
        }
        
        $out.=  "</table>";
    } else {
        $out.=  "0 results";
    }
    echo $out;
    $conn->close();
}
// ////////////////////////////////////////
// HELPER FUNCTION
// ////////////////////////////////////////
function _status($s)
{
    switch ($s) {
        case '1':
            return 'n/a*';
            break;
        case '2':
            return 'mới';
            break;
        case '3':
            return 'gữi';
            break;
        case '4':
            return 'nhận';
            break;
        case '5':
            return 'đóng*';
            break;
        case '6':
            return 'hủy*';
            break;
    }
}

function _c($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function _f($number)
{
    setlocale(LC_MONETARY, 'en_US');
    $temp = money_format('%(#10n', $number);
    //$temp = number_format($number, 2, '.', '');
    return $temp;
}
?>

