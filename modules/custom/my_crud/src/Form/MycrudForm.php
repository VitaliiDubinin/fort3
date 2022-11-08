<?php

namespace Drupal\my_crud\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Messenger;
use Drupal\Core\Link;

class MycrudForm extends FormBase
{

  public function getFormid()
  {
    return 'mycrud_form';
  }

  public function buildform(array $form, FormStateInterface $form_state)
  {
    $conn = Database::getConnection();
    $record = [];
    if (isset($_GET['id'])) {
      $query = $conn->select('my_crud', 'm')->condition('id', $_GET['id'])->fields('m');
      $record = $query->execute()->fetchAssoc();
    }
    $form['name'] = ['#type' => 'textfield', '#required' => TRUE, '#default_value' => (isset($record['name']) && $_GET['id']) ? $record['name'] : '',];
    $form['age'] = ['#type' => 'textfield',  '#required' => TRUE, '#default_value' => (isset($record['age']) && $_GET['id']) ? $record['age'] : '',];
    $form['action'] = ['#type' => 'action',];

    $form['action']['submit'] = ['#type' => 'submit', '#value' => t('Save'),];

    $form['action']['reset'] = ['#type' => 'button', '#value' => t('Reset'), '#attributes' => ['onclick' => '
  this.form.reset(); return false;',],];

    $link = Url::fromUserInput('/my_crud/');

    $form['action']['cancel'] = ['#markup' => Link::fromTextAndUrl(t('Back to page'), $link, ['
  attributes' => ['class' => 'button']])->toString(),];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $name = $form_state->getValue('name');

    if (preg_match('/[^A-Z[ ]a-z]/', $name)) {
      $form_state->setErrorByName('name', $this->t('Name must be in Characters Only'));
    }
    $age = $form_state->getValue('age');
    if (!preg_match('/[^A-Za-z]/', $age)) {
      $form_state->setErrorByName('age', $this->t('Age must be in Numbers only'));
    }

    parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $field = $form_state->getValues();

    $name = $field['name'];
    $age = $field['age'];

    if (isset($_GET['id'])) {
      $field = ['name' => $name, 'age' => $age,];

      $query = \Drupal::database();
      $query->update('my_crud')->fields($field)->condition('id', $_GET['id'])->execute();
      $this->messenger()->addMessage('Successfully updated records');
    } else {
      $field = ['name' => $name, 'age' => $age,];
      $query = \Drupal::database();
      $query->insert('my_crud')->fields($field)->execute();
      $this->messenger()->addMessage('Successfully saved records');
    }

    $form_state->setRedirect('my_crud.mycrud_controller_listing');
  }
}