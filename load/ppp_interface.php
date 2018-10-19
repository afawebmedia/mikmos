<?php
error_reporting(0);
switch($_GET['get']){
default:
@session_start();
if(!isset($_SESSION['connect'])){
 echo "<meta http-equiv='refresh' content='0;url=./?load=settings' />";
}
  $mikmosLoad = $API->comm("/interface/pptp-client/print");
	$mikmosTot = count($mikmosLoad);
	
?>
		
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <strong><?php echo __PPP_USER;?></strong> | <span class="text-danger"><?php if($mikmosTot < 2 ){echo "$mikmosTot"; }elseif($mikmosTot > 1){echo "$mikmosTot";}?></span> items | <i onclick="location.reload();" class="fa fa-refresh" style="cursor:pointer;" title="Reload data"></i>
					
                        <span class="tools pull-right">
                         </span>
                    </header>
                    <div class="panel-body">
					<?php print_r($mikmosLoad);?>
					<div class="table-responsive">
                    <div class="adv-table">
                    <table class="table table-bordered table-hover" id="mikmos-tbl-noinfo">
  <thead>
  <tr>
    <th></th>
    <th>Name</th>
    <th style="width:10%;text-align:center;">Password</th>
    <th>Service</th>
    <th>Remote Address</th>
    <th>Last Logout</th>
    <th>Coment</th>
    <th>Status</th>
  </tr>
  </thead>
  <tbody>
<?php
	for ($i=0; $i<$mikmosTot; $i++){
	$mikmosData = $mikmosLoad[$i];
	if($mikmosData['disabled']=='true'){$disabled = "<a  title='Enable' href='./?load=ppp_user&get=enable=".$mikmosData['.id'] . "'><span class='label label-danger'>disable</span></a>";}else{$disabled = "<a  title='Disable' href='./?load=ppp_user&get=disable=".$mikmosData['.id'] . "'><span class='label label-success'>enable</span></a>";}
	
	
	
?>
<tr>
<td><a  title='Remove' href='./?load=ppp_user&get=del&id=<?php echo $mikmosData['.id'];?>' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></a></td>
<td><a  title='Edit' href='./?load=ppp_user&get=edit&id=<?php echo $mikmosData['.id'];?>#' class='btn btn-info btn-xs'><i class='fa fa-edit'></i> <?php echo $mikmosData['name'];?></a></td>
<td><?php echo $mikmosData['password'];?> </td>
<td><?php echo $mikmosData['service'];?></td>
<td><?php echo $mikmosData['remote-address'];?></td>
<td><?php echo $mikmosData['last-logged-out'];?></td>
<td><?php echo $mikmosData['comment'];?></td>
<td><?php echo $disabled;?></td>
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
echo Loading('./?load=ppp_user','0');
break;
case'enable':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ppp/secret/set", array(
".id"=> "$idget",
"disabled"=> "false"));
echo Loading('./?load=ppp_user','0');
break;
case'disable':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ppp/secret/set", array(
".id"=> "$idget",
"disabled"=> "true"));
echo Loading('./?load=ppp_user','0');
break;
case'del':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ppp/secret/remove", array(
".id"=> "$idget",));
echo Loading('./?load=ppp_user','0');
break;
}
?>
