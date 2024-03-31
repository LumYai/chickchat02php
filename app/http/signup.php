<?php

// echo "signup";
//  เช็คเมื่อมีการ summitted username password name
if(isset($_POST['username']) && 
    isset($_POST['password']) && 
    isset($_POST['name'] )){
    
    # database connection file
    include '../db.conn.php';
    

    // รับมูลจาก post request และ เก็บไวใน var
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // สร้างรูปแบบข้อมูล URL 
    $data = 'name='.$name.'&username='.$username;

    // validation
    if(empty($name)){
        $em = "Name is required";


        // redirect ไปยัง 'signup.php' และส่ง error message
        header("Location: ../../signup.php?error=$em&$data");
        exit;
    }else if(empty($username)){
        $em = "Username is required";


        // redirect ไปยัง 'signup.php' และส่ง error message
        header("Location: ../../signup.php?error=$em&$data");   
        exit;
    }else if(empty($password)){
        $em = "Password is required";


        // redirect ไปยัง 'signup.php' และส่ง error message
        header("Location: ../../signup.php?error=$em&$data");
        exit;
    }else{
        // เช็ค database หากได้รับ username
        $sql = "SELECT username 
                FROM users
                WHERE username=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        // ถ้ามี username นี้อยู่แล้ว ให้แจ้งเตือน
        if($stmt->rowCount() > 0){
            $em = "The username $username is taken";
            header("Location: ../../signup.php?error=$em&$data");
            exit;
        }else{
            // p_p upload
            if(isset($_FILES['pp'])){
                $img_name = $_FILES['pp']['name'];
                // ที่อยู่ของไฟล์(ที่อยู่จริง) ที่ไฟล์ถูกอัพโหลดไปเก็บไว้ 
                $tmp_name = $_FILES['pp']['tmp_name'];
                $error = $_FILES['pp']['error'];

                if($error === 0){
                    // รับ image extention เก็บไว้ใน var
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowed_exs = array("jpg", "jpeg", "png");

                    if(in_array($img_ex_lc, $allowed_exs)){
                        // rename imag เหมือนแบบ username.$img_ex_lc
                        $new_img_name = $username. '.'.$img_ex_lc;

                        // upload path root 
                        $img_upload_path = '../../uploads/'.$new_img_name;

                        // move upload image
                        move_uploaded_file($tmp_name, $img_upload_path);
                    }else{
                        $em = "unknow err occurred!";
                        header("Location: ../../signup.php?error=$em&$data");
                        exit;
                    }

                }

            }

            // password hashing
            $password = password_hash($password, PASSWORD_DEFAULT);

            // มีการอัพโหลด pp
            if(isset($new_img_name)){
                // inset data ไป database
                $sql = "INSERT INTO users
                        (name, username, password, p_p)
                        VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $username, $password, $new_img_name]);
            }else{
                $sql = "INSERT INTO users
                        (name, username, password)
                        VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $username, $password]);
            }
        }

        $sm = "Account created successfully";
        header("Location: ../../index.php?success=$sm");
        exit;
    }
}else{
    header("Location: ../../signup.php");
    exit;
}