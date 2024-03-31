<?php


session_start();

# check if the user is logged in
if (isset($_SESSION['username'])) {
    if(isset($_POST['key'])){
        # database connection file
        include '../db.conn.php';
        $key = "%{$_POST['key']}%";
        $sql = "SELECT * FROM users
                WHERE username
                LIKE ? OR name LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$key, $key]);

        if($stmt->rowCount() > 0){ 
            $users = $stmt->fetchAll();

            foreach($users as $user){
                // เช็คถ้าชื่อตรงกับผู้ใช้ ไม่ต้องแสดง
                if($user['user_id'] == $_SESSION['user_id']) continue;
            ?>
            <li class="list-group-item">
                            <a href="chat.php?user=<?=$user['username']?>" class="d-flex justify-content-between align-items-center p-2">
                                <div class="d-flex align-items-center ">
                                    <img src="uploads/use-default.png" alt="" class="w-10 rounded-circle" style="width: 15%">
                                    <h3 class="fs-xs m-2">
                                        <?=$user['name']?>
                                    </h3>
                                </div>
                                
                            </a>
                        </li>
        <?php } } else{ ?>
            <div class="alert alert-info text-center">
            <i class="fa fa-user-times d-block fs-big"></i>
            The user "<?=htmlspecialchars($_POST['key'])?>"
            is  not found.
            </div>
        <?php 
        }
    }
}else {
	header("Location: ../../index.php");
	exit;
}