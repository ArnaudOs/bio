<?php 
session_start();
require_once('connect.php');
include('header.php');
include('nav.php');
 
$sql = "SELECT * FROM products";
$res = mysqli_query($connection, $sql);
?>
 
<div class="container">
<?php if(isset($_GET['status']) & !empty($_GET['status'])){ 
		if($_GET['status'] == 'success'){
		echo "<div class=\"alert alert-success\" role=\"alert\">Item Successfully Added to Cart</div>";
		}elseif ($_GET['status'] == 'incart') {
		echo "<div class=\"alert alert-info\" role=\"alert\">Item is Already Exists in Cart</div>";
		}elseif ($_GET['status'] == 'failed') {
		echo "<div class=\"alert alert-danger\" role=\"alert\">Failed to Add item, try to Add Again</div>";
		}
	}
?>
	<div class="row">
<?php while($r = mysqli_fetch_assoc($res)){ ?>
	  <div class="col-sm-6 col-md-3">
	    <div class="thumbnail">
	      <img src="<?php echo $r['img_name']; ?>" alt="<?php echo $r['title'] ?>">
	      <div class="caption">
			<h3><?php echo $r['title'] ?></h3>
			<input type="number" name="qty" class="qty-product" >
	        <!-- <p><?php echo $r['description'] ?></p> -->
	        <p><a href="addtocart.php?id=<?php echo $r['id']; ?>" class="btn btn-primary" role="button">Add to Cart</a></p>
	      </div>
	    </div>
	  </div>
<?php } ?>
	</div>
 
</div>
 
<?php include('footer.php'); ?>