<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1">

<title>Welcome to TSP</title>
<link rel="icon" href="../favicon.png" type="image/png">
<link rel="shortcut icon" href="../favicon.ico" type="img/x-icon">

<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,800italic,700italic,600italic,400italic,300italic,800,700,600' rel='stylesheet' type='text/css'>

<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="../css/responsive.css" rel="stylesheet" type="text/css">
<link href="../css/animate.css" rel="stylesheet" type="text/css">

<!--[if IE]><style type="text/css">.pie {behavior:url(../PIE.htc);}</style><![endif]-->

<script type="text/javascript" src="../js/jquery.1.8.3.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script type="text/javascript" src="../js/jquery-scrolltofixed.js"></script>
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/jquery.isotope.js"></script>
<script type="text/javascript" src="../js/wow.js"></script>
<script type="text/javascript" src="../js/classie.js"></script>
<script src="../contactform/contactform.js"></script>

       
</head>
<body>
<header class="header" id="header"><!--header-start-->
	<div class="container">
    	<figure class="logo animated fadeInDown delay-07s">
        	<a href="#"><img src="../img/tsp_primary_logo.svg" alt=""></a>	
        </figure>	
        <h1 class="animated fadeInDown delay-07s">Welcome to TSP</h1>
        <ul class="we-create animated fadeInUp delay-1s">
        	<li></li>
        </ul>
        <!--<a class="link animated fadeInUp delay-1s servicelink" href="#section1">Get Started</a> -->
    </div>
</header><!--header-end-->

<?php
include "../nav.php";
?>



<section class="main-section" id="section1"><!--main-section-start-->
	<div class="container">
	   <?php // new_hire_intro_welcome.php ?>
<h1 style="text-align: center; color: #2c3e50; font-size: 2.5em; margin-bottom: 25px; border-bottom: 2px solid #3498db; padding-bottom: 15px;">
    Welcome to TSP! Your Journey Starts Here
</h1>

<p style="text-align: center; font-size: 1.1em; color: #555;">
    This guide is a repository of all the little things I did not fully understand or didn’t know at all when I began working here. Don’t worry, you’ll learn it all… as you go!
</p>

<div style="background-color: #e8f6f3; padding: 20px; border-radius: 8px; margin: 30px 0; border: 1px solid #2ecc71;">
    <p style="text-align: center; font-size: 1.1em; font-weight: bold; color: #27ae60;">
        Let me say that this is a great job and I appreciate the opportunity I was given to work here. You are nearly self-employed; you will have to take care of your own needs for each job: Travel, Expenses, Communications. You are given all the resources you need to succeed like training, a team of coordinators, and lots of others doing your same job who will help you every step of the way.
    </p>
</div>
</section><!--main-section-end-->


</div>
<?php
include "../footer.php";
?>


<script type="text/javascript">
    $(document).ready(function(e) {
        $('#test').scrollToFixed();
        $('.res-nav_click').click(function(){
            $('.main-nav').slideToggle();
            return false    
            
        });
        
    });
</script>

  <script>
    wow = new WOW(
      {
        animateClass: 'animated',
        offset:       100
      }
    );
    wow.init();
  </script>


<script type="text/javascript">
	$(window).load(function(){
		
		$('.main-nav li a, .servicelink').bind('click',function(event){
			var $anchor = $(this);
			
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top - 102
			}, 1500,'easeInOutExpo');
			/*
			if you don't want to use the easing effects:
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1000);
			*/
      if ($(window).width() < 768 ) { 
        $('.main-nav').hide(); 
      }
			event.preventDefault();
		});
	})
</script>

<script type="text/javascript">

$(window).load(function(){
  
  
  var $container = $('.portfolioContainer'),
      $body = $('body'),
      colW = 375,
      columns = null;

  
  $container.isotope({
    // disable window resizing
    resizable: true,
    masonry: {
      columnWidth: colW
    }
  });
  
  $(window).smartresize(function(){
    // check if columns has changed
    var currentColumns = Math.floor( ( $body.width() -30 ) / colW );
    if ( currentColumns !== columns ) {
      // set new column count
      columns = currentColumns;
      // apply width to container manually, then trigger relayout
      $container.width( columns * colW )
        .isotope('reLayout');
    }
    
  }).smartresize(); // trigger resize to set container width
  $('.portfolioFilter a').click(function(){
        $('.portfolioFilter .current').removeClass('current');
        $(this).addClass('current');
 
        var selector = $(this).attr('data-filter');
        $container.isotope({
			
            filter: selector,
         });
         return false;
    });
  
});

</script>

</body>
</html>