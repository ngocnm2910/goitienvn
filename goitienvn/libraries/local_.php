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
    case 'report':
        report();
        break;
    case 'loadcustomerfrm':
        $sql="select * from customer where cid='{$_POST['id']}'";
        loadcustomerfrm($sql);
        searchreceiverbycustomer($_POST['id']);
        break;
    case 'loadreceiverfrm':
        $sql="select * from receiver where rid='{$_POST['id']}'";
        loadreceiverfrm($sql);
        break;
    case 'loadtransactionfrm':
        $sql="select transaction.*, agent.*, customer.*, receiver.* FROM transaction
        inner join agent on transaction.agent_id=agent.aid
        inner join customer on transaction.customer_id=customer.cid
        inner join receiver on transaction.receiver_id=receiver.rid
        where transaction.id='{$_POST['id']}'";
        loadtransaction($sql);
        break;
        
    case 'newcustomer':
        newcustomer();
        break;
    case 'newreceiver':
        newreceiver();
        break;
    case 'reportlistall':
        reportlistall();
        break;
    case 'customerphonesearch':
        $sql="select * from customer where cstatus=1 AND cphone='{$_POST['phone_no']}'";
        $cid=loadcustomerfrm($sql);
        searchreceiverbycustomer($cid);
        break;
    case 'searchreceiverbycustomer':
        searchreceiverbycustomer($_POST['id']);
        break;
    case 'searchreceiverbyphone':
        searchreceiverbyphone();
        break;
    case '':
        break;
    case '':
        break;
    case '':
        break;
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
        ?>
<style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style><?php
        echo "<div>CUSTOMER</div>";
        echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
        echo "<tr><td class=\"h\" width=\"140\" >name</td><td class=\"h\">phone</td><td class=\"h\">address</td>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr class=\"row\" id=" . $row["cid"] . "  type=\"customer\">
                        <td class=\"sr\" nowrap=\"nowrap\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">
                            " . $row["cfirst_name"] . ",
                            " . $row["clast_name"] . "</td>
                        <td class=\"sr\">" . $row["cphone"] . "</td>
                        <td class=\"sr\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["caddress"] . ", " . $row["czip"] . ", " . $row["cprovince"] . "</td>
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
        ?>
<style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style><?php
        echo "<div>RECEIVER</div>";
        echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
        echo "<tr><td class=\"h\">name</td><td class=\"h\">phone</td>
            <td class=\"h\">Sender Name</td><td class=\"h\">Sender Phone</td>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr class=\"row\" id=" . $row["rid"] . " type=\"receiver\" >
                        <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\"  nowrap=\"nowrap\" >
                                " . $row["rfirst_name"] . ",
                                " . $row["rlast_name"] . "
                        </td>
                        <td class=\"sr\" valign=\"top\" width=\"80\">
                                " . $row["rphone1"] . "</td>
                        <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\" nowrap=\"nowrap\">
                                " . $row["cfirst_name"] . ",
                                " . $row["clast_name"] . "
                        </td>
                        <td class=\"sr\" valign=\"top\" nowrap=\"nowrap\" >
                                " . $row["cphone"] . "</td>
                    </tr>";
        }
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
    where transaction.agent_id='{$_POST['aid']}' order by customer.clast_name ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        printjscript();
    // ----------------------------------------        ?>
<style>
._R {
	text-align: right;
	padding: 1px 3px 1px 2px;
	border-bottom: solid 1px #ccc;
}

._L {
	text-align: left;
	padding: 1px 8px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
	<tr>
		<td class="h">customer</td>
		<td class="h">receiver</td>
		<td class="h">amount</td>
		<td class="h">time</td>
		<td class="h">status</td>
	</tr>
        <?php
            // ------------------------------------------------------
            
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                        <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["cfirst_name"] . "," . $row["clast_name"] . " </td>
                        <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["rfirst_name"] . "," . $row["rlast_name"] . "</td>
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
function newcustomer(){
    $agent_id = $_POST['aid'];
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // $ucasezip= strtoupper($_POST['czip']);
    $sql = "INSERT INTO customer (cfirst_name,clast_name,cphone,
    caddress,ccity,cprovince,czip,cemail)
    VALUES ('{$_POST['cfname']}','{$_POST['clname']}','{$_POST['cphone']}',
    '{$_POST['caddress']}','{$_POST['ccity']}','{$_POST['cprovince']}',
    '{$_POST['czip']}','{$_POST['cemail']}')";

        if ($conn->query($sql) === TRUE) {
        echo "New customer created successfully</br>";
        $customer_id = $conn->insert_id;
        $sql = "INSERT INTO agent_customer (agent_id,customer_id)
        VALUES ('$agent_id','$customer_id')";
        if ($conn->query($sql) === TRUE) {
        echo "New join table created successfully</br>|" . $customer_id."|".$_POST['cphone'];
        } else {
            echo "Error: " . $sql . "</br>" . $conn->error;
            }
            } else {
            echo "Error: " . $sql . "</br>" . $conn->error;
            }
            $conn->close();
            return $customer_id;
}
function newreceiver(){
    $customerid = $_POST['customerid'];
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO receiver (rfirst_name,rlast_name,rdiachi,rtp_tinh,rphone1,remail)
    VALUES ('{$_POST['rfname']}','{$_POST['rlname']}','{$_POST['rdiachi']}','{$_POST['rtptinh']}',
    '{$_POST['rphone']}','{$_POST['remail']}')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New receiver created successfully</br>";
        $receiverid = $conn->insert_id;
        $sql = "INSERT INTO customer_receiver (customer_id,receiver_id)
        VALUES ('$customerid','$receiverid')";
        if ($conn->query($sql) === TRUE) {
            echo "New join table created successfully</br>|" . $receiverid . "|";
        } else {
            echo "Error: " . $sql . "</br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
    }
    
    $conn->close();
    return $receiverid;
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
        $row = $result->fetch_assoc();
        jsloadcustomerfrm($row);
    }
    else{
        echo "customer search >> not found</br>";
    }
    return ($row['cid']);
    $conn->close();
}
function jsloadcustomerfrm($row){
    ?>
    <script>
    // fill in form var by jscript
    $(document).ready(function() {
        $("#customerid").val('<?php echo $row['cid'];?>');
    	$("#clname").val('<?php echo $row['clast_name'];?>');
        $("#cfname").val('<?php echo $row['cfirst_name'];?>');
        $("#caddress").val('<?php echo $row['caddress'];?>');
        $("#ccity").val('<?php echo $row['ccity'];?>');
        //$("#cprovince").val('Manitoba');
        //$("#cprovince option[value='Manitoba']").attr("selected",true);
        $("#cprovince").prop("selectedIndex",function(){
        	var cp='<?php echo $row['cprovince'];?>';
        	//alert(cp);
        	switch(cp){
    		case 'qc':
                return 0;break;
    		case 'on':
        		return 1;break;
    		case 'mb':
        		return 2;break;
    		case 'sk':
        		return 3;break;
    		case 'ab':
        		return 4;break;
    		case 'bc':
        		return 5;break;
    		case 'nf':
        		return 6;break;
    		case 'pe':
        		return 7;break;
    		case 'nb':
        		return 8;break;
    		case 'ns':
        		return 9;break;
    		case 'nt':
        		return 10;break;
        	}
        });
        $("#czip").val('<?php echo $row['czip'];?>');
        $("#cphone").val('<?php echo $row['cphone'];?>');
        $("#cemail").val('<?php echo $row['cemail'];?>');
        });
    </script>
     <?php
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
    if ($result->num_rows > 0) {
        printjscript();
        ?>
        <style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style><?php
        $out = "<div>RECEIVER</div><table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
        $out .= "<tr><td class=\"h\">receiver name</td><td class=\"h\">phone</td>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $out .= "<tr class=\"row\" id=" . $row["rid"] . " type=\"receiver\" >               
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
        $out = "no receivers found</br>";
    }
    echo $out;
    $conn->close();
}
function searchreceiverbyphone(){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql="SELECT customer.*, customer_receiver.*, receiver.* FROM customer
            INNER JOIN customer_receiver ON customer.cid=customer_receiver.customer_id
            INNER JOIN receiver ON customer_receiver.receiver_id=receiver.rid
            WHERE receiver.rstatus=1 AND receiver.rphone1='{$_POST['phone_no']}'";
    
    $result = $conn->query($sql);
    if ($result->num_rows == 1){
        $row = $result->fetch_assoc();
        jsloadreceiverfrm($row);
    }
    else 
    if ($result->num_rows > 0) {
        //$row = $result->fetch_assoc();
        
        printjscript();
        ?>
            <style>
        .sr {
        	padding: 1px 2px 1px 2px;
        	border-bottom: solid 1px #ccc;
        }
        </style><?php
        echo "<div>CUSTOMER</div>";
        echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
        echo "<tr><td class=\"h\">customer name</td><td class=\"h\">phone</td><td class=\"h\">address</td>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            jsloadreceiverfrm($row);
            echo "<tr class=\"row\" id=" . $row["cid"] . "  type=\"customer\">
                <td class=\"sr\" nowrap=\"nowrap\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">
                    " . $row["cfirst_name"] . ", 
                    " . $row["clast_name"] . "</td>
                <td class=\"sr\">" . $row["cphone"] . "</td>
                <td class=\"sr\" style=\"text-transform:uppercase\">
                    " . $row["caddress"] . " , 
                    " . $row["ccity"] . " ,
                    " . $row["cprovince"] . ".
                    " . $row["czip"] . "</td>
            </tr>";
        }
        echo "</table>";
        
    } else {
        echo "no receivers found</br>";
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
        //printscript();
        $row = $result->fetch_assoc();
        jsloadreceiverfrm($row);
    }
    else{
        echo "receiver search >> not found</br>";
    }
    $conn->close();
}

function jsloadreceiverfrm($row){
    ?>
    <script>
    // fill in form var by jscript
    $(document).ready(function() {
        $("#receiverid").val(<?php echo $row['rid'];?>)
    	$("#rlname").val('<?php echo $row['rlast_name'];?>');
        $("#rfname").val('<?php echo $row['rfirst_name'];?>');
        $("#rdiachi").val('<?php echo $row['rdiachi'];?>');
        var tp=parseInt('<?php echo $row['rtp_tinh'];?>');
        $("#rtptinh").prop("selectedIndex",tp);
        $("#rphone").val('<?php echo $row['rphone1'];?>');
        $("#remail").val('<?php echo $row['remail'];?>');
        });
    </script>
    <?php 
}
function loadtransaction($sql){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        //printscript();
        //echo 'transaction search >> found 1 record</br>';
        $row = $result->fetch_assoc();
        ?>
                <script>
                // fill in form var by jscript
                $(document).ready(function() {
                    //agent
                    $("#leftinfotop").html('Agent Names: '+'<?php echo ($row['afirst_name'].' '.$row['alast_name']);?>')
                    //customer
                    $("#customerid").val('<?php echo $row['customer_id'];?>');
                	$("#clname").val('<?php echo $row['clast_name'];?>');
                    $("#cfname").val('<?php echo $row['cfirst_name'];?>');
                    $("#caddress").val('<?php echo $row['caddress'];?>');
                    $("#ccity").val('<?php echo $row['ccity'];?>');
                    $("#cprovince").prop("selectedIndex",function(){
                    	var cp='<?php echo $row['cprovince'];?>';
                    	//alert(cp);
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
                    //receiver
                    $("#receiverid").val(<?php echo $row['receiver_id'];?>)
                	$("#rlname").val('<?php echo $row['rlast_name'];?>');
                    $("#rfname").val('<?php echo $row['rfirst_name'];?>');
                    $("#rdiachi").val('<?php echo $row['rdiachi'];?>');
                    $("#rtptinh").prop("selectedIndex",parseInt('<?php echo $row['rtp_tinh'];?>'));
                    $("#rphone").val('<?php echo $row['rphone1'];?>');
                    $("#remail").val('<?php echo $row['remail'];?>');
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
                    $("#adnote").val('');
                    //$("#").val('');
                    });
                </script>
                <?php 
            }
            else{
                echo "0|transaction search >> not found";
            }
            $conn->close();
    
    
}
function searchtransaction($sql){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
       echo 'transaction search >> found 1 record</br>';
        $row = $result->fetch_assoc();
        ?>
                <script>
                // fill in form var by jscript
                $(document).ready(function() {
                    //agent
                    $("#leftinfotop").html('Agent Names: '+'<?php echo ($row['afirst_name'].' '.$row['alast_name']);?>')
                    //customer
                    $("#customerid").val('<?php echo $row['customer_id'];?>');
                	$("#clname").val('<?php echo $row['clast_name'];?>');
                    $("#cfname").val('<?php echo $row['cfirst_name'];?>');
                    $("#caddress").val('<?php echo $row['caddress'];?>');
                    $("#ccity").val('<?php echo $row['ccity'];?>');
                    $("#cprovince").prop("selectedIndex",function(){
                    	var cp='<?php echo $row['cprovince'];?>';
                    	//alert(cp);
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
                    //receiver
                    $("#receiverid").val(<?php echo $row['receiver_id'];?>)
                	$("#rlname").val('<?php echo $row['rlast_name'];?>');
                    $("#rfname").val('<?php echo $row['rfirst_name'];?>');
                    $("#rdiachi").val('<?php echo $row['rdiachi'];?>');
                    $("#rtptinh").prop("selectedIndex",parseInt('<?php echo $row['rtp_tinh'];?>'));
                    $("#rphone").val('<?php echo $row['rphone1'];?>');
                    $("#remail").val('<?php echo $row['remail'];?>');
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
                    $("#adnote").val('');
                    //$("#").val('');
                    });
                </script>
          <?php 
    } else  if ($result->num_rows > 1) {
            echo '2|transaction search >> found ' . $result->num_rows . ' records</br>|';
            // ----------------------------------------            ?>
        <style>
._R {
	text-align: right;
	padding: 2px 3px 2px 2px;
}

._L {
	text-align: left;
	padding: 2px 8px 2px 2px;
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
                    		
                    		$.ajax({
                        		type : "POST",
                        		url : "libraries/local.php",
                        		data : {
                        			type : 'loadtransactionfrm',id:id
                        		},
                        		cache : false,
                        		success : function(result) {
                        			$("#logpanel").append(result);
                        		}
                        	});
                    	}
                	});
                	</script>
	<table width="100%" border="0" cellspacing="1" cellpadding="3">
            	
                    <?php
            // ------------------------------------------------------
            
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                                    <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                                    <td class=\"_R\" nowrap=\"nowrap\">" . _f($row["fee_charge"]) . "</td><td class=\"_R\"> " . _f($row["total_amount"]) . "</td>
                                    <td class=\"_R\" nowrap=\"nowrap\">" . $row["created_date"] . "</td>
                                    <td class=\"_R\">" . _status($row["transaction_status"]) . "</td></tr>";
            }
            
            echo "</table>";
        } else {
            echo "0|transaction search >> not found";
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
    // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
    $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
    inner join customer on customer.cid = transaction.customer_id
    inner join receiver on receiver.rid = transaction.receiver_id
    inner join agent on agent.aid = transaction.agent_id
    where transaction.agent_id='{$_POST['aid']}' order by transaction.transaction_status ASC";
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
                            <td class=\"_L\">" . $row["confirmation_no"] . "</td>
                            <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["cfirst_name"] . ", " . $row["clast_name"] . " </td>
                            <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["rfirst_name"] . ", " . $row["rlast_name"] . "</td>
                            <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                            <td class=\"_R\" nowrap=\"nowrap\">" . _f($row["fee_charge"]) . "</td><td class=\"_R\" > " . _f($row["total_amount"]) . "</td>
                            <td class=\"_R\" nowrap=\"nowrap\">" . $row["created_date"] . "</td>
                            <td class=\"_R\" >" . _status($row["transaction_status"]) . "</td></tr>";
                }
                // get sum data
                $sql = "select
    	           sum(total_amount) as Stotalamount_new,
    	           sum(local_amount) as Slocalamount_new,
    	           sum(fee_charge) as Sfee_new
                   from transaction where transaction.agent_id='{$_POST['aid']}' and transaction_status=1";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<tr class=\"row\">
                    <td></td><td></td><td class=\"rtxt\">new trans:</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Slocalamount_new"]) . "</td>
                    <td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Sfee_new"]) . "</td><td class=\"_RR\" nowrap=\"nowrap\"> " . _f($row["Stotalamount_new"]) . "</td>
                    <td></td><td></td><td></td>
                    </tr>";
                }
                // get sum data
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
                
                echo "</table>";
            } else {
                echo "0 results";
            }
            $conn->close();
}
// ////////////////////////////////////////
// HELPER FUNCTION
// ////////////////////////////////////////

function checkinput($par){
    $par = _c($par);
    if($par!='') return true;
    else return false;
}
function printjscript(){
    ?>
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
        		break;
    		case 'receiver':
    			ajaxtype='loadreceiverfrm';
        		break;
    		case 'transaction':
        		ajaxtype='loadtransactionfrm';
        		break;
    		}
    		$.ajax({
        		type : "POST",
        		url : "libraries/local.php",
        		data : {
        			type : ajaxtype,id:id
        		},
        		cache : false,
        		success : function(result) {
            		alert(result);
        			//$("#logpanel").append(result);
        			$("#mainright").html(result);
        		}
        	});
    	}
	});
	</script>
    <?php 
}
function printtptinh($tp){
    switch($tp){
        case "0": return 'Ch&#7885;n t&#7881;nh/th&#224;nh'; break;
        case "1":
            return 'TP. H&#7891; Ch&#237; Minh';
            break;
        case "2":
            return 'TP. H&#224; N&#7897;i';
            break;
        case "3":
            return 'TP. &#272;&#224; N&#7859;ng';
            break;
        case "4":
            return 'TP. Hu&#7871;';
            break;
        case "5":
            return 'TP. H&#7843;i Ph&#242;ng'; break;
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
            return 'pending';
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

function _f($number)
{
    $number = (float)$number;
    setlocale(LC_MONETARY, 'en_US');
    //$temp = money_format('%(#10n', $number);
    $temp = number_format($number, 2, '.', ',');
    return $temp;
}

?>