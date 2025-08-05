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
            'Proteksi Spam',            // Page title
            'Proteksi Spam',            // Menu title
            'manage_options',           // Capability
            'Sweetaddons_spam',        // Menu slug
            array($this, 'spam_page_callback') // Callback function
        );

        // Add visitor statistics submenu
        add_submenu_page(
            'custom_admin_options',     // Parent slug
            'Statistik Pengunjung',     // Page title
            'Statistik Pengunjung',     // Menu title
            'manage_options',           // Capability
            'Sweetaddons_visitor_stats', // Menu slug
            array($this, 'visitor_stats_page_callback') // Callback function
        );

        // Add SEO submenu
        add_submenu_page(
            'custom_admin_options',     // Parent slug
            'Pengaturan SEO',           // Page title
            'Pengaturan SEO',           // Menu title
            'manage_options',           // Capability
            'Sweetaddons_seo',         // Menu slug
            array($this, 'seo_page_callback') // Callback function
        );

        // Add reCaptcha submenu
        add_submenu_page(
            'custom_admin_options',     // Parent slug
            'Pengaturan reCaptcha',     // Page title
            'reCaptcha',               // Menu title
            'manage_options',           // Capability
            'Sweetaddons_recaptcha',   // Menu slug
            array($this, 'recaptcha_page_callback') // Callback function
        );

        // Add White Label submenu
        add_submenu_page(
            'custom_admin_options',     // Parent slug
            'White Label',              // Page title
            'White Label',              // Menu title
            'manage_options',           // Capability
            'Sweetaddons_whitelabel',  // Menu slug
            array($this, 'whitelabel_page_callback') // Callback function
        );

        // Add WhatsApp submenu
        add_submenu_page(
            'custom_admin_options',     // Parent slug
            'Chat WhatsApp',            // Page title
            'Chat WhatsApp',            // Menu title
            'manage_options',           // Capability
            'Sweetaddons_whatsapp',    // Menu slug
            array($this, 'whatsapp_page_callback') // Callback function
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
        
        // SEO settings
        register_setting('sweetaddons_seo_group', 'sweetaddons_seo_home_title');
        register_setting('sweetaddons_seo_group', 'sweetaddons_seo_home_description');
        register_setting('sweetaddons_seo_group', 'sweetaddons_seo_default_og_image');
        register_setting('sweetaddons_seo_group', 'sweetaddons_seo_twitter_site');
        register_setting('sweetaddons_seo_group', 'sweetaddons_seo_enable_sitemap');
        register_setting('sweetaddons_seo_group', 'sweetaddons_seo_google_analytics');
        register_setting('sweetaddons_seo_group', 'sweetaddons_seo_google_search_console');
        
        // reCaptcha settings
        register_setting('sweetaddons_recaptcha_group', 'captcha_Sweetaddons');
        
        // White Label settings
        register_setting('sweetaddons_whitelabel_group', 'sweetaddons_whitelabel_plugin_name');
        register_setting('sweetaddons_whitelabel_group', 'sweetaddons_whitelabel_plugin_uri');
        register_setting('sweetaddons_whitelabel_group', 'sweetaddons_whitelabel_description');
        register_setting('sweetaddons_whitelabel_group', 'sweetaddons_whitelabel_author');
        register_setting('sweetaddons_whitelabel_group', 'sweetaddons_whitelabel_author_uri');
        register_setting('sweetaddons_whitelabel_group', 'sweetaddons_whitelabel_version');
        register_setting('sweetaddons_whitelabel_group', 'sweetaddons_whitelabel_menu_title');
        register_setting('sweetaddons_whitelabel_group', 'sweetaddons_whitelabel_hide_original');
        
        // WhatsApp settings
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_enable');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_phone');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_message');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_button_text');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_position');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_color');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_size');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_offset_x');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_offset_y');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_show_mobile');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_show_desktop');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_animation');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_bubble_style');
        register_setting('sweetaddons_whatsapp_group', 'sweetaddons_whatsapp_show_tooltip');
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
                'title' => 'Batasi Percobaan Login',
                'std'   => 1,
                'label' => 'Batasi jumlah percobaan login yang diizinkan untuk pengguna, ketika pengguna melakukan percobaan login yang melebihi 5X dalam 24 Jam, mereka akan diblokir untuk sementara waktu sebagai tindakan keamanan.',
            ],
            [
                'id'    => 'disable_xmlrpc',
                'type'  => 'checkbox',
                'title' => 'Nonaktifkan XML-RPC',
                'std'   => 1,
                'label' => 'Nonaktifkan protokol XML-RPC pada situs. XML-RPC digunakan oleh beberapa aplikasi atau layanan pihak ketiga untuk berinteraksi dengan situs WordPress.',
            ],
            [
                'id'    => 'disable_rest_api',
                'type'  => 'checkbox',
                'title' => 'Nonaktifkan REST API / JSON',
                'std'   => 0,
                'label' => 'Nonaktifkan akses ke REST API untuk keperluan keamanan atau privasi.',
            ],
        ];

?>
        <div class="wrap vd-ons">
            <h1>Proteksi Spam</h1>

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
    ?>
        <div class="wrap vd-ons">
            <h1>Dashboard Sweet Addons</h1>
            <p>Selamat datang di pengaturan Sweet Addons. Gunakan menu di sebelah kiri untuk mengakses pengaturan yang berbeda.</p>

            <div class="websweet-dashboard">
                <?php echo $this->generate_website_report(); ?>
            </div>
        </div>
<?php
    }

    public function generate_website_report()
    {
        ob_start();
        
        // Get site information
        $site_url = get_site_url();
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $wp_version = get_bloginfo('version');
        $theme = wp_get_theme();
        $admin_email = get_option('admin_email');
        
        // Get user counts
        $user_count = count_users();
        $total_users = $user_count['total_users'];
        
        // Get post counts
        $post_counts = wp_count_posts();
        $published_posts = $post_counts->publish;
        $draft_posts = $post_counts->draft;
        
        // Get page counts
        $page_counts = wp_count_posts('page');
        $published_pages = $page_counts->publish;
        
        // Get plugin information
        $active_plugins = get_option('active_plugins');
        $all_plugins = get_plugins();
        $active_plugin_count = count($active_plugins);
        $total_plugin_count = count($all_plugins);
        
        // Get theme information
        $theme_name = $theme->get('Name');
        $theme_version = $theme->get('Version');
        
        // Get database information
        global $wpdb;
        $db_size = $wpdb->get_var("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS 'DB Size in MB' FROM information_schema.tables WHERE table_schema='{$wpdb->dbname}'");
        
        // Get server information
        $php_version = phpversion();
        $max_execution_time = ini_get('max_execution_time');
        $memory_limit = ini_get('memory_limit');
        
        ?>
        <div class="websweet-report-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0;">
            
            <!-- Site Information -->
            <div class="report-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #23282d;">🌐 Informasi Website</h3>
                <table class="report-table" style="width: 100%; font-size: 14px;">
                    <tr><td><strong>Nama Website:</strong></td><td><?php echo esc_html($site_name); ?></td></tr>
                    <tr><td><strong>URL:</strong></td><td><a href="<?php echo esc_url($site_url); ?>" target="_blank"><?php echo esc_url($site_url); ?></a></td></tr>
                    <tr><td><strong>Deskripsi:</strong></td><td><?php echo esc_html($site_description); ?></td></tr>
                    <tr><td><strong>Email Admin:</strong></td><td><?php echo esc_html($admin_email); ?></td></tr>
                    <tr><td><strong>WordPress Version:</strong></td><td><?php echo esc_html($wp_version); ?></td></tr>
                </table>
            </div>

            <!-- Content Statistics -->
            <div class="report-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #23282d;">📝 Statistik Konten</h3>
                <table class="report-table" style="width: 100%; font-size: 14px;">
                    <tr><td><strong>Posts Terpublikasi:</strong></td><td><?php echo esc_html($published_posts); ?></td></tr>
                    <tr><td><strong>Draft Posts:</strong></td><td><?php echo esc_html($draft_posts); ?></td></tr>
                    <tr><td><strong>Pages Terpublikasi:</strong></td><td><?php echo esc_html($published_pages); ?></td></tr>
                    <tr><td><strong>Total Pengguna:</strong></td><td><?php echo esc_html($total_users); ?></td></tr>
                </table>
            </div>

            <!-- Theme & Plugin Information -->
            <div class="report-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #23282d;">🎨 Theme & Plugin</h3>
                <table class="report-table" style="width: 100%; font-size: 14px;">
                    <tr><td><strong>Active Theme:</strong></td><td><?php echo esc_html($theme_name); ?></td></tr>
                    <tr><td><strong>Theme Version:</strong></td><td><?php echo esc_html($theme_version); ?></td></tr>
                    <tr><td><strong>Active Plugins:</strong></td><td><?php echo esc_html($active_plugin_count); ?></td></tr>
                    <tr><td><strong>Total Plugin:</strong></td><td><?php echo esc_html($total_plugin_count); ?></td></tr>
                </table>
            </div>

            <!-- Server Information -->
            <div class="report-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #23282d;">🖥️ Server Information</h3>
                <table class="report-table" style="width: 100%; font-size: 14px;">
                    <tr><td><strong>PHP Version:</strong></td><td><?php echo esc_html($php_version); ?></td></tr>
                    <tr><td><strong>Memory Limit:</strong></td><td><?php echo esc_html($memory_limit); ?></td></tr>
                    <tr><td><strong>Max Execution Time:</strong></td><td><?php echo esc_html($max_execution_time); ?>s</td></tr>
                    <tr><td><strong>Ukuran Database:</strong></td><td><?php echo esc_html($db_size); ?> MB</td></tr>
                </table>
            </div>

            <!-- Sweet Addons Status -->
            <div class="report-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #23282d;">⚙️ Sweet Addons Status</h3>
                <table class="report-table" style="width: 100%; font-size: 14px;">
                    <tr><td><strong>Disable Comments:</strong></td><td><?php echo get_option('fully_disable_comment') ? '✅ Aktif' : '❌ Nonaktif'; ?></td></tr>
                    <tr><td><strong>Hide Admin Notice:</strong></td><td><?php echo get_option('hide_admin_notice') ? '✅ Aktif' : '❌ Nonaktif'; ?></td></tr>
                    <tr><td><strong>Maintenance Mode:</strong></td><td><?php echo get_option('maintenance_mode') ? '✅ Aktif' : '❌ Nonaktif'; ?></td></tr>
                    <tr><td><strong>Limit Login Attempts:</strong></td><td><?php echo get_option('limit_login_attempts') ? '✅ Aktif' : '❌ Nonaktif'; ?></td></tr>
                    <tr><td><strong>Block wp-login:</strong></td><td><?php echo get_option('block_wp_login') ? '✅ Aktif' : '❌ Nonaktif'; ?></td></tr>
                </table>
            </div>

            <!-- Quick Actions -->
            <div class="report-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #23282d;">🚀 Quick Actions</h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="<?php echo admin_url('admin.php?page=Sweetaddons_visitor_stats'); ?>" class="button button-primary">📊 Visitor Statistics</a>
                    <a href="<?php echo admin_url('admin.php?page=Sweetaddons_seo'); ?>" class="button button-primary">🔍 SEO Settings</a>
                    <a href="<?php echo admin_url('admin.php?page=Sweetaddons_recaptcha'); ?>" class="button button-primary">🛡️ reCaptcha</a>
                    <a href="<?php echo admin_url('admin.php?page=Sweetaddons_whitelabel'); ?>" class="button button-primary">🏷️ White Label</a>
                    <a href="<?php echo admin_url('admin.php?page=Sweetaddons_whatsapp'); ?>" class="button button-primary">💬 WhatsApp Chat</a>
                    <a href="<?php echo admin_url('options-general.php?page=Sweetaddons_umum'); ?>" class="button button-secondary">Pengaturan Umum</a>
                    <a href="<?php echo admin_url('options-general.php?page=Sweetaddons_maintenance'); ?>" class="button button-secondary">Maintenance Mode</a>
                    <a href="<?php echo admin_url('options-general.php?page=Sweetaddons_block'); ?>" class="button button-secondary">Block Login</a>
                    <a href="<?php echo admin_url('options-general.php?page=Sweetaddons_spam'); ?>" class="button button-secondary">Spam Protection</a>
                </div>
            </div>
        </div>
        
        <style>
        .report-table td {
            padding: 8px 0;
            border-bottom: 1px solid #f1f1f1;
        }
        .report-table td:first-child {
            width: 50%;
            padding-right: 10px;
        }
        .report-card h3 {
            border-bottom: 2px solid #0073aa;
            padding-bottom: 10px;
        }
        @media (max-width: 768px) {
            .websweet-report-grid {
                grid-template-columns: 1fr !important;
            }
        }
        </style>
        <?php
        
        return ob_get_clean();
    }

    public function visitor_stats_page_callback()
    {
        $stats_handler = new Sweetaddons_Visitor_Stats();
        
        // Handle rebuild request
        $rebuild_message = '';
        if (isset($_POST['rebuild_stats']) && wp_verify_nonce($_POST['_wpnonce'], 'rebuild_stats')) {
            $daily_count = $stats_handler->rebuild_daily_stats();
            $page_count = $stats_handler->rebuild_page_stats();
            $rebuild_message = "<div class='notice notice-success'><p>✅ Statistik berhasil dibangun ulang! Memproses {$daily_count} data harian dan {$page_count} data halaman.</p></div>";
        }
        
        $summary_stats = $stats_handler->get_summary_stats();
        $daily_stats = $stats_handler->get_daily_stats(30);
        $page_stats = $stats_handler->get_page_stats(30);
        $referer_stats = $stats_handler->get_referer_stats(30);
        
        ?>
        <div class="wrap vd-ons">
            <h1>📊 Statistik Pengunjung</h1>
            
            <?php echo $rebuild_message; ?>
            
            <!-- Rebuild Stats Button -->
            <div style="margin: 20px 0;">
                <form method="post" style="display: inline;">
                    <?php wp_nonce_field('rebuild_stats'); ?>
                    <input type="hidden" name="rebuild_stats" value="1">
                    <button type="submit" class="button button-secondary" onclick="return confirm('Apakah Anda yakin ingin membangun ulang statistik? Ini akan menghitung ulang semua data dari log yang ada.')">
                        🔄 Bangun Ulang Statistik
                    </button>
                    <span style="margin-left: 10px; color: #666; font-size: 13px;">
                        Use this if visitor counts appear incorrect
                    </span>
                </form>
            </div>
            
            <!-- Summary Cards -->
            <div class="stats-summary" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;">
                
                <div class="stat-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 10px 0; color: #0073aa;">Hari Ini</h3>
                    <div style="font-size: 24px; font-weight: bold; color: #23282d;"><?php echo $summary_stats['today']->unique_visitors ?: 0; ?></div>
                    <div style="color: #666; font-size: 14px;">Pengunjung Unik</div>
                    <div style="color: #999; font-size: 12px;"><?php echo $summary_stats['today']->total_visits ?: 0; ?> total visits</div>
                </div>

                <div class="stat-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 10px 0; color: #0073aa;">Minggu Ini</h3>
                    <div style="font-size: 24px; font-weight: bold; color: #23282d;"><?php echo $summary_stats['this_week']->unique_visitors ?: 0; ?></div>
                    <div style="color: #666; font-size: 14px;">Pengunjung Unik</div>
                    <div style="color: #999; font-size: 12px;"><?php echo $summary_stats['this_week']->total_visits ?: 0; ?> total visits</div>
                </div>

                <div class="stat-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 10px 0; color: #0073aa;">Bulan Ini</h3>
                    <div style="font-size: 24px; font-weight: bold; color: #23282d;"><?php echo $summary_stats['this_month']->unique_visitors ?: 0; ?></div>
                    <div style="color: #666; font-size: 14px;">Pengunjung Unik</div>
                    <div style="color: #999; font-size: 12px;"><?php echo $summary_stats['this_month']->total_visits ?: 0; ?> total visits</div>
                </div>

                <div class="stat-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 10px 0; color: #0073aa;">All Time</h3>
                    <div style="font-size: 24px; font-weight: bold; color: #23282d;"><?php echo $summary_stats['all_time']->unique_visitors ?: 0; ?></div>
                    <div style="color: #666; font-size: 14px;">Pengunjung Unik</div>
                    <div style="color: #999; font-size: 12px;"><?php echo $summary_stats['all_time']->total_visits ?: 0; ?> total visits</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
                
                <!-- Daily Visits Chart -->
                <div class="chart-container" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin-top: 0; color: #23282d;">📈 Daily Visits (Last 30 Days)</h3>
                    <canvas id="dailyVisitsChart" width="400" height="200"></canvas>
                </div>

                <!-- Top Pages Chart -->
                <div class="chart-container" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin-top: 0; color: #23282d;">📄 Halaman Teratas</h3>
                    <canvas id="topPagesChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Shortcode Usage Section -->
            <div class="shortcode-section" style="background: #fff; padding: 30px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                <h3 style="margin-top: 0; color: #23282d;">📋 Shortcode Usage - [statistic]</h3>
                <p style="color: #666; margin-bottom: 25px;">Tampilkan statistik visitor di halaman, post, atau widget dengan shortcode yang fleksibel.</p>
                
                <div class="shortcode-examples" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    
                    <!-- Basic Examples -->
                    <div class="shortcode-group">
                        <h4 style="color: #23282d; margin-bottom: 15px;">🎯 Basic Usage</h4>
                        
                        <div class="shortcode-item" style="margin-bottom: 20px;">
                            <div class="shortcode-code" style="background: #f1f1f1; padding: 12px; border-radius: 6px; font-family: monospace; margin-bottom: 10px;">
                                <span style="color: #0073aa; cursor: pointer;" onclick="copyToClipboard('[statistic]')">[statistic]</span>
                                <button onclick="copyToClipboard('[statistic]')" style="float: right; background: #0073aa; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; cursor: pointer;">Copy</button>
                            </div>
                            <div class="shortcode-desc" style="font-size: 13px; color: #666;">Tampilkan semua statistik dengan layout default</div>
                        </div>

                        <div class="shortcode-item" style="margin-bottom: 20px;">
                            <div class="shortcode-code" style="background: #f1f1f1; padding: 12px; border-radius: 6px; font-family: monospace; margin-bottom: 10px;">
                                <span style="color: #0073aa; cursor: pointer;" onclick="copyToClipboard('[statistic show=&quot;today&quot;]')">[statistic show="today"]</span>
                                <button onclick="copyToClipboard('[statistic show=&quot;today&quot;]')" style="float: right; background: #0073aa; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; cursor: pointer;">Copy</button>
                            </div>
                            <div class="shortcode-desc" style="font-size: 13px; color: #666;">Hanya statistik hari ini</div>
                        </div>

                        <div class="shortcode-item" style="margin-bottom: 20px;">
                            <div class="shortcode-code" style="background: #f1f1f1; padding: 12px; border-radius: 6px; font-family: monospace; margin-bottom: 10px;">
                                <span style="color: #0073aa; cursor: pointer;" onclick="copyToClipboard('[statistic show=&quot;total&quot;]')">[statistic show="total"]</span>
                                <button onclick="copyToClipboard('[statistic show=&quot;total&quot;]')" style="float: right; background: #0073aa; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; cursor: pointer;">Copy</button>
                            </div>
                            <div class="shortcode-desc" style="font-size: 13px; color: #666;">Hanya total statistik</div>
                        </div>
                    </div>

                    <!-- Advanced Examples -->
                    <div class="shortcode-group">
                        <h4 style="color: #23282d; margin-bottom: 15px;">⚙️ Advanced Usage</h4>
                        
                        <div class="shortcode-item" style="margin-bottom: 20px;">
                            <div class="shortcode-code" style="background: #f1f1f1; padding: 12px; border-radius: 6px; font-family: monospace; margin-bottom: 10px;">
                                <span style="color: #0073aa; cursor: pointer;" onclick="copyToClipboard('[statistic style=&quot;cards&quot; columns=&quot;2&quot;]')">[statistic style="cards" columns="2"]</span>
                                <button onclick="copyToClipboard('[statistic style=&quot;cards&quot; columns=&quot;2&quot;]')" style="float: right; background: #0073aa; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; cursor: pointer;">Copy</button>
                            </div>
                            <div class="shortcode-desc" style="font-size: 13px; color: #666;">Style card dengan 2 kolom</div>
                        </div>

                        <div class="shortcode-item" style="margin-bottom: 20px;">
                            <div class="shortcode-code" style="background: #f1f1f1; padding: 12px; border-radius: 6px; font-family: monospace; margin-bottom: 10px;">
                                <span style="color: #0073aa; cursor: pointer;" onclick="copyToClipboard('[statistic style=&quot;minimal&quot; columns=&quot;1&quot;]')">[statistic style="minimal" columns="1"]</span>
                                <button onclick="copyToClipboard('[statistic style=&quot;minimal&quot; columns=&quot;1&quot;]')" style="float: right; background: #0073aa; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; cursor: pointer;">Copy</button>
                            </div>
                            <div class="shortcode-desc" style="font-size: 13px; color: #666;">Style minimal untuk sidebar</div>
                        </div>

                        <div class="shortcode-item" style="margin-bottom: 20px;">
                            <div class="shortcode-code" style="background: #f1f1f1; padding: 12px; border-radius: 6px; font-family: monospace; margin-bottom: 10px;">
                                <span style="color: #0073aa; cursor: pointer;" onclick="copyToClipboard('[statistic show=&quot;today&quot; style=&quot;cards&quot; columns=&quot;2&quot;]')">[statistic show="today" style="cards" columns="2"]</span>
                                <button onclick="copyToClipboard('[statistic show=&quot;today&quot; style=&quot;cards&quot; columns=&quot;2&quot;]')" style="float: right; background: #0073aa; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; cursor: pointer;">Copy</button>
                            </div>
                            <div class="shortcode-desc" style="font-size: 13px; color: #666;">Kombinasi: hari ini, style card, 2 kolom</div>
                        </div>
                    </div>
                </div>

                <!-- Parameters Reference -->
                <div class="parameters-reference" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <h4 style="color: #23282d; margin-bottom: 15px;">📚 Parameter Reference</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                        
                        <div class="param-group">
                            <strong style="color: #0073aa;">show</strong>
                            <div style="font-size: 13px; color: #666; margin-top: 5px;">
                                • <code>all</code> - Semua data (default)<br>
                                • <code>today</code> - Hanya hari ini<br>
                                • <code>total</code> - Hanya total
                            </div>
                        </div>

                        <div class="param-group">
                            <strong style="color: #0073aa;">style</strong>
                            <div style="font-size: 13px; color: #666; margin-top: 5px;">
                                • <code>default</code> - Card dengan background<br>
                                • <code>minimal</code> - Style bersih<br>
                                • <code>cards</code> - Card dengan shadow
                            </div>
                        </div>

                        <div class="param-group">
                            <strong style="color: #0073aa;">columns</strong>
                            <div style="font-size: 13px; color: #666; margin-top: 5px;">
                                • <code>1</code> - Vertikal<br>
                                • <code>2</code> - Dua kolom<br>
                                • <code>3</code> - Tiga kolom<br>
                                • <code>4</code> - Empat kolom (default)
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live Preview -->
                <div class="live-preview" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <h4 style="color: #23282d; margin-bottom: 15px;">👁️ Live Preview</h4>
                    <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
                        <?php 
                        $stats_handler_preview = new Sweetaddons_Visitor_Stats();
                        echo $stats_handler_preview->statistics_shortcode(array('style' => 'cards', 'columns' => '4'));
                        ?>
                    </div>
                    <p style="font-size: 12px; color: #999; margin-top: 10px; text-align: center;">
                        Preview menggunakan: <code>[statistic style="cards" columns="4"]</code>
                    </p>
                </div>
            </div>

            <!-- Data Tables Section -->
            <div class="tables-section" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
                
                <!-- Top Pages Table -->
                <div class="table-container" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin-top: 0; color: #23282d;">🏆 Halaman Teratas (30 Hari Terakhir)</h3>
                    <table class="widefat striped" style="margin-top: 15px;">
                        <thead>
                            <tr>
                                <th>Page URL</th>
                                <th>Pengunjung Unik</th>
                                <th>Total Tampilan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($page_stats)): ?>
                                <tr><td colspan="3" style="text-align: center; color: #666;">No data available</td></tr>
                            <?php else: ?>
                                <?php foreach ($page_stats as $page): ?>
                                    <tr>
                                        <td><code><?php echo esc_html($page->page_url); ?></code></td>
                                        <td><?php echo esc_html($page->unique_visitors); ?></td>
                                        <td><?php echo esc_html($page->total_views); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Top Referrers Table -->
                <div class="table-container" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin-top: 0; color: #23282d;">🔗 Rujukan Teratas (30 Hari Terakhir)</h3>
                    <table class="widefat striped" style="margin-top: 15px;">
                        <thead>
                            <tr>
                                <th>Referrer</th>
                                <th>Visits</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($referer_stats)): ?>
                                <tr><td colspan="2" style="text-align: center; color: #666;">No data available</td></tr>
                            <?php else: ?>
                                <?php foreach ($referer_stats as $referer): ?>
                                    <tr>
                                        <td><code><?php echo esc_html(parse_url($referer->referer, PHP_URL_HOST) ?: $referer->referer); ?></code></td>
                                        <td><?php echo esc_html($referer->visits); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <script>
        // Daily Visits Chart
        const dailyData = <?php echo json_encode(array_map(function($stat) {
            return [
                'date' => $stat->visit_date,
                'unique_visits' => (int)$stat->unique_visits,
                'total_visits' => (int)$stat->total_visits
            ];
        }, $daily_stats)); ?>;

        const dailyLabels = dailyData.map(item => item.date);
        const uniqueVisitsData = dailyData.map(item => item.unique_visits);
        const totalVisitsData = dailyData.map(item => item.total_visits);

        const dailyCtx = document.getElementById('dailyVisitsChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [
                    {
                        label: 'Pengunjung Unik',
                        data: uniqueVisitsData,
                        borderColor: '#0073aa',
                        backgroundColor: 'rgba(0, 115, 170, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Total Kunjungan',
                        data: totalVisitsData,
                        borderColor: '#00a32a',
                        backgroundColor: 'rgba(0, 163, 42, 0.1)',
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        // Top Pages Chart
        const pageData = <?php echo json_encode(array_map(function($page) {
            return [
                'url' => $page->page_url,
                'views' => (int)$page->total_views
            ];
        }, array_slice($page_stats, 0, 8))); ?>;

        const pageLabels = pageData.map(item => item.url);
        const pageViews = pageData.map(item => item.views);

        const pageCtx = document.getElementById('topPagesChart').getContext('2d');
        new Chart(pageCtx, {
            type: 'bar',
            data: {
                labels: pageLabels,
                datasets: [{
                    label: 'Page Views',
                    data: pageViews,
                    backgroundColor: [
                        '#0073aa', '#00a32a', '#d63638', '#ff922b',
                        '#7c3aed', '#db2777', '#059669', '#dc2626'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0,
                            callback: function(value, index, values) {
                                const label = this.getLabelForValue(value);
                                return label.length > 20 ? label.substring(0, 20) + '...' : label;
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Copy to clipboard function
        function copyToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                // Use modern clipboard API
                navigator.clipboard.writeText(text).then(function() {
                    showCopySuccess();
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                
                try {
                    document.execCommand('copy');
                    showCopySuccess();
                } catch (err) {
                    console.error('Failed to copy text: ', err);
                }
                
                document.body.removeChild(textArea);
            }
        }

        function showCopySuccess() {
            // Create temporary success message
            const message = document.createElement('div');
            message.style.cssText = `
                position: fixed;
                top: 50px;
                right: 20px;
                background: #00a32a;
                color: white;
                padding: 12px 20px;
                border-radius: 6px;
                font-size: 14px;
                z-index: 9999;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                transition: all 0.3s ease;
            `;
            message.textContent = '✅ Shortcode copied to clipboard!';
            document.body.appendChild(message);
            
            // Animate and remove
            setTimeout(() => {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    document.body.removeChild(message);
                }, 300);
            }, 2000);
        }
        </script>

        <style>
        @media (max-width: 768px) {
            .stats-summary,
            .charts-section,
            .tables-section,
            .shortcode-examples {
                grid-template-columns: 1fr !important;
            }
        }
        
        .chart-container canvas {
            height: 200px !important;
        }
        
        .table-container table {
            font-size: 14px;
        }
        
        .table-container code {
            background: #f1f1f1;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }
        </style>
        <?php
    }

    public function seo_page_callback()
    {
        // Handle settings save
        if (isset($_POST['submit']) && wp_verify_nonce($_POST['_wpnonce'], 'sweetaddons_seo_settings')) {
            $fields = array(
                'sweetaddons_seo_home_title',
                'sweetaddons_seo_home_description', 
                'sweetaddons_seo_default_og_image',
                'sweetaddons_seo_twitter_site',
                'sweetaddons_seo_enable_sitemap',
                'sweetaddons_seo_google_analytics',
                'sweetaddons_seo_google_search_console'
            );

            foreach ($fields as $field) {
                if (isset($_POST[$field])) {
                    update_option($field, sanitize_text_field($_POST[$field]));
                }
            }

            echo '<div class="notice notice-success"><p>✅ Pengaturan SEO berhasil disimpan!</p></div>';
        }

        $home_title = get_option('sweetaddons_seo_home_title', '');
        $home_description = get_option('sweetaddons_seo_home_description', '');
        $default_og_image = get_option('sweetaddons_seo_default_og_image', '');
        $twitter_site = get_option('sweetaddons_seo_twitter_site', '');
        $enable_sitemap = get_option('sweetaddons_seo_enable_sitemap', '1');
        $google_analytics = get_option('sweetaddons_seo_google_analytics', '');
        $google_search_console = get_option('sweetaddons_seo_google_search_console', '');

        ?>
        <div class="wrap vd-ons">
            <h1>🔍 Pengaturan SEO</h1>
            <p>Optimalkan website Anda untuk mesin pencari dengan pengaturan SEO dasar ini.</p>

            <form method="post" action="">
                <?php wp_nonce_field('sweetaddons_seo_settings'); ?>

                <!-- General SEO Settings -->
                <div class="seo-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">🏠 SEO Halaman Utama</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_seo_home_title">Judul Halaman Utama</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_seo_home_title" name="sweetaddons_seo_home_title" value="<?php echo esc_attr($home_title); ?>" class="large-text" />
                                <p class="description">Kosongkan untuk menggunakan nama situs dan tagline. Maksimal 60 karakter disarankan.</p>
                                <div id="home-title-counter" style="font-size: 12px; color: #666;"></div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_seo_home_description">Deskripsi Halaman Utama</label>
                            </th>
                            <td>
                                <textarea id="sweetaddons_seo_home_description" name="sweetaddons_seo_home_description" rows="3" class="large-text"><?php echo esc_textarea($home_description); ?></textarea>
                                <p class="description">Kosongkan untuk menggunakan tagline situs. Maksimal 160 karakter disarankan.</p>
                                <div id="home-desc-counter" style="font-size: 12px; color: #666;"></div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Social Media Settings -->
                <div class="seo-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">📱 Social Media</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_seo_default_og_image">Default Open Graph Image</label>
                            </th>
                            <td>
                                <input type="url" id="sweetaddons_seo_default_og_image" name="sweetaddons_seo_default_og_image" value="<?php echo esc_url($default_og_image); ?>" class="large-text" />
                                <button type="button" class="button" id="upload-default-og-image">Upload Image</button>
                                <p class="description">Default image for social media sharing. Recommended size: 1200x630px.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_seo_twitter_site">Twitter Username</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_seo_twitter_site" name="sweetaddons_seo_twitter_site" value="<?php echo esc_attr($twitter_site); ?>" class="regular-text" placeholder="websweetstudio" />
                                <p class="description">Your Twitter username (without @).</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Technical SEO -->
                <div class="seo-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">⚙️ Technical SEO</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">XML Sitemap</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="sweetaddons_seo_enable_sitemap" value="1" <?php checked($enable_sitemap, '1'); ?> />
                                    Enable XML Sitemap generation
                                </label>
                                <p class="description">
                                    <?php if ($enable_sitemap): ?>
                                        <strong>Sitemap URL:</strong> <a href="<?php echo home_url('/?sweetaddons_sitemap=xml'); ?>" target="_blank"><?php echo home_url('/?sweetaddons_sitemap=xml'); ?></a>
                                    <?php else: ?>
                                        Enable to generate XML sitemap for search engines.
                                    <?php endif; ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Analytics -->
                <div class="seo-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">📊 Analytics & Alat Webmaster</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_seo_google_analytics">ID Google Analytics</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_seo_google_analytics" name="sweetaddons_seo_google_analytics" value="<?php echo esc_attr($google_analytics); ?>" class="regular-text" placeholder="GA4-XXXXXXXXX" />
                                <p class="description">ID Pengukuran Google Analytics 4 Anda (contoh: GA4-XXXXXXXXX).</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_seo_google_search_console">Google Search Console</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_seo_google_search_console" name="sweetaddons_seo_google_search_console" value="<?php echo esc_attr($google_search_console); ?>" class="large-text" placeholder="google1234567890abcdef.html" />
                                <p class="description">Konten meta tag verifikasi atau nama file HTML untuk Google Search Console.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- SEO Features Info -->
                <div class="seo-section" style="background: #f0f8ff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">✨ Fitur SEO yang Disertakan</h2>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">📝 Optimasi Konten</h4>
                            <ul style="margin: 0; padding-left: 20px;">
                                <li>Judul meta dan deskripsi khusus</li>
                                <li>Dukungan kata kunci meta</li>
                                <li>URL kanonik</li>
                                <li>Tag meta robots (noindex, nofollow)</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">📱 Media Sosial</h4>
                            <ul style="margin: 0; padding-left: 20px;">
                                <li>Tag meta Open Graph</li>
                                <li>Dukungan Twitter Card</li>
                                <li>Gambar media sosial khusus</li>
                                <li>Fallback otomatis</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">🔧 SEO Teknis</h4>
                            <ul style="margin: 0; padding-left: 20px;">
                                <li>Data terstruktur Schema.org</li>
                                <li>Generasi XML sitemap</li>
                                <li>Integrasi Google Analytics</li>
                                <li>Verifikasi Search Console</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">📊 Kontrol Per Postingan</h4>
                            <ul style="margin: 0; padding-left: 20px;">
                                <li>Meta box SEO di semua postingan/halaman</li>
                                <li>Penghitung karakter untuk judul/deskripsi</li>
                                <li>Pengunggah gambar untuk gambar OG</li>
                                <li>Pengaturan robots individual</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php submit_button('Save SEO Settings', 'primary', 'submit', false); ?>
            </form>
        </div>

        <script>
        jQuery(document).ready(function($) {
            // Character counters
            function updateCounter(input, counter, recommended) {
                const length = input.val().length;
                let color = '#666';
                if (length > recommended + 10) color = '#d63638';
                else if (length > recommended) color = '#ff922b';
                else if (length > recommended - 10) color = '#00a32a';
                
                counter.html(length + ' characters').css('color', color);
            }

            const homeTitleInput = $('#sweetaddons_seo_home_title');
            const homeTitleCounter = $('#home-title-counter');
            const homeDescInput = $('#sweetaddons_seo_home_description');
            const homeDescCounter = $('#home-desc-counter');

            homeTitleInput.on('input', function() {
                updateCounter(homeTitleInput, homeTitleCounter, 60);
            });

            homeDescInput.on('input', function() {
                updateCounter(homeDescInput, homeDescCounter, 160);
            });

            // Initial count
            updateCounter(homeTitleInput, homeTitleCounter, 60);
            updateCounter(homeDescInput, homeDescCounter, 160);

            // Media uploader for default OG image
            $('#upload-default-og-image').click(function(e) {
                e.preventDefault();
                
                const mediaUploader = wp.media({
                    title: 'Choose Default Open Graph Image',
                    button: { text: 'Use This Image' },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    const attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#sweetaddons_seo_default_og_image').val(attachment.url);
                });

                mediaUploader.open();
            });
        });
        </script>
        <?php
    }

    public function recaptcha_page_callback()
    {
        // Handle settings save
        if (isset($_POST['submit']) && wp_verify_nonce($_POST['_wpnonce'], 'sweetaddons_recaptcha_settings')) {
            $captcha_data = array();
            
            if (isset($_POST['captcha_aktif'])) {
                $captcha_data['aktif'] = sanitize_text_field($_POST['captcha_aktif']);
            }
            if (isset($_POST['captcha_sitekey'])) {
                $captcha_data['sitekey'] = sanitize_text_field($_POST['captcha_sitekey']);
            }
            if (isset($_POST['captcha_secretkey'])) {
                $captcha_data['secretkey'] = sanitize_text_field($_POST['captcha_secretkey']);
            }
            if (isset($_POST['captcha_login'])) {
                $captcha_data['login'] = sanitize_text_field($_POST['captcha_login']);
            }
            if (isset($_POST['captcha_comment'])) {
                $captcha_data['comment'] = sanitize_text_field($_POST['captcha_comment']);
            }
            if (isset($_POST['captcha_register'])) {
                $captcha_data['register'] = sanitize_text_field($_POST['captcha_register']);
            }

            update_option('captcha_Sweetaddons', $captcha_data);
            echo '<div class="notice notice-success"><p>✅ Pengaturan reCaptcha berhasil disimpan!</p></div>';
        }

        $captcha_settings = get_option('captcha_Sweetaddons', array());
        $aktif = isset($captcha_settings['aktif']) ? $captcha_settings['aktif'] : '';
        $sitekey = isset($captcha_settings['sitekey']) ? $captcha_settings['sitekey'] : '';
        $secretkey = isset($captcha_settings['secretkey']) ? $captcha_settings['secretkey'] : '';
        $login = isset($captcha_settings['login']) ? $captcha_settings['login'] : '';
        $comment = isset($captcha_settings['comment']) ? $captcha_settings['comment'] : '';
        $register = isset($captcha_settings['register']) ? $captcha_settings['register'] : '';

        ?>
        <div class="wrap vd-ons">
            <h1>🛡️ Pengaturan Google reCaptcha</h1>
            <p>Lindungi website Anda dari spam dan bot dengan Google reCaptcha v2.</p>

            <form method="post" action="">
                <?php wp_nonce_field('sweetaddons_recaptcha_settings'); ?>

                <!-- reCaptcha Configuration -->
                <div class="recaptcha-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">⚙️ Konfigurasi reCaptcha</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Aktifkan reCaptcha</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="captcha_aktif" value="1" <?php checked($aktif, '1'); ?> />
                                    Aktifkan Google reCaptcha v2
                                </label>
                                <p class="description">Aktifkan perlindungan reCaptcha di seluruh website Anda.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="captcha_sitekey">Site Key</label>
                            </th>
                            <td>
                                <input type="text" id="captcha_sitekey" name="captcha_sitekey" value="<?php echo esc_attr($sitekey); ?>" class="large-text" />
                                <p class="description">Site Key reCaptcha Anda dari konsol admin Google reCaptcha.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="captcha_secretkey">Kunci Rahasia</label>
                            </th>
                            <td>
                                <input type="password" id="captcha_secretkey" name="captcha_secretkey" value="<?php echo esc_attr($secretkey); ?>" class="large-text" />
                                <p class="description">Secret Key reCaptcha Anda dari konsol admin Google reCaptcha.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Protection Areas -->
                <div class="recaptcha-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">🔒 Area Perlindungan</h2>
                    <p style="color: #666; margin-bottom: 20px;">Pilih di mana menampilkan perlindungan reCaptcha.</p>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Form Login</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="captcha_login" value="1" <?php checked($login, '1'); ?> />
                                    Tambahkan reCaptcha ke form login WordPress
                                </label>
                                <p class="description">Lindungi wp-login.php dari serangan brute force.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Form Registrasi</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="captcha_register" value="1" <?php checked($register, '1'); ?> />
                                    Tambahkan reCaptcha ke form registrasi pengguna
                                </label>
                                <p class="description">Cegah registrasi pengguna otomatis.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Komentar</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="captcha_comment" value="1" <?php checked($comment, '1'); ?> />
                                    Add reCaptcha to comment forms
                                </label>
                                <p class="description">Reduce comment spam on your posts.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Setup Instructions -->
                <div class="recaptcha-section" style="background: #f0f8ff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">📋 Setup Instructions</h2>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">1. Get reCaptcha Keys</h4>
                            <ol style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Visit <a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCaptcha Admin</a></li>
                                <li>Click "+" to create a new site</li>
                                <li>Choose "reCaptcha v2" → "I'm not a robot"</li>
                                <li>Add your domain name</li>
                                <li>Salin Site Key dan Secret Key</li>
                            </ol>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">2. Konfigurasi Pengaturan</h4>
                            <ol style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Tempel Site Key dan Secret Key di atas</li>
                                <li>Enable reCaptcha protection</li>
                                <li>Select protection areas</li>
                                <li>Save settings</li>
                                <li>Test reCaptcha on your forms</li>
                            </ol>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">3. Contact Form 7</h4>
                            <p style="margin: 0; line-height: 1.6;">
                                To use reCaptcha in Contact Form 7, add this shortcode to your form:
                            </p>
                            <code style="display: block; background: #f1f1f1; padding: 10px; margin: 10px 0; border-radius: 4px;">
                                [recaptcha]
                            </code>
                            <p style="margin: 0; font-size: 13px; color: #666;">
                                The reCaptcha will automatically appear when keys are configured.
                            </p>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">4. Testing</h4>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Visit login page to test login protection</li>
                                <li>Try posting a comment to test comment protection</li>
                                <li>Check registration form if enabled</li>
                                <li>Verify reCaptcha challenge appears</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Current Status -->
                <div class="recaptcha-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">📊 Current Status</h2>
                    
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Feature</th>
                                <th>Status</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>reCaptcha Service</strong></td>
                                <td>
                                    <?php if ($aktif && $sitekey && $secretkey): ?>
                                        <span style="color: #00a32a;">✅ Active</span>
                                    <?php else: ?>
                                        <span style="color: #d63638;">❌ Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>Google reCaptcha v2 integration status</td>
                            </tr>
                            <tr>
                                <td><strong>Login Protection</strong></td>
                                <td>
                                    <?php if ($login && $aktif): ?>
                                        <span style="color: #00a32a;">✅ Protected</span>
                                    <?php else: ?>
                                        <span style="color: #999;">⚪ Disabled</span>
                                    <?php endif; ?>
                                </td>
                                <td>WordPress login form protection</td>
                            </tr>
                            <tr>
                                <td><strong>Comment Protection</strong></td>
                                <td>
                                    <?php if ($comment && $aktif): ?>
                                        <span style="color: #00a32a;">✅ Protected</span>
                                    <?php else: ?>
                                        <span style="color: #999;">⚪ Disabled</span>
                                    <?php endif; ?>
                                </td>
                                <td>Comment form spam protection</td>
                            </tr>
                            <tr>
                                <td><strong>Registration Protection</strong></td>
                                <td>
                                    <?php if ($register && $aktif): ?>
                                        <span style="color: #00a32a;">✅ Protected</span>
                                    <?php else: ?>
                                        <span style="color: #999;">⚪ Disabled</span>
                                    <?php endif; ?>
                                </td>
                                <td>User registration form protection</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <?php submit_button('Save reCaptcha Settings', 'primary', 'submit', false); ?>
            </form>
        </div>
        <?php
    }

    public function whitelabel_page_callback()
    {
        // Handle settings save
        if (isset($_POST['submit']) && wp_verify_nonce($_POST['_wpnonce'], 'sweetaddons_whitelabel_settings')) {
            $fields = array(
                'sweetaddons_whitelabel_plugin_name',
                'sweetaddons_whitelabel_plugin_uri',
                'sweetaddons_whitelabel_description',
                'sweetaddons_whitelabel_author',
                'sweetaddons_whitelabel_author_uri',
                'sweetaddons_whitelabel_version',
                'sweetaddons_whitelabel_menu_title',
                'sweetaddons_whitelabel_hide_original'
            );

            foreach ($fields as $field) {
                if (isset($_POST[$field])) {
                    update_option($field, sanitize_text_field($_POST[$field]));
                } else {
                    // Handle checkbox fields
                    if ($field === 'sweetaddons_whitelabel_hide_original') {
                        delete_option($field);
                    }
                }
            }

            echo '<div class="notice notice-success"><p>✅ Pengaturan White Label berhasil disimpan!</p></div>';
        }

        // Get current settings
        $plugin_name = get_option('sweetaddons_whitelabel_plugin_name', 'Sweet Addons');
        $plugin_uri = get_option('sweetaddons_whitelabel_plugin_uri', 'https://websweetstudio.com');
        $description = get_option('sweetaddons_whitelabel_description', 'Addon plugin for WebsweetStudio Client');
        $author = get_option('sweetaddons_whitelabel_author', 'WebsweetStudio');
        $author_uri = get_option('sweetaddons_whitelabel_author_uri', 'https://websweetstudio.com');
        $version = get_option('sweetaddons_whitelabel_version', '2.2.1');
        $menu_title = get_option('sweetaddons_whitelabel_menu_title', 'Sweet Addons');
        $hide_original = get_option('sweetaddons_whitelabel_hide_original', '');

        // Get current plugin data for reference
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/sweetaddons/sweetaddons.php');

        ?>
        <div class="wrap vd-ons">
            <h1>🏷️ Pengaturan White Label</h1>
            <p>Kustomisasi branding plugin dan informasi yang ditampilkan kepada pengguna.</p>

            <form method="post" action="">
                <?php wp_nonce_field('sweetaddons_whitelabel_settings'); ?>

                <!-- Plugin Information -->
                <div class="whitelabel-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">📋 Informasi Plugin</h2>
                    <p style="color: #666; margin-bottom: 20px;">Kustomisasi bagaimana plugin muncul di admin WordPress.</p>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whitelabel_plugin_name">Nama Plugin</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_whitelabel_plugin_name" name="sweetaddons_whitelabel_plugin_name" value="<?php echo esc_attr($plugin_name); ?>" class="large-text" />
                                <p class="description">Nama yang muncul di daftar plugin dan menu admin.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whitelabel_description">Deskripsi Plugin</label>
                            </th>
                            <td>
                                <textarea id="sweetaddons_whitelabel_description" name="sweetaddons_whitelabel_description" rows="3" class="large-text"><?php echo esc_textarea($description); ?></textarea>
                                <p class="description">Deskripsi yang ditampilkan di daftar plugin.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whitelabel_version">Versi</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_whitelabel_version" name="sweetaddons_whitelabel_version" value="<?php echo esc_attr($version); ?>" class="regular-text" />
                                <p class="description">Nomor versi plugin.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whitelabel_plugin_uri">Plugin URI</label>
                            </th>
                            <td>
                                <input type="url" id="sweetaddons_whitelabel_plugin_uri" name="sweetaddons_whitelabel_plugin_uri" value="<?php echo esc_url($plugin_uri); ?>" class="large-text" />
                                <p class="description">URL yang akan dikunjungi pengguna ketika mengklik nama plugin.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Author Information -->
                <div class="whitelabel-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">👤 Informasi Penulis</h2>
                    <p style="color: #666; margin-bottom: 20px;">Kustomisasi detail penulis yang ditampilkan dalam informasi plugin.</p>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whitelabel_author">Nama Penulis</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_whitelabel_author" name="sweetaddons_whitelabel_author" value="<?php echo esc_attr($author); ?>" class="large-text" />
                                <p class="description">Nama penulis yang ditampilkan di detail plugin.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whitelabel_author_uri">URI Penulis</label>
                            </th>
                            <td>
                                <input type="url" id="sweetaddons_whitelabel_author_uri" name="sweetaddons_whitelabel_author_uri" value="<?php echo esc_url($author_uri); ?>" class="large-text" />
                                <p class="description">The URL users will visit when clicking the author name.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Admin Customization -->
                <div class="whitelabel-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">⚙️ Admin Customization</h2>
                    <p style="color: #666; margin-bottom: 20px;">Customize the admin interface appearance.</p>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whitelabel_menu_title">Judul Menu Admin</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_whitelabel_menu_title" name="sweetaddons_whitelabel_menu_title" value="<?php echo esc_attr($menu_title); ?>" class="large-text" />
                                <p class="description">The title shown in the WordPress admin menu.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Sembunyikan Branding Asli</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="sweetaddons_whitelabel_hide_original" value="1" <?php checked($hide_original, '1'); ?> />
                                    Hide references to WebsweetStudio in admin interface
                                </label>
                                <p class="description">Remove WebsweetStudio branding from admin pages and footers.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Current vs New Comparison -->
                <div class="whitelabel-section" style="background: #f9f9f9; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">📊 Before vs After Comparison</h2>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <h4 style="color: #d63638; margin-bottom: 15px;">🔴 Current (Original)</h4>
                            <div style="background: #fff; padding: 15px; border-radius: 6px; border: 1px solid #ddd;">
                                <p><strong>Plugin Name:</strong> <?php echo esc_html($plugin_data['Name']); ?></p>
                                <p><strong>Description:</strong> <?php echo esc_html($plugin_data['Description']); ?></p>
                                <p><strong>Version:</strong> <?php echo esc_html($plugin_data['Version']); ?></p>
                                <p><strong>Author:</strong> <?php echo esc_html($plugin_data['Author']); ?></p>
                                <p><strong>Plugin URI:</strong> <?php echo esc_html($plugin_data['PluginURI']); ?></p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 style="color: #00a32a; margin-bottom: 15px;">🟢 New (White Labeled)</h4>
                            <div style="background: #fff; padding: 15px; border-radius: 6px; border: 1px solid #ddd;">
                                <p><strong>Plugin Name:</strong> <?php echo esc_html($plugin_name); ?></p>
                                <p><strong>Description:</strong> <?php echo esc_html($description); ?></p>
                                <p><strong>Version:</strong> <?php echo esc_html($version); ?></p>
                                <p><strong>Author:</strong> <?php echo esc_html($author); ?></p>
                                <p><strong>Plugin URI:</strong> <?php echo esc_html($plugin_uri); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- White Label Benefits -->
                <div class="whitelabel-section" style="background: #f0f8ff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">✨ White Label Benefits</h2>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">🏢 Professional Branding</h4>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Display your company name</li>
                                <li>Use your website URL</li>
                                <li>Custom plugin description</li>
                                <li>Professional appearance</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">👥 Client Relations</h4>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Hide third-party references</li>
                                <li>Consistent brand experience</li>
                                <li>Professional credibility</li>
                                <li>Custom support channels</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">⚙️ Easy Management</h4>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>One-click customization</li>
                                <li>Instant preview</li>
                                <li>No code modifications</li>
                                <li>Reversible changes</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">🔄 Full Control</h4>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Custom version numbers</li>
                                <li>Your support links</li>
                                <li>Branded admin interface</li>
                                <li>Complete customization</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php submit_button('Save White Label Settings', 'primary', 'submit', false); ?>
            </form>
        </div>
        <?php
    }

    public function whatsapp_page_callback()
    {
        // Handle settings save
        if (isset($_POST['submit']) && wp_verify_nonce($_POST['_wpnonce'], 'sweetaddons_whatsapp_settings')) {
            $fields = array(
                'sweetaddons_whatsapp_enable',
                'sweetaddons_whatsapp_phone',
                'sweetaddons_whatsapp_message',
                'sweetaddons_whatsapp_button_text',
                'sweetaddons_whatsapp_position',
                'sweetaddons_whatsapp_color',
                'sweetaddons_whatsapp_size',
                'sweetaddons_whatsapp_offset_x',
                'sweetaddons_whatsapp_offset_y',
                'sweetaddons_whatsapp_show_mobile',
                'sweetaddons_whatsapp_show_desktop',
                'sweetaddons_whatsapp_animation',
                'sweetaddons_whatsapp_bubble_style',
                'sweetaddons_whatsapp_show_tooltip'
            );

            foreach ($fields as $field) {
                if (isset($_POST[$field])) {
                    update_option($field, sanitize_text_field($_POST[$field]));
                } else {
                    // Handle checkbox fields
                    if (in_array($field, ['sweetaddons_whatsapp_enable', 'sweetaddons_whatsapp_show_mobile', 'sweetaddons_whatsapp_show_desktop', 'sweetaddons_whatsapp_show_tooltip'])) {
                        delete_option($field);
                    }
                }
            }

            echo '<div class="notice notice-success"><p>✅ Pengaturan Chat WhatsApp berhasil disimpan!</p></div>';
        }

        // Get current settings
        $enable = get_option('sweetaddons_whatsapp_enable', '');
        $phone = get_option('sweetaddons_whatsapp_phone', '');
        $message = get_option('sweetaddons_whatsapp_message', 'Halo! Saya butuh bantuan.');
        $button_text = get_option('sweetaddons_whatsapp_button_text', 'Chat dengan kami');
        $position = get_option('sweetaddons_whatsapp_position', 'bottom-right');
        $color = get_option('sweetaddons_whatsapp_color', '#25D366');
        $size = get_option('sweetaddons_whatsapp_size', '60');
        $offset_x = get_option('sweetaddons_whatsapp_offset_x', '20');
        $offset_y = get_option('sweetaddons_whatsapp_offset_y', '20');
        $show_mobile = get_option('sweetaddons_whatsapp_show_mobile', '1');
        $show_desktop = get_option('sweetaddons_whatsapp_show_desktop', '1');
        $animation = get_option('sweetaddons_whatsapp_animation', 'pulse');
        $bubble_style = get_option('sweetaddons_whatsapp_bubble_style', 'circle');
        $show_tooltip = get_option('sweetaddons_whatsapp_show_tooltip', '1');

        ?>
        <div class="wrap vd-ons">
            <h1>💬 Pengaturan Chat WhatsApp</h1>
            <p>Tambahkan tombol chat WhatsApp mengambang ke website Anda untuk komunikasi pelanggan yang lebih baik.</p>

            <form method="post" action="">
                <?php wp_nonce_field('sweetaddons_whatsapp_settings'); ?>

                <!-- Basic Settings -->
                <div class="whatsapp-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">⚙️ Pengaturan Dasar</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Aktifkan Chat WhatsApp</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="sweetaddons_whatsapp_enable" value="1" <?php checked($enable, '1'); ?> />
                                    Enable floating WhatsApp chat button
                                </label>
                                <p class="description">Show WhatsApp chat widget on your website.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whatsapp_phone">WhatsApp Number</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_whatsapp_phone" name="sweetaddons_whatsapp_phone" value="<?php echo esc_attr($phone); ?>" class="large-text" placeholder="+62812345678901" />
                                <p class="description">Your WhatsApp number with country code (e.g., +62812345678901).</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whatsapp_message">Pesan Default</label>
                            </th>
                            <td>
                                <textarea id="sweetaddons_whatsapp_message" name="sweetaddons_whatsapp_message" rows="3" class="large-text"><?php echo esc_textarea($message); ?></textarea>
                                <p class="description">Default message that will be pre-filled when users click the chat button.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whatsapp_button_text">Teks Tombol</label>
                            </th>
                            <td>
                                <input type="text" id="sweetaddons_whatsapp_button_text" name="sweetaddons_whatsapp_button_text" value="<?php echo esc_attr($button_text); ?>" class="large-text" />
                                <p class="description">Text shown on the button (for extended style) and tooltip.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Appearance Settings -->
                <div class="whatsapp-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">🎨 Pengaturan Tampilan</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whatsapp_bubble_style">Button Style</label>
                            </th>
                            <td>
                                <select id="sweetaddons_whatsapp_bubble_style" name="sweetaddons_whatsapp_bubble_style">
                                    <option value="circle" <?php selected($bubble_style, 'circle'); ?>>Circle (Icon Only)</option>
                                    <option value="extended" <?php selected($bubble_style, 'extended'); ?>>Extended (Icon + Text)</option>
                                </select>
                                <p class="description">Choose between circle icon or extended button with text.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whatsapp_color">Warna Tombol</label>
                            </th>
                            <td>
                                <input type="color" id="sweetaddons_whatsapp_color" name="sweetaddons_whatsapp_color" value="<?php echo esc_attr($color); ?>" />
                                <input type="text" value="<?php echo esc_attr($color); ?>" class="regular-text" readonly />
                                <p class="description">Background color of the WhatsApp button.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whatsapp_size">Ukuran Tombol</label>
                            </th>
                            <td>
                                <input type="number" id="sweetaddons_whatsapp_size" name="sweetaddons_whatsapp_size" value="<?php echo esc_attr($size); ?>" min="40" max="100" class="small-text" /> px
                                <p class="description">Ukuran tombol chat (40-100px).</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whatsapp_animation">Animasi</label>
                            </th>
                            <td>
                                <select id="sweetaddons_whatsapp_animation" name="sweetaddons_whatsapp_animation">
                                    <option value="none" <?php selected($animation, 'none'); ?>>Tanpa Animasi</option>
                                    <option value="pulse" <?php selected($animation, 'pulse'); ?>>Pulse</option>
                                    <option value="bounce" <?php selected($animation, 'bounce'); ?>>Bounce</option>
                                    <option value="shake" <?php selected($animation, 'shake'); ?>>Shake</option>
                                </select>
                                <p class="description">Efek animasi untuk tombol chat.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Position Settings -->
                <div class="whatsapp-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">📍 Pengaturan Posisi</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="sweetaddons_whatsapp_position">Posisi Tombol</label>
                            </th>
                            <td>
                                <select id="sweetaddons_whatsapp_position" name="sweetaddons_whatsapp_position">
                                    <option value="bottom-right" <?php selected($position, 'bottom-right'); ?>>Kanan Bawah</option>
                                    <option value="bottom-left" <?php selected($position, 'bottom-left'); ?>>Kiri Bawah</option>
                                    <option value="top-right" <?php selected($position, 'top-right'); ?>>Kanan Atas</option>
                                    <option value="top-left" <?php selected($position, 'top-left'); ?>>Kiri Atas</option>
                                    <option value="center-right" <?php selected($position, 'center-right'); ?>>Center Right</option>
                                    <option value="center-left" <?php selected($position, 'center-left'); ?>>Center Left</option>
                                </select>
                                <p class="description">Where to position the chat button on your website.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Jarak Offset</th>
                            <td>
                                <label>
                                    X: <input type="number" name="sweetaddons_whatsapp_offset_x" value="<?php echo esc_attr($offset_x); ?>" min="0" max="100" class="small-text" /> px
                                </label>
                                <label style="margin-left: 20px;">
                                    Y: <input type="number" name="sweetaddons_whatsapp_offset_y" value="<?php echo esc_attr($offset_y); ?>" min="0" max="100" class="small-text" /> px
                                </label>
                                <p class="description">Distance from screen edges (X = horizontal, Y = vertical).</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Visibility Settings -->
                <div class="whatsapp-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">👁️ Visibility Settings</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Device Visibility</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="sweetaddons_whatsapp_show_mobile" value="1" <?php checked($show_mobile, '1'); ?> />
                                    Tampilkan di perangkat Mobile
                                </label><br>
                                <label>
                                    <input type="checkbox" name="sweetaddons_whatsapp_show_desktop" value="1" <?php checked($show_desktop, '1'); ?> />
                                    Tampilkan di perangkat Desktop
                                </label>
                                <p class="description">Choose on which devices to display the chat button.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Tooltip</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="sweetaddons_whatsapp_show_tooltip" value="1" <?php checked($show_tooltip, '1'); ?> />
                                    Show tooltip on hover
                                </label>
                                <p class="description">Display tooltip text when hovering over the chat button.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Preview Section -->
                <div class="whatsapp-section" style="background: #f0f8ff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">👁️ Live Preview</h2>
                    <p style="color: #666; margin-bottom: 20px;">This is how your WhatsApp chat button will look:</p>
                    
                    <div style="position: relative; height: 200px; background: #f9f9f9; border: 2px dashed #ddd; border-radius: 8px; overflow: hidden;">
                        <div style="position: absolute; top: 10px; left: 10px; color: #666; font-size: 12px;">Preview Area</div>
                        
                        <?php if ($enable && $phone): ?>
                        <div class="sweetaddons-wa-preview" style="position: absolute; <?php echo ($position === 'bottom-right') ? 'bottom: 20px; right: 20px;' : 'bottom: 20px; left: 20px;'; ?>">
                            <div style="display: flex; align-items: center; <?php echo ($bubble_style === 'extended') ? 'padding: 12px 20px;' : 'width: 60px; height: 60px; justify-content: center;'; ?> background: <?php echo esc_attr($color); ?>; border-radius: <?php echo ($bubble_style === 'extended') ? '25px' : '50%'; ?>; color: white; text-decoration: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);">
                                <svg viewBox="0 0 24 24" width="24" height="24" style="<?php echo ($bubble_style === 'extended') ? 'margin-right: 8px;' : ''; ?>">
                                    <path fill="currentColor" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                                <?php if ($bubble_style === 'extended'): ?>
                                    <span style="font-size: 14px; font-weight: 500;"><?php echo esc_html($button_text); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php else: ?>
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: #666;">
                            <p>Aktifkan WhatsApp dan tambahkan nomor telepon untuk melihat preview</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Setup Instructions -->
                <div class="whatsapp-section" style="background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                    <h2 style="margin-top: 0; color: #23282d;">📋 Setup Instructions</h2>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">1. Get Your WhatsApp Number</h4>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Use your business WhatsApp number</li>
                                <li>Include country code (e.g., +62 for Indonesia)</li>
                                <li>Remove spaces and special characters</li>
                                <li>Example: +62812345678901</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">2. Konfigurasi Pengaturan</h4>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Aktifkan chat WhatsApp</li>
                                <li>Masukkan nomor telepon Anda</li>
                                <li>Kustomisasi tampilan dan posisi</li>
                                <li>Atur pesan default</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">3. Test & Optimize</h4>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Visit your website to test</li>
                                <li>Click the chat button</li>
                                <li>Verify WhatsApp opens correctly</li>
                                <li>Adjust position if needed</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 style="color: #0073aa; margin-bottom: 10px;">4. Best Practices</h4>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                                <li>Use professional greeting message</li>
                                <li>Posisi untuk akses mudah</li>
                                <li>Consider mobile users</li>
                                <li>Monitor chat responses</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php submit_button('Save WhatsApp Settings', 'primary', 'submit', false); ?>
            </form>
        </div>

        <script>
        jQuery(document).ready(function($) {
            // Color picker sync
            $('#sweetaddons_whatsapp_color').on('change', function() {
                $(this).next('input[type="text"]').val($(this).val());
            });
            
            // Real-time preview updates could be added here
        });
        </script>
        <?php
    }
}

// Initialize the Pengaturan Admin page
$custom_admin_options_page = new Custom_Admin_Option_Page();
