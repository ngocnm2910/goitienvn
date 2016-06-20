<?php
include_once '../config/connect.php';
// declare gl)
session_start();
$_SESSION['transID']= array();

switch ($_POST['type']) {
    case 'agent_getnamelist':
        agent_getnamelist();
        break;
    case 'reportagent_selectagent':
        reportagent_selectagent($_POST['aid']);
        break;
    case 'agent_show':
        agent_show($_POST['aid'], $_POST['agenttype'], $_POST['agentsortby'], $_POST['fromdate'], $_POST['todate']);
        break;
    case 'transaction_show':
        transaction_show($_POST['transtype'], $_POST['transsortby'], $_POST['fromdate'], $_POST['todate']);
        break;
    case 'accounting_show':
        accounting_show($_POST['accttype'], $_POST['acctsortby'], $_POST['fromdate'], $_POST['todate']);
        break;
    case 'printexcel':
        printexcel();
        break;
}
// agent
function agent_getnamelist()
{
    // echo 'Dung le:1|Ty Nguyen:2';
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT afirst_name,alast_name,aid FROM agent where astatus=1 order by alevel DESC";
    $result = $conn->query($sql);
    $out = '';
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $out .= $row['afirst_name'] . ' ' . $row['alast_name'] . ':' . $row['aid'] . '|';
    }
    echo $out;
    $conn->close();
}

function reportagent_selectagent($aid)
{
    // echo $aid;
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM agent where aid='{$aid}'";
    $result = $conn->query($sql);
    $out = '';
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // show agent info
        $out = 'ID:' . $aid . '</br>';
        $out .= $row['afirst_name'] . ' ' . $row['alast_name'] . '</br>';
        $out .= $row['aphone'] . '</br>';
        $out .= strtoupper($row['aaddress']) . '</br>';
        $out .= $row['acity'] . ', ' . $row['aprovince'] . '</br>';
        $out .= strtoupper($row['azip']) . '</br>';
        $out .= 'Level ' . $row['alevel'] . '%</br>';
    }
    echo $out;
    $conn->close();
}
// AgentTab
function agent_show($aid, $showtype, $sortby, $fromdate, $todate)
{
    //echo $aid . ' ' . $showtype . ' ' . $sortby . ' ' . $fromdate . ' ' . $todate . '</br>';
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $alevel=0;
    // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
    if ($showtype == 0) {
        // set sortby status
        switch ($sortby) {
            case '0':
                // $sortby='transaction.id';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                inner join agent on agent.aid = transaction.agent_id
                where transaction.agent_id='{$aid}'  and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}'  order by transaction.id";
                break;
            case '1':
                // $sortby='transaction.status';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                inner join agent on agent.aid = transaction.agent_id
                where transaction.agent_id='{$aid}'  and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.transaction_status";
                break;
            case '2':
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
            inner join customer on customer.cid = transaction.customer_id
            inner join receiver on receiver.rid = transaction.receiver_id
            inner join agent on agent.aid = transaction.agent_id
            where transaction.agent_id='{$aid}'  and
            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date";
                break;
            case '3':
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
            inner join customer on customer.cid = transaction.customer_id
            inner join receiver on receiver.rid = transaction.receiver_id
            inner join agent on agent.aid = transaction.agent_id
            where transaction.agent_id='{$aid}' and
            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.total_amount";
                break;
            case '4':
                // $sortby='receiver.rtp_tinh';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
            inner join customer on customer.cid = transaction.customer_id
            inner join receiver on receiver.rid = transaction.receiver_id
            inner join agent on agent.aid = transaction.agent_id
            where transaction.agent_id='{$aid}' and
            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by receiver.rtp_tinh";
                break;
        }
    } else {
        // set sortby status
        switch ($sortby) {
            case '0':
                // $sortby='transaction.id';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where transaction.agent_id='{$aid}' and transaction.transaction_status='{$showtype}' and
        transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.id";
                break;
            case '1':
                // $sortby='transaction.status';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                inner join agent on agent.aid = transaction.agent_id
                where transaction.agent_id='{$aid}' and transaction.transaction_status='{$showtype}' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.transaction_status";
                break;
            case '2':
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where transaction.agent_id='{$aid}' and transaction.transaction_status='{$showtype}' and
        transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date";
                break;
            case '3':
                // $sortby='transaction.total_amount';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where transaction.agent_id='{$aid}' and transaction.transaction_status='{$showtype}' and
        transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.total_amount";
                break;
            case '4':
                // $sortby='receiver.rtp_tinh';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
        inner join customer on customer.cid = transaction.customer_id
        inner join receiver on receiver.rid = transaction.receiver_id
        inner join agent on agent.aid = transaction.agent_id
        where transaction.agent_id='{$aid}' and transaction.transaction_status='{$showtype}' and
        transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by receiver.rtp_tinh";
                break;
        }
    }
   //echo $sql;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // printjscript();
        // ----------------------------------------        ?>
<style>
._c {
	text-align: Center;
	padding: 1px 2px 1px 2px;
	font: 12px Verdana, Arial, Helvetica, sans-serif;
	border-bottom: solid 1px #ccc;
}

._x {
	text-align: left;
	padding: 1px 1px 1px 3px;
	font: 12px Verdana, Arial, Helvetica, sans-serif;
	border-bottom: solid 1px #ccc;
}
.space{padding: 10px;}
._aborder (border: solid 1px #FFF;)
.bgr { background-color: #CCCCCC;}

</style>

<table width="100%" cellspacing="1" cellpadding="1"> 
	<tr><td>&nbsp;</td>
		<td colspan="7">&nbsp;</td>
	</tr>
	<tr>
		<td align="center">TrN #</td>
		<td>Customer</td>
		<td>Receiver</td>
		<td align="center">Amount</td>
		<td>Type</td>
		<td align="center">Date</td>
		<td align="center">Status</td>
		<td align="center">Fee</td>
	</tr>
            <?php
        // ---------------- Agent Sorting 		 <?php echo " $aid" afirst_name'] . ' ' . $row['alast_name
        
        // output data of each row                            <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . printtptinh($row["rtp_tinh"]) ." </td>
				// ". $aid . " === display agent number
        $index = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
							<td class=\"_c\" >" . $row["id"] . "</td>
                            <td class=\"_x\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["clast_name"] . ", " . $row["cfirst_name"] . "</td>
                            <td class=\"_x\" style=\"text-transform:uppercase\">" . $row["rlast_name"] . ", " . $row["rfirst_name"] . "</td>
                            <td class=\"_c\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                            <td class=\"_c\" nowrap=\"nowrap\"> " . _showcurrencytype($row["local_currency_type"]) . "</td>
                            <td class=\"_c\" nowrap=\"nowrap\">" . substr($row["created_date"], 0, 10) . "</td>
                            <td class=\"_c\" >" . _status($row["transaction_status"]) . "</td>
							<td class=\"_c\" nowrap=\"nowrap\">" . $row["fee_charge"] . "</td>
							</tr>";
            $index ++;
            $alevel=$row['alevel'];
            
        }
        
        echo "</table>|";
    } else {
        echo "0 results|";
    }
    // get fee report
    if($showtype!=0){
        $sql = "select
    	           sum(local_amount) as Slocalamount_new,
    	           sum(fee_charge) as Sfee_new
                   from transaction where transaction.agent_id='{$_POST['aid']}'AND transaction.created_date BETWEEN '{$fromdate}' and '{$todate}'  
                    and transaction_status='{$showtype}'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo    'TOTAL:'. _f($row["Slocalamount_new"]) . '</br>'.
                    'fee:'._f($row["Sfee_new"]);
        }
    }else{
        $sql = "select
        sum(local_amount) as Slocalamount_new,
        sum(fee_charge) as Sfee_new
        from transaction where transaction.agent_id='{$_POST['aid']}'AND transaction.created_date BETWEEN '{$fromdate}' and '{$todate}'
        and transaction_status!=5";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalamount=$row["Slocalamount_new"];
        $balance=$totalamount+$row["Sfee_new"]* (1-($alevel/100));
        echo 'ACCOUNT BALANCE'.'</br>';
        echo 'total:'. _f($row["Slocalamount_new"]) . '</br>'.
        'fee:'._f($row["Sfee_new"]).'</br>'.
        'commission:'. _f($row["Sfee_new"]* $alevel/100) .'</br>'.
        'BALANCE:'._f($balance);
        }
    }
    $conn->close();
}

// TransactionTab
function transaction_show($showtype, $sortby, $fromdate, $todate)
{
    // echo $showtype.' '.$sortby.' '.$fromdate.' '.$todate.'</br>';
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
    if ($showtype == 0) {
        // set sortby status
        switch ($sortby) {
            case '0':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                inner join agent on agent.aid = transaction.agent_id
                where agent.astatus=1  and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}'  order by transaction.id";
                break;
            case '2':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
    	        inner join customer on customer.cid = transaction.customer_id
    	        inner join receiver on receiver.rid = transaction.receiver_id
    	        inner join agent on agent.aid = transaction.agent_id
    	        where agent.astatus=1  and
    	        transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date";
                break;
            case '3':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
    	        inner join customer on customer.cid = transaction.customer_id
    	        inner join receiver on receiver.rid = transaction.receiver_id
    	        inner join agent on agent.aid = transaction.agent_id
    	        where agent.astatus=1  and
    	        transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.total_amount";
                break;
            case '4':
                
                // $sortby='receiver.rtp_tinh';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
	            inner join customer on customer.cid = transaction.customer_id
	            inner join receiver on receiver.rid = transaction.receiver_id
	            inner join agent on agent.aid = transaction.agent_id
	            where agent.astatus=1 and
	            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by receiver.rtp_tinh";
                break;
        }
    } else {
        // set sortby status
        switch ($sortby) {
            case '0':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                inner join agent on agent.aid = transaction.agent_id
                where agent.astatus=1 and transaction.transaction_status='{$showtype}' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.id";
                break;
            case '2':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
	            inner join customer on customer.cid = transaction.customer_id
	            inner join receiver on receiver.rid = transaction.receiver_id
	            inner join agent on agent.aid = transaction.agent_id
	            where agent.astatus=1 and transaction.transaction_status='{$showtype}' and 
	            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date";
                break;
            case '3':
                
                // $sortby='transaction.total_amount';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
	            inner join customer on customer.cid = transaction.customer_id
	            inner join receiver on receiver.rid = transaction.receiver_id
	            inner join agent on agent.aid = transaction.agent_id
	            where agent.astatus=1 and transaction.transaction_status='{$showtype}' and 
	            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.total_amount";
                break;
            case '4':
                
                // $sortby='receiver.rtp_tinh';
                $sql = "select customer.*, transaction.*, receiver.*, agent.* from transaction
	            inner join customer on customer.cid = transaction.customer_id
	            inner join receiver on receiver.rid = transaction.receiver_id
	            inner join agent on agent.aid = transaction.agent_id
	            where agent.astatus=1 and transaction.transaction_status='{$showtype}' and 
	            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by receiver.rtp_tinh";
                break;
        }
    }
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // printjscript();
        // ----------------------------------------        ?>
<style>
._R {
	text-align: right;
	padding: 1px 1px 1px 1px;
	border-bottom: solid 1px #ccc;
	font: normal 10px Verdana, Arial, Helvetica, sans-serif;

}
._L {
	text-align: Left;
	padding: 1px 1px 1px 1px;
	border-bottom: solid 1px #ccc;
	text-transform: Uppgercase;
	font: normal 10px Verdana, Arial, Helvetica, sans-serif;
}

._kk {
	text-align: center;
	padding: 1px 1px 1px 1px;
	border-bottom: solid 1px #ccc;
	font: normal 10px Verdana, Arial, Helvetica, sans-serif;
}
.h_ {
	text-align: center;
	padding: 0px 4px 0px 5px;
	background-color: #CCCCCC;
	border-bottom: solid 1px #666666;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}
.jj {
	text-align: center;
	border-right: solid 1px #ccc;
	border-bottom: solid 1px #666666;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}
.j1 {
	text-align: center;
	border-bottom: solid 1px #ccc;
	font: normal 12px Verdana, Arial, Helvetica, sans-serif;
}
</style>
	<table width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr><td colspan="2" class="h_">Open Bal.</td>
			<td class="h_">Wired</td>
			<td class="h_">Sent Amount</td>
			<td class="h_">Home</td>
			<td colspan="2" class="h_">Counter</td>
			<td class="h_">Close Bal.</td>
			<td class="h_">Fee</td>
		</tr>
		<tr>
			<td colspan="2" class="j1"><div>'</div><div>'</div></td>
			<td class="j1"><div>'</div><div>'</div></td>
			<td class="j1"><div>=SUMIF(G7:G600,"USD",F7:F600)</div><div>=SUMIF(G7:G600,"CAD",F7:F600)</div></td>
			<td class="j1"><div>=SUMIFS(F7:F600,G7:G600,"USD",H7:H600,"Chi nh?")*0.0055</div><div>=SUMIFS(F7:F600,G7:G600,"CAD",H7:H600,"Chi nh?")*0.0055</div></td>
			<td class="j1"><div>=SUMIFS(F7:F600,G7:G600,"USD",H7:H600,"Chi qu?y")*0.0025</div><div>=SUMIFS(F7:F600,G7:G600,"CAD",H7:H600,"Chi qu?y")*0.0025</div></td>
			<td class="j1"><div>USD</div><div>CAD</div></td>
			<td class="j1"><div>=IFERROR((A2+C2)-(D2+E2+F2)," ")</div><div>=IFERROR((C3+A3)-(D3+E3+F3)," ")</div></td>
			<td class="j1"><div>=IF(D2>0,SUMIF(G7:G600,"USD",I7:I600)," ")</div><div>=IF(D3>0,SUMIF(G7:G600,"CAD",I7:I600)," ")</div></td>

		</tr>
 		<tr>
			<td colspan="2" class="jj"><div>="8: "&SUMIF(B7:B600,"8",I7:I600)*.5</div><div>="24: "&SUMIF(B7:B600,"24",I7:I600)*.4</div></td>
			<td class="jj"><div>="18: "&SUMIF(B7:B600,"18",I7:I600)*.35</div><div>="20: "&SUMIF(B7:B600,"20",I7:I600)*.35</div></td>
			<td class="jj"><div>="22: "&SUMIF(B7:B600,"22",I7:I600)*.5</div><div>="29: "&SUMIF(B7:B600,"29",I7:I600)*.35</div></td>
			
			<td class="jj" style="background-color:#E0FFFF;"><div>="All% "&SUM((SUMIF(B7:B600,"22",I7:I600)*0.5)+(SUMIF(B7:B600,"18",I7:I600)*0.3)
				+(SUMIF(B7:B600,"8",I7:I600)*0.45)+(SUMIF(B7:B600,"29",I7:I600)*0.35)+(SUMIF(B7:B600,"20",I7:I600)*0.35)+(SUMIF(B7:B600,"23",I7:I600)*0.3)
					+(SUMIF(B7:B600,"24",I7:I600)*0.4)+(SUMIF(B7:B600,"27",I7:I600)*0.35)+(SUMIF(B7:B600,"29",I7:I600)*0.35)
						+(SUMIF(B7:B600,"33",I7:I600)*0.3)+(SUMIF(B7:B600,"32",I7:I600)*0.3)+(SUMIF(B7:B600,"31",I7:I600)*0.3))</div>
					<div>="C:"&I3-SUM((SUMIF(B7:B600,"22",I7:I600)*0.45)+(SUMIF(B7:B600,"18",I7:I600)*0.3)
				+(SUMIF(B7:B600,"8",I7:I600)*0.45)+(SUMIF(B7:B600,"29",I7:I600)*0.35)+(SUMIF(B7:B600,"20",I7:I600)*0.35)+(SUMIF(B7:B600,"23",I7:I600)*0.3)
					+(SUMIF(B7:B600,"24",I7:I600)*0.4)+(SUMIF(B7:B600,"27",I7:I600)*0.35)+(SUMIF(B7:B600,"29",I7:I600)*0.35)
						+(SUMIF(B7:B600,"33",I7:I600)*0.3)+(SUMIF(B7:B600,"32",I7:I600)*0.3)+(SUMIF(B7:B600,"31",I7:I600)*0.3))-E3-F3</div></td>
			
			<td colspan="2" class="jj"><div>="23: "&SUMIF(B7:B600,"23",I7:I600)*.3</div><div>="27: "&SUMIF(B7:B600,"27",I7:I600)*.35</div></td>
			<td class="jj"><div>="31: "&SUMIF(B7:B600,"31",I7:I600)*.3</div></td>
			<td class="jj"><div>="32: "&SUMIF(B7:B600,"32",I7:I600)*.3</div><div>="33: "&SUMIF(B7:B600,"33",I7:I600)*.3</div></td>
		</tr>		
		<tr>
			<td class="h_" width="50">=COUNTIF(F4:F600,">1")</td>
			<td class="h_" width="40">ID</td>
			<td class="h_" width="90">Date</td>
			<td class="h_" width="135">Customer</td>
			<td class="h_" width="145">Receiver</td>
			<td class="h_" width="68">Amount</td>
			<td class="h_" width="36">Type</td>
			<td class="h_" width="75">Method</td>
			<td class="h_" width="70">Fee</td>
		</tr>			

		
           <?php
        // 			<td class="h_">Ng&#432;&#7901;i G&#7919;i</td>
		//					<td class="h">#</td>
		//	<td class="h">agent</td>
		//	<td class="h">Customer</td>
		//	<td class="h">Receiver</td>
		//	<td class="h">Amount</td>
		//	<td class="h">Type</td>
		//	<td class="h">time</td>
		//	<td class="h">status</td> ------------------------------------------------------
        // output data of each row							
		//<td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . printtptinh($row["rtp_tinh"]) . "</td>
	
		// remove address and receiver info  <br/> Phone: ". $row["rphone1"]."<br/>" . $row["rdiachi"] . "<br/>" . $row["remail"] . "
         //               <td valign=\"top\" class=\"_R\" nowrap=\"nowrap\">" . printtptinh($row["rtp_tinh"]) . "</td>
		 // <td valign=\"top\" class=\"_L\" nowrap=\"nowrap\" style=\"text-transform:uppercase\">" . $row["cfirst_name"] . ", " . $row["clast_name"] . "</td>

        $index = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
					    <td class=\"_kk\" nowrap=\"nowrap\">" .$row["id"]. "</td> 
					    <td class=\"_kk\" nowrap=\"nowrap\">" . $row["aid"] . "</td> 
						<td class=\"_kk\" nowrap=\"nowrap\">" . substr($row["created_date"], 0, 10) . "</td>
						<td class=\"_L\" nowrap=\"nowrap\">" . $row["cfirst_name"] . ", " . $row["clast_name"] . "</td>
                        <td class=\"_L\" nowrap=\"nowrap\">" . $row["rfirst_name"] . ", " . $row["rlast_name"] . "</td>
                        <td class=\"_kk\" nowrap=\"nowrap\">" . _f($row["local_amount"]) . "</td>
                        <td class=\"_kk\" nowrap=\"nowrap\">" . _showcurrencytype($row["local_currency_type"]) . "</td>
                        <td class=\"_kk\" nowrap=\"nowrap\">" . printdeliverymethod($row["delivery_method"]) . "</td>
						<td class=\"_kk\" nowrap=\"nowrap\">" . $row["fee_charge"] . "</td>

				</tr>";
            $index ++;
        }
        
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
}
						//  <td class=\"_L\" >" . $row["id"] . "</td>
                        //   <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["afirst_name"] . "</br></td>
                        //    <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["cfirst_name"] . "</br><sub>" . $row["clast_name"] . "</sub></td>
                        //    <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["rfirst_name"] . "</br><sub>" . $row["rlast_name"] . "</sub></td>
                        //    <td valign=\"top\" class=\"_R\" nowrap=\"nowrap\"> " . _showcurrencytype($row["local_currency_type"]) . "</td>
                        //    <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                        //    <td class=\"_R\" nowrap=\"nowrap\">" . substr($row["created_date"], 0, 10) . "</td>
                        //    <td class=\"_R\" >" . _status($row["transaction_status"]) . "</td>

						

// accounting
function accounting_show($showtype, $sortby, $fromdate, $todate)
{
    // echo $showtype.' '.$sortby.' '.$fromdate.' '.$todate.'</br>';
    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // $sql = "SELECT * FROM transaction where agent_id='{$_SESSION['user_id']}'";
    if ($showtype == 0) {
        // set sortby status
        switch ($sortby) {
            case '0':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where 
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}'  order by transaction.id";
                break;
            case '2':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where 
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date";
                break;
            case '3':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where 
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.total_amount";
                break;
            case '4':
                
                // $sortby='receiver.rtp_tinh';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where 
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by receiver.rtp_tinh";
                break;
        }
    } else if ($showtype == 7) {
    // set sortby status //$1000
        switch ($sortby) {
            case '0':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.total_amount > '1000' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.id";
                break;
            case '2':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.total_amount > '1000' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date";
                break;
            case '3':
                
                // $sortby='transaction.total_amount';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.total_amount > '1000' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.total_amount";
                break;
            case '4':
                
                // $sortby='receiver.rtp_tinh';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.total_amount > '1000' and
            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by receiver.rtp_tinh";
                break;
        }
    } else if ($showtype == 8) {
    // set sortby status //$1000
        switch ($sortby) {
            case '0':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.total_amount > '3000' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.id";
                break;
            case '2':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.total_amount > '3000' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date";
                break;
            case '3':
                
                // $sortby='transaction.total_amount';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.total_amount > '3000' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.total_amount";
                break;
            case '4':
                
                // $sortby='receiver.rtp_tinh';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.total_amount > '3000' and
            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by receiver.rtp_tinh";
                break;
        }
    } 
    else {
        // set sortby status
        switch ($sortby) {
            case '0':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.transaction_status='{$showtype}' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.id";
                break;
            case '2':
                
                // $sortby='transaction.created_date';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.transaction_status='{$showtype}' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.created_date";
                break;
            case '3':
                
                // $sortby='transaction.total_amount';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.transaction_status='{$showtype}' and
                transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by transaction.total_amount";
                break;
            case '4':
                
                // $sortby='receiver.rtp_tinh';
                $sql = "select customer.*, transaction.*, receiver.* from transaction
                inner join customer on customer.cid = transaction.customer_id
                inner join receiver on receiver.rid = transaction.receiver_id
                where transaction.transaction_status='{$showtype}' and
            transaction.created_date BETWEEN '{$fromdate}' and '{$todate}' order by receiver.rtp_tinh";
                break;
        }
    }
    $result = $conn->query($sql);
    $index = 1;
    $totallocalamount=0;
    $totalfee=0;
    if ($result->num_rows > 0) {
        // printjscript();
        // ----------------------------------------        ?>
<style>
._R {
	text-align: right;
	padding: 1px 2px 1px 2px;
	border-bottom: solid 1px #ccc;
	valign:top;
}

._L,.reportexportexcelID {
	text-align: left;
	padding: 1px 3px 1px 2px;
	border-bottom: solid 1px #ccc;
	valign:top;
}
.h_ {
	text-align: center;
	padding: 0px 4px 0px 5px;
	background-color: #CCCCCC;
	border-bottom: solid 1px #666666;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}
.jj {
	text-align: center;
	border-right: solid 1px #ccc;
	border-bottom: solid 1px #666666;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}
.j1 {
	text-align: center;
	border-bottom: solid 1px #ccc;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}
</style>
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>
				<td align="center" width="45">=COUNTIF(E3:E600,">1")</td>
				<td align="center" width="96"><div>=COUNTIFS(E3:E600,">1",F3:F600,"USD")</div><div>=COUNTIFS(E3:E600,">1",F3:F600,"CAD")</div></td>
				<td align="left" width="160"><div>="Fee USD : "&SUMIF(F4:F600,"USD",I4:I600)</div><div>="Fee CAD : "&SUMIF(F4:F600,"CAD",E4:E600)</div></td>
				<td align="left" width="200"><div>="Send USD : "&SUMIF(F4:F600,"USD",E4:E600)</div><div>="Send CAD : "&SUMIF(F4:F600,"CAD",E4:E600)</div></td>
				<td width="75">&nbsp;</td>
				<td width="40">&nbsp;</td>
				<td width="80">&nbsp;</td>
				<td width="80">&nbsp;</td>
				<td width="64">&nbsp;</td>
			</tr>			
			<tr>
				<td class="h_">#</td>
				<td class="h_">REF #</td>
				<td class="h_">Customer</td>
				<td class="h_">Receiver</td>
				<td class="h_">amount</td>
				<td class="h_">Fee</td>		
				<td class="h_">Type</td>
				<td class="h_">Date</td>
				<td class="h_">Status</td>

			</tr>
            <?php
        // ------------------------------------------------------
        
        // output data of each row
        
        
        while ($row = $result->fetch_assoc()) {
            $totallocalamount+=$row["local_amount"];
            $totalfee+=$row["fee_charge"];
            //case $1000+
            if($showtype > 6){
                echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                            <td valign=\"top\" class=\"reportexportexcelID\" >" . $row["id"] . "</td>
                            <td valign=\"top\" class=\"_L\" >" . _conumber($row["confirmation_no"]) . "</td>
                            <td valign=\"top\" class=\"_L\" style=\"text-transform:uppercase\">"
                             . $row["cfirst_name"] . ", " . $row["clast_name"] . "</br>" . $row["caddress"] . "</br>" . $row["ccity"] . "</br>" . $row["czip"] . "</td>
                            <td valign=\"top\" class=\"_L\" style=\"text-transform:uppercase\">" . $row["rfirst_name"] . ", " . $row["rlast_name"] . "
                                            </br>" . $row["rdiachi"] . "</br>" .printtptinh($row["rtp_tinh"]) . "</td>
                            <td valign=\"top\" class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . printtptinh($row["rtp_tinh"]) . "</td>
                            <td valign=\"top\" class=\"_R\" nowrap=\"nowrap\"> <sub>" . _f($row["local_amount"]) . "</sub></br></br><sub>incl fee.</sub></br>" . _f($row["total_amount"]) . "</td>
                            <td valign=\"top\" class=\"_R\" nowrap=\"nowrap\"> " . _showcurrencytype($row["local_currency_type"]) . "</td>
                            <td valign=\"top\" class=\"_R\" nowrap=\"nowrap\">" . substr($row["created_date"], 0, 10) . "</td>
                            <td valign=\"top\" class=\"_R\" >" . _status($row["transaction_status"]) . "</td></tr>";
                
            }else{
            echo "<tr class=\"row\" id=" . $row["id"] . " type=\"transaction\">
                            <td class=\"_L\" >" . $row["id"] . "</td>
                            <td class=\"_L\" >" . _conumber($row["confirmation_no"]) . "</td>
                            <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["cfirst_name"] . "</br><sub>" . $row["clast_name"] . "</sub></td>
                            <td class=\"_L\" style=\"text-transform:uppercase\" nowrap=\"nowrap\">" . $row["rfirst_name"] . "</br><sub>" . $row["rlast_name"] . "</sub></td>
                            <td class=\"_R\" nowrap=\"nowrap\"> " . _f($row["local_amount"]) . "</td>
                            <td class=\"_R\" >" . $row["fee_charge"] . "</td>
                            <td class=\"_R\" nowrap=\"nowrap\"> " . _showcurrencytype($row["local_currency_type"]) . "</td>
                            <td class=\"_R\" nowrap=\"nowrap\">" . substr($row["created_date"], 0, 10) . "</td>
                            <td class=\"_R\" >" . _status($row["transaction_status"]) . "</td>
						</tr>";
            }
            //assign global var selecttransID for print excel
            array_push($_SESSION['transID'],$row['id']);
            $index ++;
        }
        
        echo "</table>|";
    } else {
        echo "0 results|";
    }
    echo '# trans:'.($index-1).'</br>';
    echo 'total:'._f($totallocalamount).'</br>';
    echo 'fee:  '._f($totalfee);
    $conn->close();
}

function printexcel (){
   /* $arrlength= count($_SESSION['transID']);
    echo 'here'.$arrlength;
    for($x = 0; $x < $arrlength; $x++) {
        echo $_SESSION['transID'][$x];
        echo ".";
    }*/
    print_r($_SESSION['transID']);
    foreach($_SESSION['transID'] as $val) {
        echo $val." ";
    }
}
// / helper function
function cleanData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"'))
        $str = '"' . str_replace('"', '""', $str) . '"';
}

function printtptinh($tp)
{
    switch ($tp) {
        case "0":
            return 'Ch&#7885;n t&#7881;nh/th&#224;nh';
            break;
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
            return 'TP. H&#7843;i Ph&#242;ng';
            break;
        case "6":
            return 'TP. Bi&#234;n Ho&#224;';
            break;
        case "7":
            return 'TP. Nha Trang';
            break;
        case "8":
            return 'TP. C&#7847;n Th&#417;';
            break;
        case "9":
            return 'TP. C&#224; Mau';
            break;
        case "10":
            return 'TP. H&#7841; Long';
            break;
        case "11":
            return 'TP. Long Xuy&#234;n';
            break;
        case "12":
            return 'TP. Nam &#272;&#7883;nh';
            break;
        case "13":
            return 'TP. Quy Nh&#417;n';
            break;
        case "14":
            return 'TP. R&#7841;ch Gi&#225;';
            break;
        case "15":
            return 'TP. Phan Thi&#7871;t';
            break;
        case "16":
            return 'TP. Th&#225;i Nguy&#234;n';
            break;
        case "17":
            return 'TP. Vinh';
            break;
        case "18":
            return 'TP. V&#361;ng T&#224;u';
            break;
        case "19":
            return 'An Giang';
            break;
        case "20":
            return 'B&#224; R&#7883;a - V&#361;ng T&#224;u';
            break;
        case "21":
            return 'B&#7855;c Giang';
            break;
        case "22":
            return 'B&#7855;c K&#7841;n';
            break;
        case "23":
            return 'B&#7841;c Li&#234;u';
            break;
        case "24":
            return 'B&#7855;c Ninh';
            break;
        case "25":
            return 'B&#7871;n Tre';
            break;
        case "26":
            return 'B&#236;nh &#272;&#7883;nh';
            break;
        case "27":
            return 'B&#236;nh D&#432;&#417;ng';
            break;
        case "28":
            return 'B&#236;nh Ph&#432;&#7899;c';
            break;
        case "29":
            return 'B&#236;nh Thu&#7853;n';
            break;
        case "30":
            return 'Bu&#244;n Ma Thu&#7897;t';
            break;
        case "31":
            return 'Cao B&#7857;ng';
            break;
        case "32":
            return '&#272;&#7855;c L&#7855;k';
            break;
        case "33":
            return '&#272;&#7855;c N&#244;ng';
            break;
        case "34":
            return '&#272;i&#7879;n Bi&#234;n';
            break;
        case "35":
            return '&#272;&#7891;ng Nai';
            break;
        case "36":
            return '&#272;&#7891;ng Th&#225;p';
            break;
        case "37":
            return 'Gia Lai';
            break;
        case "38":
            return 'H&#224; Giang';
            break;
        case "39":
            return 'H&#224; Nam';
            break;
        case "40":
            return 'H&#224; T&#297;nh';
            break;
        case "41":
            return 'H&#7843;i D&#432;&#417;ng';
            break;
        case "42":
            return 'H&#7853;u Giang';
            break;
        case "43":
            return 'Ho&#224; B&#236;nh';
            break;
        case "44":
            return 'H&#432;ng Y&#234;n';
            break;
        case "45":
            return 'Kh&#225;nh Ho&#224;';
            break;
        case "46":
            return 'Ki&#234;n Giang';
            break;
        case "47":
            return 'Kon Tum';
            break;
        case "48":
            return 'Lai Ch&#226;u';
            break;
        case "49":
            return 'L&#226;m &#272;&#7891;ng';
            break;
        case "50":
            return 'L&#7841;ng S&#417;n';
            break;
        case "51":
            return 'L&#224;o Cai';
            break;
        case "52":
            return 'Long An';
            break;
        case "53":
            return 'Ngh&#7879; An';
            break;
        case "54":
            return 'Ninh B&#236;nh';
            break;
        case "55":
            return 'Ninh Thu&#7853;n';
            break;
        case "56":
            return 'Ph&#250; Th&#7885;';
            break;
        case "57":
            return 'Ph&#250; Y&#234;n';
            break;
        case "58":
            return 'Qu&#7843;ng B&#236;nh';
            break;
        case "59":
            return 'Qu&#7843;ng Nam';
            break;
        case "60":
            return 'Qu&#7843;ng Ng&#227;i';
            break;
        case "61":
            return 'Qu&#7843;ng Ninh';
            break;
        case "62":
            return 'Qu&#7843;ng Tr&#7883;';
            break;
        case "63":
            return 'S&#243;c Tr&#259;ng';
            break;
        case "64":
            return 'S&#417;n La';
            break;
        case "65":
            return 'T&#226;y Ninh';
            break;
        case "66":
            return 'Th&#225;i B&#236;nh';
            break;
        case "67":
            return 'Thanh Ho&#225;';
            break;
        case "68":
            return 'Th&#7911; D&#7847;u M&#7897;t';
            break;
        case "69":
            return 'Th&#7915;a Thi&#234;n Hu&#7871;';
            break;
        case "70":
            return 'Ti&#7873;n Giang';
            break;
        case "71":
            return 'Tr&#224; Vinh';
            break;
        case "72":
            return 'Tuy&#234;n Quang';
            break;
        case "73":
            return 'V&#297;nh Long';
            break;
        case "74":
            return 'V&#297;nh Ph&#432;&#7899;c';
            break;
        case "75":
            return 'Y&#234;n B&#225;i';
            break;
    }
}

function printdeliverymethod($input)
{
    switch ($input) {
        case "0":
            return "Chi nh&#224;";
            break;
        case "1":
            return "Chi Qu&#7847;y";
            break;
        case "2":
            return "Chuy&#7875;n Kho&#7843;n";
            break;
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

function _c($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function _scheck($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = str_replace(".", "", $data);
    $data = str_replace("'", "''", $data);
    return $data;
}

function _conumber($data)
{
    $temp = substr($data, - 10, 10);
    return $temp;
}

function _f($number)
{
    $number = (float) $number;
    setlocale(LC_MONETARY, 'en_US');
    // $temp = money_format('%(#10n', $number);
    $temp = number_format($number, 2, '.', '');
    return '$' . $temp;
}
function _showcurrencytype($input){
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
?>

