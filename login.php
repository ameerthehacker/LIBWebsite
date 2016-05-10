<html>
    <head>
        <title>CSE Library</title>
        
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
        
        <!--CSS-->
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
        <link href="css/jquery.dialog.css" type="text/css" rel="stylesheet"/>
        <link href="css/login.css" type="text/css" rel="stylesheet"/>        
        
        <!--Javascript-->
        <script src="scripts/js/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/js/bootstrap.min.js" type="text/javascript"></script>                        
        <script src="scripts/js/jquery.dialog.js" type="text/javascript"></script>            
    </head>
    <body>
        <?php
        session_start();
        require_once('include/login.inc.php');
        require_once('include/core.inc.php');		
        if(isset($_SESSION['user'])){
             header('refresh:0;admin.php'); 
             exit();
        }	
        if(isset($_SESSION['libuser'])){
            header('refresh:0;user.php'); 
            exit();
        }
        if(isset($_POST['submit'])){
            $username=$_POST['username'];
            $password=$_POST['password'];
            if($username!="" and $password!=""){
                $login=new CLogin($username,$password);
                if($login->getUser()){
                    if($login->isAuthentiated()){
                        $_SESSION['user']=$login->getUser();
                        header('refresh:0;admin.php'); 
                        exit();      	
                    }
                    else{
                        popup("Sorry","$username,your password is incorrect!");
                    }
                }
                else{
                    if($login->getLibUser()){
                        if($login->isLibUser()){
                            $_SESSION['libuser']=$login->getLibUser();
                            header('refresh:0;user.php'); 
                            exit();   
                        }
                        else{
                            popup("Sorry","$username,your password is incorrect!");                            
                        }
                    }
                    else{
                        popup('Sorry','Your username is incorrect!');												                        
                    }
                }
            }
            else{
                popup('Sorry',"Username or password can't be empty!",'warning');
            }
        }
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-push-4 col-sm-4 col-xs-push-1 col-xs-10">
                    <div class="well login-box">
                        <form method="post" action="login.php">
                            <div class="form-group text-center">
                                <h4><span class="glyphicon glyphicon-user"></span> Login</h4>                                
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Usernmae"/>
                            </div><!--form-control-->
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="password"/>
                            </div><!--form-control-->
                            <div class="form-group">
                                <button class="btn btn-primary form-control" type="submit" name="submit">Submit</button>                                                              
                            </div><!--form-control-->
                        </form>
                    </div><!--well-->
                </div><!--col-xs-push-4 col-xs-4-->
            </div><!--row-->
        </div><!--container-->
    </body>
</html>