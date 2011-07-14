<?php

function adelante_meta_boxes($meta_name = false) 
{
    $meta_boxes = array(
        'generalpost' => array(
            'id' => 'adelante_generalpost_meta',
            'title' => THEME_SLUG . ' Post Options',
            'function' => 'adelante_generalpost_meta_box',
            'noncename' => 'adelante_generalpost',                                    
            'fields' => array(
                'teaser_text_meta' => array(
                    'name' => 'teaser_text',
                    'type' => 'radio_toggle',
                    'width' => 'full',
                    'default' => 'default',
                    'value' => 'default',
                    'value2' => 'custom',
                    'value3' => 'twitter',
                    'value4' => 'disabled',
                    'desc' => 'Default',
                    'desc2' => 'Custom',
                    'desc3' => 'Twitter',
                    'desc4' => 'Disabled',
                    'title' => 'Teaser Text',
                    'description' => 'Here you can override the general header teaser text options on a post by post basis.',
                    'label' => '',
                    'margin' => true
                    ),
                'teaser_text_image_meta' => array(
                    'name' => 'teaser_image_custom',
                    'type' => 'text',
                    'width' => 'full',
                    'default' => '',
                    'title' => 'Teaser Image',
                    'description' => 'If the "Custom" "Header Teaser Text" option is selected above any image you enter here will be presented in front of your custom text.',
                    'label' => '',
                    'margin' => false                    
                ),
                'teaser_text_custom_meta' => array(
                    'name' => 'teaser_text_custom',
                    'type' => 'textarea',
                    'width' => 'full',
                    'default' => '',
                    'title' => 'Teaser Custom Text',
                    'description' => 'If the "Custom" "Header Teaser Text" option is selected above any text you enter here will override your general custom header teaser text option.',
                    'label' => '',
                    'margin' => false
                ),
                'featured_image_position' => array(
                    'name' => 'featured_image_position',
                    'type' => 'radio_toggle',
                    'width' => 'full',
                    'default' => 'top',
                    'value' => 'top',
                    'value2' => 'left',
                    'value3' => 'right',
                    'value4' => 'none',
                    'desc' => 'Above Post',
                    'desc2' => 'Left Aligned',
                    'desc3' => 'Right Aligned',
                    'desc4' => 'Disabled',
                    'title' => 'Featured Image Position',
                    'description' => 'Here you can specify the position of the featured image on a post by post basis.',
                    'label' => '',
                    'margin' => true
                ),
                'css' => array(
                    'name' => 'css',
                    'type' => 'textarea',
                    'width' => 'full',
                    'default' => '',
                    'title' => 'Custom CSS',
                    'description' => 'Specify CSS styles on a post by post basis',
                    'label' => '',
                    'margin' => false                    
                )
            )
        ),
        'generalpage' => array(
            'id' => 'adelante_generalpage_meta',
            'title' => THEME_SLUG . ' General Page Options',
            'function' => 'adelante_generalpage_meta_box',
            'noncename' => 'adelante_generalpage',        
            'fields' => array(
                'teaser_text_meta' => array(
                    'name' => 'teaser_text',
                    'type' => 'radio_toggle',
                    'width' => 'full',
                    'default' => '',
                    'value' => 'default',
                    'value2' => 'custom',
                    'value3' => 'twitter',
                    'value4' => 'disabled',
                    'desc' => 'Default',
                    'desc2' => 'Custom',
                    'desc3' => 'Twitter',
                    'desc4' => 'Disabled',
                    'title' => 'Header Teaser Text',
                    'description' => 'Here you can override the general header teaser text options on a page by page basis.',
                    'label' => '',
                    'margin' => true,
                    ),
                'teaser_text_image_meta' => array(
                    'name' => 'teaser_image_custom',
                    'type' => 'text',
                    'width' => 'full',
                    'default' => '',
                    'title' => 'Header Teaser Image',
                    'description' => 'If the "Custom" "Header Teaser Text" option is selected above any image you enter here will be presented in front of your custom text.',
                    'label' => '',
                    'margin' => false                    
                ),
                'teaser_text_custom_meta' => array(
                    'name' => 'teaser_text_custom',
                    'type' => 'textarea',
                    'width' => 'full',
                    'default' => '',
                    'title' => 'Header Teaser Custom Text',
                    'description' => 'If the "Custom" "Header Teaser Text" option is selected above any text you enter here will override your general custom header teaser text option.',
                    'label' => '',
                    'margin' => false,
            )
          )
        )
    );

    if ($meta_name)
        return $meta_boxes[$meta_name];
    else
        return $meta_boxes;
}

function adelante_add_meta_box($box_name) 
{
    global $post;

    $meta_box = adelante_meta_boxes($box_name);

    foreach ($meta_box['fields'] as $meta_id => $meta_field) {
            
        $existing_value = get_post_meta($post->ID, $meta_field['name'], true);
        $value = ($existing_value != '') ? $existing_value : $meta_field['default'];
        $margin = ($meta_field['margin']) ? ' class="add_margin"' : '';
            
        ?>
        <div id="<?php echo $meta_id; ?>" class="adelante-post-control">
        <p><strong><?php echo $meta_field['title']; ?></strong><?php echo $switch; ?></p><?php if ($description){echo $description;}?>

        <?php switch ( $meta_field['type'] ) { 

            case 'textarea':
            ?>
            <p<?php echo $margin; ?>>
            <textarea id="<?php echo $meta_field['name']; ?>" name="<?php echo $meta_field['name']; ?>" type="textarea" cols="40" rows="2"><?php echo $value; ?></textarea>
            <br /><label for="<?php echo $meta_field['name']; ?>"><?php echo $meta_field['label']; ?></label>
            <?php 

            break;
            case "text":
            ?>
            <?php $width = ($meta_field['width']) ? ' ' . $meta_field['width'] : ''; ?>
            <p<?php echo $margin; ?>>
            <input type="text" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input <?php echo $width; ?>"/>
            <br /><label for="<?php echo $meta_field['name']; ?>"><?php echo $meta_field['label']; ?></label>
            </p>
            <?php

            break;
            case "radio":
            ?>
            <p<?php echo $margin; ?>>
            <label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="radio" value="<?php echo $meta_field['value']; ?>" <?php if ($existing_value == $meta_field['value'] || $existing_value == ""){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc']; ?></label><br />
            <label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_2" type="radio" value="<?php echo $meta_field['value2']; ?>" <?php if ($existing_value == $meta_field['value2']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc2']; ?></label>
            </p>
            <?php

            break;
            case "radio_toggle":
            ?>
            <p<?php echo $margin; ?>><label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="selector" type="radio" value="<?php echo $meta_field['value']; ?>" <?php if ($existing_value == $meta_field['value'] || $existing_value == ""){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc']; ?></label><br />

            <label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_2" class="selector" type="radio" value="<?php echo $meta_field['value2']; ?>" <?php if ($existing_value == $meta_field['value2']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc2']; ?></label><br />

            <label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_3" class="selector" type="radio" value="<?php echo $meta_field['value3']; ?>" <?php if ($existing_value == $meta_field['value3']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc3']; ?></label><br />

            <label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_4" class="selector" type="radio" value="<?php echo $meta_field['value4']; ?>" <?php if ($existing_value == $meta_field['value4']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc4']; ?></label>
            </p>
            <?php

            break;
            case "checkbox":
            ?>
            <p<?php echo $margin; ?>>
            <input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="checkbox" value="<?php echo $meta_field['value']; ?>" <?php if ($existing_value == $meta_field['value']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc']; ?>
            </p>
            <?php

            break;
        }
        ?>

        </div>
    <?php } ?>
    <input type="hidden" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" id="<?php echo $meta_box['noncename']; ?>_noncename" name="<?php echo $meta_box['noncename']; ?>_noncename"/>
    <?php 
}

function adelante_save_meta($post_id) 
{
    $meta_boxes = adelante_meta_boxes();
            
    foreach($meta_boxes as $meta_box) {
        if ($_POST['post_type'] == 'post') {
            if (!wp_verify_nonce($_POST['adelante_generalpost_noncename'], plugin_basename(__FILE__)))
                return $post_id;
        }
        if ($_POST['post_type'] == 'page') {
            if (!wp_verify_nonce($_POST['adelante_generalpage_noncename'], plugin_basename(__FILE__)))
                return $post_id;
        }
    }

    if ($_POST['post_type'] == 'page') {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    }
    else {
        if (!current_user_can('edit_post', $post_id))
            return $post_id;
    }
    
    if ( isset($_GET['post']) && isset($_GET['bulk_edit']) )
        return $post_id;

    foreach ($meta_boxes as $meta_box) {
        foreach ($meta_box['fields'] as $meta_field) {
            $current_data = get_post_meta($post_id, $meta_field['name'], true);    
            $new_data = $_POST[$meta_field['name']];

            if ($current_data) {
                if ($new_data == '')
                    delete_post_meta($post_id, $meta_field['name']);
                elseif ($new_data == $meta_field['default'])
                    delete_post_meta($post_id, $meta_field['name']);
                elseif ($new_data != $current_data)
                    update_post_meta($post_id, $meta_field['name'], $new_data);
            }
            elseif ($new_data != '')
                add_post_meta($post_id, $meta_field['name'], $new_data, true);
        }
    }
}

function adelante_generalpost_meta_box() 
{
    adelante_add_meta_box('generalpost');
}

function adelante_generalpage_meta_box() 
{
    adelante_add_meta_box('generalpage');
}

function adelante_add_meta_boxes() 
{
    $meta_boxes = adelante_meta_boxes();    
    $i = 1;
    foreach ($meta_boxes as $meta_box) {    
        if ($i != 2){
            add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['function'], 'post', 'normal', 'high');
            add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['function'], 'portfolio', 'normal', 'high');
        }
        if ($i == 2){
            add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['function'], 'page', 'normal', 'high');   
        }
        $i++;    
    }    
    add_action('save_post', 'adelante_save_meta');
}
add_action('admin_menu', 'adelante_add_meta_boxes');
 