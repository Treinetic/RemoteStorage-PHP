<?php
/**
 * Created by PhpStorm.
 * User: Hasitha Mapalagama (dev.hasitha@gmail.com)
 * Date: 3/19/18
 * Time: 10:58 AM
 */

class STTest extends \PHPUnit_Framework_TestCase
{
    private $st;

    protected function setUp()
    {
        $this->st = new \Treinetic\RStorage\StorageClient(
            "--",
            "--",
            "--");
    }

    public function testMakeDirectory(){
        $result = $this->st->makeDirectory("composertest");
        $result2 = $this->st->makeDirectory("composertest2");
        assert($result, "make directory failed");
        assert($result2, "make directory failed");
    }

    public function testStore(){
       $result = $this->st->put('./test/img.jpg', 'composertest', 'my.jpg');
       assert($result, "make directory failed");
    }

    public function testGet(){
        $result = $this->st->get('/composertest/my.jpg');
        file_put_contents('test.jpg', $result);
    }

    public function testCopy(){
        $result = $this->st->copy('/composertest/my.jpg', '/composertest2/copy.jpg');
        assert($result, "copy failed");
    }

    public function testMove(){
        $result = $this->st->move('/composertest/my.jpg', '/composertest2/move.jpg');
        assert($result, "copy failed");
    }

    public function testExist(){
        $result = $this->st->exists('/composertest2/move.jpg');
        assert($result, "copy failed");
    }
    public function testDelete(){
        $result = $this->st->delete('/composertest');
        assert($result, "composertest delete failed");
        $result = $this->st->delete('/composertest2/copy.jpg');
        assert($result, "/composertest2/copy.jpg delete failed");
        $result = $this->st->delete('/composertest2');
        assert($result, "/composertest2 delete failed");
    }

}