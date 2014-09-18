<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#" id="logo_name">HERAN</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li {if $main_menu_name == "main_menu_today_ad"}class="active"{/if}><a href="index.php?r=home/index">今日廣告</a></li>
            {if $permission.config_city.vw == 1 && $permission.config_area.vw == 1 && $permission.config_place.vw == 1 && $permission.config_branch.vw == 1}<li {if $main_menu_name == "main_menu_branch"}class="active"{/if}><a href="index.php?r=home/city&pos=1">分店管理</a></li>{/if}
            {if $permission.config_mac.vw == 1 && $permission.config_adtype.vw == 1 && $permission.config_ad.vw == 1}<li {if $main_menu_name == "main_menu_ad"}class="active"{/if}><a href="index.php?r=mac/index&pos=1">機台廣告管理</a></li>{/if}
            {if $permission.config_user.vw == 1 && $permission.config_permission.vw ==1}<li {if $main_menu_name == "main_menu_user"}class="active"{/if}><a href="index.php?r=user/index&pos=1">使用者管理</a></li>{/if}
            <li>
            <a href="webservice/index.html" target="_blank"><span class="glyphicon glyphicon-list-alt"></span> 文件</a></li>
            <li>
            <a href="index.php?r=index/logout"><span class="glyphicon glyphicon-log-out"></span> 登出 ({$smarty.session.USERID},您好)</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    