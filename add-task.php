<!DOCTYPE html>
<?php
require_once("./include-files/functions.inc.php");
$dbBridge = new dataBaseBridge();
$today = date("Y-m-d");
if(!empty($_POST)){
    $name = $_POST['name'];
    $priority = $_POST['priority'];
    $completion = changeDateFormat($_POST['completion']);
    $description = $_POST['description'];
    $color = $_POST['color'];
    $category = $_POST['category'];
    $reminder = changeDateFormat($_POST['reminder']);

    $query = "INSERT INTO task_list(name, category, color, priority, description, completion, reminder) VALUES ('$name', '$category', '$color', '$priority', '$description', '$completion', '$reminder')";
    $result = $dbBridge->dbQuery($query);
    if(!$result){
        $error = $dbBridge->dbError();
        $error_message = "Something went wrong with the database! Please try again later!";
        die($error_message);
    }   else    {
        redirect("index.php?op=add&status=success");
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Import Custom CSS-->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/base.css" type="text/css">
    <link rel="stylesheet" href="css/add-task.css" type="text/css">


    <title>To-Do List | Add Task</title>
</head>
<body>
    <nav class="primary-bg">
        <div class="container flex-row flex-space-between fs-25">
            <h1 class="nav-title wt400">To Do List</h1>
            <div class="date-time flex-row flex-space-between">
                <div id = "nav-date" class="wt300"></div>
                <div id = "nav-time" class="wt300"></div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="title ml30 mt10 fs-60 wt400">Add Task</div>
        <form class="ml30 mr30 mt20 flex-clm" action="index.php" id="add-task-form" method="POST" enctype="multipart/form-data">
                
        <div class="flex-row">
                <div class="form-item">
                    <input id="task-name" name ="name" class="pl10 pr10 pt5 pb5 form-input fs-20" type="text" autocomplete="off" placeholder=" ">
                    <label for="task-name" class="form-label pl10 fs-20">Task Name<span class="red-text">*</span></label>
                    <div id="error-name" class="error red-text fs-10"></div>
                </div>
                <div class="form-item">
                    <input id="task-priority" name="priority"class="pl10 pr10 pt5 pb5 form-input fs-20" type="number" min="1" max="3" autocomplete="off" placeholder=" ">
                    <label for="task-priority" class="form-label pl10 fs-20">Task Priority (Between 1-3)<span class="red-text">*</span></label>
                    <div id="error-priority" class="error red-text fs-10"></div>
                </div>
            </div>
            <div class="flex-row">
                <div class="form-item">
                    <input id="task-category" name="category" class="pl10 pr10 pt5 pb5 form-input fs-20" type="text" autocomplete="off" placeholder=" ">
                    <label for="task-category" class="form-label pl10 fs-20">Task Category</label>
                    <div id="error-category" class="error red-text fs-10"></div>
                </div>
                <div class="form-item flex-row">
                    <input id="task-color" name="color" class="pl10 pr10 pt5 pb5 form-input fs-20" type="text" autocomplete="off" placeholder=" ">
                    <div id="task-color-picker" class="ml20">
                        <span id="color-value" class="fs-15 wt700">#000000</span>
                        <input type="color" id="color-picker">
                    </div>
                    <label for="task-color" class="form-label pl10 fs-20">Task Color</label>
                    <div id="error-color" class="error red-text fs-10"></div>
                </div>
            </div>
            <div class="flex-row">
                <div class="form-item">
                    <input id="task-completion" name="completion" class="pl10 pr10 pt5 pb5 form-input fs-20" type="text" min="<?=$today;?>" onfocus="(this.type='date')" autocomplete="off" placeholder=" ">
                    <?php

                    ?>
                    <label for="task-completion" class="form-label pl10 fs-20">Task Completion Date<span class="red-text">*</span></label>
                    <div id="error-completion" class="error red-text fs-10"></div>
                </div>
                <div class="form-item">
                    <input id="task-reminder" name="reminder" class="pl10 pr10 pt5 pb5 form-input fs-20" type="text" min="<?=$today;?>" max=""onfocus="(this.type='date')" autocomplete="off" placeholder=" ">
                    <label for="task-reminder" class="form-label pl10 fs-20">Task Reminder Date</label>
                </div>
            </div>
            <div class="flex-row">
                <div class="form-item">
                    <textarea id="task-description" name="description" class="pl10 pr10 pt5 pb5 form-input form-textarea fs-20" type="text" autocomplete="off" placeholder=" "></textarea>
                    <label for="task-description" class="form-label pl10 fs-20">Task Desription<span class="red-text">*</span></label>
                    <div id="error-description" class="error red-text fs-10"></div>
                </div>
            </div>
            <div class="flex-row">
                <div class="form-item">
                    <button id="submit-button" class="btn primary-bg fs-20" type="submit" name="action">Create Task</button>
                </div>
                    
            </div>
        </form>
    </div>

    <footer>
        <h2 class="footer-text fs-25 wt300 mt30 pl30 pt30 pb30 primary-bg black-text wt700">16010421071 and 16010421112</h2>
    </footer>
    <!--Include Website Wide Level Scripts-->
    <script src="js/dateAndTime.js"></script>

    <!--Include Page Level Script-->
    <script src="js/pages/add-task.js"></script>
</body>