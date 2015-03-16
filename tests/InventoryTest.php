<?php

  /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

  /* Specs:
      Test1 - 1 item is added to inventory. Returns item.
      Test2 - Multiple items added to inventory. Returns item with correct count.
      Test3 - User deletes all items in inventory. Clears all items in database.
      Test4 - Users calls getId on item. Returns item's id#.
      Test5 - User calls find method. Accepts id#; returns item name and count.

  */

  require_once "src/Inventory.php";

  $DB = new PDO('pgsql:host=localhost;dbname=inventory_test');

  class InventoryTest extends PHPUnit_Framework_TestCase {

    protected function tearDown() {
      Inventory::deleteAll();
    }

    function test_save() {
      // Arrange
      $name = "biscuit";
      $test_inv = new Inventory($name);

      // Act
      $test_inv->save();

      // Assert
      $result = Inventory::getAll();
      $this->assertEquals($test_inv, $result[0]);
    }
  }
?>
