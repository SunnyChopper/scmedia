<?php

namespace App\Custom;

use Validator;
use Session;
use Auth;
use Mail;

class MailHelper {
	/* Private global variables */
	private $email_path;
	private $sender_first_name;
	private $sender_last_name;
	private $sender_email;
	private $recipient_first_name;
	private $recipient_last_name;
	private $recipient_email;
	private $subject;
	private $data_tags;

	/* Initializer */
	public function __construct($data) {
		if (isset($data["email_path"])) {
			$this->email_path = $data["email_path"];
		} else {
			$this->email_path = "";
		}

		if (isset($data["sender_first_name"])) {
			$this->sender_first_name = $data["sender_first_name"];
		} else {
			$this->sender_first_name = "";
		}

		if (isset($data["sender_last_name"])) {
			$this->sender_last_name = $data["sender_last_name"];
		} else {
			$this->sender_last_name = "";
		}

		if (isset($data["sender_email"])) {
			$this->sender_email = $data["sender_email"];
		} else {
			$this->sender_email = "";
		}

		if (isset($data["recipient_first_name"])) {
			$this->recipient_first_name = $data["recipient_first_name"];
		} else {
			$this->recipient_first_name = "";
		}

		if (isset($data["recipient_last_name"])) {
			$this->recipient_last_name = $data["recipient_last_name"];
		} else {
			$this->recipient_last_name = "";
		}

		if (isset($data["recipient_email"])) {
			$this->recipient_email = $data["recipient_email"];
		} else {
			$this->recipient_email = "";
		}

		if (isset($data["subject"])) {
			$this->subject = $data["subject"];
		} else {
			$this->subject = "";
		}

		if (isset($data["data_tags"])) {
			$this->data_tags = $data["data_tags"];
		} else {
			$this->data_tags = array();
		}
	}

	/* Public functions */
	public function send_email() {
		$email_data = $this->get_email_data();
		Mail::send($email_data["email_path"], $email_data["data_tags"], function($message) use ($email_data) {
			$message->to($data["recipient_email"], $data["recipient_first_name"] . " " . $data["recipient_last_name"]);
			$message->from($data["sender_email"], $data["sender_first_name"] . " " . $data["sender_last_name"]);
			$message->($data["subject"]);
			$message->replyTo($email_data["sender_email"], $email_data["sender_first_name"] . " " . $email_data["sender_last_name"]);
		});
	}

	public function send_email_with_cc($cc) {
		$email_data = $this->get_email_data();
		Mail::send($email_data["email_path"], $email_data["data_tags"], function($message) use ($email_data) {
			$message->to($data["recipient_email"], $data["recipient_first_name"] . " " . $data["recipient_last_name"]);
			$message->from($data["sender_email"], $data["sender_first_name"] . " " . $data["sender_last_name"]);
			$message->($data["subject"]);
			$message->replyTo($email_data["sender_email"], $email_data["sender_first_name"] . " " . $email_data["sender_last_name"]);
			$message->cc($cc);
		});
	}

	/* Private functions */
	private function get_email_data() {
		$data = array(
			"email_path" => $this->email_path,
			"sender_first_name" => $this->sender_first_name,
			"sender_last_name" => $this->sender_last_name,
			"sender_email" => $this->sender_email,
			"recipient_first_name" => $this->recipient_first_name,
			"recipient_last_name" => $this->recipient_last_name,
			"recipient_email" => $this->recipient_email,
			"subject" => $this->subject
		);

		return $data;
	}
}

?>