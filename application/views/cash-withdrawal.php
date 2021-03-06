<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>ATM++ By Aaditya Sharma</title>
		<meta name="robots" content="noindex, nofollow" />
		<meta name="description" content="ATM++ By Aaditya" />
		<meta name="keywords" content="ATM++ By Aaditya" />
		<meta name="author" content="Aaditya Sharma" />
		<link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.ico"> 
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/default.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/component.css" />
		 <script src="<?php echo base_url(); ?>js/libs/jquery-1.7.1.min.js"></script> 
		<script src="<?php echo base_url(); ?>js/jquery.playSound.js"></script>  
		<!--<script src="<?php echo base_url(); ?>js/myscript1.js"></script> -->
		<script src="<?php echo base_url(); ?>js/myscript2.js"></script>
		<script src="<?php echo base_url(); ?>js/modernizr.custom.js"></script>
		<script>
			$(document).ready(function() {
				$('#withdraw-money').click(function() {
				  $("#form").submit();	
				});
				$('#go-back').click(function() {
				   window.location = "<?php echo base_url(); ?>main/transaction";
				});
				$('#logout').click(function() {
				   window.location = "<?php echo base_url(); ?>main/logout";
				});
			});	
		</script>
		<script>
			$(document).ready(function() {

				document.getElementById("sound1").play();	
					
				if (!('webkitSpeechRecognition' in window)) {

					$('.not-supported').show();
					$('.supported').hide();

				} else {

					$('.not-supported').hide();
					
					var recognition = new webkitSpeechRecognition();
						recognition.continuous = true;
						recognition.interimResults = true;

					recognition.onresult = function(event) {
						final_transcript = '';
						var interim_transcript = '';

						for (var i = event.resultIndex; i < event.results.length; ++i) {
							if (event.results[i].isFinal) {
								final_transcript += event.results[i][0].transcript;
							} else {
								interim_transcript += event.results[i][0].transcript;
							}
						}

						move(final_transcript);

					};

					recognition.start();


				}
				/*
				var width = $(document).width(),
					height = $(document).height();

				$('#box').css({ left: width / 2 -  25});
				*/

				levenshteinLevel = false;

				$('#level').change( function () {
					levenshteinLevel = $(this).val();
				});

				function move(direction) {

					var animationTime = 2000,
						directions = ["more info","info","information","more information","close","back","go back","submit"];
					direction = direction.replace(/\W/g, "");
					if (direction === "") {
						return;
					}

				//   $('<span />').html(direction).appendTo('#commands');
				
					$("#speak1").text(direction);
					
					if (levenshteinLevel) {
						for (var i = 0; i < directions.length; i++) {
							if (levenshtein(directions[i], direction) <= levenshteinLevel) {
								direction = directions[i];
								break;
							}
						}
					}

				//    $('#directions div').removeClass('directionActive');
				//    $('#' + direction).addClass('directionActive');

					switch (direction) {
					
					case 'logout':
					case 'log out':
						$("#logout").click();	
						break;	
					case 'cash withdrawal':
					case 'cashwithdrawal':
					case 'withdrawal':
					case 'withdraw money':
					case 'withdrawmoney':
					case 'submit':
						$("#form").submit();	
						break;
					case 'back':
					case 'go back':
					case 'goback':
						$("#go-back").click();	
						break;	
					case 'enter amount':
					case 'enteramount':
					case 'enter the amount':
					case 'enter':
					case 'focus':
					case 'amount':
						$('#withdrawal_amount').focus();
						break;
					case 'next':
						if ($("#withdrawal_amount").is(":focus")) {
							$('#withdraw-money').focus();
						}
						break;	
					}
					
					//$("input:focus").doStuff();
					if ($("input#withdrawal_amount").is(":focus")) {
					  $("input#withdrawal_amount").val(direction);
					}
					
				}

			});
		</script>
		<script>
			function validateForm()
			{
			var x=document.forms["form"]["withdrawal_amount"].value;
			if (x==null || x=="")
			  {
				  alert("Please enter the amount");
				  return false;
			  }
			}
		</script>
	</head>
	<body>
		<div class="not-supported">
		  Your browser doesn't support Web Speech API. Please use Google Chrome.
		</div>
		<div class="supported"> 
			<div class="container">
				<header class="header-box">
					<div class="content">
						<h1>Cash Withdrawal</h1>
					</div>
				</header>
				<div class="main clearfix">
					<div class="column">
						<p style="font-size:29px;text-align:left;display:block;margin-top:20px;">
							<span style="width:100%;text-aligh:center;font-size:35px;margin-left:20px;">Welcome  <?php echo $name; ?></span>
						</p>
						<br/>
						<img class="profile-pic" src="<?php echo base_url(); ?>img/profiles/<?php echo $profile_image; ?>"/>
						<button class="btn-big" id="logout" style="font-size:20px;">Logout</button>
						<p style="font-size:29px;text-align:left;display:block;">
							<br/><br/>
							Browse this portal with your voice
							<br/>
							<span id="speak1" style="font-size:20px;">Your Voice Commands</span>
						</p>
					</div>
					<div class="column">
					<form id="form" action="<?php echo base_url(); ?>main/cash_withdrawal" method="post" onsubmit="return validateForm()">
						<p style="font-size:29px;text-align:left;display:block;margin-top:20px;">
							<span style="width:100%;text-aligh:center;font-size:35px;margin-left:20px;">Please enter the amount</span>
								<input style="margin-top:15px;" class="input-big" type="number" x-webkit-speech onwebkitspeechchange="checkanswer()" name="withdrawal_amount" required="" id="withdrawal_amount" />
						</p>
						<br/>
					</form>	
						<button name="withdraw-money" value="withdraw-money" class="btn-big" id="withdraw-money" style="font-size:20px;float:right;width:auto;height:auto;margin:15px;padding-top:1.8em;padding-bottom:1.8em;">Withdraw Money</button>
						<button class="btn-big" id="go-back" style="font-size:20px;float:right;width:auto;height:auto;margin:15px;padding-top:1.8em;padding-bottom:1.8em;">Go Back</button>
						<audio id="beep-two" controls preload="auto">
							<source src="<?php echo base_url(); ?>audio/beep.mp3" controls></source>
							<source src="<?php echo base_url(); ?>audio/beep.ogg" controls></source>
						<!--	Your browser isn't invited for super fun time. -->
						</audio>
						
					</div>
					<script>
						$(".btn-big")
						  .each(function(i) {
							if (i != 0) { 
							  $("#beep-two")
								.clone()
								.attr("id", "beep-two" + i)
								.appendTo($(this).parent()); 
							}
							$(this).data("beeper", i);
						  })
						  .mouseenter(function() {
							$("#beep-two" + $(this).data("beeper"))[0].play();
						  });
						$("#beep-two").attr("id", "beep-two0");
					</script>
				</div>
			</div>
		</div>	
			
		<div class="md-overlay"></div><!-- the overlay element -->

		<audio id="sound1" autobuffer src="<?php echo base_url(); ?>audio/login/4.mp3"></audio>
		
		<!-- classie.js -->
		<script src="<?php echo base_url(); ?>js/classie.js"></script>
		<script src="<?php echo base_url(); ?>js/modalEffects.js"></script>

		<!-- for the blur effect -->
		<script>
			// this is important for IEs
			var polyfilter_scriptpath = '/js/';
		</script>
	<!--	<script src="js/cssParser.js"></script>
		<script src="js/css-filters-polyfill.js"></script> -->
	</body>
</html>