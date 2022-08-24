<?php
/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  array  $airports
 * @return string[]
 */
function getUniqueFirstLetters(array $airports): array
{
    $firstLetters = [];

    foreach ($airports as $airport) {
        $firstLetters[] = $airport['name'][0];
    }

    sort($firstLetters);

    return array_unique($firstLetters);
}

/**
 * @param array $airports
 * @param string $filterByFirstLetter
 * @return array
 */
function filterByFirstLetter(array $airports, string $filterByFirstLetter): array
{
    $airportsByLetter = [];

    foreach ($airports as $airport) {
        if ($airport['name'][0] == $filterByFirstLetter) {
            $airportsByLetter[] = $airport;
        }
    }

    return $airportsByLetter;
}

/**
 * @param array $airports
 * @param string $filterByState
 * @return array
 */
function filterByState(array $airports, string $filterByState): array
{
    $airportsByState = [];

    foreach ($airports as $key => $airport) {
        if ($airport['state'][0] === $filterByState) {
            $airportsByState[] = $airport;
        }
    }

    return $airportsByState;
}

/**
 * @param array $airports
 * @param string $sortAirports
 * @return array
 */
function sortAirports(array $airports, string $sortAirports): array
{
    $airportsSort = [];

    foreach ($airports as $key => $airport) {
        $airportsSort[$key] = $airport[$sortAirports];
    }

    if (!empty($airports_sort)) {
        array_multisort($airportsSort, SORT_ASC, $airports);
    }

    return $airports;
}

/**
 * @param array $get
 * @param array $link
 * @return string
 */
function getLink(array $get, array $link = []): string
{
    $getParams = [];

    if (isset($get['filter_by_first_letter'])) {
        $getParams['filter_by_first_letter'] = $get['filter_by_first_letter'];
    }

    if (isset($get['filter_by_state'])) {
        $getParams['filter_by_state'] = $get['filter_by_state'];
    }

    if (isset($get['sort'])) {
        $getParams['sort'] = $get['sort'];
    }

    $getParams = array_replace($getParams, $link);

    $url = '';
    foreach ($getParams as $key => $param) {
        $url .= "&$key=$param";
    }

    return $url;
}

/**
 * @param array $airports
 * @param int $airportsPerPage
 * @param int $currentPage
 * @param int $pageQty
 * @return array
 */
function pagination(array $airports, int $airportsPerPage, int $currentPage, int $pageQty): array
{
    if ($currentPage >= 1 && $currentPage <= $pageQty) {
        $from = ($currentPage - 1) * $airportsPerPage;
        $airports = array_slice($airports, $from, $airportsPerPage);

    } else {
       throw new InvalidArgumentException();
    }

    return $airports;
}
