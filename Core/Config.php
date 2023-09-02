<?php

    namespace Core;

    class Config
    {
        private $config = [];
        public function __construct($file)
        {
            // TODO: file existence check
            // https://www.php.net/manual/en/function.parse-ini-file.php
            $this->config = parse_ini_file($file);
        }

        public function getPdoDsnForDatabase($database)
        {
            // https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.pdo
            $dsn = "mysql:" . http_build_query($this->config, '', ';') . ";dbname={$database}";

            return $dsn;
        }
    }
