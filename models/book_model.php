<?php

class BookModel
{
  private $id;
  private $author;
  private $title;
  private $publication_year;
  private $page_count;
  private $isbn_number;
  private $summary_text;

  public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id = $id;
  }

  public function getAuthor()
  {
    return $this->author;
  }
  public function setAuthor($author)
  {
    $this->author = $author;
  }

  public function getTitle()
  {
    return $this->title;
  }
  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function getPublicationYear()
  {
    return $this->publication_year;
  }
  public function setPublicationYear($year)
  {
    $this->publication_year = $year;
  }

  public function getPageCount()
  {
    return $this->page_count;
  }
  public function setPageCount($count)
  {
    $this->page_count = $count;
  }

  public function getIsbnNumber()
  {
    return $this->isbn_number;
  }
  public function setIsbnNumber($isbn)
  {
    $this->isbn_number = $isbn;
  }

  public function getSummaryText()
  {
    return $this->summary_text;
  }
  public function setSummaryText($summary)
  {
    $this->summary_text = $summary;
  }
}
