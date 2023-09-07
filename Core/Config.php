<?php

namespace Core;

class Config
{
    private $config = [];
    private $file;

    public function __construct($file)
    {
        $this->file = base_path('config/' . $file);
        // TODO: file existence check
        // https://www.php.net/manual/en/function.parse-ini-file.php
        $this->config = parse_ini_file($this->file, true);
    }

    public function get($key, $section = null)
    {
        // https://www.php.net/manual/en/migration70.new-features.php#migration70.new-features.null-coalesce-op
        if ($section === null)
        {
            return $this->config[$key] ?? null;
        }
        else
        {
            return $this->config[$section][$key] ?? null;
        }
    }

    public function getAll($section = null)
    {
        // https://www.php.net/manual/en/migration70.new-features.php#migration70.new-features.null-coalesce-op
        if ($section === null)
        {
            return $this->config ?? null;
        }
        else
        {
            return $this->config[$section] ?? null;
        }
    }

    public function getMySQLPDODSN()
    {
        // https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.pdo
        // https://www.php.net/manual/en/function.http-build-query.php
        return "mysql:" . http_build_query($this->config['database'], '', ';');
    }
}
