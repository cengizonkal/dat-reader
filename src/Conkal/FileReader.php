<?php

namespace Conkal;

use Conkal\Exceptions\FileNotSetException;
use Conkal\Exceptions\TemplateNotSetException;

class FileReader
{
    private $fp;
    private $file;
    private $line;
    private $recordCount = 0;
    private $template = [];
    private $records = [];


    public function __construct($file = null)
    {
        $this->file = $file;
    }


    public function read($limit = null)
    {
        $this->validation();

        $this->records = [];
        $this->recordCount = 0;
        $this->openFile();
        while (($this->recordCount < $limit || is_null($limit)) && ($this->line = fgets($this->fp))) {
            $this->addRecord();
        }
        return $this->records;
    }

    public function each($limit, $function)
    {
        while ($records = $this->read($limit)){
            $function($records);
        }
    }

    public function setTemplate(array $template)
    {
        $this->template = $template;
        return $this;
    }

    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    private function openFile()
    {
        if (!$this->fp) {
            $this->fp = fopen($this->file, 'r');
        }
    }

    public function closeFile()
    {
        fclose($this->fp);
        $this->fp = null;
    }

    private function validation()
    {
        if (!$this->file) {
            throw new FileNotSetException();
        }
        if (!$this->template) {
            throw new TemplateNotSetException();
        }
    }

    private function addRecord()
    {
        $record = new \stdClass();
        $start = 0;
        foreach ($this->template as $key => $len) {
            $record->{$key} = substr($this->line, $start, $len);
            $start += $len;
        }
        array_push($this->records, $record);
        $this->recordCount++;
    }
}