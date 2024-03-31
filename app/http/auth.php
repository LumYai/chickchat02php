<?php 
session_start();
// เช็ค password และ username เมื่อมีการกด submitted
//  เช็คเมื่อมีการ summitted username และ password 
if(isset($_POST['username']) && 
    isset($_POST['password'])){
    
    # database connection file
    include '../db.conn.php';
    

    // รับมูลจาก post request และ เก็บไวใน var
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // validation
    if(empty($username)){
        $em = "Username is required";


        // redirect ไปยัง 'index.php' และส่ง error message
        header("Location: ../../index.php?error=$em");   
        
    }else if(empty($password)){
        $em = "Password is required";


        // redirect ไปยัง 'index.php' และส่ง error message
        header("Location: ../../index.php?error=$em");   
        
    }else{
        $sql = "SELECT * FROM
                users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        // ถ้ามี username อยู่
        if($stmt->rowCount() === 1){
            $user = $stmt->fetch();
            if($user['username'] === $username){
                // ยืนยันการ encrypted password
                if(password_verify($password, $user['password'])){
                    // สร้าง session
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['user_id'] = $user['user_id'];

                    header("Location: ../../home.php");

                }else{
                    # error message
                    $em = "Incorect Username or password";

                    header("Location: ../../index.php?error=$em");
                    
                }

            }else{
                $em = "Incorect Username or password";

                header("Location: ../../index.php?error=$em");
                
            }
        }
        

    }


}else{
    header("Location: ../../index.php");
    exit;
}