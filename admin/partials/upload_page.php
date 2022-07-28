<div class="wrap">
    <h1>B2 Private Files - Upload New File</h1>
    <?php if(isset($_GET['message']) && !empty($_GET['message'])){ ?>
    <div class="notice notice-success settings-error">
        <?php echo $_GET['message']; ?>
    </div>
    <?php } ?>
    <form  method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" class="media-upload-form">
    <input type="hidden" name="action" value="b2_private_files_upload_action">
    <input type="file" id="uploadFile" name="uploadFile"><br/><br/>
    <input type="submit" class="button" value="Upload"/>    
    <p class="max-upload-size">Maximum upload file size: 2 MB.</p>
    </form>
</div><!-- wrap -->
<div class="clear"></div>