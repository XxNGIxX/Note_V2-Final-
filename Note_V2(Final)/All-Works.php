<?php
session_start();
include 'db.php';
$name = $_SESSION['username'];
$id = $_SESSION['user_id'];

// ------------------------------------------------------------------ Filter  ------------------------------------------------------------------

$filter_name = isset($_POST['filter_name']) && $_POST['filter_name'] !== '' ? "AND task.title = '{$_POST['filter_name']}'" : '';
$filter_category_id = isset($_POST['filter_category']) && $_POST['filter_category'] !== '' ? "AND categories.category_id = '{$_POST['filter_category']}'" : '';
$filter_priority = isset($_POST['filter_priority']) && $_POST['filter_priority'] !== '' ? "AND priority.priority_id = '{$_POST['filter_priority']}'" : '';
$date_start = isset($_POST['date_start']) && $_POST['date_start'] !== '' ? $_POST['date_start'] : '';
$date_end = isset($_POST['date_end']) && $_POST['date_end'] !== '' ? $_POST['date_end'] : '';
$filter_date = !empty($date_end) ? "AND DATE(transactions.date_time) BETWEEN '$date_start' AND '$date_end'" : '';




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 // ------------------------------------------------------------------ Insert Task ------------------------------------------------------------------ 
 if(isset($_POST['title'])){ 

     $title = $_POST['title'];
     $description = $_POST['description'];
     $due_date = $_POST['date'];
     $priority_id = $_POST['priority'];
     $status_id = 0;//$_POST['status'];
     $category_id = isset($_POST['category']) ? $_POST['category'] : 0;

     //-----------------------------------------INSERT---------------------------------------------------------------
     //ยัดข้อมูล
     $sql = "INSERT INTO task(user_id, title, description, due_date, priority_id, status_id, category_id) 
     VALUES('$id','$title', '$description', '$due_date', '$priority_id', '$status_id', '$category_id')";
     $result = mysqli_query($conn, $sql);
     //---------------------------------------------------------------------------------------------------------------
     
     header("location: All-Works.php");
     //exit();  Important to stop further script execution after redirection
     
 }


 // ------------------------------------------------------------------  Insert Category ------------------------------------------------------------------ 
 if(isset($_POST['cate_name'])){

     $cate_name = $_POST['cate_name'];
     
     //-----------------------------------------INSERT---------------------------------------------------------------
     //ยัดข้อมูล
     $sql_cate = "INSERT INTO categories(user_id, name) 
     VALUES('$id','$cate_name')";
     $rs_cate = mysqli_query($conn, $sql_cate);
     //---------------------------------------------------------------------------------------------------------------
     header("location: All-Works.php");
    
 }

 // ------------------------------------------------------------------  Delete Category ------------------------------------------------------------------ 
 if (isset($_POST['delete_category'])) {
     $category_id = $_POST['category_id']; // รับค่า category_id จากฟอร์ม

     //-----------------------------------------DELETE---------------------------------------------------------------
     $sql_d_cate = "DELETE FROM categories WHERE category_id='" . $category_id . "'";
     $rs_d_cate = mysqli_query($conn, $sql_d_cate);
     //---------------------------------------------------------------------------------------------------------------
     header("location: All-Works.php");
 }

 // ------------------------------------------------------------------  Update Status ------------------------------------------------------------------ 

 if (isset($_POST['task_id'])) {
     $task_id = $_POST['task_id'];
     $status = isset($_POST['status']) ? 1 : 0; // ถ้า checkbox ถูกติ๊กจะให้ค่า status เป็น 1 ไม่เช่นนั้นจะเป็น 0

     //-----------------------------------------UPDATE---------------------------------------------------------------
     $update_status_sql = "UPDATE task SET status_id = '$status' WHERE task_id = '$task_id'";
     $result = mysqli_query($conn, $update_status_sql);
     //---------------------------------------------------------------------------------------------------------------
 }
 


 // ------------------------------------------------------------------  Show Task ------------------------------------------------------------------ 
 if (isset($_POST['task_up'])) {
     $_SESSION['task_up'] = $_POST['task_up'];
     $showModal = true; // ตั้งค่าเพื่อแสดงโมดอล
 } else {
     $showModal = false; // ถ้าไม่มีการตั้งค่า ไม่ต้องแสดงโมดอล
 }
 


  // ------------------------------------------------------------------  Update task ------------------------------------------------------------------ 

 if (isset($_POST['title_up'])) {
     $task_id = $_SESSION['task_up'];
     $title_up = $_POST['title_up'];
     $description_up = $_POST['description_up'];
     $due_date_up = $_POST['date_up'];
     $priority_up = isset($_POST['priority_up']) ? $_POST['priority_up'] : 0;
     $category_up = $_POST['category_up'] ;
 

     //-----------------------------------------UPDATE---------------------------------------------------------------
     $update_status_sql = "UPDATE task SET title = '$title_up', description = '$description_up', due_date = '$due_date_up'
     , priority_id = '$priority_up' , category_id = '$category_up'
     WHERE task_id = '$task_id'";
     $result = mysqli_query($conn, $update_status_sql);
     //---------------------------------------------------------------------------------------------------------------
 }
 // ------------------------------------------------------------------  delete Task ------------------------------------------------------------------ 
 if (isset($_POST['del_task'])) {
    $_SESSION['del_task'] = $_POST['del_task'];
    $delModal = true; // ตั้งค่าเพื่อแสดงโมดอล
} else {
    $delModal = false; // ถ้าไม่มีการตั้งค่า ไม่ต้องแสดงโมดอล
}
// ------------------------------------------------------------------  delete task ------------------------------------------------------------------ 

if (isset($_POST['delete_task'])) {
    $task_id = $_SESSION['del_task'];
//-----------------------------------------DELETE---------------------------------------------------------------
$del_status_sql = "DELETE FROM task WHERE task_id='" . $task_id . "'";
$result = mysqli_query($conn, $del_status_sql);
//---------------------------------------------------------------------------------------------------------------

}
}
?>


<!-------------------------------------------------------------------------------------html--------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="styles_index.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Save work</title>

</head>
<body>
    <div class="sidebar">
        <div class="container1 d-flex align-items-center">
            <i class='bx bxs-user'></i>
            <span class="ms-3"><?php echo $name; ?></span>
        </div>
        <hr>

        <ul class="nav nav-pills flex-column mb-auto mt-1">
            <li class="icon nav-item">
            <a href="All-Works.php" class=" nav-link text-white float-start hover-text" style="font-size: 18px;">
                <i class='bx bxs-book me-1'></i> All Works
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white float-start hover-text " style="font-size: 18px;" data-bs-toggle="modal" data-bs-target="#taskModal">
                    <i class='bx bxs-book-add me-1'></i> Manage tasks
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-white float-start hover-text " style="font-size: 18px;" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <i class='bx bxs-category me-1'></i> Manage categories
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-white float-start hover-text " style="font-size: 18px;" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class='bx bxs-filter-alt me-1'></i> Filter
            </a>
            </li>
        </ul>
        
        <div class="dropdown nav nav-pills flex-column">
            <hr>
            <a href="login.php" class="nav-link text-white float-start hover-text">
                <i class='bx bx-log-out me-2' style="font-size: 1.5rem;"></i>
                <span style="font-size: 1.2rem;">Log out</span>
            </a>
        </div>
    </div>

    <div class="container2">
        <div class="text1">
            <h3 class="ms-2">ALL Works</h3>
            <hr style="color: #25252b">
        </div>
<!------------------------------------------------------------------------------ Task Management ----------------------------------------------------------->
        <div class="container3 mx-4">
            <h4 class="ms-2 text-dark">Task Management</h4>
            <?php

            //----------------------------------------------SELECT-------------------------------------------------------------------
            $sql_chk_task = "SELECT * FROM task WHERE user_id='" . $id . "'";
            $rs_chk_task = mysqli_query($conn, $sql_chk_task);
            //-----------------------------------------------------------------------------------------------------------------------


            //----------------------------------------------SELECT AND JOIN-------------------------------------------------------------------
            $get_name = "SELECT task.task_id, task.title, task.description, DATE(task.due_date) AS date, user.username AS user_name, 
            priority.priority_name, status.status_id, status.status_name, categories.name AS category_name
            FROM task
            JOIN user ON task.user_id = user.user_id
            JOIN priority ON task.priority_id = priority.priority_id
            JOIN status ON task.status_id = status.status_id
            JOIN categories ON task.category_id = categories.category_id 
            WHERE task.user_id='" . $id . "'
            $filter_category_id 
            $filter_priority
            $filter_name
            $filter_date
            ORDER BY task.due_date ASC
            ";
             // ASC (จากเก่าไปใหม่) หรือ DESC (จากใหม่ไปเก่า)
            //-----------------------------------------------------------------------------------------------------------------------
        $rs_get = mysqli_query($conn, $get_name);

            if (mysqli_num_rows($rs_chk_task) == 0) {
            ?>
                <div class='text-center'>
                    <hr class="mx-2" style="color: #25252b">
                    <h4 class="text-dark">No tasks available. Please add a task.</h4>
                    <button class='btn' style="background-color: #00ebfe" data-bs-toggle='modal' data-bs-target='#taskModal'>Add Task</button>
                </div>
            <?php
            } else {
            ?>
                <div class='table-responsive mx-2'>
                <table class='table table-hover table-bordered text-dark'>
                <thead class="table-dark">
                    <tr>
                        <th>Send</th>
                        <th>Task Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Priority</th>
                        <th>View</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
            <?php
                while ($row_task = mysqli_fetch_assoc($rs_get)) {
                    if ($row_task['status_id'] == 0) {
            ?>           
                        <tr class="text-dark" style="color: #25252b;">
                        <td>
                            <form action='' method='post'>
                                <input type='hidden' name ='task_id' value='<?=$row_task['task_id']?>'>
                                <input type='checkbox' name='status' value='1' onchange='this.form.submit()' <?= ($row_task['status_id'] == 1 ? 'checked' : '') ?>>
                            </form>
                        </td>
                            <td><?= $row_task['title'] ?></td>
                            <td><?= $row_task['category_name'] ?></td>
                            <td><?= substr($row_task['description'], 0, 10) ?></td>
                            <td><?= $row_task['date'] ?></td>
                            <td><?= $row_task['priority_name'] ?></td>
                            <td>

                            <form action='' method='POST'>
                                    <button class="btn" style="background-color: #00ebfe" type='submit' name='task_up' value="<?= $row_task['task_id']?>">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                            </form>
                            </td>

                            <td>
                            <form action='' method='POST'>
                                    <button class="btn btn-danger" type='submit' name='del_task' value="<?= $row_task['task_id']?>">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                            </form>
                            </td>                            
                        </tr>
                <?php
                    }
                }
                ?>  

                </tbody>
                    </table>
                    </div>
                    <div class='text-center'>
                        <button class='btn' style="background-color: #00ebfe" data-bs-toggle='modal' data-bs-target='#taskModal'>Add Task</button>
                    </div>
            <?php
            }
            ?>
        </div>
<!------------------------------------------------------------------------------ Clear Task Management ----------------------------------------------------------->
        <div class="container mt-5" style="padding-top: 100px;">
            <hr class="mx-4" style="color: #25252b">
            <h4 class="ms-4" style="color: #25252b;">Clear Task Management</h4>

            <?php
            $sql_chk_task = "SELECT * FROM task WHERE user_id='" . $id . "'";
            $rs_chk_task = mysqli_query($conn, $sql_chk_task);

            //---------------------------------------------------SELECT------------------------------------------------------------
            $get_name = "SELECT task.task_id, task.title, task.description, DATE(task.due_date) AS date, user.username AS user_name, 
                priority.priority_name, status.status_id, status.status_name, categories.name AS category_name
                FROM task
                JOIN user ON task.user_id = user.user_id
                JOIN priority ON task.priority_id = priority.priority_id
                JOIN status ON task.status_id = status.status_id
                JOIN categories ON task.category_id = categories.category_id 
                WHERE task.user_id='" . $id . "' AND status.status_id = 1
                ORDER BY task.due_date ASC";
            $rs_get = mysqli_query($conn, $get_name);
            //----------------------------------------------------------------------------------------------------------------------

            if (mysqli_num_rows($rs_chk_task) == 0) {
            ?>    
                <div class='text-center'>
                <hr class="mx-4" style="color: #25252b">
                <h4 class="text-dark">No completed tasks.</h4>
                </div>
            <?php
            } else {
            ?>
            
            <div class='table-responsive mx-4'>
                    <table class='table table-hover table-bordered text-dark'>
                    <thead class="table-dark">
                        <tr>
                            <th>Send</th>
                            <th>Task Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>View</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                while ($row_task = mysqli_fetch_assoc($rs_get)) {
            ?>
                    <tr>
                        <td>
                            <form action='' method='post'>
                                <input type='hidden' name ='task_id' value="<?=$row_task['task_id']?>">
                                <input type='checkbox' name='status' value='1' onchange='this.form.submit()' <?=($row_task['status_id'] == 1 ? 'checked' : '')?>>
                            </form>
                        </td>
                        <td><?= $row_task['title'] ?></td>
                        <td><?=$row_task['category_name']?></td>
                        <td><?= substr($row_task['description'], 0, 10) ?></td>
                        <td><?= date("d/m/Y", strtotime($row_task['date'])) ?></td>
                        <td><?= $row_task['priority_name'] ?></td>
                        <td>

                            <form action='' method='POST'>
                                    <button class="btn" style="background-color: #00ebfe" type='submit' name='task_up' value="<?= $row_task['task_id']?>">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                            </form>
                        </td>

                        <td>
                            <form action='' method='POST'>
                                    <button class="btn btn-danger "type='submit' name='del_task' value="<?= $row_task['task_id']?>">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
                </table>
                </div>
                <?php
                }
                ?>   
            </div>
        </div>

<!------------------------------------------------- Modal filter -------------------------------------------------------------------------->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <!--fade จะทำให้มีเอฟเฟกต์การเลือนเข้า/ออกเมื่อเปิดหรือปิด-->
    <!--aria-hidden="true": ระบุว่าโมดอลนี้ถูกซ่อนโดยค่าเริ่มต้น และจะปรากฏขึ้นเมื่อถูกสั่งให้เปิด-->
        <div class="modal-dialog">
            <div class="modal-content text-light" style="background-color: #25252b; box-shadow: 0 0 30px #00ebfe;" >
                <div class="modal-header">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="taskName" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="taskName" name="filter_name" placeholder="Enter task name" >
                        </div>
                      
                        <div class="mb-3">
                            <label for="account">Category</label>
                            <select id="account" name="filter_category" class="form-control">
                            <option value="">Null</option>
                                <?php

                                //-----------------------------------------SELECT---------------------------------------------------------------
                                // ดึงข้อมูล category มั้ง 🙂
                                $get_cate = "SELECT * FROM categories WHERE user_id = '" . $id . "'"; // จะเอาเเค่ category ของคนที่ login เท่านั้น
                                $rs_get_cate = mysqli_query($conn, $get_cate);
                                //--------------------------------------------------------------------------------------------------------------

                                while ($row_cate = mysqli_fetch_assoc($rs_get_cate)) {
                                    echo "<option value='{$row_cate['category_id']}'>{$row_cate['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dueDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="dueDate" name="date_start">
                        </div>
                        <div class="mb-3">
                            <input type="date" class="form-control" id="dueDate" name="date_end" >
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" value="1" id="priority" name="filter_priority" style="accent-color: blue;">
                            <label class="form-check-label" for="priority">Priority</label>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <div class="">
                                <button type="button" class="btn btn-light" onclick="window.location.href='ALL-Works.php'">
                                <i class="bi bi-arrow-clockwise"></i>Refilter
                                </button>   
                            </div>
                            <div class="">
                                <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #ff2770">Cancel</button>
                                
                                <button type="submit" class="btn" style="background-color: #00ebfe">Filter</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


     <!------------------------------------------------- Modal add task -------------------------------------------------------------------------->
     <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-light" style="background-color: #25252b; box-shadow: 0 0 30px #00ebfe;">
                <div class="modal-header" >
                    <h5 class="modal-title">Task Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="taskName" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="taskName" name="title" placeholder="Enter task name" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="taskDescription" name="description" rows="3" placeholder="Enter description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="account">Category</label>
                            <select id="account" name="category" class="form-control">
                                <option value="">Null</option>
                                <?php

                                //-----------------------------------------SELECT---------------------------------------------------------------
                                // ดึงข้อมูล category มั้ง :)
                                $get_cate = "SELECT * FROM categories WHERE user_id = '" . $id . "'"; // จะเอาเเค่ category ของคนที่ login เท่านั้น
                                $rs_get_cate = mysqli_query($conn, $get_cate);
                                //--------------------------------------------------------------------------------------------------------------

                                while ($row_cate = mysqli_fetch_assoc($rs_get_cate)) {
                                    echo "<option value='{$row_cate['category_id']}'>{$row_cate['name']}</option>";
                                }
                                ?>
                            </select>
                            
                        </div>
                        <div class="mb-3">
                            <label for="dueDate" class="form-label">Due Date</label>
                            <input type="datetime-local" class="form-control" id="dueDate" name="date" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" value="1" id="priority" name="priority">
                            <label class="form-check-label" for="priority">Priority</label>
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #ff2770">Cancel</button>      
                            <button type="submit" class="btn" style="background-color: #00ebfe">Add Task</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



     <!------------------------------------------------- Modal delete ---------------------------------------------------------------------->
     <div class="modal fade <?php echo $delModal ? 'show' : ''; ?>" id="showModal" tabindex="-1"   style="<?php echo $delModal ? 'display: block;' : 'display: none;'; ?>">
    
    <?php
        //-----------------------------------------SELECT---------------------------------------------------------------
        
        $task_up = $_SESSION['del_task'];
        
        //--------------------------------------------------------------------------------------------------------------
    
  
    ?>
    <div class="modal-backdrop">
        <div class="modal-dialog"  >
            <div class="modal-content" style="background-color: #25252b;box-shadow: 0 0 12px #00ebfe;">
                <div class="modal-header text-light">
                    <h5 class="modal-title">Delete</h5>
                    <form >
                        <button  class="btn-close" href="test.php" ></button>
                    </form>
                </div>

                
                <div class="modal-body text-light">

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="taskName w-50" class="form-label">Confirm data deletion</label>
                            <input type="hidden" class="form-control" id="taskName" name="delete_task"  >

                        </div>
                        

                        <div class="modal-footer">
                                <button type="submit" class="btn" data-bs-dismiss="modal" style="background-color: #00ebfe">Confirm</button>
                            </form>
                            <form action="" mothod="post">
                                <button type="submit" class="btn" data-bs-dismiss="modal" style="background-color: #ff2770">Cancel</button>
                            </form>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
    </div>
    <style>
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.3); /* ปรับความโปร่งใส */
}
</style>
<!------------------------------------------------- Modal add category ---------------------------------------------------------------------->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-light" style="background-color: #25252b; box-shadow: 0 0 30px #00ebfe;">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Manage Categories</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="" method="post">
                <div class="modal-body " >
                    <div class="card mb-3 border border-secondary" style="background-color: #25252b;">
                        <div class="card-body">                            
                                <div class="col-md-8">
                                    <label class="mb-2 ms-1">New Category</label>
                                    <input type="text" class="form-control" id="categoryName" name="cate_name" placeholder="Categories Name" required>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn" id="addCategoryBtn" style="background-color: #00ebfe;">
                                         Add Category
                                    </button>
                                </div>
                        </div>
                    </div>
                    </form>

                    
                    <div class="card border border-secondary" style="background-color: #25252b;">
                        <div class="card-header bg-secondary text-white">
                            <strong>Category</strong>
                        </div>
                        
                            <table class="table table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th >Category Name </th>
                                        <th style="width: 150px;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                <?php

                               //-----------------------------------------SELECT---------------------------------------------------------------
                                // ดึงข้อมูล category มั้ง :)
                                $get_cate = "SELECT * FROM categories WHERE user_id = '" . $id . "'"; // จะเอาเเค่ category ของคนที่ login เท่านั้น
                                $rs_get_cate = mysqli_query($conn, $get_cate);
                                //--------------------------------------------------------------------------------------------------------------

                                while ($row_cate = mysqli_fetch_assoc($rs_get_cate)) {
                                ?>
                                            <tr>
                                            <th><?= $row_cate['name'] ?></th>
                                                <th>
                                                    <form action='' method='post' onsubmit='return confirmDelete()'>
                                                        <input type='hidden' name='category_id' value='<?= $row_cate['category_id'] ?>'>
                                                        <button class='btn btn-danger btn-sm' type='submit' name='delete_category'>
                                                        <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                </th>
                                            </tr>
                                    <?php       
                                        }
                                    ?>
                                </tbody>
                            </table>
                        
                    </div>
                </div>



                
            </div>
        </div>
    </div>
    <!------------------------------------------------- Modal show & update -------------------------------------------------------------------------->
<!--<div class="modal fade <?php echo $showModal ? 'show' : ''; ?>" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="<?php echo $showModal ? 'false' : 'true'; ?>" style="<?php echo $showModal ? 'display: block;' : 'display: none;'; ?>"></div>-->


<div class="modal fade <?php echo $showModal ? 'show' : ''; ?>" id="showModal" tabindex="-1"   style="<?php echo $showModal ? 'display: block;' : 'display: none;'; ?>">
    
    <?php
        //-----------------------------------------SELECT---------------------------------------------------------------
        
        $task_up = $_SESSION['task_up'];
        $sql_up = "SELECT task.task_id, task.title, task.description, task.priority_id, task. due_date
        , task.category_id,categories.name AS category_name 
        FROM task 
        JOIN categories ON task.category_id = categories.category_id
        WHERE task_id = '" . $task_up . "'"; 
        $rs_shw_up = mysqli_query($conn, $sql_up);
        $up = mysqli_fetch_assoc($rs_shw_up);

        //--------------------------------------------------------------------------------------------------------------
    
    
    
    
    ?>
    <div class="modal-backdrop">
        <div class="modal-dialog">
            <div class="modal-content text-light" style="background-color: #25252b; box-shadow: 0 0 30px #00ebfe;">
                <div class="modal-header" >
                    <h5 class="modal-title">View</h5>
                    <form>
                        <button  class="btn btn-close" href="test.php"></button>
                    </form>
                </div>
                
                <div class="modal-body">

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="taskName" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="taskName" name="title_up" value="<?php echo $up['title']; ?>" >
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="taskDescription" name="description_up" rows="3" ><?php echo $up['description']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="account">Category</label>
                            <select id="account" name="category_up" class="form-control">
                                <option value="<?php echo $up['category_id']; ?>"><?php echo $up['category_name']; ?></option>
                                <?php
                                //-----------------------------------------SELECT---------------------------------------------------------------
                                // ดึงข้อมูล category ของผู้ใช้ที่ login
                                $get_cate = "SELECT * FROM categories WHERE user_id = '" . $id . "'"; // จะเอาแค่ category ของคนที่ login เท่านั้น
                                $rs_get_cate = mysqli_query($conn, $get_cate);
                                //--------------------------------------------------------------------------------------------------------------

                                // วนลูปเพื่อสร้าง <option> สำหรับแต่ละ category
                                while ($row_cate = mysqli_fetch_assoc($rs_get_cate)) {
                                    // ข้ามตัวเลือกที่ตรงกับ category ที่เลือกไว้แล้ว
                                    if ($row_cate['category_id'] != $up['category_id']) {
                                        echo "<option value='{$row_cate['category_id']}'>{$row_cate['name']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="dueDate" class="form-label">Due Date</label>
                            <input type="datetime-local" class="form-control" id="dueDate" name="date_up" value="<?php echo isset($up['due_date']) ? date('Y-m-d\TH:i', strtotime($up['due_date'])) : ''; ?>">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" value="1" id="priority" name="priority_up" <?php echo (isset($up['priority_id']) && $up['priority_id'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="priority">Priority</label>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn" style="background-color: #00ebfe">Edit Task</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    <style>
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.3); /* ปรับความโปร่งใส */
}
</style>
<!------------------------------------------------------------- script ---------------------------------------------------------------------------------------------------------------->
<script>
function confirmDelete() {
    return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบหมวดหมู่นี้?');
};

</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
