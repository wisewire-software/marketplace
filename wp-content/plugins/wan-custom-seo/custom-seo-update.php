<?php
function wp_wan_custom_seo_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "wan_custom_seo";
    $id = $_GET["id"];
    $url = trim($_POST["url"]);
    $title = trim($_POST["title"]);
    $meta_description = trim($_POST["meta_description"]);
    $class_message = 'updated';
    $class_error = '';
    $message = '';

    //update
    if (isset($_POST['update'])) {
        if($url!=='' &&  $title!=='' &&  $meta_description!==''){

            $exist = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where url=%s and id!=%s", $url, $id));

            if(count($exist)>0){
                $message.="The Custom SEO for this url, already exists.";                
                $class_message = 'error';    
            } else {
                $wpdb->update(
                        $table_name, //table
                        array('url' => $url, 'title' => $title, 'meta_description' => $meta_description), //data
                        array('id' => $id), //where
                        array('%s', '%s', '%s'), //data format
                        array('%s') //where format
                );
                $message.="Custom SEO updated."; 
            }
        }
    }
    //delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    } else {//selecting value to update	
        $custom = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where id=%s", $id));
        foreach ($custom as $s) {
            $url = $s->url;
            $title = $s->title;
            $meta_description = $s->meta_description;
        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/wp_wan_custom_seo/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Custom SEO</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Custom SEO deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=wp_wan_custom_seo_list') ?>">&laquo; Back to Custom SEO list</a><br><br>
        <?php } else if ($_POST['update']) { ?>
            <div class="<?php echo $class_message ?>"><p><?php echo $message; ?></p></div>
            <a href="<?php echo admin_url('admin.php?page=wp_wan_custom_seo_list') ?>">&laquo; Back to Custom SEO list</a><br><br>
        <?php } else { ?>
            <a href="<?php echo admin_url('admin.php?page=wp_wan_custom_seo_list') ?>">&laquo; Back to Custom SEO list</a><br><br>
        <?php } ?>    

        <?php if (!$_POST['delete']) { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table fixed' width="50%">
                    <tr>
                        <th valign="top" align="left" width="30%">Url<br><span style="color:#9c9c9c; font-size: 11px">Url has to start with http://</span></th>
                        <td width="70%"> <input style="width: 100%; <?php echo $class_error; ?>" type="text" name="url" value="<?php echo $url; ?>"/></td>
                    </tr>
                    <tr>
                        <th valign="top" align="left">Title</th>
                        <td><textarea style="width: 100%; <?php echo $class_error; ?>" rows="2" name="title"><?php echo $title; ?></textarea></td>
                    </tr>
                    <tr>
                        <th valign="top" align="left">Meta description</th>
                        <td><textarea rows="5" style="width: 100%; <?php echo $class_error; ?>" name="meta_description" ><?php echo $meta_description; ?></textarea></td>
                    </tr>
                </table>
                <input type='submit' name="update" value='Save Custom SEO' class='button button-primary'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('&iquest;You are going to delete this Custom SEO. Are you sure?')">
            </form>
        <?php } ?>    

    </div>
    <?php
}