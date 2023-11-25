<!DOCTYPE html>
<?php
require_once("./include-files/functions.inc.php");
$dbBridge = new dataBaseBridge();

$today = date("Y-m-d");
$weekend = changeDateFormat("next sunday");
$month = date('n');

$selectorUsed = false;
$selectorTitle = "";
$selectorType = "";
$query = "";
if(!empty($_GET)){
    if(isset($_GET['filter']) || isset($_GET['sort'])){    
        $selectorUsed = true;
        if(isset($_GET['filter'])){
            $selectorTitle = "Filtered";
            $selectorType = ucwords($_GET['filter-by']);
            $query = "SELECT * FROM task_list WHERE {$_GET['filter']} = '{$_GET['filter-by']}'";
        } 
        //Space for sort
        if(isset($_GET['sort'])){
            $selectorTitle = $selectorTitle == "" ? "Sorted" : $selectorTitle . " and Sorted";
            $selectorType = ucwords($_GET['sort']);
            if($query == ""){
                $query = "SELECT * FROM task_list ORDER BY {$_GET['sort']}";
            }   else    {
                $query = $query . " ORDER BY {$_GET['sort']}";
            }
        }
        $rows = $dbBridge->dbSelect($query);
    } else if(isset($_GET['op'])){
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Import Custom CSS-->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/base.css" type="text/css">
    <link rel="stylesheet" href="css/index.css" type="text/css">


    <title>To-Do List</title>
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
        <div class="selectorList flex-row mt30">
            <div id="sort" class="dropdown">
                <div id="sort-title" class="dropdown-title pb5">Sort By</div>
                <div id="sort-dropdown-list" class="dropdown-list flex-clm white-bg">
                    <div id="sort-item-remove" class="dropdown-item pt5 pb5">Remove Sorting</div>
                    <div id="sort-item-name" class="dropdown-item pt5 pb5">
                        (A-Z)
                    </div>
                    <div id="sort-item-priority" class="dropdown-item pt5 pb5">
                        Priority
                    </div>
                    <div id="sort-item-creation" class="dropdown-item pt5 pb5">
                        Creation Date
                    </div>
                    <div id="sort-item-completion" class="dropdown-item pt5 pb5">
                        Completion Date
                    </div>
                    
                </div>
            </div>
            <div id="filter" class="dropdown">
                <div id="filter-title" class="dropdown-title pb5">Filter By</div>
                <div id="filter-dropdown-list" class="dropdown-list flex-clm white-bg">
                    <div id="filter-item-remove" class="dropdown-item pt5 pb5" onclick="window.location.href = 'index.php'">Remove Filters</div>
                    <div id="filter-item-category" class="dropdown-item pt5 pb5">
                        Category
                        <div id="filter-input-category" class="dropdown-input white-bg pl10 pr10 pt10 pb10">
                            <div class="wt400 fs-20">Enter Category</div>
                            <form id="category-input-form" class="pt20 pb20" action="" method="GET">
                                <input name="filter-by" class="form-input" autocomplete="off" type="text">
                                <button name="filter" value="category" class="btn mt10" type="submit">Apply Filter</button>
                            </form>
                        </div>
                    </div>
                    <div id="filter-item-priority"class="dropdown-item pt5 pb5">
                        Priority
                        <div id="filter-input-priority" class="dropdown-input white-bg pl10 pr10 pt10 pb10">
                            <div class="wt400 fs-20">Enter Priority</div>
                            <form id="priority-input-form" class="pt20 pb20" action="" method="GET">
                                <input name="filter-by" class="form-input" autocomplete="off" type="number" min="1" max="3">
                                <button name="filter" value="priority" class="btn mt10" type="submit">Apply Filter</button>
                            </form>
                        </div>
                    </div>
                    <div id="filter-item-creation" class="dropdown-item pt5 pb5">
                        Creation Date
                        <div id="filter-input-creation" class="dropdown-input white-bg pl10 pr10 pt10 pb10">
                            <div class="wt400 fs-20">Enter Creation Date</div>
                            <form id="creation-input-form" class="pt20 pb20" action="" method="GET">
                                <input name="filter-by" class="form-input" autocomplete="off" type="date">
                                <button name="filter" value="creation" class="btn mt10" type="submit">Apply Filter</button>
                            </form>
                        </div>
                    </div>
                    <div id="filter-item-username" class="dropdown-item pt5 pb5">
                    <div id="filter-input-username" class="dropdown-input white-bg pl10 pr10 pt10 pb10">
                     <div class="wt400 fs-20">Enter Username</div>
                         <form id="username-input-form" class="pt20 pb20" action="" method="GET">
                          <input name="filter-by" class="form-input" autocomplete="off" type="text">
                          <button name="filter" value="username" class="btn mt10" type="submit">Apply Filter</button>
                         </form>
                     </div>
                    </div>
                    <div class="dropdown-item pt5 pb5">
                    <div id="filter-item-completion" class="dropdown-item pt5 pb5">
                        Completion Date
                        <div id="filter-input-completion" class="dropdown-input white-bg pl10 pr10 pt10 pb10">
                            <div class="wt400 fs-20">Enter Completion Date</div>
                            <form id="completion-input-form" class="pt20 pb20" action="" method="GET">
                                <input name="filter-by" class="form-input" autocomplete="off" type="date">
                                <button name="filter" value="completion" class="btn mt10" type="submit">Apply Filter</button>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div><a href="add-task.php" class="btn primary-bg black-text">Add Task</a></div>
        </div>
        <?php
        if($selectorUsed):
        ?>
            <div id="selector-filter-list">
                <?php    
                    if($rows == false || empty($rows)):
                        if($_GET['filter'] == "category"){
                            $message = "No task of this category was found!";
                        }   else if($_GET['filter'] == "priority"){
                            $message = "No task of this priority exists!";
                        }   else if($_GET['filter'] == "creation"){
                            $message = "No task was created on this day!";
                        }   else if($_GET['filter'] == "completion"){
                            $message = "No tasks are due on this day!";
                        }
                ?>
                <div class="ml30 mr30 mt30 mb30 fs-30 wt400"><?=$message?></div>
                <?php
                    else:
                ?>
                    <div id="selected-tasks" class="mt30">
                        <h2 class="title fs-20 wt400"><?=$selectorTitle . " by " . $selectorType?></h2>
                        <table class="task-list mt20">
                            <thead class="primary-bg">
                                <tr class="pt10 pb10 flex-row">
                                    <th class="name fs-15 wt700">Task Name</th>
                                    <th class="description fs-15 wt700">Task Description</th>
                                    <th class="priority fs-15 wt700">Priority</th>
                                    <th class="creation fs-15 wt700">Date of Creation</th>
                                    <th class="completion fs-15 wt700">Date of Completion</th>
                                    <th id="delete-overdue" class="btn-complete section-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-task-section')">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($rows as $row):
                                        switch($row->priority){
                                            case 1:
                                                $priority = "High";
                                                break;
                                            case 2:
                                                $priority = "Medium";
                                                break;
                                            case 3:
                                                $priority = "Low";
                                                break;
                                        }
                                ?>
                                <tr class="pt10 pb10 flex-row">
                                    <td class="name fs-15 wt300"><?=$row->name?><div style="background:<?=$row->color?>" class="category fs-10 wt700" ><?=$row->category?></div></td>
                                    <td class="description fs-15 wt300"><?=$row->description?></td>
                                    <td class="priority fs-15 wt300"><?=$priority?></td>
                                    <td class="creation fs-15 wt300"><?=changeDateFormat($row->creation, "jS F Y")?></td>
                                    <td class="completion fs-15 wt300"><?=changeDateFormat($row->completion, "jS F Y")?></td>
                                    <td id="<?=$row->id?>"class="btn-complete task-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-single-task')">+</a></td>
                                </tr>
                            </tbody>
                            <?php
                                endforeach;
                            ?>
                        </table>
                    </div>
                <?php
                    endif;
                ?>
            </div>
        <?php
        endif;
        ?>
        <?php
        if(isset($_GET['filter'])){
    $selectorTitle = "Filtered";
    $selectorType = ucwords($_GET['filter-by']);
    switch($_GET['filter']){
        case 'category':
            $query = "SELECT * FROM task_list WHERE category = '{$_GET['filter-by']}'";
            break;
        case 'priority':
            $query = "SELECT * FROM task_list WHERE priority = '{$_GET['filter-by']}'";
            break;
        case 'creation':
            $query = "SELECT * FROM task_list WHERE creation = '{$_GET['filter-by']}'";
            break;
        case 'completion':
            $query = "SELECT * FROM task_list WHERE completion = '{$_GET['filter-by']}'";
            break;
        case 'username':  // New case for filtering by username
            $query = "SELECT * FROM task_list WHERE username = '{$_GET['filter-by']}'";
            break;
    }
    $rows = $dbBridge->dbSelect($query);
} 
?>

        <?php
        if(!$selectorUsed):
        ?>
            <div id="normal-task-list">
                <?php
                    $query = "SELECT * FROM task_list WHERE completion<'$today'";
                    $rows = $dbBridge->dbSelect($query);
                    if(!empty($rows)):
                ?>
                    <div id="over-due" class="mt30">
                        <h2 class="title fs-20 wt400">Tasks Over Due</h2>
                        <table class="task-list mt20">
                            <thead class="primary-bg">
                                <tr class="pt10 pb10 flex-row">
                                    <th class="name fs-15 wt700">Task Name</th>
                                    <th class="description fs-15 wt700">Task Description</th>
                                    <th class="priority fs-15 wt700">Priority</th>
                                    <th class="creation fs-15 wt700">Date of Creation</th>
                                    <th class="completion fs-15 wt700">Date of Completion</th>
                                    <th id="delete-overdue" class="btn-complete section-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-task-section')">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($rows as $row):
                                        switch($row->priority){
                                            case 1:
                                                $priority = "High";
                                                break;
                                            case 2:
                                                $priority = "Medium";
                                                break;
                                            case 3:
                                                $priority = "Low";
                                                break;
                                        }
                                ?>
                                <tr class="pt10 pb10 flex-row">
                                    <td class="name fs-15 wt300"><?=$row->name?><div style="background:<?=$row->color?>" class="category fs-10 wt700" ><?=$row->category?></div></td>
                                    <td class="description fs-15 wt300"><?=$row->description?></td>
                                    <td class="priority fs-15 wt300"><?=$priority?></td>
                                    <td class="creation fs-15 wt300"><?=changeDateFormat($row->creation, "jS F Y")?></td>
                                    <td class="completion fs-15 wt300"><?=changeDateFormat($row->completion, "jS F Y")?></td>
                                    <td id="<?=$row->id?>"class="btn-complete task-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-single-task')">+</a></td>
                                </tr>
                            </tbody>
                            <?php
                                endforeach;
                            ?>
                        </table>
                    </div>
                <?php
                    endif;
                ?>

                <?php
                    $query = "SELECT * FROM task_list WHERE completion='$today'";
                    $rows = $dbBridge->dbSelect($query);
                    if(!empty($rows)):
                ?>
                    <div id="due-today" class="mt30">
                        <h2 class="title fs-20 wt400">Tasks Due Today</h2>
                        <table class="task-list mt20">
                            <thead class="primary-bg">
                                <tr class="pt10 pb10 flex-row">
                                    <th class="name fs-15 wt700">Task Name</th>
                                    <th class="description fs-15 wt700">Task Description</th>
                                    <th class="priority fs-15 wt700">Priority</th>
                                    <th class="creation fs-15 wt700">Date of Creation</th>
                                    <th class="completion fs-15 wt700">Date of Completion</th>
                                    <th id="delete-today" class="btn-complete section-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-task-section')">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($rows as $row):
                                        switch($row->priority){
                                            case 1:
                                                $priority = "High";
                                                break;
                                            case 2:
                                                $priority = "Medium";
                                                break;
                                            case 3:
                                                $priority = "Low";
                                                break;
                                        }
                                ?>
                                <tr class="pt10 pb10 flex-row">
                                    <td class="name fs-15 wt300"><?=$row->name?><div style="background:<?=$row->color?>" class="category fs-10 wt700" ><?=$row->category?></div></td>
                                    <td class="description fs-15 wt300"><?=$row->description?></td>
                                    <td class="priority fs-15 wt300"><?=$priority?></td>
                                    <td class="creation fs-15 wt300"><?=changeDateFormat($row->creation, "jS F Y")?></td>
                                    <td class="completion fs-15 wt300"><?=changeDateFormat($row->completion, "jS F Y")?></td>
                                    <td id="<?=$row->id?>"class="btn-complete task-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-single-task')">+</a></td>
                                </tr>
                            </tbody>
                            <?php
                                endforeach;
                            ?>
                        </table>
                    </div>
                <?php
                    endif;
                ?>

                <?php
                    $query = "SELECT * FROM task_list WHERE completion > '$today' AND completion <= '$weekend'";
                    $rows = $dbBridge->dbSelect($query);
                    if(!empty($rows)):
                ?>
                    <div id="due-this-week" class="mt30">
                        <h2 class="title fs-20 wt400">Tasks Due This Week</h2>
                        <table class="task-list mt20">
                            <thead class="primary-bg">
                                <tr class="pt10 pb10 flex-row">
                                    <th class="name fs-15 wt700">Task Name</th>
                                    <th class="description fs-15 wt700">Task Description</th>
                                    <th class="priority fs-15 wt700">Priority</th>
                                    <th class="creation fs-15 wt700">Date of Creation</th>
                                    <th class="completion fs-15 wt700">Date of Completion</th>
                                    <th id="delete-this-week" class="btn-complete section-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-task-section')">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($rows as $row):
                                        switch($row->priority){
                                            case 1:
                                                $priority = "High";
                                                break;
                                            case 2:
                                                $priority = "Medium";
                                                break;
                                            case 3:
                                                $priority = "Low";
                                                break;
                                        }
                                ?>
                                <tr class="pt10 pb10 flex-row">
                                    <td class="name fs-15 wt300"><?=$row->name?><div style="background:<?=$row->color?>" class="category fs-10 wt700" ><?=$row->category?></div></td>
                                    <td class="description fs-15 wt300"><?=$row->description?></td>
                                    <td class="priority fs-15 wt300"><?=$priority?></td>
                                    <td class="creation fs-15 wt300"><?=changeDateFormat($row->creation, "jS F Y")?></td>
                                    <td class="completion fs-15 wt300"><?=changeDateFormat($row->completion, "jS F Y")?></td>
                                    <td id="<?=$row->id?>" class="btn-complete task-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-single-task')">+</a></td>
                                </tr>
                            </tbody>
                            <?php
                                endforeach;
                            ?>
                        </table>
                    </div>
                <?php
                    endif;
                ?>

                <?php
                    $query = "SELECT * FROM task_list WHERE completion > '$weekend' AND month(completion)=$month";
                    $rows = $dbBridge->dbSelect($query);
                    if(!empty($rows)):
                ?>
                    <div id="due-this-month" class="mt30">
                        <h2 class="title fs-20 wt400">Tasks Due This Month</h2>
                        <table class="task-list mt20">
                            <thead class="primary-bg">
                                <tr class="pt10 pb10 flex-row">
                                    <th class="name fs-15 wt700">Task Name</th>
                                    <th class="description fs-15 wt700">Task Description</th>
                                    <th class="priority fs-15 wt700">Priority</th>
                                    <th class="creation fs-15 wt700">Date of Creation</th>
                                    <th class="completion fs-15 wt700">Date of Completion</th>
                                    <th id="delete-this-month" class="btn-complete section-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-task-section')">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($rows as $row):
                                        switch($row->priority){
                                            case 1:
                                                $priority = "High";
                                                break;
                                            case 2:
                                                $priority = "Medium";
                                                break;
                                            case 3:
                                                $priority = "Low";
                                                break;
                                        }
                                ?>
                                <tr class="pt10 pb10 flex-row">
                                    <td class="name fs-15 wt300"><?=$row->name?><div style="background:<?=$row->color?>" class="category fs-10 wt700" ><?=$row->category?></div></td>
                                    <td class="description fs-15 wt300"><?=$row->description?></td>
                                    <td class="priority fs-15 wt300"><?=$priority?></td>
                                    <td class="creation fs-15 wt300"><?=changeDateFormat($row->creation, "jS F Y")?></td>
                                    <td class="completion fs-15 wt300"><?=changeDateFormat($row->completion, "jS F Y")?></td>
                                    <td id="<?=$row->id?>" class="btn-complete task-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-single-task')">+</a></td>
                                </tr>
                            </tbody>
                            <?php
                                endforeach;
                            ?>
                        </table>
                    </div>
                <?php
                    endif;
                ?>

                <?php
                    $query = "SELECT * FROM task_list WHERE month(completion)>$month";
                    $rows = $dbBridge->dbSelect($query);
                    if(!empty($rows)):
                ?>
                    <div id="due-later" class="mt30">
                        <h2 class="title fs-20 wt400">Tasks Due Later</h2>
                        <table class="task-list mt20">
                            <thead class="primary-bg">
                                <tr class="pt10 pb10 flex-row">
                                    <th class="name fs-15 wt700">Task Name</th>
                                    <th class="description fs-15 wt700">Task Description</th>
                                    <th class="priority fs-15 wt700">Priority</th>
                                    <th class="creation fs-15 wt700">Date of Creation</th>
                                    <th class="completion fs-15 wt700">Date of Completion</th>
                                    <th id="delete-later" class="btn-complete section-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-task-section')">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($rows as $row):
                                        switch($row->priority){
                                            case 1:
                                                $priority = "High";
                                                break;
                                            case 2:
                                                $priority = "Medium";
                                                break;
                                            case 3:
                                                $priority = "Low";
                                                break;
                                        }
                                ?>
                                <tr class="pt10 pb10 flex-row">
                                    <td class="name fs-15 wt300"><?=$row->name?><div style="background:<?=$row->color?>" class="category fs-10 wt700" ><?=$row->category?></div></td>
                                    <td class="description fs-15 wt300"><?=$row->description?></td>
                                    <td class="priority fs-15 wt300"><?=$priority?></td>
                                    <td class="creation fs-15 wt300"><?=changeDateFormat($row->creation, "jS F Y")?></td>
                                    <td class="completion fs-15 wt300"><?=changeDateFormat($row->completion, "jS F Y")?></td>
                                    <td id="<?=$row->id?>" class="btn-complete task-delete"><a class="fs-20 wt500 black-text" href="#delete-single-task" onclick="displayModal('#delete-single-task')">+</a></td>
                                </tr>
                            </tbody>
                            <?php
                                endforeach;
                            ?>
                        </table>
                    </div>
                <?php
                    endif;
                ?>
            </div>
        <?php
        endif;
        ?>
    </div>

    <div id="delete-single-task" class="modal">
        <div class="modal-content white-bg">    
            <div class="modal-text">
                <h4 class="pt30">Delete Task From List?</h4>
                <p class="mt20">Are you sure you want to delete this task from the to-do list?</p>
            </div>
            <div class="modal-footer mt140 mr30">
                <a href="" class="modal-close mr20 btn lgray-bg black-text" onclick="hideModal('#delete-single-task')">Cancel</a>
                <a href="delete.php?type=singleTask" id="singleTaskDeleteConfirm" class="modal-close btn primary-bg black-text">Confirm</a>
            </div>
        </div>
    </div>

    <div id="delete-task-section" class="modal">
        <div class="modal-content white-bg">    
            <div class="modal-text">
                <h4 class="pt30">Delete all Tasks from section?</h4>
                <p class="mt20">Are you sure you want to delete all these tasks from the to-do list?</p>
            </div>
            <div class="modal-footer mt140 mr30">
                <a href="" class="modal-close mr20 btn lgray-bg black-text" onclick="hideModal('#delete-task-section')">Cancel</a>
                <a href="delete.php?type=section" id="sectionDeleteConfirm" class="modal-close btn primary-bg black-text">Confirm</a>
            </div>
        </div>
    </div>

    <div id="delete-successful" class="toast">
        <div class="toast-text pt15 pb15 pl40 pr40 fs-20 wt300 white-text green-bg">Task Deleted Successfully!</div>
    </div>

    <div id="delete-unsuccessful" class="toast">
        <div class="toast-text pt15 pb15 pl40 pr40 fs-20 wt300 white-text red-bg">Task Could Not Be Deleted!</div>
    </div>

    <div id="add-successful" class="toast">
        <div class="toast-text pt15 pb15 pl40 pr40 fs-20 wt300 white-text green-bg">Task Added Successfully!</div>
    </div>

    <footer>
        <h2 class="footer-text fs-25 wt300 mt50 pl30 pt30 pb30 primary-bg black-text wt700">16010421071 and 16010421112</h2>
    </footer>
</body>

    <!--Include Page Level Scripts-->
    <script src="js/pages/home.js"></script>

    <!--Include Website Wide Level Scripts-->
    <script src="js/dateAndTime.js"></script>
</html>