<?php

use Swoole\Redis\Server;

/**
 * Class Server
 *
 * @package \\${NAMESPACE}
 */
class SequenceRedisServer
{
    /**
     * @var \Co\Redis\Server
     */
    private $server;

    /**
     * @var \Sequence
     */
    private $sequence;

    public function __construct($host = '0.0.0.0', $port = 9999)
    {
        $this->server = new Server($host, $port, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
        $this->server->setHandler('sequence', [$this, 'sequenceHandler']);

        $this->server->set([
            'worker_num' => 1,
        ]);
        $this->server->on('WorkerStart', [$this, 'onWorkerStart']);
    }

    public function start()
    {
        $this->server->start();
    }

    public function sequenceHandler($fd, $data)
    {
        try {
            $number = $this->sequence->generate();
            $this->server->send($fd, Server::format(Server::STRING, $number));
        } catch (Exception $e) {
            $this->server->send($fd, Server::format(Server::NIL));
        }
    }

    public function onWorkerStart(Server $server, $worker_id)
    {
        $this->sequence = new Sequence($worker_id);
    }
}
