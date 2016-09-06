<html>
    <head>
        <title>Home</title>

        <!--CSS-->
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet"/>

         <!--Javascript-->
        <script src="scripts/js/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/js/bootstrap.min.js" type="text/javascript"></script>   
        <script src="scripts/js/jquery.form.js" type="text/javascript"></script>
        <script src="scripts/js/index.js" type="text/javascript"></script>
    </head>
    <body>
    	<div class="navbar">
    		<div class="container-fluid">
    			<div class="navbar-header">
    				<a class="navbar-brand">
    					CSE Library
    				</a>
    				<button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-content">
    					<span class="icon-bar"></span>
    					<span class="icon-bar"></span>
    					<span class="icon-bar"></span>
    				</button>
    			</div>
    			<div id="navbar-content" class="navbar-collapse collapse">
	    			<ul class="navbar-nav nav navbar-right">
                        <li>
                        <?php
                            session_start();

                            if(isset($_SESSION['user'])){
                                $username=$_SESSION['user']['username'];
                                $link="<a href='admin.php'>$username</a>";
                            } 
                            else if(isset($_SESSION['libuser'])){
                                $username=$_SESSION['libuser']['userid'];
                                $link="<a href='user.php'>$username</a>";
                            }
                            else{
                                $link="<a href='login.php'>Login</a>";                                
                            }
                            echo($link);                            
                        ?>
                        </li>
	    			</ul>
    			</div>
    		</div>
    	</div>
        <div class="container-fluid">
            <form id="form-books-search" class="form-horizontal" method="get" onsubmit="return false">
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                     <div class="radio-inline">
                            <label>
                                <input type="radio" name="type" value="books" checked/>
                                Books
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="type" value="journals"/>
                                Journals
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="type" value="conferences"/>
                                Author
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-search"></span>
                            </div>
                            <input id="text-keyword" type="search" name="keyword" class="form-control" placeholder="Search Library"/>
                            <span class="input-group-btn">
                                <button id="btn-books-search" type="button" class="btn btn-primary">Search</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                     <div class="radio-inline">
                            <label>
                                <input type="radio" name="category" value="id"/>
                                Access Number
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="category" value="name" checked/>
                                Name
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="category" value="author"/>
                                Author
                            </label>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
        <div class="container">
            <div  id="div-books-result">
            </div>
        </div>
    </body>
</html>