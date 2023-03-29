<?php
// Adapted code from Hafiz Haider 24-11-2019

	require_once 'libs/phpmailer/includes/PHPMailer.php';
	require_once 'libs/phpmailer/includes/SMTP.php';
	require_once 'libs/phpmailer/includes/Exception.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class Mailer {

		private $mail;

		public function __construct(){
			$this->mail = new PHPMailer();

			$this->mail->isSMTP();
			$this->mail->Host = getenv('MAIL_HOST');
			$this->mail->SMTPAuth = true;
			$this->mail->SMTPSecure = "tls";
			$this->mail->Port = getenv('MAIL_PORT');
			$this->mail->Username = getenv('EMAIL_USER');
			$this->mail->Password = getenv('EMAIL_PASSWORD');
			$this->mail->setFrom(getenv('EMAIL_USER'));
			$this->mail->isHTML(true);
			$this->mail->CharSet = 'UTF-8';
		}

		public function sendEmail($emailToSend, $subject, $body){
			$this->mail->Subject = utf8_decode($subject);
			$this->mail->Body = utf8_decode($body);
			$this->mail->addAddress($emailToSend);

			if ( $this->mail->send() ) {
				echo "Email Sent.";
			}else{
				echo 'Message could not be sent. Mailer Error: '.$this->mail->ErrorInfo.'.';
			}
		}

		public function closeConnection(){
			$this->mail->smtpClose();
		}

	}

?>
