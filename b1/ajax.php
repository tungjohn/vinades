<?php
    require_once('db.php');
    $database = new Database();

    if (isset($_POST['province_id']))
    {
        $province_id = $_POST['province_id'];
        $sql = "SELECT * FROM nv4_vi_location_district WHERE idprovince = $province_id";
        
        $result = $database->create($sql);
        echo '<option value="">---Chọn Quận---</option>';
        while ($row = mysqli_fetch_assoc($result))
        {
            echo '<option value=' . $row['id'] . '>' . $row['title'] . '</option>';
        }
    }
    if (isset($_POST['district_id']))
    {
        $district_id = $_POST['district_id'];
        $sql = "SELECT * FROM nv4_vi_location_ward WHERE iddistrict = $district_id";
        
        $result = $database->create($sql);
        echo '<option value="">---Chọn phường---</option>';
        while ($row = mysqli_fetch_assoc($result))
        {
            echo '<option value=' . $row['id'] . '>' . $row['title'] . '</option>';
        }
    }

?>