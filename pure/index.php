<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1">

<title>Pure Storage Project</title>
<link rel="icon" href="../favicon.png" type="image/png">
<link rel="shortcut icon" href="../favicon.ico" type="img/x-icon">

<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,800italic,700italic,600italic,400italic,300italic,800,700,600' rel='stylesheet' type='text/css'>

<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="../css/responsive.css" rel="stylesheet" type="text/css">
<link href="../css/animate.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../js/jquery.1.8.3.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
</head>
<body>
<header class="header" id="header">
	<div class="container">
    	<figure class="logo animated fadeInDown delay-07s">
        	<a href="pure.php"><img src="../img/purelogo-tr.png" alt="Pure Storage"></a>	
        </figure>	
        <h1 class="animated fadeInDown delay-07s">Pure Storage Project</h1>
        <ul class="we-create animated fadeInUp delay-1s">
        	<li>Knowledge Base & Certification Resources</li>
        </ul>
    </div>
</header>

<?php include "../nav.php"; ?>

<section class="main-section" id="section1">
	<div class="container">
        <h2>Pure Storage Resources</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="service-list">
                    <div class="service-list-col1">
                        <i class="fa fa-book"></i>
                    </div>
                    <div class="service-list-col2">
                        <h3><a href="purekb.php">Pure Knowledge Base</a></h3>
                        <p>Browse the Pure Storage knowledge base articles and technical documentation.</p>
                    </div>
                </div>
                
                <div class="service-list">
                    <div class="service-list-col1">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <div class="service-list-col2">
                        <h3><a href="examprep.php">IE Certification Exam Prep</a></h3>
                        <p>Practice questions and study materials for the Pure Storage Implementation Engineer certification exam.</p>
                    </div>
                </div>

                <h3 style="margin-top: 30px;">Additional Resources</h3>
                <ul style="list-style: disc; margin-left: 20px;">
                    <?php
                    $files = array_diff(scandir('.'), array('..', '.', 'index.php'));
                    foreach ($files as $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                            $displayName = ucwords(str_replace(['.php', 'pure', '_', '-'], [' ', 'Pure ', ' ', ' '], $file));
                            echo "<li><a href='$file'>$displayName</a></li>\n";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
	</div>
</section>

<?php include "../footer.php"; ?>

</body>
</html>
