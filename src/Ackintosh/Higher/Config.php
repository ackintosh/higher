<?php
namespace Ackintosh\Higher;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class Config
{
    private $configFile;
    private $tableDir;
    private $parser;
    private $config;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    public function parse()
    {
        if (empty($this->configFile)) {
            throw new \RuntimeException("Configuration file is not set.");
        }

        try {
            $this->config = $this->parser->parse(file_get_contents($this->configFile));
        } catch(ParseException $e) {
            throw new \RuntimeException(sprintf("Unable to parse the YAML string: %s", $e->getMessage()));
        }

        return $this;
    }

    public function setConfigFile($pathToFile)
    {
        if (is_file($pathToFile) === false) {
            throw new \InvalidArgumentException("Not found : {$pathToFile}");
        }

        $this->configFile = $pathToFile;
        return $this;
    }

    public function setTableDir($dirToTable)
    {
        if (is_dir($dirToTable) === false) {
            throw new \InvalidArgumentException("Not found : {$dirToTable}");
        }

        $this->tableDir = $dirToTable;
        return $this;
    }

    public function __get($name)
    {
        return $this->config[$name];
    }

    public function getTableDir()
    {
        return $this->tableDir;
    }

    public function getTableConnectionConfig($location)
    {
        return (isset($this->config['connection'][$location])) ? $this->config['connection'][$location] : $this->config['connection']['default'];
    }
}
