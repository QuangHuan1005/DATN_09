<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" id="elementor-post-625-css"
        href="https://mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-625.css?ver=1745082661" type="text/css"
        media="all">

    <body
        class="blog wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-625 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active blog-pagination-default kitify--enabled kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
        data-elementor-device-mode="laptop">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div id="site-content" class="site-content-wrapper">
                    <div data-elementor-type="archive" data-elementor-id="625"
                        class="elementor elementor-625 elementor-location-archive">
                        <div class="elementor-element elementor-element-d282e6b e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent e-lazyloaded"
                            data-id="d282e6b" data-element_type="container">
                            <div class="e-con-inner" style="--kitify-section-width: 1225px;">
                                <div class="elementor-element elementor-element-650f302 kitify-breadcrumbs-page-title-yes kitify-breadcrumbs-align-center elementor-widget kitify elementor-kitify-breadcrumbs"
                                    data-id="650f302" data-element_type="widget"
                                    data-widget_type="kitify-breadcrumbs.default">
                                    <div class="elementor-widget-container">

                                        <div class="kitify-breadcrumbs">
                                            <h3 class="kitify-breadcrumbs__title">Tin thời trang</h3>
                                            <div class="kitify-breadcrumbs__content">
                                                <div class="kitify-breadcrumbs__wrap">
                                                    <div class="kitify-breadcrumbs__item"><a
                                                            href="https://mixtas.novaworks.net/"
                                                            class="kitify-breadcrumbs__item-link is-home" rel="home"
                                                            title="Home">Home</a></div>
                                                    <div class="kitify-breadcrumbs__item">
                                                        <div class="kitify-breadcrumbs__item-sep"><span>/</span></div>
                                                    </div>
                                                    <div class="kitify-breadcrumbs__item"><span
                                                            class="kitify-breadcrumbs__item-target">Blog</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-577be7f0 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent e-lazyloaded"
                            data-id="577be7f0" data-element_type="container">
                            <div class="e-con-inner" style="--kitify-section-width: 1225px;">
                                <div class="elementor-element elementor-element-4ff1bacc e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="4ff1bacc" data-element_type="container">
                                    <div class="elementor-element elementor-element-36b3f36f e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child elementor-sticky"
                                        data-id="36b3f36f" data-element_type="container"
                                        data-settings="{&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;laptop&quot;],&quot;sticky_offset&quot;:100,&quot;sticky_parent&quot;:&quot;yes&quot;,&quot;sticky_effects_offset&quot;:0}">
                                        <div class="elementor-element elementor-element-296e00fd elementor-widget kitify elementor-kitify-sidebar"
                                            data-id="296e00fd" data-element_type="widget"
                                            data-widget_type="kitify-sidebar.default">
                                            <div class="elementor-widget-container">
                                                <div class="kitify-sidebar kitify-sidebar-layout_01 kitify-toggle-sidebar"
                                                    data-breakpoint="1024">
                                                    <div class="kitify-toggle-sidebar__overlay js-column-toggle"></div>
                                                    <div class="kitify-toggle-sidebar__container"><a
                                                            class="kitify-toggle-sidebar__toggle js-column-toggle"
                                                            href="javascript:void(0)"></a>
                                                        <div class="toggle-column-btn__wrap"><a
                                                                class="toggle-column-btn js-column-toggle"
                                                                href="javascript:void(0)"></a></div>
                                                        <div class="kitify-toggle-sidebar__inner nova_box_ps ps ps--theme_default"
                                                            data-ps-id="973b9cfb-cb5d-cf35-d8fb-b236d38773a1">
                                                            <aside class="widget widget_search">
                                                                <form role="search" method="get" class="search-form"
                                                                    action="https://mixtas.novaworks.net/">
                                                                    <label>
                                                                        <span class="screen-reader-text">Search for:</span>
                                                                        <input type="search" class="search-field"
                                                                            placeholder="Search …" value=""
                                                                            name="s">
                                                                    </label>
                                                                    <input type="submit" class="search-submit"
                                                                        value="Search">
                                                                </form>
                                                            </aside>
                                                            <aside class="widget widget_categories">
                                                                <h4 class="widget-title">Categories</h4>
                                                                <ul>
                                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li class="cat-item cat-item-<?php echo e($category->id); ?>">
                                                                            <a  href="#">
                                                                                <?php echo e($category->name); ?>

                                                                            </a>
                                                                            <span
                                                                                class="count"><?php echo e($category->news_count); ?></span>
                                                                        </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </ul>
                                                            </aside>
                                                            <aside class="widget widget_calendar">
                                                                <div id="calendar_wrap" class="calendar_wrap">
                                                                    <table id="wp-calendar" class="wp-calendar-table">
                                                                        <caption>October 2025</caption>
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" aria-label="Monday">M
                                                                                </th>
                                                                                <th scope="col" aria-label="Tuesday">T
                                                                                </th>
                                                                                <th scope="col" aria-label="Wednesday">
                                                                                    W</th>
                                                                                <th scope="col" aria-label="Thursday">T
                                                                                </th>
                                                                                <th scope="col" aria-label="Friday">F
                                                                                </th>
                                                                                <th scope="col" aria-label="Saturday">S
                                                                                </th>
                                                                                <th scope="col" aria-label="Sunday">S
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td colspan="2" class="pad">&nbsp;
                                                                                </td>
                                                                                <td>1</td>
                                                                                <td>2</td>
                                                                                <td>3</td>
                                                                                <td>4</td>
                                                                                <td>5</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>6</td>
                                                                                <td>7</td>
                                                                                <td>8</td>
                                                                                <td>9</td>
                                                                                <td>10</td>
                                                                                <td>11</td>
                                                                                <td>12</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>13</td>
                                                                                <td>14</td>
                                                                                <td>15</td>
                                                                                <td>16</td>
                                                                                <td>17</td>
                                                                                <td>18</td>
                                                                                <td id="today">19</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>20</td>
                                                                                <td>21</td>
                                                                                <td>22</td>
                                                                                <td>23</td>
                                                                                <td>24</td>
                                                                                <td>25</td>
                                                                                <td>26</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>27</td>
                                                                                <td>28</td>
                                                                                <td>29</td>
                                                                                <td>30</td>
                                                                                <td>31</td>
                                                                                <td class="pad" colspan="2">&nbsp;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <nav aria-label="Previous and next months"
                                                                        class="wp-calendar-nav">
                                                                        <span class="wp-calendar-nav-prev"><a
                                                                                href="https://mixtas.novaworks.net/2023/12/">«
                                                                                Dec</a></span>
                                                                        <span class="pad">&nbsp;</span>
                                                                        <span class="wp-calendar-nav-next">&nbsp;</span>
                                                                    </nav>
                                                                </div>
                                                            </aside>
                                                            <aside class="widget widget_archive">
                                                                <h4 class="widget-title">Archives</h4> <label
                                                                    class="screen-reader-text"
                                                                    for="archives-dropdown-2">Archives</label>
                                                                <select id="archives-dropdown-2" name="archive-dropdown">

                                                                    <option value="">Select Month</option>
                                                                    <option value="https://mixtas.novaworks.net/2023/12/">
                                                                        December 2023 </option>

                                                                </select>

                                                                <script type="text/javascript">
                                                                    /* <![CDATA[ */

                                                                    (function() {
                                                                        var dropdown = document.getElementById("archives-dropdown-2");

                                                                        function onSelectChange() {
                                                                            if (dropdown.options[dropdown.selectedIndex].value !== '') {
                                                                                document.location.href = this.options[this.selectedIndex].value;
                                                                            }
                                                                        }
                                                                        dropdown.onchange = onSelectChange;
                                                                    })();

                                                                    /* ]]> */
                                                                </script>
                                                            </aside>
                                                            <aside class="widget widget_recent_entries">
                                                                <h4 class="widget-title">Recent Posts</h4>
                                                                <ul>

                                                                    <?php $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li>
                                                                            <div class="pr-item">
                                                                                <div class="pr-item--left">
                                                                                    
                                                                                    <a href="#"
                                                                                        class="nova-lazyload-image"
                                                                                        data-background-image="<?php echo e($post->thumbnail_url ?? asset('images/placeholder-150.jpg')); ?>">
                                                                                        <span
                                                                                            class="hidden"><?php echo e($post->title); ?></span>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="pr-item--right">
                                                                                    <span class="post-date">
                                                                                        <?php echo e($post->published_at ? $post->published_at->format('F d, Y') : 'N/A'); ?>

                                                                                    </span>
                                                                                    <a 
                                                                                        href="#">
                                                                                        <?php echo e($post->title); ?>

                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                </ul>
                                                            </aside>
                                                            <aside class="widget widget_tag_cloud">
                                                                <h4 class="widget-title">Tags</h4>
                                                                <div class="tagcloud">

                                                                    <?php
                                                                        $minFontSize = 8;
                                                                        $maxFontSize = 22;
                                                                        $fontRange = $maxFontSize - $minFontSize;
                                                                        $countRange = $maxCount - $minCount;
                                                                        $countRange = $countRange > 0 ? $countRange : 1;
                                                                    ?>

                                                                    <?php $__currentLoopData = $topKeywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                            $fontSize =
                                                                                $minFontSize +
                                                                                (($count - $minCount) / $countRange) *
                                                                                    $fontRange;
                                                                            $fontSize = round($fontSize, 2);
                                                                            $slugForUrl = \Illuminate\Support\Str::slug(
                                                                                $keyword,
                                                                            );
                                                                        ?>

                                                                        <a href="<?php echo e(route('blog.index', ['q' => $keyword])); ?>"
                                                                            class="tag-cloud-link tag-link-position-<?php echo e($loop->iteration); ?>"
                                                                            style="font-size: <?php echo e($fontSize); ?>pt;"
                                                                            aria-label="<?php echo e(ucwords($keyword)); ?> (<?php echo e($count); ?> items)">
                                                                            <?php echo e(ucwords($keyword)); ?>

                                                                        </a>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                </div>
                                                            </aside>
                                                            <div class="ps__scrollbar-x-rail"
                                                                style="left: 0px; bottom: 0px;">
                                                                <div class="ps__scrollbar-x" tabindex="0"
                                                                    style="left: 0px; width: 0px;"></div>
                                                            </div>
                                                            <div class="ps__scrollbar-y-rail"
                                                                style="top: 0px; right: 0px;">
                                                                <div class="ps__scrollbar-y" tabindex="0"
                                                                    style="top: 0px; height: 0px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-260e9c6c e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="260e9c6c" data-element_type="container">
                                    <div class="elementor-element elementor-element-19036ac8 active-object-fit active-object-fit-true custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-widget kitify elementor-kitify-posts"
                                        data-id="19036ac8" data-element_type="widget"
                                        data-widget_type="kitify-posts.default">
                                        <div class="elementor-widget-container">

                                            <div data-widget_current_query="yes" id="novapost_19036ac8"
                                                class="kitify-posts layout-type-grid preset-list-1 querycpt--current_query kitify-posts--list"
                                                data-item_selector=".kitify-posts__item">
                                                <div class="kitify-posts__list_wrapper">
                                                    <div class="kitify-posts__list col-row">
                                                        <div class="kitify-posts__loop-wrapper" id="news-container">

                                                            <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div
                                                                    class="kitify-posts__item has-post-thumbnail col-desk-1 col-tabp-1 col-tab-1 col-lap-1 term-<?php echo e($post->category_id); ?>">
                                                                    <div class="kitify-posts__outer-box">
                                                                        <div class="kitify-posts__inner-box">

                                                                            <div
                                                                                class="post-thumbnail kitify-posts__thumbnail">
                                                                                <a href="<?php echo e(route('blog.show', $post->slug)); ?>"
                                                                                    class="kitify-posts__thumbnail-link">

                                                                                    <?php if($post->thumbnail): ?>
                                                                                        <img width="1500" height="1000"
                                                                                            src="<?php echo e($post->thumbnail_url); ?>"
                                                                                            class="kitify-posts__thumbnail-img wp-post-image"
                                                                                            alt="<?php echo e($post->title); ?>"
                                                                                            decoding="async">
                                                                                    <?php else: ?>
                                                                                        <img width="1500" height="1000"
                                                                                            src="<?php echo e(asset('images/placeholder.jpg')); ?>"
                                                                                            class="kitify-posts__thumbnail-img wp-post-image no-thumbnail"
                                                                                            alt="Lỗi/Chưa có ảnh"
                                                                                            decoding="async">
                                                                                    <?php endif; ?>
                                                                                </a>
                                                                            </div>

                                                                            <div class="kitify-posts__inner-content">
                                                                                <div
                                                                                    class="kitify-posts__inner-content-inner">
                                                                                    <div
                                                                                        class="kitify-posts__meta kitify-posts__meta1">
                                                                                        <div
                                                                                            class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                            <span
                                                                                                class="meta--label">By</span>
                                                                                            <span class="meta--value">
                                                                                                <a href="#"
                                                                                                    class="posted-by__author"
                                                                                                    rel="author"><?php echo e($post->author->name ?? 'Người dùng ẩn danh'); ?></a>
                                                                                            </span>
                                                                                        </div>
                                                                                        <div
                                                                                            class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                            <span class="meta--value">
                                                                                                <?php echo e($post->published_at ? $post->published_at->format('F d, Y') : 'Đang cập nhật'); ?>

                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <h4 class="kitify-posts__title">
                                                                                        <a href="<?php echo e(route('blog.show', $post->slug)); ?>"
                                                                                            title="<?php echo e($post->seo_title); ?>"
                                                                                            rel="bookmark">
                                                                                            <?php echo e($post->title); ?>

                                                                                        </a>
                                                                                    </h4>
                                                                                    <div
                                                                                        class="kitify-posts__excerpt entry-excerpt">
                                                                                        <?php echo e($post->excerpt); ?>

                                                                                    </div>
                                                                                    <div
                                                                                        class="kitify-posts__meta kitify-posts__meta2">
                                                                                        <div
                                                                                            class="kitify-posts__meta__item kitify-posts__meta__item--category post__cat">
                                                                                            <span class="meta--value">
                                                                                                <a href="#"
                                                                                                    rel="category tag"><?php echo e($post->category->name ?? 'Không chuyên mục'); ?></a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <nav class="post-pagination kitify-pagination clearfix kitify-ajax-pagination nothingtoshow"
                                                    data-parent-container="#novapost_19036ac8"
                                                    data-container="#novapost_19036ac8 .kitify-posts__list"
                                                    data-item-selector=".kitify-posts__item" data-ajax_request_id="paged">
                                                    <div class="kitify-ajax-loading-outer"><span
                                                            class="kitify-css-loader"></span></div>
                                                    <div
                                                        class="kitify-post__loadmore_ajax kitify-pagination_ajax_loadmore">
                                                        <a href="javascript:;"><span>Load More</span></a>
                                                    </div>
                                                </nav>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- .site-content-wrapper -->
                <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/blog/index.blade.php ENDPATH**/ ?>