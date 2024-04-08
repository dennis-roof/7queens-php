<?php

/**
 * PHP version 8.2+
 *
 * @package Queens\Board\StateManager
 * @author  Dennis Roof <dennis.roof.it@gmail.com>
 */

namespace Queens\Board;

/**
 * Board state manager for adding and reverting queen moves.
 */
class StateManager
{
    /**
     * Array with all boards, each board represent a queen move.
     */
    protected $boards = [];
    
    /**
     * Add a board with the next queen piece.
     *
     * @param Board $board Board to be added to the state manager.
     *
     * @return StateManager This state manager with the board instance added.
     */
    public function addBoard(Board $board): StateManager
    {
        array_push($this->boards, $board);
        
        return $this;
    }
    
    /**
     * Revert the last board move.
     *
     * @return StateManager This state manager with the reverted state.
     */
    public function revertState(): StateManager
    {
        array_pop($this->boards);
        
        return $this;
    }
    
    /**
     * Get the current board
     *
     * @return Board The current (latest) board with all the queen moves done so far.
     */
    public function getBoard(): Board
    {
        if (count($this->boards) > 0) {
            return end($this->boards);
        }
        
        return BoardFactory::createBoard();
    }
    
    /**
     * Clone the current board for the next queen move.
     *
     * @return Board Clone of the current board, to modify for the next queen move.
     */
    public function cloneBoard(): Board
    {
        return clone end($this->boards);
    }
    
    /**
     * Count number of boards in the state manager, this equals the number of moves.
     *
     * @return int Number of board states = total number of queen moves on the board.
     */
    public function countStates(): int
    {
        return count($this->boards);
    }
}
