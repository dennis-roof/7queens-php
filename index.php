<?php

/**
 * Display all "7 Queens" solutions on screen, either in browser or in console.
 * For PHP CLI: "php index.php"
 *
 * PHP version: 7.1+
 * Tested with PHP version 7.3.9
 *
 * @author Dennis Roof <dennis.roof.it@gmail.com>
 */

// Simplified PSR-4 Autoloader
spl_autoload_register(
    function ($className) {
        include str_replace('\\', '/', $className) . '.php';
    }
);

use Queens\QueensSolver;
use Queens\Board\{Board, StateManager};

// Set board size, the Queens problem solver will attempt find solutions for any size
$boardSize = 7;

// Initiate the Queens problem solver
$queensSolver = new QueensSolver();

// Add the chess board to the Queens problem solver
$queensSolver->setBoard(new Board($boardSize));

// Add the board state manager to the Queens problem solver
$queensSolver->setStateManager(new StateManager());

// Retrieve all possible solutions from the Queens problem solver
$solutions = $queensSolver->getAllSolutions();

// Display all found solutions and total number of solutions
// On these boards, 0 is an empty spot and 1 is a queen piece
echo '<pre>' . PHP_EOL;
echo 'solutions (0 is an empty spot, 1 is a queen piece):' . PHP_EOL;

foreach ($solutions as $board) {
    echo '---' . PHP_EOL;
    for ($row = 0; $row < count($board); $row++) {
        echo implode('', $board[$row]) . PHP_EOL;
    }
}

echo '---' . PHP_EOL;
echo 'Total of ' . count($solutions) . ' unique solutions found for board size: ';
echo $boardSize . PHP_EOL;
