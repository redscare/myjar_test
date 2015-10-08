<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMPQConnector{

	private $link;
	private $channel;
	private $handler;

	public $host;
	public $port;
	public $user;
	public $pass;
	public $inQueueName;
	public $outQueueName;
	public $token;

	/*
	* Building new object for handling requests;		
	*/
	public function __construct()
    {
        $this->handler = new msgHandler;
    }

    /*
	* Making new connection to remote service		
	*/
    public function connect()
    {
    	$this->link = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pass);
    	$this->channel = $this->link->channel();
    }

   /*
	* Making new connection to remote service		
	*/
    public function runService()
    {
        $this->channel->basic_consume($this->inQueueName, '', false, false, false, false, function(AMQPMessage $msg) {
            
            $req = json_decode($msg->body);
           
            if (!isset($req->sum) || !is_numeric($req->sum) || !isset($req->days) || !is_int($req->days) || $req->days<1)
            	{
            		echo "Invalid input data: $msg->body" . PHP_EOL;
            		return;
            	}

            $query = json_encode($this->handler->buildQuery($req->sum, $req->days, $this->token));
            $message = new AMQPMessage($query, ['content_type' => 'application/json']);
            $this->channel->basic_publish($message, '', $this->outQueueName);
        });

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}