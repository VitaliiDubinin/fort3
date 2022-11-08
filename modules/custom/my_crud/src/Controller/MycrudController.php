<?php

/**
 * @file
 * Install, update and uninstall functions for the my_crud module.
 */

namespace Drupal\my_crud\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Messenger;
use Drupal\Core\Link;


class MycrudController extends ControllerBase
{

  public function Listing()
  {

    // table apache_request_headers
    $header_table = ['id' => t('ID'), 'name' => t('Name'), 'age' => t('Age'), 'opt' => t('Edit Operation'), '
    opt1' => t('Delete Operation'),];
    $row = [];
    $conn = Database::getConnection();
    $query = $conn->select('my_crud', 'm');
    $query->fields('m', ['id', 'name', 'age']);
    $result = $query->execute()->fetchAll();

    foreach ($result as $value) {
      $delete = Url::fromUserInput('/my_crud/form/delete/' . $value->id);
      $edit = Url::fromUserInput('/my_crud/form/data?id=' . $value->id);

      $row[] = ['id' => $value->id, 'name' => $value->name, 'age' => $value->age, 'opt' => Link::fromTextAndUrl('Edit', $edit)->toString(), 'opt1' => Link::fromTextAndUrl('Delete', $delete)->toString(),];
    }
    $add = Url::fromUserInput('/my_crud/form/data');
    $text = "Add User";

    $data['table'] = ['#type' => 'table', '#header' => $header_table, '#rows' => $row, '#empty' => t('
    No record found'), '#caption' => Link::fromTextAndUrl($text, $add)->toString(),];

    $this->messenger()->addMessage('Records Listed');
    return $data;
  }
}