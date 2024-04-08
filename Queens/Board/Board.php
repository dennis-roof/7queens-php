<?php

/**
 * PHP version 8.2+
 *
 * @package Queens\Board\Board
 * @author  Dennis Roof <dennis.roof.it@gmail.com>
 */

namespace Queens\Board;

/**
 * Board with information about size, queen pieces and valid moves for the next queen
 */
class Board
{
    /**
     * X and Y position of the latest queen piece added to the board.
     */
    protected int $posX = -1;
    protected int $posY = -1;

    /**
     * Board size
     */
    protected int $size = 0;

    /**
     * Board with the queen pieces.
     */
    protected array $board = [];

    /**
     * Board with all remaining valid moves for the next queen piece.
     */
    protected array $validMoves = [];

    /**
     * Create a new board with a given board size.
     *
     * @param int $size Size of the board.
     */
    public function __construct(int $size = 0)
    {
        if ($size <= 0) {
            return;
        }

        $this->size = $size;
        
        // On the board, 0 is an empty spot and 1 is a queen piece
        $this->board = $this->generateBoard(boardSize: $size, filler: 0);
        
        // On the valid moves map, 0 is an invalid move and 1 is a valid move
        $this->validMoves = $this->generateBoard(boardSize: $size, filler: 1);
    }

    /**
     * 2D board generator for the queen pieces and valid moves.
     *
     * @param int $boardSize Size of the board to generated.
     * @param int $filler    Integer value to fill the entire board with.
     *
     * @return array Generated 2D board with specific size and filler values.
     */
    protected function generateBoard(int $boardSize, int $filler): array
    {
        return array_fill(0, $boardSize, array_fill(
            0, $boardSize, $filler)
        );
    }

    /**
     * Check if this board is empty, board size 0 is empty.
     *
     * @return bool Is this board empty, true or false.
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * Get the latest queen piece X coordinate.
     *
     * @return int X coordinate of latest queen piece.
     */
    public function getPosX(): int
    {
        return $this->posX;
    }


    /**
     * Get the latest queen piece Y coordinate.
     *
     * @return int Y coordinate of latest queen piece.
     */
    public function getPosY(): int
    {
        return $this->posY;
    }

    /**
     * Get the board size.
     *
     * @return int Size of this board.
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Get the 2D board with the queen pieces.
     *
     * @return array 2D board showing all the queen pieces.
     */
    public function getQueens(): array
    {
        return $this->board;
    }

    /**
     * Get the 2D board with the valid moves for the next queen piece.
     *
     * @return array 2D board showing all remaining valid moves for the next queen.
     */
    public function getValidMoves(): array
    {
        return $this->validMoves;
    }

    /**
     * Manually invalidate a specific move for the next queen piece.
     *
     * @param int $x X-coordinate of the move to invalidate.
     * @param int $y Y-coordinate of the move to invalidate.
     *
     * @return Board This board with the specified move invalidated.
     */
    public function invalidateMove(int $x, int $y): Board
    {
        $this->validMoves[$y][$x] = 0;
        
        return $this;
    }

    /**
     * Find a valid move for the next queen piece.
     *
     * @return object Standard object with 'x' and 'y' properties for the next move.
     */
    public function findValidMove(): object
    {
        for ($y = 0; $y < count($this->validMoves); $y++) {
            for ($x = 0; $x < count($this->validMoves[$y]); $x++) {
                if ($this->validMoves[$y][$x] === 1) {
                    return (object) ['x' => $x, 'y' => $y];
                }
            }
        }
        
        // Return a negative (invalid) coordinate if no valid moves are found
        return (object) ['x' => -1, 'y' => -1];
    }

    /**
     * Check if two X and Y coordinates have a diagonal intersection.
     *
     * @param int $x1 First move X-coordinate.
     * @param int $y1 First move Y-coordinate.
     * @param int $x2 Second move X-coordinate.
     * @param int $y2 Second move Y-coordinate.
     *
     * @return bool Do the first and second move intersect diagonally, true or false.
     */
    protected function isDiagonal(int $x1, int $y1, int $x2, int $y2): bool
    {
        return (abs($x1 - $x2) === abs($y1 - $y2));
    }

    /**
     * Check if a specific move is a valid move on the board.
     *
     * @param int $x X-coordinate of the move to validate.
     * @param int $y Y-coordinate of the move to validate.
     *
     * @return bool Is this move valid, true or false.
     */
    public function isValidMove(int $x, int $y): bool
    {
        return ($x !== -1 && $y !== -1);
    }

    /**
     * Add the next queen piece, update the board accordingly.
     *
     * @param int $posX X-coordinate of this next queen piece on the board.
     * @param int $posY Y-coordinate of this next queen piece on the board.
     *
     * @return Board This board updated with the added queen piece.
     */
    public function addQueen(int $posX, int $posY): Board
    {
        // Update the queen piece coordinates
        $this->posX = $posX;
        $this->posY = $posY;
        
        // Add the queen piece to the board
        $this->board[$posY][$posX] = 1;
        
        // Update the valid moves map for the new queen piece
        for ($y = 0; $y < count($this->validMoves); $y++) {
            for ($x = 0; $x < count($this->validMoves[$y]); $x++) {
                // Ignore already invalid moves
                if ($this->validMoves[$y][$x] === 0) {
                    continue;
                }
                
                // Mark horizontal, vertical and diagonal moves as invalid
                if ($x === $posX
                    || $y === $posY
                    || $this->isDiagonal(x1: $posX, y1: $posY, x2: $x, y2: $y)
                ) {
                    $this->validMoves[$y][$x] = 0;
                }
            }
        }
        
        return $this;
    }
}
