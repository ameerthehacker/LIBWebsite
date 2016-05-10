<?php
session_start();

require_once('include/connect.inc.php');

if(!isset($_SESSION['libuser'])){
    header('refresh:0;login.php');
    exit();
}

$username=$_SESSION['libuser']['userid'];

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
        
        <!--CSS-->
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
        <link href="css/jquery.dialog.css" type="text/css" rel="stylesheet"/>
        <link href="css/jquery-ui.min.css" type="text/css" rel="stylesheet"/>                
        <link href="css/user.css" type="text/css" rel="stylesheet"/>        
            
        <!--Javascript-->
        <script src="scripts/js/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/js/bootstrap.min.js" type="text/javascript"></script>                        
        <script src="scripts/js/jquery.dialog.js" type="text/javascript"></script>                        
        <script src="scripts/js/user.js" type="text/javascript"></script> 
        
        <title>My Account</title>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="#" class="navbar-brand">CSE Library</a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-body">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                </div>
                <div class="navbar-collapse collapse" id="navbar-body">
                    <ul class="navbar-nav nav pull-right">
                        <li class="dropdown">
                            <a href="#" role="button" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span>
                                <?php 
                                echo($username);
                                ?>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a role="button" href="#">Change Password</a>
                                </li>
                                <li>
                                    <a role="button" href="logout.php">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
           <ul class="nav nav-tabs">
               <li class="active"><a data-toggle="tab" href="#my-books">My Books</a></li>
               <li><a data-toggle="tab" href="#my-log">Activity Log</a></li>               
           </ul>
           <div class="tab-content">
               <div id="my-books" class="tab-pane fade in active">
                    <?php 
                    $sql="SELECT id,bookname,author,publication,price,idate,duedate FROM libbooks b INNER JOIN issues i ON b.id=i.bookid WHERE i.userid='$username'";
                    $table="<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Book ID</th>
                                    <th>Book Name</th>
                                    <th>Author</th>
                                    <th>Publication</th>
                                    <th>Price</th>
                                    <th>Issue Date</th>
                                    <th>Due Date</th>                                                                                    
                                </tr>
                            </thead>";
                    if($result=mysql_query($sql)){
                        if(mysql_num_rows($result)==0){
                            echo("<div class='alert alert-success'>You hav not taken any books</div>");
                        }
                        else{
                            
                            while($record=mysql_fetch_assoc($result)){
                                $datediff=strtotime($record['duedate'])-strtotime(date('Y-m-d'));
                                if($datediff<0){
                                    $class="bg-danger";
                                }
                                else if($datediff==0){
                                    $class="bg-warning";
                                }
                                else{
                                    $class="bg-success";
                                }
                                $table.="<tr class='$class'>
                                        <td>$record[id]</td>
                                        <td>$record[bookname]</td>
                                        <td>$record[author]</td>
                                        <td>$record[publication]</td>
                                        <td>$record[price]</td>
                                        <td>$record[idate]</td>
                                        <td>$record[duedate]</td>                            
                                    </tr>";
                            }
                            $table.="</table>";
                            echo($table);    
                        }
                    }
                    else{
                        echo("<div class='alert alert-danger'>Internal error: ".mysql_error()."</div>");                
                    }
                    ?>
               </div>
               <div id="my-log" class="tab-pane fade">
                   <?php
                   $sql="SELECT b.id,b.bookname,b.author,b.publication,b.price,l.activity,l.adate FROM LIBBOOKS B INNER JOIN ACTIVITY_LOG L ON L.BOOKID=B.ID WHERE L.USERID='$username'";
                   $list="<div class='list-group'>";
                   if($result=mysql_query($sql)){
                       while($record=mysql_fetch_assoc($result)){
                           $bookdetail="Book ID:$record[id]
                                        Author:$record[author]
                                        Publication:$record[publication]
                                        Price:$record[price]";
                           $popover="<a href='#' data-toggle='popover' title='Book Details' data-content='$bookdetail'>$record[bookname]</a>";
                           $item=$record['activity']." ".$popover." on ".$record['adate'];
                           $list.="<div class='list-group-item'>$item</div>";
                       }
                       $list.="</div>";
                       echo($list);
                   } 
                   else{
                        echo("<div class='alert alert-danger'>Internal error: ".mysql_error()."</div>");                                       
                   }
                   ?>
               </div>
           </div>
        </div>
    </body>
</html>