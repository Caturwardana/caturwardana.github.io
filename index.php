<?php

	if(empty($_POST) === false) {

		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];

		if(empty($name) === true || empty($email) === true || empty($message) === true) {
			$errors[] = 'Name, email and message are required!';
		} else {
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$errors[] = 'That\'s not a valid email address!';
			}
			if(ctype_alpha($name) === false) {
				$errors[] = 'Name must only contain letters!';
			}
		}

	}

	/* ###################### */

	ini_set('display_errors', 1);

	/* ###################### */

		function base64url_encode($plainText) {
			$base64 = base64_encode($plainText);
			$base64url = strtr($base64, '+/=', '-_,');
			return $base64url;
		}

		function base64url_decode($plainText) {
			$base64url = strtr($plainText, '-_,', '+/=');
			$base64 = base64_decode($base64url);
			return $base64;
		}

		/* ###################### */

				function getRealIPAddr()
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
			{
				$ip=$_SERVER['HTTP_CLIENT_IP'];
			}
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
			{
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
				$ip=$_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}

		/* ###################### */

		function sanitize_output($buffer) {

    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // Remove HTML comments
    );

    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
	}

	ob_start("sanitize_output");

	/* ###################### */

	function cleanInput($input) {

	  $search = array(
	    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
	    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
	    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
	    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	  );

	    $output = preg_replace($search, '', $input);
	    return $output;
	  }

	function sanitize($input) {
	    if (is_array($input)) {
	        foreach($input as $var=>$val) {
	            $output[$var] = sanitize($val);
	        }
	    }
	    else {
	        if (get_magic_quotes_gpc()) {
	            $input = stripslashes($input);
	        }
	        $input  = cleanInput($input);
	        $output = mysql_real_escape_string($input);
	    }
	    return $output;
	}

	/* ###################### */

		function clean($input){

		if (is_array($input)){

			foreach ($input as $key => $val){

				$output[$key] = clean($val);

				// $output[$key] = $this->clean($val);

			}

		}else{

			$output = (string) $input;

			// if magic quotes is on then use strip slashes

			if (get_magic_quotes_gpc()){

				$output = stripslashes($output);

			}

			// $output = strip_tags($output);

			$output = htmlentities($output, ENT_QUOTES, 'UTF-8');

		}

	// return the clean text

		return $output;

	}

	/* ###################### WHO IS */

	function whois_query($domain) {

    // fix the domain name:
    $domain = strtolower(trim($domain));
    $domain = preg_replace('/^http:\/\//i', '', $domain);
    $domain = preg_replace('/^www\./i', '', $domain);
    $domain = explode('/', $domain);
    $domain = trim($domain[0]);

    // split the TLD from domain name
    $_domain = explode('.', $domain);
    $lst = count($_domain)-1;
    $ext = $_domain[$lst];

    // You find resources and lists
    // like these on wikipedia:
    //
    // http://de.wikipedia.org/wiki/Whois
    //
    $servers = array(
        "biz" => "whois.neulevel.biz",
        "com" => "whois.internic.net",
        "us" => "whois.nic.us",
        "coop" => "whois.nic.coop",
        "info" => "whois.nic.info",
        "name" => "whois.nic.name",
        "net" => "whois.internic.net",
        "gov" => "whois.nic.gov",
        "edu" => "whois.internic.net",
        "mil" => "rs.internic.net",
        "int" => "whois.iana.org",
        "ac" => "whois.nic.ac",
        "ae" => "whois.uaenic.ae",
        "at" => "whois.ripe.net",
        "au" => "whois.aunic.net",
        "be" => "whois.dns.be",
        "bg" => "whois.ripe.net",
        "br" => "whois.registro.br",
        "bz" => "whois.belizenic.bz",
        "ca" => "whois.cira.ca",
        "cc" => "whois.nic.cc",
        "ch" => "whois.nic.ch",
        "cl" => "whois.nic.cl",
        "cn" => "whois.cnnic.net.cn",
        "cz" => "whois.nic.cz",
        "de" => "whois.nic.de",
        "fr" => "whois.nic.fr",
        "hu" => "whois.nic.hu",
        "ie" => "whois.domainregistry.ie",
        "il" => "whois.isoc.org.il",
        "in" => "whois.ncst.ernet.in",
        "ir" => "whois.nic.ir",
        "mc" => "whois.ripe.net",
        "to" => "whois.tonic.to",
        "tv" => "whois.tv",
        "ru" => "whois.ripn.net",
        "org" => "whois.pir.org",
        "aero" => "whois.information.aero",
        "nl" => "whois.domain-registry.nl"
    );

    if (!isset($servers[$ext])){
        die('Error: No matching nic server found!');
    }

    $nic_server = $servers[$ext];

    $output = '';

    // connect to whois server:
    if ($conn = fsockopen ($nic_server, 43)) {
        fputs($conn, $domain."\r\n");
        while(!feof($conn)) {
            $output .= fgets($conn,128);
        }
        fclose($conn);
    }
    else { die('Error: Could not connect to ' . $nic_server . '!'); }

    return $output;
}

 ?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Reynaldo &mdash; Web Developer</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<meta name=description content="Reynaldo is a web developer and programmer from Indonesia">
	<meta name=keywords content="HTML, CSS, javascript, PHP, Portfolio, Personal Website, Developer, Developer Indonesia, Web developer, Reynaldodev. Website">
	<meta name=author content="Reynaldo Pratama" />
	<meta name=”geo.position” content=”latitude; longitude“>
	<meta name=”geo.placename” content=”Place Name“>
	<meta name=”geo.region” content=”Country Subdivision Code“>
	<meta http-equiv=Cache-control content=public>
	<meta http-equiv=Cache-control content=private>
	<meta http-equiv=Cache-control content=no-cache>
	<meta http-equiv=Cache-control content=no-store>
	<link media="print" rel="shortcut icon" href=images/ava2.png>

	<!-- <link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,600,400italic,700' rel='stylesheet' type='text/css'> -->

	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="css/stttyllee.css">
  <link rel="stylesheet" href="css/styylee.css">
	<link rel="stylesheet" href="css/componentt.css">

  <link rel="stylesheet" href="css/nivo-lightbox.css">
  <link rel="stylesheet" href="css/nivo_themes/default/default.css">

	<link rel="stylesheet" href="css/vegas.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.8.0/css/flag-icon.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript">

	</script>

	</head>
	<body id="top" data-spy="scroll" data-offset="50" data-target=".navbar-collapse">
		<div class="preloader">
		     <div class="sk-spinner sk-spinner-pulse"></div>
		</div>

<!-- Navigation section  -->

  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">

      <div class="navbar-header">
        <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon icon-bar"></span>
          <span class="icon icon-bar"></span>
          <span class="icon icon-bar"></span>
        </button>
        <a href="#top" class="navbar-brand smoothScroll">Reynaldo</a>
      </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#top" class="smoothScroll"><span>Home</span></a></li>
            <li><a href="#about" class="smoothScroll"><span>About</span></a></li>
            <li><a href="#portfolio" class="smoothScroll"><span>Portfolio</span></a></li>
						<li><a href="#gtco-services" class="smoothScroll"><span>Services</span></a></li>
            <li><a href="#contact" class="smoothScroll"><span>Contact</span></a></li>
          </ul>
       </div>

    </div>
  </div>


<section id="home">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">

      <div class="col-md-offset-1 col-md-10 col-sm-12 wow fadeInUp" data-wow-delay="0.3s">
        <h1 class="wow fadeInUp" data-wow-delay="0.6s">HELLO. MY NAME IS REYNALDO</h1>
        <p class="wow fadeInUp" data-wow-delay="0.9s">I'm a 17 years old <b style="color: #73e2cc">Web Developer</b> living in Indonesia</p>
				<p class="wow fadeInUp" data-wow-delay="0.9s">I create profesional and modern webiste</p>
				<!--<button onclick="toggleFullScreen()" ontouchstart="toggleFullScreen()">Toggle Full Screen</button>-->
      </div>

    </div>
  </div>
</section>

<!-- About section -->

<section id="about">
  <div class="container">
    <div class="row">

      <div class="col-md-9 col-sm-8 wow fadeInUp">
        <div class="about-thumb">
          <h1>About Me</h1>
          <p>Hello my name is Reynaldo, i'm 17 years old and i'm a web developer also web designer from Indonesia. I have almost 3 years experience in developing and coding for any apps for a worldwide clients. I have developing website
						for small business, website for community, small e-commerce, a blog, and even you can just talk
						about your problem business, so i can give the advice for find the solution.
					</p>
					<section class=buttons>
						<div class=container-cv>
						<a href=https://resume.com/share/nhft9wagrpzqif8k4 class="btn-cv btn-1">
						<svg>
						<rect x=0 y=0 fill=none width=100% height=100% /> </svg> Resume </a>
					</div>
				</section>
			</div>
    </div>

      <div class="col-md-3 col-sm-4 wow fadeInUp about-img" data-wow-delay="0.6s">
        <img src="images/saya.jpg" class="img-responsive img-circle" alt="About">
      </div>

      <div class="clearfix"></div>

</section>

	<div id="gtco-features-2">
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2>Why Choose Me</h2>
					<p>
						This is some reasons why should choose me, i'm the one Web Developer in town
						who have any services in below so, don't waste your time think about me
						just choose me and contact me.
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="feature-left animate-box" data-animate-effect="fadeInLeft">
						<span class="icon">
							<i class="icon-time-slot"></i>
						</span>
						<div class="feature-copy">
							<h3>Fast Response</h3>
							<p>I'm ready 24 hours for any problem you have, and i'll help you. You can ask for my services, benfits and etc.</p>
						</div>
					</div>

					<div class="feature-left animate-box" data-animate-effect="fadeInLeft">
						<span class="icon">
							<i class="icon-check"></i>
						</span>
						<div class="feature-copy">
							<h3>Fully Services</h3>
							<p>My prices are included my services, so if you agreed with me, you'll got my services all time without more fee.</p>
						</div>
					</div>

					<div class="feature-left animate-box" data-animate-effect="fadeInLeft">
						<span class="icon">
							<i class="icon-paper"></i>
						</span>
						<div class="feature-copy">
							<h3>Good Quality</h3>
							<p>I design and develop website with my best skills, so quality is number one for me and dont worried to get bad websites.</p>
						</div>
					</div>

				</div>

					<div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-delay="0.6s">
						<img src="images/about-img.png" class="img-responsive" alt="about img">
					</div>
			</div>
		</div>
	</div>

	<!-- Sections -->
	<section id="our-skills" class=" skills skill-bg">
			<div class="overlay-img">
					<div class="container sections text-center">
							<div class="skill-heading">

									<h2 class="custom-font">MY SKILLS</h2>

							</div>
							<!-- Example row of columns -->
							<div class="row">
											<div class="col-sm-3 text-center">
					<div class="main-skill">
						<div class="chart-round">
							<div class="chart" data-percent="95">
								<span class="percent"></span>
							</div>
						</div>
						<div class="skills-text">HTML5</div>
					</div>
											</div>

											<div class="col-sm-3 text-center">
					<div class="main-skill">
						<div class="chart-round">
							<div class="chart" data-percent="92">
								<span class="percent"></span>
							</div>
						</div>
						<div class="skills-text">CSS</div>
					</div>
											</div>

											<div class="col-sm-3 text-center">
					<div class="main-skill">
						<div class="chart-round">
							<div class="chart" data-percent="88">
								<span class="percent"></span>
							</div>
						</div>
						<div class="skills-text">Javascript</div>
					</div>
											</div>

											<div class="col-sm-3 text-center">
					<div class="main-skill">
						<div class="chart-round">
							<div class="chart" data-percent="84">
								<span class="percent"></span>
							</div>
						</div>
						<div class="skills-text">PHP</div>
					</div>
											</div>

											<div class="col-sm-3 text-center">
						<div class="main-skill">
						<div class="chart-round">
							<div class="chart" data-percent="80">
								<span class="percent"></span>
							</div>
						</div>
						<div class="skills-text">mySql</div>
						</div>
											</div>

											<div class="col-sm-3 text-center">
					<div class="main-skill">
						<div class="chart-round">
							<div class="chart" data-percent="78">
								<span class="percent"></span>
							</div>
						</div>
						<div class="skills-text">CMS</div>
					</div>
											</div>

											<div class="col-sm-3 text-center">
						<div class="main-skill">
						<div class="chart-round">
							<div class="chart" data-percent="72">
								<span class="percent"></span>
							</div>
						</div>
						<div class="skills-text">eCommerce</div>
						</div>
											</div>

											<div class="col-sm-3 text-center">
					<div class="main-skill">
						<div class="chart-round">
							<div class="chart" data-percent="68">
								<span class="percent"></span>
							</div>
						</div>
						<div class="skills-text">SEO</div>
					</div>
											</div>

									</div>

					</div>
			</div> <!-- /container -->
	</div>
</section>

  <!-- portfolio section -->
  <div id="portfolio">
  	<div class="container">
  		<div class="row">
  			<div class="col-md-12 col-sm-12 animate-box">
  				<h1 class="heading bold">PORTFOLIO</h1>
  				<h2 class="subheading">BEAUTY, MODERN &amp; MINIMALIST</h2>
  				<!-- ISO section -->
  				<div class="iso-section">
  					<ul class="filter-wrapper clearfix">
                     		 <li><a href="#" data-filter="*" class="selected opc-main-bg">All</a></li>
                     		 <li><a href="#" class="opc-main-bg" data-filter=".personal">Personal</a></li>
                     		 <li><a href="#" class="opc-main-bg" data-filter=".food">Food &amp; Beverages</a></li>
                      	 <li><a href="#" class="opc-main-bg" data-filter=".blog">Blog</a></li>
                      	 <li><a href="#" class="opc-main-bg" data-filter=".commerce">e&mdash;Commerce</a></li>
                 		</ul>
                 		<div class="iso-box-section wow fadeIn" data-wow-delay="0.9s">
                 			<div class="iso-box-wrapper col4-iso-box">


												<div class="iso-box personal blog mobile col-lg-4 col-md-4 col-sm-6 col-xs-12 animate-box" data-animate-effect="fadeInLeft">
													<ul class="grid cs-style-4">
														<li>
															<figure>
																<div data-lightbox-gallery="portfolio-gallery"><img src="images/portfolio-1.png" alt="image 1"></div>
																<figcaption>
																	<h1>ScitusSquad Website</h1>
																	<small>It is one of community website from the best School in town.</small>
																</figcaption>
															</figure>
														</li>
												</div>


											<div class="iso-box personal blog col-lg-4 col-md-4 col-sm-6 col-xs-12 animate-box" data-animate-effect="fadeInTop">
												<ul class="grid cs-style-4">
													<li>
														<figure>
															<div data-lightbox-gallery="portfolio-gallery"><img src="images/portfolio-2.png" alt="image 1"></div>
															<figcaption>
																<h1>Anak Teknik</h1>
																<small>This is the one of Engineer Blog in Indonesia.</small>
															</figcaption>
														</figure>
													</li>
											</div>

                 				 <div class="iso-box commerce col-lg-4 col-md-4 col-sm-6 col-xs-12">
													 <ul class="grid cs-style-4">
 													 <li>
 														 <figure>
 															 <div data-lightbox-gallery="portfolio-gallery"><img src="images/portfolio-3.png" alt="image 1"></div>
 															 <figcaption>
 																 <h1>Sport Center</h1>
 																 <small>It's actually not hosted, because this site i made it for my education and my exercises.</small>
 															 </figcaption>
 														 </figure>
 													 </li>
												 </div>


                 				 <div class="iso-box commerce col-lg-4 col-md-4 col-sm-6 col-xs-12 animate-box" data-animate-effect="fadeInRight">
													 <ul class="grid cs-style-4">
 													 <li>
 														 <figure>
 															 <div data-lightbox-gallery="portfolio-gallery"><img src="images/portfolio-4.png" alt="image 1"></div>
 															 <figcaption>
 																 <h1>Radja Bangunan</h1>
 																 <small>One of hardware store in town which have own online store.</small>
 															 </figcaption>
 														 </figure>
 													 </li>
												 </div>


                 				 <div class="iso-box commerce col-lg-4 col-md-4 col-sm-6 col-xs-12">
													 <ul class="grid cs-style-4">
 													 <li>
 														 <figure>
 															 <div data-lightbox-gallery="portfolio-gallery"><img src="images/portfolio-5.png" alt="image 1"></div>
 															 <figcaption>
 																 <h1>ESC-Hardware</h1>
 																 <small>Also this site its not hosted becasue its my education necessary for improve my skill about e-commerce.</small>
 															 </figcaption>
 														 </figure>
 													 </li>
												 </div>

                 				 <div class="iso-box food col-lg-4 col-md-4 col-sm-6 col-xs-12">
													 <ul class="grid cs-style-4">
 													 <li>
 														 <figure>
 															 <div data-lightbox-gallery="portfolio-gallery"><img src="images/portfolio-6.png" alt="image 1"></div>
 															 <figcaption>
 																 <h1>Dearte Cafe</h1>
 																 <small>Dearte cafe is the best cafe in town, they have fresh coffee and any foods.</small>
 															 </figcaption>
 														 </figure>
 													 </li>
												 </div>

												 <div class="iso-box food col-lg-4 col-md-4 col-sm-6 col-xs-12">
													 <ul class="grid cs-style-4">
 													 <li>
 														 <figure>
 															 <div data-lightbox-gallery="portfolio-gallery"><img src="images/portfolio-7.png" alt="image 1"></div>
 															 <figcaption>
 																 <h1>Delotuz Kitchen</h1>
 																 <small>It is the best restaurant in town, they have comfy place with good design and good foods.</small>
 															 </figcaption>
 														 </figure>
 													 </li>
												 </div>

												 <div class="iso-box food commerce personal blog col-lg-4 col-md-4 col-sm-6 col-xs-12">
													 <ul class="grid cs-style-4">
 													 <li>
 														 <figure>
 															 <div data-lightbox-gallery="portfolio-gallery"><img src="images/404-page.jpg" alt="image 1"></div>
 															 <figcaption>
 																 <h1>BLANK</h1>
 																 <small>Make this field a lot of project that i have, please help me to fill this blank. And lets make something awesome with me.</small>
 															 </figcaption>
 														 </figure>
 													 </li>
												 </div>

                 			</div>
                 		</div>

  				</div>
  			</div>
  		</div>
  	</div>
  </div>

	<div id="gtco-counter" class="gtco-bg gtco-counter">
		<div class="gtco-container">
			<div class="row">
				<div class="display-t">
					<div class="display-tc">
						<div class="col-md-3 col-sm-6 animate-box">
							<div class="feature-center">
								<span class="icon">
									<i class="icon-eye"></i>
								</span>

								<span class="counter js-counter" data-from="0" data-to="12050" data-speed="5000" data-refresh-interval="50">1</span>
								<span class="counter-label">Creativity Fuel</span>

							</div>
						</div>
						<div class="col-md-3 col-sm-6 animate-box">
							<div class="feature-center">
								<span class="icon">
									<i class="icon-anchor"></i>
								</span>

								<span class="counter js-counter" data-from="0" data-to="12" data-speed="5000" data-refresh-interval="50">1</span>
								<span class="counter-label">Happy Clients</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 animate-box">
							<div class="feature-center">
								<span class="icon">
									<i class="icon-briefcase"></i>
								</span>
								<span class="counter js-counter" data-from="0" data-to="120" data-speed="5000" data-refresh-interval="50">1</span>
								<span class="counter-label">Projects Done</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 animate-box">
							<div class="feature-center">
								<span class="icon">
									<i class="icon-clock"></i>
								</span>

								<span class="counter js-counter" data-from="0" data-to="121012" data-speed="5000" data-refresh-interval="50">1</span>
								<span class="counter-label">Hours Spent</span>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="gtco-testimonial">
		<div class="gtco-container">
			<!-- <div class="row"> -->
				<div class="row animate-box">
				</div>
				<div class="row animate-box">


					<div class="owl-carousel owl-carousel-fullwidth ">
						<div class="item">
							<div class="testimony-slide active text-center">
								<figure>
								</figure>
								<span>Nicholas Negroponte</span>
								<blockquote>
									<p>&ldquo;Computing is not about computers anymore. It is about living.&ldquo;</p>
									</blockquote>
							</div>
						</div>
						<div class="item">
							<div class="testimony-slide active text-center">
								<figure>
								</figure>
								<span>Damola Mabogunje</span>
								<blockquote>
									<p>&ldquo;PROGRAMMING is like writting an essay, in the language of logic.&ldquo;</p>
									</blockquote>
							</div>
						</div>
						<div class="item">
							<div class="testimony-slide active text-center">
								<figure>
								</figure>
								<span>Albert Einstein</span>
								<blockquote>
									<p>&ldquo;Try not to become a man of success, but rather try to become a man of value.&ldquo;</p>
								</blockquote>
							</div>
						</div>
						<div class="item">
							<div class="testimony-slide active text-center">
								<figure>
								</figure>
								<span>John Romero</span>
								<blockquote>
									<p>&ldquo;You might not think that programmers are artist, but programming is
										an extremely creative profession.It'slogic based creativity.&ldquo;</p>
								</blockquote>
							</div>
						</div>
						<div class="item">
							<div class="testimony-slide active text-center">
								<figure>
								</figure>
								<span>Steve Jobs</span>
								<blockquote>
									<p>&ldquo;Innovation is the ability to see change as an opportunity,
										not a threat.&ldquo;</p>
								</blockquote>
							</div>
						</div>
					</div>
				</div>
			<!-- </div> -->
		</div>
	</div>

	<div id="gtco-services">
		<div class="gtco-container">

			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2>What I'm Offer</h2>
					<p>This all my services are include in my prices, so don't worry to get service charge for me, all my services are deserved to my clients.</p>
				</div>
			</div>

			<div class="row animate-box">

				<div class="gtco-tabs">
					<ul class="gtco-tab-nav">
						<li class="active"><a href="#" data-tab="1"><span class="icon visible-xs"><i class="icon-command"></i></span><span class="hidden-xs">Web Design</span></a></li>
						<li><a href="#" data-tab="2"><span class="icon visible-xs"><i class="icon-code"></i></span><span class="hidden-xs">Web Developer</span></a></li>
						<li><a href="#" data-tab="3"><span class="icon visible-xs"><i class="icon-bag"></i></span><span class="hidden-xs">E-Commerce</span></a></li>
						<li><a href="#" data-tab="4"><span class="icon visible-xs"><i class="icon-laptop"></i></span><span class="hidden-xs">Programmer</span></a></li>
						<li><a href="#" data-tab="5"><span class="icon visible-xs"><i class="icon-search"></i></span><span class="hidden-xs">SEO</span></a></li>
						<li><a href="#" data-tab="6"><span class="icon visible-xs"><i class="icon-database"></i></span><span class="hidden-xs">Database</span></a></li>
						<li><a href="#" data-tab="7"><span class="icon visible-xs"><i class="icon-mobile"></i></span><span class="hidden-xs">Responsive</span></a></li>
						<li><a href="#" data-tab="8"><span class="icon visible-xs"><i class="icon-pencil"></i></span><span class="hidden-xs">Support</span></a></li>
					</ul>

					<!-- Tabs -->
					<div class="gtco-tab-content-wrap">

						<div class="gtco-tab-content tab-content active" data-tab-content="1">
							<div class="col-md-6">
								<div class="icon icon-xlg">
									<i class="icon-command"></i>
								</div>
							</div>
							<div class="col-md-6">
								<h2>Web Design</h2>
								<p>A designer who have skill to design anything especially web design and improve
									business advertisement which can increase the income.
									Because design is important things to make viewer interesting to
									check it.
								</p>
							<div class="row">
								<div class="col-md-6">
									<h2 class="uppercase">Modern Design</h2>
									<p>My designs are up to date, so dont worried you got the old design</p>
								</div>
								<div class="col-md-6">
									<h2 class="uppercase">100% good quality</h2>
									<p>My design are good quality which is you dont need to complained the designs</p>
								</div>
							</div>
							</div>
						</div>

						<div class="gtco-tab-content tab-content" data-tab-content="2">
							<div class="col-md-6">
								<div class="icon icon-xlg">
									<i class="fa fa-code"></i>
								</div>
							</div>
							<div class="col-md-6">
								<h2>Web Developer</h2>
								<p>
									A full stack developer with an eye for design, UX and UI development and a strong desire to learn and create.
									I have had a long career in the areas of software, e-commerce, blog and
									web development.
								</p>
									<div class="row">
									<div class="col-md-6">
										<h2 class="uppercase">Full Time Developer</h2>
										<p>I'm a full time developer that i have many time for developed websites</p>
									</div>
									<div class="col-md-6">
										<h2 class="uppercase">Many Experiences</h2>
										<p>As an Web Developer you need much experience to make sure your client. I have experience almost 4 years.</p>
									</div>
								</div>

							</div>
						</div>

						<div class="gtco-tab-content tab-content" data-tab-content="3">
							<div class="col-md-6">
								<div class="icon icon-xlg">
									<i class="icon-bag"></i>
								</div>
							</div>
							<div class="col-md-6">
								<h2>e-Commerce</h2>
								<p>With almost a year of experience in E-Commerce, I can develop an E-Commerce solution to the needs of yourself, your business, your community, your projects, and you customers.
									I make it minimalist, effective and nice contents you need it.
								</p>
								<div class="row">
									<div class="col-md-6">
										<h2 class="uppercase">Easy to shop</h2>
										<p>I will make it simple so you can shop easily</p>
									</div>
									<div class="col-md-6">
										<h2 class="uppercase">Good looking</h2>
										<p>Cusomers is more have time with website if they get the point of view so customers will get patience for shopping</p>
									</div>
								</div>

							</div>
						</div>

						<div class="gtco-tab-content tab-content" data-tab-content="4">
							<div class="col-md-6">
								<div class="icon icon-xlg">
									<i class="fa fa-terminal"></i>
								</div>
							</div>
							<div class="col-md-6">
								<h2>Programmer</h2>
								<p>You have business or projects that need apps to increase income and
									sociate your project to worldwide? Yes, you can use me to make
									interesting apps that i guarantee your business is grow up.
								</p>
								<div class="row">
									<div class="col-md-6">
										<h2 class="uppercase">Good Businesses</h2>
										<p>I can create program to make your businesses are good, and i hope it can help your business</p>
									</div>
								</div>
							</div>
						</div>

						<div class="gtco-tab-content tab-content" data-tab-content="5">
							<div class="col-md-6">
								<div class="icon icon-xlg">
									<i class="fa fa-search"></i>
								</div>
							</div>
							<div class="col-md-6">
								<h2>SEO</h2>
								<p>You have business or projects that need apps to increase income and sociate your project to worldwide? Yes, you can use me to make
									interesting apps that i guarantee your business is grow up.
								</p>
								<div class="row">
									<div class="col-md-6">
										<h2 class="uppercase">Top ten Google Search</h2>
										<p>I will give my best for got top ten.</p>
									</div>
									<div class="col-md-6">
										<h2 class="uppercase">Known well with netizens</h2>
										<p>Netizens are important for the reputation of websites.</p>
									</div>
								</div>
							</div>
						</div>

						<div class="gtco-tab-content tab-content" data-tab-content="6">
							<div class="col-md-6">
								<div class="icon icon-xlg">
									<i class="fa fa-database"></i>
								</div>
							</div>
							<div class="col-md-6">
								<h2>Database</h2>
								<p>Do you have'nt time to manage, to clean, to input data or something
									which your business need it? Don't worry i can be your Database
									Administrator so you can save your time to do your job and help your
									job always updated.
								</p>
								<div class="row">
									<div class="col-md-6">
										<h2 class="uppercase">Got Handle</h2>
										<p>Don't worry about your data, i can handle your big data with some database.</p>
									</div>
									<div class="col-md-6">
										<h2 class="uppercase">Big data</h2>
										<p>Have a thousand data that they need to maintenance and update? don't worry you got me.</p>
									</div>
								</div>
							</div>
						</div>

						<div class="gtco-tab-content tab-content" data-tab-content="7">
							<div class="col-md-6">
								<div class="icon icon-xlg">
									<i class="icon-mobile"></i>
								</div>
							</div>
							<div class="col-md-6">
								<h2>Responsive</h2>
								<p>Beside developing, you can tell me about your problems about tech,
									and i can help you as far as i can support your biz, your blog,
									your project management etc. Don't doubt to talk with me.
								</p>
								<div class="row">
									<div class="col-md-6">
										<h2 class="uppercase">Pixel perfect</h2>
										<p>I guranteed all my design is suitable for mobile devices.</p>
									</div>
									<div class="col-md-6">
										<h2 class="uppercase">User Interface Expert</h2>
										<p>Not just for pc, you can access from your mobile where ever you go without interupted bad designs.</p>
									</div>
								</div>
							</div>
						</div>

						<div class="gtco-tab-content tab-content" data-tab-content="8">
							<div class="col-md-6">
								<div class="icon icon-xlg">
									<i class="fa fa-pencil-square-o"></i>
								</div>
							</div>
							<div class="col-md-6">
								<h2>Support</h2>
								<p>Beside developing, you can tell me about your problems about tech,
									and i can help you as far as i can support your biz, your blog,
									your project management etc. Don't doubt to talk with me.
								</p>
								<div class="row">
									<div class="col-md-6">
										<h2 class="uppercase">Services Numero Uno</h2>
										<p>I have good services for all my client, so don't worry if you struglled.</p>
									</div>
									<div class="col-md-6">
										<h2 class="uppercase">24 Hours</h2>
										<p>I have 24 hours for helping my clients.</p>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- contact section -->
	<section id="contact">
		<div class="container">
			<div class="row">

				<div class="col-md-offset-2 col-md-8 col-sm-12">
					<div class="section-title">
						<h1 class="wow fadeInUp" data-wow-delay="0.3s">Get in touch</h1>
						<p class="wow fadeInUp" data-wow-delay="0.6s">I'm available for new project and
							work opportunities. If you want to hire or just say hello, feel free and don't hesitate
							to get in touch with me on my social media or email me.
							I'll reply as soon as possible!
						</p>
					</div>
					<div class="contact-form wow fadeInUp" data-wow-delay="1.0s">

						<?php

						if(empty($errors) === false) {
							echo '<ul>';
							foreach ($errors as $error) {
								echo '<li>', $error ,'</li>';
							}
							echo '</ul>';
						}

						 ?>

	<form id="contact-form" method="post" action="contact.php">
          <div class="col-md-6 col-sm-6">
            	<input name="name" type="text" class="form-control" placeholder="Your Name" required>
          </div>
          <div class="col-md-6 col-sm-6">
            	<input name="email" type="email" class="form-control" placeholder="Your Email" required>
          </div>
   			  	<div class="col-md-12 col-sm-12">
   			<textarea name="message" class="form-control" placeholder="Message" rows="6" required></textarea>
       			  	</div>
							<div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
								<input name="submit" type="submit" class="form-control submit" id="submit" value="SEND MESSAGE">
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</section>

	<footer id="gtco-footer" role="contentinfo">
		<div class="gtco-container">

			<div class="col-md-5"></div>

			<div class="col-md-5 col-sm-8 ">
					 <!-- CONTACT INFO -->
					 <div class="wow fadeInUp contact-info" data-wow-delay="0.4s">

								<p><i class="fa fa-map-marker"></i> Bandar Lampung, Lampung, Indonesia</p>
								<p><i class="fa fa-comment"></i>reynaldopratama84@gmail.com</p>
								<p><i class="fa fa-phone"></i> 010-020-0340</p>
					 </div>
			</div>

			<div class="row copyright">
				<div class="col-md-12">
					<p class="pull-left">
						<small class="block">&copy; 2018 Personal Website of Reynaldo.</small>
						<small class="block">Made in <i class="flag-icon flag-icon-id"></i> and Designed with <i class="fa fa-heart" id="heart"></i>  by <a href="http://reynaldodev.com/" target="_blank">Reynaldo</a></small>
					</p>
					<p class="pull-right">
						<ul class="gtco-social-icons pull-right">
							<li><a href="#"><i class="icon-facebook"></i></a></li>
							<li><a href="#"><i class="icon-instagram"></i></a></li>
							<li><a href="mailto:reynaldopratama84@gmail.com"><i class="icon-mail"></i></a></li>
						</ul>
					</p>
				</div>
			</div>
		</div>
	</footer>

	<div class="gototop js-top">
		<!--<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>-->
		<a href=javascript:void(0) id=rocketmeluncur class=showrocket><i></i></a>
	</div>
<script async src=ga-local.js></script>

	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- countTo -->
	<script src="js/jquery.countTo.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>
	<!-- Main -->
	<script src="js/mainnn.js"></script>
  <script src="js/custommss.js"></script>
  <script src="js/isotope.js"></script>
  <script src="js/imagesloaded.min.js"></script>
  <script src="js/nivo-lightbox.min.js"></script>
	<script src="js/vegas.min.js"></script>
	<script src="js/jquery.easypiechart.min.js"></script>

	<script type="text/javascript">
function downloadJSAtOnload() {
var element = document.createElement("script");
element.src = "mainn.js";
document.body.appendChild(element);
}
if (window.addEventListener)
window.addEventListener("load", downloadJSAtOnload, false);
else if (window.attachEvent)
window.attachEvent("onload", downloadJSAtOnload);
else window.onload = downloadJSAtOnload;
</script>

	</body>
</html>
