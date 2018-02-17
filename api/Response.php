<?php

/**
* Response class
*/
class Response
{
	private $type;
	private $data;

	function __construct($type, $data)
	{
		$this->type = $type;
		$this->data = $data;
	}

	public function success($data)
	{
		return array(
			'response' => $data
		);
	}

	public function error($message)
	{
		return array(
			'response' => $message,
			'error' => true
		);
	}

	public function send()
	{
		$response;
		switch ($this->type) {
			case 'success':
				$response = $this->success($this->data);
				break;
			
			case 'error':
				$response = $this->error($this->data);
				break;
			
			default:
				$response = $this->success($this->data);
				break;
		}
		echo json_encode($response);
		exit(0);
	}
}