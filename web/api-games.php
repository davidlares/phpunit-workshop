<?php

require __DIR__ . "/../src/Repository/GameRepository.php";
// request body
$request_body = json_decode(file_get_contents('php://input'), true);
// sanitizing user
$clean = [];
$clean['user'] = filter_var($request_body['user'], FILTER_SANITIZE_NUMBER_INT);
// new Repository instance
$repo = new GameRepository();
// find by Id user
$games = $repo->findByUserId($clean['user']);
// iterating
$data = [];
foreach ($games as $game) {
    $data[] = $game->toArray();
}
// adding header 
header('Content-Type: application/json');
echo json_encode([
    'data' => $data,
]);
