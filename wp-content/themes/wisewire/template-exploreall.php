<?php
/**
 * Template Name: Explore All
 */

session_start();

require get_template_directory() . "/Controller/ExploreAll.php";


global $total_pages_seo;
global $current_page;
global $url_link;
global $control;
global $items;


$control = new Controller_ExploreAll();
$items = $control->populate_data_posts;

$total_pages_seo = $control->pages_count;
$current_page = $control->page_nr;
$url_link = $control->get_permalink();


?>
<?php get_header(); ?>


<div id="explore-body">
    <!-- Visible on <768px -->
    <?php if ($control->search === false): ?>
        <section class="nav-grades-mobile visible-xs-block">
            <div class="container">
                <p>
                    <?php echo strtoupper($control->grade) ?>
                </p>
            </div>
        </section>
    <?php endif; ?>
    <?php get_template_part('parts/grades', 'explorenavigation' . (WiseWireApi::get_option('gradelevels_nav') == 'full' ? '' : '_1')); ?>

    <!-- Hidden on <768px -->
    <div>
        <div class="container">
            <div class="items<?php if ($control->search !== false) echo ' search-results'; ?>">
                <?php if ($control->search === false): ?>
                    <div class="btn-back">
                        <a href="<?php echo get_site_url() ?>/explore/<?php echo $control->grade ?>/">&lt; Back</a>
                    </div>
                <?php endif; ?>
                <div class="row row-head">
                    <div class="col-sm-7 col-headline<?php if ($control->search === false) echo ' col-uppercase'; ?>">
                        
                        <?php if ($control->search !== false): ?>
                            <h3>Search results: <span><?php echo $control->search ?></span></h3>
                        <?php endif; ?>
                        
                        <p>
                            <?php echo $control->posts_count ?>
                            items <?php echo $control->search !== false ? 'found' : 'in this category' ?>
                            <span class="ajax-loading small"></span>
                            <?php if ($active_filters = $control->display_active_filters()) { ?>
                                <br>
                                <a href="?clear_filters=1" class="btn-filters-clear">Clear filters</a>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="col-sm-5">

                        <div class="options">

                            <div class="rank">
                                <p>
                                    RANK BY
                                </p>
                                <select name="order_by" class="form-control select filter-order-by">
                                    <option value="">Popularity</option>
                                    <option
                                        value="most_recent" <?php echo $control->order_by === 'most_recent' ? 'selected' : '' ?>>
                                        Most recent
                                    </option>
                                </select>

                                <div class="items">
                                    <div class="filters">
                                        <a href="#" class="btn-filter" id="btn-filters-overlay-open">Filter</a>
                                        <select name="order_by" class="form-control select filter-order-by small">
                                            <option value="">Rank By Popularity</option>
                                            <option
                                                value="most_recent" <?php echo $control->order_by === 'most_recent' ? 'selected' : '' ?>>
                                                Rank by Most recent
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="grid">
                                <p>View</p>
                                <a href="#"
                                   class="btn-grid <?php echo $control->list_view === 'grid' ? 'active' : '' ?>"
                                   id="btn-view-grid"></a>
                                <a href="#"
                                   class="btn-list <?php echo $control->list_view === 'list' ? 'active' : '' ?>"
                                   id="btn-view-list"></a>
                            </div>

                        </div><!-- /options -->

                    </div>

                </div><!-- /row -->

                <?php if ($control->search && $control->search_keyword_sepllcheck): ?>
                    <div class="row suggestions">
                        <div class="col-sm-12">
                            <p>Did you mean?</p>
                            <ul class="list-unstyled">
                                <?php foreach ($control->search_keyword_sepllcheck as $s): ?>
                                    <?php
                                    $word_spellcheck = preg_replace(array('/"AND"/', '/"/', '/\(/', '/\)/'), ' ', $s->collationQuery);
                                    $word_spellcheck = str_replace('\\', '', $word_spellcheck);
                                    ?>
                                    <li>
                                        <a href="<?php echo get_site_url(); ?>/explore/search/<?php echo $word_spellcheck; ?>?sepllcheck=1"><?php echo $word_spellcheck; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row">

                    <div class="filters-overlay" id="filters-overlay">
                        <div class="col-sm-3 col-nav">
                            <div class="col-headline<?php if ($control->search === false) echo ' col-uppercase'; ?>">
                                <h3>
                                    <?php if ($control->search): ?>
                                        Search results: <span><?php echo $control->search ?></span>
                                    <?php else: ?>
                                        <?php echo $control->discipline_object->level1_label ?>
                                    <?php endif; ?>
                                </h3>
                                <p>
                                    <?php echo $control->posts_count ?>
                                    items <?php echo $control->search ? 'found' : 'in this category' ?>
                                    <span class="ajax-loading small"></span>
                                    <?php if ($active_filters = $control->display_active_filters()) { ?>
                                        <br>
                                        <a href="?clear_filters=1" class="btn-filters-clear">Clear filters</a>
                                    <?php } ?>
                                </p>
                            </div>

                            <div class="nav-head">
                                <p>
                                    Filter by<span class="ajax-loading"></span>
                                </p>
                            </div>

                            <div class="accordion-filters" id="accordion-filters" role="tablist"
                                 aria-multiselectable="true">
                                <?php if ($control->filter_grades)://&& $control->search !== false): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="filters-heading-0">
                                            <h3 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion-filters"
                                                   href="#filterPanel0" aria-expanded="true"
                                                   aria-controls="filterPanel0" class="collapsed">
                                                    Grade Level
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="filterPanel0"
                                             class="panel-collapse collapse <?php echo $control->filter_requested('gradelevel') ? 'in' : '' ?>"
                                             role="tabpanel" aria-labelledby="filters-heading-0">
                                            <div class="panel-body panel-grades">
                                                <ul>
                                                    <?php foreach ($control->filter_grades as $key => $value): ?>
                                                        <li>
                                                            <a class="collapsed" role="button" data-toggle="collapse"
                                                               data-parent="#filterGradeLevel"
                                                               href="#<?php echo $key ?>Nav" aria-expanded="true"
                                                               aria-controls="<?php echo $key ?>Nav">
                                                                <?php echo strtoupper($key); ?>
                                                            </a>
                                                            <ul id="<?php echo $key ?>Nav"
                                                                class="panel-collapse collapse <?php //echo $control->filter_grades[''][$grade_parent]['open'] ? 'in' : '' ?>"
                                                                role="tabpanel">
                                                                <?php foreach ($value as $subgrade_key => $subgrade): ?>
                                                                    <li>
                                                                        <a href="#<?php echo $subgrade['term_id'] ?>"
                                                                           data-filter="gradelevel"
                                                                           class="filter <?php echo in_array($subgrade['term_id'], $control->filters['gradelevel']) ? 'active' : '' ?>">
                                                                            <?php echo strtoupper($subgrade['name']) ?>
                                                                        </a>
                                                                        <span><?php echo $subgrade['count'] ?></span>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>

                                        </div>
                                    </div><!-- /panel -->
                                <?php endif; ?>

                                <?php if ($control->subdisciplines): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="filters-heading-1">
                                            <h3 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion-filters"
                                                   href="#filterPanel1" aria-expanded="true"
                                                   aria-controls="filterPanel1" class="collapsed">
                                                    SUB-DISCIPLINE
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="filterPanel1"
                                             class="panel-collapse collapse <?php echo $control->filter_requested('subdiscipline') ? 'in' : '' ?>"
                                             role="tabpanel" aria-labelledby="filters-heading-1">
                                            <div class="panel-body">
                                                <ul>
                                                    <?php foreach ($control->subdisciplines as $v): ?>
                                                        <?php if (!$v->groupValue) continue ?>
                                                        <li><a href="#<?php echo $v->groupValue ?>"
                                                               data-filter="subdiscipline"
                                                               class="filter <?php echo in_array($v->groupValue, $control->filters['subdiscipline']) ? 'active' : '' ?>"><?php echo strtoupper($v->groupValue) ?></a><span><?php echo $v->doclist->numFound ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($control->filter_content_types): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="filters-heading-2">
                                            <h3 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion-filters"
                                                   href="#filterPanel2" aria-expanded="true"
                                                   aria-controls="filterPanel2" class="collapsed">
                                                    CONTENT TYPE
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="filterPanel2"
                                             class="panel-collapse collapse <?php echo $control->filter_requested('content_type') ? 'in' : '' ?>"
                                             role="tabpanel" aria-labelledby="filters-heading-2">
                                            <div class="panel-body">
                                                <ul>
                                                    <?php foreach ($control->filter_content_types as $v): ?>
                                                        <?php if (!$v->groupValue) continue ?>
                                                        <li><a href="#<?php echo $v->groupValue ?>"
                                                               data-filter="content_type"
                                                               class="filter <?php echo in_array($v->groupValue, $control->filters['content_type']) ? 'active' : '' ?>"><?php echo strtoupper($v->groupValue) ?></a><span><?php echo $v->doclist->numFound ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /panel -->
                                <?php endif; ?>

                                <?php if ($control->filter_object_types): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="filters-heading-3">
                                            <h3 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion-filters"
                                                   href="#filterPanel3" aria-expanded="true"
                                                   aria-controls="filterPanel3" class="collapsed">
                                                    OBJECT TYPE
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="filterPanel3"
                                             class="panel-collapse collapse <?php echo $control->filter_requested('object_type') ? 'in' : '' ?>"
                                             role="tabpanel" aria-labelledby="filters-heading-3">
                                            <div class="panel-body">                                               
                                                <ul>
                                                    <?php foreach ($control->filter_object_types as $v): ?>
                                                        <?php if (!$v->value) continue ?>
                                                        <li><a href="#<?php echo $v->value ?>"
                                                               data-filter="object_type"
                                                               class="filter <?php echo in_array($v->value, $control->filters['object_type']) ? 'active' : '' ?>"><?php echo strtoupper($v->value) ?></a><span><?php echo $v->count ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /panel -->
                                <?php endif; ?>

                                <?php if ($control->filter_standards): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="filters-heading-4">
                                            <h3 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion-filters"
                                                   href="#filterPanel4" aria-expanded="true"
                                                   aria-controls="filterPanel4" class="collapsed">
                                                    Standards
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="filterPanel4"
                                             class="panel-collapse collapse <?php echo $control->filter_requested('standard') ? 'in' : '' ?>"
                                             role="tabpanel" aria-labelledby="filters-heading-4">
                                            <div class="panel-body">
                                                <ul>
                                                    <?php foreach ($control->filter_standards as $v): ?>
                                                        <?php if (!$v->groupValue) continue ?>
                                                        <li><a href="#<?php echo $v->groupValue ?>"
                                                               data-filter="standard"
                                                               class="filter <?php echo in_array($v->groupValue, $control->filters['standard']) ? 'active' : '' ?>"><?php echo strtoupper($v->groupValue) ?></a><span><?php echo $v->doclist->numFound ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /panel -->
                                <?php endif; ?>

                                <?php if ($control->filter_contributors): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="filters-heading-5">
                                            <h3 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion-filters"
                                                   href="#filterPanel5" aria-expanded="true"
                                                   aria-controls="filterPanel5" class="collapsed">
                                                    Contributors
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="filterPanel5"
                                             class="panel-collapse collapse <?php echo $control->filter_requested('contributor') ? 'in' : '' ?>"
                                             role="tabpanel" aria-labelledby="filters-heading-5">
                                            <div class="panel-body">
                                                <ul>
                                                    <?php foreach ($control->filter_contributors as $v): ?>
                                                        <?php if (!$v->groupValue) continue ?>
                                                        <li><a href="#<?php echo $v->groupValue ?>"
                                                               data-filter="contributor"
                                                               class="filter <?php echo in_array($v->groupValue, $control->filters['contributor']) ? 'active' : '' ?>"><?php echo strtoupper($v->groupValue) ?></a><span><?php echo $v->doclist->numFound ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /panel -->
                                <?php endif; ?>

                                <?php if ($control->filter_dok): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="filters-heading-6">
                                            <h3 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion-filters"
                                                   href="#filterPanel6" aria-expanded="true"
                                                   aria-controls="filterPanel6" class="collapsed">
                                                    Dok
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="filterPanel6"
                                             class="panel-collapse collapse <?php echo $control->filter_requested('dok') ? 'in' : '' ?>"
                                             role="tabpanel" aria-labelledby="filters-heading-6">
                                            <div class="panel-body">
                                                <ul>
                                                    <?php foreach ($control->filter_dok as $v): ?>
                                                        <li><a href="#<?php echo $v->groupValue ?>" data-filter="dok"
                                                               class="filter <?php echo in_array($v->groupValue, isset($control->filters['dok']) ? $control->filters['dok'] : array()) ? 'active' : '' ?>"><?php echo $v->groupValue ?></a><span><?php echo $v->doclist->numFound ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /panel -->
                                <?php endif; ?>

                                <?php if ($control->filter_ranking): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="filters-heading-7">
                                            <h3 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion-filters"
                                                   href="#filterPanel7" aria-expanded="true"
                                                   aria-controls="filterPanel7" class="collapsed">
                                                    RATING
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="filterPanel7"
                                             class="panel-collapse collapse <?php echo $control->filter_requested('ranking') ? 'in' : '' ?>"
                                             role="tabpanel" aria-labelledby="filters-heading-7">
                                            <div class="panel-body">
                                                <ul>
                                                    <?php foreach ($control->filter_ranking as $v): ?>
                                                        <li><a href="#<?php echo intval($v->groupValue) ?>"
                                                               data-filter="ranking"
                                                               class="filter side-rate <?php echo in_array($v->groupValue, $control->filters['ranking']) ? 'active' : '' ?>"><?php rating_display_stars($v->groupValue, '') ?></a><span><?php echo $v->doclist->numFound ?></span>
                                                        </li>
                                                    <?php endforeach ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /panel -->
                                <?php endif; ?>
                                    
                                <?php if ($control->filter_license_type): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="filters-heading-8">
                                            <h3 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion-filters"
                                                   href="#filterPanel8" aria-expanded="true"
                                                   aria-controls="filterPanel8" class="collapsed">
                                                    LICENSE TYPE
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="filterPanel8"
                                             class="panel-collapse collapse <?php echo $control->filter_requested('license_type') ? 'in' : '' ?>"
                                             role="tabpanel" aria-labelledby="filters-heading-8">
                                            <div class="panel-body">
                                                <ul>
                                                    <?php foreach ($control->filter_license_type as $v): ?>
                                                        <?php if (!$v->groupValue) continue ?>
                                                        <li><a href="#<?php echo $v->groupValue ?>"
                                                               data-filter="license_type"
                                                               class="filter <?php echo in_array($v->groupValue, $control->filters['license_type']) ? 'active' : '' ?>"><?php echo strtoupper($v->groupValue) ?></a><span><?php echo $v->doclist->numFound ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <a href="#" class="btn btn-filters-overlay-close" id="btn-filters-overlay-close"
                                   class="btn">Done</a>

                            </div>
                        </div>

                        <div id="explore-items"
                             data-searchvalue="<?php echo($control->search ? $control->search : '') ?>"
                             class="<?php echo $control->list_view ?>-layout">
                            <div class="col-sm-9 col-items">
                                <?php if ($active_filters = $control->display_active_filters()): ?>
                                    <div class="selections">
                                        <p>
                                            Your selection
                                        </p>
                                        <ul>
                                            <?php echo $active_filters ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <div id="section-view-grid">
                                    <section class="lo-items">
                                        <div class="row row-no-margin">
                                            <?php if ($items): ?>
                                                <?php foreach ($items as $item): ?>
                                                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                                                        <a data-itemtitle="<?php echo $item->title ?>"
                                                                 class="lo-item lo-item-col <?php echo $WWItems->get_color($item->content_type_icon) ?> <?php echo($item->type == 'item' ? '' : 'item-search') ?>"
                                                                 href="/item/<?php echo($item->type == 'item' ? $item->name : $item->id) ?>/" <?php echo add_rel_nofollow_to_item($item->id) ?> >
                                                            <div class="img">
                                                                <?php
                                                                $item_main_image = $item->image_id;
                                                                if ($item_main_image):
                                                                    $size = "thumbnail";
                                                                    $image = wp_get_attachment_image_src($item_main_image, $size);
                                                                    ?>
                                                                    <img alt="" src="<?php echo $image[0]; ?>"
                                                                         class="img-responsive"/>
                                                                <?php else: ?>
                                                                    <?php echo $WWItems->get_thumbnail($item->content_type_icon, 'thumb-related', $item->subdiscipline, $item->author, $item->title) ?>
                                                                <?php endif ?>

                                                                <?php if (substr($item->preview, 0, 1) === 'Y'): ?>
                                                                    <div class="ribbon"><span class="icon"></span>
                                                                        Preview
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>

                                                            <?php 
                                                                $code_label = $item->title;    
                                                                if ($item->type != 'item'): ?>
                                                                <?php
                                                                    $array_object_type = array_map('trim', explode(',', $item->object_type));
                                                                    //if ($item->object_type != 'question') {
                                                                    if ( !in_array("question", $array_object_type) ){
                                                                    $level1_label = !empty($item->subdiscipline) ? $item->subdiscipline : '&nbsp;';
                                                                    $level2_label = $item->content_type_icon;
                                                                    $level3_label = null;
                                                                    $description_label = null;

                                                                    
                                                                } else {
                                                                    $level1_label = !empty($item->level1_label) ? $item->level1_label : '&nbsp';
                                                                    $level2_label = !empty($item->level2_label) ? $item->level2_label : '&nbsp';
                                                                    $level3_label = !empty($item->level3_label) ? $item->level3_label : '&nbsp';
                                                                    $description_label = $item->description_label;
                                                                    $code_label = $item->code_label;
                                                                } ?>
                                                            <?php endif ?>

                                                            <div class="content">
                                                                <?php if ($item->type == 'item'): ?>
                                                                    <div class="details">
                                                                        <h3 class="sub-discipline">
                                                                            <?php echo !empty($item->subdiscipline) ? $item->subdiscipline : '&nbsp;' ?>
                                                                            <?php if (substr($item->preview, 0, 1) === 'Y'): ?>
                                                                                <div
                                                                                    class="ribbon ribbon-list-layout">
                                                                                    <span class="icon"></span>
                                                                                    Preview
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </h3>
                                                                        <p class="content-type">
                                                                            <?php echo $item->content_type_icon ?>
                                                                        </p>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="details">
                                                                        <h3 class="sub-discipline">
                                                                            <?php echo $level1_label ?>
                                                                            <?php if (substr($item->preview, 0, 1) === 'Y'): ?>
                                                                                <div
                                                                                    class="ribbon ribbon-list-layout">
                                                                                    <span class="icon"></span>
                                                                                    Preview
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </h3>
                                                                        <p class="content-type">
                                                                            <?php if ($item->source != 2) {
                                                                                echo $level2_label;
                                                                            } ?>


                                                                        </p>
                                                                        <?php if ($level3_label !== null): ?>
                                                                            <p class="content-type">
                                                                                <?php if ($item->source != 2) {
                                                                                    echo $level3_label;
                                                                                } ?>
                                                                            </p>
                                                                        <?php endif ?>
                                                                        <p class="grade-level">
                                                                            <?php
                                                                            $words_to_find = array("Question", "question");
                                                                            $description_label = str_replace($words_to_find, "", $description_label);
                                                                            ?>
                                                                            <?php echo $description_label; ?>
                                                                        </p>
                                                                    </div>
                                                                <?php endif ?>
                                                                <div class="more-info">
                                                                    <div class="content-title">
                                                                        <h3><?php echo $code_label ?></h3>
                                                                        <div class="content-type-icon">
                                                                            <svg
                                                                                class="svg-<?php echo $WWItems->get_icon($item->content_type_icon) ?>-dims">
                                                                                <use
                                                                                    xlink:href="#<?php echo $WWItems->get_icon($item->content_type_icon) ?>"></use>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="rate rate-list-layout">
                                                                        <?php rating_display_stars($item->ratings, '') ?>
                                                                        <p class="number">
                                                                            <?php echo $item->ratings ? $item->ratings : '' ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="lo-info lo-info-list-layout">
                                                                    <div class="date-rate">
                                                                        <p class="date">
                                                                            <?php if ($item->publish_date): ?>
                                                                                <?php echo date_i18n('m-d-Y', strtotime($item->publish_date)); ?>
                                                                            <?php endif; ?>
                                                                        </p>
                                                                        <p class="object-type">
                                                                            <?php echo ucfirst($item->object_type) ?>
                                                                        </p>
                                                                        <?php do_action('product_tile_price',$item);  ?>
                                                                    </div>
                                                                </div>
                                                                <?php if (substr($item->preview, 0, 1) === 'Y'): ?>
                                                                    <div class="ribbon ribbon-list-layout-small">
                                                                        <span class="icon"></span> Preview
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </a>

                                                        <div class="lo-info lo-info-outside">
                                                            <div class="date-rate">
                                                                <div class="date">
                                                                    <?php if ($item->publish_date): ?>
                                                                        <?php echo date_i18n('m-d-Y', strtotime($item->publish_date)); ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="rate">
                                                                    <?php rating_display_stars($item->ratings, '') ?>
                                                                    <p class="number">
                                                                        <?php echo $item->ratings ? $item->ratings : '' ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <p class="object-type">
                                                                <?php echo str_replace("tei", "&nbsp;TEI&nbsp;", ucfirst($item->object_type)); ?>
                                                            </p>
                                                            <?php do_action('product_tile_price',$item);  ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="no-results">
                                                    <p>Sorry, no results were found.</p>
                                                </div>
                                            <?php endif ?>
                                        </div><!-- /row -->
                                    </section><!-- /lo-items -->
                                </div><!-- /view-grid -->

                                <?php
                                $params_url_spellcheck = null;
                                if ($control->search && !$control->search_keyword_sepllcheck) {
                                    $params_url_spellcheck = 'sepllcheck=1';
                                }
                                ?>

                                <?php $pagination = f_paginate($control->posts_count, $control->on_page, $control->page_nr, 4) ?>
                                <?php if ($control->pages_count > 1): ?>
                                    <nav>
                                        <ul class="pagination">
                                            <?php if ($control->page_nr > 1): ?>
                                                <li>
                                                    <a class="filter-page-nr"
                                                       href="<?php echo $control->get_permalink() . ($control->page_nr - 1) . '/' . ($params_url_spellcheck ? '?' . $params_url_spellcheck : '') ?>"
                                                       aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                                                </li>
                                            <?php endif; ?>

                                            <?php foreach ($pagination as $i): ?>
                                                <li <?php echo $control->page_nr == $i ? 'class="active"' : '' ?>><a
                                                        class="filter-page-nr"
                                                        href="<?php echo $control->get_permalink() . ($i != '...' ? $i : $control->page_nr) . '/' . ($params_url_spellcheck ? '?' . $params_url_spellcheck : '') ?>"><?php echo $i ?> </a>
                                                </li>
                                            <?php endforeach ?>
                                            <?php if ($control->page_nr < $control->pages_count): ?>
                                                <li>
                                                    <a class="filter-page-nr"
                                                       href="<?php echo $control->get_permalink() . ($control->page_nr + 1) . '/' . ($params_url_spellcheck ? '?' . $params_url_spellcheck : '') ?>"
                                                       aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                <?php endif; ?>

                            </div><!-- /col-items -->
                        </div><!-- /#explore-items -->
                    </div><!-- /row -->
                </div><!-- /items -->
            </div><!-- /container -->
            <!-- SEO improvements -->
            <?php if ($control->search === false): ?>
                <div class="row container-seo">
                    <div class="col-md-9">
                        <h1 class="title-page">
                            <?php echo nl2br($control->title); ?>
                        </h1>
                        <div class="meta-description-page">
                            <?php echo nl2br($control->meta_description) ?>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            <?php endif ?>
        </div><!-- /hidden-xs -->


        <div class="back-to-top" id="back-to-top">
            <a href="#header" class="scroll">Back to top</a>
        </div>

    </div>
    <?php add_action('wp_footer', 'add_script_ga_footer'); ?>
    <?php get_footer(); ?>


