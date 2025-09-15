<?php
require_once __DIR__ . '/../models/book_model.php';
require_once __DIR__ . '/../util/pdo.php';

class BookController
{
  public static function getAll()
  {
    global $pdo;

    try {
      $stmt = $pdo->prepare("
        SELECT b.id, title, publication_year, page_count, isbn_number, summary_text, a.full_name as author
        FROM Books b
        INNER JOIN Authors a ON author_id = a.id
        ORDER BY b.id ASC
      ");
      $stmt->execute();
    } catch (PDOException $e) {
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $books = [];

    foreach ($rows as $row) {
      $book = new BookModel();
      $book->setId($row['id']);
      $book->setAuthor($row['author']);   // assumes your query joins authors
      $book->setTitle($row['title']);
      $book->setPublicationYear($row['publication_year']);
      $book->setPageCount($row['page_count']);
      $book->setIsbnNumber($row['isbn_number']);
      $book->setSummaryText($row['summary_text']);

      $books[] = $book;
    }

    return $books;
  }

  public static function delete(int $id)
  {
    if ($id < 1) {
      return;
    }

    global $pdo;

    try {
      $stmt = $pdo->prepare("DELETE FROM Books WHERE id = :id");
      $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
    }
  }

  public static function create(
    string $title,
    int $publication_year,
    int $page_count,
    string $isbn_number,
    int $author_id,
    string $summary_text
  ) {
    global $pdo;

    if (
      empty($title) ||
      $publication_year < 0 ||
      $page_count < 0 ||
      empty($isbn_number) ||
      $author_id < 1 ||
      empty($summary_text)
    ) {
      return;
    }

    try {
      $stmt = $pdo->prepare("
        INSERT INTO Books 
        (title, publication_year, page_count, isbn_number, author_id, summary_text)
        VALUES (:title, :publication_year, :page_count, :isbn_number, :author_id, :summary_text)
      ");

      $stmt->execute([
        ':title' => $title,
        ':publication_year' => $publication_year,
        ':page_count' => $page_count,
        ':isbn_number' => $isbn_number,
        ':author_id' => $author_id,
        ':summary_text' => $summary_text
      ]);
    } catch (PDOException $e) {
    }
  }

  public static function edit(
    int $id,
    string $title,
    int $publication_year,
    int $page_count,
    string $isbn_number,
    int $author_id,
    string $summary_text
  ) {
    global $pdo;

    if (
      $id < 1 ||
      empty($title) ||
      $publication_year < 0 ||
      $page_count < 0 ||
      empty($isbn_number) ||
      $author_id < 1 ||
      empty($summary_text)
    ) {
      return;
    }

    try {
      $stmt = $pdo->prepare("
        UPDATE Books 
        SET 
          title = :title,
          publication_year = :publication_year,
          page_count = :page_count,
          isbn_number = :isbn_number,
          author_id = :author_id,
          summary_text = :summary_text
        WHERE id = :id
      ");

      $stmt->execute([
        ':id' => $id,
        ':title' => $title,
        ':publication_year' => $publication_year,
        ':page_count' => $page_count,
        ':isbn_number' => $isbn_number,
        ':author_id' => $author_id,
        ':summary_text' => $summary_text
      ]);
    } catch (PDOException $e) {
    }
  }

  public static function get(int $id)
  {
    if ($id < 1) {
      return null;
    }

    global $pdo;

    try {
      $stmt = $pdo->prepare("
        SELECT b.id, title, publication_year, page_count, isbn_number, summary_text, a.full_name as author
        FROM Books b
        INNER JOIN Authors a ON author_id = a.id
        WHERE b.id = :id
      ");
      $stmt->execute([":id" => $id]);
    } catch (PDOException $e) {
      return;
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) == 0) {
      return null;
    }

    $row = $rows[0];

    $book = new BookModel();
    // $book->id = $row['id'];
    // $book->author = $row['author'];      // assumes your query joins authors
    // $book->title = $row['title'];
    // $book->publication_year = $row['publication_year'];
    // $book->page_count = $row['page_count'];
    // $book->isbn_number = $row['isbn_number'];
    // $book->summary_text = $row['summary_text'];
    $book->setId($row['id']);
    $book->setAuthor($row['author']);   // assumes your query joins authors
    $book->setTitle($row['title']);
    $book->setPublicationYear($row['publication_year']);
    $book->setPageCount($row['page_count']);
    $book->setIsbnNumber($row['isbn_number']);
    $book->setSummaryText($row['summary_text']);

    return $book;
  }
}

if (isset($_POST['button_delete_book'], $_POST['book_id'])) {
  BookController::delete(filter_var($_POST['book_id'] ?? null, FILTER_VALIDATE_INT) ?: 0);
  header("Location: /books.php");
}

if (isset($_POST['button_add_book'])) {
  BookController::create(
    trim($_POST['title'] ?? ''),
    filter_var($_POST['publication_year'] ?? null, FILTER_VALIDATE_INT) ?: 0,
    filter_var($_POST['page_count'] ?? null, FILTER_VALIDATE_INT) ?: 0,
    trim($_POST['isbn_number'] ?? ''),
    filter_var($_POST['author_id'] ?? null, FILTER_VALIDATE_INT) ?: 0,
    trim($_POST['summary_text'] ?? '')
  );

  header("Location: /books.php");
}

if (isset($_POST['button_edit_book'])) {
  BookController::edit(
    filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT) ?: 0,
    trim($_POST['title'] ?? ''),
    filter_var($_POST['publication_year'] ?? null, FILTER_VALIDATE_INT) ?: 0,
    filter_var($_POST['page_count'] ?? null, FILTER_VALIDATE_INT) ?: 0,
    trim($_POST['isbn_number'] ?? ''),
    filter_var($_POST['author_id'] ?? null, FILTER_VALIDATE_INT) ?: 0,
    trim($_POST['summary_text'] ?? '')
  );

  header("Location: /books.php");
}
