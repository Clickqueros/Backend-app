function toastr_message(code,service,message){
    //console.log(code);
    switch(code) {
        case 200:
            response = toastr.success(message,service);
            break;
        case 300:
            response = toastr.info(message,service);
            break;
        case 400:
            response = toastr.warning(message,service);
            break;
        case 500:
            response = toastr.error(message,service);
            break;
        default:
            response = false
            break;
    }
    //console.log(response);
    return response;
}

function changeDiscount(id_refer,discount) {
	updateDiscount(id_refer,discount).done(function(respUpd) {
		console.log(id_refer,discount);
		$("td[data-target='discount'][data-refer='"+id_refer+"']").html('$ '+discount);
		$("td[data-target='btn_edit'][data-refer='"+id_refer+"']").html('<button class="btn btn-sm button-edit btnDiscount" data-refer="'+id_refer+'" data-edit="0"><i class="fa fa-pencil" aria-hidden="true"></i></button>');
		// $("td[data-target='discount'][data-refer='"+id_refer+"']").attr('data-val', discount);
		$("td[data-target='discount'][data-refer='"+id_refer+"']").data('val', discount);
		$(".btnDiscount").click(function() {
			actionDiscount($(this));
		});
		if (respUpd["code"] == 200) {
		}
		// var toastMessage_ = {"service":"Notificación","500":text_message,"500":text_message};
		toastr_message(respUpd["code"],'Notificación',respUpd["response"]);
		console.log(respUpd);
	}).fail(function(respFail) {
		console.log(respFail);
	})
}

function changeStatus(id_refer,status) {
	updateStatus(id_refer,status).done(function(respUpd) {
		if (respUpd["code"] == 200) {
			var style_upd = (status == 1)?"table-success":"table-info";
			var style_rmv = (status == 1)?"table-info":"table-success";
			var text_upd = (status == 1)?"Redimido":"Sin redimir";
			$("td[data-target='status_redeemed'][data-refer='"+id_refer+"']").text(text_upd);
			$("td[data-target='status_redeemed'][data-refer='"+id_refer+"']").removeClass(style_rmv);
			$("td[data-target='status_redeemed'][data-refer='"+id_refer+"']").addClass(style_upd);
		}
		// var toastMessage_ = {"service":"Notificación","500":text_message,"500":text_message};
		toastr_message(respUpd["code"],'Notificación',respUpd["response"]);
		console.log(respUpd);
	}).fail(function(respFail) {
		console.log(respFail);
	})
}

function actionDiscount(object) {
	console.log('Entro a btn discount');
	var id_refer = $(object).data('refer');
	var edit = $(object).data('edit');
	var val_discount = $("td[data-target='discount'][data-refer='"+id_refer+"']").data('val');
	console.log(id_refer,edit,val_discount);
	if (edit == 0) {
		console.log('Entro a edit');
		// $("td[data-target='discount'][data-refer='"+id_refer+"']").children().remove();
		$("td[data-target='discount'][data-refer='"+id_refer+"']").html('<input type="number" class="form-control form-control-sm inputDiscount" data-refer="'+id_refer+'" value="'+val_discount+'">');
		$("td[data-target='btn_edit'][data-refer='"+id_refer+"']").html('<button class="btn btn-sm btn-info btnSave" data-refer="'+id_refer+'"><i class="fa fa-floppy-o" aria-hidden="true"></i></button></div>');
		// $(".btnSave").off('click');
		$(".btnSave").click(function(event) {
			var id_refer_save = $(this).data('refer');
			var discount_save = $(".inputDiscount[data-refer='"+id_refer_save+"']").val();
			var discount_prev = $("td[data-target='discount'][data-refer='"+id_refer_save+"']").data('val');
			if (discount_save != discount_prev) {
				changeDiscount(id_refer_save,discount_save);
			}
			else {
				$("td[data-target='discount'][data-refer='"+id_refer+"']").html('$ '+discount_prev);
				$("td[data-target='btn_edit'][data-refer='"+id_refer+"']").html('<button class="btn btn-sm button-edit btnDiscount" data-refer="'+id_refer_save+'" data-edit="0"><i class="fa fa-pencil" aria-hidden="true"></i></button>');
				$(".btnDiscount").click(function() {
					actionDiscount($(this));
				});
			}
		});
	}
}

function loadPrincipal() {
	$(".bodyView").load("views/viewDashboard.html", function(){
		console.log('Entro al Principal');
		let listReferenced = getAllReferenced();
		$.when(listReferenced).done(function(respRefer) {
			console.log(respRefer);
			$.each(respRefer["response"], function(index, value) {
				var num = index+1;
				var styleStatus = (value["status_redeemed"] == 1)?"table-success":"table-info";
				var status = (value["status_redeemed"] == 1)?"Redimido":"Sin redimir";
				var check_status = (value["status_redeemed"] == 1)?"checked":"";
				$("#table_referenced tbody").append('<tr><th scope="row">'+num+'</th><td class="celValue" data-target="names">'+value["names"]+'</td><td class="celValue" data-target="document">'+value["document"]+'</td><td data-target="email">'+value["email"]+'</td><td data-target="mobile">'+value["mobile"]+'</td><td data-target="refer_by"><p style="color:#556015;font-weight:600;">'+value["refer_by"]+'</p></td><td data-target="policy">'+value["policy"]+'</td><td class="'+styleStatus+'" data-refer="'+value["id"]+'" data-target="status_redeemed">'+status+'</td><td data-target="discount" data-refer="'+value["id"]+'" data-val="'+value["discount"]+'"><p>$ '+value["discount"]+'</p> </td><td data-target="btn_edit" data-refer="'+value["id"]+'"><button class="btn btn-sm button-edit btnDiscount" data-refer="'+value["id"]+'" data-edit="0"><i class="fa fa-pencil" aria-hidden="true"></i></button></td><td data-target="check_status"><label class="checkboxSpecial"><input type="checkbox" class="btn btn-sm btnStatus" id="'+value["id"]+'" '+check_status+'/><span class="primary"></span></label></td></tr>');
				$("#table_export tbody").append('<tr><th scope="row">'+num+'</th><td>'+value["names"]+'</td><td>'+value["document"]+'</td><td>'+value["email"]+'</td><td>'+value["mobile"]+'</td><td>'+value["refer_by"]+'</td><td>'+value["policy"]+'</td><td>'+status+'</td><td>$ '+value["discount"]+'</td></tr>');
			});
			$("#findDoc").keyup(function() {
				console.log('Entro findDoc');
				var filter = $(this).val();
				filter = (filter != "")?filter.toUpperCase():"";
				$.each($("tr"), function() {
					var validate = false;
					if ($(this).children('th').length > 1){
						validate = true;
					}
					$.each($(this).find("td[data-target='document']"), function() {
						var text = $(this).text();
						text = (text != "")?text.toUpperCase():"";
						if (text.includes(filter) && filter != "") {
							validate = true;
						}
						else if (!$(this).text().includes(filter) && filter != ""){
						
						}
						else if (filter == ""){
							validate = true;
						}
					});
					if (validate == true) {
						$(this).removeClass('d-none');
					}
					else {
						$(this).addClass('d-none');

					}
				});
			});
			$("#findName").keyup(function() {
				console.log('Entro findNames');
				var filter = $(this).val();
				filter = (filter != "")?filter.toUpperCase():"";
				$.each($("tr"), function() {
					var validate = false;
					if ($(this).children('th').length > 1){
						validate = true;
					}
					$.each($(this).find("td[data-target='names']"), function() {
						var text = $(this).text();
						text = (text != "")?text.toUpperCase():"";
						if (text.includes(filter) && filter != "") {
							validate = true;
						}
						else if (!$(this).text().includes(filter) && filter != ""){
						
						}
						else if (filter == ""){
							validate = true;
						}
					});
					if (validate == true) {
						$(this).removeClass('d-none');
					}
					else {
						$(this).addClass('d-none');

					}
				});
			});
			$(".btnStatus").click(function() {
				var id_refer = $(this).attr('id');
				var status = ($(this).prop('checked') == true)?1:0;
				changeStatus(id_refer,status);
			});
			$(".btnDiscount").off('click');
			$(".btnDiscount").click(function() {
				actionDiscount($(this));
			});
			$("#exportInfo").click(function(e) {
				window.open('data:application/vnd.ms-excel;charset=utf-8,%EF%BB%BF' + encodeURIComponent($('#viewTableExport').html()));
            	e.preventDefault();
			});
		}).fail(function(response) {
			console.log('Fail Referenced');
			console.log(response);
		});
		
	});
}

function loginView() {
	console.log('Entro al login');
	getUserLogged().done(function(respLogged){
		console.log(respLogged);
		if (respLogged["code"] == 300) {
			$(".bodyView").load("views/viewLogin.html", function(){
				/* Act on the event */
				$("#formLogin").off('submit');
				$("#formLogin").submit(function(event) {
					var user = $("#inputEmail").val();
					var password = $("#inputPassword").val();
					loginUser(btoa(user),btoa(password)).done(function(respLogin){
						console.log(respLogin);
						if (respLogin["code"] == 200) {
							loadPrincipal();
						}
					}).fail(function(response){
						console.log('Fail Login');
						console.log(response);
					});
					event.preventDefault();
				});
			}); 
		}
		else if (respLogged["code"] == 200) {
			loadPrincipal();
		}
	}).fail(function(response){
		console.log('Fail Logged');
		console.log(response);
	});
}

$(document).ready(function() {
	loginView();
});