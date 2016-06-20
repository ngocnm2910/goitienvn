<?php
// session_start();
// print_r($_SESSION);

// initial all temp session ID
include_once '../config/connect.php';
switch ($_POST['type']) {
    
    /////////////// customer //////////////
    case 'listcustomer':
        listcustomer();
        break;
    case 'listreceiver':
        listreceiver();
        break;
    case 'listtransaction':
        listtransaction();
        break;
    case 'loadcustomerfrm':
        $sql="select * from customer where cid='{$_POST['id']}'";
        loadcustomerfrm($sql);
        break;
    case 'loadcustomerfrm_onetime':
        $sql="select * from customer where cid='{$_POST['id']}'";
        loadcustomerfrm_onetime($sql);
        break;
    case 'loadreceiverfrm':
        $sql="select * from receiver where rid='{$_POST['id']}'";
        loadreceiverfrm($sql);
        break;
    case 'loadreceiverfrm_onetime':
        $sql="select * from receiver where rid='{$_POST['id']}'";
        loadreceiverfrm_onetime($sql);
        break;
    case 'loadallfrmbytransactionfrm':
        loadallfrmbytransactionfrm();
        break;
    case 'reportlistall':
        reportlistall();
        break;
    case 'customerphonesearch':
        customerphonesearch();
        break;
    case 'customernamesearch':
        customernamesearch();
        break;
    case 'receiverphonesearch':
        receiverphonesearch();
        break;
    case 'receivernamesearch':
        receivernamesearch();
        break;
    case 'transactionsubmit':
        transactionsubmit($_POST['customerid'],$_POST['receiverid'],$_POST['aid']);
        break;
    case 'printonly_transaction':
        printonly_transaction();
        break;
    case 'transactionsearchbyfromtodate':
        transactionsearchbyfromtodate();
        break;
        //reportlistfromtodate
    case 'reportlistfromtodate':
        reportlistfromtodate();
        break;
        
}


function reportlistfromtodate(){
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //fromdate:fromdate,todate:todate,reportlisttype:$("#report_showtype").val(),aid:$("#agentid").val()
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $searchtype=$_POST['reportlisttype'];
    $aid=$_POST['aid'];
    // Create connection
    if ($searchtype > 0) {
        // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
        $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where transaction.transaction_status='{$searchtype}' and transaction.agent_id='{$aid}' AND transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.transaction_status ASC";
    } else {
        $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where transaction.agent_id='{$aid}' AND transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.transaction_status ASC";
    }
/*
    $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
    inner join customer on customer.cid = transaction.customer_id
    inner join receiver on receiver.rid = transaction.receiver_id
    inner join agent on agent.aid = transaction.agent_id
    where transaction.transaction_status='{$searchtype}' and transaction.agent_id='{$aid}' 
    and AND transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.transaction_status ASC";
    
    */
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
    // ----------------------------------------        ?>
<style>
._R {
	text-align: right;
	padding: 2px 3px 2px 2px;
	border-bottom: solid 1px #ccc;
}

._RR {
	text-align: right;
	font-weight: bold;
	color: #990000;
	padding: 2px 3px 2px 2px;
	border-bottom: solid 1px #ccc;
}

._L {
	text-align: left;
	padding: 2px 8px 2px 2px;
	border-bottom: solid 1px #ccc;
}

.rtxt {
	text-align: right;
	font-weight: bold;
	color: #990000;
	padding: 2px 3px 2px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
	<tr>
		<td class="h">Co No.</td>
		<td class="h">customer</td>
		<td class="h">receiver</td>
		<td class="h">local</td>
		<td class="h">fee</td>
		<td class="h">total</td>
		<td class="h">time</td>
		<td class="h">status</td>
	</tr>
                <?php
                    // ------------------------------------------------------
                    
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                                <td class=\"_L\">" . _pco($row["confirmation_no"]) . "</td>
                                <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["cfirst_name"] . "</br> " . $row["clast_name"] . " </td>
                                <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["rfirst_name"] . "</br> " . $row["rlast_name"] . "</td>
                                <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                                <td class=\"_R\" nowrap=\"nowrap\">" . _f($row["fee_charge"]) . "</td><td class=\"_R\" > " . _f($row["total_amount"]) . "</td>
                                <td class=\"_R\" nowrap=\"nowrap\">" . substr($row["created_date"],0,-8) . "</td>
                                <td class=\"_R\" >" . _status($row["transaction_status"]) . "</td></tr>";
                    $alevel=$row["alevel"];
                    }
                    // get sum data
                    if ($searchtype > 0) {
                    $sql = "select
        	           sum(total_amount) as Stotalamount_new,
        	           sum(local_amount) as Slocalamount_new,
        	           sum(fee_charge) as Sfee_new
                       from transaction where transaction.agent_id='{$_POST['aid']}'AND transaction.created_date BETWEEN '{$fromdate}' and '{$todate}'  and transaction_status=$searchtype";
                    }else{
                        $sql = "select
                        sum(total_amount) as Stotalamount_new,
                        sum(local_amount) as Slocalamount_new,
                        sum(fee_charge) as Sfee_new
                        from transaction where transaction.agent_id='{$_POST['aid']}' AND transaction.created_date BETWEEN '{$fromdate}' and '{$todate}'";
                    }
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<tr class=\"row\">
                        <td></td><td></td><td class=\"rtxt\">TOTAL:</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Slocalamount_new"]) . "</td>
                        <td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Sfee_new"]) . "</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Stotalamount_new"]) . "</td>
                        <td></td><td></td><td></td>
                        </tr>";
                        echo "<tr class=\"row\">
                        <td></td><td></td><td class=\"rtxt\">COMMISSION:</td><td class=\"_RR\" nowrap=\"nowrap\"> " . $alevel . "%</td>
                        <td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Sfee_new"]*$alevel/100) . "</td><td class=\"_RR\" nowrap=\"nowrap\"> </td>
                        <td></td><td></td><td></td>
                        </tr>";
                    }
                   
                    echo "</table>";
                } else {
                    echo "0 results";
                }
                $conn->close();
}

function listcustomer(){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "select customer.*, agent_customer.* from agent_customer
    inner join customer on customer.cid=agent_customer.customer_id
    where agent_customer.agent_id='{$_POST['aid']}' order by cfirst_name ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        printjscript();
        echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
        echo "<tr><td class=\"h\" width=\"140\" >name, last name</td><td class=\"h\">phone</td><td class=\"h\">address</td><td class=\"h\">city</td><td class=\"h\">zip</td><td class=\"h\">province</td>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr class=\"row\" id=" . $row["cid"] . "  type=\"customer\">
                        <td class=\"sr\" nowrap=\"nowrap\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">
                            " . $row["cfirst_name"] . ",
                            " . $row["clast_name"] . "</td>
                        <td class=\"sr\">" . $row["cphone"] . "</td>
                        <td class=\"sr\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["caddress"] . "</td>
                        <td class=\"sr\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["ccity"] . "</td>    
                        <td class=\"sr\" style=\"text-transform:uppercase\" nowrap=\"nowrap\"> " . $row["czip"] . "</td>
                        <td class=\"sr\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["cprovince"] . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
}

function listreceiver(){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "select agent.aid, agent_customer.agent_id,agent_customer.customer_id,customer.*, customer_receiver.*, receiver.* from agent
    inner join agent_customer on agent.aid = agent_customer.agent_id
    inner join customer on customer.cid = agent_customer.customer_id
    inner join customer_receiver on customer_receiver.customer_id = agent_customer.customer_id
    inner join receiver on receiver.rid = customer_receiver.receiver_id
    where agent.aid='{$_POST['aid']}' order by rlast_name ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        printjscript();
        echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
        echo "<tr><td class=\"h\">Receiver name, last name</td><td class=\"h\">city</td><td class=\"h\">phone</td>
            <td class=\"h\">Sender Name, last name</td><td class=\"h\">Sender city</td><td class=\"h\">Sender Phone</td>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr class=\"row\" id=" . $row["rid"] . " type=\"receiver\" >
                        <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\"  nowrap=\"nowrap\" >
                                " . $row["rfirst_name"] . ",
                                " . $row["rlast_name"] . "
                        </td>
                        <td class=\"sr\" valign=\"top\">
                                " . printtptinh($row["rtp_tinh"]) . "</td>
                        <td class=\"sr\" valign=\"top\">
                                " . $row["rphone1"] . "</td>
                        <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase;background:#f9f9f9;\" nowrap=\"nowrap\">
                                " . $row["cfirst_name"] . ",
                                " . $row["clast_name"] . "
                        </td>
                        <td class=\"sr\" valign=\"top\" style=\"background:#f9f9f9;\">
                                " . $row["ccity"] . "</td>
                        <td class=\"sr\" valign=\"top\" nowrap=\"nowrap\" style=\"background:#f9f9f9;\" >
                                " . $row["cphone"] . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
}
function loadcustomerfrm($sql)
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        //echo "customer search/select >> found a record";
        $row = $result->fetch_assoc();
        jsloadcustomerfrm($row);
        searchreceiverbycustomer($row['cid']);
    }
    else{
        echo ">> customer search >> not found";
    }
    $conn->close();
}
function loadcustomerfrm_onetime($sql)
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        jsloadcustomerfrm($row);
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
function loadreceiverfrm($sql)
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        //echo "receiver search/select >> found a record";
        $row = $result->fetch_assoc();
        jsloadreceiverfrm($row);
        searchcustomerbyreceiver($row['rid']);
    }
    else{
        echo ">> receiver search >> not found";
    }
    $conn->close();
}
function loadreceiverfrm_onetime($sql)
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        jsloadreceiverfrm($row);
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
function reportlistall(){
        // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $searchtype = $_POST['report_showtype'];
    if ($searchtype > 0) {
        // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
        $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
    inner join customer on customer.cid = transaction.customer_id
    inner join receiver on receiver.rid = transaction.receiver_id
    inner join agent on agent.aid = transaction.agent_id
    where transaction.transaction_status='{$searchtype}' and transaction.agent_id='{$_POST['aid']}' order by transaction.transaction_status ASC";
    } else {
        $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where transaction.agent_id='{$_POST['aid']}' order by transaction.transaction_status ASC";
    }
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // ----------------------------------------        ?>
<style>
._R {
	text-align: right;
	padding: 2px 3px 2px 2px;
	border-bottom: solid 1px #ccc;
}

._RR {
	text-align: right;
	font-weight: bold;
	color: #990000;
	padding: 2px 3px 2px 2px;
	border-bottom: solid 1px #ccc;
}

._L {
	text-align: left;
	padding: 2px 8px 2px 2px;
	border-bottom: solid 1px #ccc;
}

.rtxt {
	text-align: right;
	font-weight: bold;
	color: #990000;
	padding: 2px 3px 2px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
	<table width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<td class="h">Co No.</td>
			<td class="h">customer</td>
			<td class="h">receiver</td>
			<td class="h">local</td>
			<td class="h">fee</td>
			<td class="h">total</td>
			<td class="h">time</td>
			<td class="h">status</td>
		</tr>
            <?php
                // ------------------------------------------------------
                
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                            <td class=\"_L\">" . _pco($row["confirmation_no"]) . "</td>
                            <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["cfirst_name"] . ", " . $row["clast_name"] . " </td>
                            <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["rfirst_name"] . ", " . $row["rlast_name"] . "</td>
                            <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                            <td class=\"_R\" nowrap=\"nowrap\">" . _f($row["fee_charge"]) . "</td><td class=\"_R\" > " . _f($row["total_amount"]) . "</td>
                            <td class=\"_R\" nowrap=\"nowrap\">" . substr($row["created_date"],0,-8) . "</td>
                            <td class=\"_R\" >" . _status($row["transaction_status"]) . "</td></tr>";
                }
                // get sum data
                if ($searchtype > 0) {
                $sql = "select
    	           sum(total_amount) as Stotalamount_new,
    	           sum(local_amount) as Slocalamount_new,
    	           sum(fee_charge) as Sfee_new
                   from transaction where transaction.agent_id='{$_POST['aid']}'and transaction_status=$searchtype";
                }else{
                    $sql = "select
                    sum(total_amount) as Stotalamount_new,
                    sum(local_amount) as Slocalamount_new,
                    sum(fee_charge) as Sfee_new
                    from transaction where transaction.agent_id='{$_POST['aid']}'";
                }
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<tr class=\"row\">
                    <td></td><td></td><td class=\"rtxt\">TOTAL:</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Slocalamount_new"]) . "</td>
                    <td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Sfee_new"]) . "</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Stotalamount_new"]) . "</td>
                    <td></td><td></td><td></td>
                    </tr>";
                }
                // get sum data
                /*
                $sql = "select
                sum(total_amount) as Stotalamount_pending,
                sum(local_amount) as Slocalamount_pending,
                sum(fee_charge) as Sfee_pending
                from transaction where transaction.agent_id='{$_POST['aid']}' and transaction_status=2";
                $result = $conn->query($sql);
                
                    if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<tr class=\"row\">
                <td></td><td></td><td class=\"rtxt\">approved trans:</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Slocalamount_pending"]) . "</td>
                <td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Sfee_pending"]) . "</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Stotalamount_pending"]) . "</td>
                    <td></td><td></td><td></td>
                    </tr>";
                }
                // get sum data
                $sql = "select
                sum(total_amount) as Stotalamount_received,
                sum(local_amount) as Slocalamount_received,
                sum(fee_charge) as Sfee_received
                from transaction where transaction.agent_id='{$_POST['aid']}' and transaction_status=4";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<tr class=\"row\">
                <td></td><td></td><td class=\"rtxt\">received trans:</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Slocalamount_received"]) . "</td>
                <td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Sfee_received"]) . "</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Stotalamount_received"]) . "</td>
                    <td></td><td></td><td></td>
                                    </tr>";
                }
                // get sum data
                $sql = "select
                sum(total_amount) as Stotalamount_complete,
                sum(local_amount) as Slocalamount_complete,
                sum(fee_charge) as Sfee_complete
                from transaction where transaction.agent_id='{$_POST['aid']}' and transaction_status=5";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<tr class=\"row\">
                <td></td><td></td><td class=\"rtxt\">completed trans:</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Slocalamount_complete"]) . "</td>
                <td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Sfee_complete"]) . "</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Stotalamount_complete"]) . "</td>
                    <td></td><td></td><td></td>
                                    </tr>";
                }
                */
                echo "</table>";
            } else {
                echo "0 results";
            }
            $conn->close();
}

function listtransaction(){

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
    where transaction.agent_id='{$_POST['aid']}' order by transaction.created_date ASC";
    $result = $conn->query($sql);
// list all transaction
    if ($result->num_rows > 0) {
        printjscript();
         ?>
    <style>
._R {
	text-align: right;
	padding: 2px 3px 2px 2px;
	border-bottom: solid 1px #ccc;
}

._L {
	text-align: left;
	padding: 2px 8px 2px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
	
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>
				<td class="h">No.</td>
				<td class="h">Ref#</td>
				<td class="h" width="180px">Customer</td>
				<td class="h" width="240px">Beneficiary</td>
				<td class="h">Amount</td>
				<td class="h">Time</td>
				<td class="h">Status</td>
			</tr>

        <?php
            // output data of each row
			//                         <td class=\"_L\">" . _pco($row["confirmation_no"]) . "</td>

            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                        <td class=\"_L\" nowrap=\"nowrap\">" . $row["id"] . "</td>
                        <td class=\"_L\" nowrap=\"nowrap\">" . _pco($row["confirmation_no"]) . "</td>
                        <td class=\"_L\" style=\"text-transform:uppercase\">" . $row["cfirst_name"] . "," . $row["clast_name"] . " </td>
                        <td class=\"_L\" style=\"text-transform:uppercase\">" . $row["rfirst_name"] . "," . $row["rlast_name"] . "</td>
                        <td class=\"_R\" style=\"color:#990000;font-weight:bold;\"> " . _f($row["local_amount"]) . "</td>
                        <td class=\"_R\" nowrap=\"nowrap\">" . substr($row["created_date"],0,10) . "</td>
                        <td class=\"_R\" style=\"font-weight:bold;\"style=\"color:#990000;font-weight:bold;\">" . _status($row["transaction_status"]) . "</td></tr>";
            }
            
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
}
function loadallfrmbytransactionfrm(){
        // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql="select transaction.*, agent.*, customer.*, receiver.* FROM transaction
    inner join agent on transaction.agent_id=agent.aid
    inner join customer on transaction.customer_id=customer.cid
    inner join receiver on transaction.receiver_id=receiver.rid
    where transaction.id='{$_POST['id']}'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        echo 'selected transaction load to NEW form, warning by submit will create new transaction.';
        $row = $result->fetch_assoc();
        jsloadcustomerfrm($row);
        jsloadreceiverfrm($row);
        jsloadtransactionfrm($row);
        
    } else {
        echo "transaction search >> not found";
    }
    $conn->close();
    
    
}

function jsloadcustomerfrm($row){
    ?>
    <script>
        $("#customerid").val('<?php echo $row['cid'];?>');
    	$("#clname").val("<?php echo $row['clast_name'];?>");
        $("#cfname").val("<?php echo $row['cfirst_name'];?>");
        $("#caddress").val("<?php echo $row['caddress'];?>");
        $("#ccity").val('<?php echo $row['ccity'];?>');
        $("#cprovince").prop("selectedIndex",function(){
        	var cp='<?php echo $row['cprovince'];?>';
        	switch(cp){
    		case 'qc':return 0;break;
    		case 'on':return 1;break;
    		case 'mb':return 2;break;
    		case 'sk':return 3;break;
    		case 'ab':return 4;break;
    		case 'bc':return 5;break;
    		case 'nf':return 6;break;
    		case 'pe':return 7;break;
    		case 'nb':return 8;break;
    		case 'ns':return 9;break;
    		case 'nt':return 10;break;
        	}
        });
        $("#czip").val('<?php echo $row['czip'];?>');
        $("#cphone").val('<?php echo $row['cphone'];?>');
        $("#cemail").val('<?php echo $row['cemail'];?>');
    </script>
    <?php 
}
function jsloadreceiverfrm($row){
    ?>
    <script>
        //receiver
        $("#receiverid").val('<?php echo $row['rid'];?>')
    	$("#rlname").val('<?php echo $row['rlast_name'];?>');
        $("#rfname").val('<?php echo $row['rfirst_name'];?>');
        $("#rdiachi").val('<?php  echo $row['rdiachi'];?>');
        $("#rtptinh").prop("selectedIndex",parseInt('<?php echo $row['rtp_tinh'];?>'));
        $("#rphone").val('<?php echo $row['rphone1'];?>');
        $("#remail").val('<?php echo $row['remail'];?>');
    </script>
    <?php 
}
function jsloadtransactionfrm($row){
    ?>
    <script>
        //transaction
        $("#transactionid").val('<?php echo $row['id'];?>')
        $("#trans_conumber").val('<?php echo $row['confirmation_no'];?>');
        $("#trans_phonenumber").val('<?php echo $row['cphone'];?>');
        $("#localamount").val('<?php echo $row['local_amount'];?>');
        $("#selectlocaltype").prop("selectedIndex",parseInt('<?php echo $row['local_currency_type'];?>'));
        $("#selectdeliverytype").prop("selectedIndex",parseInt('<?php echo $row['foreign_currency_type'];?>'));
        $("#deliveryamount").val('<?php echo $row['foreign_amount'];?>');
        $("#fee").val('<?php echo $row['fee_charge'];?>');
        $("#totalamount").val('<?php echo $row['total_amount'];?>');
        $("#deliverymethod").prop("selectedIndex",parseInt('<?php echo $row['delivery_method'];?>'));
        $("#tnote").val('<?php echo $row['transaction_note'];?>');
        //admin
        $("#adstatus").prop("selectedIndex",parseInt('<?php echo $row['transaction_status'];?>')-1);
        $("#adconfirmationby").prop("selectedIndex",parseInt('<?php echo $row['transaction_confirmby'];?>'));
        $("#adnote").val('<?php echo $row['transaction_note'];?>');
    </script>
    <?php 
}
//////////////////////////////
// search operation
//////////////////////////////
function customerphonesearch(){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql="select * from customer where cstatus=1 AND cphone='{$_POST['phone_no']}'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        echo "customer search >> found a record|";
        $row = $result->fetch_assoc();
        jsloadcustomerfrm($row);
        searchreceiverbycustomer($row['cid']);
    }
    else{
        echo "customer search >> not found|";
    }
    $conn->close();
}
function customernamesearch(){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (preg_match("/^[  a-zA-Z]+/", $_POST['name'])) {
        $name = $_POST['name'];
        $sql = "SELECT customer.*, agent_customer.* FROM agent_customer 
                INNER JOIN customer ON agent_customer.`customer_id`=customer.`cid`
                WHERE agent_customer.`agent_id`='{$_POST['aid']}' AND cfirst_name LIKE '{$name}' OR clast_name LIKE '{$name}'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            echo "customer search >> found a record|";
            $row = $result->fetch_assoc();
            jsloadcustomerfrm($row);
            searchreceiverbycustomer($row['cid']);
        }else if($result->num_rows == 0) {
            echo "customer search >> not found|";
        }else{
            ?>
     <style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
			<script>
    $(".row_c").bind( "mouseenter mouseleave", function() {
		$( this ).toggleClass( "entered" );
	});
	$(".row_c").click(function(){
		var rowid=$(this).attr('id');
		$( this ).toggleClass( "selected" );
    	var selectedrow=$(this).attr("class");
    	//row is selected - highlite
    	if (selectedrow=="row_c entered selected"){
    		var id =$(this).attr('id');
    		//alert(type+id+ajaxtype);
    		$.ajax({
        		type : "POST",
        		url : "libraries/local.php",
        		data : {
        			type : 'loadcustomerfrm',id:id
        		},
        		cache : false,
        		success : function(result) {
        			$("#receiverinfo").html(result);
        		}
        	});
    	}
	});
	</script>
    <?php 
            //echo "customer search >> found multiple records|";
            echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row_c\" id=" . $row["cid"] . "  type=\"customer\">
                        <td class=\"sr\" nowrap=\"nowrap\" style=\"text-transform:uppercase\">
                            " . $row["cfirst_name"] . ",
                            " . $row["clast_name"] . "</td>
                        <td class=\"sr\" nowrap=\"nowrap\">" . $row["cphone"] . "</td>
                        <td class=\"sr\" >" . $row["caddress"] . "</td>
                  
                    </tr>";
            }
            echo "</table>";
        }
    }
    $conn->close();
}

function searchreceiverbycustomer($cid)
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "select customer.*, customer_receiver.*,receiver.* from customer
    inner join customer_receiver on customer.cid=customer_receiver.customer_id
    inner join receiver on customer_receiver.receiver_id=receiver.rid
    where customer.cid='{$cid}' order by receiver.rlast_name, receiver.rfirst_name ASC";
    $result = $conn->query($sql);
    $out="";
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        jsloadreceiverfrm($row);
    }
    else if ($result->num_rows > 1) {
        ?>
     <style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
			<script>
    $(".row_r").bind( "mouseenter mouseleave", function() {
		$( this ).toggleClass( "entered" );
	});
	$(".row_r").click(function(){
		var rowid=$(this).attr('id');
		$( this ).toggleClass( "selected" );
    	var selectedrow=$(this).attr("class");
    	//row is selected - highlite
    	if (selectedrow=="row_r entered selected"){
    		var id =$(this).attr('id');
    		$.ajax({
        		type : "POST",
        		url : "libraries/local.php",
        		data : {
        			type : 'loadreceiverfrm_onetime',id:id
        		},
        		cache : false,
        		success : function(result) {
        			$("#infobar").html(result);
        		}
        	});
    	}
	});
	//receiver frm
	$("#receiverid").val('');
	$("#rfname").val('');
	$("#rlname").val('');
	$("#rdiachi").val('');
	$("#rphone").val('');
	$("#remail").val('');
	$("#rtptinh").prop("selectedIndex",0);
	</script>
    <?php 
        $out = "<table width=\"100%\"  cellspacing=\"1\" cellpadding=\"3\">";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $out .= "<tr class=\"row_r\" id=" . $row["rid"] . " type=\"receiver\" >               
                            <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\"  nowrap=\"nowrap\" >
                                    " . $row["rfirst_name"] . ", 
                                    " . $row["rlast_name"] . " 
                            </td>
                            <td class=\"sr\" valign=\"top\"nowrap=\"nowrap\">
                                    " . $row["rphone1"] . "</td>
                        </tr>";
        }
        $out .= "</table>";
    } else {
        //$out = "no receivers found</br>";
        ?>
        <script>
        //receiver frm
    	$("#receiverid").val('');
    	$("#rfname").val('');
    	$("#rlname").val('');
    	$("#rdiachi").val('');
    	$("#rphone").val('');
    	$("#remail").val('');
    	$("#rtptinh").prop("selectedIndex",0);
    	</script>
        <?php
    }
    echo $out;
    $conn->close();
}

function receiverphonesearch(){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql="select * from receiver where rstatus=1 AND rphone1='{$_POST['phone_no']}'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        echo "receiver search >> found a record|";
        $row = $result->fetch_assoc();
        jsloadreceiverfrm($row);
        searchcustomerbyreceiver($row['rid']);
    }
    else{
        echo "receiver search >> not found|";
    }
    $conn->close();
}
function receivernamesearch(){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (preg_match("/^[  a-zA-Z]+/", $_POST['name'])) {
        $name = $_POST['name'];
        $sql = "SELECT * FROM receiver WHERE rfirst_name LIKE '{$name}' OR rlast_name LIKE '{$name}'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
        echo "receiver search >> found a record|";
            $row = $result->fetch_assoc();
            jsloadcustomerfrm($row);
            searchreceiverbycustomer($row['cid']);
        }else if($result->num_rows == 0) {
        echo "receiver search >> not found|";
        }else{
            ?>
     <style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
			<script>
    $(".row_r").bind( "mouseenter mouseleave", function() {
		$( this ).toggleClass( "entered" );
	});
	$(".row_r").click(function(){
		var rowid=$(this).attr('id');
		$( this ).toggleClass( "selected" );
    	var selectedrow=$(this).attr("class");
    	//row is selected - highlite
    	if (selectedrow=="row_r entered selected"){
    		var id =$(this).attr('id');
    		//alert(type+id+ajaxtype);
    		$.ajax({
        		type : "POST",
        		url : "libraries/local.php",
        		data : {
        			type : 'loadreceiverfrm',id:id
        		},
        		cache : false,
        		success : function(result) {
        			$("#customerinfo").html(result);
        		}
        	});
    	}
	});
	</script>
    <?php 
            //echo "customer search >> found multiple records|";
            echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row_r\" id=" . $row["rid"] . "  type=\"customer\">
                        <td class=\"sr\" nowrap=\"nowrap\" style=\"text-transform:uppercase\">
                            " . $row["rfirst_name"] . ",
                            " . $row["rlast_name"] . "</td>
                        <td class=\"sr\" nowrap=\"nowrap\">" . $row["rphone1"] . "</td>
                        <td class=\"sr\" >" .printtptinh($row["rtp_tinh"]) . "</td>
                  
                    </tr>";
            }
            echo "</table>";
        }
    }
    $conn->close();
}
function searchcustomerbyreceiver($id)
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "select customer.*, customer_receiver.*,receiver.* from customer
    inner join customer_receiver on customer.cid=customer_receiver.customer_id
    inner join receiver on customer_receiver.receiver_id=receiver.rid
    where receiver.rid='{$id}' order by customer.clast_name, customer.cfirst_name ASC";
    $out="";
    $result = $conn->query($sql);
    if($result->num_rows == 1 ){
        $row = $result->fetch_assoc();
        jsloadcustomerfrm($row);
    }
    else if ($result->num_rows > 1) {
            ?>
     <style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
			<script>
    $(".row_c").bind( "mouseenter mouseleave", function() {
		$( this ).toggleClass( "entered" );
	});
	$(".row_c").click(function(){
		var rowid=$(this).attr('id');
		$( this ).toggleClass( "selected" );
    	var selectedrow=$(this).attr("class");
    	//row is selected - highlite
    	if (selectedrow=="row_c entered selected"){
    		var id =$(this).attr('id');
    		$.ajax({
        		type : "POST",
        		url : "libraries/local.php",
        		data : {
        			type : 'loadcustomerfrm_onetime',id:id
        		},
        		cache : false,
        		success : function(result) {
        			$("#infobar").html(result);
        		}
        	});
    	}
	});
	//receiver frm
	$("#customerid").val('');
	$("#cfname").val('');
	$("#clname").val('');
	$("#caddress").val('');
	$("#ccity").val('');
	$("#cphone").val('');
	$("#czip").val('');
	$("#cemail").val('');
	$("#cprovince").prop("selectedIndex",0);
	</script>
    <?php 
        $out = "<table width=\"100%\"  cellspacing=\"1\" cellpadding=\"3\">";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $out .= "<tr class=\"row_c\" id=" . $row["cid"] . " type=\"customer\" >
                            <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\"  nowrap=\"nowrap\" >
                                    " . $row["cfirst_name"] . ",
                                    " . $row["clast_name"] . "
                            </td>
                            <td class=\"sr\" valign=\"top\"nowrap=\"nowrap\">
                                    " . $row["cphone"] . "</td>
                        </tr>";
        }
        $out .= "</table>";
    } else {
        //$out = "no customers found</br>";
        ?>
        <script>
        $("#customerid").val('');
		$("#cfname").val('');
		$("#clname").val('');
		$("#caddress").val('');
		$("#ccity").val('');
		$("#cphone").val('');
		$("#czip").val('');
		$("#cemail").val('');
		$("#cprovince").prop("selectedIndex",0);
        </script>
        <?php 
    }
    echo $out;
    $conn->close();
}
/////////////////////////////
//  
/////////////////////////////
function generateconumber($cid,$rid,$aid){
    $conumber = '';
    //while(strlen($cid) < 2) $cid .= 'C';
    //while(strlen($rid) < 2) $rid .= 'R';
    //while(strlen($aid) < 2) $aid .= 'A';
    $conumber= $aid.$cid.$rid.'-'.time();
    return $conumber;
}
function transactionsubmit($customerid,$receiverid,$agentid){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $caseno=0;
    
    if($customerid=='' && $receiverid ==''){
        $caseno=1;
        $customerid=newcustomer($agentid);
        $receiverid=newreceiver($customerid);
        ?><script>
                $("#customerid").val('<?php echo $customerid;?>');
                $("#receiverid").val('<?php echo $receiverid;?>');
                </script><?php 
    } else if ($customerid != '' && $receiverid == '') {
        $caseno=2;
        $receiverid=newreceiver($customerid);
        ?><script>$("#receiverid").val('<?php echo $receiverid;?>');</script><?php
    } else if ($customerid == '' && $receiverid != '') {
        $caseno=3;
        $customerid=newcustomer($agentid);
        ?><script>$("#customerid").val('<?php echo $customerid;?>');</script><?php
    } else { // both old 
        $caseno=4;    
        if($agentid!=22){
        //verify with in 48 hrs
        //find previous transaction time
        $sql= "select confirmation_no, total_amount from transaction 
                where customer_id='{$customerid}' and receiver_id='{$receiverid}' order by modify_date";
                    $result = $conn->query($sql);
                    $temptotalamount = 0;
                    $tempstr = "";
                    while ($row = $result->fetch_assoc()) {
                        $var = $row['confirmation_no'];
                        $previoustime = (int) substr($var, - 10, 10); // $t2=substr($str,-10,10);
                        $nowtime = time();
                        $difftime = $nowtime - $previoustime;
                        if ($difftime <= 172800) { // 48 hrs
                            $temptotalamount += $row['total_amount'];
                            $tempstr .= "<div>Transaction #" . $var . " @" . date("M-d-Y H:i:s", $previoustime) . " amount of $" . $row['total_amount'] . "</div>";
                        }
                    }
                    if ($temptotalamount + $_POST['totalamount'] >= 1000) {
                        // echo("invalid".$var." ".$preioustime." ".$nowtime." ".$difftime);
                        echo "<div style=\"text-align:left;\"><div>Invalid Transaction - In our record</div>";
                        echo $tempstr;
                        echo "<div>was submit in less than 48hrs with same sender and receiver.</div> ";
                        echo "<div>please read the agreement before procee.</div></div>";
                        exit();
                    }
                }
            }
    
    if ($customerid == 0 || $receiverid == 0) {
        echo "ERROR, plesse reenter data";
        $conn->close();
        exit;
        //break;
    }
    // confirmation no.
    $cnumber = generateconumber($customerid,$receiverid,$agentid);
    $sql = "INSERT INTO transaction (agent_id,customer_id,receiver_id,local_currency_type,foreign_currency_type,
    local_amount,foreign_amount,fee_charge,
    total_amount,delivery_method,confirmation_no,transaction_note)
    VALUES ('$agentid','$customerid','$receiverid','{$_POST['selectlocaltype']}','{$_POST['selectdeliverytype']}',
    '{$_POST['localamount']}','{$_POST['deliveryamount']}','{$_POST['fee']}',
    '{$_POST['totalamount']}','{$_POST['deliverymethod']}','{$cnumber}','{$_POST['tnote']}');";
    $sql .= "INSERT INTO customer_receiver(customer_id,receiver_id)
    SELECT '$customerid','$receiverid' FROM DUAL WHERE NOT EXISTS
    (SELECT * FROM customer_receiver WHERE customer_id='{$customerid}' AND receiver_id='{$receiverid}')";
            
    if ($conn->multi_query($sql) === TRUE) {
        //echo "transaction completed, Co. No. ".$cnumber;
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
    }
    $conn->close();
    printreceipt($cnumber,$customerid,$receiverid,$_POST['localamount'],$_POST['totalamount'],$_POST['fee'],$_POST['deliverymethod']);
}
function printonly_transaction(){
    // print receipt        ?>
                            <div id="printdiv">
				<style>
.h_ {
	padding: 0px 4px 0px 5px;
	background-color: #CCCCCC;
	border-bottom: solid 1px #666666;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}

._R_ {
	text-align: right;
	padding: 2px 3px 2px 2px;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	border-bottom: solid 1px #666;
}

._L_ {
	text-align: left;
	padding: 2px 8px 2px 2px;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	border-bottom: solid 1px #666;
}

.n {
	text-align: left;
	padding: 1px;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}

.b {
	padding: 1px;
	font: bold 11px Verdana, Arial, Helvetica, sans-serif;
}
._nx {font: normal 10px Verdana, Arial, Helvetica, sans-serif;}

.bb {
	padding: 2px 8px 2px 2px;
	font: bold 13px Verdana, Arial, Helvetica, sans-serif;
}
.textBold {
	padding: 6px 6px 2px 2px;
	font: bold 16px Verdana, Arial, Helvetica, sans-serif;
}
._grey_ {color:#ccc;}
.space12x {padding: 10px;}
._x_ {border-bottom: dashed 1px;}
	

</style>
<table width="760px" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td width="190px" align="right"><img src="libraries/logo.png"></td>
						<td width="190px" valign="baseline" align="left" nowrap="nowrap">
							<div class="b">&nbsp;</div>
							<div class="b"><?php echo $_POST['id']; ?></div>
							<div class="b"><?php $temp=substr($_POST['trans_conumber'],-10,10); echo date('M-d-Y / H:i:s',intval($temp));?></div>
							<div class="b"><?php echo $_POST['trans_conumber'];?></div>
						</td>
						<td width="190px">&nbsp;</td>
						<td width="190px" valign="top" align="left">
							<div class="b">Tyger Chuy&#7875;n Ti&#7873;n</div>
							<div class="_nx">6599 Parc Avenue</div>
							<div class="_nx">Montreal, QC. H2V 4J1.</div>
							<div class="_nx">514 658 6678</div>
						</td>
					</tr>
					<tr><td colspan="4" align="center"><div class="textBold">Receipt - Bi&#234;n Lai</div></td></tr>
					<tr>
						<td width="50%" colspan="2" valign="top" align="left">
							<div class="h_">Customer - Ng&#432;&#7901;i G&#7919;i</div>
							<div class="n"><?php echo ($_POST['cfname'] . ", " . $_POST['clname'] . "</br>" . $_POST['cphone'] . "</br>
                                    " . $_POST['caddress'] . "</br> " . $_POST['ccity'] . " " . strtoupper($_POST['cprovince'])). "</br> " . $_POST['czip'] ?></div>
						</td>
						<td colspan="2" valign="top" align="left">
							<div class="h_">Beneficiary - Ng&#432;&#7901;i Nh&#7853;n</div>
							<div class="n"><?php echo ($_POST['rfname'] . ", " . $_POST['rlname'] . "</br>" . $_POST['rphone'] . "</br>
                                    " . $_POST['rdiachi'] . "</br>" . printtptinh($_POST['rtptinh']))."</br>".$_POST['remail']?><div>
						
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="top">
							<div class="b">Method Payment:</div>
							<div class="b">Send Amount:</div>
							<div class="b">Fee:</div>
						</td>
						<td valign="top" align="left"><div class="b">&nbsp;<?php echo printdeliverymethod($_POST['deliverymethod'])?>
    					<div class="b">&nbsp;<?php echo _f($_POST['localamount']);?></div>
								<div class="b">&nbsp;<?php echo _f($_POST['fee']);?></div></td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="top"><div class="bb">TOTAL:</div></td>
						<td align="left"><div class="bb">&nbsp;<?php echo _f($_POST['totalamount']);?></div></td>
					</tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					<tr>
						<td colspan="2" align="Center" valign="bottom"><span class="_grey_">__________________________</span><br/>Client's Sign / Initial</td>
						<td colspan="2" align="Center" valign="bottom"><span class="_grey_">__________________________</span><br/>Agent's Sign / Initial</td>
					</tr>
		
					<tr><td colspan="4"><div class="_x_">&nbsp;</div></td></tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					<tr>
						<td width="190px" align="right"><img src="libraries/logo.png"></td>
						<td width="190px" valign="baseline" align="left" nowrap="nowrap">
							<div class="b">&nbsp;</div>
							<div class="b"><?php echo $_POST['id'];?></div>
							<div class="b"><?php $temp=substr($_POST['trans_conumber'],-10,10); echo date('M-d-Y / H:i:s',intval($temp));?></div>
							<div class="b"><?php echo $_POST['trans_conumber'];?></div>
						</td>
						<td width="190px">&nbsp;</td>
						<td width="190px" valign="top" align="left">
							<div class="b">Tyger Chuy&#7875;n Ti&#7873;n</div>
							<div class="_nx">6599 Parc Avenue</div>
							<div class="_nx">Montreal, QC. H2V 4J1.</div>
							<div class="_nx">514 658 6678</div>
						</td>
					</tr>
					<tr><td colspan="4" align="center"><div class="textBold">Client's Receipt - Bi&#234;n Lai</div></td></tr>
					<tr>
						<td width="50%" colspan="2" valign="top" align="left">
							<div class="h_">Customer - Ng&#432;&#7901;i G&#7919;i</div>
							<div class="n"><?php echo ($_POST['cfname'] . ", " . $_POST['clname'] . "</br>" . $_POST['cphone'] . "</br>
                                    " . $_POST['caddress'] . "</br> " . $_POST['ccity'] . " " . strtoupper($_POST['cprovince'])). "</br> " . $_POST['czip'] ?></div>
						</td>
						<td colspan="2" valign="top" align="left">
							<div class="h_">Beneficiary - Ng&#432;&#7901;i Nh&#7853;n</div>
							<div class="n"><?php echo ($_POST['rfname'] . ", " . $_POST['rlname'] . "</br>" . $_POST['rphone'] . "</br>
                                    " . $_POST['rdiachi'] . "</br>" . printtptinh($_POST['rtptinh']))."</br>".$_POST['remail']?><div>
						
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="top"><div>&nbsp;</div>
							<div class="b">Method Payment:</div>
							<div class="b">Send Amount:</div>
							<div class="b">Fee:</div>
						</td>
						<td valign="top" align="left"><div class="b">&nbsp;<?php echo printdeliverymethod($_POST['deliverymethod'])?>
    					<div class="b">&nbsp;<?php echo _f($_POST['localamount']);?></div>
								<div class="b">&nbsp;<?php echo _f($_POST['fee']);?></div></td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="top"><div class="bb">TOTAL:</div></td>
						<td align="left"><div class="bb">&nbsp;<?php echo _f($_POST['totalamount']);?></div></td>
					</tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					
					<tr><td colspan="4" align="center"><div class="textBold">Thank you - C&#7843;m &#417;n<br/>Qu&#237; Kh&#225;ch</div></td></tr>
				</table>
			</div>
        <?php
}

function printreceipt($cnumber, $customerid, $receiverid, $localamount, $totalamount, $fee, $deliverymethod)
{
    // generate receipt
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "select * from customer join receiver where cid='{$customerid}' and rid='{$receiverid}'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // print receipt        ?>
                        <div id="printdiv">
				<style>
.h_ {
	padding: 0px 4px 0px 5px;
	background-color: #CCCCCC;
	border-bottom: solid 1px #666666;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}

._R_ {
	text-align: right;
	padding: 2px 3px 2px 2px;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	border-bottom: solid 1px #666;
}

._L_ {
	text-align: left;
	padding: 2px 8px 2px 2px;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	border-bottom: solid 1px #666;
}

.n {
	text-align: left;
	padding: 1px;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}

.b {
	padding: 1px;
	font: bold 11px Verdana, Arial, Helvetica, sans-serif;
}
._nx {font: normal 10px Verdana, Arial, Helvetica, sans-serif;}

.bb {
	padding: 2px 8px 2px 2px;
	font: bold 13px Verdana, Arial, Helvetica, sans-serif;
}
.textBold {
	padding: 6px 6px 2px 2px;
	font: bold 16px Verdana, Arial, Helvetica, sans-serif;
}
._grey_ {color:#ccc;}
.space12x {padding: 10px;}
._x_ {border-bottom: dashed 1px;}
	

</style>
<table width="760px" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td width="190px" align="right"><img src="libraries/logo.png"></td>
						<td width="190px" valign="baseline" align="left" nowrap="nowrap">
							<div class="b">&nbsp;</div>
							<div class="b"><?php echo $_POST['id'];?></div>
							<div class="b"><?php $temp=substr($_POST['trans_conumber'],-10,10); echo date('M-d-Y / H:i:s',intval($temp));?></div>
							<div class="b"><?php echo $_POST['trans_conumber'];?></div>
						</td>
						<td width="190px">&nbsp;</td>
						<td width="190px" valign="top" align="left">
							<div class="b">Tyger Chuy&#7875;n Ti&#7873;n</div>
							<div class="_nx">6599 Parc Avenue</div>
							<div class="_nx">Montreal, QC. H2V 4J1.</div>
							<div class="_nx">514 658 6678</div>
						</td>
					</tr>
					<tr><td colspan="4" align="center"><div class="textBold">Receipt - Bi&#234;n Lai</div></td></tr>
					<tr>
						<td width="50%" colspan="2" valign="top" align="left">
							<div class="h_">Customer - Ng&#432;&#7901;i G&#7919;i</div>
							<div class="n"><?php echo ($_POST['cfname'] . ", " . $_POST['clname'] . "</br>" . $_POST['cphone'] . "</br>
                                    " . $_POST['caddress'] . "</br> " . $_POST['ccity'] . " " . strtoupper($_POST['cprovince'])). "</br> " . $_POST['czip'] ?></div>
						</td>
						<td colspan="2" valign="top" align="left">
							<div class="h_">Beneficiary - Ng&#432;&#7901;i Nh&#7853;n</div>
							<div class="n"><?php echo ($_POST['rfname'] . ", " . $_POST['rlname'] . "</br>" . $_POST['rphone'] . "</br>
                                    " . $_POST['rdiachi'] . "</br>" . printtptinh($_POST['rtptinh']))."</br>".$_POST['remail']?><div>
						
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="top">
							<div class="b">Method Payment:</div>
							<div class="b">Send Amount:</div>
							<div class="b">Fee:</div>
						</td>
						<td valign="top" align="left"><div class="b">&nbsp;<?php echo printdeliverymethod($_POST['deliverymethod'])?>
    					<div class="b">&nbsp;<?php echo _f($_POST['localamount']);?></div>
								<div class="b">&nbsp;<?php echo _f($_POST['fee']);?></div></td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="top"><div class="bb">TOTAL:</div></td>
						<td align="left"><div class="bb">&nbsp;<?php echo _f($_POST['totalamount']);?></div></td>
					</tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					<tr>
						<td colspan="2" align="Center" valign="bottom"><span class="_grey_">__________________________</span><br/>Client's Sign / Initial</td>
						<td colspan="2" align="Center" valign="bottom"><span class="_grey_">__________________________</span><br/>Agent's Sign / Initial</td>
					</tr>
		
					<tr><td colspan="4"><div class="_x_">&nbsp;</div></td></tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					<tr>
						<td width="190px" align="right"><img src="libraries/logo.png"></td>
						<td width="190px" valign="baseline" align="left" nowrap="nowrap">
							<div class="b">&nbsp;</div>
							<div class="b"><?php echo $_POST['id'];?></div>
							<div class="b"><?php $temp=substr($_POST['trans_conumber'],-10,10); echo date('M-d-Y / H:i:s',intval($temp));?></div>
							<div class="b"><?php echo $_POST['trans_conumber'];?></div>
						</td>
						<td width="190px">&nbsp;</td>
						<td width="190px" valign="top" align="left">
							<div class="b">Tyger Chuy&#7875;n Ti&#7873;n</div>
							<div class="_nx">6599 Parc Avenue</div>
							<div class="_nx">Montreal, QC. H2V 4J1.</div>
							<div class="_nx">514 658 6678</div>
						</td>
					</tr>
					<tr><td colspan="4" align="center"><div class="textBold">Client's Receipt - Bi&#234;n Lai</div></td></tr>
					<tr>
						<td width="50%" colspan="2" valign="top" align="left">
							<div class="h_">Customer - Ng&#432;&#7901;i G&#7919;i</div>
							<div class="n"><?php echo ($_POST['cfname'] . ", " . $_POST['clname'] . "</br>" . $_POST['cphone'] . "</br>
                                    " . $_POST['caddress'] . "</br> " . $_POST['ccity'] . " " . strtoupper($_POST['cprovince'])). "</br> " . $_POST['czip'] ?></div>
						</td>
						<td colspan="2" valign="top" align="left">
							<div class="h_">Beneficiary - Ng&#432;&#7901;i Nh&#7853;n</div>
							<div class="n"><?php echo ($_POST['rfname'] . ", " . $_POST['rlname'] . "</br>" . $_POST['rphone'] . "</br>
                                    " . $_POST['rdiachi'] . "</br>" . printtptinh($_POST['rtptinh']))."</br>".$_POST['remail']?><div>
						
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="top"><div>&nbsp;</div>
							<div class="b">Method Payment:</div>
							<div class="b">Send Amount:</div>
							<div class="b">Fee:</div>
						</td>
						<td valign="top" align="left"><div class="b">&nbsp;<?php echo printdeliverymethod($_POST['deliverymethod'])?>
    					<div class="b">&nbsp;<?php echo _f($_POST['localamount']);?></div>
								<div class="b">&nbsp;<?php echo _f($_POST['fee']);?></div></td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="top"><div class="bb">TOTAL:</div></td>
						<td align="left"><div class="bb">&nbsp;<?php echo _f($_POST['totalamount']);?></div></td>
					</tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					<tr><td colspan="4"><div class="space12x">&nbsp;</div></td></tr>
					
					<tr><td colspan="4" align="center"><div class="textBold">Thank you - C&#7843;m &#417;n<br/>Qu&#237; Kh&#225;ch</div></td></tr>
				</table>
			</div>
    <?php
    }
    
    $conn->close();
}
function transactionsearchbyfromtodate(){
    $fromdate = $_POST['fromdate'];
    $todate=$_POST['todate'];
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
    where transaction.agent_id='{$_POST['aid']}' AND transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    printjscript();
    ?>
        <style>
._R {
	text-align: right;
	padding: 2px 3px 2px 2px;
	border-bottom: solid 1px #ccc;
}

._L {
	text-align: left;
	padding: 2px 5px 2px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
			<table width="100%" border="0" cellspacing="1" cellpadding="3">
				<tr>
					<td class="h">#</td>
					<td class="h">T#</td>
					<td class="h" width="180px">Customer</td>
					<td class="h" width="240px">Beneficiary</td>
					<td class="h">Amount</td>
					<td class="h">Date</td>
					<td class="h">Status</td>
				</tr>
            <?php
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                            <td class=\"_L\" nowrap=\"nowrap\">" . $row["id"] . "</td>
                            <td class=\"_L\" nowrap=\"nowrap\">" . _pco($row["confirmation_no"]) . "</td>
                            <td class=\"_L\" style=\"text-transform:uppercase\">" . $row["cfirst_name"] . "," . $row["clast_name"] . " </td>
                            <td class=\"_L\" style=\"text-transform:uppercase\">" . $row["rfirst_name"] . "," . $row["rlast_name"] . "</td>
                            <td class=\"_R\" style=\"color:#990000;font-weight:bold;\"> " . _f($row["local_amount"]) . "</td>
                            <td class=\"_R\" nowrap=\"nowrap\">" . substr($row["created_date"],0,10) . "</td>
                            <td class=\"_R\" style=\"font-weight:bold;\"style=\"color:#990000;font-weight:bold;\">" . _status($row["transaction_status"]) . "</td></tr>";
                }
                
                echo "</table>";
            } else {
                echo "0 results";
            }
            $conn->close();
    
}
function newcustomer($agent_id)
{
    // $agent_id = $_POST['aid'];
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $customer_id = 0;
    $address = str_replace("'", "''", $_POST['caddress']);
    $lname = str_replace("'", "''", $_POST['clname']);
    $fname = str_replace("'", "''", $_POST['cfname']);
    $sql = "INSERT INTO customer (cfirst_name,clast_name,cphone,caddress,ccity,cprovince,czip,cemail)
    select  '{$fname}','{$lname}','{$_POST['cphone']}','{$address}',
    '{$_POST['ccity']}','{$_POST['cprovince']}','{$_POST['czip']}','{$_POST['cemail']}'
        from dual where not exists (select * from customer where cphone='{$_POST['cphone']}')";
    
    if ($conn->query($sql) === TRUE) {
        // echo "New customer created successfully</br>";
        $customer_id = $conn->insert_id;
        if ($customer_id == 0) { // record already exist
            $tsql = "select cid from customer where cphone='{$_POST['cphone']}'";
            $result = $conn->query($tsql);
            $row = $result->fetch_assoc();
            $customer_id = $row['cid'];
        } else 
            if ($customer_id != 0) {
                $sql = "INSERT INTO agent_customer (agent_id,customer_id)
                VALUES ('$agent_id','$customer_id')";
                if ($conn->query($sql) === TRUE) {
                    // echo "New join table created successfully</br>|" . $customer_id . "|" . $_POST['cphone'];
                } else {
                    echo "Error: " . $sql . "</br>" . $conn->error;
                }
            }
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
    }
    $conn->close();
    return $customer_id;
}
function newreceiver($customerid)
{
        // $customerid = $_POST['customerid'];
        // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO receiver (rfirst_name,rlast_name,rdiachi,rtp_tinh,rphone1,remail)
    select '{$_POST['rfname']}','{$_POST['rlname']}','{$_POST['rdiachi']}','{$_POST['rtptinh']}',
    '{$_POST['rphone']}','{$_POST['remail']}' from dual where not exists
    (select * from receiver where rphone1='{$_POST['rphone']}')";
    
    $receiverid=0;
    if ($conn->query($sql) === TRUE) {
        // echo "New receiver created successfully</br>";
        $receiverid = $conn->insert_id;
        if ($receiverid == 0) { // record already exist
            $tsql = "select rid from receiver where rphone1='{$_POST['rphone']}'";
            $result = $conn->query($tsql);
            $row = $result->fetch_assoc();
            $receiverid = $row['rid'];
        } else 
            if ($receiverid != 0) {
                $sql = "INSERT INTO customer_receiver (customer_id,receiver_id) VALUES ('$customerid','$receiverid')";
                if ($conn->query($sql) === TRUE) {
                    // echo "New join table created successfully</br>|" . $receiverid . "|";
                } else {
                    echo "Error: " . $sql . "</br>" . $conn->error;
                }
            }
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
    }
    
    $conn->close();
    return $receiverid;
}

// ////////////////////////////////////////
// HELPER FUNCTION
// ////////////////////////////////////////
function checkinput($par)
{
    $par = _c($par);
    if ($par != '')
        return true;
    else
        return false;
}

function printjscript()
{
    ?>
     <style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
				<script>
    $(".row").bind( "mouseenter mouseleave", function() {
		$( this ).toggleClass( "entered" );
	});
	$(".row").click(function(){
		var rowid=$(this).attr('id');
		$( this ).toggleClass( "selected" );
    	var selectedrow=$(this).attr("class");
    	//row is selected - highlite
    	if (selectedrow=="row entered selected"){
    		var id =$(this).attr('id');
    		var type=$(this).attr('type');
    		var ajaxtype='';
    		switch(type){
    		case 'customer':
        		ajaxtype='loadcustomerfrm';
        		//clearreceiverfrm();
        		break;
    		case 'receiver':
    			//$("#receiverinfo").html('');
    			ajaxtype='loadreceiverfrm';
        		break;
    		case 'transaction':
        		ajaxtype='loadallfrmbytransactionfrm';
        		break;
    		}
    		//alert(type+id+ajaxtype);
    		$.ajax({
        		type : "POST",
        		url : "libraries/local.php",
        		data : {
        			type : ajaxtype,id:id
        		},
        		cache : false,
        		success : function(result) {
            		//alert(result);
        			switch(type){
            		case 'customer':
            			$("#receiverinfo").html(result);
                		break;
            		case 'receiver':
            			$("#customerinfo").html(result);
                		break;
            		case 'transaction':
            			$("#infobar").html(result);
            			$("#receiverinfo").html('');
            			$("#customerinfo").html('');
                		break;
            		}
        		}
        	});
    	}
	});
	</script>
    <?php 
}
function printdeliverymethod($input){
    switch ($input){
        case "0":return "Home / t&#7841;i nh&#224;"; break;
        case "1":return "Pickup / T&#7841;i Qu&#7847;y";break;
        case "2":return "Transfer / Chuy&#7875;n Kho&#7843;n";break;
    }
}
function printtptinh($tp){
    switch($tp){
        case "0": return 'Ch&#7885;n t&#7881;nh/th&#224;nh'; break;
        case "1": return 'TP. H&#7891; Ch&#237; Minh';break;
        case "2": return 'TP. H&#224; N&#7897;i'; break;
        case "3": return 'TP. &#272;&#224; N&#7859;ng'; break;
        case "4": return 'TP. Hu&#7871;'; break;
        case "5": return 'TP. H&#7843;i Ph&#242;ng'; break;
        case "6": return 'TP. Bi&#234;n Ho&#224;'; break;
        case "7": return 'TP. Nha Trang'; break;
        case "8": return 'TP. C&#7847;n Th&#417;'; break;
        case "9": return 'TP. C&#224; Mau'; break;
        case "10": return 'TP. H&#7841; Long'; break;
        case "11": return 'TP. Long Xuy&#234;n'; break;
        case "12": return 'TP. Nam &#272;&#7883;nh'; break;
        case "13": return 'TP. Quy Nh&#417;n'; break;
        case "14": return 'TP. R&#7841;ch Gi&#225;'; break;
        case "15": return 'TP. Phan Thi&#7871;t'; break;
        case "16": return 'TP. Th&#225;i Nguy&#234;n'; break;
        case "17": return 'TP. Vinh'; break;
        case "18": return 'TP. V&#361;ng T&#224;u'; break;
        case "19": return 'An Giang'; break;
        case "20": return 'B&#224; R&#7883;a - V&#361;ng T&#224;u'; break;
        case "21": return 'B&#7855;c Giang'; break;
        case "22": return 'B&#7855;c K&#7841;n'; break;
        case "23": return 'B&#7841;c Li&#234;u'; break;
        case "24": return 'B&#7855;c Ninh'; break;
        case "25": return 'B&#7871;n Tre'; break;
        case "26": return 'B&#236;nh &#272;&#7883;nh'; break;
        case "27": return 'B&#236;nh D&#432;&#417;ng'; break;
        case "28": return 'B&#236;nh Ph&#432;&#7899;c'; break;
        case "29": return 'B&#236;nh Thu&#7853;n'; break;
        case "30": return 'Bu&#244;n Ma Thu&#7897;t'; break;
        case "31": return 'Cao B&#7857;ng'; break;
        case "32": return '&#272;&#7855;c L&#7855;k'; break;
        case "33": return '&#272;&#7855;c N&#244;ng'; break;
        case "34": return '&#272;i&#7879;n Bi&#234;n'; break;
        case "35": return '&#272;&#7891;ng Nai'; break;
        case "36": return '&#272;&#7891;ng Th&#225;p'; break;
        case "37": return 'Gia Lai'; break;
        case "38": return 'H&#224; Giang'; break;
        case "39": return 'H&#224; Nam'; break;
        case "40": return 'H&#224; T&#297;nh'; break;
        case "41": return 'H&#7843;i D&#432;&#417;ng'; break;
        case "42": return 'H&#7853;u Giang'; break;
        case "43": return 'Ho&#224; B&#236;nh'; break;
        case "44": return 'H&#432;ng Y&#234;n'; break;
        case "45": return 'Kh&#225;nh Ho&#224;'; break;
        case "46": return 'Ki&#234;n Giang'; break;
        case "47": return 'Kon Tum'; break;
        case "48": return 'Lai Ch&#226;u'; break;
        case "49": return 'L&#226;m &#272;&#7891;ng'; break;
        case "50": return 'L&#7841;ng S&#417;n'; break;
        case "51": return 'L&#224;o Cai'; break;
        case "52": return 'Long An'; break;
        case "53": return 'Ngh&#7879; An'; break;
        case "54": return 'Ninh B&#236;nh'; break;
        case "55": return 'Ninh Thu&#7853;n'; break;
        case "56": return 'Ph&#250; Th&#7885;'; break;
        case "57": return 'Ph&#250; Y&#234;n'; break;
        case "58": return 'Qu&#7843;ng B&#236;nh'; break;
        case "59": return 'Qu&#7843;ng Nam'; break;
        case "60": return 'Qu&#7843;ng Ng&#227;i'; break;
        case "61": return 'Qu&#7843;ng Ninh'; break;
        case "62": return 'Qu&#7843;ng Tr&#7883;'; break;
        case "63": return 'S&#243;c Tr&#259;ng'; break;
        case "64": return 'S&#417;n La'; break;
        case "65": return 'T&#226;y Ninh'; break;
        case "66": return 'Th&#225;i B&#236;nh'; break;
        case "67": return 'Thanh Ho&#225;'; break;
        case "68": return 'Th&#7911; D&#7847;u M&#7897;t'; break;
        case "69": return 'Th&#7915;a Thi&#234;n Hu&#7871;'; break;
        case "70": return 'Ti&#7873;n Giang'; break;
        case "71": return 'Tr&#224; Vinh'; break;
        case "72": return 'Tuy&#234;n Quang'; break;
        case "73": return 'V&#297;nh Long'; break;
        case "74": return 'V&#297;nh Ph&#432;&#7899;c'; break;
        case "75": return 'Y&#234;n B&#225;i'; break;
    }

}
function _status($s)
{
    switch ($s) {
        case '1':
            return 'new';
            break;
        case '2':
            return 'aprroved';
            break;
        case '3':
            return 'process';
            break;
        case '4':
            return 'received';
            break;
        case '5':
            return 'completed';
            break;
        case '6':
            return 'cancel';
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
function _scheck($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = str_replace(".",",",$data);
    $data = str_replace("'","''",$data);
    return $data;
}

function _f($number)
{
    $number = (float)$number;
    setlocale(LC_MONETARY, 'en_US');
    //$temp = money_format('%(#10n', $number);
    $temp = number_format($number, 2, '.', '');
    return '$'.$temp;
}
function _pco($str){
    //$temp = explode("-",$str);
    //$s/tr= $temp[0]."\n".$temp[1];
    $t2=substr($str,-10,10);
    $t1=substr($str,0,strlen($str)-11);
    $str = $t1."\n".$t2;
    return $str;
}
?>