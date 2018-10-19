<?php
switch($_GET['get']){
default:
$mikmosLoad = $API->comm("/ppp/secret/getall");
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


<p class="text-muted">
<a title="Tambahkan Users" class="btn btn-success" href="./?load=ppp_user&get=add"> <i class="fa fa-plus"></i> <?php echo __ADD;?></a>
</p><hr>

<?php //print_r($mikmosLoad);?>
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

case'add':
$mikmosLoadP = $API->comm("/ip/hotspot/user/profile/print");
$mikmosLoadS = $API->comm("/ip/hotspot/print");
if(isset($_POST['save'])){
$server = ($_POST['server']);
$name = ($_POST['name']);
$password = ($_POST['pass']);
$profile = ($_POST['profile']);
$disabled = ($_POST['disabled']);
$timelimit = ($_POST['timelimit']);
$datalimit = ($_POST['datalimit']);
$comment = ($_POST['comment']);
$mbgb = ($_POST['mbgb']);
if($timelimit == ""){$timelimit = "0";}else{$timelimit = $timelimit;}
if($datalimit == ""){$datalimit = "0";}else{$datalimit = $datalimit*$mbgb;}
$API->comm("/ip/hotspot/user/add", array(
"server" => "$server",
"name" => "$name",
"password" => "$password",
"profile" => "$profile",
"disabled" => "no",
"limit-uptime" => "$timelimit",
"limit-bytes-total" => "$datalimit",
"comment" => "$comment",
));
$getuser = $API->comm("/ip/hotspot/user/print", array(
"?name"=> "$name",
));
$uid =$getuser[0]['.id'];
echo Loading('./?load=users&get=edit&id='.$uid.'','0');
}
?>
<script>
function PassUser(){
var x = document.getElementById('passUser');
if (x.type === 'password') {
x.type = 'text';
} else {
x.type = 'password';
}}
</script>

<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __ADD;?> <?php echo __USERS;?></strong>

<span class="tools pull-right">
 </span>
</header>
<form name="form" autocomplete="off" method="post" action="">
<div class="panel-body"><hr>
<?php //print_r($mikmosLoad);?>
<div class="row">
<div class="col-md-7">
<p class="text-muted">
<a class="btn btn-danger" href="./?load=users"> <i class="fa fa-close"></i> <?php echo __CANCEL;?></a>
<button type="submit" class="btn bg-primary" name="save"><i class="fa fa-save"></i> <?php echo __SAVE;?></button>
</p>
<table class="table">
<tr>
<td class="align-middle">Name</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
</tr>
<tr>
<td class="align-middle">Local Address</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
</tr>
<tr>
<td class="align-middle">Remote Address</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
</tr>
<tr>
<td class="align-middle">DNS Server</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
</tr>
<tr>
<td class="align-middle">Rate limit (rx/tx)</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
</tr>
<tr>
<td class="align-top">Parent Queue</td><td>
<select class="form-control" onchange="GetVP();" id="uprof" name="profile" required="1">
<option value="">=== Pilih Profil Users ===</option>
<?php $mikmosTot = count($mikmosLoadP);
for ($i=0; $i<$mikmosTot; $i++){
  $ponlogin = $mikmosLoadP[$i]['on-login'];
  $gettime = explode(",",$ponlogin)[5];
  if(empty($gettime)){
	  $gettime1 = explode(",",$ponlogin)[3];
	  }else{
	  $gettime1 = $gettime;
	  }
?>
<option onClick="form.timelimit.value='<?php echo $gettime1;?>'" value="<?php echo $mikmosLoadP[$i]['name'];?>"><?php echo $mikmosLoadP[$i]['name'];?></option>
<?php } ?>
</select>
<div id="GetValidPrice"></div>
<input hidden class="form-control" type="text"autocomplete="off" name="timelimit" value="">
</td>
</tr>
</table>
</div>
<div class="col-md-5">

</div>
</div>
</div>
</form>
</div>
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
