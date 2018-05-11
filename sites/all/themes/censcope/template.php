<?php

/**
 * @file
 * template.php
 */
function censcope_preprocess_html(&$vars) {
  drupal_add_css('//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic', array('type' => 'external'));
  
drupal_add_css('//www.censusscope.org/new/topics/css/style.css', array('type' => 'external'));

}



function censcope_preprocess_page(&$vars, $hook) {

  $alias = drupal_get_path_alias($_GET['q']);
  if ($alias != $_GET['q']) {
    $template_filename = 'page';
    foreach (explode('/', $alias) as $path_part) {
      $template_filename = $template_filename . '__' . str_replace("-", "_", $path_part);
      $vars['theme_hook_suggestions'][] = $template_filename;
      //$vars['test'] = $template_filename;
    }
  }
}