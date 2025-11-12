<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1">

<title>TSP Project</title>
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
    	<a href="/tsp/"><img src="../img/tsp_primary_logo.svg" alt="TSP"></a>	
    </figure>
        <h1 class="animated fadeInDown delay-07s">TSP Project</h1>
        <ul class="we-create animated fadeInUp delay-1s">
        	<li>Employee Resources & Tools</li>
        </ul>
    </div>
</header>

<?php include "../nav.php"; ?>

<section class="main-section" id="section1">
	<div class="container">
        <h2>TSP Resources</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="service-list">
                    <div class="service-list-col1">
                        <i class="fa fa-book"></i>
                    </div>
                    <div class="service-list-col2">
                        <h3><a href="tspkb.php">TSP Knowledge Base</a></h3>
                        <p>Browse TSP knowledge base articles and company information.</p>
                    </div>
                </div>
                
                <div class="service-list">
                    <div class="service-list-col1">
                        <i class="fa fa-user-plus"></i>
                    </div>
                    <div class="service-list-col2">
                        <h3><a href="tspkb.php?page=newhire">New Hire Information</a></h3>
                        <p>Resources and onboarding materials for new employees.</p>
                    </div>
                </div>

                <div class="service-list">
                    <div class="service-list-col1">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <div class="service-list-col2">
                        <h3><a href="sendlostreceipt.php">Lost Receipt Form</a></h3>
                        <p>Submit a lost receipt request.</p>
                    </div>
                </div>

                <div class="service-list">
                    <div class="service-list-col1">
                        <i class="fa fa-folder-open"></i>
                    </div>
                    <div class="service-list-col2">
                        <h3><a href="tspkb/TSP Employee Handbook.pdf" target="_blank">Employee Handbook</a></h3>
                        <p>View the TSP employee handbook (PDF).</p>
                    </div>
                </div>

                <h3 style="margin-top: 30px;">Additional Tools</h3>
                <ul style="list-style: disc; margin-left: 20px;">
                    <li><a href="resolution/">Resolution Tool</a></li>
                    <li><a href="lost-receipt/">Lost Receipt System</a></li>
                </ul>

                <h3 style="margin-top: 30px;">Other Files</h3>
                <ul style="list-style: disc; margin-left: 20px;">
                    <?php
                    $files = array_diff(scandir('.'), array('..', '.', 'index.php', 'resolution', 'lost-receipt', 'tspkb'));
                    foreach ($files as $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                            $displayName = ucwords(str_replace(['.php', 'tsp', '_', '-'], [' ', 'TSP ', ' ', ' '], $file));
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
