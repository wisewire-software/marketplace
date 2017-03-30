<?php

function array_sort($array, $on, $order = SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
?>

<?php if (substr($item_preview, 0, 1) === 'Y') { ?>

    <?php if (($item_demo_viewer_template == "Carousel") || ($item_demo_viewer_template == "Iframe")) { ?>

        <div class="modal fade modal-preview<?php if ($item_demo_viewer_template == "Iframe") echo ' detail-iframe'; ?>"
             id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="modal-title <?php if (!$item_demo_subhead) echo "modal-title-no-subhead"; ?>">
                            <h1><?php echo $title ?></h1>
                            <?php if ($item_demo_subhead) { ?>
                                <h2><?php echo $item_demo_subhead; ?></h2>
                            <?php } ?>
                        </div>
                        <?php if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                            <div class="carousel">
                                <?php $sorted_array = array_sort($item_carousel_images, 'title', SORT_ASC) ?>

                                <?php foreach ($sorted_array as $image) { ?>
                                    <li>
                                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"
                                             class="img-responsive"/>
                                    </li>
                                <?php } ?>
                            </div>
                        <?php } else if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                            <div class="iframe-container">
                                <iframe src="" frameborder="0" webkitAllowFullScreen mozallowfullscreen
                                        allowFullScreen></iframe>
                            </div>
                        <?php } ?>
                        <div style="width: 100%; color: #777; font-size:12px; padding-top: 10px">
                            Your preview may not load properly due to 3rd party or browser restrictions.
                        </div>
                    </div><!-- /modal-body -->
                </div>
            </div>
        </div><!-- /modal -->

    <?php } ?>

<?php } ?>