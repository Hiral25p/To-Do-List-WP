<?php
require_once("./include-files/functions.inc.php");
$dbBridge = new dataBaseBridge();

if(!isset($_GET['type'])){
   dd("How Did you get over here?");
}
if(!isset($_GET['id'])){
    dd("No ID Passed");
}
$id = $_GET['id'];
$type = $_GET['type'];

if($type === "singleTask"){
    $query = "DELETE FROM task_list WHERE id=$id";
    $result = $dbBridge->dbQuery($query);
    if($result){
        redirect("index.php?op=delete&status=success");
    }   else    {
        redirect("index.php?op=delete&status=failure");
    }
}   
else if($type === "section"){
    $today = date("Y-m-d");
    $weekend = changeDateFormat("next sunday");
    $month = date('n');
    if($id == "delete-overdue"){
        $query = "DELETE FROM task_list WHERE completion<'$today'";
        $result = $dbBridge->dbQuery($query);
        if($result){
            redirect("index.php?op=delete&status=success");
        }   else    {
            redirect("index.php?op=delete&status=failure");
        }
    }   else if($id == "delete-today"){
        $query = "DELETE FROM task_list WHERE completion='$today'";
        $result = $dbBridge->dbQuery($query);
        if($result){
            redirect("index.php?op=delete&status=success");
        }   else    {
            redirect("index.php?op=delete&status=failure");
        }
    }   else if($id == "delete-this-week"){
        $query = "DELETE FROM task_list  WHERE completion > '$today' AND completion <= '$weekend'";
        $result = $dbBridge->dbQuery($query);
        if($result){
            redirect("index.php?op=delete&status=success");
        }   else    {
            redirect("index.php?op=delete&status=failure");
        }
    }   else if($id == "delete-this-month"){
        $query = "DELETE FROM task_list  WHERE completion > '$weekend' AND month(completion)=$month";
        $result = $dbBridge->dbQuery($query);
        if($result){
            redirect("index.php?op=delete&status=success");
        }   else    {
            redirect("index.php?op=delete&status=failure");
        }
    }   else if($id == "delete-later"){
        $query = "DELETE FROM task_list  WHERE month(completion)>$month";
        $result = $dbBridge->dbQuery($query);
        if($result){
            redirect("index.php?op=delete&status=success");
        }   else    {
            redirect("index.php?op=delete&status=failure");
        }
    }  
}
?>