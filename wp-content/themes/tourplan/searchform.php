<form role="search" method="get" action="<?php echo home_url('/') ?>" >
    <input type="text" class="form-control" placeholder="Enter keyword to search..." value="<?php echo get_search_query(); ?>" name="s" title="Search" />
    <input type="hidden" name="post_type[]" id="post_type" value="trips" />
    <input type="hidden" name="post_type[]" id="post_type" value="package_tour" />
    <input type="hidden" name="post_type[]" id="post_type" value="hotel-info" />
    <input type="hidden" name="post_type[]" id="post_type" value="travelog" />
    <input type="hidden" name="post_type[]" id="post_type" value="product" />
</form>