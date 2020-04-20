
<?php 
session_start();
require_once('connect.php'); 
include('header.php'); 
include('nav.php');
?>
 
<div class="container">
<?php 
$items = $_SESSION['cart'];
$cartitems = explode(",", $items);
?>
	<div class="row">
	  <table class="table">
	  	<tr>
	  	<th>S.NO</th>
		  <th>Item Name</th>
		  <th>Quantité</th>
	  	<th>Price</th>
	  	</tr>
		<?php
		$total = 0;
        $i=0;
        
	 foreach ($cartitems as $key=>$id) {
		$sql = "SELECT * FROM products WHERE id = $id";
		$res=mysqli_query($connection, $sql);
		$r = mysqli_fetch_assoc($res);
		var_dump($_SESSION);
        //    $db=new PDO("mysql:host=localhost;dbname=beebee;charset=utf8", "root","",[
        //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // ]);
        // // $this->db = new PDO("mysql:host=localhost;dbname=beebee;charset=utf8", "root","",[
        // //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // // ]);
        // $query = $db->prepare( "SELECT * FROM products WHERE id = $id");
        // $query->execute([
        //     ':id' => $id,
        // ]);
		?>	  	
	  	<tr>
          <td><?php echo $i; ?></td>
        
		  <td><a href="delcart.php?remove=<?=$key ?>">Remove</a> <?php echo $r['title']; ?></td>
		<td>$<?= $_SESSION['quantity'] ?></td>
	  	<td>$<?php echo $r['price']; ?></td>
	  	</tr>
		<?php 
		$total = $total + $r['price'];
		$i++; 
		} 
		?>
		<tr>
		<td><strong>Total Price</strong></td>
		<td><strong>$<?php echo $total; ?></strong></td>
		<td><a href="#" class="btn btn-info">Checkout</a></td>
		</tr>
	  </table>
	  
	</div>
 
</div>
 
<?php include('footer.php'); ?>