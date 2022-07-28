<div class="wrap">
    <h1 class="wp-heading-inline">Short Codes for file <?php echo $fileName;?></h1>
    <hr class="wp-header-end">
    <p>You can use the following shortcodes in Posts, Pages, widgets or anywhere you wanted to display the link to the private file. When that post is rendered, the shortcode will be generated with token passed to the link.</p>
    <div class="form-wrap">
        <div class="form-field term-description-wrap">
                <label for="tag-description">Button</label>
                <textarea name="description" rows="1" cols="40">[b2-private-file-button filename="<?php echo $fileName;?>"]</textarea>
                <p>Render a Download button, which redirects the user to the file with token passed in the url.</p>
        </div>
    </div>
</div><!-- wrap -->
<div class="clear"></div>