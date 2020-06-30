<?php
session_start();
if(isset($_SESSION['userid']))
{
    //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/home.php");
            exit;
}
?>
<html>
<head>
    <link href="style.css" rel="Stylesheet" type="text/css" media="screen"></link>
    <link href="designImages/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <title>Willkommen bei FLOOS</title>
    <link rel="stylesheet" href="sonstiges/css/bootstrap.css">
</head>
<body>
       <div id="root">
             <div role="navigation" class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#" class="navbar-brand">Project name</a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <form action="login.php" method="post" class="navbar-form navbar-right">
                        <div class="form-group">
                            <input type="text" name="email" style="width:100px;" value="E-Mail" onfocus="if(this.value == 'E-Mail') this.value = ''" onblur="if(this.value == '') this.value = 'E-Mail'"></input>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" style="width:100px;" value="*******" onfocus="if(this.value == '*******') this.value = ''" onblur="if(this.value == '') this.value = '*******'"></input> <input type="submit" value="Login" name="submit"></input>
                        </div>
                        <input type="submit" value="Login" name="submit"></input>
                        </form>
                    </div>
                </div>
             </div>
         </div>
         <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
         <script type="text/javascript" src="sonstiges/js/bootstrap.min.js"></script>
 </body>    
</html>