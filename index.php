<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1">

<title>SmartLikeRocks - Project Portal</title>
<link rel="icon" href="favicon.png" type="image/png">
<link rel="shortcut icon" href="favicon.ico" type="img/x-icon">

<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,800italic,700italic,600italic,400italic,300italic,800,700,600' rel='stylesheet' type='text/css'>

<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">
<link href="css/animate.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery.1.8.3.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/wow.js"></script>

</head>
<body>
<header class="header" id="header">
	<div class="container">
        <h1 class="animated fadeInDown delay-07s">SmartLikeRocks</h1>
        <ul class="we-create animated fadeInUp delay-1s">
        	<li>Project Portal - Browse Available Projects</li>
        </ul>
    </div>
</header>

<?php include "nav.php"; ?>

<section class="main-section paddingTop100" id="section1">
	<div class="container">
        <h2>Available Projects</h2>
        <div class="row" style="margin-top: 40px;">
            
            <!-- Pure Storage Project -->
            <div class="col-lg-6 col-sm-6 wow fadeInLeft delay-05s">
                <div class="service-list" style="border: 1px solid #ddd; padding: 30px; margin-bottom: 30px; border-radius: 5px; min-height: 280px;">
                    <div class="service-list-col1">
                        <i class="fa fa-database" style="font-size: 48px; color: #ff6700;"></i>
                    </div>
                    <div class="service-list-col2">
                        <h3 style="margin-top: 0;"><a href="pure/">Pure Storage Project</a></h3>
                        <p>Knowledge base, certification exam prep, and technical resources for Pure Storage products and solutions.</p>
                        <ul style="margin-top: 15px;">
                            <li><a href="pure/purekb.php">Knowledge Base</a></li>
                            <li><a href="pure/examprep.php">IE Certification Prep</a></li>
                        </ul>
                        <div style="margin-top: 20px;">
                            <a href="pure/" class="btn btn-primary" style="display: inline-block; padding: 10px 30px; background: #ff6700; color: white; text-decoration: none; border-radius: 3px;">Browse Project →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TSP Project -->
            <div class="col-lg-6 col-sm-6 wow fadeInRight delay-05s">
                <div class="service-list" style="border: 1px solid #ddd; padding: 30px; margin-bottom: 30px; border-radius: 5px; min-height: 280px;">
                    <div class="service-list-col1">
                        <i class="fa fa-briefcase" style="font-size: 48px; color: #0066cc;"></i>
                    </div>
                    <div class="service-list-col2">
                        <h3 style="margin-top: 0;"><a href="tsp/">TSP Project</a></h3>
                        <p>Employee resources, onboarding materials, knowledge base, and administrative tools for TSP operations.</p>
                        <ul style="margin-top: 15px;">
                            <li><a href="tsp/tspkb.php">Knowledge Base</a></li>
                            <li><a href="tsp/tspkb.php?page=newhire">New Hire Resources</a></li>
                            <li><a href="tsp/sendlostreceipt.php">Lost Receipt Form</a></li>
                        </ul>
                        <div style="margin-top: 20px;">
                            <a href="tsp/" class="btn btn-primary" style="display: inline-block; padding: 10px 30px; background: #0066cc; color: white; text-decoration: none; border-radius: 3px;">Browse Project →</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div style="margin-top: 50px; padding: 20px; background: #f5f5f5; border-radius: 5px;">
            <h3>About This Portal</h3>
            <p>This portal hosts various semi-permanent projects. Each project is organized in its own subfolder with dedicated resources and tools. Navigate to a project using the cards above or the navigation menu.</p>
        </div>
	</div>
</section>

<?php include "footer.php"; ?>

<script>
    wow = new WOW({
        animateClass: 'animated',
        offset: 100
    });
    wow.init();
</script>

</body>
</html>	