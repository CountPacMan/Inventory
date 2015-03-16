<?php
  class Inventory {
    private $name;
    private $number;
    private $id;

    function __construct($name, $number = 1, $id = null)   {
      $this->name = $name;
      $this->number = $number;
      $this->id = $id;
    }

    // getters
    function getName()  {
      return $this->name;
    }

    function getNumber()  {
      return $this->number;
    }

    function getId() {
      return $this->id;
    }

    // setters
    function setName($name)  {
      $this->name = (string) $name;
    }

    function setNumber($number) {
      $this->number = (int) $number;
    }

    function setId($id) {
      $this->id = (int) $id;
    }

    // DB
    function save() {
      $statement = $GLOBALS['DB']->query("INSERT INTO items (name, number) VALUES ('{$this->getName()}', '{$this->getNumber()}') RETURNING id;");
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      $this->setId($result['id']);
    }

    // static function find($search_id) {
    //   $found_task = null;
    //   $items = Inventory::getAll();
    //   foreach ($items as $item) {
    //     $task_id = $item->getId();
    //     if ($task_id == $search_id) {
    //       $found_task = $item;
    //     }
    //   }
    //   return $found_task;
    // }

    static function getAll() {
      $returned_items = $GLOBALS['DB']->query("SELECT * FROM items;");
      $items = array();
      foreach($returned_items as $item) {
        $name = $item['name'];
        $number = $item['number'];
        $id = $item['id'];
        $new_item = new Inventory($name, $number, $id);
        array_push($items, $new_item);
      }
      return $items;
    }

    static function deleteAll() {
      $GLOBALS['DB']->exec("DELETE FROM items *;");
    }
  }
?>
