<?php 
    //Prepare Table of elements
    $files_table = new PrivateFiles_List_Table();
    $files_table->prepare_items();
?>

<div class="wrap">
    <h1 class="wp-heading-inline">B2 Private Files - Library</h1>
    <a href="<?php echo esc_url( admin_url('upload.php') ); ?>?page=b2-private-files-upload-page" class="page-title-action aria-button-if-js" role="button" aria-expanded="false">Add New</a>
    <?php $files_table->display(); ?>
</div><!-- wrap -->
<div class="clear"></div>