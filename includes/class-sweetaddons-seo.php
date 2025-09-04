<?php

/**
 * SEO functionality for Sweet Addons
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweetaddons
 * @subpackage Sweetaddons/includes
 */

class Sweetaddons_SEO
{
    public function __construct()
    {
        add_action('wp_head', array($this, 'output_meta_tags'), 1);
        add_action('wp_head', array($this, 'output_og_tags'), 2);
        add_action('add_meta_boxes', array($this, 'add_seo_meta_boxes'));
        add_action('save_post', array($this, 'save_seo_meta_data'));
        add_action('init', array($this, 'handle_sitemap_request'));
        add_filter('wp_title', array($this, 'custom_title'), 10, 2);
        add_filter('document_title_parts', array($this, 'custom_document_title_parts'));
    }

    public function output_meta_tags()
    {
        if (is_admin() || is_feed() || is_robots() || is_trackback()) {
            return;
        }

        global $post;
        
        // Meta description
        $meta_description = $this->get_meta_description();
        if ($meta_description) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        }

        // Meta keywords
        $meta_keywords = $this->get_meta_keywords();
        if ($meta_keywords) {
            echo '<meta name="keywords" content="' . esc_attr($meta_keywords) . '">' . "\n";
        }

        // Robots meta
        $robots = $this->get_robots_meta();
        if ($robots) {
            echo '<meta name="robots" content="' . esc_attr($robots) . '">' . "\n";
        }

        // Canonical URL
        $canonical = $this->get_canonical_url();
        if ($canonical) {
            echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
        }

        // Schema.org markup
        $this->output_schema_markup();
    }

    public function output_og_tags()
    {
        if (is_admin() || is_feed() || is_robots() || is_trackback()) {
            return;
        }

        global $post;

        // Open Graph tags
        echo '<meta property="og:type" content="' . $this->get_og_type() . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($this->get_page_title()) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($this->get_canonical_url()) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";

        $og_description = $this->get_meta_description();
        if ($og_description) {
            echo '<meta property="og:description" content="' . esc_attr($og_description) . '">' . "\n";
        }

        $og_image = $this->get_og_image();
        if ($og_image) {
            echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
            
            $image_data = wp_get_attachment_image_src(attachment_url_to_postid($og_image), 'full');
            if ($image_data) {
                echo '<meta property="og:image:width" content="' . $image_data[1] . '">' . "\n";
                echo '<meta property="og:image:height" content="' . $image_data[2] . '">' . "\n";
            }
        }

        // Twitter Card tags
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($this->get_page_title()) . '">' . "\n";
        
        if ($og_description) {
            echo '<meta name="twitter:description" content="' . esc_attr($og_description) . '">' . "\n";
        }
        
        if ($og_image) {
            echo '<meta name="twitter:image" content="' . esc_url($og_image) . '">' . "\n";
        }

        $twitter_site = get_option('sweetaddons_seo_twitter_site');
        if ($twitter_site) {
            echo '<meta name="twitter:site" content="@' . esc_attr($twitter_site) . '">' . "\n";
        }
    }

    private function get_page_title()
    {
        global $post;

        if (is_singular()) {
            $custom_title = get_post_meta($post->ID, '_sweetaddons_seo_title', true);
            if ($custom_title) {
                return $custom_title;
            }
            return get_the_title($post->ID);
        }

        if (is_home() || is_front_page()) {
            $home_title = get_option('sweetaddons_seo_home_title');
            if ($home_title) {
                return $home_title;
            }
            return get_bloginfo('name') . ' - ' . get_bloginfo('description');
        }

        if (is_category()) {
            return single_cat_title('', false);
        }

        if (is_tag()) {
            return single_tag_title('', false);
        }

        if (is_archive()) {
            return strip_tags(get_the_archive_title());
        }

        return wp_get_document_title();
    }

    private function get_meta_description()
    {
        global $post;

        if (is_singular()) {
            $custom_desc = get_post_meta($post->ID, '_sweetaddons_seo_description', true);
            if ($custom_desc) {
                return $custom_desc;
            }
            
            // Auto-generate from excerpt or content
            if ($post->post_excerpt) {
                return wp_trim_words($post->post_excerpt, 25);
            }
            
            return wp_trim_words(strip_tags($post->post_content), 25);
        }

        if (is_home() || is_front_page()) {
            $home_desc = get_option('sweetaddons_seo_home_description');
            if ($home_desc) {
                return $home_desc;
            }
            return get_bloginfo('description');
        }

        if (is_category()) {
            $cat_desc = category_description();
            if ($cat_desc) {
                return wp_trim_words(strip_tags($cat_desc), 25);
            }
        }

        if (is_tag()) {
            $tag_desc = tag_description();
            if ($tag_desc) {
                return wp_trim_words(strip_tags($tag_desc), 25);
            }
        }

        return '';
    }

    private function get_meta_keywords()
    {
        global $post;

        if (is_singular()) {
            $custom_keywords = get_post_meta($post->ID, '_sweetaddons_seo_keywords', true);
            if ($custom_keywords) {
                return $custom_keywords;
            }

            // Auto-generate from tags
            $tags = get_the_tags($post->ID);
            if ($tags) {
                $keywords = array();
                foreach ($tags as $tag) {
                    $keywords[] = $tag->name;
                }
                return implode(', ', $keywords);
            }
        }

        return '';
    }

    private function get_robots_meta()
    {
        global $post;

        $robots = array();

        if (is_singular()) {
            $noindex = get_post_meta($post->ID, '_sweetaddons_seo_noindex', true);
            $nofollow = get_post_meta($post->ID, '_sweetaddons_seo_nofollow', true);

            if ($noindex) {
                $robots[] = 'noindex';
            } else {
                $robots[] = 'index';
            }

            if ($nofollow) {
                $robots[] = 'nofollow';
            } else {
                $robots[] = 'follow';
            }
        } else {
            $robots[] = 'index';
            $robots[] = 'follow';
        }

        return implode(', ', $robots);
    }

    private function get_canonical_url()
    {
        global $post;

        if (is_singular()) {
            $custom_canonical = get_post_meta($post->ID, '_sweetaddons_seo_canonical', true);
            if ($custom_canonical) {
                return $custom_canonical;
            }
            return get_permalink($post->ID);
        }

        if (is_home()) {
            return home_url('/');
        }

        if (is_category()) {
            return get_category_link(get_queried_object_id());
        }

        if (is_tag()) {
            return get_tag_link(get_queried_object_id());
        }

        if (is_archive()) {
            return get_term_link(get_queried_object());
        }

        return '';
    }

    private function get_og_type()
    {
        if (is_singular('post')) {
            return 'article';
        }

        if (is_front_page() || is_home()) {
            return 'website';
        }

        return 'website';
    }

    private function get_og_image()
    {
        global $post;

        if (is_singular()) {
            // Custom OG image
            $custom_image = get_post_meta($post->ID, '_sweetaddons_seo_og_image', true);
            if ($custom_image) {
                return $custom_image;
            }

            // Featured image
            if (has_post_thumbnail($post->ID)) {
                return get_the_post_thumbnail_url($post->ID, 'large');
            }
        }

        // Default OG image
        $default_image = get_option('sweetaddons_seo_default_og_image');
        if ($default_image) {
            return $default_image;
        }

        return '';
    }

    private function output_schema_markup()
    {
        if (is_singular('post')) {
            $this->output_article_schema();
        } elseif (is_front_page() || is_home()) {
            $this->output_website_schema();
        }
    }

    private function output_article_schema()
    {
        global $post;

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title($post->ID),
            'datePublished' => get_the_date('c', $post->ID),
            'dateModified' => get_the_modified_date('c', $post->ID),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author_meta('display_name', $post->post_author)
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url()
            )
        );

        if (has_post_thumbnail($post->ID)) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'large');
        }

        $description = $this->get_meta_description();
        if ($description) {
            $schema['description'] = $description;
        }

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
    }

    private function output_website_schema()
    {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => get_bloginfo('name'),
            'url' => home_url(),
            'description' => get_bloginfo('description'),
            'potentialAction' => array(
                '@type' => 'SearchAction',
                'target' => home_url('/?s={search_term_string}'),
                'query-input' => 'required name=search_term_string'
            )
        );

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
    }

    public function add_seo_meta_boxes()
    {
        $post_types = get_post_types(array('public' => true));
        
        foreach ($post_types as $post_type) {
            add_meta_box(
                'sweetaddons_seo_meta',
                '🔍 SEO Settings',
                array($this, 'seo_meta_box_callback'),
                $post_type,
                'normal',
                'high'
            );
        }
    }

    public function seo_meta_box_callback($post)
    {
        wp_nonce_field('sweetaddons_seo_meta_nonce', 'sweetaddons_seo_meta_nonce');

        $title = get_post_meta($post->ID, '_sweetaddons_seo_title', true);
        $description = get_post_meta($post->ID, '_sweetaddons_seo_description', true);
        $keywords = get_post_meta($post->ID, '_sweetaddons_seo_keywords', true);
        $canonical = get_post_meta($post->ID, '_sweetaddons_seo_canonical', true);
        $og_image = get_post_meta($post->ID, '_sweetaddons_seo_og_image', true);
        $noindex = get_post_meta($post->ID, '_sweetaddons_seo_noindex', true);
        $nofollow = get_post_meta($post->ID, '_sweetaddons_seo_nofollow', true);

        ?>
        <table class="form-table">
            <tr>
                <th><label for="sweetaddons_seo_title">SEO Title</label></th>
                <td>
                    <input type="text" id="sweetaddons_seo_title" name="sweetaddons_seo_title" value="<?php echo esc_attr($title); ?>" class="large-text" />
                    <p class="description">Leave empty to use post title. Recommended length: 50-60 characters.</p>
                    <div id="title-length-counter" style="font-size: 12px; color: #666;"></div>
                </td>
            </tr>
            <tr>
                <th><label for="sweetaddons_seo_description">Meta Description</label></th>
                <td>
                    <textarea id="sweetaddons_seo_description" name="sweetaddons_seo_description" rows="3" class="large-text"><?php echo esc_textarea($description); ?></textarea>
                    <p class="description">Leave empty to auto-generate. Recommended length: 150-160 characters.</p>
                    <div id="desc-length-counter" style="font-size: 12px; color: #666;"></div>
                </td>
            </tr>
            <tr>
                <th><label for="sweetaddons_seo_keywords">Meta Keywords</label></th>
                <td>
                    <input type="text" id="sweetaddons_seo_keywords" name="sweetaddons_seo_keywords" value="<?php echo esc_attr($keywords); ?>" class="large-text" />
                    <p class="description">Comma-separated keywords. Leave empty to use post tags.</p>
                </td>
            </tr>
            <tr>
                <th><label for="sweetaddons_seo_canonical">Canonical URL</label></th>
                <td>
                    <input type="url" id="sweetaddons_seo_canonical" name="sweetaddons_seo_canonical" value="<?php echo esc_url($canonical); ?>" class="large-text" />
                    <p class="description">Leave empty to use default permalink.</p>
                </td>
            </tr>
            <tr>
                <th><label for="sweetaddons_seo_og_image">Open Graph Image</label></th>
                <td>
                    <input type="url" id="sweetaddons_seo_og_image" name="sweetaddons_seo_og_image" value="<?php echo esc_url($og_image); ?>" class="large-text" />
                    <button type="button" class="button" id="upload-og-image">Upload Image</button>
                    <p class="description">Leave empty to use featured image. Recommended size: 1200x630px.</p>
                </td>
            </tr>
            <tr>
                <th>Robots Meta</th>
                <td>
                    <label>
                        <input type="checkbox" name="sweetaddons_seo_noindex" value="1" <?php checked($noindex, '1'); ?> />
                        No Index (prevent search engines from indexing this page)
                    </label><br>
                    <label>
                        <input type="checkbox" name="sweetaddons_seo_nofollow" value="1" <?php checked($nofollow, '1'); ?> />
                        No Follow (prevent search engines from following links on this page)
                    </label>
                </td>
            </tr>
        </table>

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

            const titleInput = $('#sweetaddons_seo_title');
            const titleCounter = $('#title-length-counter');
            const descInput = $('#sweetaddons_seo_description');
            const descCounter = $('#desc-length-counter');

            titleInput.on('input', function() {
                updateCounter(titleInput, titleCounter, 60);
            });

            descInput.on('input', function() {
                updateCounter(descInput, descCounter, 160);
            });

            // Initial count
            updateCounter(titleInput, titleCounter, 60);
            updateCounter(descInput, descCounter, 160);

            // Media uploader for OG image
            $('#upload-og-image').click(function(e) {
                e.preventDefault();
                
                const mediaUploader = wp.media({
                    title: 'Choose Open Graph Image',
                    button: { text: 'Use This Image' },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    const attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#sweetaddons_seo_og_image').val(attachment.url);
                });

                mediaUploader.open();
            });
        });
        </script>
        <?php
    }

    public function save_seo_meta_data($post_id)
    {
        if (!isset($_POST['sweetaddons_seo_meta_nonce']) || !wp_verify_nonce($_POST['sweetaddons_seo_meta_nonce'], 'sweetaddons_seo_meta_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $fields = array(
            'sweetaddons_seo_title' => '_sweetaddons_seo_title',
            'sweetaddons_seo_description' => '_sweetaddons_seo_description',
            'sweetaddons_seo_keywords' => '_sweetaddons_seo_keywords',
            'sweetaddons_seo_canonical' => '_sweetaddons_seo_canonical',
            'sweetaddons_seo_og_image' => '_sweetaddons_seo_og_image',
            'sweetaddons_seo_noindex' => '_sweetaddons_seo_noindex',
            'sweetaddons_seo_nofollow' => '_sweetaddons_seo_nofollow'
        );

        foreach ($fields as $field => $meta_key) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
            } else {
                delete_post_meta($post_id, $meta_key);
            }
        }
    }

    public function custom_title($title, $sep)
    {
        if (is_feed()) {
            return $title;
        }

        return $this->get_page_title();
    }

    public function custom_document_title_parts($title)
    {
        $title['title'] = $this->get_page_title();
        return $title;
    }

    public function handle_sitemap_request()
    {
        if (isset($_GET['sweetaddons_sitemap']) && $_GET['sweetaddons_sitemap'] === 'xml') {
            $this->generate_xml_sitemap();
            exit;
        }
    }

    private function generate_xml_sitemap()
    {
        header('Content-Type: application/xml; charset=utf-8');
        
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        echo '<url>' . "\n";
        echo '<loc>' . esc_url(home_url('/')) . '</loc>' . "\n";
        echo '<lastmod>' . date('c') . '</lastmod>' . "\n";
        echo '<changefreq>daily</changefreq>' . "\n";
        echo '<priority>1.0</priority>' . "\n";
        echo '</url>' . "\n";

        // Posts and pages
        $posts = get_posts(array(
            'post_type' => array('post', 'page'),
            'post_status' => 'publish',
            'numberposts' => -1
        ));

        foreach ($posts as $post) {
            $noindex = get_post_meta($post->ID, '_sweetaddons_seo_noindex', true);
            if ($noindex) continue;

            echo '<url>' . "\n";
            echo '<loc>' . esc_url(get_permalink($post->ID)) . '</loc>' . "\n";
            echo '<lastmod>' . date('c', strtotime($post->post_modified)) . '</lastmod>' . "\n";
            
            if ($post->post_type === 'post') {
                echo '<changefreq>monthly</changefreq>' . "\n";
                echo '<priority>0.8</priority>' . "\n";
            } else {
                echo '<changefreq>monthly</changefreq>' . "\n";
                echo '<priority>0.6</priority>' . "\n";
            }
            
            echo '</url>' . "\n";
        }

        echo '</urlset>';
    }
}