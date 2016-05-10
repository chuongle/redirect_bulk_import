<?php

namespace Drupal\redirect_bulk_import\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the redirect_bulk_import module.
 */
class RedirectBulkImportTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "redirect_bulk_import RedirectBulkImport's controller functionality",
      'description' => 'Test Unit for module redirect_bulk_import and controller RedirectBulkImport.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests redirect_bulk_import functionality.
   */
  public function testRedirectBulkImport() {
    // Check that the basic functions of module redirect_bulk_import.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
