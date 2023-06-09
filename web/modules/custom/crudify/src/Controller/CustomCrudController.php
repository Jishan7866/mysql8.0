<?php 

namespace Drupal\custom_crud\Controller;

use Drupal\Core\Controller\ControllerBase;

class CustomCrudController extends ControllerBase {

  public function list() {
    $build = array(
      '#markup' => '<h2>List of custom items</h2>',
    );
    return $build;
  }

}

?>