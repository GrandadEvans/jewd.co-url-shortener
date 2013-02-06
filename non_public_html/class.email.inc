<?php
require_once('includes/swiftMailer/swift_required.php');

class email {

    public $to_address;
	public $to_name;
	public $from_address;
	public $from_name;
	public $subject;
	public $body;
	public $debug = false;
	
	private $smtp_user;
	private $smtp_pass;
	private $smtp_host;

	
	function __construct() {
	    $this->to_address = "john@jewd.co.uk";
		$this->to_name = 'John Evans';
		$this->from_address = 'john@jewd.co.uk';
		$this->from_name = 'jewd Scripts';
        $this->smtp_user = '';
	    $this->smtp_pass = '';
    	$this->smtp_host = '';
	}
	//Create the Transport
    function send() {
	    if ($this->debug === true) '<pre>';
		$transport = Swift_SmtpTransport::newInstance($this->smtp_host, 25)
		  ->setUsername($this->smtp_user)
		  ->setPassword($this->smtp_pass)
		  ;
		if ($this->debug === true) echo "SMTP Host: " . $this->smtp_host . "<br />Username: " . $this->smtp_user . "<br />Password: " . $this->smtp_pass . "<br />";
        $mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance($this->subject)
		  ->setFrom(array($this->from_address => $this->from_name))
		  ->setTo(array($this->to_address => $this->to_name))
		  ->setBody(nl2br($this->body), 'text/html')
		  ->addPart(strip_tags($this->body), 'text/plain')
		  ;
		if ($this->debug === true) echo "Subject: " . $this->subject . "<br />From Name: " . $this->from_name . "<br />From Email Address: " . $this->from_address . "<br />To Name: " . $this->to_name . "<br />To Email Address: " . $this->to_address . "<br />Body: " . $this->body . "<br />";
		$result = $mailer->send($message);
		if ($this->debug === true) echo '</pre>';
		if ($this->debug === true) exit;		
	}
}
?>
