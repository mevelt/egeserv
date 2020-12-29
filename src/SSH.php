<?php

namespace mehmetbeyHZ;

class SSH
{
    protected $connection;
    /**
     * @var resource
     */
    protected $stream;
    public function __construct($server, $username,$password)
    {
        $this->connection = ssh2_connect($server, 22);
        ssh2_auth_password($this->connection, $username, $password);
    }

    public function command($command) : SSH
    {

        $this->stream = ssh2_exec($this->connection, $command);
        stream_set_blocking($this->stream, true);
        return $this;
    }

    public function getOutputStream()
    {
        return ($this->stream) ?  stream_get_contents($this->stream) : null;
    }


    public function sendFile($localFolder,$remoteFolder,$mode = 0644): SSH
    {
        ssh2_scp_send($this->connection,$localFolder,$remoteFolder,$mode);
        return $this;
    }

    public function __destruct()
    {
        if ($this->stream){
            fclose($this->stream);
        }
    }

}
