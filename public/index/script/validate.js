$(function() {
	$(".submit").click(function(e) {
		var i = 0, val, flag = true, inputList = $("input[type='text']"),
		len = inputList.length;
		for(;i < len;i++){
			if(!$(inputList[i]).val().trim()) {
				myalert('信息填写不完整！');
				e.preventDefault();
				return false;
			}
		}
		if($("input[name='club_owner_idcard']").length && !regRule.idcard.test($("input[name='club_owner_idcard']").val())) {
			myalert('请输入规范的身份证号码！');
			e.preventDefault();
			return false;
		}
		if($("input[name='member_tel']").length && !regRule.mobile.test($("input[name='member_tel']").val())) {
			myalert('请输入规范的手机号！');
			e.preventDefault();
			return false;
		}
	});

	$("#send-code").click(function(e) {
		var phone;
		e.preventDefault();

		if(phone = $("#send-code").prev('input').val().trim()) {
			if(!regRule.mobile.test(phone)) {
				myalert('请输入规范的手机号！');
				return false;
			}
		} else {
			myalert('手机号不能为空！');
			return false;
		}

		$.ajax({
			type:"POST",
			url:"./sendCode",
			data:{'memberTel' : $("input[name='member_tel']").val()},
			async:false,
			success: function(data) {
				myalert(data.msg);
				if(data.code == 1) {
					$("#send-code").addClass('active').attr('disabled',true);
					var count = 58,
						that = $("#send-code").text('59s后可重新发送'),
						interID = setInterval(function() {
							if(count == 0) {
								that.removeClass('active').text('发送验证码');
								clearInterval(interID);
								that.removeAttr("disabled");
								return;
							}
							that.text(count-- + 's后可重新发送');
						},1000)
				}
			}
		});
	});
});

var regRule = {
	idcard: /(^\d{15}$)|(^\d{17}([0-9]|X)$)/,
	mobile: /^1\d{10}$/,
	mail: /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/
};
