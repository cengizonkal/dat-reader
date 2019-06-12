<?php

namespace DatReader;

use DatReader\Exceptions\FileNotSetException;
use DatReader\Exceptions\TemplateNotSetException;

class Reader
{
    private $filePointer;
    private $filename;
    private $recordCount = 0;
    private $template = [];


    /**
     * Reader constructor.
     * @param $filename
     * @param array $template
     * @throws FileNotSetException
     * @throws TemplateNotSetException
     */
    public function __construct($filename, array $template)
    {
        $this->filename = $filename;
        $this->setTemplate($template);
        $this->openFile();
    }


    public function read()
    {
        $line = fgets($this->filePointer);
        if ($line) {
            return $this->readRecord($line);
        }
        return false;


    }

    public function each($function)
    {
        while ($line = fgets($this->filePointer)) {
            $record = $this->readRecord($line);
            $function($record);
        }
    }

    public function setTemplate(array $template)
    {
        if (!$template) {
            throw new TemplateNotSetException();
        }
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
        if (!$this->filename) {
            throw new FileNotSetException();
        }
        if (!$this->filePointer) {
            $this->filePointer = fopen($this->filename, 'r');
        }
    }

    public function closeFile()
    {
        fclose($this->filePointer);
        $this->filePointer = null;
    }


    private function readRecord($line)
    {
        $record = new \stdClass();
        $start = 0;
        foreach ($this->template as $key => $len) {
            $record->{$key} = substr($line, $start, $len);
            $start += $len;
        }
        $this->recordCount++;
        return $record;

    }
}