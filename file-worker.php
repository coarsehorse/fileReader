<?php
/**
 * Created by PhpStorm.
 * User: heroys6
 * Date: 025 25.09.18
 * Time: 6:22 PM
 */

/**
 * Loads file line by line to the 2D array.
 * @param null $filePath - the path to the file with input data.
 * @return array - the result array with data from file.
 */
function loadBooksFromFileToArray($filePath = null) {
    // Check for empty parameter
    isset($filePath) or die("Parameter \"\$filePath\" is not specified!");

    $file = fopen($filePath, "r") or die("Cannot open file \"" . $filePath . "\"!");
    $resultArray = array();
    $arrayCounter = 0;

    // Read file line by line
    while(!feof($file)) {
        $tempStr = fgets($file); // get next input string
        $tempStr = preg_replace("/(\d+\) |\n|\r|\t)/", "", $tempStr); // clean up input str
        $strParts = preg_split("/\|/", $tempStr); // get data fields from string

        // Check fields count
        if (count($strParts) != 4)
            die("Broken data string(not enough fields): \"" . $tempStr . "\"");

        // Fill up the result array
        $resultArray[$arrayCounter++] = array("title" => $strParts[0],
            "author" => $strParts[1],
            "print" => $strParts[2],
            "status" => $strParts[3]);
    }

    fclose($file);

    return $resultArray;
}

/**
 * Filters out books by status field.
 * @param $books - all the books with different statuses.
 * @param null $status - publishing status.
 * Can be 0 - unpublished or 1 - published.
 * @return array the books filtered by $status field.
 */
function getBooksByStatus($books = null, $status = null) {
    // Check for empty parameters
    isset($books) or die("Parameter \"\$books\" is not specified!");
    isset($status) or die("Parameter \"\$status\" is not specified!");

    return array_values(array_filter($books, function($book) use ($status) {
        return $book["status"] == $status;
    }));
}

// Tests
// 1. Print parsed books from file

/*
$booksArray = loadBooksFromFileToArray("test_file.txt");

echo "Books loaded from the file:\n";
var_dump($booksArray);
*/

// 2. Print only published/unpublished books

/*
$booksArray2 = loadBooksFromFileToArray("test_file.txt");
$publishedBooks = getBooksByStatus($booksArray2, 1);
$unPublishedBooks = getBooksByStatus($booksArray2, 0);

echo "Published books:\n";
var_dump($publishedBooks);

echo "Unpublished books:\n";
var_dump($unPublishedBooks);
*/