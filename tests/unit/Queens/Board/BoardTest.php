<?php

class BoardTest extends \PHPUnit\Framework\TestCase
{
    public function testGetPosX()
    {
        $board = new \Queens\Board\Board(size: 7);

        $this->assertEquals($board->getPosX(), -1);
    }

    public function testGetPosY()
    {
        $board = new \Queens\Board\Board(size: 7);

        $this->assertEquals($board->getPosY(), -1);
    }

    public function testGetSize()
    {
        $board = new \Queens\Board\Board(size: 7);

        $this->assertEquals($board->getSize(), 7);
    }

    public function testGetQueens()
    {
        $board = new \Queens\Board\Board(size: 7);

        $this->assertEquals(count($board->getQueens()), 7);
        $this->assertEquals(count($board->getQueens()[0]), 7);
    }

    public function testGetValidMoves()
    {
        $board = new \Queens\Board\Board(size: 7);

        $this->assertEquals(count($board->getValidMoves()), 7);
        $this->assertEquals(count($board->getValidMoves()[0]), 7);
    }

    public function testInvalidateMove()
    {
        $board = new \Queens\Board\Board(size: 7);
        $x = 4;
        $y = 2;
        
        $board->invalidateMove(x: $x, y: $y);

        $this->assertEquals($board->getValidMoves()[$y][$x], 0);
    }

    public function testFindValidMove()
    {
        $board = new \Queens\Board\Board(size: 7);

        $this->assertEquals($board->findValidMove(), (object) ['x' => 0, 'y' => 0]);
    }

    public function getMethod($name) {
        $class = new ReflectionClass("\Queens\Board\Board");
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testIsDiagonal()
    {
        $isDiagonal = self::getMethod('isDiagonal');
        $board = new \Queens\Board\Board(size: 7);
        $this->assertTrue($isDiagonal->invokeArgs($board, [4, 4, 2, 2]));
        $this->assertFalse($isDiagonal->invokeArgs($board, [4, 4, 2, 1]));
    }

    public function testIsValidMove()
    {
        $board = new \Queens\Board\Board(size: 7);

        $this->assertTrue($board->isValidMove(x: 0, y: 0));
    }

    public function testAddQueen()
    {
        $board = new \Queens\Board\Board(size: 7);
        $x = 4;
        $y = 2;

        $this->assertFalse( $board->getQueens()[$y][$x] === 1 );

        $board->addQueen($x, $y);
        
        $this->assertTrue( $board->getQueens()[$y][$x] === 1 );
    }
}
