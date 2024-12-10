<?php

/**
 * Plugin Name: Alianza Options
 * Description: Plugin de customização de tema
 * Version: 0.1
 * Author: Pang Brands
 * Author URI: http://pangbrands.com
 */

// Incluir o autoload do Composer
require_once __DIR__ . '/vendor/autoload.php';

define('ALZC_OPTIONS_DIR', plugin_dir_path(__FILE__));
define('ALZC_OPTIONS_URL', plugins_url('/', __FILE__));

add_action('after_setup_theme', 'crb_load');
function crb_load()
{
  \Carbon_Fields\Carbon_Fields::boot();
}

// Criação da página de opções
add_action('carbon_fields_register_fields', 'crb_footer_options');
function crb_footer_options()
{
  \Carbon_Fields\Container::make('theme_options', __('Theme Options'))
    ->set_page_menu_position(3)
    ->set_icon('/wp-content/uploads/2024/11/fav-icon-e1732417992265.png') // Adiciona o ícone
    ->add_fields(array(
      \Carbon_Fields\Field::make('image', 'footer_logo', __('Logo do Rodapé'))
        ->set_value_type('url'),
      \Carbon_Fields\Field::make('complex', 'social_links', __('Redes Sociais'))
        ->set_layout('tabbed-horizontal')
        ->add_fields(array(
          \Carbon_Fields\Field::make('select', 'platform', __('Plataforma'))
            ->set_options(array(
              'facebook' => 'Facebook',
              'instagram' => 'Instagram',
              'whatsapp' => 'WhatsApp',
              'youtube' => 'YouTube',
            ))
            ->set_required(true),
          \Carbon_Fields\Field::make('text', 'link', __('Link'))
            ->set_required(true),
        )),
      \Carbon_Fields\Field::make('complex', 'contact_info', __('Informações de Contato'))
        ->set_layout('tabbed-horizontal')
        ->add_fields(array(
          \Carbon_Fields\Field::make('text', 'contact_text', __('Texto de Contato')),
          \Carbon_Fields\Field::make('url', 'contact_link', __('Link de Contato')),
        )),
      \Carbon_Fields\Field::make('text', 'address', __('Endereço')),
      \Carbon_Fields\Field::make('text', 'copyright', __('Direitos Autorais')),
      \Carbon_Fields\Field::make('text', 'whatsapp_link', __('Link do WhatsApp')),
    ));
}

// Salvar as opções
add_action('carbon_fields_before_render', 'crb_load_options');
function crb_load_options()
{
  \Carbon_Fields\Carbon_Fields::register();
}

// Enqueue Scripts e Styles
add_action('admin_enqueue_scripts', 'enqueue_crb_scripts');
function enqueue_crb_scripts()
{
  wp_enqueue_script('carbon-fields-js', ALZC_OPTIONS_URL . 'vendor/html5shiv.js', array('jquery'), '1.0', true);
}
