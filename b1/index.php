<?php
    require_once('db.php');
    $database = new Database();
    $error = [];
    if (isset($_POST) && !empty($_POST))
    {
        $user_name = isset($_POST['user_name']) ? $database->check_input($_POST['user_name']) : '';
        $user_email = isset($_POST['user_email']) ? $database->check_input($_POST['user_email']) : '';
        $user_phone = isset($_POST['user_phone']) ? $database->check_input($_POST['user_phone']) : '';
        $user_province_id = isset($_POST['user_province']) ? $_POST['user_province'] : '';
        $user_district_id = isset($_POST['user_district']) ? $_POST['user_district'] : '';
        $user_ward_id = isset($_POST['user_ward']) ? $_POST['user_ward'] : '';
        
        if (empty($user_name))
        {
            $error[] = 'Bạn chưa nhập user_name'; 
        } else if (!preg_match('/[a-zA-Z][^#&<>\"~;$^%{}?]{1,20}$/', $user_name)) {
            $error[] = 'Tên sai định dạng';
        }
        if (empty($user_email))
        {
            $error[] = 'Bạn chưa nhập user_email'; 
        } else if (!preg_match("/^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/i", $user_email)){
            $error[] = 'Email sai định dạng';
        }
        
        if (empty($user_phone))
        {
            $error[] = 'Bạn chưa nhập user_phone'; 
        } else if (!preg_match('/[0-9][^#&<>\"~;$^%{}?]{9,10}$/', $user_phone)) {
            $error[] = 'số điện thoại không đúng định dạng';
        }
        if (empty($user_province_id))
        {
            $error[] = 'Bạn chưa nhập user_city'; 
        }

        
        if (empty($user_district_id))
        {
            $error[] = 'Bạn chưa nhập user_district'; 
        }
        if (empty($user_ward_id))
        {
            $error[] = 'Bạn chưa nhập user_ward'; 
        }
        if (empty($error))
        {
            $sql_province = "SELECT title FROM nv4_vi_location_province WHERE id = $user_province_id";
            $result_province = $database->create($sql_province);
            while ($row = mysqli_fetch_assoc($result_province))
            {
                $user_province =  $row['title'];
            }
            
            $sql_district = "SELECT title FROM nv4_vi_location_district WHERE id = $user_district_id";
            $result_district = $database->create($sql_district);
            while ($row = mysqli_fetch_assoc($result_district))
            {
                $user_district =  $row['title'];
            }

            $sql_ward = "SELECT title FROM nv4_vi_location_ward WHERE id = $user_ward_id";
            $result_ward = $database->create($sql_ward);
            while ($row = mysqli_fetch_assoc($result_ward))
            {
                $user_ward =  $row['title'];
            }
            
            $sql = "INSERT INTO users (user_name, user_email, user_phone, user_province, user_district, user_ward) VALUES ('$user_name', '$user_email', '$user_phone', '$user_province', '$user_district', '$user_ward')";
            $result = $database->create($sql);
            if ($result)
            {
                echo "Thêm người dùng thành công";
            } else {echo "Thêm người dùng thất bại";}
        }
        $error_string = implode("<br>", $error);
        echo "<div style='color:red'>$error_string</div>";

        
    }
    echo "<pre>";
    print_r($error);
    echo "</pre>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content">
    <h2>Nhập thông tin người dùng</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="">Name: </label>
            <input type="text" class="form-control" name="user_name">
        </div>
        <div class="form-group">
            <label for="">Email: </label>
            <input type="text" class="form-control" name="user_email">
        </div>
        <div class="form-group">
            <label for="">Phone number: </label>
            <input type="text" class="form-control" name="user_phone">
        </div>
        <div class="form-group">
            <select name="user_province" id="user_province" class="form-control">
                <option value="">---Chọn Thành Phố---</option>
                <?php
                    $sql = "SELECT * FROM nv4_vi_location_province";
                    $provinces = $database->runQuery($sql);
                ?>
                <?php if (!empty($provinces)) : ?>
                <?php foreach ($provinces as $province) :?>
                    <option value="<?php echo $province['id'] ?>"><?php echo $province['title'] ?></option>
                <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <select name="user_district" id="user_district" class="form-control">
                <option value="">---Chọn Quận---</option>
                
            </select>
        </div>
        <div class="form-group">
            <select name="user_ward" id="user_ward" class="form-control">
                <option value="">---Chọn Phường---</option>
                
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
</div>
    



    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#user_province').change(function() {
                var province_id  = $(this).val();
                $.ajax({
                    url: 'ajax.php',
                    method: 'POST',
                    
                    dataType:"text",
                    data: {province_id: province_id},
                    success: function(data) {
                        $('#user_district').html(data);
                    }
                })
            });
            $('#user_district').change(function() {
                var district_id  = $(this).val();
                $.ajax({
                    url: 'ajax.php',
                    method: 'POST',
                    
                    dataType:"text",
                    data: {district_id: district_id},
                    success: function(data) {
                        $('#user_ward').html(data);
                    }
                })
            });
            $('#user_province').change(function() {
                var district_id  = $(this).val();
                $.ajax({
                    url: 'ajax.php',
                    method: 'POST',
                    
                    dataType:"text",
                    data: {district_id: district_id},
                    success: function(data) {
                        $('#user_ward').html(data);
                    }
                })
            });
        });
    </script>    
</body>
</html>