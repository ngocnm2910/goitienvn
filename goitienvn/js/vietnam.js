// JavaScript Document
$(document).ready(function() {
	$.ajaxSetup({ cache: false });
	$("#vnview_mophieu").click(function(){
		clearvar();
		listmophieu();
	});
	function listmophieu(){
		$.ajax({
			type : "POST",
			url : "libraries/vietnam.php",
			data : {
				type : "vnview_mophieu"
			},
			cache : false,
			success : function(result) {
				$("#mainpane").html(result);
				$("#leftinfo").html("Tất cã phiếu còn mỡ");
			}
		});
		return true;
	}
	
	$("#vnview_dongphieu").click(function(){
		clearvar();
		listdongphieu();
	});
	function listdongphieu(){
		$.ajax({
			type : "POST",
			url : "libraries/vietnam.php",
			data : {
				type : "vnview_dongphieu"
			},
			cache : false,
			success : function(result) {
				$("#mainpane").html(result);
				$("#leftinfo").html("Tất cã phiếu còn mỡ");
			}
		});
		return true;
	}
	/*
	$("#vnview_dongphieu").click(function(){
		var selectedtransactionid=$("#selected_transactionid").val();
		//alert(selectedtransactionid);
		if(selectedtransactionid==0){
			alert('Xin vui lòng chọn phiếu để đóng, Cám ơn');
		}else{
			//alert(selectedtransactionid);
			$.ajax({
        		type : "POST",
        		url : "libraries/vietnam.php",
        		data : {
        			type : "vnview_inphieu",tid:selectedtransactionid,status:"dongphieu"
        		},
        		cache : false,
        		success : function(result) {
        			$("#dongphieu_detail").html(result);
					$("#dialog_dongphieu").dialog('option', 'title', 'Phiếu số: '+$("#selected_transaction_co_no").val());
					$("#dialog_dongphieu").dialog("open");
        		}
        	});
			
		}
	});
	*/
	$("#vnview_doiphieu").click(function(){
		alert('comming soon');
	});
	$("#vnview_thanhtoan").click(function(){
		clearvar();
		$.ajax({
        		type : "POST",
        		url : "libraries/vietnam.php",
        		data : {
        			type : "vnview_thanhtoan"
        		},
        		cache : false,
        		success : function(result) {
        			$("#mainpane").html(result);
        		}
        	});
	});
	
	$("#dialog_guiphieu").dialog({
		autoOpen : false,
		width : 400,
		height : 300,
		buttons: {
			"Gữi/In Phiếu": guiphieu,
			Cancel: function() {
			$(this).dialog( "close" );
			}
		}
	});
	function guiphieu(){
		var selectedtransactionid=$("#selected_transactionid").val();
		$.ajax({
        		type : "POST",
        		url : "libraries/vietnam.php",
        		data : {
        			type : "vnview_phieu_update",tid:selectedtransactionid,status:"3"
        		},
        		cache : false,
        		success : function(result) {
        			$("#leftinfo").html(result);
					$("#dialog_guiphieu").dialog("close");
					clearvar();
        		}
        	});
	}
	$("#dialog_dongphieu").dialog({
		autoOpen : false,
		width : 410,
		height : 430,
		buttons: {
			"Đóng Phiếu": dongphieu,
			Cancel: function() {
			$(this).dialog( "close" );
			}
		}
	});
	
	function dongphieu(){
		var selectedtransactionid=$("#selected_transactionid").val();
		$.ajax({
        		type : "POST",
        		url : "libraries/vietnam.php",
        		data : {
        			type : "vnview_phieu_update",tid:selectedtransactionid,status:"4"
        		},
        		cache : false,
        		success : function(result) {
        			$("#leftinfo").html(result);
					$("#dialog_dongphieu").dialog("close");
					listdongphieu();
					clearvar();
        		}
        	});
	}
	function clearvar(){
		$("#selected_transactionid").val('0');
	}
});