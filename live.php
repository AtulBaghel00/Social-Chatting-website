<?php
 
$servername= "localhost";
$username="root";
$password="";
$database="CHAT";
$conn= mysqli_connect("$servername","$username","$password","$database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // $now = strtotime(date("Y/m/d h:i:s"));
  // $last_active_date =  "SELECT last_active_update FROM user_info";
  // $interval  = abs($last_active_date - $now);
  // $minutes   = round($interval / 60);



// $user_info = $conn->real_escape_string($_POST['user_info']);

// $a= mysqli_query($conn,"Select username from user_info");
// echo $a;

// $sql = "SELECT username FROM user_info where ";
// $result = $conn->query($sql);



// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//       echo "username: " . $row["username"]. "<br>";
//     }
//   } else {
//     echo "0 results";
//   }
//   $conn->close();
 
// get the current time
// $currentTime = time();

// // set the timeout interval for activity
// $timeout = 300; // 5 minutes

// // initialize an array to store online users
// $onlineUsers = array();

// // query the database for active users
// $sql = "SELECT DISTINCT username FROM user_info WHERE last_active_update > ($currentTime-$timeout)";
// $result = $conn->query($sql);
 
// if ($result->num_rows > 0) {
//     // loop through the results and add users to the online users array
//     while ($row = $result->fetch_assoc()) {
//         $user_id = $row['username'];
//         $onlineUsers[] = $user_id;
        
        
//     }
// }
 

// print the list of online users
// echo '<div class="online" >';
// echo  implode("<br>", $onlineUsers);
// echo '</div>';

// close the database connection


// Assuming the existence of a users table with a last_login column

 
class Right {
    public static function generateFriendContact($current_user_id, $user) {

        $now = strtotime(date("Y/m/d h:i:s"));
            $last_active_date = strtotime($user->getPropertyValue("last_active_update"));
            $interval  = abs($last_active_date - $now);
            $minutes   = round($interval / 60);
    }
}
// calculate the time threshold for determining if a user is online
$online_threshold = time() - 300; // assuming a user is online if their last login time is within the last 5 minutes (300 seconds)
echo $online_threshold;
// select the online users
$sql = "SELECT username FROM user_info WHERE  $minutes < 5";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // display the list of online users
    echo "Online users:<br>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['username']."<br>";
    }
} else {
    // no online users found
    echo "No online users";
}

// close the database connection
mysqli_close($conn);

$conn->close();
    

 
?>
<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="live.css">
</head>
<body>
    <table>
    <tr>
    <div class="online">
    
        <?php echo  implode("<br>", $onlineUsers); ?>
        <img src="public/assets/images/icons/$online_status" class="image-style-4 contact-user-connection-icon" alt="">
    </div>
</table>
</body>
</html> -->