<?php 
$user_id = $_SESSION['login_id'];
function getConversation($user_id, $conn){
  /**
    Getting all the conversations 
    for current (logged in) user
  **/
  $sql = "SELECT * FROM conversations
          WHERE user_1=? OR user_2=?
          ORDER BY conversation_id DESC";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $user_id, $user_id); // Bind parameters as integers
  $stmt->execute();

  $result = $stmt->get_result();

  if($result->num_rows > 0){
      $conversations = $result->fetch_all(MYSQLI_ASSOC);

      /**
        creating empty array to 
        store the user conversation
      **/
      $user_data = [];
      
      # looping through the conversations
      foreach($conversations as $conversation){
          # if conversations user_1 row equal to user_id
          if ($conversation['user_1'] == $user_id) {
              $sql2  = "SELECT *
                        FROM users WHERE id=?";
              $stmt2 = $conn->prepare($sql2);
              $stmt2->bind_param("i", $conversation['user_2']);
              $stmt2->execute();
          }else {
              $sql2  = "SELECT *
                        FROM users WHERE id=?";
              $stmt2 = $conn->prepare($sql2);
              $stmt2->bind_param("i", $conversation['user_1']);
              $stmt2->execute();
          }

          $result2 = $stmt2->get_result();
          $allConversations = $result2->fetch_all(MYSQLI_ASSOC);

          # pushing the data into the array 
          array_push($user_data, $allConversations[0]);
      }

      return $user_data;

  }else {
      $conversations = [];
      return $conversations;
  }  
}
