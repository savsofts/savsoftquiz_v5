 <style>
  
 
#exTab1 .tab-content {
border:1px solid #dddddd;
padding:20px;
  color : #212121;
  background-color: #ffffff;
  padding : 5px 15px;
}

#exTab2 h3 {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}

/* remove border radius for the tab */

#exTab1 .nav-pills > li > a {
  border-radius: 0;
}

/* change border radius for the tab , apply corners on top*/

#exTab3 .nav-pills > li > a {
  border-radius: 4px 4px 0 0 ;
}

#exTab3 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}


.slink{
	background: #dddddd;
}




</style>

<?php 
 if($quid==0){
$uid=$user['uid'];

			 $sl="select * from savsoft_group where gid in ($gids) ";
			 
			$rq=$this->db->query($sl);
			 
			$gr=$rq->result_array();
			$pricek=0;
			
			foreach($gr as $k => $gv){
				$gid=$gv['gid'];
			$sl2="select * from savsoft_payment where uid='$uid' and gid='$gid' and payment_status='Paid' ";
			$sl3=$this->db->query($sl2);
			  
				if($sl3->num_rows() == 0){
				$pricek+=$gv['price'];
				 
				}
				
				}
 }else{
	
$pricek=$quiz['quiz_price'];
	
 }
			 
?>
			
<div class="container">

  <div class="row">
    
<div class="col-md-10">

<?php 
if(!$this->session->userdata('logged_in')){
?>
	  	<img src="<?php echo base_url('images/logo.png');?>">
	  	<?php 
	  	}
	  	?>
	
  
   
<div class="container">



<div style="margin-top:50px;margin-bottom:50px;">

<h3><?php echo $this->lang->line('select_payment_gateway');?> </h3>

   </div>

</div>
<div id="exTab1" class="container">	
<ul  class="nav nav-pills">
<?php 
  if($this->config->item('paypal')=='true'){
?>
<li class=""><a  href="#1a" data-toggle="tab" class="active tabtitle slink" onClick="showtab('#1a',this);" ><?php echo $this->lang->line('paypal');?></a>
</li>
<?php 
 }
  if($this->config->item('checkout')=='true'){
?>
<li><a href="#2a" data-toggle="tab" onClick="showtab('#2a',this);" class="tabtitle" ><?php echo $this->lang->line('checkout');?></a>
</li>
<?php 
 }
  if($this->config->item('payumoney')=='true'){
?>

<li><a href="#3a" data-toggle="tab" onClick="showtab('#3a',this);" class="tabtitle" ><?php echo $this->lang->line('payumoney');?></a>
</li>
 <?php 
 }
  if($this->config->item('paytm')=='true'){
?>
 		
<li><a href="#4a" data-toggle="tab" onClick="showtab('#4a',this);" class="tabtitle" ><?php echo $this->lang->line('paytm');?></a>
</li>
<?php 
}
?>		
</ul>

<div class="tab-content clearfix">
<div class="tab-pane active" id="1a">
         
         
   <?php 
  if($this->config->item('paypal')=='true'){
?>
<?php 
if($quid != 0){
echo $this->lang->line('paytoattempt')." '".$quiz['quiz_name']."'";	
}
?>
	<br><br>
 <?php echo $this->lang->line('price_');?>: <?php echo $this->config->item('paypal_currency_prefix');?> <?php echo $pricek*$this->config->item('paypal_conversion');?> <?php echo $this->config->item('paypal_currency_sufix');?><br>




<form name="_xclick" action="https://www.<?php echo $this->config->item('paypal_environment');?>paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $this->config->item('paypal_receiver');?>">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="item_name" value="<?php echo $this->lang->line('quiz_subscription');?>">
<input type="hidden" name="notify_url" value="<?php echo site_url('payment_gateway_2/paypal_ipn');?>">
<input type="hidden" name="custom" value="<?php echo $user['uid'].'-'.str_replace(',',':',$gids).'-'.$quid;?>">
<input type="hidden" name="return" value="<?php echo site_url('payment_gateway_2/success');?>">
<input type="hidden" name="cancel_return" value="<?php echo site_url('payment_gateway_2/cancel');?>">
<input type="hidden" name="amount" value="<?php echo $pricek*$this->config->item('paypal_conversion');?>">
<input  class="btn btn-default" value="<?php echo $this->lang->line('paynow');?>"  type="submit"  name="submit" alt="">
</form>

 
 
 <?php 
  }
  ?>     
         
         
         
</div>
<div class="tab-pane" id="2a">


<?php 
  if($this->config->item('checkout')=='true'){
	  ?>
	  <?php 
if($quid != 0){
echo $this->lang->line('paytoattempt')." '".$quiz['quiz_name']."'";	
}
?>
	<br><br>
 <?php echo $this->lang->line('price_');?>: <?php echo $this->config->item('checkout_currency_prefix');?> <?php echo $pricek*$this->config->item('checkout_conversion');?> <?php echo $this->config->item('checkout_currency_sufix');?><br>



<form action="https://<?php echo $this->config->item('checkout_environment');?>2checkout.com/checkout/purchase" method='post'>
  <input type='hidden' name='sid' value="<?php echo $this->config->item('checkout_sid');?>" />
  <input type='hidden' name='x_receipt_link_url' value="<?php echo site_url('payment_gateway_2/checkout_ipn/');?>" />
  <input type='hidden' name='mode' value='2CO' />
  <input type='hidden' name='currency_code' value="<?php echo $this->config->item('checkout_currency_sufix');?>" />
  <input type='hidden' name='li_0_type' value='product' />
  <input type='hidden' name='custom' value="<?php echo $user['uid'].'-'.str_replace(',',':',$gids).'-'.$quid;?>" />
  <input type='hidden' name='li_0_name' value="<?php echo $this->lang->line('quiz_subscription');?>" />
  <input type='hidden' name='li_0_price' value="<?php echo $pricek*$this->config->item('checkout_conversion');?>" />
  <input name='submit' type='submit' class="btn btn-default" value="<?php echo $this->lang->line('paynow');?>" />
</form>

  
 
 <?php 
  }
  ?>

</div>
<div class="tab-pane" id="3a">
  
<?php 
   if($this->config->item('payumoney')=='true'){  
 
	  ?>
	  <?php 
if($quid != 0){
echo $this->lang->line('paytoattempt')." '".$quiz['quiz_name']."'";	
}
?>
	<br><br>
 <?php echo $this->lang->line('price_');?>: <?php echo $this->config->item('payumoney_currency_prefix');?> <?php echo $group['price']*$this->config->item('payumoney_conversion');?> <?php echo $this->config->item('payumoney_currency_sufix');?><br>

 
 <?php
 $pricepayu=$pricek*$this->config->item('payumoney_conversion');
 // Merchant key here as provided by Payu
$MERCHANT_KEY = $this->config->item('payu_merchant_key');

// Merchant Salt as provided by Payu
$SALT =  $this->config->item('payu_salt');
$txnid = $user['uid'];
$hash_string = $MERCHANT_KEY."|".$txnid."|".$pricepayu."|".$this->lang->line('quiz_subscription')."|".$user['first_name']."|".$user['email']."|".$user['uid'].'-'.str_replace(',',':',$gids).'-'.$quid."||||||||||".$SALT;
$hash = hash('sha512', $hash_string);
    //print_r( $hash_string);
	//echo"<br>";
	//print_r($hash);
?>
<form method="POST" action="https://secure.payu.in/_payment">

 <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY; ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash; ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid; ?>" />
     
	 
	 
  <input type="hidden" name="phone" value="<?php echo $user['contact_no'];?>" />
	 <input type="hidden" name="amount" value="<?php echo $pricepayu;?>" />
	
	<input type="hidden" name="firstname" id="firstname" value="<?php echo $user['first_name'];?>" >
	<input type="hidden"  name="email" id="email" value="<?php echo $user['email'];?>"  />
	 <input type="hidden"  name="productinfo" value="<?php echo $this->lang->line('quiz_subscription');?>">
		  <input type="hidden"  name="surl" value="<?php echo site_url('payment_gateway_2/success/payu');?>" size="64" />
		  <input type="hidden"  name="furl" value="<?php echo site_url('payment_gateway_2/cancel');?>" size="64" />
		  <input type="hidden"   name="service_provider" value="payu_paisa" size="64" />
<input  type="hidden"  name="udf1" value="<?php echo $user['uid'].'-'.str_replace(',',':',$gids).'-'.$quid;?>">
 
 <input type="submit" value="<?php echo $this->lang->line('paynow');?>" class="btn btn-default" >
</form>

  
 <?php 
  }  
  
  ?>

</div>
<div class="tab-pane" id="4a">
<?php 
if($quid != 0){
echo $this->lang->line('paytoattempt')." '".$quiz['quiz_name']."'";	
}
?>
 <?php 
   
  // paytm gateway
   
  if($this->config->item('paytm')=='true'){
$checkSum = "";
$paramList = array();

$ORDER_ID = $user['uid'].'-'.str_replace(',',':',$gids).'-'.rand(11111,99999).'-'.$quid;
$CUST_ID = $user['uid'];
$INDUSTRY_TYPE_ID = 'Retail';
$CHANNEL_ID = 'WEB';
$TXN_AMOUNT = $pricek*$this->config->item('paytm_conversion');

 
$paramList["MID"] = PAYTM_MERCHANT_MID;
$paramList["ORDER_ID"] = $ORDER_ID;
$paramList["CUST_ID"] = $CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
$paramList["CHANNEL_ID"] = $CHANNEL_ID;
$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
$paramList["CALLBACK_URL"] = site_url('payment_gateway_2/success/paytm');
$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

 
$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);

  ?>
 	<br><br>
 <?php echo $this->lang->line('price_');?>: <?php echo $this->config->item('payumoney_currency_prefix');?> <?php echo $pricek*$this->config->item('payumoney_conversion');?> <?php echo $this->config->item('payumoney_currency_sufix');?><br>

 <form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			<input type="hidden" name="CALLBACK_URL" value="<?php echo site_url('payment_gateway_2/success/paytm'); ?>">
			</tbody>
		</table>
		<input type="submit" value="<?php echo $this->lang->line('paynow');?>" class="btn btn-default" > 
	</form>
 
 <?php 
 }
 ?>

</div>
</div>
</div>




	 
 
 
</div> 
</div> 
 
</div>
<script>
function showtab(d,e){
	$('.tabtitle').removeClass('slink');
	$(e).addClass('slink');
	 $('.tab-pane').css('display','none');
	$(d).css('display','block');
}
</script>