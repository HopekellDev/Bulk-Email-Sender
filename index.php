<?php
  
  // include phpmailer class
  require_once 'mailer/class.phpmailer.php';
  // creates object
  $mail = new PHPMailer(true); 
  
  if(isset($_POST['btn_send']))
  {
	$email      = strip_tags($_POST['emails']);
	$mails= str_replace(".,", ",", $email);
	$subject    = strip_tags($_POST['Subject']);
	$client	=	$_POST['client'];
	$message  = $_POST['message'];

	/// Import Files

	//create folder/directory for your uploads
	$folder="./uploads/";
	//get image information from form
	$file = $_FILES['file']['name'];

	//Generate temporary name
	$file_loc = $_FILES['file']['tmp_name'];

	//change uploads to lowercase
	$file_lowercase= strtolower($file);

	//Relace all spacese with dash
	$attach= str_replace(" ", "-", $file_lowercase);
	   try
	   {
	    $mail->IsSMTP(); 
	    $mail->isHTML(true);
	    $mail->SMTPDebug  = 0;                     
	    $mail->SMTPAuth   = true;                  
	    $mail->SMTPSecure = "ssl";                 
	    $mail->Host       = "smtp.gmail.com";      
	    $mail->Port       = 465;
	    $addr = explode(',', $mails);
	    foreach ($addr as $ad) {
	    	$mail->AddBCC(trim($ad));
	              } 
	    if (move_uploaded_file($file_loc, $folder.$attach)){         
	    	$mail->AddAttachment('./uploads/'.$attach);
		}
	    $mail->Username   ="email@gmail.com";  
	    $mail->Password   ="GMAIL_password";            
	    $mail->SetFrom('email@gmail.com',$client);
	    $mail->AddReplyTo("email@gmail.com",$client);
	    $mail->Subject    = $subject;
	    $mail->Body    = $message;
	    $mail->AltBody    = $message;
	     
	    if($mail->Send())
	    {
	     
	     ?>
	     <script>
	     	alert("Email sent")
	     	window.location.href="./";
	     </script>
	     <?php
	     
	    }
	   }
	   catch(phpmailerException $ex)
	   {
	    $msg = "<div class='alert alert-warning'>".$ex->errorMessage()."</div>";
	   }
	   // HTML email ends here
	 
  } 
  
?>

<!DOCTYPE html>
<html>
<head>
	<title>Bulk Mail sender with attachment using Form, PHP and SMTP</title>
	<link href="./assets/css/tagsinput.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row" style="padding-top: 100px">
			<div class="col-md-8" style="margin: auto;">
				<h4 class="text-primary"><center><i class="fa fa-bomb"></i> Bulk Mail sender with attachment using Form, PHP and SMTP</center></h4>
				<form method="post" action="" enctype="multipart/form-data" autocomplete="off">
					<?php
					  if(isset($msg))
					  {
					   echo $msg;
					  }
					  ?>
					<div class="form-group">
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text" id="basic-addon1">Subject</span>
						  </div>
						  <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="Subject">
						</div>
					</div>
					<div class="form-group">
						<label>Recipients (BCC)</label>
						<input type="text" class="form-control" name="emails" data-role="tagsinput" autocomplete="off" />
					</div>
					<div class="form-group">
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
						  </div>
						  <input type="text" name="client" class="form-control" reqired />
						</div>
					</div>
					<div class="form-group">
						<label>Email Body</label>
						<textarea class="form-control"  id="editor1" name="message"></textarea>
					</div>
					<div class="form-group">
						<label>Upload Attachment</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text" id="basic-addon1"><i class="fa fa-paperclip"></i></span>
						  </div>
						  <input type="file" name="file" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-lg" name="btn_send" type="submit"><i class="fa fa-paper-plane"></i> Send Emails</button>
						<a href="https://hopekelltech.com.ng/" class="btn btn-success btn-lg" style="float: right;">Hire Me</a>
					</div>
				</form>
			</div>
		</div>
	</div>



<script src="./assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="./assets/js/popper.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./assets/js/tagsinput.js"></script>

<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script>
        CKEDITOR.replace( 'editor1' );

</script>
</body>
</html>