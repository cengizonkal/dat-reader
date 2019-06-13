<?php

namespace Conkal\DatReader;


class Reader
{
    private $filePointer;
    private $filename;
    private $recordCount = 0;
    private $template = [];
    private $encoding = 'utf-8';


    /**
     * Reader constructor.
     * @param $filename
     * @param array $template
     * @param string $encoding
     */
    public function __construct($filename, array $template, $encoding = 'utf-8')
    {
        $this->filename = $filename;
        $this->encoding = $encoding;
        $this->template = $template;
    }


    public function read($trim = true)
    {
        $line = mb_convert_encoding(fgets($this->filePointer), 'utf-8', $this->encoding);
        if ($line) {
            return $this->parseItem($line, $trim);
        }
        return false;
    }

    public function each($function)
    {
        while ($record = $this->read()) {
            $function($record);
        }
    }


    public function open()
    {
        if (!$this->filePointer) {
            $this->filePointer = fopen($this->filename, 'r');
        }
    }

    public function close()
    {
        fclose($this->filePointer);
        $this->filePointer = null;
    }


    private function parseItem($line, $trim)
    {
        $record = [];
        $start = 0;
        foreach ($this->template as $key => $len) {
            $record[$key] = $trim ? trim(mb_substr($line, $start, $len)) : mb_substr($line, $start, $len);
            $start += $len;
        }
        $this->recordCount++;
        return $record;

    }
}