<!DOCTYPE html>
<html>
<head>
	<title>Demo app</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
  <h2>Product form</h2>
  <div class="col-md-12 global-msg"></div>
  <form method="post" id="product-form">
	  <table class="table table-bordered">
	    <tbody>
	      <tr>
	        <td>Product name</td>
	        <td><input type="text" name="name" /></td>
	      </tr>
	      <tr>
	        <td>Quantity in Stock</td>
	        <td><input type="text" name="qty" id="qty" /></td>
	      </tr>
	      <tr>
	        <td>Price</td>
	        <td><input type="text" name="price" id="price" /></td>
	      </tr>
	      <tr>
	      	<td colspan="2" align="center">
	      		<button class="btn btn-success" type="button">Save</button>
	      	</td>
	      </tr>
	    </tbody>
	  </table>
	  <h2>Product Table</h2>
	  <div id="res_div">
	  	<?php
			$file_path = dirname(__FILE__).'/product.json';
			//read json file
			$str = file_get_contents($file_path);
			$array = json_decode($str);

			$html_str = '<table class="table table-striped">';
			$html_str .= '<thead>'.
			      '<tr>
			        <th>Product Name</th>
			        <th>Quantity in stock</th>
			        <th>Price per item</th>
			        <th>Datetime</th>
			        <th>Total value number</th>
			      </tr>
			    </thead>
			    <tbody>';
			if(count($array)) {
			$rev = array_reverse($array);
			
			    $sum_total_val_no = 0;
			    foreach ($rev as $item) {
			    	$total_val_no = ($item->qty * $item->price);
			    	$sum_total_val_no += $total_val_no;
			    	$html_str .= '<tr>';
			    	$html_str .= '<td>'.$item->name.'</td>';
			    	$html_str .= '<td>'.$item->qty.'</td>';
			    	$html_str .= '<td>'.$item->price.'</td>';
			    	$html_str .= '<td>'.$item->time.'</td>';
			    	$html_str .= '<td>'.$total_val_no.'</td>';
			    	$html_str .= '</tr>';
			    }
			    $html_str .= '<tr><td colspan=4>&nbsp;</td><td>'.$sum_total_val_no.'</td></tr>';
			
			
		} else {
			$html_str .= "<tr><td colspan=5 align='center'>No Data Found</td></tr>";
		}
		$html_str .= "</tbody></table>";
		echo $html_str;
		?>
	  </div>
  </form>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(".btn-success").click(function() {
			var myform = document.getElementById("product-form");
    		var form_data = new FormData(myform);
			jQuery.ajax({
				url: 'save.php',
				method: "POST",
				cache: false,
		        processData: false,
		        contentType: false,
				data: form_data,
				success: function(data) {
					var s_msg = '<div class="alert alert-success"><strong>Success!</strong> Data has been saved.</div>'
					jQuery(".global-msg").html(s_msg);
					if(data==0) {
						alert("no data found");
					} else {
						jQuery("#res_div").html(data);
					}
					clearform();
				},
				error:function() {
					clearform();
				}
			});
		});

		$("#qty").keypress(function (e) {
	     //if the letter is not digit then display error and don't type anything
	     	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
           		return false;
	    	}
	   	});

	   	$("#price").keypress(function (e) {
	   		console.log(e.which);
	   		if(e.which==46) {
	   			return true;
	   		}
	     //if the letter is not digit then display error and don't type anything
	     	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
           		return false;
	    	}
	   	});
	});
	function clearform() {
		jQuery("#product-form input").val("");
	}
</script>
</body>
</html>
