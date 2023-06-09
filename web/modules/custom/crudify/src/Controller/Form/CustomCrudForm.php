<?php

namespace Drupal\crudify\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomCrudForm extends FormBase {

  public function getFormId() {
    return 'custom_crud_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['firstName'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#required' => TRUE,
    );

    $form['lastName'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#required' => TRUE,
    );

    $form['lastName'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#required' => TRUE,
    );

    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    );

    $form['candidate_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'Female' => $this->t('Female'),
        'male' => $this->t('Male'),
        ),
      );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    );

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

    // Validate the first name.
    $firstName = $form_state->getValue('firstName');
    if (strlen($firstName) < 2) {
      $form_state->setErrorByName('firstName', $this->t('The first name should be at least 2 characters long.'));
    }

    // Validate the last name.
    $lastName = $form_state->getValue('lastName');
    if (strlen($lastName) < 2) {
      $form_state->setErrorByName('lastName', $this->t('The last name should be at least 2 characters long.'));
    }

    // Validate the email address.
    $email = $form_state->getValue('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
    }

    // Validate the gender.
    $gender = $form_state->getValue('candidate_gender');
    if (empty($gender)) {
      $form_state->setErrorByName('candidate_gender', $this->t('Please select your gender.'));
    }
}


public function submitForm(array &$form, FormStateInterface $form_state) {
  // Create a new node object.
  $node = \Drupal\node\Entity\Node::create();

  // Set the node type to "candidate".
  $node->set('type', 'candidate');

  // Set the node title to the candidate's first and last name.
  $firstName = $form_state->getValue('firstName');
  $lastName = $form_state->getValue('lastName');
  $node->set('title', $firstName . ' ' . $lastName);

  // Set the node body to the candidate's email address and gender.
  $email = $form_state->getValue('email');
  $gender = $form_state->getValue('candidate_gender');
  $node->set('body', [
    'value' => 'Email: ' . $email . "\nGender: " . $gender,
    'format' => 'plain_text',
  ]);

  // Save the node.
  $node->save();

  // Redirect to the node page.
  $form_state->setRedirect('entity.node.canonical', ['node' => $node->id()]);
}


}


?>