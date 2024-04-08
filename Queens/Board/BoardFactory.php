<?php

/**
 * PHP version 8.2+
 *
 * @package Queens\Board\BoardFactory
 * @author  Dennis Roof <dennis.roof.it@gmail.com>
 */

namespace Queens\Board;

/**
 * Board factory for requesting new Board instances.
 */
class BoardFactory
{
    /**
     * Create a new Board instance
     *
     * @return Board New board instance.
     */
    public static function createBoard(): Board
    {
        return new Board();
    }
}
