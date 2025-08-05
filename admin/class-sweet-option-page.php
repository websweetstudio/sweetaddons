<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweetaddons
 * @subpackage Sweetaddons/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sweetaddons
 * @subpackage Sweetaddons/admin
 * @author     WebsweetStudio <websweetstudio@gmail.com>
 */

class Custom_Admin_Option_Page
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_options_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_options_page()
    {
        add_menu_page(
            'Sweet Addons',       // Judul halaman
            'Sweet Addons',       // Judul menu
            'manage_options',           // Hak akses yang dibutuhkan
            'custom_admin_options',     // Slug menu
            array($this, 'options_page_callback'), // Callback untuk halaman pengaturan
            '',                         // URL icon (biarkan kosong atau tambahkan URL icon)
            70                         // Posisi menu (semakin kecil angkanya semakin tinggi posisinya)
        );

        // Add spam submenu
        add_submenu_page(
            'custom_admin_options',     // Parent slug
            'Spam',                     // Page title
            'Spam',                     // Menu title
            'manage_options',           // Capability
            'Sweetaddons_spam',        // Menu slug
            array($this, 'spam_page_callback') // Callback function
        );
    }


    public function register_settings()
    {
        register_setting('custom_admin_options_group', 'fully_disable_comment');
        register_setting('custom_admin_options_group', 'hide_admin_notice');
        register_setting('custom_admin_options_group', 'limit_login_attempts');
        register_setting('custom_admin_options_group', 'maintenance_mode');
        register_setting('custom_admin_options_group', 'maintenance_mode_data');
        register_setting('custom_admin_options_group', 'license_key');
        register_setting('custom_admin_options_group', 'auto_resize_mode');
        register_setting('custom_admin_options_group', 'auto_resize_mode_data');
        register_setting('custom_admin_options_group', 'disable_xmlrpc');
        register_setting('custom_admin_options_group', 'disable_rest_api');
        register_setting('custom_admin_options_group', 'disable_gutenberg');
        register_setting('custom_admin_options_group', 'block_wp_login');
        register_setting('custom_admin_options_group', 'whitelist_block_wp_login');
        register_setting('custom_admin_options_group', 'whitelist_country');
        register_setting('custom_admin_options_group', 'redirect_to');
        // register_setting('custom_admin_options_group', 'standar_editor_Sweetaddons');
        register_setting('custom_admin_options_group', 'classic_widget_Sweetaddons');
        register_setting('custom_admin_options_group', 'remove_slug_category_Sweetaddons');
        register_setting('custom_admin_options_group', 'auto_resize_image_Sweetaddons');
        register_setting('custom_admin_options_group', 'captcha_Sweetaddons');
        register_setting('custom_admin_options_group', 'news_generate');
    }

    public function field($data)
    {

        $type   = isset($data['type']) ? $data['type'] : '';
        $id     = isset($data['id']) ? $data['id'] : '';
        $std    = isset($data['std']) ? $data['std'] : '';
        $step   = isset($data['step']) ? $data['step'] : '';
        $value  = get_option($id, $std);
        $name   = $id;

        // jika ada sub, sub array dari Value
        if (isset($data['sub']) && !empty($data['sub'])) {
            $sub    = $data['sub'];
            $value  = isset($value[$sub]) ? $value[$sub] : '';
            $name   = $id . '[' . $sub . ']';
        }

        if ($std && empty($value) && $type != 'checkbox') {
            $value = $std;
        }

        //jika field checkbox
        if ($type == 'checkbox') {
            $checked = ($value == 1) ? 'checked' : '';
            echo '<input type="checkbox" id="' . $id . '" name="' . $name . '" value="1" ' . $checked . '> ';
        }
        //jika field text
        if ($type == 'text') {
            echo '<div><input type="text" id="' . $id . '" name="' . $name . '" value="' . $value . '" class="regular-text"></div>';
        }

        if ($type == 'password') {
            echo '<div><input type="password" id="' . $id . '" name="' . $name . '" value="' . $value . '" class="regular-text"></div>';
        }

        //jika field number
        if ($type == 'number') {
            echo '<div><input type="number" step="' . $step . '" min="0" id="' . $id . '" name="' . $name . '" value="' . $value . '" class="small-text"></div>';
        }
        //jika field textarea
        if ($type == 'textarea') {
            echo '<div>';
            echo '<textarea id="' . $id . '" name="' . $name . '" rows="6" cols="50" class="large-text">';
            echo $value;
            echo '</textarea>';
            echo '</div>';
        }

        ///tampil label
        if (isset($data['label']) && !empty($data['label'])) {
            echo '<label for="' . $id . '">';
            echo '<small>' . $data['label'] . '</small>';
            echo '</label>';
        }

        ///tampil deskripsi
        if (isset($data['desc']) && !empty($data['desc'])) {
            echo '<div>';
            echo '<small>' . $data['desc'] . '</small>';
            echo '</div>';
        }
    }

    public function spam_page_callback()
    {
        $spam_fields = [
            [
                'id'    => 'limit_login_attempts',
                'type'  => 'checkbox',
                'title' => 'Limit Login Attempts',
                'std'   => 1,
                'label' => 'Batasi jumlah percobaan login yang diizinkan untuk pengguna, ketika pengguna melakukan percobaan login yang melebihi 5X dalam 24 Jam, mereka akan diblokir untuk sementara waktu sebagai tindakan keamanan.',
            ],
            [
                'id'    => 'disable_xmlrpc',
                'type'  => 'checkbox',
                'title' => 'Disable XML-RPC',
                'std'   => 1,
                'label' => 'Nonaktifkan protokol XML-RPC pada situs. XML-RPC digunakan oleh beberapa aplikasi atau layanan pihak ketiga untuk berinteraksi dengan situs WordPress.',
            ],
            [
                'id'    => 'disable_rest_api',
                'type'  => 'checkbox',
                'title' => 'Disable REST API / JSON',
                'std'   => 0,
                'label' => 'Nonaktifkan akses ke REST API untuk keperluan keamanan atau privasi.',
            ],
            [
                'id'    => 'captcha_Sweetaddons',
                'sub'   => 'aktif',
                'type'  => 'checkbox',
                'title' => 'Captcha',
                'std'   => 1,
                'label' => 'Aktifkan Google reCaptcha v2',
                'desc'  => 'Gunakan reCaptcha v2 di Form Login, Komentar dan WebsweetStudio Toko <br>
                        Untuk <strong>Contact Form 7</strong> gunakan <code>[recaptcha]</code>'
            ],
            [
                'id'    => 'captcha_Sweetaddons',
                'sub'   => 'sitekey',
                'type'  => 'text',
                'title' => 'Sitekey'
            ],
            [
                'id'    => 'captcha_Sweetaddons',
                'sub'   => 'secretkey',
                'type'  => 'text',
                'title' => 'Secretkey'
            ]
        ];

?>
        <div class="wrap vd-ons">
            <h1>Spam Protection</h1>

            <form method="post" action="options.php">
                <?php settings_fields('custom_admin_options_group'); ?>
                <?php do_settings_sections('custom_admin_options_group'); ?>

                <table class="form-table">
                    <?php
                    foreach ($spam_fields as $data) :
                        echo '<tr>';
                        echo '<th scope="row">';
                        echo $data['title'];
                        echo '</th>';
                        echo '<td>';
                        $this->field($data);
                        echo '</td>';
                        echo '</tr>';
                    endforeach;
                    ?>
                </table>

                <div style="float:right;">
                    <?php submit_button(); ?>
                </div>
            </form>
        </div>
    <?php
    }

    public function options_page_callback()
    {
        $main_fields = [
            [
                'id'    => 'license_key',
                'type'  => 'text',
                'title' => 'License Key',
                'std'   => '',
                'label' => 'Masukkan license key untuk mengaktifkan fitur premium.',
            ]
        ];

    ?>
        <div class="wrap vd-ons">
            <h1>Sweet Addons</h1>
            <p>Selamat datang di pengaturan Sweet Addons. Gunakan menu di sebelah kiri untuk mengakses pengaturan yang berbeda.</p>

            <form method="post" action="options.php">
                <?php settings_fields('custom_admin_options_group'); ?>
                <?php do_settings_sections('custom_admin_options_group'); ?>

                <table class="form-table">
                    <?php
                    foreach ($main_fields as $data) :
                        echo '<tr>';
                        echo '<th scope="row">';
                        echo $data['title'];
                        echo '</th>';
                        echo '<td>';
                        $this->field($data);
                        echo '<button type="button" class="button check-license" style="margin-left: 10px;">Check License</button>';
                        echo '<div class="license-status" style="margin-top: 5px;"></div>';
                        echo '</td>';
                        echo '</tr>';
                    endforeach;
                    ?>
                </table>

                <div style="float:right;">
                    <?php submit_button(); ?>
                </div>

                <script>
                    jQuery(document).ready(function($) {
                        $('.check-license').click(function(e) {
                            e.preventDefault();

                            var licenseKey = $('#license_key').val();

                            // Check if license key is not empty
                            if (licenseKey === '') {
                                alert('Please enter a license key.');
                                return;
                            }

                            $.ajax({
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                type: 'POST',
                                data: {
                                    action: 'check_license',
                                    license_key: licenseKey
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('.license-status').html('License verified');
                                    } else {
                                        $('.license-status').html(response.data);
                                    }
                                },
                                error: function() {
                                    $('.license-status').html('Server not reachable');
                                }
                            });
                        });
                    });
                </script>

            </form>
        </div>
<?php
    }
}

// Initialize the Pengaturan Admin page
$custom_admin_options_page = new Custom_Admin_Option_Page();
