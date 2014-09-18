<div class="container">

<nav class="navbar navbar-default" role="navigation" style="margin-top:-60px">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="webservice/index.html" target="_blank"><span class="glyphicon glyphicon-list-alt"></span> 文件</a>
    </div>
  </div><!-- /.container-fluid -->
</nav>

<button type="button" class="btn btn-danger ladda-button" id="update_lottery"  data-style="expand-left">抓取台彩最新資料</button>
<br><br>
  <div class="panel panel-warning">
    <!-- Default panel contents -->
    <div class="panel-heading"><span class="glyphicon glyphicon-search"></span> 搜尋</div>
    <div class="panel-body">
            <form action="index.php" method="get">
              <input type="hidden" name="r" value="index/index">
              <input type="hidden" name="q" value="1">
              <div class="row">
                  <select class="selectpicker" name="type">
                      <option value="">類型</option>
                      <option value="威力彩" {if $p.type == '威力彩'}selected{/if}>威力彩</option>
                      <option value="38樂合彩" {if $p.type == '38樂合彩'}selected{/if}>38樂合彩</option>
                      <option value="大樂透" {if $p.type == '大樂透'}selected{/if}>大樂透</option>
                      <option value="49樂合彩" {if $p.type == '49樂合彩'}selected{/if}>49樂合彩</option>
                      <option value="今彩539" {if $p.type == '今彩539'}selected{/if}>今彩539</option>
                      <option value="39樂合彩" {if $p.type == '39樂合彩'}selected{/if}>39樂合彩</option>
                      <option value="三星彩" {if $p.type == '三星彩'}selected{/if}>三星彩</option>
                      <option value="四星彩" {if $p.type == '四星彩'}selected{/if}>四星彩</option>
                  </select>
                  
                  <div class="col-xs-2">
                    <input type="text" name="open_code" value="{$p.open_code}" class="form-control" placeholder="期數">
                  </div>
                  <div class="col-xs-2">
                    <input type="text" name="open_date" value="{$p.open_date}" class="form-control" placeholder="開獎時間">
                  </div>
                  <!-- <div class="col-xs-3" style="margin-left:-12px">
                    <div class='input-group date datepicker'>
                            <input type='text' name="open_date" class="form-control" placeholder="開獎時間(起)" value="{$p.open_date}" data-date-format="YYYY-MM-DD"/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                  </div> -->
                  
                <button type="submit" class="btn btn-success btn-sm" style="margin-top:-10px"><span class="glyphicon glyphicon-search"></span> 搜尋</button>
                <button type="button" class="btn btn-info btn-sm" style="margin-top:-10px" onclick="location.href='index.php?r=index/index&clear=1'"><span class="glyphicon glyphicon-record"></span> 清除條件</button>
            </div>
            </form>
    </div>
       <table class="table table-bordered">
          
          <tr class="danger">
            <th>類型</th>
            <th>開獎日期</th>
            <th>期數</th>
            <th>開獎結果</th>
            <th>特別號</th>
            <th width="50">操作</th>
          </tr>
          {foreach from=$lists item=obj name=row}
          <tr>
            <td>{$obj->type}</td>
            <td>{$obj->open_date}</td>
            <td>{$obj->open_code}</td>
            <td>{$obj->result}</td>
            <td>{$obj->special}</td>
            <td style="text-align:center">
              <!-- <span class="glyphicon glyphicon-eye-open" data-placement="top" title="詳細資料"></span> |  -->
              <span class="glyphicon glyphicon-pencil" data-placement="top" title="編輯"></span><!--  | 
              <span class="glyphicon glyphicon-trash" data-placement="top" title="刪除"></span> -->
            </td>
          </tr>
          <tr style="display:none">
            <td> 
                <input type="hidden" name="id" value="{$obj->id}">
                <select class="selectpicker" name="type">
                      <option value="">類型</option>
                      <option value="威力彩" {if $obj->type == '威力彩'}selected{/if}>威力彩</option>
                      <option value="38樂合彩" {if $obj->type == '38樂合彩'}selected{/if}>38樂合彩</option>
                      <option value="大樂透" {if $obj->type == '大樂透'}selected{/if}>大樂透</option>
                      <option value="49樂合彩" {if $obj->type == '49樂合彩'}selected{/if}>49樂合彩</option>
                      <option value="今彩539" {if $obj->type == '今彩539'}selected{/if}>今彩539</option>
                      <option value="39樂合彩" {if $obj->type == '39樂合彩'}selected{/if}>39樂合彩</option>
                      <option value="三星彩" {if $obj->type == '三星彩'}selected{/if}>三星彩</option>
                      <option value="四星彩" {if $obj->type == '四星彩'}selected{/if}>四星彩</option>
                  </select> 
            </td>
            <td><input type="text" name="open_date" value="{$obj->open_date}" class="form-control" placeholder="開獎日期"></td>
            <td><input type="text" name="open_code" value="{$obj->open_code}" class="form-control" placeholder="期數"></td>
            <td><input type="text" name="result" value="{$obj->result}" class="form-control" placeholder="開獎結果"></td>
            <td><input type="text" name="special" value="{$obj->special}" class="form-control" placeholder="特別號"></td>
            <td>
              <button type="button" class="btn btn-success btn-xs btn_save">儲存</button>
              <button type="button" class="btn btn-primary btn-xs btn_cancel">取消</button>
            </td>
          </tr>
          {/foreach}

       </table>
  </div>
  {include file=$pager_page}
</div> <!-- /container -->
