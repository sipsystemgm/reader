<?php
namespace Sip\Reader\Test;

use PHPUnit\Framework\TestCase;
use Sip\Reader\ReadFromFile;

class ReaderFromFileTest extends TestCase
{
    public function testReadFile(): void
    {
        foreach ($this->getReader() as $item) {
            $this->assertNotEmpty($item);
        }
    }

    public function testFileNotFoundException(): void
    {
        $fileName = 'someFile.txt';
        try {
            $this->getReader($fileName);
        } catch (\Exception $exception) {
            $this->assertEquals(
                $exception->getMessage(),
                sprintf(ReadFromFile::ERROR_TEXT, $this->getPath($fileName))
            );
        }
    }

    private function getReader(string $fileName = 'test-data.html'): \Iterator
    {
        return new ReadFromFile($this->getPath($fileName));
    }

    private function getPath(string $fileName): string
    {
        return __DIR__.'/data/'.$fileName;
    }
}
