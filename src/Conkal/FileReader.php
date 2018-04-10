<?php

namespace Conkal;

use Conkal\Exceptions\FileNotSetException;
use Conkal\Exceptions\TemplateNotSetException;

class FileReader
{
    private $filePointer;
    private $filename;
    private $currentLine;
    private $recordCount = 0;
    private $template = [];
    private $records = [];


    public function __construct($filename = null)
    {
        $this->filename = $filename;
    }


    public function read($limit = null)
    {
        $this->validation();

        $this->records = [];
        $this->recordCount = 0;
        $this->openFile();
        while (($this->recordCount < $limit || is_null($limit)) && ($this->currentLine = fgets($this->filePointer))) {
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

    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    private function openFile()
    {
        if (!$this->filePointer) {
            $this->filePointer = fopen($this->filename, 'r');
        }
    }

    public function closeFile()
    {
        fclose($this->filePointer);
        $this->filePointer = null;
    }

    private function validation()
    {
        if (!$this->filename) {
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
            $record->{$key} = substr($this->currentLine, $start, $len);
            $start += $len;
        }
        array_push($this->records, $record);
        $this->recordCount++;
    }
}