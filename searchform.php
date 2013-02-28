<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="control-group">
        <label for="s" class="control-label assistive-text"><?php _e( 'Search', 'fusedpress' ); ?></label>
        <div class="controls input-append">
            <input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'fusedpress' ); ?>" value="<?php echo esc_attr(get_search_query());?>" />
        <button type="submit" class="btn btn-info btn-large submit" name="submit" id="searchsubmit" ><?php esc_attr_e( 'Search', 'fusedpress' ); ?></button>
        </div> 
    </div>   
</form>