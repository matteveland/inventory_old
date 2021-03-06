<?php
/**
 * add_order.php
 *
 * @package default
 */
$page_title = 'All orders';
require_once 'includes/load.php';
// Checkin What level user has permission to view this page
page_require_level(1);

$all_orders = find_all('orders');
$order_id = last_id('orders');
$new_order_id = $order_id['id'] + 1;

?>
<?php
if (isset($_POST['add_order'])) {
	$customer_name = remove_junk($db->escape($_POST['customer_name']));
	$paymethod = remove_junk($db->escape($_POST['paymethod']));
	//$c_address = "";
	//$c_postcode = "";
	//$c_telephone = "";
	//$c_email = "";
	
	if ( ! find_by_name('customers',$customer_name) )
	{
		$query  = "INSERT INTO customers (";
		//$query .=" name,address,postcode,telephone,email,paymethod";
		$query .=" name,paymethod";
		$query .=") VALUES (";
		//$query .=" '{$customer}', '{$c_address}', '{$c_postcode}', '{$c_telephone}', '{$c_email}', '{$paymethod}'";
		$query .=" '{$customer_name}', '{$paymethod}'";
		$query .=")";
		$result = $db->query($query);
		if ($result && $db->affected_rows() === 1) {
			$session->msg('s', "Customer Added! ");
		} else {
			$session->msg('d', ' Sorry, Failed to Add!');
		}
	}	
	
	
	$notes = "";
	$current_date    = make_date();
	if (empty($errors)) {
		$sql  = "INSERT INTO orders (id,customer,paymethod,notes,date)";
		$sql .= " VALUES ('{$new_order_id}','{$customer_name}','{$paymethod}','{$notes}','{$current_date}')";
		if ($db->query($sql)) {
			$session->msg("s", "Successfully Added Order");
			redirect( ( 'add_sale_to_order.php?id=' . $new_order_id ) , false);
		} else {
			$session->msg("d", "Sorry, Failed to Add Order!");
			redirect( 'add_order.php' , false);
		}
	} else {
		$session->msg("d", $errors);
		redirect( 'add_order.php' , false);
	}
}
?>

<?php include_once 'layouts/header.php'; ?>

<div class="login-page">
    <div class="text-center">
<!--     *************************     -->
       <h2>Add Order</h3>
       <h3>#<?php echo $new_order_id;?></h3>
<!--     *************************     -->
     </div>
     <?php echo display_msg($msg); ?>

      <form method="post" action="" class="clearfix">
<!--     *************************     -->
        <div class="form-group">
        </div>

        <div class="form-group">
              <label for="name" class="control-label">Customer Name</label>
              <input type="text" class="form-control" name="customer_name" value="" placeholder="Customer">
        </div>

           <div class="form-group">
                    <select class="form-control" name="paymethod">
                      <option value="">Select Payment Method</option>
                      <option value="Cash">Cash</option>
                      <option value="Check">Check</option>
                      <option value="Credit">Credit</option>
                      <option value="Charge">Charge to Account</option>
                    </select>
           </div>

           <div class="form-group">
               <input type="text" class="form-control" name="notes" value="" placeholder="Notes">
           </div>

<!--     *************************     -->
        <div class="form-group clearfix">
         <div class="pull-right">
                <button type="submit" name="add_order" class="btn btn-info">Start Order</button>
        </div>
        </div>
    </form>
</div>

<?php include_once('layouts/footer.php'); ?>
