<?php

namespace QMVC\Base\Tests\HTTPContext;

use PHPUnit\Framework\TestCase;

use QMVC\Base\HTTPContext\FileUpload;

/**
* TODO: NEED TO MOCK FILE UPLOAD TO TEST
*/

class FileUploadTest extends TestCase
{
    protected $dummyFileName = 'dummy.dat';

    protected function setUp()
    {
        $fp = fopen($this->dummyFileName, 'w');
        fseek($fp,  1024 - 2,SEEK_CUR);
        fwrite($fp,'\0');
        fclose($fp);
        $_POST[$this->dummyFileName] = $this->dummyFileName;
    }

    protected function tearDown()
    {
        unlink($this->dummyFileName);
    }

    public function testConstructor()
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $fileMimeType = $finfo->file($this->dummyFileName);
        $upload = new FileUpload($this->dummyFileName, '', 1024);
        $this->assertTrue(is_a($upload, FileUpload::class));
    }

    public function testGetUploadErrors()
    {
        $upload = new FileUpload('randomefilename.dat', '', 0);
        $this->assertTrue(count($upload->getUploadErrors()) > 0);
    }
}