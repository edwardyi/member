<script type="text/javascript">
	$(document).ready(function(){
		$("#login").bootstrapValidator({
			container: 'popover', //tooltip
			feedbackIcons:{
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields:{
				account:{
					validators:{
						notEmpty:{
							message: '帳號必填'
						},
						stringLength:{
							enable:true,
							min:8,
							max:40,
							message: "帳號介於8到40字元"
						},
						regexp:{
							enable: true,
							regexp: /^[a-zA-Z\s]+$/,
							message: "帳號只允許文數字"
						}
					}
				},
				password:{
					validators:{
						notEmpty:{
							message: '密碼必填'
						},
						stringLength:{
							enable:true,
							min:6,
							max:40,
							message: "密碼介於6到40字元"
						}

					}
				}
			}
		});
			// $("#login").validateEngine();
			// $("#login").validationEngine();
	});


</script>
<form class="form-horizontal" action="login.php" class="memberForm" id="login" method="post">
	<div class="form-group">
		<label class="col-lg-offset-1 col-lg-3"><h2>會員登入</h2></label>
	</div>
	<div class="form-group">
		<label class="col-lg-2 control-label">帳號:</label>
		<div class="col-lg-2">
			<input class="form-control" type="text" name="account" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-lg-2 control-label">密碼:</label>
		<div class="col-lg-2">
			<input class="form-control" type="password" name="password" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-2">
			<input type="submit" class=" btn btn-primary" value="登入"/>
		</div>
		<div class="col-lg-2">
			<a class="btn btn-primary">註冊</a>
		</div>
	</div>
	
</form>