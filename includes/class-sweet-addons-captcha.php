<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/includes
 * @author     WebsweetStudio <websweetstudio@gmail.com>
 */

 class Sweet_Addons_Captcha {

    /**
    * Sitekey reCaptcha v2
    */
    private $sitekey;
        
    /**
    * Secretkey reCaptcha v2
    */
    private $secretkey;

    /**
    * data-size reCaptcha v2
    * compact, normal
    */
    private $size;

    private $active = false;

    public function __construct() {
        $captcha_sweet_addons   = get_option('captcha_sweet_addons',[]);
        $captcha_aktif      = isset($captcha_sweet_addons['aktif'])?$captcha_sweet_addons['aktif']:'';
        $this->sitekey      = isset($captcha_sweet_addons['sitekey'])?$captcha_sweet_addons['sitekey']:'';
        $this->secretkey    = isset($captcha_sweet_addons['secretkey'])?$captcha_sweet_addons['secretkey']:'';
        $this->size         = wp_is_mobile()?'compact':'normal';

        if($captcha_aktif && $this->sitekey && $this->secretkey) {

            $this->active = true;

            // Tambahkan action captcha ke login_form
            add_action('login_form', array($this, 'display'));
            add_action('login_form_middle', array($this, 'display_login_form'));

            // Tambahkan Filter Auth untuk captcha
            add_filter( 'wp_authenticate_user', array($this, 'verify_login_form'), 10, 3 );

            // Panggil fungsi untuk menambahkan reCaptcha ke kolom komentar
            add_action('comment_form_after_fields', array($this, 'display')); 
            // Panggil fungsi untuk memvalidasi reCaptcha saat proses submit komentar
            add_action('pre_comment_on_post', array($this, 'verify_comment_form'), 10, 1);

            // Panggil fungsi untuk menambahkan reCaptcha ke kolom lostpassword
            add_action('lostpassword_form', array($this, 'display'));
            add_action('lostpassword_post', array($this, 'lostpassword_post'));

            // Panggil fungsi untuk menambahkan reCaptcha ke kolom register
            add_action('register_form', array($this, 'display'));
            add_action('signup_extra_fields', array($this, 'display'));
            add_filter('registration_errors', array($this, 'verify_register_form'), 10, 3);

            if (class_exists('WPCF7') ){
                add_action('wpcf7_init', array($this, 'wpcf7_form_captcha'));
            }
            
            add_shortcode('sweet_recaptcha', array($this, 'display_login_form'));
        }
        
    }

    public function wpcf7_form_captcha(){
        wpcf7_add_form_tag('sweet_captcha', array($this, 'wpcf7_display_captcha'));
    }
    public function wpcf7_display_captcha(){
        ob_start();
        echo $this->display();
        return ob_get_clean();
    }

    public function isActive(){ 
        return $this->active;
    }

    public function display(){
        if($this->active){
            $node = 'rr'.uniqid();
            echo '<div class="'.$node.'">';
                echo '<div id="g'.$node.'" data-size="'.$this->size.'" style="transform: scale(0.9);transform-origin: 0 0;"></div>';
                ?>
                <script type="text/javascript">
                    function onloadCallback<?php echo $node;?>() {
                        grecaptcha.render('g<?php echo $node;?>', {
                            'sitekey' : '<?php echo $this->sitekey;?>',
                            'callback': callback<?php echo $node;?>,
                            'expired-callback' : expired<?php echo $node;?>
                        });
                    };
                    function callback<?php echo $node;?>() {
                        (function ($) {
                            var form = $('.<?php echo $node;?>').parent().closest('form');
                            form.find('input[type="submit"]').attr('disabled', false);
                            form.find('button[type="submit"]').attr('disabled', false);
                        })(jQuery);
                    };
                    (function ($) {
                        $( document ).ready(function() {
                            var form = $('.<?php echo $node;?>').parent().closest('form');
                            form.find('input[type="submit"]').attr('disabled', 'disabled');
                            form.find('button[type="submit"]').attr('disabled', 'disabled');
                        });
                    })(jQuery);
                    function expired<?php echo $node;?>() {
                        alert('Captcha Kadaluarsa, silahkan refresh halaman');
                    };
                </script>
                <?php
                echo '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback'.$node.'&render=explicit" async defer></script>'; 
            echo '</div>';
        }
    }

    public function verify($gresponse = null){        
        
        if($this->active){

            $gresponse = $gresponse?$gresponse:'0';
            if(empty($gresponse) && isset($_POST['g-recaptcha-response'])){
                $gresponse = $_POST['g-recaptcha-response'];
            }

            $result = [
                'success' => false,
                'message' => 'Harap validasi captcha yang ada',
            ];
            
            if($gresponse){
                $response = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret='.$this->secretkey.'&response=' . $gresponse );
                $response = json_decode($response['body'], true); 

                if (true == $response['success']) {
                    $result = [
                        'success' => true,
                        'message' => 'Validasi captcha berhasil',
                    ];
                } else {
                    $result = [
                        'success' => false,
                        'message' => 'Captcha salah',
                    ];
                }
            }
            
        } else {
            
            $result = [
                'success' => true,
                'message' => 'Validasi captcha tidak aktif',
            ];

        }

        return $result;
    }
    
    public function verify_login_form($user, $password){

        // Periksa apakah reCaptcha valid saat proses login
        $respon = isset($_POST['g-recaptcha-response'])?$_POST['g-recaptcha-response']:'0';
        $verify = $this->verify($respon);
        
        if (!$verify['success']) {
            // Jika reCaptcha tidak valid, hentikan proses login
            remove_action('authenticate', 'wp_authenticate_username_password', 20);
            // wp_die('reCaptcha verification failed. Please try again.');
            return new WP_Error( 'Captcha Invalid', __($verify['message']) );
        } else {            
            return $user;
        }

    }

    public function verify_comment_form($comment_data) {
        // Periksa apakah reCaptcha valid saat proses submit komentar
        $verify = $this->verify($_POST['g-recaptcha-response']);
        
        if (!$verify['success']) {
            // Jika reCaptcha tidak valid, hentikan proses submit komentar
            wp_die($verify['message']);
        }
        
        return $comment_data;
    }

    public function lostpassword_post(){
     
       //jika user belum login
     		if ( !is_user_logged_in() ) {
             // Periksa apakah reCaptcha valid saat proses submit lostpassword
             $verify = $this->verify($_POST['g-recaptcha-response']);
             
             if (!$verify['success']) {
                 // Jika reCaptcha tidak valid, hentikan proses submit
                 wp_die($verify['message']);
             }
       }
     
    }

    public function verify_register_form($errors, $sanitized_user_login, $user_email){

        if (isset($_POST['register']) && !empty($_POST['g-recaptcha-response'])) {
            $verify = $this->verify($_POST['g-recaptcha-response']);
            if (!$verify['success']) {
                $errors->add('recaptcha_error', __($verify['message']));
            }
        }

        return $errors;
    }
    
    public function display_login_form(){
        if($this->active){
            $html = '<div>';
                $html .= '<div class="g-recaptcha" data-sitekey="'.$this->sitekey.'"></div>';
                $html .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>'; 
            $html .= '</div>';

            return $html;

        } else {
            return '';
        }
    }

 }

 $captcha_handler = new Sweet_Addons_Captcha();
