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
      Test5 - User calls find method. Accepts name; returns item name and count if found.

  */

  require_once "src/Inventory.php";

  $DB = new PDO('pgsql:host=localhost;dbname=inventory_test');

  class InventoryTest extends PHPUnit_Framework_TestCase {

    protected function tearDown() {
      Inventory::deleteAll();
    }

    function test1() {
      // Arrange
      $name = "biscuit";
      $test_inv = new Inventory($name);

      // Act
      $test_inv->save();

      // Assert
      $result = Inventory::getAll();
      $this->assertEquals($test_inv, $result[0]);
    }

    function test2() {
      // Arrange
      $name = "biscuit";
      $test_inv = new Inventory($name, 10);

      // Act
      $test_inv->save();

      // Assert
      $result = Inventory::getAll();
      $this->assertEquals($test_inv, $result[0]);
    }

    function test3() {
      // Arrange
      $name = "biscuit";
      $test_inv = new Inventory($name, 10);

      // Act
      $test_inv->save();
      Inventory::deleteAll();

      // Assert
      $result = Inventory::getAll();
      $this->assertEquals([], $result);
    }

    // function test4() {
    //   // Arrange
    //   $name = "biscuit";
    //   $test_inv = new Inventory($name, 10, 1);
    //
    //   // Act
    //   $test_inv->save();
    //
    //   // Assert
    //   $result = $test_inv->getId();
    //   $this->assertEquals(1, $result);
    // }

    function test5() {
      // Arrange
      $name = "biscuit";
      $test_inv = new Inventory($name, 10);

      // Act
      $test_inv->save();

      // Assert
      $result = Inventory::find($name);
      $this->assertEquals($test_inv, $result);
    }
  }
?>
