$(function(){
	var status0=false;
	var status1=false;
	var status2=false;
	var status3=false;
	$("input[name='enterprise_name']").blur(function(){
		var $this=$(this);
		var val=$this.val();
			val=$.trim(val);
			if(val.length>=4){
				$("span[for='nickName']").text("企业名称可用");
				$("span[for='nickName']").css("color","green");
				status3=true;
			}else{
				$("span[for=nickName]").text("*企业名称至少是4位");
				$("span[for=nickName]").css("color","red");
				status3=false;
			}
	});
});
