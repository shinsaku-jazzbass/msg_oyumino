<?php

//group_chat_disp.php

include('database_connection.php');

session_start();

echo fetch_group_chat_history($connect);

?>