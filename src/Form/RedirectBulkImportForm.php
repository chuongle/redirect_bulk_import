<?php

namespace Drupal\redirect_bulk_import\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\redirect_bulk_import\RedirectBulkImport;
use Drupal\Core\Link;
use Drupal\Core\Url;


/**
 * Class RedirectBulkImportForm.
 *
 * @package Drupal\redirect_bulk_import\Form
 */
class RedirectBulkImportForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'redirect_bulk_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $validators = array(
      'file_validate_extensions' => array('csv'),
      'file_validate_size' => array(file_upload_max_size()),
    );
    $form['delimiter'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Delimiter'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => ',',
    ];
    $form['file'] = [
      '#type' => 'file',
      '#title' => $this->t('File'),
      '#description' => $this->t('Upload csv file.'),
      '#upload_validators' => $validators,
    ];
    $form['actions'] = array(
      '#type' => 'actions',
    );
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Import'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $file = file_save_upload('file', $form['file']['#upload_validators'], 'public://', 0);
    if(!$file) {
      $form_state->setErrorByName('file', $this->t('Please upload file to import.'));
    }else {
      $form_state->setValue('file', $file);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $file = $form_state->getValue('file');
    $results = redirect_bulk_import_import($file);
    drupal_set_message('Import :count redirects', array(':count' => $results['count']));
    if(!empty($results['existing_redirects'])){
      drupal_set_message('Some redirects are already existed. Please edit them');
      foreach($results['existing_redirects'] as $redirect) {
        $link = Link::fromTextAndUrl('Here', Url::fromUri('internal:/admin/config/search/redirect/edit/'.$redirect, array('attributes' => array('target'=>'_blank'))));
        $html = $link->toString();
        drupal_set_message($html);
      }
    }
  }
}
