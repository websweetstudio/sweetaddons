<?php

/**
 * The Maintenance Mode settings page functionality
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweetaddons
 * @subpackage Sweetaddons/admin
 */

class Sweet_Option_Maintenance
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
            'Maintenance Mode',         // Page title
            'Maintenance Mode',         // Menu title
            'manage_options',           // Capability
            'Sweetaddons_maintenance', // Menu slug
            array($this, 'maintenance_page_callback') // Callback function
        );
    }

    public function register_settings()
    {
        register_setting('Sweetaddons_maintenance_group', 'maintenance_mode');
        register_setting('Sweetaddons_maintenance_group', 'maintenance_mode_data');
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

    public function maintenance_page_callback()
    {
        $maintenance_fields = [
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
        ];

?>
        <div class="wrap vd-ons">
            <h1>Maintenance Mode</h1>

            <form method="post" action="options.php">
                <?php settings_fields('Sweetaddons_maintenance_group'); ?>
                <?php do_settings_sections('Sweetaddons_maintenance_group'); ?>

                <table class="form-table">
                    <?php
                    foreach ($maintenance_fields as $data) :
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

// Initialize the Maintenance page
$sweet_option_maintenance = new Sweet_Option_Maintenance();
