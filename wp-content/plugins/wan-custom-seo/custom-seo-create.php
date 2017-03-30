<?php
function wp_wan_custom_seo_create() {
    $url = trim($_POST["url"]);
    $title = trim($_POST["title"]);
    $meta_description = trim($_POST["meta_description"]);
    $class_message = 'updated';
    $class_error = '';
    $message = '';
    //insert
    if (isset($_POST['insert'])) {
        if($url!=='' &&  $title!=='' &&  $meta_description!==''){
            global $wpdb;
            $table_name = $wpdb->prefix . "wan_custom_seo";

            $exist = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where url=%s", $url));
            
            if(count($exist)>0){
                $message.="The Custom SEO for this url, already exists.";                
                $class_message = 'error';    
            } else {
                $wpdb->insert(
                        $table_name, //table
                        array('url' => $url, 'title' => $title, 'meta_description' => $meta_description), //data
                        array('%s', '%s', '%s') //data format			
                );
                $message.="Custom SEO inserted";
                $insert_id = $wpdb->insert_id;  
            }
        } else {
            $message.="Required fields are not complete.";
            $class_error = 'border:1px solid red';
            $class_message = 'error';
        }

    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/wp_wan_custom_seo/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Add New Custom SEO</h2>
        <?php if (isset($message)): ?><div class="<?php echo $class_message; ?>"><p><?php echo $message; ?></p></div><?php endif; ?>

        <a href="<?php echo admin_url('admin.php?page=wp_wan_custom_seo_list') ?>">&laquo; Back to Custom SEO list</a><br><br>
        
        <form method="post" action="<?php echo !isset($insert_id)? $_SERVER['REQUEST_URI']:admin_url('admin.php?page=wp_wan_custom_seo_update&id='.$insert_id) ?>">            

            <table class='wp-list-table fixed' width="50%">                
                <tr>
                    <th valign="top" align="left" width="30%">Url<br><span style="color:#9c9c9c; font-size: 11px">Url has to start with http://</span></th>
                    <td width="70%"><input style="width: 100%; <?php echo $class_error; ?>" type="text" name="url" value="<?php echo $url; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th valign="top" align="left">Title</th>
                    <td><textarea style="width: 100%; <?php echo $class_error; ?>" rows="2" name="title"><?php echo $title; ?></textarea></td>
                </tr>
                <tr>
                    <th valign="top" align="left">Meta description</th>
                    <td><textarea style="width: 100%; <?php echo $class_error; ?>" rows="5" name="meta_description"><?php echo $meta_description; ?></textarea></td>
                </tr>
            </table>            
            <?php if( isset($insert_id) ){ ?>
                <input type='submit' name="update" value='Save Custom SEO' class='button button-primary'>
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('&iquest;You are going to delete this Custom SEO. Are you sure?')">
            <?php } else { ?>
                <input type='submit' name="insert" value='Save Custom SEO' class='button button-primary'>    
            <?php }  ?>
        </form>
    </div>
    <?php
}