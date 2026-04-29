<?php
class Patrimonio {

	// Brand management 
	public function getBrandList(){
        require("config.php");
        $sql = "select idmarca as id, '' as bname, marca as name, idestatus as status patrimonio_catalogodemarcas where idestatus = 0";
        $result = $conexion -> query($sql);
		$numRows = mysqli_num_rows($result);
		$brandData = array();	
		while( $brand = mysqli_fetch_assoc($result) ) {			
			$status = '';
			if($brand['status'] == 'active')	{
				$status = '<span class="label label-success">Active</span>';
			} else {
				$status = '<span class="label label-danger">Inactive</span>';
			}
			$brandRows = array();
			$brandRows[] = $brand['id'];
			$brandRows[] = $brand['bname'];
			$brandRows[] = $brand['name'];
			$brandRows[] = $status;
			$brandRows[] = '<button type="button" name="update" id="'.$brand["id"].'" class="btn btn-primary btn-sm rounded-0  update" title="Update"><i class="fa fa-edit"></i></button><button type="button" name="delete" id="'.$brand["id"].'" class="btn btn-danger btn-sm rounded-0  delete" data-status="'.$brand["status"].'" title="Delete"><i class="fa fa-trash"></i></button>';
			$brandData[] = $brandRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$brandData
		);
		echo json_encode($output);
	}
    
	public function categoryDropdownList(){		
		$sqlQuery = "SELECT * FROM ".$this->categoryTable." 
			WHERE status = 'active' 
			ORDER BY name ASC";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$categoryHTML = '';
		while( $category = mysqli_fetch_assoc($result)) {
			$categoryHTML .= '<option value="'.$category["categoryid"].'">'.$category["name"].'</option>';	
		}
		return $categoryHTML;
	}
	public function saveBrand() {		
		$sqlInsert = "
			INSERT INTO ".$this->brandTable."(categoryid, bname) 
			VALUES ('".$_POST["categoryid"]."', '".$_POST['bname']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		echo 'New Brand Added';
	}	
	public function getBrand(){
		$sqlQuery = "
			SELECT * FROM ".$this->brandTable." 
			WHERE id = '".$_POST["id"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}	
	public function updateBrand() {		
		if($_POST['id']) {	
			$sqlUpdate = "UPDATE ".$this->brandTable." SET bname = '".$_POST['bname']."', categoryid='".$_POST['categoryid']."' WHERE id = '".$_POST["id"]."'";
			mysqli_query($this->dbConnect, $sqlUpdate);	
			echo 'Brand Update';
		}	
	}	
	public function deleteBrand(){
		$sqlQuery = "
			DELETE FROM ".$this->brandTable." 
			WHERE id = '".$_POST["id"]."'";	
		mysqli_query($this->dbConnect, $sqlQuery);		
	}

}
?>