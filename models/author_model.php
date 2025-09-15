<?php

class AuthorModel
{
  private $id;
  private $full_name;
  private $birth_date;
  private $biography_summary;

  public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id = $id;
  }

  public function getFullName()
  {
    return $this->full_name;
  }
  public function setFullName($name)
  {
    $this->full_name = $name;
  }

  public function getBirthDate()
  {
    return $this->birth_date;
  }
  public function setBirthDate($birthDate)
  {
    $this->birth_date = $birthDate;
  }

  public function getBiographySummary()
  {
    return $this->biography_summary;
  }
  public function setBiographySummary($summary)
  {
    $this->biography_summary = $summary;
  }
}
