<?php

include './api/auth.php';
$auth = new auth();

// visitor info
$agent=$_SERVER['HTTP_USER_AGENT'];
$ip= $auth->getUserIP();
$host_name = gethostbyaddr($ip);
$platform = $_SERVER['HTTP_SEC_CH_UA_PLATFORM'];
$browser_info = $_SERVER['HTTP_SEC_CH_UA'];
$is_mobile = $_SERVER['HTTP_SEC_CH_UA_MOBILE'];

$user = $auth->fetchUser(1);
$codeSkills = $auth->fetchSkillsByType('coding');
$otherSkills = $auth->fetchSkillsByType('other');

// user info
$name = $user['name'];
$email = $user['email'];
$contact = $user['contact'];
$age = $user['age'];
$residence = $user['residence'];
$freelance = $user['freelance'];
$address = $user['address'];
$bio = $user['bio'];

// user name with line break
$nameArr = explode(" ", $name); 
$nameLogo = $nameArr[0].'<br>'.$nameArr[1];

// PROJECTS DATA
$projects = $auth->getProjects();

function formatDescription($desc){
	$arr = explode("(skipline)", $desc);
	$description = '';
	foreach($arr as $i){
		$description .= $i.'<br><br>';
	}
	return $description;
}

// ABOUT DATA
$aboutParas = $auth->fetchAboutParas();

?>

<!doctype html>
<html lang="en-US">
<head>

	<!-- Meta -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="description" content="Abdul Hannan Personal Portfolio" />
	<meta name="keywords" content="flutter, flutter developer, developer, web developer, app developer, abdul hannan, hannan, rocky, rocky khan, resume, personal portfolio, cv, portfolio" />
	<meta name="author" content="Abdul Hannan" />

	<!-- Title -->
	<title><?php echo $name ?> - Portfolio</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Mr+Dafoe&amp;display=swap" rel="stylesheet">

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/favicons/logo.ico" type="image/x-icon">

	<!-- Styles -->
	<link rel="stylesheet" href="assets/css/basic.css" />
	<link rel="stylesheet" href="assets/css/layout.css" />
	<link rel="stylesheet" href="assets/css/magnific-popup.css" />
	<link rel="stylesheet" href="assets/css/animate.css" />
	<link rel="stylesheet" href="assets/css/jarallax.css" />
	<link rel="stylesheet" href="assets/css/owl.carousel.css" />
	<link rel="stylesheet" href="assets/css/swiper.css" />
	<link rel="stylesheet" href="css/fontawesome.css" />
	<!-- Custom Styles -->
	<link rel="stylesheet" href="assets/css/custom/style.css">
	
</head>

<body class="home">

	<!-- Preloader -->
	<div class="preloader">
		<div class="box-1">
			<div class="centrize full-width">
				<div class="vertical-center">
					<div class="spinner">
						<div class="lines"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="box-2"></div>
	</div>

	<!-- Container -->
	<div class="container">

		<!-- Header -->
		<header class="header">

			<!-- logo -->
			<div class="logo">
				<a href="#">
					<img class="logo-img" src="assets/images/logo.png" alt="" />
					<span class="logo-lnk"><?php echo $nameLogo ?></span>
				</a>
			</div>

			<!-- menu button -->
			<a href="#" class="menu-btn"><span></span></a>

			<!-- download cv button -->
			<a href="#" class="btn download-cv-btn">
				<span class="animated-button"><span>Download CV</span></span>
				<i class="icon fas fa-download"></i>
			</a>

			<!-- header sidebar -->
			<div class="header-sidebar">

				<!-- top menu -->
				<div class="top-menu">
					<div class="top-menu-nav">
						<div class="menu-topmenu-container">
							<ul class="menu">
								<li class="menu-item current-menu-item ">
									<a href="#section-started">
										<span class="animated-button"><span>Home</span></span>
									</a>
								</li>
								<li class="menu-item">
									<a href="#section-about">
										<span class="animated-button"><span>About</span></span>
									</a>
								</li>
								<li class="menu-item">
									<a href="#section-experience">
										<span class="animated-button"><span>Resume</span></span>
									</a>
								</li>
								<li class="menu-item">
									<a href="#section-portfolio">
										<span class="animated-button"><span>Portfolio</span></span>
									</a>
								</li>
								<li class="menu-item">
									<a href="#section-contacts">
										<span class="animated-button"><span>Contact</span></span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

			</div>

		</header>

		<!-- Wrapper -->
		<div class="wrapper">

			<!-- Background -->
			<div class="background-bg">
				<div class="background-filter">
					<div class="background-img" style="background-image: url(assets/images/man.jpg);"></div>
				</div>
			</div>

			<!-- Section Started -->
			<div class="section started" id="section-started">
				<div class="centrize full-width">
					<div class="vertical-center">

						<!-- title -->
						<h1 class="h-title">
							<?php echo $nameLogo ?>
						</h1>

						<!-- content started -->
						<div class="started-content">

							<!-- subtitle -->
							<div class="h-subtitles">
								<div class="h-subtitle typing-subtitle">
									<p>Consultant and Mentor</p>
									<p>App Developer</p>
									<p>Programmer</p>
									<p>Web Developer</p>
								</div>
								<span class="typed-subtitle"></span>
							</div>

							<!-- text -->
							<div class="h-text"><?php echo $bio ?></div>

							<!-- button -->
							<a href="#" id="contactMeBtn" class="btn">
								<span class="animated-button"><span>Contact Me</span></span>
								<i class="icon fas fa-chevron-right"></i>
							</a>

							<!-- mosue button -->
							<a href="#" class="btn mouse-btn" style="display: none;">
								<i class="icon fas fa-chevron-down"></i>
							</a>

						</div>

					</div>
				</div>
			</div>

			<!-- Section About -->
			<div class="section about" id="section-about">
				<div class="content">

					<!-- title -->
					<div class="titles">
						<div class="title">About Me</div>
						<div class="subtitle">My story</div>
					</div>

					<!-- text -->
					<div class="cols">
						<?php foreach($aboutParas as $para) { ?>
							<div class="col <?php echo $para['length'] == 1 ? 'col-full' : 'col' ?>">
								<div class="single-post-text">
									<p><?php echo $para['para'] ?></p>
								</div>
							</div>
						<?php } ?>
					</div>

					<!-- info list -->
					<div class="info-list">
						<ul>
							<li><strong>Age:</strong> <?php echo $age ?> </li>
							<li><strong>Residence:</strong> <?php echo $residence ?> </li>
							<li><strong>Freelance:</strong>  <?php echo $freelance == 1 ? 'Available' : 'Unavailable' ?></li>
							<li><strong>Address:</strong> <?php echo $address ?> </li>
							<li><strong>Phone:</strong> <?php echo $contact ?> </li>
							<li><strong>E-mail:</strong> <?php echo $email ?> </li>
						</ul>
					</div>

					<div class="clear"></div>
				</div>
			</div>

			<!-- Section Service -->
			<div class="section service" id="section-services">
				<div class="content">

					<!-- title -->
					<div class="titles">
						<div class="title">Services</div>
						<div class="subtitle">What I Do</div>
					</div>

					<!-- services items -->
					<div class="service-items">

						<div class="service-col">
							<div class="service-item">
								<div class="icon"><i class="fas fa-mobile"></i></div>
								<div class="name">App <br />Development</div>
								<div class="single-post-text">
									<p>
										App development involves the complete lifecycle of designing, coding, testing, and launching mobile applications for various platforms, delivering seamless and innovative user experiences.
									</p>
								</div>
							</div>
						</div>

						<div class="service-col">
							<div class="service-item">
								<div class="icon"><i class="icon fab fa-chrome"></i></div>
								<div class="name">Web <br />Development</div>
								<div class="single-post-text">
									<p>
										Web development encompasses the entire process of creating and building websites, including designing, coding, and implementing interactive and visually appealing web pages.
									</p>
								</div>
							</div>
						</div>

						<div class="service-col">
							<div class="service-item">
								<div class="icon"><i class="icon fas fa-photo-video"></i></div>
								<div class="name">Graphic <br />Designing</div>
								<div class="single-post-text">
									<p>
										Graphic design is the art of visual storytelling, blending creativity and communication to convey powerful messages through stunning visuals.
									</p>
								</div>
							</div>
						</div>

						<div class="service-col">
							<div class="service-item">
								<div class="icon"><i class="icon fas fa-gamepad"></i></div>
								<div class="name">Game <br />Development</div>
								<div class="single-post-text">
									<p>
										Game development is the fusion of imagination and technology, crafting interactive worlds and captivating experiences for players to immerse themselves in.
									</p>
								</div>
							</div>
						</div>

					</div>

					<div class="clear"></div>
				</div>
			</div>
			

			<!-- Section Resume -->
			<div class="section resume" id="section-experience">
				<div class="content">

					<!-- title -->
					<div class="titles">
						<div class="title">Experience</div>
						<div class="subtitle">Working with</div>
					</div>

					<!-- resume items -->
					<div class="content-carousel">
						<div class="owl-carousel" data-slidesview="2" data-slidesview_mobile="1">

							<div class="item">
								<div class="resume-item active">
									<div class="date">Present</div>
									<div class="name">Bingtech <br />Solutions</div>
									<div class="single-post-text">
										<p>
											As an app developer at BingTech Solutions, I am passionately creating innovative mobile experiences that captivate users and push the boundaries of technology.
										</p>
									</div>
								</div>
							</div>

							<div class="item">
								<div class="resume-item">
									<div class="date">2022-2022</div>
									<div class="name">Bingtech <br />Solutions</div>
									<div class="single-post-text">
										<p>
											During my 3-month internship (July-October), BingTech Solutions fueled my passion for innovative app development, shaping captivating mobile experiences.
										</p>
									</div>
								</div>
							</div>

						</div>

						<!-- navigation -->
						<div class="navs">
							<span class="prev fas fa-chevron-left"></span>
							<span class="next fas fa-chevron-right"></span>
						</div>

					</div>

				</div>
			</div>

			<!-- Section Resume -->
			<div class="section resume" id="section-education">
				<div class="content">

					<!-- title -->
					<div class="titles">
						<div class="title">Education</div>
						<div class="subtitle">Studied at</div>
					</div>

					<!-- resume items -->
					<div class="content-carousel">
						<div class="owl-carousel" data-slidesview="2" data-slidesview_mobile="1">

							<div class="item">
								<div class="resume-item active">
									<div class="date">2020-2024</div>
									<div class="name">Agriculture University <br />Peshawar</div>
									<div class="single-post-text">
										<p>
											Studying Computer Science at the University of Agriculture Peshawar, fueling my tech-driven aspirations.
										</p>
									</div>
								</div>
							</div>

							<div class="item">
								<div class="resume-item">
									<div class="date">2018-2020</div>
									<div class="name">Edwardes College <br />Peshawar</div>
									<div class="single-post-text">
										<p>
											Completed pre-engineering studies at Edwardes College Peshawar, fueling my engineering passion for future pursuits.
										</p>
									</div>
								</div>
							</div>

							<div class="item">
								<div class="resume-item">
									<div class="date">2018</div>
									<div class="name">Peshawar Model <br />School</div>
									<div class="single-post-text">
										<p>
											Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna.
										</p>
									</div>
								</div>
							</div>

							</div>

						<!-- navigation -->
						<div class="navs">
							<span class="prev fas fa-chevron-left"></span>
							<span class="next fas fa-chevron-right"></span>
						</div>

					</div>

				</div>
			</div>

			<!-- Section Coding Skills -->
			<div class="section skills" id="section-skills-code">
				<div class="content">

					<!-- title -->
					<div class="titles">
						<div class="title">Coding Skills</div>
						<div class="subtitle">Developing on</div>
					</div>

					<!-- skills items-->
					<div class="skills circles">
						<ul>
							<?php foreach($codeSkills as $skill){ ?>
								<li>
									<div class="progress p<?php echo $skill['percent'] ?>"> 
										<div class="percentage"></div>
										<span><?php echo $skill['percent'] ?>%</span>
									</div>
									<div class="name"><?php echo $skill['name'] ?></div>
									<div class="single-post-text">
										<p><?php echo $skill['description'] ?></p>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>

				</div>
			</div>

			<!-- Section Other Skills -->
			<div class="section skills" id="section-skills">
				<div class="content">

					<!-- title -->
					<div class="titles">
						<div class="title">Other Skills</div>
						<div class="subtitle">proficient in</div>
					</div>

					<!-- skills items -->
					<div class="skills percent">
						<ul>
							<?php foreach($otherSkills as $skill){ ?>
								<li>
									<div class="name"><?php echo $skill['name'] ?></div>
									<div class="single-post-text">
										<p><?php echo $skill['description'] ?></p>
									</div>
									<div class="progress">
										<div class="percentage" style="width: <?php echo $skill['percent'] ?>%;">
											<span class="percent"><?php echo $skill['percent'] ?>%</span>
										</div>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>

				</div>
			</div>

			<!-- Works -->
			<div class="section works" id="section-portfolio">
				<div class="content">

					<!-- title -->
					<div class="titles">
						<div class="title">Portfolio</div>
						<div class="subtitle">Latest works</div>
					</div>

					<!-- filter -->
					<div class="filter-menu">
						<div class="filters">
							<div class="btn-group">
								<label data-text="All" class="glitch-effect">
									<input type="radio" name="fl_radio" value=".box-col" />All
								</label>
							</div>
							<div class="btn-group">
								<label data-text="App">
									<input type="radio" name="fl_radio" value=".f-app" />App
								</label>
							</div>
							<div class="btn-group">
								<label data-text="Web">
									<input type="radio" name="fl_radio" value=".f-web" />Web
								</label>
							</div>
							<div class="btn-group">
								<label data-text="Design">
									<input type="radio" name="fl_radio" value=".f-design" />Design
								</label>
							</div>
							<div class="btn-group">
								<label data-text="Other">
									<input type="radio" name="fl_radio" value=".f-other" />Other
								</label>
							</div>
						</div>
					</div>

					<!-- portfolio items -->
					<div class="box-items">

						<div id="projectsContainer"></div>
						<?php foreach($projects as $project){ ?>
							<div class="box-col f-<?php echo $project['type'] ?>">
								<div class="box-item">
									<div class="image">
										<?php
											echo $project['type'] == 'design'
											?
											'<a href="assets/images/projects/'.$project['type'].'/'.$project['img'].'" class="has-popup-image">'
											:
											'<a href="#popup-'.$project['pid'].'" class="has-popup-media">';
										?>
											<img src="<?php echo 'assets/images/projects/'.$project['type'].'/'.$project['img'] ?>" alt="project thumbnail" />
											<span class="info">
												<span class="centrize full-width">
													<span class="vertical-center">
														<i class="
															<?php
																switch($project['type']){
																	case 'app':
																		echo 'icon fas fa-mobile-alt';
																		break;
																	case 'web':
																		echo 'icon fab fa-chrome';
																		break;
																	case 'design':
																		echo 'icon fas fa-image';
																		break;
																	case 'other':
																		echo 'icon fas fa-link';
																		break;
																}
															?>
														"></i>
													</span>
												</span>
											</span>
										</a>
									</div>
									<div class="desc">
										<div class="category"><?php echo ucwords($project['type']) ?></div>
										<?php
											echo $project['type'] == 'design'
											?
											'<a href="'.'assets/images/projects/'.$project['type'].'/'.$project['img'].'" class="name has-popup-image">'.$project['name'].'</a>'
											:
											'<a href="#popup-'.$project['pid'].'" class="name has-popup-media">'.$project['name'].'</a>'
										?>
									</div>
									<?php if($project['type'] != 'design'){ ?>
										<div id="popup-<?php echo $project['pid'] ?>" class="popup-box mfp-fade mfp-hide">
										<div class="content">
											<div class="image">
												<img src="<?php echo 'assets/images/projects/'.$project['type'].'/'.$project['img'] ?>" alt="project image">
											</div>
											<div class="desc">
												<div class="category"><?php echo ucwords($project['type']) ?></div>
												<h4><?php echo $project['name'] ?></h4>
												<p> <?php echo formatDescription($project['description']) ?> </p>
												<?php
													if ($project['url'] != ""){
														echo $project['type'] == 'web' || $project['type'] == 'other'
														?
														'<a target="_blank" href="'.$project['url'].'" class="btn"> <span class="animated-button"> <span> View Project </span> </span> <i class="icon fas fa-chevron-right"> </i> </a>'
														: '';
													}
												?>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>

					</div>

					<div class="clear"></div>
				</div>
			</div>

			<!-- Section Contacts Info >-->
			<div class="section contacts" id="section-contacts">
				<div class="content">

					<!-- title -->
					<div class="titles">
						<div class="title">Contact</div>
						<div class="subtitle">Let's talk</div>
					</div>

					<!-- contact form -->
					<div class="contact-form">
						<form id="cform" method="post">
							<div class="group-val">
								<div class="label">Full name <strong>*</strong></div>
   								<input type="text" name="name" placeholder="Abdul Hannan" />
							</div>
							<div class="group-val">
								<div class="label">Email address <strong>*</strong></div>
								<input type="email" name="email" placeholder="example@domain.com" />
							</div>
							<div class="group-val">
								<div class="label">Message <strong>*</strong></div>
								<textarea name="message" placeholder="To Write"></textarea>
							</div>
							<div class="group-bts">
								<button type="submit" class="btn">
									<span class="animated-button"><span>Send Message</span></span>
									<i class="icon fas fa-chevron-right"></i>
								</button>
							</div>
						</form>
						<div class="alert-success">
							<p>Thanks, your message is sent successfully.</p>
						</div>
						<div class="alert-error">
							<p>The Message could not be sent.</p>
						</div>
					</div>

					<!-- contact info -->
					<div class="contact-info">
						<div class="name"> <?php echo $name ?> </div>
						<div class="subname">App &amp; Web Developer</div>
						<div class="info-list">
							<ul>
								<li><strong>Age:</strong> <?php echo $age ?> </li>
								<li><strong>Residence:</strong> <?php echo $residence ?> </li>
								<li><strong>Freelance:</strong> <?php echo $freelance == 1 ? 'Available' : 'Unavailable' ?> </li>
								<li><strong>Address:</strong>  <?php echo $address ?>  </li>
								<li><strong>Phone:</strong> <?php echo $contact ?> </li>
								<li><strong>Gmail:</strong>  <?php echo explode("@", $email)[0] ?>  </li>
							</ul>
						</div>
						<div class="author"> <?php echo $name ?> </div>
					</div>

					<div class="clear"></div>
				</div>
			</div>

		</div>

		<!-- Footer -->
		<footer class="footer">
			<div class="socials">
				<a target="_blank" href="https://github.com/Abdul-Hannan12">
					<i class="icon fab fa-github"></i>
				</a>
				<a target="_blank" href="https://www.linkedin.com/in/abdul-hannan-8a78b01bb/">
					<i class="icon fab fa-linkedin-in"></i>
				</a>
				<a target="_blank" href="mailto: abdulhannan8540680@gmail.com">
					<i class="icon fa fa-envelope"></i>
				</a>
			</div>
		</footer>

	</div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/velocity.min.js"></script>
	<script src="assets/js/jquery.validate.js"></script>
	<script src="assets/js/magnific-popup.js"></script>
	<script src="assets/js/typed.js"></script>
	<script src="assets/js/jarallax.js"></script>
	<script src="assets/js/jarallax-video.js"></script>
	<script src="assets/js/jarallax-element.js"></script>
	<script src="assets/js/imagesloaded.pkgd.js"></script>
	<script src="assets/js/isotope.pkgd.js"></script>
	<script src="assets/js/owl.carousel.js"></script>
	<script src="assets/js/swiper.js"></script>
	<script src="assets/js/scripts.min.js"></script>

</body>
</html>
