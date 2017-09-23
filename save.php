<?php
try {

	$jsondata = json_encode($_POST);
	$file_path = dirname(__FILE__).'/product.json';

	//read json file
	$str = file_get_contents($file_path);
	$array = json_decode($str);

	$new_product = new stdClass;
	$new_product->name = $_POST['name'];
	$new_product->qty = $_POST['qty'];
	$new_product->price = $_POST['price'];
	$new_product->time = date("Y-m-d H:i:s");

	array_push($array,$new_product);
	
	//write json file
	$fp = fopen($file_path, 'w');
	fwrite($fp, json_encode($array));
	fclose($fp);

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

}
catch(Exception $e) {
	echo $e->getMessage();
}