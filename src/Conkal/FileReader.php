<?php

namespace Conkal;

use Conkal\Exceptions\FileNotSetException;
use Conkal\Exceptions\TemplateNotSetException;

class FileReader
{
    private $fp;
    private $file;
    private $line;
    private $lineCount = 0;
    private $template = [];
    private $records = [];


    public function __construct($file = null)
    {
        $this->file = $file;
    }


    public function read($limit = null)
    {
        if (!$this->file) {
            throw new FileNotSetException();
        }
        if (!$this->template) {
            throw new TemplateNotSetException();
        }

        $this->openFile();
        while ($this->line = fgets($this->fp)) {
            $record = new \stdClass();
            $start = 0;
            foreach ($this->template as $key => $len) {
                $record->{$key} = substr($this->line, $start, $len);
                $start += $len;
            }
            array_push($this->records, $record);
        }
        return $this->records;
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
}