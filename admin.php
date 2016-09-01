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
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="css/jquery.dialog.css" type="text/css" rel="stylesheet" />
        <link href="css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" />
        <link href="css/dataTables.bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="css/jquery-ui.min.css" type="text/css" rel="stylesheet" />
        <link href="css/admin.css" type="text/css" rel="stylesheet" />


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
        <div class="navbar">
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
                        <li><a href="index.php">Home</a></li>
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
                            <a role="button" class="dropdown-toggle" data-toggle="dropdown">Journals <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a role="button" href="#" data-toggle="modal" data-target="#modal-journals-add">New Journal</a></li>
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
                                    <a href="#" role="button" data-toggle="modal" data-target="#modal-admins-change-password">Change Password</a>
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
            <ul class="nav nav-tabs">
                <li>
                    <a href="#books" data-toggle="tab">Books</a>
                </li>
                <li>
                    <a href="#users" data-toggle="tab">Users</a>
                </li>
                <li>
                    <a href="#journals" data-toggle="tab">Journals</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="books" class="tab-pane fade in active">
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
                    $sql="SELECT bookname,id,author,IFNULL(publication,'N/A'),price,IFNULL(userid,'Available') FROM libbooks l LEFT OUTER JOIN issues i on l.id=i.bookid";
                    $html=$books->drawTable(array('#','Book Name','Book ID','Author','Publisher','Price','Status'),true,$sql);
                    echo($html);
                    ?>
                </div>
                <div id="users" class="tab-pane fade in">
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
                <div id="journals" class='tab-pane fade in'>
                    <form class="form-inline pull-right" onsubmit="return false">
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button id="btn-journals-delete" class="btn btn-danger form-control">Delete</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button id="btn-journals-selectall" class="btn btn-primary form-control">Select All</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button id="btn-journals-invert" class="btn btn-primary form-control">Invert</button>
                            </div>
                        </div>
                    </form>
                    <?php
                    require_once('include/connect.inc.php');
                    $tableHeader="<table id='libjournals' class='table table-stripped table-hover'>
                                    <thead>
                                         <th>#</th>
                                         <th>Name</th>
                                         <th>Title</th>
                                         <th>Authors</th>
                                         <th>Month</th>
                                         <th>Acadamic Year</th>
                                         <th>Issue</th>
                                         <th>Volume</th>
                                         <th>Impact Factor</th>                                                             
                                         <th>PDF</th>
                                    </thead>";
                    $tableFooter="<tfoot>
                                    <th>#</th>                                  
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Authors</th>
                                    <th>Month</th> 
                                    <th>Acadamic Year</th>
                                    <th>Issue</th>
                                    <th>Volume</th>                                    
                                    <th>Impact Factor</th>                                    
                                    <th>PDF</th>
                                  </tfoot>
                                </table>";

                    $tableBody="<tbody>";
                    $sql="SELECT * FROM libjournals";
                    if($result=mysql_query($sql)){
                        while($journal=mysql_fetch_assoc($result)){
                            $journalAuthors=[];
                            $sql="SELECT u.username FROM journal_authors j JOIN libusers u ON j.userid=u.id AND j.journalid='$journal[id]'";
                            if($author_result=mysql_query($sql)){
                                while($author=mysql_fetch_assoc($author_result)){
                                    array_push($journalAuthors,$author['username']);
                                }
                                $journalAuthors=implode(",",$journalAuthors);
                            }
                            $pdfButton="<div class='input-group'>
                                            <div class='input-group-btn'>
                                                <a href='scripts/php/journals/pdf/$journal[id].pdf' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-eye-open'></span></a>
                                                <a href='#' class='btn btn-warning'><span class='glyphicon glyphicon-pencil'></span></a>                                        
                                            </div>
                                        </div>";
                            $tableBody.="<tr field-id='$journal[id]' class='libjournals-row'>
                                            <td><input type='checkbox' class='libjournals-checkbox' field-id='$journal[id]'/></td>
                                            <td class='field'>$journal[journalname]</td>
                                            <td class='field'>$journal[journaltitle]</td>
                                            <td class='field'>$journalAuthors</td>
                                            <td class='field'>$journal[month]</td>
                                            <td class='field'>$journal[year_from]-$journal[year_to]</td>
                                            <td class='field'>$journal[issue]</td>
                                            <td class='field'>$journal[volume]</td>
                                            <td class='field'>$journal[impactfactor]</td>
                                            <td class='field'>$pdfButton</td>
                                         </tr>";
                        }
                        $tableBody.="</tbody>";
                    }
                    echo($tableHeader.$tableBody.$tableFooter);
                    ?>
                </div>
            </div>
        </div>

        <!--Modals For the page-->

        <!--Modal For adding journal-->

        <div class="modal fade" id="modal-journals-add">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4>Add a Journal</h4>
                    </div>
                    <div class="modal-body">
                        <form action="scripts/php/journals/add.php" method="post" class="form-horizontal" id="form-journals-add" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Journal Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="journalname" placeholder="Name of the jounral" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Journal Title</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="journaltitle" placeholder="Title of the jounral" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Journal Authors</label>
                                <div class="col-lg-9">
                                    <input id="text-journals-authors" type="text" name="authors" class="form-control" placeholder="ID of the authors" />
                                </div>
                            </div>
                            <div class="form-group" id="suggest-journals-authors" style="visibility:hidden;display:none">
                                <div class="col-lg-12 text-center">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Journal Month</label>
                                <div class="col-lg-9">
                                    <select name="month" class="form-control">
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>                                                                                
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Acadamic Year</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="year_from" placeholder="From Year" />
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="year_to" placeholder="To Year" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Volume</label>
                                <div class="col-lg-9">
                                    <input  type="text" class="form-control" name="volume" placeholder="Volume of the jounral" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Issue</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="issue" placeholder="Issue of the jounral" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Impact Factor</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="impactfactor" placeholder="Impact Factor of the jounral" />
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="file" name="pdf" style="visibility:hidden;display:none" id="file-journals-pdf">
                                <label class="control-label col-lg-3">PDF File</label>
                                <label id="label-journals-pdf" class="control-label col-lg-7">Browse File...</label>
                                <div class="col-lg-2">
                                    <button class="btn btn-primary form-control" id="btn-journals-pdf">browse</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-journals-add" class="btn btn-success">Add</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal For editing journal-->

        <div class="modal fade" id="modal-journals-update">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4>Edit Journal</h4>
                    </div>
                    <div class="modal-body">
                        <form action="scripts/php/journals/update.php" method="post" class="form-horizontal" id="form-journals-update" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Journal Name</label>
                                <div class="col-lg-9">
                                    <input id="journalname" type="text" class="form-control" name="journalname" placeholder="Name of the jounral" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Journal Title</label>
                                <div class="col-lg-9">
                                    <input id="journaltitle" type="text" class="form-control" name="journaltitle" placeholder="Title of the jounral" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Journal Authors</label>
                                <div class="col-lg-9">
                                    <input id="journalauthors" type="text" name="authors" class="form-control" placeholder="ID of the authors" />
                                </div>
                            </div>

                            <div class="form-group" id="suggest-journals-authors-for-update" style="visibility:hidden;display:none">
                                <div class="col-lg-12 text-center">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Journal Month</label>
                                <div class="col-lg-9">
                                    <select id="journalmonth" name="month" class="form-control">
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>                                                                                
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Acadamic Year</label>
                                <div class="col-lg-4">
                                    <input id="journalyearfrom" type="text" class="form-control" name="year_from" placeholder="From Year" />
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" id="journalyearto" class="form-control" name="year_to" placeholder="To Year" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Volume</label>
                                <div class="col-lg-9">
                                    <input id="journalvolume" type="text" class="form-control" name="volume" placeholder="Volume of the jounral" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Issue</label>
                                <div class="col-lg-9">
                                    <input id="journalissue" type="text" class="form-control" name="issue" placeholder="Issue of the jounral" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-lg-3">Impact Factor</label>
                                <div class="col-lg-9">
                                    <input id="journalimpact" type="text" class="form-control" name="impactfactor" placeholder="Impact Factor of the jounral"
                                    />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-journals-update" class="btn btn-success">Update</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal for changing the admin password-->

        <div class="modal fade" id="modal-admins-change-password">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change Password</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-admins-change-password" class="form-horizontal" method="post" action="scripts/php/users/changepassword.php">
                            <div class="form-group">
                                <label class="control-label col-lg-4">Old Password</label>
                                <div class="col-lg-8">
                                    <input placeholder="Type old password" type="password" class="form-control" name="oldpassword" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4">New Password</label>
                                <div class="col-lg-8">
                                    <input placeholder="Type new password" type="password" class="form-control" name="newpassword" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4">Retype New Password</label>
                                <div class="col-lg-8">
                                    <input placeholder="Retype new password" type="password" class="form-control" name="retypepassword" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-admins-change-password" class="btn btn-success">Change</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>



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
                                    <input id="text-users-issue-id" type="text" class="form-control" name="userid" placeholder="Unique ID of the user" />
                                </div>
                            </div>
                            <div id="div-users-details" class="form-group" style="display:none;visibility:hidden;">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td id="d-username"></td>
                                            <td id="d-userid"></td>
                                            <td id="d-department"></td>
                                            <td id="d-category"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Book ID</label>
                                <div class="col-lg-10">
                                    <input type="text" id="text-books-issue-id" class="form-control" name="bookid" placeholder="Unique ID of the book" />
                                </div>
                            </div>
                            <!--div for book details-->
                            <div id="div-books-details" class="form-group" style="display:none;visibility:hidden;">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <tr id="row-books-details">
                                            <td id="d-bookname"></td>
                                            <td id="d-author"></td>
                                            <td id="d-publication"></td>
                                            <td id="d-price"></td>
                                            <td id="d-status"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-12 text-center">Date Of Issue</label>
                            </div>
                            <div class="radio">
                                <label class="control-label col-lg-2">
                                    <input type="radio" checked="true" name="issuedate" value="today"  readonly/>
                                    Today
                                </label>
                                <label class="control-label col-lg-2">
                                    <input type="radio" name="issuedate" value="other"/>
                                    Other
                                </label>
                                <div class="col-lg-8">
                                    <input type="text" id="text-books-issue-date" class="form-control" name="dateofissue" placeholder="Date of issue" />
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
                                    <input type="text" id="username" class="form-control" name="username" placeholder="Name of the user" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">User ID</label>
                                <div class="col-lg-10">
                                    <input type="text" id="userid" class="form-control" name="userid" placeholder="Unique ID of the user" />
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
                                    <input id="bookname" type="text" name="bookname" placeholder="Name of the book" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Book ID</label>
                                <div class="col-lg-10">
                                    <input id="bookid" type="text" name="bookid" placeholder="Unique ID of the book" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Author</label>
                                <div class="col-lg-10">
                                    <input id="author" type="text" name="author" placeholder="Name of the author" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Publication</label>
                                <div class="col-lg-10">
                                    <input id="publication" type="text" name="publication" placeholder="Name of the publisher" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Price</label>
                                <div class="col-lg-10">
                                    <input id="price" type="text" name="price" placeholder="Price of the book" class="form-control" />
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
                                    <input type="text" class="form-control" name="username" placeholder="Name of the user" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">User ID</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="userid" placeholder="Unique ID of the user" />
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
                            <input id="file-users-csv" style="display:none;visiblity:hidden" type="file" name="csv" />
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
                                    <input type="text" name="bookname" placeholder="Name of the book" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Book ID</label>
                                <div class="col-lg-10">
                                    <input type="text" name="bookid" placeholder="Unique ID of the book" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Author</label>
                                <div class="col-lg-10">
                                    <input type="text" name="author" placeholder="Name of the author" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Publication</label>
                                <div class="col-lg-10">
                                    <input type="text" name="publication" placeholder="Name of the publisher" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Price</label>
                                <div class="col-lg-10">
                                    <input type="text" name="price" placeholder="Price of the book" class="form-control" />
                                </div>
                            </div>
                        </form>
                        <form id="form-books-csv" class="form-horizontal" method="post" action="scripts/php/books/csv.php" enctype="multipart/form-data">
                            <input id="file-books-csv" style="display:none;visiblity:hidden" type="file" name="csv" />
                            <div class="form-group">
                                <label class="col-lg-12 text-center">Import From CSV</label>
                            </div>
                            <div class="form-group">
                                <label id="label-books-csv" class="col-lg-8 control-label">Choose a file ...</label>
                                <div class="col-lg-2">
                                    <button id="btn-books-browse-csv" class="btn btn-primary form-control">Browse</button>
                                </div>
                                <div class="col-lg-2">
                                    <button id="btn-books-csv" class="btn btn-success form-control">Submit</button>
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
        <div id="modal-books-return" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Return Book</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-books-return" method="post" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Book ID</label>
                                <div class="col-lg-10">
                                    <input id="text-books-return-id" class="form-control" type="text" placeholder="Unique ID of the book..." name="bookid" />
                                </div>
                            </div>
                            <div id="div-return-details" class="form-group" style="display:none;visibility:hidden;">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td id="r-bookname"></td>
                                            <td id="r-author"></td>
                                            <td id="r-publication"></td>
                                            <td id="r-price"></td>
                                        </tr>
                                        <tr>
                                            <td id="r-userid"></td>
                                            <td id="r-username"></td>
                                            <td id="r-department"></td>
                                            <td id="r-category"></td>
                                        </tr>
                                    </table>
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