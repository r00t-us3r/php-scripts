<?php

startSession();

function checkActiveUsers() {
    $queue = json_decode(file_get_contents('data/queue.json'), true);
    if (!isset($queue['activeUsers'][session_id()]) && (count($queue['activeUsers']) >= (int)$queue['totalSpaces'])) {
        exit ("Please wait in the queue for an available space");
    } else {
        storeVisitor();
    }
}

function storeVisitor() {
    $queue = json_decode(file_get_contents('data/queue.json'), true);
    if (!isset($queue['activeUsers'][session_id()])) {
        $queue['activeUsers'][session_id()] = [
            'lastActive' => time()
        ];
    } else {
        $queue['activeUsers'][session_id()]['lastActive'] = time();
    }
    file_put_contents('data/queue.json', json_encode($queue));
}

function isPost()
{
    return ($_SERVER['method'] === 'POST');
}

function startSession()
{
    if (session_id() === "") {
        session_start();
    }
    echo "Your session id is " . session_id() . "\r\n<br />";
    checkActiveUsers();
}