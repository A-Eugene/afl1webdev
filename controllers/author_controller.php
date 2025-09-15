<?php
require_once __DIR__ . '/../models/author_model.php';
require_once __DIR__ . '/../util/pdo.php';

class AuthorController
{
  public static function getAll()
  {
    global $pdo;

    try {
      $stmt = $pdo->prepare("SELECT * FROM Authors");
      $stmt->execute();
    } catch (PDOException $e) {
      return;
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $authors = [];

    foreach ($rows as $row) {
      $author = new AuthorModel();
      $author->setId($row['id']);
      $author->setFullName($row['full_name']);   // assumes your query joins authors
      $author->setBirthDate($row['birth_date']);
      $author->setBiographySummary($row['biography_summary']);
      $authors[] = $author;
    }

    return $authors;
  }

  public static function getNames()
  {
    global $pdo;

    try {
      $stmt = $pdo->prepare("SELECT id, full_name FROM Authors");
      $stmt->execute();
    } catch (PDOException $e) {
      return;
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $authors = [];

    foreach ($rows as $row) {
      $author = new AuthorModel();
      $author->setId($row['id']);
      $author->setFullName($row['full_name']);   // assumes your query joins authors
      $authors[] = $author;
    }

    return $authors;
  }

  public static function delete(int $id)
  {
    if ($id < 1) {
      return;
    }

    global $pdo;

    try {
      $stmt = $pdo->prepare("DELETE FROM Authors WHERE id = :id");
      $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
      echo $e;
    }
  }

  public static function getNonEmptyAuthors()
  {
    global $pdo;

    try {
      $stmt = $pdo->prepare("SELECT DISTINCT author_id FROM Books");
      $stmt->execute();
    } catch (PDOException $e) {
      return;
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ids = [];

    foreach ($rows as $row) {
      $ids[] = $row['author_id'];
    }

    return $ids;
  }

  public static function create(
    string $full_name,
    string $birth_date,
    string $biography_summary
  ) {
    if (
      empty($full_name) ||
      empty($birth_date) ||
      empty($biography_summary)
    ) {
      return;
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth_date)) {
      return;
    }

    $dateObj = DateTime::createFromFormat('Y-m-d', $birth_date);
    if (!$dateObj || $dateObj->format('Y-m-d') !== $birth_date) {
      return;
    }
    if ($dateObj > new DateTime()) {
      return;
    }

    global $pdo;

    try {
      $stmt = $pdo->prepare("
        INSERT INTO Authors (full_name, birth_date, biography_summary)
        VALUES (:name, :birth_date, :biography_summary)
      ");
      $stmt->execute([
        ':name' => $full_name,
        ':birth_date' => $birth_date,
        ':biography_summary' => $biography_summary
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
      $stmt = $pdo->prepare("SELECT * FROM Authors WHERE id = :id");
      $stmt->execute([":id" => $id]);
    } catch (PDOException $e) {
      return;
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) == 0) {
      return null;
    }

    $row = $rows[0];

    $author = new AuthorModel();
    $author->setId($row['id']);
    $author->setFullName($row['full_name']);   // assumes your query joins authors
    $author->setBirthDate($row['birth_date']);
    $author->setBiographySummary($row['biography_summary']);

    return $author;
  }

  public static function edit(
    int $id,
    string $full_name,
    string $birth_date,
    string $biography_summary
  ) {
    if (
      $id < 1 ||
      empty($full_name) ||
      empty($birth_date) ||
      empty($biography_summary)
    ) {
      return;
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth_date)) {
      return;
    }

    $dateObj = DateTime::createFromFormat('Y-m-d', $birth_date);
    if (!$dateObj || $dateObj->format('Y-m-d') !== $birth_date) {
      return;
    }
    if ($dateObj > new DateTime()) {
      return;
    }

    global $pdo;

    try {
      $stmt = $pdo->prepare("
        UPDATE Authors
        SET 
          full_name = :name,
          birth_date = :birth_date, 
          biography_summary = :biography_summary
        WHERE id = :id
      ");
      $stmt->execute([
        ':id' => $id,
        ':name' => $full_name,
        ':birth_date' => $birth_date,
        ':biography_summary' => $biography_summary
      ]);
    } catch (PDOException $e) {
      // echo $e;
    }
  }
}

if (isset($_POST['button_add_author'])) {
  AuthorController::create(
    trim($_POST['full_name'] ?? ''),
    trim($_POST['birth_date'] ?? ''),
    trim($_POST['biography_summary'] ?? '')
  );
  header("Location: /authors.php");
}

if (isset($_POST['button_delete_author'])) {
  AuthorController::delete(filter_var($_POST['author_id'] ?? null, FILTER_VALIDATE_INT) ?: 0);
  header("Location: /authors.php");
}

if (isset($_POST['button_edit_author'])) {
  AuthorController::edit(
    filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT) ?: 0,
    trim($_POST['full_name'] ?? ''),
    trim($_POST['birth_date'] ?? ''),
    trim($_POST['biography_summary'] ?? '')
  );

  header("Location: /authors.php");
}
