//$(document).ready(function(){
//	// var filter = $(".panel-body").find("select");
//
//	 
//	$("#matrimony_accordion").delegate("input[type=text],select","change keyup",function(){
//		// var matrimony_type = $("#collapseFour").find("input[type=checkbox]").attr("id");
//		var chkdata = $("input[name='matrimony_gender\\[\\]']:checked").map(function(){return $(this).val();}).get();
//		var filter_val = $(this).val();
//		var field_name = $(this).attr("ftype");
//
//
//
//			var result = Validate(filter_val,field_name);
//			 
//			 if(result == false){
//			 	return false;
//			 }
//				// var	v1 = chkdata.split(",");
//				// 	alert(v1[0]);
//			 
//			  // alert(chkdata.length);
//			  if(chkdata.length == 1){
//			  	if(chkdata[0]=="Male")
//			  	var Searchfor = "Grooms";
//			  	else
//			  	var Searchfor = "Brides";	
//			  }
//			  	
//			  else var Searchfor = "Brides and Grooms";
//
//			// alert(Searchfor);	
//		 	$.ajax({
//		 		// beforeSend : function(){
//		 		// 	$(".filters_loader_box").show();
//		 		// } ,
//
//				// for Testing purpose 
//				url : "http://"+location.hostname+"/rustagi/matrimonial/matrimonyfilters",
//
//				// for Live purpose
//				//url : "http://"+location.hostname+"/matrimonial/matrimonyfilters",
//
//		 		type : "POST",
//		 		async : false,
//		 		data : {gender_type:chkdata,value:filter_val,type:field_name,SearchType:Searchfor},
//		 		success : function(data){
//		 			
//		 			// $("#searchfor").html(Searchfor);
//					$(".showerrorbox").fadeOut();
//		 			$("#profile1").hide();
//		 			$("#profilepage").hide();
//		 			$("#profile").show();
//					$("#listgrid").show();
//		 			$("#profile").html(data);
//						$('ul#items').easyPaginate({
//							step:16
//						});
//						var CSCdata = $("#CSCresults").html();
//						var atr = $("#CSCresults").attr("ftyle");
//						var taratr = $("#matrimony_accordion").find("select[ftype="+atr+"]");
//
//						taratr.html(CSCdata);
//						// alert(atr);
//		 		},
//		 		// complete : function(){
//		 		// 	$(".filters_loader_box").hide();
//		 		// }
//		 	});
//	});
//  
//
//
//});
//
//function Validate(filter_val,field_name){
//
//	if(field_name == "office_email"){
//					if(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(filter_val) == false){
//
//				 		var error = "<p id='filtererrors'>Not valid email</p>";
//						showerror(error);
//						return false;
//					}
//			 }
//			else if(filter_val == "---Select---country---"){
//				var error = "<p id='filtererrors'>Please select country</p>";
//				// alert();
//				$("select[ftype=state]").empty();
//				$("select[ftype=city]").empty();
//				$("select[ftype=state]").html("<option>---Select---state---</option>");
//				$("select[ftype=city]").html("<option>---Select---city---</option>");
//				showerror(error);
//				return false;
//			}
//			else if(filter_val == "---Select---state---"){
//				var error = "<p id='filtererrors'>Please select state</p>";
//				// alert();
//				$("select[ftype=city]").empty();
//				$("select[ftype=city]").html("<option>---Select---city---</option>");
//				showerror(error);
//				return false;
//			}
//			else if(filter_val == "---Select---city---"){
//				var error = "<p id='filtererrors'>Please select city</p>";
//				// alert();
//				showerror(error);
//				return false;
//			}
//			else if(field_name == "zip_pin_code"){
//			if(/[0-9]/.test(filter_val) == true){
//
//				if(filter_val.length != 6){
//					var error = "<p id='filtererrors'>Pincode length must be of 6 digits only</p>";
//					// alert(filter_val.length);	
//					showerror(error);
//					return false;
//				}
//			}
//			else {
//				var error = "<p id='filtererrors'>Pincode should be numeric</p>";
//
//				showerror(error);
//				return false;
//			}
//			 }
//			 else if(field_name == "phone_no"){
//			if(/[0-9]/.test(filter_val) == true){
//
//				if(filter_val.length != 10){
//					var error = "<p id='filtererrors'>Phone no length must be of 10 digits only</p>";
//					// alert(filter_val.length);	
//					showerror(error);
//					return false;
//				}
//			}
//			else {
//				var error = "<p id='filtererrors'>Phone no should be numeric</p>";
//
//				showerror(error);
//				return false;
//			}
//			 }
//
//			 else if(field_name == "full_name"){
//					if(/[a-zA-Z]/.test(filter_val) == false){
//
//				 		var error = "<p id='filtererrors'>Name must be in alphabets</p>";
//						showerror(error);
//						return false;
//					}
//			 }
//			else  if(filter_val == "---Select---Profession---"){
//				var error = "<p id='filtererrors'>Please select Profession</p>";
//				// alert();
//				showerror(error);
//				return false;
//			}
//			else if(filter_val == "---Select---Education---"){
//				var error = "<p id='filtererrors'>Please select Education</p>";
//				// alert();
//				showerror(error);
//				return false;
//			}
//			else if(filter_val == "---Select---Designation---"){
//				var error = "<p id='filtererrors'>Please select Designation</p>";
//				// alert();
//				showerror(error);
//				return false;
//			}
//			else if(filter_val == "---Marital---Status---"){
//				var error = "<p id='filtererrors'>Please select Marital Status</p>";
//				// alert();
//				showerror(error);
//				return false;
//			}
//			else if(filter_val == "---Select---Height---"){
//				var error = "<p id='filtererrors'>Please select Height of person</p>";
//				// alert();
//				showerror(error);
//				return false;
//			}
//			else if(filter_val == "---Manglik---Dosh---"){
//				var error = "<p id='filtererrors'>Please select Manglik Dosh</p>";
//				// alert();
//				showerror(error);
//				return false;
//			}
//			else return true;
//
//}
//
//function showerror(error)
//	{
//		$(".showerrorbox").fadeIn();
//		$(".showerrorbox").html(error);
//		// alert(error);
//	}
