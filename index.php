<?php

/**
 * Display all "7 Queens" solutions on screen, either in browser or in console.
 * For PHP CLI: "php index.php"
 *
 * PHP version: 8.2+
 * Tested with PHP version 8.2.15
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
$queensSolver->setBoard(new Board(size: $boardSize));

// Add the board state manager to the Queens problem solver
$queensSolver->setStateManager(new StateManager());

// Retrieve all possible solutions from the Queens problem solver
$solutions = $queensSolver->getAllSolutions();

// Display all found solutions and total number of solutions
// On these boards, 0 is an empty spot and 1 is a queen piece
echo '<pre>' . PHP_EOL;
echo 'Solutions (0 is an empty spot, 1 is a queen piece):' . PHP_EOL;

foreach ($solutions as $boardRows) {
    echo '---' . PHP_EOL;

    $boardOutput = array_reduce($boardRows, function(string $boardOutput, array $boardRow): string {
        $boardOutput .= implode('', $boardRow) . PHP_EOL;
        return $boardOutput;
    }, '');

    echo $boardOutput;
}

echo '---' . PHP_EOL;
echo 'Total of ' . count($solutions) . ' unique solutions found for board size: ';
echo $boardSize . '!' . PHP_EOL;
