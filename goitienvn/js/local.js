/**
 * 
 */
$(document).ready(function() {
	//transaction attachment
	$("#viewattachment").click(function(){
		var fileInput= document.getElementById("transactionattachment");
		var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
		$(this).html('<img src="'+fileUrl+'" width="300" height="150"/>');
	});
	
	
	$("#transaction_fromdatepicker,#transaction_todatepicker,#report_fromdatepicker,#report_todatepicker").datepicker();
	$("#transaction_datesubmit").click(function(){
		var fromdate=$("#transaction_fromdatepicker").val();
		var todate  =$("#transaction_todatepicker").val();
		//check empty
		if(fromdate =='' && todate==''){
			alert('please select from - to date');
		}else{
			fromdate=fromdate.substring(6,10)+'/'+fromdate.substring(0,5);
			todate=todate.substring(6,10)+'/'+todate.substring(0,5);
			$.ajax({
				type : "POST",
				url : "libraries/local.php",
				data : {
					type : "transactionsearchbyfromtodate",fromdate:fromdate,todate:todate,aid:$("#agentid").val()
				},
				cache : false,
				success : function(result) {
						$("#transactionpane").html(result);
					}
			});
		}
	});
	
	 $("#dialog-confirm").dialog({
		 				autoOpen: false,
						resizable : false,
						width:800,
						height:600,
						modal : true,
						buttons : {
							"Print transaction" : function() {
								var myWindow = window.open("", "myWindow");
					    	    myWindow.document.write($(this).html());
					    	    myWindow.print();
					    	    myWindow.close();
					    	    location.reload();
							},
							"Cancel / close" :function() {
								$(this).dialog("close");
								location.reload();
							}
						}
					});
	$( "#tabs" ).tabs();
	$.ajaxSetup({ cache: false });
	$("#tab-customer").click(function(){listdata('listcustomer');$("#customerinfo").html('');});
	$("#tab-receiver").click(function(){listdata('listreceiver');$("#receiverinfo").html('');});
	//$("#tab-transaction").click(function(){listdata('listtransaction');});
	$("#transaction_listall").click(function(){listdata('listtransaction');});
	//$("#tab-report").click(function(){listdata('reportlistall');});
	//modify report function version 2
	$("#report_listall").click(function(){
		var fromdate=$("#report_fromdatepicker").val();
		var todate  =$("#report_todatepicker").val();
		//check empty
		if(fromdate =='' && todate==''){
			alert('please select from - to report date');
		}else{
			fromdate=fromdate.substring(6,10)+'/'+fromdate.substring(0,5);
			todate=todate.substring(6,10)+'/'+todate.substring(0,5);
			//alert($("#report_showtype").val());
			$.ajax({
				type : "POST",
				url : "libraries/local.php",
				data : {
					type : "reportlistfromtodate",
					fromdate:fromdate,
					todate:todate,
					reportlisttype:$("#report_showtype").val(),
					aid:$("#agentid").val()
				},
				cache : false,
				success : function(result) {
						$("#reportpane").html(result);
					}
			});
		}
	});
	//$("#report_listall").click(function(){listdata('reportlistall');});

	$("#aclearfrm").click(function(){cleardatafrm();});
	$("#rclear").click(function(){clearreceiverfrm();});
	$("#cclear").click(function(){clearcustomerfrm();});
	$("#tclear").click(function(){cleartransactionfrm();});	
	
	//search
	$("#buttonsearch").click(function(){
		if($("#customersearch").val()!= ''){
			var par = $("#customersearch").val();
			if(par =='invalid'){
				alert('please verify customer phone search');
			}//
			else{
				var number = /^[0-9 ]+$/;
				var letter = /^[a-zA-Z ]+$/;
				if (par.match(number)){ //phone search
					$.ajax({
						type : "POST",
						url : "libraries/local.php",
						data : {
							type : "customerphonesearch",phone_no:par,l:par.length
						},
						cache : false,
						success : function(result) {
							var temp=result.split('|');
							$("#infobar").html(temp[0]);
							if(temp.length > 1){
								$("#receiverinfo").html(temp[1]);
							}
						}
					});
				}else if (par.match(letter)){ //name search
					$.ajax({
						type : "POST",
						url : "libraries/local.php",
						data : {
							type : "customernamesearch",name:par,aid:$("#agentid").val()
						},
						cache : false,
						success : function(result) {
							$("#customerinfo").html(result);
						}
					});
				}
				
			}
		}else if($("#receiversearch").val()!= ''){
			var par = $("#receiversearch").val();
			if(par =='invalid'){
				alert('please verify receiver input search');
			}//
			else{
				var number = /^[0-9 ]+$/;
				var letter = /^[a-zA-Z ]+$/;
				if (par.match(number)){ //phone search
					$.ajax({
						type : "POST",
						url : "libraries/local.php",
						data : {
							type : "receiverphonesearch",phone_no:par,l:par.length
						},
						cache : false,
						success : function(result) {
							var temp=result.split('|');
							$("#infobar").html(temp[0]);
							if(temp.length > 1){
								$("#customerinfo").html(temp[1]);
							}
						}
					});
				}else if (par.match(letter)){ //name search
					$.ajax({
						type : "POST",
						url : "libraries/local.php",
						data : {
							type : "receivernamesearch",name:par,aid:$("#agentid").val()
						},
						cache : false,
						success : function(result) {
							$("#receiverinfo").html(result);
						}
					});
				}
			}
		}
		else{
			alert('empty search');
		}
		
	});
	$("#customersearch").change(function(){
		var par=$(this).val();
		var temp = checksearchinput(par);
		$(this).val(temp);
		//clear other box
		$("#receiversearch").val('');
		$("#cosearch").val('');
		cleardatafrm();
	});
	$("#receiversearch").change(function(){
		var letter = /^[a-zA-Z ]+$/;
		var par=$(this).val();
		if (par.match(letter)){
			par = par.toUpperCase();
			$(this).val(par);
		}
		cleardatafrm();
		$("#cosearch").val('');
		$("#customersearch").val('');
	});
	function checksearchinput(par){
		var number = /^[0-9 ]+$/;
		var letter = /^[a-zA-Z ]+$/;
		if (par.match(number)){
			par=phone_format(par);
		}else if (par.match(letter)){
			par = par.toUpperCase();
		}else{
			par = 'invalid';
		}
		return par;	
	}
	
	///////////////////
	//transaction
	///////////////////
	$("#trans_submit").click(function(){
		var cid=$("#customerid").val();
		var rid=$("#receiverid").val();
		var tid=$("#transactionid").val();
		//var check=transactioncheck(cid,rid,tid);
		if(transactioncheck(cid,rid,tid)){
			if( !confirm('Submit the transaction?') ) 
	            event.preventDefault();
			transactionsubmit(cid, rid);
		}
	});
	
	$("#trans_print").click(function(){
		var cid=$("#customerid").val();
		var rid=$("#receiverid").val();
		var tid=$("#transactionid").val();
		var check=transactioncheck(cid,rid,tid);
		if(check){
			var dataString = '';
			dataString = getinputfrmdata('customerfrm');
			dataString = dataString+getinputfrmdata('receiverfrm');
			dataString = dataString+getinputfrmdata('transactionfrm');
			dataString = dataString+"type=printonly_transaction";
			$.ajax({
				type : "POST",
				url : "libraries/local.php",
				data : dataString,
				cache : false,
				success : function(result) {
					$("#dialog-confirm").dialog('open');
					$("#dialog-confirm").html(result);
					return result;
				}
			});
		}
	});
	function transactioncheck(cid,rid,tid){
		if(!checkinputfrmdata('customerfrm')){
			alert('please verify customer required fields');
			return false;
		}
		if(!checkinputfrmdata('receiverfrm')){
			alert('please verify receiver required fields');
			return false;
		}
		if(!checkinputfrmdata('transactionfrm')){
			alert('please verify transaction required fields');
			return false;
		}
		return true;
	}
	function transactionsubmit(cid,rid){
		var dataString = '';
		dataString = getinputfrmdata('customerfrm');
		dataString = dataString+getinputfrmdata('receiverfrm');
		dataString = dataString+getinputfrmdata('transactionfrm');
		dataString = dataString+"type=transactionsubmit&aid="+$("#agentid").val();
				$.ajax({
					type : "POST",
					url : "libraries/local.php",
					data : dataString,
					cache : false,
					success : function(result) {
						$("#dialog-confirm").dialog('open');
						$("#dialog-confirm").html(result);
						return true;
					}
		});
		return false;
	}
	//global var
	//////////////////////////////////////////////////////////////////
	//localview
	/////////////////////////////////////////////////////////////////
	function listdata(datatype){
		$.ajax({
			type : "POST",
			url : "libraries/local.php",
			data : {
				type : datatype, aid:$("#agentid").val(),report_showtype:$("#report_showtype").val()
			},
			cache : false,
			success : function(result) {
				switch(datatype){
	    		case 'listcustomer':
	    			$("#tabs-customer").html(result);
	        		break;
	    		case 'listreceiver':
	    			$("#tabs-receiver").html(result);
	        		break;
	    		case 'listtransaction':
	    			$("#transactionpane").html(result);
	        		break;
	    		case 'reportlistall':
	    			$("#reportpane").html(result);
	    			break;
	    		}
			}
		});
		return false;
	}
	$(".toupper").change(function(){
		var temp=$(this).val();
		$(this).val(temp.toUpperCase());
	});
	$("#cphone").change(function(){
		var temp = phone_format($(this).val());
		$(this).val(temp);
		//clear id
		$("#customerid").val('');
	});
	$("#rphone").change(function(){
		$("receiverid").val('');
	});
	
	$("#czip").change(function(){
		var temp = zip_format($(this).val());
		$(this).val(temp);
	});
	$("#localamount").change(function(){
		var temp = $(this).val();
		$(this).val(parseFloat(temp).toFixed(2));
		$("#deliveryamount").val(parseFloat(temp).toFixed(2));
		if (temp<=950.00){
			var fee = (temp*0.015+5).toFixed(2);
		}else{
			var fee = (temp*0.02+5).toFixed(2);
		}
		$("#fee").val(fee);
		var total=parseFloat(temp)+parseFloat(fee);
		$("#totalamount").val(total.toFixed(2));
		$("#trans_conumber").val('');
	});
	$("#fee").change(function(){
		var fee=$(this).val();
		var local=$("#localamount").val();
		$(this).val(parseFloat(fee).toFixed(2));
		var total = parseFloat(local)+parseFloat(fee);
		$("#totalamount").val(total.toFixed(2));
	});
	$("#customer_toggle").click(function(){$("#customerinfo" ).toggleClass( "ctoggle_hide" );});
	$("#receiver_toggle").click(function(){$("#receiverinfo" ).toggleClass( "ctoggle_hide" );});
/////////// helper //////////////
	function checkinputfrmdata(frmname){
		if(frmname =='customerfrm'){
			if($("#clname").val()=='')return false;
			else if($("#cfname").val()=='')return false;
			else if($("#caddress").val()=='')return false;
			else if($("#ccity").val()=='')return false;
			else if($("#czip").val()=='')return false;
			else if($("#cphone").val()=='')return false;
			else return true;
		}else if (frmname=='receiverfrm'){
			if($("#rtptinh").val()=='') return false;
			else if($("#rphone").val()=='')return false;
			else if($("#rlname").val()=='')return false;
			else if($("#rfname").val()=='')return false;
			else if($("#rdiachi").val()=='')return false;
			else return true;
		}else if (frmname=='transactionfrm'){
			if($("#totalamount").val()=='')return false;
			else return true;
		}
		
	}
	
	function getinputfrmdata(frmname){
		var x = document.getElementById(frmname);
		var dataString = '';
		var i;
		for (i = 0; i < x.length; i++) {
			dataString += x.elements[i].name + '=' + x.elements[i].value + '&';
		}
		return (dataString);
	}
	function phone_format(t){
		t=t.replace(/[^0-9]/g, "");
		var l = '';
		switch (t.length)
		{
		case 10:
			l = t.substr(0,3)+" "+t.substr(3,3)+" "+t.substr(6,4);
			break;
		case 7:
			l = t.substr(0,3)+" "+t.substr(3,4);
			break;
		case 4:
			l=t;
			break;
		default:
			l='invalid';
		}			
		return l;
	}
	
	function zip_format(t){
		var l = '';
		switch (t.length)
		{
		case 6:
			l = t.substr(0,3)+" "+t.substr(3,3);
			break;
		case 7:
			l = t.substr(0,3)+" "+t.substr(4,3);
			break;
		default:
			l='invalid';
		}			
		return l.toUpperCase();
	}
	function cleardatafrm(){
		//location.reload();
		//main id
		clearcustomerfrm();
		clearreceiverfrm();
		cleartransactionfrm();
		$("#infobar").html('');
		//$("#customersearch").val('');
		//$("#receiversearch").val('');
	}
	function clearcustomerfrm(){
		//customer frm
		$("#customerinfo").html('');
		$("#customerid").val('');
		$("#cfname").val('');
		$("#clname").val('');
		$("#caddress").val('');
		$("#ccity").val('');
		$("#cphone").val('');
		$("#czip").val('');
		$("#cemail").val('');
		$("#cprovince").prop("selectedIndex",0);
	}
	function clearreceiverfrm(){
		//receiver frm
		$("#receiverinfo").html('');
		$("#receiverid").val('');
		$("#rfname").val('');
		$("#rlname").val('');
		$("#rdiachi").val('');
		$("#rphone").val('');
		$("#remail").val('');
		$("#rtptinh").prop("selectedIndex",0);
	}
	function cleartransactionfrm(){
		//transaction frm
		$("#transactioninfo").html('');
		$("#transactionid").val('');
		$("#trans_conumber").val('');
		$("#trans_phonenumber").val('');
		$("#localamount").val('');
		$("#deliveryamount").val('');
		$("#deliverymethod").prop("selectedIndex",0);
		$("#fee").val('');
		$("#totalamount").val('');
		$("#tnote").val('');
	}
	
	// change info script
	///////////////////////////////////////
	//load data to changeinfofrm
	$("#tab-account").click(function(){
		var aid=$("#agentid").val();
		$.ajax({
				type : "POST",
				url : "libraries/changeinfo_get.php",
				data : {type:'loadinfo',aid:aid},
				cache : false,
				success : function(result) {
					$("#infobar").html(result);
					}
				});
	});	
	$("#changepassword_repeatnewpassword").change(function(){
		checkpassword();
	});
	$("#changepassword_submit").click(function(){
		if(checkpassword()){
			var dataString = getinputfrmdata('changepasswordfrm');
			dataString = dataString+"&aid="+$("#agentid").val();
			//alert(dataString);
			$.ajax({
			type : "POST",
			url : "libraries/changeinfo_get.php",
			data : dataString,
			cache : false,
			success : function(result) {
				//alert(result);
				var temp=result.split('|');
				$("#infobar").html(result);
				resetinput();
				}
			});
		}
	});
	
	$("#changeinfo_submit").click(function(){
			var dataString = getinputfrmdata('changeinfofrm');
			dataString = dataString+"&aid="+$("#agentid").val()+"&type=changeinfo_update";
			//alert(dataString);
			$.ajax({
			type : "POST",
			url : "libraries/changeinfo_get.php",
			data : dataString,
			cache : false,
			success : function(result) {
				//alert(result);
				var temp=result.split('|');
				$("#infobar").html(result);
				resetinput();
				}
			});
	});
	$("#changeinfo_phone").change(function(){
		var temp = phone_format($(this).val());
		$(this).val(temp);
	});
	

	$("#changeinfo_zip").change(function(){
		var temp = zip_format($(this).val());
		$(this).val(temp);
	});


function resetinput(){
	$("#changepassword_username").val('');
	$("#changepassword_oldpassword").val('');
	$("#changepassword_newpassword").val('');
	$("#changepassword_repeatnewpassword").val('');
	return false;
}
function checkpassword(){
	var p1 = $("#changepassword_newpassword").val();
	var p2 = $("#changepassword_repeatnewpassword").val();
		if(p1!=p2){
			alert('password not same');
			return false
		}	
	return true;	
}
	
});