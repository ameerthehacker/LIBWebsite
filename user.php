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
        
        <title></title>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-static-top">
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
                        <li>
                            <a href="#">My Books</a>
                        </li>
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
        <div class="container">
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
            else{
                
            }
            ?>
        </div>
    </body>
</html>