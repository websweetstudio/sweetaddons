<?php

/**
 * The Block Login settings page functionality
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweetaddons
 * @subpackage Sweetaddons/admin
 */

class Sweet_Option_Block
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_submenu_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_submenu_page()
    {
        add_submenu_page(
            'custom_admin_options',     // Parent slug
            'Block Login',              // Page title
            'Block Login',              // Menu title
            'manage_options',           // Capability
            'Sweetaddons_block',       // Menu slug
            array($this, 'block_page_callback') // Callback function
        );
    }

    public function register_settings()
    {
        register_setting('Sweetaddons_block_group', 'block_wp_login');
        register_setting('Sweetaddons_block_group', 'whitelist_block_wp_login');
        register_setting('Sweetaddons_block_group', 'whitelist_country');
        register_setting('Sweetaddons_block_group', 'redirect_to');
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

    public function block_page_callback()
    {
        $block_fields = [
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
        ];

?>
        <div class="wrap vd-ons">
            <h1>Block Login Settings</h1>

            <form method="post" action="options.php">
                <?php settings_fields('Sweetaddons_block_group'); ?>
                <?php do_settings_sections('Sweetaddons_block_group'); ?>

                <table class="form-table">
                    <?php
                    foreach ($block_fields as $data) :
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
}

// Initialize the Block page
$sweet_option_block = new Sweet_Option_Block();
