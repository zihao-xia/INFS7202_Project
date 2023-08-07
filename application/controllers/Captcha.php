<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Captcha extends CI_Controller // cited from https://techarise.com/build-captcha-in-codeigniter/
{
    public function refresh()
    {
        $this->load->helper('captcha');
        $config = array(
            'img_path'      => './uploads/captcha_images/',
            'img_url'       => base_url() . './uploads/captcha_images/',
            'font_path'     => BASEPATH . 'system/fonts/texb.ttf',
            'img_width'     => 170,
            'img_height'    => 55,
            'expiration'    => 7200,
            'word_length'   => 6,
            'font_size'     => 25,
            'colors'        => array(
                'background' => array(171, 194, 177),
                'border' => array(10, 51, 115),
                'text' => array(0, 0, 0),
                'grid' => array(185, 234, 237)
            )
        );
        $captcha = create_captcha($config);
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        // Display captcha image
        echo $captcha['image'];
    }
}
