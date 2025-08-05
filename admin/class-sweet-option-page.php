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

        // Add visitor statistics submenu
        add_submenu_page(
            'custom_admin_options',     // Parent slug
            'Visitor Statistics',       // Page title
            'Visitor Statistics',       // Menu title
            'manage_options',           // Capability
            'Sweetaddons_visitor_stats', // Menu slug
            array($this, 'visitor_stats_page_callback') // Callback function
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
    ?>
        <div class="wrap vd-ons">
            <h1>Sweet Addons Dashboard</h1>
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
                    <tr><td><strong>Total Users:</strong></td><td><?php echo esc_html($total_users); ?></td></tr>
                </table>
            </div>

            <!-- Theme & Plugin Information -->
            <div class="report-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #23282d;">🎨 Theme & Plugin</h3>
                <table class="report-table" style="width: 100%; font-size: 14px;">
                    <tr><td><strong>Active Theme:</strong></td><td><?php echo esc_html($theme_name); ?></td></tr>
                    <tr><td><strong>Theme Version:</strong></td><td><?php echo esc_html($theme_version); ?></td></tr>
                    <tr><td><strong>Active Plugins:</strong></td><td><?php echo esc_html($active_plugin_count); ?></td></tr>
                    <tr><td><strong>Total Plugins:</strong></td><td><?php echo esc_html($total_plugin_count); ?></td></tr>
                </table>
            </div>

            <!-- Server Information -->
            <div class="report-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #23282d;">🖥️ Server Information</h3>
                <table class="report-table" style="width: 100%; font-size: 14px;">
                    <tr><td><strong>PHP Version:</strong></td><td><?php echo esc_html($php_version); ?></td></tr>
                    <tr><td><strong>Memory Limit:</strong></td><td><?php echo esc_html($memory_limit); ?></td></tr>
                    <tr><td><strong>Max Execution Time:</strong></td><td><?php echo esc_html($max_execution_time); ?>s</td></tr>
                    <tr><td><strong>Database Size:</strong></td><td><?php echo esc_html($db_size); ?> MB</td></tr>
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
        $summary_stats = $stats_handler->get_summary_stats();
        $daily_stats = $stats_handler->get_daily_stats(30);
        $page_stats = $stats_handler->get_page_stats(30);
        $referer_stats = $stats_handler->get_referer_stats(30);
        
        ?>
        <div class="wrap vd-ons">
            <h1>📊 Visitor Statistics</h1>
            
            <!-- Summary Cards -->
            <div class="stats-summary" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;">
                
                <div class="stat-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 10px 0; color: #0073aa;">Today</h3>
                    <div style="font-size: 24px; font-weight: bold; color: #23282d;"><?php echo $summary_stats['today']->unique_visitors ?: 0; ?></div>
                    <div style="color: #666; font-size: 14px;">Unique Visitors</div>
                    <div style="color: #999; font-size: 12px;"><?php echo $summary_stats['today']->total_visits ?: 0; ?> total visits</div>
                </div>

                <div class="stat-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 10px 0; color: #0073aa;">This Week</h3>
                    <div style="font-size: 24px; font-weight: bold; color: #23282d;"><?php echo $summary_stats['this_week']->unique_visitors ?: 0; ?></div>
                    <div style="color: #666; font-size: 14px;">Unique Visitors</div>
                    <div style="color: #999; font-size: 12px;"><?php echo $summary_stats['this_week']->total_visits ?: 0; ?> total visits</div>
                </div>

                <div class="stat-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 10px 0; color: #0073aa;">This Month</h3>
                    <div style="font-size: 24px; font-weight: bold; color: #23282d;"><?php echo $summary_stats['this_month']->unique_visitors ?: 0; ?></div>
                    <div style="color: #666; font-size: 14px;">Unique Visitors</div>
                    <div style="color: #999; font-size: 12px;"><?php echo $summary_stats['this_month']->total_visits ?: 0; ?> total visits</div>
                </div>

                <div class="stat-card" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 10px 0; color: #0073aa;">All Time</h3>
                    <div style="font-size: 24px; font-weight: bold; color: #23282d;"><?php echo $summary_stats['all_time']->unique_visitors ?: 0; ?></div>
                    <div style="color: #666; font-size: 14px;">Unique Visitors</div>
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
                    <h3 style="margin-top: 0; color: #23282d;">📄 Top Pages</h3>
                    <canvas id="topPagesChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Data Tables Section -->
            <div class="tables-section" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
                
                <!-- Top Pages Table -->
                <div class="table-container" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin-top: 0; color: #23282d;">🏆 Top Pages (Last 30 Days)</h3>
                    <table class="widefat striped" style="margin-top: 15px;">
                        <thead>
                            <tr>
                                <th>Page URL</th>
                                <th>Unique Visitors</th>
                                <th>Total Views</th>
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
                    <h3 style="margin-top: 0; color: #23282d;">🔗 Top Referrers (Last 30 Days)</h3>
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
                        label: 'Unique Visitors',
                        data: uniqueVisitsData,
                        borderColor: '#0073aa',
                        backgroundColor: 'rgba(0, 115, 170, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Total Visits',
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
        </script>

        <style>
        @media (max-width: 768px) {
            .stats-summary,
            .charts-section,
            .tables-section {
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
}

// Initialize the Pengaturan Admin page
$custom_admin_options_page = new Custom_Admin_Option_Page();
