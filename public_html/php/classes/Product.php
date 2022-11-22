<?php
/* session_start(); */

require_once dirname(__FILE__) . "/DbConnection.php";


/* $error = array(); */

$email = "";
$code = "";
$username = "";



class Product extends DbConnection{
	public $output = array();

  
    public function add(/* $product_id, */ $product_name, $product_description, $product_category, $product_discount, $product_price, $product_date, $product_availability, $product_image) {
   
		/* $_SESSION["rowCount"] = "true"; */
	/* 	$_SESSION["lastRowCount"] = ""; */
        $statement = $this->connect()->prepare("
        INSERT INTO product 
        (name, description, category, discount, price, date, availability, image) 
        VALUES (:name, :description, :category, :discount, :price, :date, :availability, :image)");
       $result = $statement->execute([
        ':name'=>$product_name,
        ':description'=>$product_description,
        ':category'=>$product_category,
        ':discount'=>$product_discount,
        ':price'=>$product_price,
        ':date'=>$product_date,
        ':availability'=>$product_availability,
        ':image'=>$product_image]);

        if($result)
        {
            $output['success'] = '<div class="alert alert-success">New Data Added</div>';

            echo json_encode($output);
        }
    }
    public function edit($product_id, $product_name, $product_description, $product_category, $product_discount, $product_price, $product_date, $product_availability, $product_image) {
      
        if($_POST['action_product'] == 'Update')
        {
            $statement = $this->connect()->prepare("UPDATE product 
            SET name = :name, description = :description, category = :category, discount = :discount, price = :price, date = :date, availability = :availability, image = :image WHERE product_id = :product_id
            ");
$result = $statement->execute([
    ':name'=>$product_name,
        ':description'=>$product_description,
        ':category'=>$product_category,
        ':discount'=>$product_discount,
        ':price'=>$product_price,
        ':date'=>$product_date,
        ':availability'=>$product_availability,
        ':image'=>$product_image,
				':product_id'=>$product_id]);
            if($result)
            {
                $output['success'] = '<div class="alert alert-success">'. $product_id.'Data Updated</div>';
            }
            echo json_encode($output);
        }
    }

    public function delete($id) {
      
		if($this->connect()->query( "
		DELETE FROM product 
		WHERE product_id = '".$id."'
		"))
		{
			$output['success'] = '<div class="alert alert-success">Data Deleted</div>';

			echo json_encode($output);
		} 
    }

    public function fetch() {
		$query = "
		SELECT * FROM product 
		WHERE product_id = '".$_POST["id"]."'
		";

		$result = $this->connect()->query($query);

		$data = array();

		foreach($result as $row)
		{
			
		
			$data['product_id'] = $row['product_id'];
			$data['product_name'] = $row['name'];
			$data['product_description'] = $row['description'];
			$data['product_category'] = $row['category'];
			$data['product_price'] = $row['price'];
			$data['product_date'] = $row['date'];
			$data['product_availability'] = $row['availability'];
			$data['product_image'] = $row['image'];
		}

		echo json_encode($data);
	}

    public function fetch_top_five_data()
{
	$query = "
	SELECT * FROM product 
	ORDER BY product_id DESC 
	LIMIT 5";

	$result = $this->connect()->query($query);

	$output = '';

	foreach($result as $row)
	{
		$output .= '
		
		<tr>
	
		<td>'.$row["product_id"].'</td>
		<td>'.$row["name"].'</td>
		<td>'.$row["description"].'</td>
		<td>'.$row["category"].'</td>
		<td>'.$row["price"].'</td>
		<td>'.$row["date"].'</td>
		<td>'.$row["availability"].'</td>
		<td>'.$row["image"].'</td>
			<td><button type="button" onclick="fetch_data('.$row["product_id"].')" class="">Edit</button>&nbsp;<button type="button" class="" onclick="delete_data('.$row["product_id"].')">Delete</button></td>
		</tr>
		';
	}
	return $output;
}

public function count_all_data()
{
	$query = "SELECT * FROM product";

	$statement = $this->connect()->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

public function filter() {
    

	$startGET = filter_input(INPUT_GET, "start", FILTER_SANITIZE_NUMBER_INT);
	$start = $startGET ? intval($startGET) : 0;
	$lengthGET = filter_input(INPUT_GET, "length", FILTER_SANITIZE_NUMBER_INT);
	$length = $lengthGET ? intval($lengthGET) : 10;
	$searchQuery = filter_input(INPUT_GET, "searchQuery", FILTER_SANITIZE_STRING);
	$search = empty($searchQuery) || $searchQuery === "null" ? "" : $searchQuery;
	$sortColumnIndex = filter_input(INPUT_GET, "sortColumn", FILTER_SANITIZE_NUMBER_INT);
	$sortDirection = filter_input(INPUT_GET, "sortDirection", FILTER_SANITIZE_STRING);
	
	
	$column = array("product_id", "product_name", "product_description", "product_category", "product_price", "product_date", "product_availability", "product_image");
	
	$query = "SELECT * FROM product ";
	
	$query .= '
		WHERE product_id LIKE "%'.$search.'%" 
	OR product_name LIKE "%'.$search.'%" 
	OR product_description LIKE "%'.$search.'%" 
	OR product_category LIKE "%'.$search.'%" 
	OR product_price LIKE "%'.$search.'%" 
	OR product_date LIKE "%'.$search.'%" 
	OR product_availability LIKE "%'.$search.'%" 
	OR product_image LIKE "%'.$search.'%" 
		';
	
	
	if($sortColumnIndex != '')
	{
		$query .= 'ORDER BY '.$column[$sortColumnIndex].' '.$sortDirection.' ';
	}
	else
	{
		$query .= 'ORDER BY product_id DESC ';
	}
	
	$query1 = '';
	
	if($length != -1)
	{
		$query1 = 'LIMIT ' . $start . ', ' . $length;
	}
	
	$statement = $this->connect()->prepare($query);
	
	$statement->execute();
	
	$number_filter_row = $statement->rowCount();
	
	$result = $this->connect()->query($query . $query1);
	
	$data = array();
	
	foreach($result as $row)
	{
		$sub_array = array();
	
	$sub_array[] = $row['product_id'];
	$sub_array[] = $row['product_name'];
	$sub_array[] = $row['product_description'];
	$sub_array[] = $row['product_category'];
	$sub_array[] = $row['product_price'];
	$sub_array[] = $row['product_date'];
	$sub_array[] = $row['product_availability'];
	$sub_array[] = $row['product_image'];
		$sub_array[] = '<button type="button" onclick="fetch_data('.$row["product_id"].')" class="">Edit</button>&nbsp;<button type="button" class="" onclick="delete_data('.$row["product_id"].')">Delete</button>';
	
		$data[] = $sub_array;
	}
	
	
	
	$output = array(
		"recordsTotal"		=>	$this->count_all_data(),
		"recordsFiltered"	=>	$number_filter_row,
		"data"				=>	$data
	);
	
	echo json_encode($output);
	
}



}



