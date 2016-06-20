<?php
include_once '../config/connect.php';


switch ($_POST['type']) {
    case 'register':
        register();
        break;
    case 'report':
        report();
        break;
    // localview/////////////////////////////
    case 'listagent':
        listagent();
        break;
    case 'listcustomer':
        listcustomer();
        break;
    case 'listreceiver':
        listreceiver();
        break;
    case 'listtransaction':
        listtransaction();
        break;
    case 'listnewtransaction':
        listnewtransaction();
        break;
    case 'customerphonesearch':
        $sql="select * from customer where cstatus=1 AND cphone='{$_POST['phone_no']}'";
        searchcustomer($sql);
        break;
    case 'loadcustomerfrm':
        $sql="select * from customer where cid='{$_POST['id']}'";
        searchcustomer($sql);
        break;
    case 'loadreceiverfrm':
        $sql="select * from receiver where rid='{$_POST['id']}'";
        searchreceiver($sql);
        break;
    case 'loadtransactionfrm':
        $sql="select transaction.*, agent.*, customer.*, receiver.* FROM transaction
        inner join agent on transaction.agent_id=agent.aid
        inner join customer on transaction.customer_id=customer.cid
        inner join receiver on transaction.receiver_id=receiver.rid
        where agent.astatus=1 and  transaction.id='{$_POST['id']}'";
        loadtransaction($sql);
        break;
    case 'transactionsubmitwithid':
        $aid=$_POST['aid'];
        transactionsubmitwithid($_POST['cid'],$_POST['rid'],$aid);
        break;
    case 'transactionsubmitwithNOid':
        $aid=$_POST['aid'];
        $cid=newcustomer();
        $rid=newreceiver($cid);
        transactionsubmitwithid($cid,$rid,$aid);
        break;
    case 'searhtransationbyconumber':
        $sql="select transaction.*, agent.*, customer.*, receiver.* FROM transaction
        inner join agent on transaction.agent_id=agent.aid
        inner join customer on transaction.customer_id=customer.cid
        inner join receiver on transaction.receiver_id=receiver.rid
        where agent.astatus=1 and  transaction.confirmation_no='{$_POST['number']}'";
        searchtransaction($sql);
        break;
    case 'searchtransactionbyphone':
        $sql="select transaction.*, agent.*, customer.*, receiver.* FROM transaction
        inner join agent on transaction.agent_id=agent.aid
        inner join customer on transaction.customer_id=customer.cid
        inner join receiver on transaction.receiver_id=receiver.rid
        where agent.astatus=1 and  customer.cphone='{$_POST['number']}'";
        searchtransaction($sql);
        break;
    case 'transactionupdate':
        transactionupdate();
        break;
    case 'transactionedit':
        transactionedit();
        break;
    case 'newcustomer':
        newcustomer();
        break;
    case 'newreceiver':
        newreceiver($_POST['customerid']);
        break;
    case 'editcustomer':
        editcustomer();
        break;
    case 'editreceiver':
        editreceiver();
        break;
    case 'dailytransaction':
        dailytransaction();
        break;
    case 'fromtodatetransaction':
        fromtodatetransaction();
        break;
    case 'quicknewtransaction':
        quicknewtransaction();
        break;
    case 'sendreport':
       sendreport();
       break;
}

function report()
{
    // show the report view (with the registration form, and messages/errors)
   include("../views/report.php");
}
function register()
{
    // show the register view (with the registration form, and messages/errors)
    include("../views/register.php");
}

function listagent()
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM agent where astatus=1 order by alevel DESC";
    $result = $conn->query($sql);
    $out = '';
    if ($result->num_rows > 0) {
     printjscript();
     ?>
<style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}

.lname {
	font-weight: bold;
}
</style><?php
        $out.= "<div>AGENT</div><table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">
        <tr><td class=\"h\">Type</td><td class=\"h\">Name</td>
    <td class=\"h\">Phone</td><td class=\"h\">Address</td><td class=\"h\">level</td>
    <td class=\"h\" colspan=\"2\">option</td></tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            // settype
            switch ($row["aaccesscode"]) {
                case '1':
                    $type = "vietnam";
                    break;
                case '2':
                    $type = "local";
                    break;
                case '3':
                    $type = "admin";
                    break;
            }
            $out.= "<tr class=\"row\" id=" . $row["aid"] . " type=\"agent\">
                <td class=\"sr\" style=\"text-transform:uppercase\">" . $type . "</td><td class=\"sr\" style=\"text-transform:uppercase\">" . $row["afirst_name"] . "</br>" . $row["alast_name"] . "</td>
                <td class=\"sr\" nowrap=\"nowrap\">" . $row["aphone"] . "</td>
                <td class=\"sr\" style=\"text-transform:uppercase\">" . $row["aaddress"] . "</br> " . $row["acity"] . " " . $row["aprovince"] . " " . $row["azip"] . "</td>
                <td class=\"sr\">".$row["alevel"]."%</td>
                <td class=\"sr\"><img src=\"libraries/edit.png\" width=\"13\" height=\"13\"></td>
                <td class=\"sr\"><img src=\"libraries/delete.png\" width=\"13\" height=\"13\"></td> 
        </tr>";
        }
        $out.= "</table>";
    } else {
        $out= "0 results";
    }
    echo $out;
    $conn->close();
}
function listcustomer(){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        
    }
    /*$sql = "select agent.*, agent_customer.*, customer.* from agent
inner join agent_customer on agent.aid=agent_customer.agent_id
inner join customer on customer.cid=agent_customer.customer_id
where customer.cstatus=1 order by agent.aid, customer.clast_name";*/
    $sql = "select agent.*, agent_customer.agent_id,agent_customer.customer_id,customer.*, customer_receiver.*, receiver.* from agent
    inner join agent_customer on agent.aid = agent_customer.agent_id
    inner join customer on customer.cid = agent_customer.customer_id
    inner join customer_receiver on customer_receiver.customer_id = agent_customer.customer_id
    inner join receiver on receiver.rid = customer_receiver.receiver_id
    where agent.astatus=1 and customer.cstatus=1 order by agent.aid, customer.clast_name";
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
        echo "<div>LIST ALL SENDERS/CUSTOMERS</div>";
        echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
        echo "<tr><td class=\"h\">sender</td><td class=\"h\">receiver</td><td class=\"h\">agent</td>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr class=\"row\" id=" . $row["cid"] . "  type=\"customer\">
             
                    <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\" nowrap=\"nowrap\">
                                " . $row["cfirst_name"] . ", " . $row["clast_name"] . "</br>
                        <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["cphone"] . "</br>
                        " . $row["caddress"] . ", " . $row["ccity"] . "</br>
                        " . $row["cprovince"] . ". " . $row["czip"] . "
                        </td>
              <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\">
                                " . $row["rfirst_name"] . ", " . $row["rlast_name"] ."</br>
                                <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["rphone1"] . "</br>
                                " . $row["rdiachi"] . "</br>" . printtptinh($row["rtp_tinh"]) ."</br>
                        </td>
            <td class=\"sr\" nowrap=\"nowrap\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">
                    " . $row["afirst_name"] . "</br>
                    " . $row["alast_name"] . "</td>
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
    
    $sql = "select agent.*, agent_customer.agent_id,agent_customer.customer_id,customer.*, customer_receiver.*, receiver.* from agent
    inner join agent_customer on agent.aid = agent_customer.agent_id
    inner join customer on customer.cid = agent_customer.customer_id
    inner join customer_receiver on customer_receiver.customer_id = agent_customer.customer_id
    inner join receiver on receiver.rid = customer_receiver.receiver_id
    where agent.astatus=1 and receiver.rstatus=1 order by agent.aid, receiver.rlast_name";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        printjscript();
                // -----------------------------------------------------------------
        ?>
<style>
.sr {
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}

.lname {
	font-weight: bold;
}
</style><?php 
                echo "<div>LIST ALL RECEIVERS</div><table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">";
                echo "<tr><td class=\"h\">receiver name</td><td class=\"h\">sender name</td><td class=\"h\">agent</td>";
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class=\"row\" id=" . $row["rid"] . " type=\"receiver\" >               
                        <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\">
                                " . $row["rfirst_name"] . ", " . $row["rlast_name"] ."</br>
                                <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["rphone1"] . "</br>
                                " . $row["rdiachi"] . "</br>" . printtptinh($row["rtp_tinh"]) ."</br>
                        </td>
                        <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\" nowrap=\"nowrap\">
                                " . $row["cfirst_name"] . ", " . $row["clast_name"] . "</br>
                        <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["cphone"] . "</br>
                        " . $row["caddress"] . ", " . $row["ccity"] . "</br>
                        " . $row["cprovince"] . ". " . $row["czip"] . "
                        </td>
                        <td class=\"sr\" valign=\"top\"  style=\"text-transform:uppercase\" nowrap=\"nowrap\">
                                " . $row["afirst_name"] . "</br>" . $row["alast_name"] . "
                        </td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
            $conn->close();
    
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
        case "1": return 'TP. H&#7891; Ch&#237; Minh'; break;
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
function _showshowcurrencytype($input){
    switch ($input) {
        case '0':
            return 'CAD';
        break;
        case '1':
            return 'USD';
        break;
        default:
            return 'N/A';
        break;
    }
}
function dailytransaction(){

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
    where agent.astatus=1 and transaction.created_date BETWEEN       
    DATE_SUB(CURDATE(), INTERVAL {$_POST['days']} DAY)  AND CURDATE() order by transaction.created_date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // ----------------------------------------        ?>
<style>
._R {
	text-align: right;
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}

._L {
	text-align: left;
	padding: 1px 3px 1px 2px;
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
                		$(this).attr("selectedtrans","1");
                    	var selectedrow=$(this).attr("class");
                    	//row is selected - highlite
                    	if (selectedrow=="row entered selected"){
                    		var id =$(this).attr('id');
                    		
                    		$.ajax({
                        		type : "POST",
                        		url : "libraries/admin.php",
                        		data : {
                        			type : 'loadtransactionfrm',id:id
                        		},
                        		cache : false,
                        		success : function(result) {
                        			$("#logstart").append(result);
                        		}
                        	});
                    	}
                	});
                	$("#sendreport").click(function(){
                		var dataString = '';
                		var inputElements = document.getElementsByClassName('selectedtrans');
                		for(var i=0; inputElements[i]; ++i){
                		      if(inputElements[i].checked){
                		    	  dataString += inputElements[i].value+",";
                		      }
                		}
                		if(dataString!=''){
                    		$.ajax({
                        		type : "POST",
                        		url : "libraries/admin.php",
                        		data : {
                        			type : 'sendreport',idstring:dataString
                        		},
                        		cache : false,
                        		success : function(result) {
                        			$("#dialog_reportsendfrm").html(result);
                        			$("#dialog_reportsendfrm").dialog('open');
                        		}
                        	});
                		}else{
              			  alert("Select transaction to send !");
                    	}
                	});
</script>

<form id="selecttransctionreport">
	<table width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<td class="h">agent</td>
			<td class="h">sender</td>
			<td class="h">receiver</td>
			<td class="h">amount</td>
			<td class="h">time</td>			
			<td class="h">status</td>
			<td class="h">send</td>
		</tr>
        <?php
            // ------------------------------------------------------
            
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                        <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["afirst_name"] . "</br><sub>" . $row["alast_name"] . "</sub></td>
                        <td class=\"_L\" valign=\"top\"  style=\"text-transform:uppercase\" nowrap=\"nowrap\">
                                " . $row["cfirst_name"] . ", " . $row["clast_name"] . "</br>
                        <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["cphone"] . "</br>
                        " . $row["caddress"] . "</br>" . $row["ccity"] . "</br>
                        " . $row["cprovince"] . ". " . $row["czip"] . "
                        </td>
                        <td class=\"_L\" valign=\"top\"  style=\"text-transform:uppercase\">
                                " . $row["rfirst_name"] . ", " . $row["rlast_name"] ."</br>
                                <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["rphone1"] . "</br>
                                " . $row["rdiachi"] . "</br>" . printtptinh($row["rtp_tinh"]) ."</br>
                        </td>
                        <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                        <td class=\"_R\" nowrap=\"nowrap\">" .  substr($row["created_date"],0,10) . "</td>
                        <td class=\"_R\" >" . _status($row["transaction_status"]) . "</td>
                        <td class=\"_R\"><input class=\"selectedtrans\" type=\"checkbox\" value=". $row["id"]."></td>
                        </tr>";
            }
            echo "</table></form>";
        } else {
            echo "0 results";
        }
        $conn->close();
    
}

function fromtodatetransaction(){

    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $fromdate = $_POST['fromdate'];
    $todate=$_POST['todate'];
	$showtype=$_POST['showtype'];
    // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
	if ($showtype==0){
	$sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
    inner join customer on customer.cid = transaction.customer_id
    inner join receiver on receiver.rid = transaction.receiver_id
    inner join agent on agent.aid = transaction.agent_id
    where agent.astatus=1 and transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date DESC";
	}else{
    $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
    inner join customer on customer.cid = transaction.customer_id
    inner join receiver on receiver.rid = transaction.receiver_id
    inner join agent on agent.aid = transaction.agent_id
    where agent.astatus=1 and transaction.transaction_status='{$showtype}' and transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date DESC";
    }
	$result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // ----------------------------------------        ?>
<style>
._R {
	text-align: right;
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}

._L {
	text-align: left;
	padding: 1px 3px 1px 2px;
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
                		$(this).attr("selectedtrans","1");
                    	var selectedrow=$(this).attr("class");
                    	//row is selected - highlite
                    	if (selectedrow=="row entered selected"){
                    		var id =$(this).attr('id');
                    		
                    		$.ajax({
                        		type : "POST",
                        		url : "libraries/admin.php",
                        		data : {
                        			type : 'loadtransactionfrm',id:id
                        		},
                        		cache : false,
                        		success : function(result) {
                        			$("#logstart").append(result);
                        		}
                        	});
                    	}
                	});
                	$("#sendreport").click(function(){
                		var dataString = '';
                		var inputElements = document.getElementsByClassName('selectedtrans');
                		for(var i=0; inputElements[i]; ++i){
                		      if(inputElements[i].checked){
                		    	  dataString += inputElements[i].value+",";
                		      }
                		}
                		if(dataString!=''){
                    		$.ajax({
                        		type : "POST",
                        		url : "libraries/admin.php",
                        		data : {
                        			type : 'sendreport',idstring:dataString
                        		},
                        		cache : false,
                        		success : function(result) {
                        			$("#dialog_reportsendfrm").html(result);
                        			$("#dialog_reportsendfrm").dialog('open');
                        		}
                        	});
                		}else{
              			  alert("Select transaction to send !");
                    	}
                	});
</script>
		<form id="selecttransctionreport">
			<table width="100%" border="0" cellspacing="1" cellpadding="3">
				<tr>
					<td class="h">#</td>
					<td class="h">ID</td>
					<td class="h">Sender</td>
					<td class="h">Receiver</td>
					<td class="h">Amount</td>
					<td class="h">Date</td>
					<td class="h">Status</td>
					<td class="h">Send</td>
				</tr>
        <?php
            // ------------------------------------------------------
            
            // output data of each row
            $index=1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                        <td class=\"_L\" >".$row["id"]."</td>
                        <td class=\"_L\" style=\"text-transform:uppercase\">" . $row["aid"] . "-" . $row["afirst_name"] . "</td>
                        <td class=\"_L\" valign=\"top\" nowrap=\"nowrap\">
                                " . $row["cfirst_name"] . ", " . $row["clast_name"] . "</br>
                        <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["cphone"] . "</br>
                        " . $row["caddress"] . "</br>" . $row["ccity"] . "</br>
                        " . strtoupper($row["cprovince"]) . ". " . $row["czip"] . "
                        </td>
                        <td class=\"_L\" valign=\"top\" >
                                " . $row["rfirst_name"] . ", " . $row["rlast_name"] ."</br>
                                <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["rphone1"] . "</br>
                                " . $row["rdiachi"] . "</br>" . printtptinh($row["rtp_tinh"]) ."</br>
                        </td>
                        <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                        <td class=\"_R\" nowrap=\"nowrap\">" .  substr($row["created_date"],0,10) . "</td>
                        <td class=\"_R\" >" . _status($row["transaction_status"]) . "</td>
                        <td class=\"_R\"><input class=\"selectedtrans\" type=\"checkbox\" value=". $row["id"]."></td>
                        </tr>";
                $index++;
            }
            echo "</table></form>";
        } else {
            echo "0 results";
        }
        $conn->close();
    
}

function quicknewtransaction(){

    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where agent.astatus=1 and transaction.transaction_status=1 order by transaction.created_date DESC";
    
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // ----------------------------------------        ?>
<style>
._R {
	text-align: right;
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}

._L {
	text-align: left;
	padding: 1px 3px 1px 2px;
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
                		$(this).attr("selectedtrans","1");
                    	var selectedrow=$(this).attr("class");
                    	//row is selected - highlite
                    	if (selectedrow=="row entered selected"){
                    		var id =$(this).attr('id');
                    		
                    		$.ajax({
                        		type : "POST",
                        		url : "libraries/admin.php",
                        		data : {
                        			type : 'loadtransactionfrm',id:id
                        		},
                        		cache : false,
                        		success : function(result) {
                        			$("#logstart").append(result);
                        		}
                        	});
                    	}
                	});
                	$("#sendreport").click(function(){
                		var dataString = '';
                		var inputElements = document.getElementsByClassName('selectedtrans');
                		for(var i=0; inputElements[i]; ++i){
                		      if(inputElements[i].checked){
                		    	  dataString += inputElements[i].value+",";
                		      }
                		}
                		if(dataString!=''){
                    		$.ajax({
                        		type : "POST",
                        		url : "libraries/admin.php",
                        		data : {
                        			type : 'sendreport',idstring:dataString
                        		},
                        		cache : false,
                        		success : function(result) {
                        			$("#dialog_reportsendfrm").html(result);
                        			$("#dialog_reportsendfrm").dialog('open');
                        		}
                        	});
                		}else{
              			  alert("Select transaction to send !");
                    	}
                	});
</script>
		<form id="selecttransctionreport">
			<table width="100%" border="0" cellspacing="1" cellpadding="3">
				<tr>
					<td class="h">#</td>
					<td class="h">ID</td>
					<td class="h">Sender</td>
					<td class="h">Receiver</td>
					<td class="h">Amount</td>
					<td class="h">Date</td>
					<td class="h">Status</td>
					<td class="h">Send</td>
				</tr>
        <?php
            // ------------------------------------------------------
            
            // output data of each row
            $index=1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                        <td class=\"_L\" >".$row["id"]."</td>
                        <td class=\"_L\" style=\"text-transform:uppercase\">" . $row["aid"] . "-" . $row["afirst_name"] . "</td>
                        <td class=\"_L\" valign=\"top\" nowrap=\"nowrap\">
                                " . $row["cfirst_name"] . ", " . $row["clast_name"] . "</br>
                        <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["cphone"] . "</br>
                        " . $row["caddress"] . "</br>" . $row["ccity"] . "</br>
                        " . strtoupper($row["cprovince"]) . ". " . $row["czip"] . "
                        </td>
                        <td class=\"_L\" valign=\"top\" >
                                " . $row["rfirst_name"] . ", " . $row["rlast_name"] ."</br>
                                <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">" . $row["rphone1"] . "</br>
                                " . $row["rdiachi"] . "</br>" . printtptinh($row["rtp_tinh"]) ."</br>
                        </td>
                        <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                        <td class=\"_R\" nowrap=\"nowrap\">" .  substr($row["created_date"],0,10) . "</td>
                        <td class=\"_R\" >" . _status($row["transaction_status"]) . "</td>
                        <td class=\"_R\"><input class=\"selectedtrans\" type=\"checkbox\" value=". $row["id"]."></td>
                        </tr>";
                $index++;
            }
            echo "</table></form>";
        } else {
            echo "0 results";
        }
        $conn->close();
    
}
function sendreport(){
    $arr_id=substr($_POST['idstring'],0,strlen($_POST['idstring'])-1); 
    
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
    where transaction.id in ({$arr_id})";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        ?>
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
</style><div id="printdiv">
					<table width="100%" border="0" cellspacing="2" cellpadding="3">
						<tr>
							<td colspan="2"class="_R_"><img src="libraries/logo.png" width="60" height="60"></td>
							<td colspan="3" valign="center" class="_L_">TY PC-TECH INC. -
								MONEY TRANSFER<br />6599 Avenue Du Parc<br />Montreal, QC. H2V
								4J1<br>514 658 6678
							</td>
							<td colspan="3" valign="top" class="_L_"><?php echo date("d/m/Y");?></td>
						</tr>
						<tr>
							<td class="h_">#</td>
							<td class="h_">M&#227; S&#7889;</td>
							<td class="h_">Ng&#432;&#7901;i G&#7919;i</td>
							<td class="h_">Ng&#432;&#7901;i Nh&#7853;n</td>
							<td class="h_" nowrap>S&#7889; Ti&#7873;n</td>
							<td class="h_">TP/T&#7881;nh</td>
							<td class="h_" nowrap>Chi Tr&#7843;</td>
							<td class="h_">Ng&#224;y g&#7919;i</td>
						</tr>
        <?php
            // output data of each row
            $totalsend=0;
            $index=1;
            while ($row = $result->fetch_assoc()) {
                $totalsend+=$row["local_amount"];
                echo "<tr ><td class=\"_L_\" >".$row["id"]."</td><td class=\"_L_\" valign=\"top\">". _conumber($row['confirmation_no'])."</td>
                        <td class=\"_L_\" style=\"text-transform:uppercase\">" . $row["cfirst_name"] . ", " . $row["clast_name"] . "</br>
                        <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">". $row["cphone"]."</br>" . $row["caddress"] . 
                        "</br>" . $row["ccity"] . " " . $row["cprovince"] . " " . $row["czip"] . "</br>" . $row["cemail"] . "
                        </td>
                        <td class=\"_L_\" style=\"text-transform:uppercase\">" . $row["rfirst_name"] . ", " . $row["rlast_name"] . "</br>
                        <img src=\"libraries/phone-icon.png\" width=\"13\" height=\"13\">". $row["rphone1"]."</br>" . $row["rdiachi"] . "</br>" .printtptinh($row["rtp_tinh"]) . "</br>" . $row["remail"] . "</td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"><b> " . _f($row["local_amount"]) . "</b></td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"> " .printtptinh($row["rtp_tinh"]) . "</td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"> " .printdeliverymethod($row["delivery_method"]) . "</td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\">" .  substr($row["created_date"],0,10) . "</td>
                     </tr>";
               $index++;
            }
            echo "<tr>
                        <td class=\"_L_\">&nbsp;</td>
                        <td class=\"_L_\">&nbsp;</td>
                        <td class=\"_L_\">&nbsp;</td>
                        <td class=\"_R_\"><b>Tổng Cộng:</b></td>
                        <td class=\"_R_\" nowrap=\"nowrap\"><div id=\"send_total\"><b>"._f($totalsend)."</b></div></td>
                        <td class=\"_L_\"><div id=\"send_currency\"><b>CAD</b></div></td>
                        <td class=\"_L_\">&nbsp;</td>
                        <td class=\"_L_\">&nbsp;</td>
                      </tr>";
            echo "</table></div>";
        } else {
            echo "0 results";
        }
        $conn->close();
    
}

function generatereport_printrow($row){
    
}
function generatereport_printheader($row){
    
}
function generatereport_printfooter($row){
    
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
    where agent.astatus=1 and transaction.status=1 order by transaction.created_date DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        printjscript();
    // ----------------------------------------        ?>
<style>
._R {
	text-align: right;
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
}

._L {
	text-align: left;
	padding: 1px 3px 1px 2px;
	border-bottom: solid 1px #ccc;
}
</style>
						<table width="100%" border="0" cellspacing="1" cellpadding="3">
							<tr>
								<td class="h">#</td>
								<td class="h">agent</td>
								<td class="h">customer</td>
								<td class="h">receiver</td>
								<td class="h">amount</td>
								<td class="h">time</td>
								<td class="h">status</td>
							</tr>
        <?php
            // ------------------------------------------------------
            
            // output data of each row
            $index=1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                        <td class=\"_L\" >".$row["id"]."</td>
                        <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["afirst_name"] . "</br><sub>" . $row["alast_name"] . "</sub></td>
                        <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["cfirst_name"] . "</br><sub>" . $row["clast_name"] . "</sub></td>
                        <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["rfirst_name"] . "</br><sub>" . $row["rlast_name"] . "</sub></td>
                        <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                        <td class=\"_R\" nowrap=\"nowrap\">" .  substr($row["created_date"],0,10) . "</td>
                        <td class=\"_R\" >" . _status($row["transaction_status"]) . "</td></tr>";
                $index++;
            }
            
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
    
}
function listnewtransaction(){

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
    where agent.astatus=1 and transaction.transaction_status=1 order by transaction.created_date ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // ----------------------------------------        ?>
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
        		//alert(id);
        		$.ajax({
            		type : "POST",
            		url : "libraries/admin.php",
            		data : {
            			type : 'loadtransactionfrm',id:id
            		},
            		cache : false,
            		success : function(result) {
            			$("#logstart").append(result);
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
            echo "0 results";
        }
        $conn->close();
    
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
    		case 'agent':
    			var aid=id;
    			$.ajax({
    					type : "POST",
    					url : "libraries/changeinfo_get.php",
    					data : {type:'loadinfo',aid:aid},
    					cache : false,
    					success : function(result) {
    						$("#logstart").append(result);
    						$("#dialog_account").dialog('open');
    						}
    					});
        		break;
    		}
    		$.ajax({
        		type : "POST",
        		url : "libraries/admin.php",
        		data : {
        			type : ajaxtype,id:id
        		},
        		cache : false,
        		success : function(result) {
        			$("#logstart").append(result);
        			
        		}
        	});
    	}
	});
	</script>
    <?php 
}

function searchcustomer($sql)
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //$sql = "select * from customer where cstatus=1 AND cphone='{$phone_no}'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        //printscript();
        $out='customer search >> found 1 record</br>';
        $row = $result->fetch_assoc();
        ?>
        <script>
        // fill in form var by jscript
        $(document).ready(function() {
        	function strcheck(s){
            	s = s.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'');
            	return s;
                }
            $("#customerid").val("<?php echo $row['cid'];?>");
        	$("#clname").val(strcheck("<?php echo $row['clast_name'];?>"));
            $("#cfname").val(strcheck("<?php echo $row['cfirst_name'];?>"));
            $("#caddress").val(strcheck("<?php echo $row['caddress'];?>"));
            $("#ccity").val(strcheck("<?php echo $row['ccity'];?>"));
            //$("#cprovince").val('Manitoba');
            //$("#cprovince option[value='Manitoba']").attr("selected",true);
            $("#cprovince").prop("selectedIndex",function(){
            	var cp="<?php echo $row['cprovince'];?>";
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
            $("#czip").val("<?php echo $row['czip'];?>");
            $("#cphone").val("<?php echo $row['cphone'];?>");
            $("#cemail").val("<?php echo $row['cemail'];?>");
            });
        </script>
        <?php 
    }
    else{
        $out = "customer search >> not found</br>";
    }
    echo $out;
    $conn->close();
}
function searchreceiver($sql)
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
        $out='receiver search >> found 1 record</br>';
        $row = $result->fetch_assoc();
        ?>
        <script>
        // fill in form var by jscript
        $(document).ready(function() {
        	function strcheck(s){
            	s = s.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'');
            	return s;
                }
            $("#receiverid").val("<?php echo $row['rid'];?>")
        	$("#rlname").val(strcheck("<?php echo $row['rlast_name'];?>"));
            $("#rfname").val(strcheck("<?php echo $row['rfirst_name'];?>"));
            $("#rdiachi").val(strcheck("<?php echo $row['rdiachi'];?>"));
            var tp=parseInt("<?php echo $row['rtp_tinh'];?>");
            $("#rtptinh").prop("selectedIndex",tp);
            $("#rphone").val("<?php echo $row['rphone1'];?>");
            $("#remail").val("<?php echo $row['remail'];?>");
            });
        </script>
        <?php 
    }
    else{
        $out = "receiver search >> not found</br>";
    }
    echo $out;
    $conn->close();
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
        $row = $result->fetch_assoc();
        echo 'transaction '.$row['confirmation_no'].' selected.</br>';
        ?>
                <script>
                // fill in form var by jscript
                $(document).ready(function() {
                    //agent
                    //customer
                    $("#customerid").val("<?php echo $row['customer_id'];?>");
                	$("#clname").val(strcheck("<?php echo $row['clast_name'];?>"));
                    $("#cfname").val(strcheck("<?php echo $row['cfirst_name'];?>"));
                    $("#caddress").val(strcheck("<?php echo $row['caddress'];?>"));
                    $("#ccity").val("<?php echo $row['ccity'];?>");
                    $("#cprovince").prop("selectedIndex",function(){
                    	var cp="<?php echo $row['cprovince'];?>";
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
                    $("#czip").val("<?php echo $row['czip'];?>");
                    $("#cphone").val("<?php echo $row['cphone'];?>");
                    $("#cemail").val("<?php echo $row['cemail'];?>");
                    //receiver
                    $("#receiverid").val("<?php echo $row['receiver_id'];?>")
                	$("#rlname").val(strcheck("<?php echo $row['rlast_name'];?>"));
                    $("#rfname").val(strcheck("<?php echo $row['rfirst_name'];?>"));
                    $("#rdiachi").val(strcheck("<?php echo $row['rdiachi'];?>"));
                    $("#rtptinh").prop("selectedIndex",parseInt("<?php echo $row['rtp_tinh'];?>"));
                    $("#rphone").val("<?php echo $row['rphone1'];?>");
                    $("#remail").val("<?php echo $row['remail'];?>");
                    //transaction
                    $("#transactionid").val("<?php echo $row['id'];?>")
                    $("#trans_conumber").val("<?php echo $row['confirmation_no'];?>");
                    $("#trans_phonenumber").val("<?php echo $row['cphone'];?>");
                    $("#localamount").val("<?php echo $row['local_amount'];?>");
                    $("#selectlocaltype").prop("selectedIndex",parseInt("<?php echo $row['local_currency_type'];?>"));
                    $("#selectdeliverytype").prop("selectedIndex",parseInt("<?php echo $row['foreign_currency_type'];?>"));
                    $("#deliveryamount").val("<?php echo $row['foreign_amount'];?>");
                    $("#fee").val("<?php echo $row['fee_charge'];?>");
                    $("#totalamount").val("<?php echo $row['total_amount'];?>");
                    $("#deliverymethod").prop("selectedIndex",parseInt("<?php echo $row['delivery_method'];?>"));
                    $("#tnote").val(strcheck("<?php echo $row['transaction_note'];?>"));
                    //admin
                    $("#adstatus").prop("selectedIndex",parseInt("<?php echo $row['transaction_status'];?>")-1);
                    $("#adconfirmationby").prop("selectedIndex",parseInt("<?php echo $row['transaction_confirmby'];?>"));
                    $("#adnote").val(strcheck('<?php echo $row['transaction_note'];?>'));
                    //$("#").val('');
                    function strcheck(s){
                    	s = s.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'');
                    	return s;
                        }
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
                	function strcheck(s){
                    	s = s.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'');
                    	return s;
                        }
                    //agent
                    //customer
                    $("#customerid").val("<?php echo $row['customer_id'];?>");
                	$("#clname").val(strcheck("<?php echo $row['clast_name'];?>"));
                    $("#cfname").val(strcheck("<?php echo $row['cfirst_name'];?>"));
                    $("#caddress").val(strcheck("<?php echo $row['caddress'];?>"));
                    $("#ccity").val(strcheck("<?php echo $row['ccity'];?>"));
                    $("#cprovince").prop("selectedIndex",function(){
                    	var cp="<?php echo $row['cprovince'];?>";
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
                    $("#czip").val("<?php echo $row['czip'];?>");
                    $("#cphone").val("<?php echo $row['cphone'];?>");
                    $("#cemail").val("<?php echo $row['cemail'];?>");
                    //receiver
                    $("#receiverid").val("<?php echo $row['receiver_id'];?>")
                	$("#rlname").val(strcheck("<?php echo $row['rlast_name'];?>"));
                    $("#rfname").val(strcheck("<?php echo $row['rfirst_name'];?>"));
                    $("#rdiachi").val(strcheck("<?php echo $row['rdiachi'];?>"));
                    $("#rtptinh").prop("selectedIndex",parseInt("<?php echo $row['rtp_tinh'];?>"));
                    $("#rphone").val("<?php echo $row['rphone1'];?>");
                    $("#remail").val("<?php echo $row['remail'];?>");
                    //transaction
                    $("#transactionid").val("<?php echo $row['id'];?>")
                    $("#trans_conumber").val("<?php echo $row['confirmation_no'];?>");
                    $("#trans_phonenumber").val("<?php echo $row['cphone'];?>");
                    $("#localamount").val("<?php echo $row['local_amount'];?>");
                    $("#selectlocaltype").prop("selectedIndex",parseInt("<?php echo $row['local_currency_type'];?>"));
                    $("#selectdeliverytype").prop("selectedIndex",parseInt("<?php echo $row['foreign_currency_type'];?>"));
                    $("#deliveryamount").val("<?php echo $row['foreign_amount'];?>");
                    $("#fee").val("<?php echo $row['fee_charge'];?>");
                    $("#totalamount").val("<?php echo $row['total_amount'];?>");
                    $("#deliverymethod").prop("selectedIndex",parseInt("<?php echo $row['delivery_method'];?>"));
                    $("#tnote").val(strcheck("<?php echo $row['transaction_note'];?>"));
                    //admin
                    $("#adstatus").prop("selectedIndex",parseInt("<?php echo $row['transaction_status'];?>")-1);
                    $("#adconfirmationby").prop("selectedIndex",parseInt("<?php echo $row['transaction_confirmby'];?>"));
                    $("#adnote").val(strcheck('<?php echo $row['transaction_note'];?>'));
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
                        		url : "libraries/admin.php",
                        		data : {
                        			type : 'loadtransactionfrm',id:id
                        		},
                        		cache : false,
                        		success : function(result) {
                        			$("#logstart").append(result);
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

function transactionsubmitwithid($cid, $rid, $aid)
{
    $agentid = $aid;
    $customerid = $cid;
    $receiverid = $rid;
    // confirmation no.
    $cnumber = time();
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO transaction (agent_id,customer_id,receiver_id,local_currency_type,foreign_currency_type,
    local_amount,foreign_amount,fee_charge,
    total_amount,delivery_method,confirmation_no,transaction_note)
    VALUES ('$agentid','$customerid','$receiverid','{$_POST['selectlocaltype']}','{$_POST['selectdeliverytype']}',
    '{$_POST['localamount']}','{$_POST['deliveryamount']}','{$_POST['fee']}',
    '{$_POST['totalamount']}','{$_POST['deliverymethod']}',$cnumber,'{$_POST['tnote']}');";
    //$sql.="INSERT INTO customer_receiver (customer_id,receiver_id) VALUES('$customerid','$receiverid')";
    $sql.="INSERT INTO customer_receiver(customer_id,receiver_id)
     SELECT '$customerid','$receiverid' FROM DUAL WHERE NOT EXISTS 
    (SELECT * FROM customer_receiver WHERE customer_id='$customerid' AND receiver_id='$receiverid')";
    //if ($conn->query($sql) === TRUE) {
    if ($conn->multi_query($sql) === TRUE) {
        echo 'Confirmation No.' . $cnumber. "</br>|". $cnumber;
    
        }else {
            echo "Error: " . $sql . "</br>" . $conn->error;
        }
        
        $conn->close();
    
}
function transactionupdate(){
    $transaction_id = $_POST['tid'];
    $transaction_newstatus = $_POST['adstatus'];
    $transaction_updatetime = time();
    $transaction_confirmby=$_POST['adconfirmationby'];
    $transaction_note=_scheck($_POST['adnote']);
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //complete transaction
    if($transaction_newstatus==5){
        $sql = "UPDATE transaction
        SET transaction_status='$transaction_newstatus',
        complete_date='$transaction_updatetime',
        transaction_confirmby='$transaction_confirmby',
        transaction_note='$transaction_note'
        WHERE id='$transaction_id'";
    }else{
        $sql = "UPDATE transaction
        SET transaction_status='$transaction_newstatus',
        modify_date='$transaction_updatetime',
        transaction_confirmby='$transaction_confirmby',
        transaction_note='$transaction_note'
        WHERE id='$transaction_id'";
    }
    //echo "DEBUG: " . $sql.'</br>';
    if ($conn->query($sql) === TRUE) {
        echo "updated successfully</br>";
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
    }
    
    $conn->close();
    
}
function transactionedit(){
    $transaction_id = $_POST['tid'];
    $transaction_updatetime = time();
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //complete transaction
    if($transaction_newstatus==5){
        $sql = "UPDATE transaction
        SET local_amount='{$_POST['localamount']}',
        foreign_amount='{$_POST['deliveryamount']}',
        fee_charge='{$_POST['fee']}',
        total_amount='{$_POST['totalamount']}',
        delivery_method='{$_POST['deliverymethod']}',
        transaction_note='{$_POST['tnote']}'
        WHERE id='$transaction_id'";
    }else{
        $sql = "UPDATE transaction
        SET modify_date='$transaction_updatetime',
        local_amount='{$_POST['localamount']}',
        foreign_amount='{$_POST['deliveryamount']}',
        fee_charge='{$_POST['fee']}',
        total_amount='{$_POST['totalamount']}',
        delivery_method='{$_POST['deliverymethod']}',
        transaction_note='{$_POST['tnote']}'
        WHERE id='$transaction_id'";
    }
    //echo "DEBUG: " . $sql.'</br>';
    if ($conn->query($sql) === TRUE) {
        echo "updated successfully</br>";
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
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
    $caddress = _scheck($_POST['caddress']);
    $cfname = _scheck($_POST['clname']);
    $clname = _scheck($_POST['cfname']);
    /*$sql = "INSERT INTO customer (cfirst_name,clast_name,cphone,caddress,ccity,cprovince,czip,cemail) 
    select  '{$_POST['cfname']}','{$_POST['clname']}','{$_POST['cphone']}','{$_POST['caddress']}',
            '{$_POST['ccity']}','{$_POST['cprovince']}','{$_POST['czip']}','{$_POST['cemail']}' 
    from dual where not exists (select * from customer where cphone='{$_POST['cphone']}')";*/
    
    $sql = "INSERT INTO customer (cfirst_name,clast_name,cphone,caddress,ccity,cprovince,czip,cemail)
    select  '{$cfname}','{$clname}','{$_POST['cphone']}','{$caddress}',
    '{$_POST['ccity']}','{$_POST['cprovince']}','{$_POST['czip']}','{$_POST['cemail']}'
    from dual where not exists (select * from customer where cphone='{$_POST['cphone']}')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New customer created successfully</br>";
        $customer_id = $conn->insert_id;
        if ($customer_id != 0) {
            $sql = "INSERT INTO agent_customer (agent_id,customer_id)
                VALUES ('$agent_id','$customer_id')";
            if ($conn->query($sql) === TRUE) {
                echo "New join table created successfully</br>|" . $customer_id . "|" . $_POST['cphone'];
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
function editcustomer(){
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
        // $ucasezip= strtoupper($_POST['czip']);
    $sql = "UPDATE customer SET
            cfirst_name='{$_POST['cfname']}',
            clast_name='{$_POST['clname']}',
            caddress='{$_POST['caddress']}',
            ccity='{$_POST['ccity']}',
            cprovince='{$_POST['cprovince']}',
            czip='{$_POST['czip']}',
            cemail='{$_POST['cemail']}'
            WHERE cid='{$_POST['cid']}'";
    if ($conn->query($sql) === TRUE) {
        echo "customer ID:".$_POST['cid'] ." updated successfully</br>";
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
    }
    $conn->close();
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
    // $sql = "INSERT INTO receiver (rfirst_name,rlast_name,rdiachi,rtp_tinh,rphone1,remail)
    // VALUES ('{$_POST['rfname']}','{$_POST['rlname']}','{$_POST['rdiachi']}','{$_POST['rtptinh']}',
    // '{$_POST['rphone']}','{$_POST['remail']}')";
    $tempdiachi = str_replace (".",",",$_POST['rdiachi']);
    
    $sql = "INSERT INTO receiver (rfirst_name,rlast_name,rdiachi,rtp_tinh,rphone1,remail)
    select '{$_POST['rfname']}','{$_POST['rlname']}','{$tempdiachi}','{$_POST['rtptinh']}',
        '{$_POST['rphone']}','{$_POST['remail']}' from dual where not exists
        (select * from receiver where rphone1='{$_POST['rphone']}')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New receiver created successfully</br>";
        $receiverid = $conn->insert_id;
        if ($receiverid != 0) {
            $sql = "INSERT INTO customer_receiver (customer_id,receiver_id) VALUES ('$customerid','$receiverid')";
            if ($conn->query($sql) === TRUE) {
                echo "New join table created successfully</br>|" . $receiverid . "|";
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
function editreceiver()
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // $ucasezip= strtoupper($_POST['czip']);
    $sql = "UPDATE receiver SET
        rfirst_name='{$_POST['rfname']}',
        rlast_name='{$_POST['rlname']}',
        rdiachi='{$_POST['rdiachi']}',
        rtp_tinh='{$_POST['rtptinh']}',
        rphone1='{$_POST['rphone']}',
        remail='{$_POST['remail']}' 
        WHERE rid='{$_POST['rid']}'";
    
    if ($conn->query($sql) === TRUE) {
        echo "receiver ID:" . $_POST['rid'] . " updated successfully</br>";
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
    }
    $conn->close();
}
// ////////////////////////////////////////
// HELPER FUNCTION
// ////////////////////////////////////////
function connection()
{
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}
function _status($s)
{
    switch ($s) {
        case '1':
            return 'new';
            break;
        case '2':
            return 'approved';
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
function _conumber($data){
    $temp =  substr($data, - 10, 10);
    return $temp;
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
    $data = str_replace(".","",$data);
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

?>