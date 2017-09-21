<?php

namespace QMVC\Base\Tests\HTTPContext;

use PHPUnit\Framework\TestCase;

use QMVC\Base\HTTPContext\FileResponse;

class FileResponseTest extends TestCase
{
    protected $dummyFile = null;
    protected $dummyFileSize = 1048576;
    protected $dummyFileName = 'dummy.dat';

    protected function setUp()
    {
        $fp = fopen($this->dummyFileName, 'w');
        fseek($fp, $this->dummyFileSize - 2,SEEK_CUR);
        fwrite($fp,'\0');
        fclose($fp);
    }

    protected function tearDown()
    {
        unlink($this->dummyFileName);
    }

    public function testConstructor()
    {
        $this->assertTrue(is_a(new FileResponse('', 0), FileResponse::class));
    }

    public function testIsLimitedDefault()
    {
        $response = new FileResponse('');
        $this->assertFalse($response->isLimited());
    }

    public function testIsLimitedSetLimit()
    {
        $response = new FileResponse('', 200);
        $this->assertTrue($response->isLimited());
    }

    public function testSetLimit()
    {
        $limit = 210.0;
        $response = new FileResponse('');
        $response->setDownloadLimit($limit);
        $this->assertTrue($response->isLimited() && $response->getDownloadLimit() === $limit);
    }

    public function testGetFileName()
    {
        $filename = '/dir1/dir2/dir3/file.txt';
        $response = new FileResponse($filename);
        $this->assertTrue(basename($filename) === $response->getFileName());
    }

    public function testGetFileSize()
    {
        $response = new FileResponse($this->dummyFileName);
        echo $response->getFileSize();
        $this->assertTrue($response->getFileSize() === $this->dummyFileSize);
    }
}

?>