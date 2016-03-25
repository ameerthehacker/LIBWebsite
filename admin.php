<?php
session_start();
if(!isset($_SESSION['user'])){
     header('refresh:0;login.php'); 
     exit();
}
 
?>
<html>
    <head>
        <title>
            Library Admin
        </title>
        
         <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
        
        <!--CSS-->
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
        <link href="css/jquery.dialog.css" type="text/css" rel="stylesheet"/>
        
        <!--Javascript-->
        <script src="scripts/js/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/js/bootstrap.min.js" type="text/javascript"></script>                        
        <script src="scripts/js/jquery.dialog.js" type="text/javascript"></script> 
        <script src="scripts/js/jquery.form.js" type="text/javascript"></script>     
        <script src="scripts/js/admin.js" type="text/javascript"></script>              
             
    </head>
    <body>
        <div class="navbar navbar-fixed-top navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-body">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="#">CSE Library</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-body">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a role="button" class="dropdown-toggle" data-toggle="dropdown">Users <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a role="button" href="#" data-toggle="modal" data-target="#modal-users-add">New User</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a role="button" class="dropdown-toggle" data-toggle="dropdown">Books <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a role="button" href="#" data-toggle="modal" data-target="#modal-books-add">New Book</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a role="button" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span>
                                <?php
                                $user=$_SESSION['user']['username'];
                                 echo($user);
                                ?>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">Change Password</a>
                                </li>
                                <li>
                                    <a href="logout.php">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!--Modals For the page-->
        <div class="modal fade" id="modal-users-add">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add User</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-users-add" class="form-horizontal" method="post" action="scripts/php/users/add.php">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Username</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="username" placeholder="Name of the user"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">User ID</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="userid" placeholder="Unique ID of the user"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Department</label>                                    
                                <div class="col-lg-10">
                                    <select class="form-control" name="dept">
                                        <option value="BIOTECH">BIOTECH</option>
                                        <option value="CIVIL">CIVIL</option>
                                        <option value="CSE">CSE</option>
                                        <option value="EEE">EEE</option>
                                        <option value="EEE">ECE</option>
                                        <option value="IT">IT</option>
                                        <option value="MECH">MECHANICAL</option>
                                        <option value="MATHS">MATHS</option>
                                        <option value="PHYSICS">PHYSICS</option>
                                        <option value="CHEMISTRY">CHEMISTRY</option>
                                        <option value="ENGLISH">ENGLISH</option>
                                        <option value="MBA">MBA</option>
                                        <option value="MCA">MCA</option>
                                        <option value="PHY-EDU">PHY-EDU</option>
                                        <option value="OTHERS">OTHERS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Category</label>                                    
                                <div class="col-lg-10">
                                    <select class="form-control" name="category">
                                        <option value="STUDENT">STUDENT</option>
                                        <option value="FACULTY">FACULTY</option>
                                        <option value="STAFF">STAFF</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-users-add" class="btn btn-success">Add</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-books-add">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Book</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-books-add" class="form-horizontal" method="post" action="scripts/php/books/add.php">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Book Name</label>
                                <div class="col-lg-10">
                                    <input type="text" name="bookname" placeholder="Name of the book" class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-2 control-label">Book ID</label>
                                <div class="col-lg-10">
                                    <input type="text" name="bookid" placeholder="Unique ID of the book" class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-2 control-label">Author</label>
                                <div class="col-lg-10">
                                    <input type="text" name="author" placeholder="Name of the author" class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-2 control-label">Publication</label>
                                <div class="col-lg-10">
                                    <input type="text" name="publication" placeholder="Name of the publisher" class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-2 control-label">Price</label>
                                <div class="col-lg-10">
                                    <input type="text" name="price" placeholder="Price of the book" class="form-control"/>
                                </div>
                            </div>
                        </form>                        
                    </div>
                    <div class="modal-footer">
                        <button id="btn-books-add" class="btn btn-success">Add</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</htm>