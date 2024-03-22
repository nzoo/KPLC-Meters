<?php

// Include the config.php file
require_once('config.php');

//int PDOStatement::rowCount ();

class display {
    
    public function table_dashboard() {
        global $conn;

		$stmt = $this->db->prepare("SELECT code FROM locations");
 $stmt->execute();


        // Prepare the SQL statement
        $sql = $conn->prepare('SELECT * FROM employees');
        // Execute the statement
        $sql->execute();
        // Fetch all the results
		$resultSet = $stmt->get_result();
        $fetch = $resultSet->fetch_all();

        // Check if we got any results
        if(5 > 0){
            $data = ['data' => []];
            foreach ($fetch as $value) {
                // Assuming 'item_status' is a column in your employees table
                $status = ($value['item_status'] == 1) ? 'New' : 'Old';
                $data['data'][] = [
                    $value['i_model'],
                    $value['i_category'],
                    $value['i_brand'],
                    $value['i_description'],
                    $value['items_stock'],
                    $status
                ];
            }
            echo json_encode($data);
        } else {
            echo json_encode(['data' => []]);
        }
    }
}

$display = new display();

// Check if key is set in POST request to prevent undefined index notice
if (isset($_POST['key'])) {
    $key = trim($_POST['key']);

    switch ($key) {
        case 'table_dashboard':
            $display->table_dashboard();
            break;
    }
}

?>
