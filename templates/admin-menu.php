<style type="text/css">
    .postbox.maxxer {
        max-width: 992px;
    }
</style>
<div id="wpbody" role="main">
    <div id="wpbody-content" aria-label="Main content" tabindex="0">
        <div class="wrap">
            <h1 class="wp-heading-inline">Kneejerk Development Menu Swapper</h1>
            <div class="postbox maxxer">
                <div class="inside">
                    <h2>Menu Configurations</h2>
                    <hr>
                    <div class="main">
                        <form id="kjd-menu-swapper-form" method="POST">
                            <table class="form-table">
                                <thead>
                                    <tr>
                                        <th>Theme Menu Location</th>
                                        <th>Default (all users)</th>
                                        <th>Logged In Menu Swap</th>
                                        <th>Enable Swap!</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ( $data['theme_menus'] as $nav_slug => $nav_name ) {
                                        $menu_id = $data['menu_locations'][$nav_slug] ?? false;
                                        $configured_menu = isset($data['config'][$nav_slug]) ? $data['config'][$nav_slug] : false;
                                        $default_menu = $data['menus'][$menu_id]->name ?? 'None Selected';
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $nav_name ?> [<?php echo $nav_slug ?>]</th>
                                        <td>
                                            <?php echo $default_menu ?>
                                            <?php if ($menu_id) { ?>
                                            [<a href="<?php echo admin_url("nav-menus.php?action=edit&menu=$menu_id") ?>">configure menu</a>]
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <select name="<?php echo $nav_slug ?>[swap]">
                                                <option value=''>None</option>
                                                <?php foreach ( $data['menus'] as $menu ) {
                                                    $selected = $configured_menu && $configured_menu['swap'] == $menu->slug;
                                                    ?>
                                                <option value="<?php echo $menu->slug ?>"<?php echo $selected ? ' selected="selected"' : '' ?>><?php echo $menu->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="<?php echo $nav_slug ?>[enabled]"<?php echo isset($configured_menu['enabled']) ? ' checked="checked"' : '' ?>>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan=4>
                                            <button id="kjd-menu-swapper-submit-btn">Save</button>
                                            <span id="kjd-menu-swapper-results"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- wpbody-content -->
</div>
<script type="text/javascript">
(function($) {
    // Save new Trial plan info
    var kjdMenuSwapperForm = $('#kjd-menu-swapper-form');
    var kjdMenuSwapperSubmitBtn = $('#kjd-menu-swapper-submit-btn');
    var kjdMenuSwapperResults = $('#kjd-menu-swapper-results');
    kjdMenuSwapperForm.submit(function(e) {
        e.preventDefault();
        var originalMsg = kjdMenuSwapperSubmitBtn.html();
        kjdMenuSwapperSubmitBtn.html('Saving...');
        kjdMenuSwapperResults.html('&nbsp;').addClass('hidden');
        $.ajax({
            type: kjdMenuSwapperForm.attr('method'),
            url: ajaxurl + '?action=kjd_configure_menu_swapper',
            data: kjdMenuSwapperForm.serialize(),
            dataType: 'json',
            success: function(data) {
                kjdMenuSwapperResults.html('Successfully saved new configuration!');
            },
            error: function(xhr) {
                kjdMenuSwapperResults.html(`New configuration did not save: ${xhr.statusText}`);
            },
            complete: function() {
                kjdMenuSwapperSubmitBtn.html(originalMsg);
                kjdMenuSwapperResults.removeClass('hidden');
            }
        });
    });
})( jQuery );
</script>
