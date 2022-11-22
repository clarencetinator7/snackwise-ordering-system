<?php
/* session_start(); */

require_once dirname(__FILE__) . "/DbConnection.php";

class Holiday extends DbConnection
{
    public function add_holiday($date)
    {
        $query = $this->connect()->prepare("INSERT INTO holiday (date) VALUES( :date)");

        $result = $query->execute([":date" => $date]);

        if ($result ) {
            $output['success'] = 'dayte Added';
            echo json_encode($output);
        } else {
            $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.1</div>';
            echo json_encode($output);
        }
    }
    public function delete_holiday($holiday_id)
    {
        $query = $this->connect()->prepare("DELETE FROM holiday WHERE holiday_id = :holiday_id");

        $result = $query->execute([":holiday_id" => $holiday_id]);

        if ($result ) {
            $output['success'] = 'delete holiday';
            echo json_encode($output);
        } else {
            $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.1</div>';
            echo json_encode($output);
        }
    }

    public function delete_past_holiday() {
   
 
        $query  = $this->connect()->prepare("DELETE FROM holiday WHERE  UNIX_TIMESTAMP(NOW())- UNIX_TIMESTAMP(date) > :unixtime");
        $result = $query->execute([':unixtime' => 0]);
  
    
    }

    public function display_holiday() {
     

		

        $result =$query = $this->connect()->prepare("SELECT holiday_id, date FROM holiday");
        $query->execute();

if( $result) {
	
		$data = array();

		
        foreach ($result as $row) {
			$sub_array = array();

			$sub_array['date'] = $row['date'];
			$sub_array['delete'] = '<button type="button" class="" onclick="delete_holiday(' . $row["holiday_id"] . ')">Delete</button>';
			$data[] = $sub_array;
		}


		$output = array(
			
			"data"				=>	$data
		);

		echo json_encode($output);
    } else {
        $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.1</div>';
    echo json_encode($output);
    }
    }
}
