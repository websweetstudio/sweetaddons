<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/admin
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
            'Pengaturan Web',       // Judul halaman
            'Pengaturan Web',       // Judul menu
            'manage_options',           // Hak akses yang dibutuhkan
            'custom_admin_options',     // Slug menu
            array($this, 'options_page_callback'), // Callback untuk halaman pengaturan
            '',                         // URL icon (biarkan kosong atau tambahkan URL icon)
            70                         // Posisi menu (semakin kecil angkanya semakin tinggi posisinya)
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
        // register_setting('custom_admin_options_group', 'standar_editor_sweet_addons');
        register_setting('custom_admin_options_group', 'classic_widget_sweet_addons');
        register_setting('custom_admin_options_group', 'remove_slug_category_sweet_addons');
        register_setting('custom_admin_options_group', 'auto_resize_image_sweet_addons');
        register_setting('custom_admin_options_group', 'captcha_sweet_addons');
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

    public function options_page_callback()
    {
        $pages = [
            'umum' => [
                'title'     => 'Umum',
                'fields'    => [
                    [
                        'id'    => 'fully_disable_comment',
                        'type'  => 'checkbox',
                        'title' => 'Disable Comment',
                        'std'   => 1,
                        'label' => 'Nonaktifkan fitur komentar pada situs.',
                    ],
                    [
                        'id'    => 'hide_admin_notice',
                        'type'  => 'checkbox',
                        'title' => 'Hide Admin Notice',
                        'std'   => 0,
                        'label' => 'Sembunyikan pemberitahuan admin di halaman admin. Pemberitahuan admin seringkali muncul untuk memberikan informasi atau peringatan kepada admin situs.',
                    ],
                    [
                        'id'    => 'disable_gutenberg',
                        'type'  => 'checkbox',
                        'title' => 'Disable Gutenberg',
                        'std'   => 0,
                        'label' => 'Aktifkan untuk menggunakan editor klasik WordPress menggantikan Gutenberg.',
                    ],
                    [
                        'id'    => 'classic_widget_sweet_addons',
                        'type'  => 'checkbox',
                        'title' => 'Classic Widget',
                        'std'   => 1,
                        'label' => 'Aktifkan untuk menggunakan widget klasik.',
                    ],
                    [
                        'id'    => 'remove_slug_category_sweet_addons',
                        'type'  => 'checkbox',
                        'title' => 'Remove Slug Category',
                        'std'   => 0,
                        'label' => 'Aktifkan untuk hapus slug /category/ dari URL.',
                    ],
                ],
            ],
            'captcha' => [
                'title'     => 'Spam',
                'fields'    => [
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
                        'id'    => 'captcha_sweet_addons',
                        'sub'   => 'aktif',
                        'type'  => 'checkbox',
                        'title' => 'Captcha',
                        'std'   => 1,
                        'label' => 'Aktifkan Google reCaptcha v2',
                        'desc'  => 'Gunakan reCaptcha v2 di Form Login, Komentar dan WebsweetStudio Toko <br>
                                Untuk <strong>Contact Form 7</strong> gunakan <code>[sweet_captcha]</code>'
                    ],
                    [
                        'id'    => 'captcha_sweet_addons',
                        'sub'   => 'sitekey',
                        'type'  => 'text',
                        'title' => 'Sitekey'
                    ],
                    [
                        'id'    => 'captcha_sweet_addons',
                        'sub'   => 'secretkey',
                        'type'  => 'text',
                        'title' => 'Secretkey'
                    ]
                ],
            ],
            
            'maintenance' => [
                'title'     => 'Maintenance Mode',
                'fields'    => [
                    [
                        'id'    => 'maintenance_mode',
                        'type'  => 'checkbox',
                        'title' => 'Maintenance Mode',
                        'std'   => 1,
                        'label' => 'Aktifkan mode perawatan pada situs. Saat mode perawatan diaktifkan, pengunjung situs akan melihat halaman pemberitahuan perawatan yang menunjukkan bahwa situs sedang dalam perbaikan atau tidak tersedia sementara waktu.',
                    ],
                    [
                        'id'    => 'maintenance_mode_data',
                        'sub'   => 'header',
                        'type'  => 'text',
                        'title' => 'Header',
                        'std'   => 'Maintenance Mode',
                    ],
                    [
                        'id'    => 'maintenance_mode_data',
                        'sub'   => 'body',
                        'type'  => 'textarea',
                        'title' => 'Body',
                        'std'   => 'We are currently performing maintenance. Please check back later.',
                    ]
                ],
            ],
            'block' => [
                'title'     => 'Block Login',
                'fields'    => [
                    [
                        'id'    => 'block_wp_login',
                        'type'  => 'checkbox',
                        'title' => 'Block wp-login.php',
                        'std'   => 0,
                        'label' => 'Aktifkan pemblokiran akses ke file wp-login.php pada situs.',
                    ],
                    [
                        'id'    => 'whitelist_block_wp_login',
                        'type'  => 'text',
                        'title' => 'Whitelist IP Block wp-login.php',
                        'std'   => '',
                        'label' => 'Tambahkan daftar IP yang di Whitelist proses pemblokiran akses ke file wp-login.php.',
                    ],
                    [
                        'id'    => 'whitelist_country',
                        'type'  => 'text',
                        'title' => 'Whitelist Country',
                        'std'   => 'ID',
                        'label' => 'Batasi akses ke situs WordPress hanya untuk negara-negara tertentu dengan menggunakan ID negara sebagai pemisah, seperti contoh ID,MY,US.',
                    ],
                    [
                        'id'    => 'redirect_to',
                        'type'  => 'text',
                        'title' => 'Redirect To',
                        'std'   => 'http://127.0.0.1',
                        'label' => 'Tujuan redirect wp-login.php, jika Block wp-login.php aktif.',
                    ],
                ],
            ],
        ];

?>
        <div class="wrap vd-ons">
            <h1>Pengaturan Admin</h1>

            <form method="post" action="options.php">
                <?php settings_fields('custom_admin_options_group'); ?>
                <?php do_settings_sections('custom_admin_options_group'); ?>

                <div class="nav-tab-wrapper">
                    <?php foreach ($pages as $tab => $tabs) : ?>
                        <a href="#<?php echo $tab; ?>" class="nav-tab">
                            <?php echo $tabs['title']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="tab-content">
                    <?php foreach ($pages as $tab => $tabs) : ?>
                        <div id="<?php echo $tab; ?>" class="content">
                            <table class="form-table">
                                <?php
                                foreach ($tabs['fields'] as $ky => $data) :
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
                            <hr>
                        </div>
                    <?php endforeach; ?>
                </div>

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

                        function activeTab(id) {
                            $('.vd-ons .nav-tab').removeClass('nav-tab-active');
                            $('.vd-ons .nav-tab[href="' + id + '"]').addClass('nav-tab-active');
                            $('.vd-ons .tab-content .content').hide();
                            $('.vd-ons .tab-content ' + id).show();
                        }
                        $('.vd-ons .nav-tab').on('click', function(event) {
                            activeTab($(this).attr('href'));
                            localStorage.setItem('vdons-tabs', $(this).attr('href'));
                            event.preventDefault();
                        });
                        var act = localStorage.getItem('vdons-tabs');
                        act = act ? act : '#umum';
                        activeTab(act);
                    });
                </script>


            </form>
        </div>
<?php
    }
}

// Initialize the Pengaturan Admin page
$custom_admin_options_page = new Custom_Admin_Option_Page();
