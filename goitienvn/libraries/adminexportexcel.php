<?php
include_once '../config/connect.php';

function cleanData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"'))
        $str = '"' . str_replace('"', '""', $str) . '"';
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
function printdeliverymethod($input){
    switch ($input){
        case "0":return "Chi Nh&#224;"; break;
        case "1":return "Chi Qu&#7847;y";break;
        case "2":return "Chuy&#7875;n Kho&#7843;n";break;
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
function _scheck($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = str_replace(".","",$data);
    $data = str_replace("'","''",$data);
    return $data;
}
function _conumber($data){
    $temp =  substr($data, - 10, 10);
    return $temp;
}
function _f($number)
{
    $number = (float)$number;
    setlocale(LC_MONETARY, 'en_US');
    //$temp = money_format('%(#10n', $number);
    $temp = number_format($number, 2, '.', '');
    return '$'.$temp;
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

//new versions//
/*
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
					<table width="800" border="0" cellspacing="2" cellpadding="3">
						<tr>
							<td colspan="2"class="_R_"></td>
							<td colspan="3" valign="top" class="_L_">TY PC-TECH -
								MONEY TRANSFER<br />6599 Avenue Du Parc<br />Montreal, QC. H2V
								4J1<br>514 658 6678
							</td>
							<td colspan="2" valign="top" class="_L_"><?php echo date("d/m/Y");?></td>
						</tr>
						<tr>
							<td class="h_" valign=\"top\">#</td>
							<td class="h_" valign=\"top\">M&#227; S&#7889;</td>
							<td class="h_" valign=\"top\">Ng&#432;&#7901;i G&#7919;i</td>
							<td class="h_" valign=\"top\">Ng&#432;&#7901;i Nh&#7853;n</td>
							<td class="h_" valign=\"top\">S&#7889; Ti&#7873;n</td>
							<td class="h_" valign=\"top\">fee</td>
							<td class="h_" valign=\"top\">Ng&#224;y g&#7919;i</td>
						</tr>
        <?php
            // output data of each row
            $totalsend=0;
            $index=1;
            $sumfee=0;
            while ($row = $result->fetch_assoc()) {
                $totalsend+=$row["local_amount"];
                $sumfee+=$row["fee_charge"];
                echo "<tr ><td class=\"_L_\"  valign=\"top\" >".$row["id"]."</td><td class=\"_L_\" valign=\"top\">". _conumber($row['confirmation_no'])."</td>
                        <td valign=\"top\" class=\"_L_\" style=\"text-transform:uppercase\">" . $row["cfirst_name"] . ", " . $row["clast_name"] . "</td>
                        <td valign=\"top\" class=\"_L_\" style=\"text-transform:uppercase\">" . $row["rfirst_name"] . ", " . $row["rlast_name"] . "<br/>
                        ". $row["rphone1"]."</td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"><b> " . _f($row["local_amount"]) . "</b></td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"> " ._f($row["fee_charge"]) . "</td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\">" .  substr($row["created_date"],0,10) . "</td>
                     </tr>";
               $index++;
            }
            echo "<tr>
                        <td class=\"_L_\">&nbsp;</td>
                        <td class=\"_L_\">&nbsp;</td>
                        <td class=\"_L_\">&nbsp;</td>
                        <td valign=\"top\" class=\"_R_\"><b>Fee:</b></td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"><div id=\"send_total\"><b>"._f($sumfee)."</b></div></td>
                        <td valign=\"top\" class=\"_L_\"><div id=\"send_currency\"><b>CAN</b></div></td>
                        <td class=\"_L_\">&nbsp;</td>
                      </tr>
                    <tr>
                        <td class=\"_L_\">&nbsp;</td>
                        <td class=\"_L_\">&nbsp;</td>
                        <td class=\"_L_\">&nbsp;</td>
                        <td valign=\"top\" class=\"_R_\"><b>T&#7893;ng C&#7897;ng:</b></td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"><div id=\"send_total\"><b>"._f($totalsend)."</b></div></td>
                        <td valign=\"top\" class=\"_L_\"><div id=\"send_currency\"><b>CAN</b></div></td>
                        <td class=\"_L_\">&nbsp;</td>
                      </tr>";
            echo "</table></div>";
        } else {
            echo "0 results";
        }
        $conn->close();
exit();
*/
//old version
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
._c_ {
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
.bg{
	background-color:yellow;
	color:red;
	font: bold 11px Verdana, Arial, Helvetica, sans-serif;
}
.red{
	color:red;
	font: bold 11px Verdana, Arial, Helvetica, sans-serif;
}
.tt{
	text-align: left;
	padding: 2px 3px 2px 2px;
	font: bold 12px Verdana, Arial, Helvetica, sans-serif;
	border-bottom: solid 1px #666;
}
</style><div id="printdiv">
					<table width="800px" border="0" cellspacing="2" cellpadding="3">
						<tr><td width="130"><?php echo " ";?></td><td width="145"><?php echo " ";?></td><td width="210"><?php echo " ";?></td><td width="95"><?php echo " ";?></td>
							<td width="70"><?php echo " ";?></td><td width="35"><?php echo " ";?></td><td width="59"><?php echo " ";?></td><td width="100"><?php echo " ";?></td>
						</tr>
						<tr>
							<td colspan="2" class="tt">
								<div>TY PC-TECH INC.</div>
								<div>&nbsp;Tel: 514-658-6678</div>
								<div>&nbsp;6599 Avenue Du Park</div></td>
							<td class="_R_">&nbsp;</td>
							<td valign="top" class="_R_"><div>&nbsp;</div><div><b>T&#7893;ng C&#7897;ng: </b></div><div>&nbsp;</div></td>
							<td class="_R_">
								
								<div><b>=sumif(F6:F66, "USD",E6:E66)</b></div>
								<div><b>=sumif(F6:F66, "CAD",E6:E66)</b></div>
							</td>							
							<td class="_R_"><div><b>USD</b></div><div><b>CAD</b></div></td>
							<td colspan="2" valign="top" class="_R_"><?php echo date("d/m/Y");?></td>
						</tr>
						<!-- remove STT <td class="h_" valign=\"top\">STT</td> -->
						<tr>
							<td class="h_" valign=\"top\">STT + M&#227; S&#7889;</td>
							<td class="h_" valign=\"top\">Ng&#432;&#7901;i G&#7919;i</td>
							<td class="h_" valign=\"top\">Ng&#432;&#7901;i Nh&#7853;n</td>
							<td class="h_" valign=\"top\">TP/Tinh</td>
							<td class="h_" valign=\"top\">S&#7889; Ti&#7873;n</td>
							<td class="h_" valign=\"top\">Ti&#7873;n</td>
							<td class="h_" valign=\"top\">Chi Tr&#7843;</td>
							<td class="h_" valign=\"top\">MSG - Luu Y</td>
						</tr>
        <?php
            // output data of each row
			// remove the STT <td class=\"_L_\"  valign=\"top\" >".$row["id"]."</td>
            
            $totalsend=0;
            $index=1;
            while ($row = $result->fetch_assoc()) {
                $totalsend+=$row["local_amount"];
                echo "<tr >
                        
                        <td valign=\"top\" class=\"_L_\" nowrap=\"nowrap\"><span class=\"red\">".$row["id"]."</span>-"._conumber($row['confirmation_no'])."" . $row["aid"] . "</td>
                        <td valign=\"top\" class=\"_L_\" style=\"text-transform:uppercase\">" . $row["cfirst_name"] . ", " . $row["clast_name"] . "</td>
                        <td valign=\"top\" class=\"_L_\" style=\"text-transform:uppercase\">" . $row["rfirst_name"] . ", " . $row["rlast_name"] . "<br/>
                        DT: ". $row["rphone1"]."<br/>" . $row["rdiachi"] . "<br/>" . $row["remail"] . "</td>
						
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"> " . printtptinh($row["rtp_tinh"]) . "</td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"><b> " . _f($row["local_amount"]) . "</b></td>
                        <td valign=\"top\" class=\"_L_\" nowrap=\"nowrap\"><b> " . _showcurrencytype($row["local_currency_type"]) . "</b></td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\">" . printdeliverymethod($row["delivery_method"]) . "</td>
                        <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\">&nbsp;</td>
                     </tr>";
               $index++;
			   // show date testing to curr.   original<td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\">" .  substr($row["created_date"],0,10) . "</td>
			   // <td class=\"_L_\">=sumif(F4:F20,A20,E4:E20)</td>
               //   <td class=\"_L_\">&nbsp;</td>
               //         <td valign=\"top\" class=\"_R_\"><b>T&#7893;ng C&#7897;ng:</b></td>
               //         <td valign=\"top\" class=\"_R_\" nowrap=\"nowrap\"><div id=\"send_total\"><b>"._f($totalsend)."</b></div></td>
               //         <td valign=\"top\" class=\"_L_\"><div id=\"send_currency\"><b>CAD</b></div></td>
               //         <td class=\"_L_\">&nbsp;</td>
               //         <td class=\"_L_\">&nbsp;</td>
				//	echo "<tr><td class=\"_R_\">&nbsp;</td>
				//	</tr>";
				//
				//
				//
				//
            }
            
            echo "</table></div>";
        } else {
            echo "0 results";
        }
        $conn->close();
exit();
?>