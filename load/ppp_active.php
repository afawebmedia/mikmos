<?php
error_reporting(0);
switch($_GET['get']){
default:
@session_start();
if(!isset($_SESSION['connect'])){
 echo "<meta http-equiv='refresh' content='0;url=./?load=settings' />";
}
$mikmosLoad = $API->comm("/ppp/active/print");
$mikmosTot = count($mikmosLoad);
	
?>
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <strong><?php echo __PPP_ACTIVE;?></strong> | <span class="text-danger"><?php if($mikmosTot < 2 ){echo "$mikmosTot"; }elseif($mikmosTot > 1){echo "$mikmosTot";}?></span> items | <i onclick="location.reload();" class="fa fa-refresh" style="cursor:pointer;" title="Reload data"></i>
					
                        <span class="tools pull-right">
                         </span>
                    </header>
                    <div class="panel-body">
					<?php //print_r($mikmosLoad);?>
					<div class="table-responsive">
                    <div class="adv-table">
                    <table class="table table-bordered table-hover" id="mikmos-tbl-noinfo">
  <thead>
  <tr>
    <th>Name</th>
    <th>Service</th>
    <th>Caller ID</th>
    <th>Address</th>
    <th>Uptime</th>
    <th>encoding</th>
    <th>session-id</th>
    <th style="text-align:center;">limit-bytes<br/>in /  out</th>
    <th style="text-align:center;">Status</th>
  </tr>
  </thead>
  <tbody>
<?php
	for ($i=0; $i<$mikmosTot; $i++){
	$mikmosData = $mikmosLoad[$i];
	if($mikmosData['radius']=='true'){$disabled = "<span class='label label-success'>".$mikmosData['radius']."</span>";}else{$disabled = "<span class='label label-danger'>".$mikmosData['radius']."</span>";}
	
	
	
?>
<tr>
<td><?php echo $mikmosData['name'];?></td>
<td><?php echo $mikmosData['service'];?></td>
<td><?php echo $mikmosData['caller-id'];?></td>
<td><?php echo $mikmosData['address'];?></td>
<td><?php echo $mikmosData['uptime'];?></td>
<td><?php echo $mikmosData['encoding'];?></td>
<td><?php echo $mikmosData['session-id'];?></td>
<td style="text-align:center;"><?php echo $mikmosData['limit-bytes-in'];?> / <?php echo $mikmosData['limit-bytes-out'];?></td>
<td style="text-align:center;"><?php echo $disabled;?></td>
</tr>
	<?php } ?>
  </tbody>
</table>
					</div>
					</div>
					
                    </div>
                </section>
            </div>
        </div>

<script type="text/javascript">
    setTimeout(function(){
       window.location.reload(1);
    }, 10000);
</script>
<?php

break;
case'type':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$idtype = $_GET['fix'];
$API->comm("/ppp/secret/set", array(
".id"=> "$idget",
"type"=> "$idtype"));
echo Loading('./?load=ppp','0');
break;
case'enable':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ppp/secret/set", array(
".id"=> "$idget",
"disabled"=> "true"));
echo Loading('./?load=ppp','0');
break;
case'disable':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ppp/secret/set", array(
".id"=> "$idget",
"disabled"=> "false"));
echo Loading('./?load=ppp','0');
break;
case'del':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ppp/secret/remove", array(
".id"=> "$idget",));
echo Loading('./?load=ppp','0');
break;
}
?>
