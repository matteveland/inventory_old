<?php
/**
 * add_customer.php
 *
 * @package default
 */


$page_title = 'Add customer';
require_once 'includes/load.php';
// Checkin What level user has permission to view this page
page_require_level(2);

if (isset($_POST['add_customer'])) {
	$req_fields = array('customer-name' );
	validate_fields($req_fields);

	if (empty($errors)) {
		if (is_null($_POST['customer-name']) || $_POST['customer-name'] === "") {
			$c_name  =  '';
		} else {
			$c_name  = remove_junk($db->escape($_POST['customer-name']));
		}
		if (is_null($_POST['customer-address']) || $_POST['customer-address'] === "") {
			$c_address  =  '';
		} else {
			$c_address  = remove_junk($db->escape($_POST['customer-address']));
		}
		if (is_null($_POST['customer-postcode']) || $_POST['customer-postcode'] === "") {
			$c_postcode  =  '';
		} else {
			$c_postcode  = remove_junk($db->escape($_POST['customer-postcode']));
		}
		if (is_null($_POST['customer-telephone']) || $_POST['customer-telephone'] === "") {
			$c_telephone  =  '';
		} else {
			$c_telephone  = remove_junk($db->escape($_POST['customer-telephone']));
		}
		if (is_null($_POST['customer-email']) || $_POST['customer-email'] === "") {
			$c_email  =  '';
		} else {
			$c_email  = remove_junk($db->escape($_POST['customer-email']));
		}
		if (is_null($_POST['customer-paymethod']) || $_POST['customer-paymethod'] === "") {
			$c_paymethod  =  '';
		} else {
			$c_paymethod  = remove_junk($db->escape($_POST['customer-paymethod']));
		}

	if ( ! find_by_name('customers',$c_name) )
	{	
		$query  = "INSERT INTO customers (";
		$query .=" name,address,postcode,telephone,email,paymethod";
		$query .=") VALUES (";
		$query .=" '{$c_name}', '{$c_address}', '{$c_postcode}', '{$c_telephone}', '{$c_email}', '{$c_paymethod}'";
		$query .=")";
		$result = $db->query($query);
		if ($result && $db->affected_rows() === 1) {
			$session->msg('s', 'Customer Added!');
			redirect('customers.php', false);
		} else {
			$session->msg('d', 'Failure to Add!');
			redirect('customers.php', false);
		}
	} else {
			$session->msg('d', 'Customer Already Added!');
			redirect('customers.php', false);
	}


	} else {
		$session->msg("d", $errors);
		redirect('customers.php', false);
	}

}

?>


<?php include_once 'layouts/header.php'; ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
	<div class="col-md-7">
	<div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Customer</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
<!--     *************************     -->
          <form method="post" action="add_customer.php" class="clearfix">
<!--     *************************     -->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-user"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-name" value="" placeholder="Customer Name">
               </div>
              </div>


              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-home"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-address" value="" placeholder="Address">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-envelope"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-postcode" value="" placeholder="Postal Code">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-phone"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-telephone" value="" placeholder="Telephone">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-globe"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-email" value="" placeholder="Email">
               </div>
              </div>

           <div class="form-group">
                    <select class="form-control" name="customer-paymethod">
                      <option value="">Select Payment Method</option>
                      <option value="Cash">Cash</option>
                      <option value="Check">Check</option>
                      <option value="Credit">Credit</option>
                      <option value="Charge">Charge to Account</option>
                    </select>
           </div>

	  <div class="pull-right">
              <button type="submit" name="add_customer" class="btn btn-info">Add</button>
          </form>
         </div>
        </div>
    
      </div>
    </div>
  </div>

<?php include_once 'layouts/footer.php'; ?>
