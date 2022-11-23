<?php
require_once dirname(__FILE__) . "/DbConnection.php";
require_once dirname(__FILE__) . "/Image.php";
require_once dirname(__FILE__) . '/../../vendor/autoload.php';

class Menu extends DbConnection
{
	/* -------------------- index.php  */
	public function display_bestseller()
	{
		/* gets top 5 available bestseller items */
		$result = $query = $this->connect()->prepare("SELECT o.menu_id, COUNT(o.menu_id), m.* FROM orderlist o INNER JOIN menu  m ON (m.menu_id = o.menu_id) WHERE m.availability=:availability GROUP BY o.menu_id ORDER BY COUNT(o.menu_id) DESC LIMIT 4");
		$query->execute([":availability"=>'Available']);
		if ($result->rowCount() > 0) {
			$data = array();
			foreach ($result as $row) {
				$sub_array = array();
				$sub_array['menu_id'] = $row['menu_id'];
				$sub_array['name'] = $row['name'];
				$sub_array['description'] = $row['description'];
				$sub_array['discount'] = $row['discount'];
				$sub_array['category'] = $row['category'];
				$sub_array['price'] = $row['price'];
				$sub_array['image'] = $row['image'];
				$sub_array['discounted_price'] = ($row['price'] - ($row['price'] * (floatval($row['discount']) / 100)));
				
				$data[] = $sub_array;
			}
			$output = array("data" => $data);
		} else {
			$output['empty'] = "No Items Found";
		}
		echo json_encode($output);
	}

	/* -------------------- menu.php */
	public function display_menu($category)
	{
		/* gets all available items */
		$result = $query = $this->connect()->prepare("SELECT * FROM menu WHERE category = :category AND availability=:availability");
		$query->execute([":category"=>$category, ":availability"=>'Available']);
		if ($result->rowCount() > 0) {
			$data = array();
			foreach ($result as $row) {
				$sub_array = array();
				$sub_array['menu_id'] = $row['menu_id'];
				$sub_array['name'] = $row['name'];
				$sub_array['description'] = $row['description'];
				$sub_array['category'] = $row['category'];
				$sub_array['price'] = $row['price'];
				$sub_array['date'] = $row['date'];
				$sub_array['availability'] = $row['availability'];
				$sub_array['discount'] = $row['discount'];
				$sub_array['image'] = $row['image'];
				$sub_array['discounted_price'] = ($row['price'] - ($row['price'] * (floatval($row['discount']) / 100)));
				$data[] = $sub_array;
			}
			$output = array("data" => $data);
		} else {
			$output['empty'] = "No Items Found";
		}
		echo json_encode($output);
	}

	/* -------------------- STAFF -------------------- */
	/* -------------------- edit-menu.php */
	public function add_menu($menu_id, $name, $description, $category, $discount, $price, $date, $availability, $image)
	{
		$upload_image = new Image();
		$data = $upload_image->upload_image($image, $name, "SnackWise/Menu/");
		$image_link = "v" . $data['version'] . "/" . $data['public_id'];

		$query = $this->connect()->prepare("
        INSERT INTO menu
        (name, description, category, discount, price, date, availability, image)
        VALUES (:name, :description, :category, :discount, :price, :date, :availability, :image)");
		$result = $query->execute([':name' => $name, ':description' => $description, ':category' => $category, ':discount' => $discount, ':price' => $price, ':date' => $date, ':availability' => $availability, ':image' => $image_link]);
		if ($result) {
			$output['success'] = 'Item Added Successfully';
		} else {
			$output['error'] = 'Something went wrong! Please try again later.';
		}
		echo json_encode($output);
	}

	public function edit_menu($menu_id, $name, $description, $category, $discount, $price, $date, $availability, $image, $edit_menu_image)
	{
		if ($_POST['action_menu'] == 'Update') {
			/* checks if the menu image has been changed or not, 
			if not only other information will be changed */
			if ($edit_menu_image == "") {
				$upload_image = new Image();
				$data = $upload_image->upload_image($image, $name, "SnackWise/Menu/");
				$image_link = "v" . $data['version'] . "/" . $data['public_id'];
				$query = $this->connect()->prepare("UPDATE menu SET name = :name, description = :description, category = :category, discount = :discount, price = :price, date = :date, availability = :availability, image = :image WHERE menu_id = :menu_id");
				$result = $query->execute([':name' => $name, ':description' => $description, ':category' => $category, ':discount' => $discount, ':price' => $price, ':date' => $date, ':availability' => $availability, ':image' => $image_link, ':menu_id' => $menu_id]);
			} else {
				$query = $this->connect()->prepare("UPDATE menu SET name = :name, description = :description, category = :category, discount = :discount, price = :price, date = :date, availability = :availability WHERE menu_id = :menu_id");
				$result = $query->execute([':name' => $name, ':description' => $description, ':category' => $category, ':discount' => $discount, ':price' => $price, ':date' => $date, ':availability' => $availability, ':menu_id' => $menu_id]);
			}
			if ($result) {
				$output['success'] = 'Item Updated Successfully';
			} else {
				$output['error'] = 'Something went wrong! Please try again later.';
			}
		}
		echo json_encode($output);
	}

	public function delete_menu($menu_id)
	{
		$query = $this->connect()->prepare("DELETE FROM menu WHERE menu_id = :menu_id");
		$result = $query->execute([':menu_id' => $menu_id]);
		if ($result) {
			$output['success'] = 'Item Deleted Successfully';
		} else {
			$output['error'] = 'Something went wrong! Please try again later.';
		}
		echo json_encode($output);
	}

	/* fetch the information of the selected menu item */
	public function fetch_selected_menu()
	{
		$menu_id = $_POST["id"];
		$result = $query = $this->connect()->prepare("SELECT * FROM menu WHERE menu_id = :menu_id");
		$query->execute([':menu_id' => $menu_id]);
		$data = array();

		foreach ($result as $row) {
			$data['menu_id'] = $row['menu_id'];
			$data['name'] = $row['name'];
			$data['description'] = $row['description'];
			$data['category'] = $row['category'];
			$data['discount'] = $row['discount'];
			$data['price'] = $row['price'];
			$data['date'] = $row['date'];
			$data['availability'] = $row['availability'];
			$data['image'] = $row['image'];
		}
		echo json_encode($data);
	}

	/* fetch the 5 recently added menus, this will be the default items to be shown in the table */
	public function fetch_five()
	{
		$result = $query = $this->connect()->prepare("SELECT m.*,m.name AS menu_name, c.category_id, c.name AS cat_name FROM category c INNER JOIN menu m ON(c.category_id = m.category) ORDER BY m.menu_id ASC LIMIT 5");
		$query->execute();
		$output = '';
		foreach ($result as $row) {
			$output .= '
		<tr>
			<td>' . $row["menu_id"] . '</td>
			<td>' . $row["menu_name"] . '</td>
			<td>' . $row["description"] . '</td>
			<td>' . $row["cat_name"] . '</td>
			<td>' . $row["discount"] . '</td>
			<td>' . $row["price"] . '</td>
			<td>' . $row["date"] . '</td>
			<td>' . $row["availability"] . '</td>
			<td> <img src= "https://res.cloudinary.com/dhzn9musm/image/upload/' . $row["image"] . '" width="70px" height="70px"></td>
			<td>
				<button type="button" onclick="new Menu().fetch_selected_menu(' . $row["menu_id"] . ')" class="btn btn-edit"><i class="fa-solid fa-pen"></i></button>&nbsp;
				<button type="button" class="btn btn-delete" onclick="new Menu().delete_menu(' . $row["menu_id"] . ')"><i class="fa-solid fa-trash"></i></button>
			</td>
		</tr>
		';
		}
		return $output;
	}

	/* gets how many items are in the menu table, this is used to set pagination */
	public function count_all_data()
	{
		$query = $this->connect()->prepare("SELECT * FROM menu");
		$query->execute();
		return $query->rowCount();
	}

	/* filters the items in the table depending on the character entered by the staff in the search field */
	public function filter()
	{
		$startGET = filter_input(INPUT_GET, "start", FILTER_SANITIZE_NUMBER_INT);
		$start = $startGET ? intval($startGET) : 0;
		$lengthGET = filter_input(INPUT_GET, "length", FILTER_SANITIZE_NUMBER_INT);
		$length = $lengthGET ? intval($lengthGET) : 10;
		$searchQuery = filter_input(INPUT_GET, "searchQuery", FILTER_SANITIZE_STRING);
		$search = empty($searchQuery) || $searchQuery === "null" ? "" : $searchQuery;
		$sortColumnIndex = filter_input(INPUT_GET, "sortColumn", FILTER_SANITIZE_NUMBER_INT);
		$sortDirection = filter_input(INPUT_GET, "sortDirection", FILTER_SANITIZE_STRING);

		$column = array("menu_id", "menu_name", "description", "category", "price", "date", "availability", "image");
		$sql = "SELECT m.*,m.name AS menu_name, c.category_id, c.name AS cat_name FROM category c INNER JOIN menu m ON(c.category_id = m.category) ";
		
		$sql .= '
			WHERE m.menu_id LIKE "%' . $search . '%"
			OR m.name LIKE "%' . $search . '%"
			OR m.description LIKE "%' . $search . '%"
			OR c.name LIKE "%' . $search . '%"
			OR m.discount LIKE "%' . $search . '%"
			OR m.price LIKE "%' . $search . '%"
			OR m.date LIKE "%' . $search . '%"
			OR m.availability LIKE "%' . $search . '%"
			OR m.image LIKE "%' . $search . '%"
		';

		/* pagination */
		if ($sortColumnIndex != '') {
			$sql .= 'ORDER BY ' . $column[$sortColumnIndex] . ' ' . $sortDirection . ' ';
		} else {
			$sql .= 'ORDER BY m.menu_id ASC ';
		}

		$sql1 = '';

		if ($length != -1) {
			$sql1 = 'LIMIT ' . $start . ', ' . $length;
		}

		$query = $this->connect()->prepare($sql);
		$query->execute();
		$number_filter_row = $query->rowCount();
		$result = $this->connect()->prepare($sql . $sql1);
		$result->execute();
		$data = array();

		foreach ($result as $row) {
			$sub_array = array();
			$sub_array[] = $row['menu_id'];
			$sub_array[] = $row['menu_name'];
			$sub_array[] = $row['description'];
			$sub_array[] = $row['cat_name'];
			$sub_array[] = $row['discount'];
			$sub_array[] = $row['price'];
			$sub_array[] = $row['date'];
			$sub_array[] = $row['availability'];
			$sub_array[] = '<td> <img src= "https://res.cloudinary.com/dhzn9musm/image/upload/' . $row["image"] . '" width="70px" height="70px"></td>';
			$sub_array[] = '<button type="button" onclick="new Menu().fetch_selected_menu(' . $row["menu_id"] . ')" class="btn btn-edit"><i class="fa-solid fa-pen"></i></button>&nbsp;
			<button type="button" class="btn btn-delete" onclick="new Menu().delete_menu(' . $row["menu_id"] . ')"><i class="fa-solid fa-trash"></i></button>';
			$data[] = $sub_array;
		}

		$output = array("recordsTotal" => $this->count_all_data(), "recordsFiltered" => $number_filter_row, "data" => $data);
		echo json_encode($output);
	}
}
