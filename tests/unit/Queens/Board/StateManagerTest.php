<?php

class StateManagerTest extends \PHPUnit\Framework\TestCase
{
    public function testAddBoard()
    {
        $stateManager = new \Queens\Board\StateManager();
        $board = new \Queens\Board\Board();

        $stateManager->addBoard($board);
        $this->assertSame($stateManager->getBoard(), $board);
    }

    public function testRevertState()
    {
        $stateManager = new \Queens\Board\StateManager();
        $board1 = new \Queens\Board\Board(size: 6);
        $board2 = new \Queens\Board\Board(size: 7);

        $stateManager->addBoard($board1)->addBoard($board2);
        $this->assertEquals($stateManager->getBoard(), $board2);

        $stateManager->revertState();
        $this->assertEquals($stateManager->getBoard(), $board1);
    }

    public function testCloneBoard()
    {
        $stateManager = new \Queens\Board\StateManager();
        $board = new \Queens\Board\Board(size: 6);

        $stateManager->addBoard($board);

        $this->assertEquals($stateManager->cloneBoard(), $board);
    }

    public function testCountStates()
    {
        $stateManager = new \Queens\Board\StateManager();
        $board1 = new \Queens\Board\Board(size: 6);
        $board2 = new \Queens\Board\Board(size: 7);
        $board3 = new \Queens\Board\Board(size: 8);

        $stateManager->addBoard(board: $board1)
            ->addBoard(board: $board2)
            ->addBoard(board: $board3);

        $this->assertEquals($stateManager->countStates(), 3);
    }
}
