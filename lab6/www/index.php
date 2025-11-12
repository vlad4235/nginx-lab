<?php
require 'vendor/autoload.php';

use App\RedisExample;
use App\ElasticExample;
use App\ClickhouseExample;

echo '<h1>🔍 NoSQL Лабораторная работа</h1>';

try {
    // Redis примеры
    echo '<h2>🔴 Redis</h2>';
    \ = new RedisExample();
    echo '<p>' . \->setValue('user:101', ['name' => 'Alice', 'age' => 25]) . '</p>';
    echo '<p>' . \->getValue('user:101') . '</p>';

    // Elasticsearch примеры
    echo '<h2>🔍 Elasticsearch</h2>';
    \ = new ElasticExample();
    echo '<p>' . \->createIndex('books') . '</p>';
    echo '<p>' . \->indexDocument('books', 1, [
        'title' => '1984', 
        'author' => 'George Orwell',
        'year' => 1949
    ]) . '</p>';
    echo '<p>' . \->search('books', [
        'match' => ['author' => 'Orwell']
    ]) . '</p>';

    // ClickHouse примеры
    echo '<h2>⚡️ ClickHouse</h2>';
    \ = new ClickhouseExample();
    echo '<p>' . \->createTable('test_table') . '</p>';
    echo '<p>' . \->query('INSERT INTO test_table VALUES (1, \"Test User\", now())') . '</p>';
    echo '<p>' . \->query('SELECT count() FROM system.tables') . '</p>';
    echo '<p>' . \->query('SELECT * FROM test_table') . '</p>';

} catch (Exception \) {
    echo '<p style=\"color: red;\">❌ Ошибка: ' . \->getMessage() . '</p>';
}
