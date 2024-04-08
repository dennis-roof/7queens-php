<?php

class BoardFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateBoard()
    {
        $factoryBoard = \Queens\Board\BoardFactory::createBoard();
        $board = new \Queens\Board\Board();

        $this->assertEquals($factoryBoard, $board);
    }
}
