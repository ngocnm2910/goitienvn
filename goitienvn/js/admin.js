$(document).ready(function() {
	$.ajaxSetup({ cache: false });
	//register/////////////////////////////
	$("#register").click(function(){
		$.ajax({
			type : "POST",
			url : "libraries/admin.php",
			data : {
				type : 'register'
			},
			cache : false,
			success : function(result) {
				$("#mainright").html(result);
			}
		});
		return false;
	});
	//report/////////////////////////
	$( "#tabs" ).tabs();
	$("#report").click(function(){
		$("#dialog_adminreport" ).dialog('open');
		//get agent namelist
		$.ajax({
     		type : "POST",
     		url : "libraries/adminreport.php",
     		data : {
     			type:'agent_getnamelist'
     		},
     		cache : false,
     		success : function(result) {
     			//$("#reportmain").html(result);
     			var temp=result.split('|');
     			var agent='';
     			var optionsAsString = "";
     			for(var i = 0; i < temp.length; i++) {
     				agent=temp[i].split(':');
     			    optionsAsString += "<option value='" + agent[1] + "'>" + agent[0] + "</option>";
     			}
     			$( 'select[name="reportagent_selectagent"]' ).append( optionsAsString );
     		}
     	});
		
	});
	$("#dialog_adminreport" ).dialog({
		 autoOpen : false,
		 resizable: true,
		 width :990,
		 height:970,
		 modal: true,
		 buttons: {
	     /*
		 "Print":function(){
			 var myWindow = window.open("", "myWindow");
	    	    myWindow.document.write($(this).html());
	    	    myWindow.print();
	    	    myWindow.close();
	    	    location.reload();
		 },*/
		 Close: function() {
			 $( this ).dialog( "close" );
		 	}
		 }
	 });
	//agent
	$("#reportagent_selectagent").click(function(){
		//get agent namelist
		$.ajax({
     		type : "POST",
     		url : "libraries/adminreport.php",
     		data : {
     			type:'reportagent_selectagent',aid:$(this).val()
     				},
     		cache : false,
     		success : function(result) {
     			$("#reportagentinfo_detail").html(result);
     		}
     	});
	});
	//report agent
	$("#reportagent_buttonsubmit").click(function(){
		var agenttype= $("#reportagent_selecttransaction").val();
		var agentsortby=$("#reportagent_sortby").val();
		var fromdate = $("#reportagent_fromdatepicker").val();
		var todate = $("#reportagent_todatepicker").val();
		if (fromdate == 'from date' || todate == 'to date') {
			alert('please select from - to date');
		} else {
			fromdate = fromdate.substring(6, 10) + '/' + fromdate.substring(0, 5);
			todate = todate.substring(6, 10) + '/' + todate.substring(0, 5);
			//get agent namelist
			$.ajax({
	     		type : "POST",
	     		url : "libraries/adminreport.php",
	     		data : {
	     			type:'agent_show',aid:$("#reportagent_selectagent").val(),agenttype:agenttype,agentsortby:agentsortby,fromdate:fromdate,todate:todate
	     		},
	     		cache : false,
	     		success : function(result) {
	     			//here
	     			var temp=result.split('|');
	     			$("#reportagent_main").html(temp[0]);
	     			$("#reportagentinfo_detail_sub").html(temp[1]);
	     		}
	     	});
		}
	});
	$("#report_Agent_buttonExcel").click(function(){
		var agenttype= $("#reportagent_selecttransaction").val();
		var agentsortby=$("#reportagent_sortby").val();
		var fromdate = $("#reportagent_fromdatepicker").val();
		var todate = $("#reportagent_todatepicker").val();
		if (fromdate == 'from date' || todate == 'to date') {
			alert('please select from - to date');
		} else {
			fromdate = fromdate.substring(6, 10) + '/' + fromdate.substring(0, 5);
			todate = todate.substring(6, 10) + '/' + todate.substring(0, 5);
			//get agent namelist
			$.ajax({
	     		type : "POST",
	     		url : "libraries/adminreport.php",
	     		data : {
	     			type:'agent_show',aid:$("#reportagent_selectagent").val(),agenttype:agenttype,agentsortby:agentsortby,fromdate:fromdate,todate:todate
	     		},
	     		cache : false,
	     		success : function(result) {
	     			var temp=result.split('|');
	     			$("#accountingmain").html(temp[0]);
	     			$("#reportaccounting_detail_sub").html('Report To Excel File');
	     			//myWindow.document.write(result);
         			window.open('data:application/vnd.ms-excel,' + encodeURIComponent(temp[0]));
     			    e.preventDefault();
	     		}
	     	});
		}
		
	});	
	
	//report transasction
	$("#reporttransaction_buttonsubmit").click(function(){
		var transtype= $("#reporttransaction_selecttransaction").val();
		var transsortby=$("#reporttransaction_sortby").val();
		var fromdate = $("#reporttransaction_fromdatepicker").val();
		var todate = $("#reporttransaction_todatepicker").val();
		if (fromdate == 'from date' || todate == 'to date') {
			alert('please select from - to date');
		} else {
			fromdate = fromdate.substring(6, 10) + '/' + fromdate.substring(0, 5);
			todate = todate.substring(6, 10) + '/' + todate.substring(0, 5);
			//get agent namelist
			$.ajax({
	     		type : "POST",
	     		url : "libraries/adminreport.php",
	     		data : {
	     			type:'transaction_show',transtype:transtype,transsortby:transsortby,fromdate:fromdate,todate:todate
	     		},
	     		cache : false,
	     		success : function(result) {
	     			$("#transactionmain").html(result);
	     		}
	     	});
		}
	});
	$("#reporttransaction_buttonprint").click(function(){
		var transtype= $("#reporttransaction_selecttransaction").val();
		var transsortby=$("#reporttransaction_sortby").val();
		var fromdate = $("#reporttransaction_fromdatepicker").val();
		var todate = $("#reporttransaction_todatepicker").val();
		if (fromdate == 'from date' || todate == 'to date') {
			alert('please select from - to date');
		} else {
			fromdate = fromdate.substring(6, 10) + '/' + fromdate.substring(0, 5);
			todate = todate.substring(6, 10) + '/' + todate.substring(0, 5);
			//get agent namelist
			$.ajax({
	     		type : "POST",
	     		url : "libraries/adminreport.php",
	     		data : {
	     			type:'transaction_show',transtype:transtype,transsortby:transsortby,fromdate:fromdate,todate:todate
	     		},
	     		cache : false,
	     		success : function(result) {
	     			var temp=result.split('|');
	     			$("#accountingmain").html(temp[0]);
	     			$("#reportaccounting_detail_sub").html('Report To Excel File');
	     			//myWindow.document.write(result);
         			window.open('data:application/vnd.ms-excel,' + encodeURIComponent(temp[0]));
     			    e.preventDefault();
	     		}
	     	});
		}
		
	});			
	// $("#reporttransaction_buttonprint").click(function(){
	//	var myWindow = window.open("", "myWindow");
 	//    myWindow.document.write($("#transactionmain").html());
 	//    myWindow.print();
 	//    myWindow.close();
 	//    location.reload();
	// });
	//report accounting
	$("#reportaccounting_buttonsubmit").click(function(){
		var accttype= $("#reportaccounting_selecttransaction").val();
		var acctsortby=$("#reportaccounting_sortby").val();
		var fromdate = $("#reportaccounting_fromdatepicker").val();
		var todate = $("#reportaccounting_todatepicker").val();
		//alert('debug');
		if (fromdate == 'from date' || todate == 'to date') {
			alert('please select from - to date');
		} else {
			fromdate = fromdate.substring(6, 10) + '/' + fromdate.substring(0, 5);
			todate = todate.substring(6, 10) + '/' + todate.substring(0, 5);
			//get agent namelist
			$.ajax({
	     		type : "POST",
	     		url : "libraries/adminreport.php",
	     		data : {
	     			type:'accounting_show',accttype:accttype,acctsortby:acctsortby,fromdate:fromdate,todate:todate
	     		},
	     		cache : false,
	     		success : function(result) {
	     			var temp=result.split('|');
	     			$("#accountingmain").html(temp[0]);
	     			$("#reportaccounting_detail_sub").html(temp[1]);
	     		}
	     	});
		}
	});
	$("#reportaccounting_buttonprint").click(function(){
		var myWindow = window.open("", "myWindow");
 	    myWindow.document.write($("#accountingmain").html());
 	    myWindow.print();
 	    myWindow.close();
 	    location.reload();
	});
							
	$("#reportaccounting_buttonexportexcel").click(function(){
		var accttype= $("#reportaccounting_selecttransaction").val();
		var acctsortby=$("#reportaccounting_sortby").val();
		var fromdate = $("#reportaccounting_fromdatepicker").val();
		var todate = $("#reportaccounting_todatepicker").val();
		//alert('debug');
		if (fromdate == 'from date' || todate == 'to date') {
			alert('please select from - to date');
		} else {
			fromdate = fromdate.substring(6, 10) + '/' + fromdate.substring(0, 5);
			todate = todate.substring(6, 10) + '/' + todate.substring(0, 5);
			//get agent namelist
			$.ajax({
	     		type : "POST",
	     		url : "libraries/adminreport.php",
	     		data : {
	     			type:'accounting_show',accttype:accttype,acctsortby:acctsortby,fromdate:fromdate,todate:todate
	     		},
	     		cache : false,
	     		success : function(result) {
	     			var temp=result.split('|');
	     			$("#accountingmain").html(temp[0]);
	     			$("#reportaccounting_detail_sub").html('Report To Excel File');
	     			//myWindow.document.write(result);
         			window.open('data:application/vnd.ms-excel,' + encodeURIComponent(temp[0]));
     			    e.preventDefault();
	     		}
	     	});
		}
		
	});	
	//transaction////////////////////////
	$("#transaction_fromdatepicker,#transaction_todatepicker,#reporttransaction_fromdatepicker,#reporttransaction_todatepicker,#reportagent_fromdatepicker,#reportagent_todatepicker,#reportaccounting_fromdatepicker,#reportaccounting_todatepicker").datepicker();
	$("#dialog_reportsendfrm" ).dialog({
		 autoOpen : false,
		 resizable: true,
		 width :900,
		 height:800,
		 modal: true,
		 buttons: {
	     "print":function(){
	    	 	var myWindow = window.open("", "myWindow");
	    	    myWindow.document.write($(this).html());
	    	    myWindow.print();
	    	    myWindow.close();
	    	    location.reload();
	     },
		 "export Excel":function(){
			 //window.open('data:application/vnd.ms-excel,' + encodeURIComponent($(this).html()));
			 //e.preventDefault();
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
		             		url : "libraries/adminexportexcel.php",
		             		//contentType: "application/vnd.ms-excel",
		             		data : {
		             			idstring:dataString
		             		},
		             		cache : false,
		             		success : function(result) {
		        	    	    //myWindow.document.write(result);
		             			window.open('data:application/vnd.ms-excel,' + encodeURIComponent(result));
		         			    e.preventDefault();
		             		}
		             	});
		     		}else{
		   			  alert("Select transaction to send !");
		         	}
			
			 $( this ).dialog( "close" );
		 },
		 Close: function() {
			 $( this ).dialog( "close" );
			 location.reload();
			 //cleardatafrm();
		 	}
		 }
	 });
	$("#dialog_confirm").dialog({
		autoOpen: false,
		resizable : false,
		width:300,
		height:300,
		modal : true,
		buttons : {
			"save" : function() {
				
			},
			"delete" : function() {
				
			},
			"Cancel / close" :function() {
				$(this).dialog("close");
			}
		}
	});
	$("#dialog_account").dialog({
		autoOpen: false,
		resizable : false,
		width:300,
		height:320,
		modal : true,
		buttons : {
			"save" : function() {
				var dataString = getinputfrmdata('changeinfofrm');
				dataString = dataString+"&aid="+$("#agentid").val()+"&type=changeinfo_update";
				$.ajax({
				type : "POST",
				url : "libraries/changeinfo_get.php",
				data : dataString,
				cache : false,
				success : function(result) {
					$("#logstart").append(result);
					$("#dialog_account").dialog("close");
					}
				});
				
			},
			"delete" : function() {
				$.ajax({
				type : "POST",
				url : "libraries/changeinfo_get.php",
				data : {type:'changeinfo_delete',aid:$('#agentid').val()},
				cache : false,
				success : function(result) {
					$("#logstart").append(result);
					$("#dialog_account").dialog("close");
					}
				});
			},
			"Cancel / close" :function() {
				$(this).dialog("close");
			}
		}
	});
	//
	$("#topmenulistagent").click(function() {
		listdata('listagent');
	});
	$("#topmenulistcustomer").click(function() {
		listdata('listcustomer');
	});
	$("#topmenulistreceiver").click(function() {
		listdata('listreceiver');
	});
	$("#topmenulisttransaction").click(function() {
		listdata('listtransaction');
	});
	
	$("#adnew").click(function() {
		listnewtransaction();
	});
	$("#closelog").click(function() {
		var temp = $(this).attr('value');
		if(temp=='close log'){
			$("#logpanel").css({display:'none'});
			$("#leftinfo").css({display:'none'});
			$(this).attr('value','open log');
		}else{
			$("#logpanel").css({display:'block'});
			$("#leftinfo").css({display:'block'});
			$(this).attr('value','close log');
		}
	});
	
	function listnewtransaction(){
		$.ajax({
			type : "POST",
			url : "libraries/admin.php",
			data : {
				type : 'listnewtransaction'
			},
			cache : false,
			success : function(result) {
				//$("#leftinfosub").html(result);
			}
		});
		return false;
	}
	$("#dailytransaction").click(function(){
		var days=$("#transctiondays").val();
		//alert(days);
		$.ajax({
			type : "POST",
			url : "libraries/admin.php",
			data : {
				type : 'dailytransaction',days:days
			},
			cache : false,
			success : function(result) {
				$("#mainright").html(result);
			}
		});
		return false;
	});
	$("#fromtotransaction").click(
			function() {
				var fromdate = $("#transaction_fromdatepicker").val();
				var todate = $("#transaction_todatepicker").val();
				var report_showtype = $("#report_showtype").val();
				if (fromdate == '' && todate == '') {
					alert('please select from - to date');
				} else {
					fromdate = fromdate.substring(6, 10) + '/' + fromdate.substring(0, 5);
					todate = todate.substring(6, 10) + '/' + todate.substring(0, 5);
					//alert(fromdate+todate);
					$.ajax({
						type : "POST",
						url : "libraries/admin.php",
						data : {
							type : 'fromtodatetransaction',
							fromdate:fromdate,todate:todate,showtype:report_showtype
						},
						cache : false,
						success : function(result) {
							$("#mainright").html(result);
						}
					});
				return false;
				}
			});
	$("#quicknewtransaction").click(
			function() {
				$.ajax({
					type : "POST",
					url : "libraries/admin.php",
					data : {
						type : 'quicknewtransaction'
					},
					cache : false,
					success : function(result) {
						$("#mainright").html(result);
					}
				});
			return false;
	});
	
	//update transaction
	$("#adupdate").click(function(){
		//check id
		if($("#transactionid").val()=='' || $("#customerid").val()=='' || $("#receiverid").val()==''){
			alert('verify form data');
		}
		//procee
		else{
			//alert($("#transactionid").val());
			//get only admin frm data
			var dataString = getinputfrmdata('adminfrm')+"type=transactionupdate&tid="+$("#transactionid").val();
			//alert(dataString);
			if( !confirm('Update the transaction?') ) 
	            event.preventDefault();
			$.ajax({
				type : "POST",
				url : "libraries/admin.php",
				data : dataString,
				cache : false,
				success : function(result) {
					var temp=result.split('|');
					$("#logpanel").preppend(temp[0]);
					//listnewtransaction();
				}
			});
		}
	});
	$("#trans_edit").click(function(){
		//check id
		if($("#transactionid").val()=='' || $("#customerid").val()=='' || $("#receiverid").val()==''){
			alert('verify form data');
		}
		//procee
		else{
			//alert($("#transactionid").val());
			//get only admin frm data
			var dataString = getinputfrmdata('transactionfrm')+"type=transactionedit&tid="+$("#transactionid").val();
			//alert(dataString);
			if( !confirm('Edit the transaction?') ) 
	            event.preventDefault();
			$.ajax({
				type : "POST",
				url : "libraries/admin.php",
				data : dataString,
				cache : false,
				success : function(result) {
					var temp=result.split('|');
					$("#logpanel").preppend(temp[0]);
					//listnewtransaction();
				}
			});
		}
	});
	//customer frm
	$("#cnew").click(function(){
		if($("#customerid").val()!=''){
			alert('warning duplicate customer data entry');
		}
		else if(checkinputfrmdata('customerfrm')){
			var dataString= getinputfrmdata('customerfrm');
			var dataString = dataString+"type=newcustomer&aid="+$("#agentid").val();
			//alert(dataString);
			if( !confirm('Created new Customer?') ) 
	            event.preventDefault();
			$.ajax({
				type : "POST",
				url : "libraries/admin.php",
				data : dataString,
				cache : false,
				success : function(result) {
					var temp=result.split('|');
					$("#logpanel").append(temp[0]);
					$("#customerid").val(temp[1]);
					$("#trans_phonenumber").val(temp[2]);
				}
			});
		}else{
			alert('please verify customer required fields');	
		}
	});
	$("#cedit").click(function(){
		if($("#customerid").val()==''){
			alert('Error - customer data entry');
		}
		else if(checkinputfrmdata('customerfrm')){
			var dataString= getinputfrmdata('customerfrm');
			var dataString = dataString+"type=editcustomer&cid="+$("#customerid").val();
			//alert(dataString);
			if( !confirm('Edit Customer Information?') ) 
	            event.preventDefault();
			$.ajax({
				type : "POST",
				url : "libraries/admin.php",
				data : dataString,
				cache : false,
				success : function(result) {
					var temp=result.split('|');
					$("#logpanel").append(temp[0]);
					$("#customerid").val(temp[1]);
				}
			});
		}else{
			alert('please verify customer required fields');	
		}
	});
	$("#rnew").click(function(){
		if($("#receiverid").val()!=''){
			alert('warning duplicate receiver data entry');
		}else if(checkinputfrmdata('receiverfrm')== false){ 
			alert('please verify receiver required fields');	
		}else if($("#customerid").val()==''){
			alert('please verify customer required fields');
		}else{
			var dataString= getinputfrmdata('receiverfrm');
			var dataString = dataString+"type=newreceiver&customerid="+$("#customerid").val()+"&aid="+$("#agentid").val();
			//alert(dataString);
			if( !confirm('Create new Receiver?') ) 
	            event.preventDefault();
			$.ajax({
				type : "POST",
				url : "libraries/admin.php",
				data : dataString,
				cache : false,
				success : function(result) {
					var temp=result.split('|');
					$("#logpanel").append(temp[0]);
				}
			});	
		}
		
	});
	$("#redit").click(function(){
		if($("#receiverid").val()==''){
			alert('Error - receiver data entry');
		}
		else if(checkinputfrmdata('receiverfrm')){
			var dataString= getinputfrmdata('receiverfrm');
			var dataString = dataString+"type=editreceiver&rid="+$("#receiverid").val();
			//alert(dataString);
			if( !confirm('Edit Receiver information?') ) 
	            event.preventDefault();
			$.ajax({
				type : "POST",
				url : "libraries/admin.php",
				data : dataString,
				cache : false,
				success : function(result) {
					var temp=result.split('|');
					$("#logpanel").append(temp[0]);
				}
			});
		}else{
			alert('please verify receiver required fields');	
		}
	});
	//transaction
	$("#trans_conumber").change(function(){
		var p=$(this).val();
		if(p.length != 10){
			alert('Invalid number');
		}
	});
	$("#trans_co_search").click(function(){
	 	searchtransactionby('searhtransationbyconumber',$("#trans_conumber").val());
		
	 });
	$("#trans_phone_search").click(function(){
	 	searchtransactionby('searchtransactionbyphone',$("#trans_phonenumber").val());
	 });						
	function searchtransactionby(type,number){
		//alert(type+number);
		$.ajax({
    		type : "POST",
    		url : "libraries/admin.php",
    		data : {
    			type : type,number:number
    		},
    		cache : false,
    		success : function(result) {
				var temp=result.split('|');
				if(temp[0]==2){
					$("#logpanel").append(temp[1]);
					//$("#leftinfosub").html(temp[2]);
				}else{
					$("#logpanel").append(result);
				}
				
    		}
    	});
	}
	
	$("#trans_submit").click(function(){
		var cid=$("#customerid").val();
		var rid=$("#receiverid").val();
		var tid=$("#transactionid").val();
		transactioncheck(cid,rid,tid);
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
		
			transactionsubmit(cid,rid);
			return true;
	
	}
	function transactionsubmit(cid,rid){
		var dataString = '';
		//get customerfrm
		dataString = getinputfrmdata('customerfrm');
		dataString = dataString+getinputfrmdata('receiverfrm');
		dataString = dataString+getinputfrmdata('transactionfrm');
		dataString = dataString+"type=newtransactionsubmit&aid="+$("#agentid").val();
		alert(dataString);
		$.ajax({
			type : "POST",
			url : "libraries/admin.php",
			data :dataString,
			cache : false,
			success : function(result) {
				$("#logpanel").append(result);
				/*
				//$(".leftinfo").html(result);
				var temp=result.split('|');
				//old file
				if((cid!='')&&(rid!='')){
					$("#logpanel").append(temp[0]);
					$("#trans_conumber").val(temp[1]);
				}//new file
				else{
					$("#logpanel").append(temp[0]+temp[2]+temp[4]);
					$("#trans_conumber").val(temp[5]);
				}
				*/
			}
		});
		return false;
	}
	function listdata(datatype){
		$.ajax({
			type : "POST",
			url : "libraries/admin.php",
			data : {
				type : datatype
			},
			cache : false,
			success : function(result) {
				$("#mainright").html(result);
			}
		});
		return false;
	}
	$("#csearch").click(function() {
		customerphonesearch();
	});
	function customerphonesearch(){
		var temp=$("#cphone").val();
		var temp_length = temp.length;
		$.ajax({
    		type : "POST",
    		url : "libraries/admin.php",
    		data : {
    			type : "customerphonesearch",phone_no:temp,l:temp_length
    		},
    		cache : false,
    		success : function(result) {
    			$("#logpanel").append(result);
    		}
    	});
	}
	$(".toupper").change(function(){
		var temp=$(this).val();
		$(this).val(temp.toUpperCase());
	});
	$("#cphone,#trans_phonenumber").change(function(){
		var temp = phone_format($(this).val());
		$(this).val(temp);
	});
	
	$("#czip").change(function(){
		var temp = zip_format($(this).val());
		$(this).val(temp);
	});
	$("#localamount").change(function(){
		var temp = $(this).val();
		$(this).val(parseFloat(temp).toFixed(2));
		$("#deliveryamount").val(parseFloat(temp).toFixed(2));
		var fee = (temp*0.015+5).toFixed(2);
		$("#fee").val(fee);
		var total=parseFloat(temp)+parseFloat(fee);
		$("#totalamount").val(total.toFixed(2));
	});
	$("#fee").change(function(){
		var fee=$(this).val();
		var local=$("#localamount").val();
		$(this).val(parseFloat(fee).toFixed(2));
		var total = parseFloat(local)+parseFloat(fee);
		$("#totalamount").val(total.toFixed(2));
	});
	$("#aclearfrm").click(function(){
		cleardatafrm();
	});
	$("#rclear").click(function(){
		clearreceiverfrm();
	});
	$("#cclear").click(function(){
		clearcustomerfrm();
	});
	$("#tclear").click(function(){
		cleartransactionfrm();
	});
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
			if($("#").val()=='') return false;
			else if($("#rphone").val()=='')return false;
			else if($("#rlname").val()=='')return false;
			else if($("#rfname").val()=='')return false;
			else if($("#rdiachi").val()=='')return false;
			else return true;
			//else if($("#").val()=='')
			//else if($("#").val()=='')
		}else if (frmname=='transactionfrm'){
			if($("#totalamount").val()=='')return false;
			else if($("#deliveryamount").val()=='')return false;

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
		location.reload();
	}
	function clearcustomerfrm(){
		//customer frm
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
});
