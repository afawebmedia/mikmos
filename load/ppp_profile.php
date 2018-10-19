<?php
error_reporting(0);
switch($_GET['get']){
default:
@session_start();
if(!isset($_SESSION['connect'])){
 echo "<meta http-equiv='refresh' content='0;url=./?load=settings' />";
}
$mikmosLoad = $API->comm("/ppp/profile/getall");
$mikmosTot = count($mikmosLoad);
?>
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <strong><?php echo __PPP_PROFILE;?></strong> | <span class="text-danger"><?php if($mikmosTot < 2 ){echo "$mikmosTot"; }elseif($mikmosTot > 1){echo "$mikmosTot";}?></span> items | <i onclick="location.reload();" class="fa fa-refresh" style="cursor:pointer;" title="Reload data"></i>
					
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
    <th></th>
    <th>Name</th>
    <th>Local Address</th>
    <th>Remote Address</th>
    <th>Only One</th>
    <th>Rate Limit</th>
    <th>Coment</th>
  </tr>
  </thead>
  <tbody>
<?php
	for ($i=0; $i<$mikmosTot; $i++){
	$mikmosData = $mikmosLoad[$i];
	if($mikmosData['disabled']=='true'){$disabled = "<a  title='Enable' href='./?load=ppp&get=disable=".$mikmosData['.id'] . "'><span class='label label-danger'>disable</span></a>";}else{$disabled = "<a  title='Disable' href='./?load=ppp&get=enable=".$mikmosData['.id'] . "'><span class='label label-success'>enable</span></a>";}
	
	
	
?>
<tr>
<td><a  title='Remove' href='./?load=ppp&get=del&id=<?php echo $mikmosData['.id'];?>'><i class='fa fa-trash text-danger'></i></a></td>
<td><?php echo $mikmosData['name'];?></td>
<td><?php echo $mikmosData['local-address'];?></td>
<td><?php echo $mikmosData['remote-address'];?></td>
<td><?php echo $mikmosData['only-one'];?></td>
<td><?php echo $mikmosData['rate-limit'];?></td>
<td><?php echo $mikmosData['comment'];?></td>
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
case'del':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ppp/profile/remove", array(
".id"=> "$idget",));
echo Loading('./?load=ppp_profile','0');
break;
}
?>
