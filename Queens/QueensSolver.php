<?php

/**
 * PHP version 8.2+
 *
 * @package Queens\QueensSolver
 * @author  Dennis Roof <dennis.roof.it@gmail.com>
 */

namespace Queens;

use Queens\Board\{Board, StateManager};

/**
 * Uses the simplest queens problem strategy I could think of:
 * - Place queens on the board until all valid moves are taken.
 * - If no solution found: revert move, mark move as invalid and try again.
 * - If solution is found: store solution and pretend no solution was found
 *   to trick the solver into finding all solutions.
 */
class QueensSolver
{
    /**
     * Initial chess board
     */
    protected ?Board $board = null;
    
    /**
     * State manager for adding and reverting queen moves
     */
    protected ?StateManager $stateManager = null;
    
    /**
     * Set the initial board, including the board size
     *
     * @param Board $board The initial chess board without queen pieces.
     *
     * @return QueenSolver This solver with the board instance added.
     */
    public function setBoard(Board $board): QueensSolver
    {
        $this->board = $board;
        
        return $this;
    }
    
    /**
     * Set the state manager, so we can add and revert queen moves
     *
     * @param StateManager $stateManager The state manager for all queen moves.
     *
     * @return QueenSolver This solver with the state manager added.
     */
    public function setStateManager(StateManager $stateManager): QueensSolver
    {
        $this->stateManager = $stateManager;
        
        return $this;
    }
    
    /**
     * Each state in the state manager represents a queen move on the board.
     * So when the number of states equals the board size, a solution is found.
     * For example: 7 queen moves on a board size 7.
     *
     * @return bool Is problem solved, true or false.
     */
    protected function isSolved(): bool
    {
		if ($this->stateManager === null) {
			// If state manager is not set, break loop with "true" response
			return true;
		}

        $numberOfQueenPieces = ($this->stateManager->countStates() - 1);
        $boardSize = $this->stateManager->getBoard()->getSize();
        
        return ($numberOfQueenPieces === $boardSize);
    }
    
    /**
     * Find all solutions for the queens problem using the strategy described above.
     *
     * @return array An array of 2D boards with all solutions.
     */
    public function getAllSolutions(): array
    {
		if ($this->stateManager === null || $this->board === null) {
			return [];
		}

        // Storage for all solutions
        $solutions = [];
        
        // Add the initial board state (no queens)
        $this->stateManager->addBoard(board: $this->board);
        
        while (true) {
            // If the state manager no longer has any boards, break
            $board = $this->stateManager->getBoard();

            if ($board->isEmpty()) {
                break;
            }
            
            // When a unique solution is found, store this solutions
            if ($this->isSolved() && ! in_array($board->getQueens(), $solutions)) {
                $solutions[] = $board->getQueens();
            }
            
            // Find a valid move for the next queen piece
            $move = $board->findValidMove();
            
            // Either when no valid moves are found or a solution is found
            if (! $board->isValidMove(x: $move->x, y: $move->y) || $this->isSolved()) {
                do {
                    // Remember this wrong solution for the queen position
                    $wrongBoard = $this->stateManager->getBoard();
                    
                    // Revert the queen move
                    $board = $this->stateManager->revertState()->getBoard();
                    if ($board->isEmpty()) {
                        break;
                    }
                    
                    // Invalidate the queen move from the wrong solution
                    $this->stateManager->getBoard()->invalidateMove(
                        x: $wrongBoard->getPosX(),
                        y: $wrongBoard->getPosY()
                    );
                    
                    // Now find the next valid move, excluding the previous wrong one
                    $move = $board->findValidMove();
                } while (! $board->isValidMove(x: $move->x, y: $move->y));
            }
            
            // If valid move is found, add the board with queen to the state manager
            if ($board->isValidMove(x: $move->x, y: $move->y)) {
                $board = $this->stateManager->cloneBoard();
                $this->stateManager->addBoard(board: $board->addQueen(posX: $move->x, posY: $move->y));
            }
        }
        
        // Return all found solutions
        return $solutions;
    }
}
