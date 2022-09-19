<?php
/**
 * TODO
 *  Open web/airports.php file
 *  Go through all airports in a loop and INSERT airports/cities/states to equivalent DB tables
 *  (make sure, that you do not INSERT the same values to the cities and states i.e. name should be unique i.e. before INSERTing check if record exists)
 */

/** @var \PDO $pdo */
require_once './pdo_ini.php';

foreach (require_once('../web/airports.php') as $item) {
    // Cities
    // To check if city with this name exists in the DB we need to SELECT it first
    $query = $pdo->prepare('SELECT id FROM cities WHERE name = :name');
    $query->setFetchMode(\PDO::FETCH_ASSOC);
    $query->execute(['name' => $item['city']]);
    $city = $query->fetch();

    // If result is empty - we need to INSERT city
    if (!$city) {
        $query = $pdo->prepare('INSERT INTO cities (name) VALUES (:name)');
        $query->execute(['name' => $item['city']]);

        // We will use this variable to INSERT airport
        $cityId = $pdo->lastInsertId();
    } else {
        // We will use this variable to INSERT airport
        $cityId = $city['id'];
    }

    // TODO States
    $query = $pdo->prepare('SELECT `id` FROM `states` WHERE `name` = :name;');
    $query->execute(['name' => $item['state']]);
    $state = $query->fetch();

    if (!$state) {
        $query = $pdo->prepare('INSERT INTO `states` (`name`) VALUES (:name);');
        $query->execute(['name' => $item['state']]);

        $item['cityId'] = $pdo->lastInsertId();
    } else {
        $item['stateId'] = $state['id'];
    }

    // TODO Airports
    $query = $pdo->prepare("INSERT INTO `airports` (`name`, `code`, `city_id`, `state_id`, `address`, `timezone`) VALUES (:name, :code, :cityId, :stateId, :address, :timezone);");
    $query->execute([
        'name' => $item['name'],
        'code' => $item['code'],
        'cityId' => $item['cityId'],
        'stateId' => $item['stateId'],
        'address' => $item['address'],
        'timezone' => $item['timezone']
    ]);
}