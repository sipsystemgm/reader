<?php

namespace Sip\Reader;

class ReadFromFile implements \Iterator
{
    public const ERROR_TEXT = "Can't find file [%s]";
    private $fileHandler = null;
    private $key;
    private $current;
    private $fileName;
    private int $bufferLength;

    public function __construct(string $fileName, int $bufferLength = 65)
    {
        $this->bufferLength = $bufferLength;
        try {
            $this->fileHandler = fopen($fileName, "r");
            $this->fileName = $fileName;
            $this->key = 0;
        } catch (\Exception $exception) {
            throw new \Exception(sprintf(self::ERROR_TEXT, $fileName));
        }
    }

    public function __destruct()
    {
        fclose($this->fileHandler);
    }

    public function current()
    {
        if ($this->valid()) {
            $this->current = fread($this->fileHandler, $this->bufferLength);
        }

        return $this->current;
    }

    public function next()
    {
        $this->key++;
    }

    public function key()
    {
        return $this->key;
    }

    public function valid()
    {
        return !feof($this->fileHandler);
    }

    public function rewind()
    {
        $this->__destruct();
        $this->__construct($this->fileName);
    }

}