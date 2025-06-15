<?php

  // function get Title
function getTitle()
{
  global $pageTitle;

  if (isset($pageTitle))
  {
    echo $pageTitle;
  }else {
    $pageTitle = 'Default page';
  }
}
// function latest
function latest($conn,$table)
{
  $stmt = $conn->prepare("SELECT * FROM $table ORDER BY id DESC LIMIT 5");
  $stmt->execute();
  $lt = $stmt->fetchAll();
  return $lt;
}
// function get all items
function AllItems($conn,$table,$ord)
{
    $stmt = $conn->prepare("SELECT * FROM $table ORDER BY id $ord");
    $stmt->execute();
    $items = $stmt->fetchAll();
    return $items;
}


// function get Total
function Total($conn,$table)
{
    $stmt = $conn->prepare("SELECT * FROM $table ");
    $stmt->execute();
    $total = $stmt->rowCount();
    return $total;
}

// function get Total for product
function Total_Prod($conn, $table, $condition = "1") {
  try {
      $query = "SELECT COUNT(*) AS total_prod FROM $table WHERE $condition";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['total_prod'];
  } catch (PDOException $e) {
      return "Error: " . $e->getMessage(); // For debugging
  }
}

// function get Total for comming
function Total_com($conn, $table, $condition = "1") {
  try {
      $query = "SELECT COUNT(*) AS total_com FROM $table WHERE $condition";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['total_com'];
  } catch (PDOException $e) {
      return "Error: " . $e->getMessage(); // For debugging
  }
}

function Total_ret($conn, $table, $condition = "1") {
  try {
      $query = "SELECT COUNT(*) AS total_ret FROM $table WHERE $condition";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['total_ret'];
  } catch (PDOException $e) {
      return "Error: " . $e->getMessage(); // For debugging
  }
}

// function get Total for comming
function Total_rep($conn, $table, $condition = "1") {
  try {
      $query = "SELECT COUNT(*) AS total_rep FROM $table WHERE $condition";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['total_rep'];
  } catch (PDOException $e) {
      return "Error: " . $e->getMessage(); // For debugging
  }
}


 ?>
