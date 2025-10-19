@extends('master')
@section('content')

    <body
        class="blog wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-625 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  blog-pagination-default kitify--enabled">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div data-elementor-type="archive" data-elementor-id="625"
                        class="elementor elementor-625 elementor-location-archive">
                        <div class="elementor-element elementor-element-d282e6b e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="d282e6b" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-650f302 kitify-breadcrumbs-page-title-yes kitify-breadcrumbs-align-center elementor-widget kitify elementor-kitify-breadcrumbs"
                                    data-id="650f302" data-element_type="widget"
                                    data-widget_type="kitify-breadcrumbs.default">
                                    <div class="elementor-widget-container">

                                        <div class="kitify-breadcrumbs">
                                            <h3 class="kitify-breadcrumbs__title">Blog</h3>
                                            <div class="kitify-breadcrumbs__content">
                                                <div class="kitify-breadcrumbs__wrap">
                                                    <div class="kitify-breadcrumbs__item"><a href="../index.html"
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
                        <div class="elementor-element elementor-element-577be7f0 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="577be7f0" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-4ff1bacc e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="4ff1bacc" data-element_type="container">
                                    <div class="elementor-element elementor-element-36b3f36f e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
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
                                                        <div class="kitify-toggle-sidebar__inner nova_box_ps">
                                                            <aside class="widget widget_search">
                                                                <form role="search" method="get" class="search-form"
                                                                    action="https://mixtas.novaworks.net/">
                                                                    <label>
                                                                        <span class="screen-reader-text">Search for:</span>
                                                                        <input type="search" class="search-field"
                                                                            placeholder="Search &hellip;" value=""
                                                                            name="s" />
                                                                    </label>
                                                                    <input type="submit" class="search-submit"
                                                                        value="Search" />
                                                                </form>
                                                            </aside>
                                                            <aside class="widget widget_categories">
                                                                <h4 class="widget-title">Categories</h4>
                                                                <ul>
                                                                    <li class="cat-item cat-item-54"><a
                                                                            href="../category/men-clothing/index.html">Men
                                                                            Clothing</a> <span class="count">3</span>
                                                                    </li>
                                                                    <li class="cat-item cat-item-53"><a
                                                                            href="../category/news/index.html">News</a>
                                                                        <span class="count">6</span>
                                                                    </li>
                                                                    <li class="cat-item cat-item-62"><a
                                                                            href="../category/women-clothing/index.html">Women
                                                                            Clothing</a> <span class="count">3</span>
                                                                    </li>
                                                                </ul>

                                                            </aside>
                                                            <aside class="widget widget_calendar">
                                                                <div id="calendar_wrap" class="calendar_wrap">
                                                                    <table id="wp-calendar" class="wp-calendar-table">
                                                                        <caption>September 2025</caption>
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" aria-label="Monday">M
                                                                                </th>
                                                                                <th scope="col" aria-label="Tuesday">T
                                                                                </th>
                                                                                <th scope="col" aria-label="Wednesday">
                                                                                    W
                                                                                </th>
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
                                                                                <td>1</td>
                                                                                <td>2</td>
                                                                                <td>3</td>
                                                                                <td>4</td>
                                                                                <td>5</td>
                                                                                <td>6</td>
                                                                                <td>7</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>8</td>
                                                                                <td>9</td>
                                                                                <td>10</td>
                                                                                <td>11</td>
                                                                                <td>12</td>
                                                                                <td>13</td>
                                                                                <td>14</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>15</td>
                                                                                <td>16</td>
                                                                                <td>17</td>
                                                                                <td>18</td>
                                                                                <td>19</td>
                                                                                <td>20</td>
                                                                                <td>21</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>22</td>
                                                                                <td>23</td>
                                                                                <td>24</td>
                                                                                <td>25</td>
                                                                                <td>26</td>
                                                                                <td>27</td>
                                                                                <td>28</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>29</td>
                                                                                <td id="today">30</td>
                                                                                <td class="pad" colspan="5">&nbsp;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <nav aria-label="Previous and next months"
                                                                        class="wp-calendar-nav">
                                                                        <span class="wp-calendar-nav-prev"><a
                                                                                href="../2023/12/index.html">&laquo;
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
                                                                    <option value='../2023/12/index.html'> December 2023
                                                                    </option>

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
                                                                    <li>
                                                                        <div class="pr-item">

                                                                            <div class="pr-item--left">
                                                                                <a href="../2023/12/fashion-forward-emerging-trends-you-need-to-know/index.html"
                                                                                    class="nova-lazyload-image"
                                                                                    data-background-image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06-150x150.jpg"><span
                                                                                        class="hidden">Fashion Forward:
                                                                                        Emerging Trends You Need to
                                                                                        Know</span></a>
                                                                            </div>

                                                                            <div class="pr-item--right">
                                                                                <span class="post-date">December 19,
                                                                                    2023</span>
                                                                                <a
                                                                                    href="../2023/12/fashion-forward-emerging-trends-you-need-to-know/index.html">Fashion
                                                                                    Forward: Emerging Trends You Need to
                                                                                    Know</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="pr-item">

                                                                            <div class="pr-item--left">
                                                                                <a href="../2023/12/dress-to-impress-a-guide-to-power-dressing-for-success/index.html"
                                                                                    class="nova-lazyload-image"
                                                                                    data-background-image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05-150x150.jpg"><span
                                                                                        class="hidden">Dress to Impress: A
                                                                                        Guide to Power Dressing for
                                                                                        Success</span></a>
                                                                            </div>

                                                                            <div class="pr-item--right">
                                                                                <span class="post-date">December 19,
                                                                                    2023</span>
                                                                                <a
                                                                                    href="../2023/12/dress-to-impress-a-guide-to-power-dressing-for-success/index.html">Dress
                                                                                    to Impress: A Guide to Power Dressing
                                                                                    for Success</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="pr-item">

                                                                            <div class="pr-item--left">
                                                                                <a href="../2023/12/unveiling-elegance-timeless-fashion-trends-for-women/index.html"
                                                                                    class="nova-lazyload-image"
                                                                                    data-background-image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-04-150x150.jpg"><span
                                                                                        class="hidden">Unveiling Elegance:
                                                                                        Timeless Fashion Trends for
                                                                                        Women</span></a>
                                                                            </div>

                                                                            <div class="pr-item--right">
                                                                                <span class="post-date">December 19,
                                                                                    2023</span>
                                                                                <a
                                                                                    href="../2023/12/unveiling-elegance-timeless-fashion-trends-for-women/index.html">Unveiling
                                                                                    Elegance: Timeless Fashion Trends for
                                                                                    Women</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="pr-item">

                                                                            <div class="pr-item--left">
                                                                                <a href="../2023/12/gentlemans-gazette-a-guide-to-timeless-mens-fashion/index.html"
                                                                                    class="nova-lazyload-image"
                                                                                    data-background-image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-03-150x150.jpg"><span
                                                                                        class="hidden">Gentleman&#8217;s
                                                                                        Gazette: A Guide to Timeless
                                                                                        Men&#8217;s Fashion</span></a>
                                                                            </div>

                                                                            <div class="pr-item--right">
                                                                                <span class="post-date">December 14,
                                                                                    2023</span>
                                                                                <a
                                                                                    href="../2023/12/gentlemans-gazette-a-guide-to-timeless-mens-fashion/index.html">Gentleman&#8217;s
                                                                                    Gazette: A Guide to Timeless Men&#8217;s
                                                                                    Fashion</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="pr-item">

                                                                            <div class="pr-item--left">
                                                                                <a href="../2023/12/tailored-tales-unveiling-the-latest-trends-in-mens-fashion/index.html"
                                                                                    class="nova-lazyload-image"
                                                                                    data-background-image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-02-150x150.jpg"><span
                                                                                        class="hidden">Tailored Tales:
                                                                                        Unveiling the Latest Trends in
                                                                                        Men&#8217;s Fashion</span></a>
                                                                            </div>

                                                                            <div class="pr-item--right">
                                                                                <span class="post-date">December 14,
                                                                                    2023</span>
                                                                                <a
                                                                                    href="../2023/12/tailored-tales-unveiling-the-latest-trends-in-mens-fashion/index.html">Tailored
                                                                                    Tales: Unveiling the Latest Trends in
                                                                                    Men&#8217;s Fashion</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </aside>
                                                            <aside class="widget widget_tag_cloud">
                                                                <h4 class="widget-title">Tags</h4>
                                                                <div class="tagcloud"><a href="../tag/clothing/index.html"
                                                                        class="tag-cloud-link tag-link-50 tag-link-position-1"
                                                                        style="font-size: 22pt;"
                                                                        aria-label="clothing (6 items)">clothing</a>
                                                                    <a href="../tag/men/index.html"
                                                                        class="tag-cloud-link tag-link-55 tag-link-position-2"
                                                                        style="font-size: 8pt;"
                                                                        aria-label="men (3 items)">men</a>
                                                                    <a href="../tag/posts/index.html"
                                                                        class="tag-cloud-link tag-link-52 tag-link-position-3"
                                                                        style="font-size: 22pt;"
                                                                        aria-label="posts (6 items)">posts</a>
                                                                    <a href="../tag/shopping/index.html"
                                                                        class="tag-cloud-link tag-link-48 tag-link-position-4"
                                                                        style="font-size: 22pt;"
                                                                        aria-label="shopping (6 items)">shopping</a>
                                                                    <a href="../tag/women/index.html"
                                                                        class="tag-cloud-link tag-link-63 tag-link-position-5"
                                                                        style="font-size: 8pt;"
                                                                        aria-label="women (3 items)">women</a>
                                                                </div>
                                                            </aside>
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
                                                        @foreach ($news as $new)
                                                            <div
                                                                class="kitify-posts__item has-post-thumbnail col-desk-1 col-tabp-1 col-tab-1 col-lap-1 term-53 term-62 term-50 term-52 term-48 term-63">
                                                                <div class="kitify-posts__outer-box">
                                                                    <div class="kitify-posts__inner-box">
                                                                        <div
                                                                            class="post-thumbnail kitify-posts__thumbnail">
                                                                            <a href="{{ route('blog.show', $new->id) }}"
                                                                                class="kitify-posts__thumbnail-link"><img
                                                                                    width="1500" height="1000"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06.jpg"
                                                                                    class="kitify-posts__thumbnail-img wp-post-image nova-lazyload-image wp-post-image"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06.jpg 1500w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06-300x200.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06-1024x683.jpg 1024w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06-768x512.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06-1000x667.jpg 1000w"
                                                                                    sizes="(max-width: 1500px) 100vw, 1500px" /></a>

                                                                        </div>
                                                                        <div class="kitify-posts__inner-content">
                                                                            <div class="kitify-posts__inner-content-inner">
                                                                                <div
                                                                                    class="kitify-posts__meta kitify-posts__meta1">
                                                                                    <div
                                                                                        class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                        <span
                                                                                            class="meta--label">By</span><span
                                                                                            class="meta--value"><a
                                                                                                href="../author/admin/index.html"
                                                                                                class="posted-by__author"
                                                                                                rel="author">admin</a></span>
                                                                                    </div>
                                                                                    <div
                                                                                        class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                        <span class="meta--value">December
                                                                                            19,
                                                                                            2023</span>
                                                                                    </div>
                                                                                </div>
                                                                                <h4 class="kitify-posts__title"><a
                                                                                        href="../2023/12/fashion-forward-emerging-trends-you-need-to-know/index.html"
                                                                                        title="Fashion Forward: Emerging Trends You Need to Know"
                                                                                        rel="bookmark">Fashion Forward:
                                                                                        Emerging
                                                                                        Trends You Need to Know</a></h4>
                                                                                <div
                                                                                    class="kitify-posts__excerpt entry-excerpt">
                                                                                    What makes a purchase “worth it”? The
                                                                                    answer
                                                                                    is different for everybody,
                                                                                    so&nbsp;we’re
                                                                                    asking&nbsp;some of the coolest, most
                                                                                    shopping-savvy people we know—from
                                                                                    small-business owners to designers,
                                                                                    artists,
                                                                                    and actors—to tell&hellip;</div>
                                                                                <div
                                                                                    class="kitify-posts__meta kitify-posts__meta2">
                                                                                    <div
                                                                                        class="kitify-posts__meta__item kitify-posts__meta__item--category post__cat">
                                                                                        <span class="meta--value"><a
                                                                                                href="../category/news/index.html"
                                                                                                rel="category tag">News</a><span
                                                                                                class="cspr">, </span><a
                                                                                                href="../category/women-clothing/index.html"
                                                                                                rel="category tag">Women
                                                                                                Clothing</a></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        {{-- <div
                                                        class="kitify-posts__item has-post-thumbnail col-desk-1 col-tabp-1 col-tab-1 col-lap-1 term-53 term-62 term-50 term-52 term-48 term-63">
                                                        <div class="kitify-posts__outer-box">
                                                            <div class="kitify-posts__inner-box">
                                                                <div class="post-thumbnail kitify-posts__thumbnail">
                                                                    <a href="../2023/12/dress-to-impress-a-guide-to-power-dressing-for-success/index.html"
                                                                        class="kitify-posts__thumbnail-link"><img
                                                                            width="1500" height="1000"
                                                                            src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05.jpg"
                                                                            class="kitify-posts__thumbnail-img wp-post-image nova-lazyload-image wp-post-image"
                                                                            alt="" decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05.jpg 1500w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05-300x200.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05-1024x683.jpg 1024w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05-768x512.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05-1000x667.jpg 1000w"
                                                                            sizes="(max-width: 1500px) 100vw, 1500px" /></a>

                                                                </div>
                                                                <div class="kitify-posts__inner-content">
                                                                    <div class="kitify-posts__inner-content-inner">
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta1">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                <span class="meta--label">By</span><span
                                                                                    class="meta--value"><a
                                                                                        href="../author/admin/index.html"
                                                                                        class="posted-by__author"
                                                                                        rel="author">admin</a></span>
                                                                            </div>
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                <span class="meta--value">December 19,
                                                                                    2023</span>
                                                                            </div>
                                                                        </div>
                                                                        <h4 class="kitify-posts__title"><a
                                                                                href="../2023/12/dress-to-impress-a-guide-to-power-dressing-for-success/index.html"
                                                                                title="Dress to Impress: A Guide to Power Dressing for Success"
                                                                                rel="bookmark">Dress to Impress: A Guide
                                                                                to Power Dressing for Success</a></h4>
                                                                        <div
                                                                            class="kitify-posts__excerpt entry-excerpt">
                                                                            What makes a purchase “worth it”? The answer
                                                                            is different for everybody, so&nbsp;we’re
                                                                            asking&nbsp;some of the coolest, most
                                                                            shopping-savvy people we know—from
                                                                            small-business owners to designers, artists,
                                                                            and actors—to tell&hellip;</div>
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta2">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--category post__cat">
                                                                                <span class="meta--value"><a
                                                                                        href="../category/news/index.html"
                                                                                        rel="category tag">News</a><span
                                                                                        class="cspr">, </span><a
                                                                                        href="../category/women-clothing/index.html"
                                                                                        rel="category tag">Women
                                                                                        Clothing</a></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="kitify-posts__item has-post-thumbnail col-desk-1 col-tabp-1 col-tab-1 col-lap-1 term-53 term-62 term-50 term-52 term-48 term-63">
                                                        <div class="kitify-posts__outer-box">
                                                            <div class="kitify-posts__inner-box">
                                                                <div class="post-thumbnail kitify-posts__thumbnail">
                                                                    <a href="../2023/12/unveiling-elegance-timeless-fashion-trends-for-women/index.html"
                                                                        class="kitify-posts__thumbnail-link"><img
                                                                            width="1500" height="1000"
                                                                            src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-04.jpg"
                                                                            class="kitify-posts__thumbnail-img wp-post-image nova-lazyload-image wp-post-image"
                                                                            alt="" decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-04.jpg 1500w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-04-300x200.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-04-1024x683.jpg 1024w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-04-768x512.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-04-1000x667.jpg 1000w"
                                                                            sizes="(max-width: 1500px) 100vw, 1500px" /></a>

                                                                </div>
                                                                <div class="kitify-posts__inner-content">
                                                                    <div class="kitify-posts__inner-content-inner">
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta1">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                <span class="meta--label">By</span><span
                                                                                    class="meta--value"><a
                                                                                        href="../author/admin/index.html"
                                                                                        class="posted-by__author"
                                                                                        rel="author">admin</a></span>
                                                                            </div>
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                <span class="meta--value">December 19,
                                                                                    2023</span>
                                                                            </div>
                                                                        </div>
                                                                        <h4 class="kitify-posts__title"><a
                                                                                href="../2023/12/unveiling-elegance-timeless-fashion-trends-for-women/index.html"
                                                                                title="Unveiling Elegance: Timeless Fashion Trends for Women"
                                                                                rel="bookmark">Unveiling Elegance:
                                                                                Timeless Fashion Trends for Women</a>
                                                                        </h4>
                                                                        <div
                                                                            class="kitify-posts__excerpt entry-excerpt">
                                                                            What makes a purchase “worth it”? The answer
                                                                            is different for everybody, so&nbsp;we’re
                                                                            asking&nbsp;some of the coolest, most
                                                                            shopping-savvy people we know—from
                                                                            small-business owners to designers, artists,
                                                                            and actors—to tell&hellip;</div>
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta2">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--category post__cat">
                                                                                <span class="meta--value"><a
                                                                                        href="../category/news/index.html"
                                                                                        rel="category tag">News</a><span
                                                                                        class="cspr">, </span><a
                                                                                        href="../category/women-clothing/index.html"
                                                                                        rel="category tag">Women
                                                                                        Clothing</a></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="kitify-posts__item has-post-thumbnail col-desk-1 col-tabp-1 col-tab-1 col-lap-1 term-54 term-53 term-50 term-55 term-52 term-48">
                                                        <div class="kitify-posts__outer-box">
                                                            <div class="kitify-posts__inner-box">
                                                                <div class="post-thumbnail kitify-posts__thumbnail">
                                                                    <a href="../2023/12/gentlemans-gazette-a-guide-to-timeless-mens-fashion/index.html"
                                                                        class="kitify-posts__thumbnail-link"><img
                                                                            width="1500" height="1000"
                                                                            src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-03.jpg"
                                                                            class="kitify-posts__thumbnail-img wp-post-image nova-lazyload-image wp-post-image"
                                                                            alt="" decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-03.jpg 1500w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-03-300x200.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-03-1024x683.jpg 1024w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-03-768x512.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-03-1000x667.jpg 1000w"
                                                                            sizes="(max-width: 1500px) 100vw, 1500px" /></a>

                                                                </div>
                                                                <div class="kitify-posts__inner-content">
                                                                    <div class="kitify-posts__inner-content-inner">
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta1">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                <span class="meta--label">By</span><span
                                                                                    class="meta--value"><a
                                                                                        href="../author/admin/index.html"
                                                                                        class="posted-by__author"
                                                                                        rel="author">admin</a></span>
                                                                            </div>
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                <span class="meta--value">December 14,
                                                                                    2023</span>
                                                                            </div>
                                                                        </div>
                                                                        <h4 class="kitify-posts__title"><a
                                                                                href="../2023/12/gentlemans-gazette-a-guide-to-timeless-mens-fashion/index.html"
                                                                                title="Gentleman&#8217;s Gazette: A Guide to Timeless Men&#8217;s Fashion"
                                                                                rel="bookmark">Gentleman&#8217;s
                                                                                Gazette: A Guide to Timeless Men&#8217;s
                                                                                Fashion</a></h4>
                                                                        <div
                                                                            class="kitify-posts__excerpt entry-excerpt">
                                                                            What makes a purchase “worth it”? The answer
                                                                            is different for everybody, so&nbsp;we’re
                                                                            asking&nbsp;some of the coolest, most
                                                                            shopping-savvy people we know—from
                                                                            small-business owners to designers, artists,
                                                                            and actors—to tell&hellip;</div>
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta2">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--category post__cat">
                                                                                <span class="meta--value"><a
                                                                                        href="../category/men-clothing/index.html"
                                                                                        rel="category tag">Men
                                                                                        Clothing</a><span class="cspr">,
                                                                                    </span><a
                                                                                        href="../category/news/index.html"
                                                                                        rel="category tag">News</a></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="kitify-posts__item has-post-thumbnail col-desk-1 col-tabp-1 col-tab-1 col-lap-1 term-54 term-53 term-50 term-55 term-52 term-48">
                                                        <div class="kitify-posts__outer-box">
                                                            <div class="kitify-posts__inner-box">
                                                                <div class="post-thumbnail kitify-posts__thumbnail">
                                                                    <a href="../2023/12/tailored-tales-unveiling-the-latest-trends-in-mens-fashion/index.html"
                                                                        class="kitify-posts__thumbnail-link"><img
                                                                            width="1500" height="1000"
                                                                            src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-02.jpg"
                                                                            class="kitify-posts__thumbnail-img wp-post-image nova-lazyload-image wp-post-image"
                                                                            alt="" decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-02.jpg 1500w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-02-300x200.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-02-1024x683.jpg 1024w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-02-768x512.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-02-1000x667.jpg 1000w"
                                                                            sizes="(max-width: 1500px) 100vw, 1500px" /></a>

                                                                </div>
                                                                <div class="kitify-posts__inner-content">
                                                                    <div class="kitify-posts__inner-content-inner">
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta1">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                <span class="meta--label">By</span><span
                                                                                    class="meta--value"><a
                                                                                        href="../author/admin/index.html"
                                                                                        class="posted-by__author"
                                                                                        rel="author">admin</a></span>
                                                                            </div>
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                <span class="meta--value">December 14,
                                                                                    2023</span>
                                                                            </div>
                                                                        </div>
                                                                        <h4 class="kitify-posts__title"><a
                                                                                href="../2023/12/tailored-tales-unveiling-the-latest-trends-in-mens-fashion/index.html"
                                                                                title="Tailored Tales: Unveiling the Latest Trends in Men&#8217;s Fashion"
                                                                                rel="bookmark">Tailored Tales: Unveiling
                                                                                the Latest Trends in Men&#8217;s
                                                                                Fashion</a></h4>
                                                                        <div
                                                                            class="kitify-posts__excerpt entry-excerpt">
                                                                            What makes a purchase “worth it”? The answer
                                                                            is different for everybody, so&nbsp;we’re
                                                                            asking&nbsp;some of the coolest, most
                                                                            shopping-savvy people we know—from
                                                                            small-business owners to designers, artists,
                                                                            and actors—to tell&hellip;</div>
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta2">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--category post__cat">
                                                                                <span class="meta--value"><a
                                                                                        href="../category/men-clothing/index.html"
                                                                                        rel="category tag">Men
                                                                                        Clothing</a><span class="cspr">,
                                                                                    </span><a
                                                                                        href="../category/news/index.html"
                                                                                        rel="category tag">News</a></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="kitify-posts__item has-post-thumbnail col-desk-1 col-tabp-1 col-tab-1 col-lap-1 term-54 term-53 term-50 term-55 term-52 term-48">
                                                        <div class="kitify-posts__outer-box">
                                                            <div class="kitify-posts__inner-box">
                                                                <div class="post-thumbnail kitify-posts__thumbnail">
                                                                    <a href="../2023/12/menswear-maven-fashion-finds-for-every-occasion/index.html"
                                                                        class="kitify-posts__thumbnail-link"><img
                                                                            width="1500" height="1000"
                                                                            src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-01.jpg"
                                                                            class="kitify-posts__thumbnail-img wp-post-image nova-lazyload-image wp-post-image"
                                                                            alt="" decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-01.jpg 1500w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-01-300x200.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-01-1024x683.jpg 1024w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-01-768x512.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-01-1000x667.jpg 1000w"
                                                                            sizes="(max-width: 1500px) 100vw, 1500px" /></a>

                                                                </div>
                                                                <div class="kitify-posts__inner-content">
                                                                    <div class="kitify-posts__inner-content-inner">
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta1">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                <span class="meta--label">By</span><span
                                                                                    class="meta--value"><a
                                                                                        href="../author/admin/index.html"
                                                                                        class="posted-by__author"
                                                                                        rel="author">admin</a></span>
                                                                            </div>
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                <span class="meta--value">December 6,
                                                                                    2023</span>
                                                                            </div>
                                                                        </div>
                                                                        <h4 class="kitify-posts__title"><a
                                                                                href="../2023/12/menswear-maven-fashion-finds-for-every-occasion/index.html"
                                                                                title="Menswear Maven: Fashion Finds for Every Occasion"
                                                                                rel="bookmark">Menswear Maven: Fashion
                                                                                Finds for Every Occasion</a></h4>
                                                                        <div
                                                                            class="kitify-posts__excerpt entry-excerpt">
                                                                            What makes a purchase “worth it”? The answer
                                                                            is different for everybody, so&nbsp;we’re
                                                                            asking&nbsp;some of the coolest, most
                                                                            shopping-savvy people we know—from
                                                                            small-business owners to designers, artists,
                                                                            and actors—to tell&hellip;</div>
                                                                        <div
                                                                            class="kitify-posts__meta kitify-posts__meta2">
                                                                            <div
                                                                                class="kitify-posts__meta__item kitify-posts__meta__item--category post__cat">
                                                                                <span class="meta--value"><a
                                                                                        href="../category/men-clothing/index.html"
                                                                                        rel="category tag">Men
                                                                                        Clothing</a><span class="cspr">,
                                                                                    </span><a
                                                                                        href="../category/news/index.html"
                                                                                        rel="category tag">News</a></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
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
                @include('layouts.footer')
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            @include('layouts.js')
        @endsection
