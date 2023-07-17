<?php

use Buki\Pdox;

class Database
{

    private ?PDOx $cn = null;


    public function __construct(
        private string $host,
        private string $name,
        private string $user,
        private string $password,
        private ?array $options = null
    ) {
    }

    public function getConnection(): PDOx
    {

        if ($this->cn == null) {
            $config = [
                'host' => $this->host,
                'driver' => $this->options['driver'] ?? 'mysql',
                'database' => $this->name,
                'username' => $this->user,
                'password' => $this->password,
                'charset' => $this->options['charset'] ?? 'utf8',
                'collation' => $this->options['collation'] ?? 'utf8_general_ci',
                'prefix' => $this->options['prefix'] ?? ''
            ];
            $this->cn = new PDOx($config);
        }

        return $this->cn;
    }

}