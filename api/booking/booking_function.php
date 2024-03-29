<?php
include '../structure/structure.php';
class booking_function
{
    private $conn;
    private $structure;
    // constructor
    public function __construct()
    {
        require_once '../DB_Connect.php';
        // connecting to database
        $db              = new Db_Connect();
        $this->conn      = $db->connect();
        $this->structure = new Structure_object();
    }

    // destructor
    public function __destruct()
    {

    }

    /**
     * read function
     * */
    public function read($selected_date,$service_id)
    {
        $stmt = $this->conn->prepare("SELECT updated_at, created_at, status, customer_id, selected_date, person, duration, selected_time, service_id, booking_id
        
         FROM tb_booking WHERE soft_delete = '' AND selected_date= '$selected_date' AND service_id = $service_id");
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        $result = $stmt->execute();

        if ($result) {
            //set up bind result
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            $return_arr = $this->structure->bindResult($stmt, $params, $row);
        }

        return (sizeof($return_arr) > 0 ? $return_arr : false);
    }

    public function check($selected_date,$service_id,$booking_id)
    {
        $stmt = $this->conn->prepare("SELECT updated_at, created_at, status, customer_id, selected_date, person, duration, selected_time, service_id, booking_id
        
         FROM tb_booking WHERE soft_delete = '' AND selected_date= '$selected_date' AND service_id = $service_id AND booking_id !=$booking_id");
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        $result = $stmt->execute();

        if ($result) {
            //set up bind result
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            $return_arr = $this->structure->bindResult($stmt, $params, $row);
        }

        return (sizeof($return_arr) > 0 ? $return_arr : false);
    }

    public function getBooking($selected_date,$service_id,$provider_id)
    {
        $stmt = $this->conn->prepare("SELECT updated_at, created_at, status, customer_id, selected_date, person, duration, selected_time, service_id, booking_id
        
         FROM tb_booking WHERE soft_delete = '' AND selected_date= '$selected_date' AND service_id = $service_id AND provider_id = $provider_id" );
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        $result = $stmt->execute();

        if ($result) {
            //set up bind result
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            $return_arr = $this->structure->bindResult($stmt, $params, $row);
        }

        return (sizeof($return_arr) > 0 ? $return_arr : false);
    }

    public function findSpecificBranchBooking($branch_id)
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT tb_booking.updated_at, tb_booking.created_at, tb_booking.status, tb_booking.customer_id, tb_booking.selected_date, 
        tb_booking.person, tb_booking.duration, tb_booking.selected_time, tb_booking.service_id, tb_booking.booking_id, tb_booking.provider_id, tb_booking.service_title,
         tb_booking.service_description, tb_customer.remark, tb_customer.name ,tb_customer.customer_id, tb_customer.contact, tb_customer.email, tb_service.color 
         FROM tb_booking JOIN tb_service ON tb_booking.service_id = tb_service.service_id JOIN tb_branch_link ON tb_branch_link.service_id = tb_service.service_id 
         JOIN tb_customer ON tb_booking.customer_id = tb_customer.customer_id WHERE tb_branch_link.branch_id = $branch_id
          AND tb_booking.soft_delete = '' AND tb_booking.status = 0 ORDER BY tb_booking.service_id " );
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        $result = $stmt->execute();

        if ($result) {
            //set up bind result
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            $return_arr = $this->structure->bindResult($stmt, $params, $row);
        }

        return (sizeof($return_arr) > 0 ? $return_arr : false);
    }

    public function findAllBranchBooking($company_id)
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT tb_booking.customer_id, tb_booking.selected_date, tb_booking.person, tb_booking.duration, tb_booking.selected_time,
         tb_booking.service_id, tb_booking.booking_id, tb_booking.provider_id, tb_booking.service_title, tb_booking.service_description, tb_branch.branch_id,
          tb_customer.remark,tb_customer.name ,tb_customer.customer_id, tb_customer.contact, tb_customer.email, tb_service.color 
          FROM tb_booking JOIN tb_service ON tb_booking.service_id = tb_service.service_id JOIN tb_branch_link ON tb_service.service_id = tb_branch_link.service_id 
          JOIN tb_branch ON tb_branch_link.branch_id = tb_branch.branch_id JOIN tb_customer ON tb_booking.customer_id = tb_customer.customer_id 
          WHERE tb_branch.company_id = $company_id AND tb_booking.status = 0 ORDER BY `tb_booking`.`customer_id` ASC " );
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        $result = $stmt->execute();

        if ($result) {
            //set up bind result
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            $return_arr = $this->structure->bindResult($stmt, $params, $row);
        }

        return (sizeof($return_arr) > 0 ? $return_arr : false);
    }

    public function getCustomerAppointment($customer_id)
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT tb_booking.updated_at,tb_booking.created_at, tb_booking.status, tb_booking.customer_id, tb_booking.selected_date, 
        tb_booking.person, tb_booking.duration, tb_booking.selected_time, tb_booking.service_id, tb_booking.booking_id, tb_booking.provider_id, 
        tb_booking.service_title, tb_booking.service_description,tb_customer.remark, tb_branch.name, tb_branch.branch_id FROM tb_booking 
        JOIN tb_customer ON tb_booking.customer_id = tb_customer.customer_id JOIN tb_service ON tb_booking.service_id = tb_service.service_id 
        JOIN tb_branch_link ON tb_service.branch_id = tb_branch_link.branch_id 
        JOIN tb_branch ON tb_branch_link.branch_id = tb_branch.branch_id 
         WHERE tb_booking.soft_delete = '' AND tb_customer.customer_id= $customer_id");
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        } 
        $result = $stmt->execute();

        if ($result) {
            //set up bind result
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            $return_arr = $this->structure->bindResult($stmt, $params, $row);
        }

        return (sizeof($return_arr) > 0 ? $return_arr : false);
    }
    


    /**
     * create function
     * */
    public function create($params)
    {
        $return_arr = array();
        $stmt       = $this->conn->prepare('INSERT INTO tb_booking(service_id, selected_time, duration, service_title, service_description, selected_date, person, customer_id ,created_at ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        $result  = $this->structure->bindParam($stmt, $params);
        $last_id = $stmt->insert_id;
        $stmt->close();
        return ($result ? $last_id : false);
    }

    public function createBooking($params)
    {
        $return_arr = array();
        $stmt       = $this->conn->prepare('INSERT INTO tb_booking(service_id, selected_time, duration, service_title, service_description, selected_date, person, customer_id, provider_id, created_at ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        $result  = $this->structure->bindParam($stmt, $params);
        $last_id = $stmt->insert_id;
        $stmt->close();
        return ($result ? $last_id : false);
    }


    /**
     * update function
     * */
    public function updateBooking($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_booking SET selected_time = ?, selected_date = ? , person = ?, updated_at = ?  WHERE booking_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
    public function updateCustomer($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_customer SET name = ?, contact = ? , email = ?, remark = ?, updated_at = ?   WHERE customer_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
        
    }

    /**
     * delete function
     * */
    public function delete($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_booking SET  WHERE booking_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
}
?>