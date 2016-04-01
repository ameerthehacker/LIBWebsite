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
        <link href="css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"/>
        <link href="css/dataTables.bootstrap.min.css" type="text/css" rel="stylesheet"/>
        <link href="css/jquery-ui.min.css" type="text/css" rel="stylesheet"/>                
        <link href="css/admin.css" type="text/css" rel="stylesheet"/>        
            
        
        <!--Javascript-->
        <script src="scripts/js/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/js/bootstrap.min.js" type="text/javascript"></script>                        
        <script src="scripts/js/jquery.dialog.js" type="text/javascript"></script> 
        <script src="scripts/js/jquery.form.js" type="text/javascript"></script>
        <script src="scripts/js/jquery.datatables.min.js" type="text/javascript"></script>     
        <script src="scripts/js/dataTables.bootstrap.min.js" type="text/javascript"></script>    
        <script src="scripts/js/jquery-ui.min.js" type="text/javascript"></script>                                        
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
                                <li><a role="button" href="#" data-toggle="modal" data-target="#modal-books-issue">Issue Book</a></li>
                                <li><a role="button" href="#" data-toggle="modal" data-target="#modal-books-return">Return/Renew Book</a></li>                                                                                                
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
        <!--Tab Contents-->
        
        
        <div class="container-fluid">
            <div id="admin-tabs">
                <ul>
                    <li>
                        <a href="#books">Books</a>
                    </li>
                    <li>
                        <a href="#users">Users</a>
                    </li>
                </ul>
                <div id="books">
                    <form class="form-inline pull-right" onsubmit="return false">
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button id="btn-books-delete" class="btn btn-danger form-control">Delete</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button id="btn-books-selectall" class="btn btn-primary form-control">Select All</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button id="btn-books-invert" class="btn btn-primary form-control">Invert</button>
                            </div>
                        </div>
                    </form>
                    <?php 
                   
                    require_once('include/table.inc.php');
                    
                    $books=new CTable('libbooks','libbooks');
                    $sql="SELECT bookname,id,author,IFNULL(publication,'N/A'),price FROM libbooks";
                    $html=$books->drawTable(array('#','Book Name','Book ID','Author','Publisher','Price'),true,$sql);
                    echo($html);
                    ?>
                </div>
                <div id="users">
                   <form class="form-inline pull-right" onsubmit="return false">
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button id="btn-users-delete" class="btn btn-danger form-control">Delete</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button id="btn-users-selectall" class="btn btn-primary form-control">Select All</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button id="btn-users-invert" class="btn btn-primary form-control">Invert</button>
                            </div>
                        </div>
                    </form>
                    <?php 
                   
                    require_once('include/table.inc.php');
                    
                    $books=new CTable('libusers','libusers');
                    $html=$books->drawTable(array('#','Username','User ID','Department','Category'),true);
                    echo($html);
                    ?>
                </div>
            </div>            
        </div>
        
        <!--Modals For the page-->
        
        
        <!--Modal for issuing the book-->
        <div class="modal fade" id="modal-books-issue">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>                        
                        <h4 class="modal-title">Issue a Book</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-books-issue" class="form-horizontal" method="post" action="scripts/php/books/issue.php">
                            <div class="form-group">
                                <label class="control-label col-lg-2">User ID</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="userid" placeholder="Unique ID of the user" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Book ID</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="bookid" placeholder="Unique ID of the book" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-12 text-center">Date Of Issue</label>
                            </div>
                            <div class="radio">
                                <label class="control-label col-lg-2">
                                    <input type="radio" checked="true" name="issuedate" value="today"/>
                                    Today
                                </label>
                                <label class="control-label col-lg-2">
                                    <input type="radio" name="issuedate" value="other"/>
                                    Other
                                </label>
                                <div class="col-lg-8">
                                    <input type="text" id="text-books-issue-date" class="form-control" name="dateofissue" placeholder="Date of issue"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-books-issue" class="btn btn-success">Issue</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>                        
                    </div>
                </div>
            </div>
        </div>
        
        <!--Modal for editing users-->
        <div class="modal fade" id="modal-users-update">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit User</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-users-update" class="form-horizontal" method="post" action="scripts/php/users/update.php">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Username</label>
                                <div class="col-lg-10">
                                    <input type="text" id="username" class="form-control" name="username" placeholder="Name of the user"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">User ID</label>
                                <div class="col-lg-10">
                                    <input type="text" id="userid" class="form-control" name="userid" placeholder="Unique ID of the user"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Department</label>                                    
                                <div class="col-lg-10">
                                    <select id="dept" class="form-control" name="dept">
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
                                    <select id="category" class="form-control" name="category">
                                        <option value="STUDENT">STUDENT</option>
                                        <option value="FACULTY">FACULTY</option>
                                        <option value="STAFF">STAFF</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-users-update" class="btn btn-success">Update</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>                        
                    </div>
                </div>
            </div>
        </div>
        
        <!--Modal for editing books-->
        <div class="modal fade" id="modal-books-update">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Book</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-books-update" class="form-horizontal" method="post" action="scripts/php/books/update.php">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Book Name</label>
                                <div class="col-lg-10">
                                    <input id="bookname" type="text" name="bookname" placeholder="Name of the book" class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-2 control-label">Book ID</label>
                                <div class="col-lg-10">
                                    <input id="bookid" type="text" name="bookid" placeholder="Unique ID of the book" class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-2 control-label">Author</label>
                                <div class="col-lg-10">
                                    <input id="author" type="text" name="author" placeholder="Name of the author" class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-2 control-label">Publication</label>
                                <div class="col-lg-10">
                                    <input id="publication" type="text" name="publication" placeholder="Name of the publisher" class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-2 control-label">Price</label>
                                <div class="col-lg-10">
                                    <input id="price" type="text" name="price" placeholder="Price of the book" class="form-control"/>
                                </div>
                            </div>
                        </form>                        
                    </div>
                    <div class="modal-footer">
                        <button id="btn-books-update" class="btn btn-success">Update</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>                        
                    </div>
                </div>
            </div>
        </div>
        
        <!--Modal for adding users-->
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
                        <form id="form-users-csv" class="form-horizontal" method="post" action="scripts/php/users/csv.php" enctype="multipart/form-data">
                            <input id="file-users-csv" style="display:none;visiblity:hidden" type="file" name="csv"/>
                            <div class="form-group">
                                <label class="col-lg-12 text-center">Import From CSV</label>                                  
                            </div>
                            <div class="form-group">
                                <label id="label-users-csv" class="col-lg-8 control-label">Choose a file ...</label>
                                <div class="col-lg-2">
                                    <button id="btn-users-browse-csv" class="btn btn-primary form-control">Browse</button>
                                </div>
                                <div class="col-lg-2">
                                    <button id="btn-users-csv" class="btn btn-success form-control">Submit</button>
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
        
        <!--Modal for adding books-->        
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
        
        <!--Modal For returning the book-->
        <div id="modal-books-return"  class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Return Book</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-books-return" method="post"  class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Book ID</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Unique ID of the book..." name="bookid"/>
                                </div>
                            </div>                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-books-renew" class="btn btn-success">Renew</button>                        
                        <button id="btn-books-return" class="btn btn-success">Return</button>
                        <button data-dismiss="modal" class="btn btn-danger">Cancel</button>                        
                    </div>
                </div>
            <div>
        </div>
    </body>
</html>