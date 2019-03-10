<?php
global $wpdb;
wp_enqueue_script('iv_directories-script-signup-2-15', wp_iv_directories_URLPATH . 'admin/files/js/jquery.form-validator.js');
wp_enqueue_style('profile-signup-style', falcons_CSS.'profile-registration.css', array(), $ver = false, $media = 'all');


$api_currency= 'USD';
if( get_option('_iv_directories_api_currency' )!=FALSE ) {
	$api_currency= get_option('_iv_directories_api_currency' );
}
if(isset($_REQUEST['payment_gateway'])){

		$payment_gateway=$_REQUEST['payment_gateway'];
		if($payment_gateway=='paypal'){
			//include(wp_iv_directories_DIR . '/admin/pages/payment-inc/paypal-submit.php');
		}
}

		$iv_gateway='paypal-express';
		if( get_option( 'iv_directories_payment_gateway' )!=FALSE ) {
			$iv_gateway = get_option('iv_directories_payment_gateway');
				   if($iv_gateway=='paypal-express'){
						$post_name='iv_directories_paypal_setting';
						$row = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE post_name = '".$post_name."' ");
						$paypal_id='0';
						if(sizeof($row )>0){
							$paypal_id= $row->ID;
						}
						$api_currency=get_post_meta($paypal_id, 'iv_directories_paypal_api_currency', true);
					}
		}
		$package_id='';
		if(isset($_REQUEST['package_id'])){
			$package_id=$_REQUEST['package_id'];

			$recurring= get_post_meta($package_id, 'iv_directories_package_recurring', true);
			if($recurring == 'on'){
				$package_amount=get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true);
			}else{
				$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true);
			}

			if($package_amount=='' || $package_amount=='0' ){$iv_gateway='paypal-express';}

		}

		$form_meta_data= get_post_meta( $package_id,'iv_directories_content',true);
		$row = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE id = '".$package_id."' ");
		$package_name='';
		$package_amount='';
		if(sizeof($row)>0){
			$package_name=$row->post_title;
			$count =get_post_meta($package_id, 'iv_directories_package_recurring_cycle_count', true);


			$package_name=$package_name;

			$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true);
		}

	$newpost_id='';
	$post_name='iv_directories_stripe_setting';
	$row = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE post_name = '".$post_name."' ");
				if(sizeof($row )>0){
				  $newpost_id= $row->ID;
				}
	$stripe_mode=get_post_meta( $newpost_id,'iv_directories_stripe_mode',true);
	if($stripe_mode=='test'){
		$stripe_publishable =get_post_meta($newpost_id, 'iv_directories_stripe_publishable_test',true);
	}else{
		$stripe_publishable =get_post_meta($newpost_id, 'iv_directories_stripe_live_publishable_key',true);
	}


?>

<div class="registration-style">
<div class="row">

	<div id="iv-form3" class="col-md-12">
		<?php
			if($iv_gateway=='paypal-express'){
			 ?>

				<form id="iv_directories_registration" name="iv_directories_registration" class="form-horizontal" action="<?php  the_permalink() ?>?package_id=<?php echo $package_id; ?>&payment_gateway=paypal&iv-submit-listing=register" method="post" role="form">

		<?php
		}
		if($iv_gateway=='woocommerce'){
		?>
		<form id="iv_directories_registration" name="iv_directories_registration" class="form-horizontal" action="<?php  the_permalink() ?>?&payment_gateway=woocommerce&iv-submit-listing=register" method="post" role="form">
		<?php
		}
		if($iv_gateway=='stripe'){?>
				<form id="iv_directories_registration" name="iv_directories_registration" class="form-horizontal" action="<?php  the_permalink() ?>?&package_id=<?php echo $package_id; ?>&payment_gateway=stripe&iv-submit-stripe=register" method="post" role="form">

				<input type="hidden" name="payment_gateway" id="payment_gateway" value="stripe">
				<input type="hidden" name="iv-submit-stripe" id="iv-submit-stripe" value="register">
		<?php
		}
		?>


			<div class="content">
			<h3  class="form-title"><?php  esc_html_e('User Information','falcons');?></h3>

			<div class="form-content">

			<div class="row">


          <div class="col-md-12">
						<?php
							 if(isset($_REQUEST['message-error'])){?>
							  <div class="row alert alert-info alert-dismissable" id='loading-2'><a class="panel-close close" data-dismiss="alert">x</a> <?php  echo $_REQUEST['message-error']; ?></div>
							  <?php
							  }
						?>

	<!--
		For Form Validation we used plugins http://formvalidator.net/index.html#reg-form
		This is in line validation so you can add fields easily.
	-->


				<div>
						<div id="selected-column-1" class=" ">
						<div class="text-center" id="loading"> </div>
						<div class="form-group row"  >
						<label  class="col-md-3 control-label"><?php  esc_html_e('User Name','falcons');?><span class="chili"></span></label>
						<div class="col-md-9">
							<input type="text"  name="iv_member_user_name"  data-validation="length alphanumeric"
data-validation-length="4-12" data-validation-error-msg="<?php  esc_html_e(' The user name has to be an alphanumeric value between 4-12 characters','falcons');?>" class="form-control ctrl-textbox" placeholder="Enter User Name"  >

						</div>
					</div>
					<div class="form-group row">
						<label  class="col-md-3 control-label" ><?php  esc_html_e('Email Address','falcons');?><span class="chili"></span></label>
						<div class="col-md-9">
							<input type="email" name="iv_member_email" data-validation="email"  class="form-control ctrl-textbox" placeholder="Enter email address" data-validation-error-msg="<?php  esc_html_e('Please enter a valid email address','falcons');?> " >
						</div>
					</div>
					<div class="form-group row ">
						<label  class="col-md-3 control-label"><?php  esc_html_e('Password','falcons');?><span class="chili"></span></label>
						<div class="col-md-9">
							<input type="password" name="iv_member_password"  class="form-control ctrl-textbox" placeholder="" data-validation="strength"
		 data-validation-strength="2">
						</div>
					</div>
					<?php
					$tax_type= (get_option('_iv_tax_type')!=""?get_option('_iv_tax_type'):"country");
					$tax_active_module=get_option('_iv_directories_active_tax');

					if($tax_active_module=='' ){ $tax_active_module='yes';	}
					$country_show=0;
					if($tax_type=='country'){
					 $country_show=1;
					}else{
						$country_show=0;
					}
					if($tax_active_module=='yes' AND $country_show==1){
					?>
					<div class="form-group row ">
						<label  class="col-md-3 control-label"><?php  esc_html_e('State','falcons');?><span class="chili"></span></label>
						<div class="col-md-9">
							<select name="state_select" id="state_select" class="form-control" data-validation="required"
		 data-validation-error-msg="<?php  esc_html_e('Please select your state','falcons');?>" >
								<?php
								$indianStates = array('AR' => 'Arunachal Pradesh',
									'AR' => 'Arunachal Pradesh',
									'AS' => 'Assam',
									'BR' => 'Bihar',
									'CT' => 'Chhattisgarh',
									'GA' => 'Goa',
									'GJ' => 'Gujarat',
									'HR' => 'Haryana',
									'HP' => 'Himachal Pradesh',
									'JK' => 'Jammu and Kashmir',
									'JH' => 'Jharkhand',
									'KA' => 'Karnataka',
									'KL' => 'Kerala',
									'MP' => 'Madhya Pradesh',
									'MH' => 'Maharashtra',
									'MN' => 'Manipur',
									'ML' => 'Meghalaya',
									'MZ' => 'Mizoram',
									'NL' => 'Nagaland',
									'OR' => 'Odisha',
									'PB' => 'Punjab',
									'RJ' => 'Rajasthan',
									'SK' => 'Sikkim',
									'TN' => 'Tamil Nadu',
									'TG' => 'Telangana',
									'TR' => 'Tripura',
									'UP' => 'Uttar Pradesh',
									'UT' => 'Uttarakhand',
									'WB' => 'West Bengal',
									'AN' => 'Andaman and Nicobar Islands',
									'CH' => 'Chandigarh',
									'DN' => 'Dadra and Nagar Haveli',
									'DD' => 'Daman and Diu',
									'LD' => 'Lakshadweep',
									'DL' => 'National Capital Territory of Delhi',
									'PY' => 'Puducherry');
								$i=0;
								echo '<option value="" >'. __('Select State','falcons').'</option>';
								$first_state='select';
								foreach($indianStates as $key=>$indianState) {
										echo '<option value="'. $key.'" >'. $indianState.'</option>';

										$i++;
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row"  >
						<label class="col-md-3 control-label"><?php  esc_html_e('City','falcons');?><span class="chili"></span></label>
						<div class="col-md-9">
							<input type="text" name="iv_member_user_city"  data-validation="required"
							data-validation-error-msg="<?php  esc_html_e(' Please enter city','falcons');?>" class="form-control ctrl-textbox" placeholder="Enter City"
						</div>
					</div>
					<?php
					}
					?>

					</div>
					<div class="row form-group">
						<label class="col-md-3 control-label"></label>
						<div class="col-md-9 " >
							<div id="loading-3" style="display: none;"><img src='<?php echo wp_iv_directories_URLPATH. 'admin/files/images/loader.gif'; ?>' /></div>
							<button  id="submit_iv_directories_payment"  type="submit" class="btn-new btn-custom ctrl-btn"  > <?php  esc_html_e('Submit','falcons');?> </button>
						</div>
					</div>
					</div>
					</div>
					<input type="hidden" name="hidden_form_name" id="hidden_form_name" value="iv_directories_registration">


              </div>
         </div>
        </div>
			</div>
		</form>
		<div style="display: none;">
			<img src='<?php echo wp_iv_directories_URLPATH. 'admin/files/images/loader.gif'; ?>' />
		</div>
	</div>
	</div>
</div>

<?php
 wp_enqueue_script( 'profile-registration-js', falcons_JS.'profile-registration.js', array('jquery'), $ver = true, true );
 wp_localize_script( 'profile-registration-js', 'falcons_data', array( 	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
																		'loading_image'		=> wp_iv_directories_URLPATH.'admin/files/images/loader.gif',
																		'old_loader'		=> wp_iv_directories_URLPATH.'admin/files/images/old-loader.gif',
																		'iv_gateway'		=>$iv_gateway,
																		'stripe_publishable'=>$stripe_publishable,
																		'package_amount'	=> $package_amount,
																		'api_currency'		=>$api_currency ,
																		'right_icon'		=> wp_iv_directories_URLPATH. 'admin/files/images/right_icon.png' ,
																		'wrong_icon'		=> wp_iv_directories_URLPATH. 'admin/files/images/wrong_16x16.png' ,
																		'Hide_Coupon'=> __('Hide Coupon','falcons'),
																		'have_Coupon'=> __('Have a coupon?','falcons'),

																		) );

 ?>
