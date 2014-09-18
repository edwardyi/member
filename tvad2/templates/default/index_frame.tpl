<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>台灣彩卷資料抓取</title>

    <!-- Bootstrap core CSS -->
    <link href="css/layout/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{$main_css}" rel="stylesheet">

    <!--Bootstrap Select!-->
    <link href="js/silviomoreto-bootstrap-select-effe132/dist/css/bootstrap-select.min.css" rel="stylesheet">
	
    <!--Bootstrap Datetimepicker!-->
    <link href="js/bootstrap-datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet">
    <!-- Back to top -->
    <link rel="stylesheet" href="js/Simple-jQuery-Plugin-For-Scroll-To-Top-Button-scrollToTop/css/scrollToTop.css">

	<!--Loding!-->
    <link rel="stylesheet" href="http://msurguy.github.io/ladda-bootstrap/dist/ladda-themeless.min.css">
    {literal}
	<style>
		body{
			font-family: '微軟正黑體';
		}
        .glyphicon{
            cursor:pointer;
        }
        .table_td_center{
            text-align:center;
        }
        .sub_content_top{
            margin:0 15px;
            padding-bottom:10px;
        }
        .sub_content_top p.bg-danger {
            padding: 5px;
            text-align: center;
        }
        #logo_name{
            color:#FFF !important;
        }
        .navbar-nav>li>a {
            font-size: 16px;
            font-weight: bold;
        }
        .green{
            color:#0f0;
        }
        .gray{
            color:#e0e0e0;
        }
        .red{
            color:#f00;
        }
        button{
            cursor:pointer;
        }
      /*  ul.dropdown-menu {
            height: 300px;
            overflow-y: auto;
        }*/
	</style>
	{/literal}
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/layout/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/layout/ie10-viewport-bug-workaround.js"></script>

 
  </head>

  <body>
    
	{include file=$content}

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/layout/bootstrap.min.js"></script>
    <script src="js/layout/offcanvas.js"></script>
    <!--Bootstrap Select!-->
    <script src="js/silviomoreto-bootstrap-select-effe132/dist/js/bootstrap-select.min.js"></script>
    <!--Bootstrap Datetimepicker!-->
    <script src="js/bootstrap-datetimepicker/mount.js"></script>
    <script src="js/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
    <!-- Back to top -->
    <script src="js/Simple-jQuery-Plugin-For-Scroll-To-Top-Button-scrollToTop/src/jquery-scrollToTop.js"></script>

    <!-- LOADING -->
    <script src="http://msurguy.github.io/ladda-bootstrap/dist/spin.min.js"></script>
    <script src="http://msurguy.github.io/ladda-bootstrap/dist/ladda.min.js"></script>


    <script>

    {literal}
    
        $(function(){
            //Back to top
            $('body').scrollToTop({skin: 'cycle'});
            
            //tooltip
            $('.glyphicon').tooltip();
            // $('.form_column').tooltip();

            //select style
            $('.selectpicker').selectpicker({width:'auto'});

            //datetimepicker
             $('.datetimepicker').datetimepicker({format:"YYYY-MM-DD HH:mm"});
             $('.timepicker').datetimepicker({pickDate: false,format:"HH:mm"});
             $('.datepicker').datetimepicker({pickTime: false});
             

             $(".glyphicon-pencil").on("click",function(){
                $(this).parent().parent().hide();
                $(this).parent().parent().next().show();
             })

             $(".btn_cancel").on("click",function(){
                $(this).parent().parent().hide();
                $(this).parent().parent().prev().show();
             })

             $(".btn_save").on("click",function(){
                _this = $(this).parent().parent();
                _data = _this.find("input,select").serialize();
                $.ajax({
                    url:"index.php?r=index/save",
                    type:"post",
                    data:_data ,
                    success:function(){
                       _this.hide();
                       _this.prev().show();
                       _this.prev().find("td:nth-child(1)").text(_this.find("td:nth-child(1) select").val());
                       _this.prev().find("td:nth-child(2)").text(_this.find("td:nth-child(2) input").val());
                       _this.prev().find("td:nth-child(3)").text(_this.find("td:nth-child(3) input").val());
                       _this.prev().find("td:nth-child(4)").text(_this.find("td:nth-child(4) input").val());
                       _this.prev().find("td:nth-child(5)").text(_this.find("td:nth-child(5) input").val());
                    }
                })

             })

            $("#update_lottery").on("click",function(){
                    var l = Ladda.create(this);
                    l.start();
                $.ajax({
                    url:"webservice/get_lottery.php?reload=5",
                    success:function(e){
                        
                       if(e == 1){
                            alert("有新開獎資料，按下確定後網頁將刷新");
                            location.reload();
                       }else{
                            l.stop();
                            alert("無新開獎資料");
                       }
                    }
                });

            })


        })
        
             

    {/literal}
    </script>
  </body>
</html>
