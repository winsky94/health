//function open_modal(){
//    $('#modal1').openModal();
//}


//函数返回名称为name的cookie值，如果不存在则返回空
function get_cookie(name){
      var strcookie=document.cookie;
      var arrcookie=strcookie.split("; ");
      for(var i=0;i<arrcookie.length;i++){
            var arr=arrcookie[i].split("=");
            if(arr[0]==name)return unescape(arr[1]);
      }
      return "";
}

function add_cookie(name,value,expireHours){

      var cookieString=name+"="+escape(value);
      //判断是否设置过期时间
      if(expireHours>0){
             var date=new Date();
             date.setTime(date.getTime+expireHours*3600*1000);
             cookieString=cookieString+"; expire="+date.toGMTString();
      }
      document.cookie=cookieString;
}

function delete_cookie(){
    var date=new Date();
    date.setTime(date.getTime()-10000);
    document.cookie='userName'+'=v; expire='+date.toGMTString();
}


function check_cookie(){
  var userName=get_cookie('userName');
  if (userName!=null && userName!="" && userName!='v'){
      return true;
  }else{
      return false;
  }
}

function write_header(){
  var login=check_cookie();
  if(!login){
    write_header_not_login();
  }else{
    var userName=get_cookie('userName');
    var type=get_cookie('type');
    write_header_login(userName,type);
  }
}

function exit(){
   delete_cookie('userName');
   window.location.href="../view/index.html";
}

function write_header_login(userName,type){
	if(type=='admin'){
		// 系统管理员的页头
		var txt=' \
			<script> \
				$(document).ready(function(){  \
					$(".dropdown-button").dropdown();  \
			    	$(".button-collapse").sideNav();  \
			    	$(".modal-trigger").leanModal();  \
			   }); \
			</script> \
			<!-- Dropdown Structure -->\
    		<ul id="dropdown1" class="dropdown-content">\
      			<li><a href="">活动管理</a></li>\
      			<li><a href="../view/releaseEvents.php?userName='+userName+'">发布活动</a></li>\
      			<li><a href="../view/showEvents.php">查看活动</a></li>\
    		</ul>\
    		<!-- Dropdown Structure -->\
    		<ul id="dropdown2" class="dropdown-content">\
    			<li><a href="">'+userName+'</a></li>\
    			<li><a href="user.php?userName='+userName+'">个人信息</a></li>\
    			<li><a href="" onclick="exit()">退出登录</a></li>\
    		</ul>\
        <!-- Dropdown Structure -->\
        <ul id="dropdown8" class="dropdown-content">\
          <li><a href="">用户管理</a></li>\
          <li><a href="../view/userManage.php?type=user">个人用户</a></li>\
          <li><a href="../view/userManage.php?type=doctor-coach">医生教练</a></li>\
        </ul>\
    		<div class="navbar-fixed"> \
        		<nav> \
           		<div class="nav-wrapper teal lighten-3"> \
               		<div class="container"> \
                   		<div class="row"> \
                           	<a href="" class="brand-logo">uniFIT</a> \
                           	<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a> \
                           	<ul class="right hide-on-med-and-down"> \
	                           	<li> \
	                                   <a href="index.html">首页</a> \
	                               </li> \
	                               <!-- Dropdown Trigger --> \
	                           	<li> \
	                           	    <a class="dropdown-button" id="action" title=活动管理 href="" data-activates="dropdown1">活动管理<i class="material-icons right">arrow_drop_down</i> \
	                           	    </a> \
	                           	</li> \
                               	<li> \
                                  <a class="dropdown-button" id="users" title=用户管理 href="" data-activates="dropdown8">用户管理<i class="material-icons right">arrow_drop_down</i> \
                                  </a> \
                              </li> \
	                               <li> \
	                                   <a href="">查看举报</a> \
	                               </li> \
	                               <li> \
                                    <a class="dropdown-button" id="user-name" title="'+userName+'" href="" data-activates="dropdown2">'+userName+'<i class="material-icons right">arrow_drop_down</i> \
                                    </a> \
                                </li> \
                           	</ul> \
                   		</div> \
               		</div> \
               	</div> \
               </nav> \
           </div> \
		';
	}else if(type=='user'){
		var txt='\
			<script> \
				$(document).ready(function(){  \
					$(".dropdown-button").dropdown();  \
			    	$(".button-collapse").sideNav();  \
			    	$(".modal-trigger").leanModal();  \
			   }); \
			</script> \
    		<!-- Dropdown Structure -->\
    		<ul id="dropdown4" class="dropdown-content">\
    			<li><a href="">建议管理</a></li>\
      			<li><a href="../view/showSuggestions.php?userName='+userName+'">查看建议</a></li>\
      			<li><a href="../view/reserve.php?userName='+userName+'&type=doctor-coach">预约</a></li>\
    		</ul>\
    		<!-- Dropdown Structure -->\
    		<ul id="dropdown5" class="dropdown-content">\
    			<li><a href="">'+userName+'</a></li>\
    			<li><a href="user.php?userName='+userName+'">个人信息</a></li>\
    			<li><a href="" onclick="exit()">退出登录</a></li>\
    		</ul>\
		    <div class="navbar-fixed"> \
        		<nav> \
            		<div class="nav-wrapper teal lighten-3"> \
                		<div class="container"> \
                    		<div class="row"> \
                            	<a href="" class="brand-logo">uniFIT</a> \
                            	<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a> \
                            	<ul class="right hide-on-med-and-down"> \
                                	<li> \
                                    	<a href="index.html">首页</a> \
                                	</li> \
                                	<li> \
                                    	<a href="../view/healthManage.php">健康管理</a> \
                                	</li> \
                                	<li> \
                                    	<a href="../view/showEvents.php">参与活动</a> \
                                	</li> \
                                	<li> \
	                                    <a class="dropdown-button" title=建议管理 href="" data-activates="dropdown4">建议管理<i class="material-icons right">arrow_drop_down</i> \
	                                    </a> \
	                                </li>  \
	                                <li> \
	                                    <a href="#">朋友圈</a> \
	                                </li> \
	                                <li> \
	                                    <a href="#">兴趣组</a> \
	                                </li> \
	                                <!-- Dropdown Trigger --> \
	                                <li> \
	                                    <a class="dropdown-button" id="user-name" title="'+userName+'" href="" data-activates="dropdown5">'+userName+'<i class="material-icons right">arrow_drop_down</i> \
	                                    </a> \
	                                </li> \
	                            </ul> \
	                    	</div> \
	                	</div> \
                	</div>\
                </nav>\
            </div>\
		';
	}else if(type=='coach'||type=='doctor'){
		var txt='\
			<script> \
				$(document).ready(function(){  \
					$(".dropdown-button").dropdown();  \
			    	$(".button-collapse").sideNav();  \
			    	$(".modal-trigger").leanModal();  \
			   }); \
			</script> \
			<!-- Dropdown Structure -->\
			<!-- Dropdown Structure -->\
			<ul id="dropdown6" class="dropdown-content">\
    			<li><a href="">发布建议</a></li>\
    			<li><a href="../view/releaseSuggestion.php?userName=' + userName + '">在线填写</a></li>\
    			<li><a href="../view/uploadSuggestion.php?userName='+userName+'">文件导入</a></li>\
    		</ul>\
			<ul id="dropdown7" class="dropdown-content">\
    			<li><a href="">'+userName+'</a></li>\
    			<li><a href="user.php?userName='+userName+'">个人信息</a></li>\
    			<li><a href="" onclick="exit()">退出登录</a></li>\
    		</ul>\
    		<div class="navbar-fixed"> \
        		<nav> \
            		<div class="nav-wrapper teal lighten-3"> \
                		<div class="container"> \
                    		<div class="row"> \
                            	<a href="" class="brand-logo">uniFIT</a> \
                            	<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a> \
                            	<ul class="right hide-on-med-and-down"> \
                                	<li> \
                                    	<a href="index.html">首页</a> \
                                	</li> \
                                	<!-- Dropdown Trigger --> \
                                	<li> \
	                                    <a class="dropdown-button" title=发布建议 href="" data-activates="dropdown6">发布建议<i class="material-icons right">arrow_drop_down</i> \
	                                    </a> \
	                                </li>  \
                                	<li> \
                                    	<a href="#">查看预约客户</a> \
                                	</li> \
	                                <!-- Dropdown Trigger --> \
	                                <li> \
	                                    <a class="dropdown-button" id="user-name" title="'+userName+'" href="" data-activates="dropdown7">'+userName+'<i class="material-icons right">arrow_drop_down</i> \
	                                    </a> \
	                                </li> \
	                            </ul> \
	                    	</div> \
	                	</div> \
                	</div>\
                </nav>\
            </div>\
		';
	}
    
    $("header").html(txt);
}

function write_header_not_login(){
    var txt='<script>  \
       $(document).ready(function(){  \
         $(".dropdown-button").dropdown();  \
         $(".button-collapse").sideNav();  \
         $(".modal-trigger").leanModal();  \
       }); \
    </script> \
    <!-- Dropdown Structure --> \
        <div class="navbar-fixed"> \
        <nav> \
            <div class="nav-wrapper teal lighten-3"> \
                <div class="container"> \
                    <div class="row"> \
                        <div class="col l6 s12"> \
                            <a href="" class="brand-logo">uniFIT</a> \
                            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a> \
                        </div> \
                        <ul class="right hide-on-med-and-down"> \
                            <li><a class="modal-trigger" href="#modal1">登录/注册</a></li> \
                        </ul> \
                        <ul class="side-nav" id="mobile-demo"> \
                            <li><a class="modal-trigger" id="login-trigger" href="#modal1">登录/注册</a></li> \
                        </ul> \
                    </div> \
                </div> \
            </div> \
        </nav> \
        </div> \
        <!-- Modal Structure --> \
        <div id="modal1" class="modal"> \
            <div class="modal-content"> \
                <section class="loginBox row-fluid"> \
                    <div class="tabbable" id="tabs-634549"> \
                            <div class="tab-content"> \
                                <div class="tab-pane" id="panel-60560"></div> \
                                <div class="tab-pane active" id="panel-549981"> \
                                    <div> \
                                        <input id="userName" type="text" name="userName" \
                                            placeholder="用户名" /> \
                                    </div> \
                                    <div> \
                                        <input id="password" type="password" name="password" onkeydown="if(event.keyCode==13){verify_login()}" \
                                            placeholder="密码" /> \
                                    </div> \
                                    <p> \
                                        <input type="checkbox" class="filled-in" id="test1" /> <label \
                                            for="test1">下次自动登录</label><font color="red" size="2"> \
                                            <span id="result"> </span></font><br/><br/> \
                                    </p> \
                                    <div class="span1"> \
                                        <input type="submit" value=" 登录 " onclick="verify_login()" \
                                            class="btn btn-primary"> <a href="sign_up.html"> \
                                            <input type="button" value=" 注册 " class="btn btn-primary"> \
                                        </a> \
                                    </div> \
                                </div> \
                            </div> \
                    </div> \
                </section> \
            </div> \
        </div>';
        $("header").html(txt);
}
