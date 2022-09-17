<?php
/**
 * Connect to DB
 */

/**
 * SELECT the list of unique first letters using https://www.w3resource.com/mysql/string-functions/mysql-left-function.php
 * and https://www.w3resource.com/sql/select-statement/queries-with-distinct.php
 * and set the result to $uniqueFirstLetters variable
 */
require_once './pdo_ini.php';

const PAGE_SIZE = 20;

$airportsSql = 'SELECT a.`name`, `code`, c.`name` as city_name, s.`name` as state_name, `address`, `timezone` ';
$from = <<<SQL
        FROM `airports` a
            JOIN `cities` c ON a.`city_id` = c.`id`
            JOIN `states` s ON a.`state_id` = s.`id`
    SQL;
$filterByFirstLetter = '';
$filterByState = '';
$sort = '';

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 *
 * For filtering by first_letter use LIKE 'A%' in WHERE statement
 * For filtering by state you will need to JOIN states table and check if states.name = A
 * where A - requested filter value
 */
if (isset($_GET['filter_by_first_letter'])) {
    $filterByFirstLetter .= " WHERE a.`name` LIKE '" . $_GET['filter_by_first_letter'] . "%'";
}
if (isset($_GET['filter_by_state'])) {
    $filterByState = (!$filterByFirstLetter) ? ' WHERE ' : ' AND ';
    $filterByState .= " s.`name` = '" . $_GET['filter_by_state'] . "'";
}
// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 *
 * For sorting use ORDER BY A
 * where A - requested filter value
 */
if (isset($_GET['sort'])) {
    $sort = ' ORDER BY `' . $_GET['sort'] . '` ASC';
}
// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 *
 * For pagination use LIMIT
 * To get the number of all airports matched by filter use COUNT(*) in the SELECT statement with all filters applied
 */
$_GET['page'] = (isset($_GET['page']) && is_numeric($_GET['page']) && ($_GET['page'] > 0)) ? $_GET['page'] : 1;
$pagesSql = 'SELECT COUNT(*) ' . $from . $filterByFirstLetter . $filterByState;
$sth = $pdo->query($pagesSql);
$sth->bindColumn(1, $pages);
$sth->fetch();
$pages = round($pages / PAGE_SIZE);
$currentPage = ' LIMIT ' . PAGE_SIZE * ($_GET['page'] - 1) . ', ' . PAGE_SIZE;
/**
 * Build a SELECT query to DB with all filters / sorting / pagination
 * and set the result to $airports variable
 *
 * For city_name and state_name fields you can use alias https://www.mysqltutorial.org/mysql-alias/
 */
$airportsSql .= $from . $filterByFirstLetter . $filterByState . $sort . $currentPage . ';';
$sth = $pdo->query($airportsSql);
$airports = $sth->fetchAll(\PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
    -->
    <div class="alert alert-dark">
        Filter by first letter:

        <?php
        foreach ($uniqueFirstLetters as $letter): ?>
            <a href="<?= $_SERVER["PHP_SELF"] . "?" . http_build_query(array_merge($_GET, ["page" => 1, "filter_by_first_letter" => $letter])); ?>"><?= $letter ?></a>
        <?php endforeach; ?>
        <a href="/" class="float-right">Reset all filters</a>
    </div>

    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
    -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="<?= $_SERVER["PHP_SELF"] . "?" . http_build_query(array_merge($_GET, ["sort" => "name"])); ?>">Name</a></th>
            <th scope="col"><a href="<?= $_SERVER["PHP_SELF"] . "?" . http_build_query(array_merge($_GET, ["sort" => "code"])); ?>">Code</a></th>
            <th scope="col"><a href="<?= $_SERVER["PHP_SELF"] . "?" . http_build_query(array_merge($_GET, ["sort" => "state_name"])); ?>">State</a></th>
            <th scope="col"><a href="<?= $_SERVER["PHP_SELF"] . "?" . http_build_query(array_merge($_GET, ["sort" => "city_name"])); ?>">City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <!--
            Filtering task #2
            Replace # in HREF so that link follows to the same page with the filter_by_state key
            i.e. /?filter_by_state=A or /?filter_by_state=B

            Make sure, that the logic below also works:
             - when you apply filter_by_state the page should be equal 1
             - when you apply filter_by_state, than filter_by_first_letter (see Filtering task #1) is not reset
               i.e. if you have filter_by_first_letter set you can additionally use filter_by_state
        -->
        <?php
        foreach ($airports as $airport): ?>
            <tr>
                <td><?= $airport['name'] ?></td>
                <td><?= $airport['code'] ?></td>
                <td><a href="<?= $_SERVER["PHP_SELF"] . "?" . http_build_query(array_merge($_GET, ['filter_by_state' => $airport['state_name'], 'page' => 1])); ?>"><?= $airport['state_name'] ?></a></td>
                <td><?= $airport['city_name'] ?></td>
                <td><?= $airport['address'] ?></td>
                <td><?= $airport['timezone'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!--
        Pagination task
        Replace HTML below so that it shows real pages dependently on number of airports after all filters applied

        Make sure, that the logic below also works:
         - show 5 airports per page
         - use page key (i.e. /?page=1)
         - when you apply pagination - all filters and sorting are not reset
    -->
    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">
            <?php
            for ($i = 1; $i <= $pages; $i++): ?>
                <li class="page-item <?php
                if ($_GET['page'] == $i): ?> active <?php
                endif; ?>">
                    <a class="page-link"
                       href="<?= $_SERVER["PHP_SELF"] . "?" . http_build_query(array_merge($_GET, ["page" => $i])); ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

</main>
</html>
