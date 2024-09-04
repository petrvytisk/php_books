<?php
class DbConnect
{
    private $server = 'sql8.endora.cz';
    private $dbname = 'petrvy1725446813';
    private $user = 'petrvy1725446813';
    private $pass = 'K%X)6Oa1tGe(@+ii';
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    public function connect()
    {
        try {
            $conn = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->dbname . ';charset=utf8', $this->user, $this->pass, $this->options );
            return $conn;
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
}