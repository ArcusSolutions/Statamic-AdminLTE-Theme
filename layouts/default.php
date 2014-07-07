<?php

$current_user = Auth::getCurrentMember();
$name = $current_user->get('name');

?><!DOCTYPE html>
<html lang="<?php echo Config::getCurrentLanguage(); ?>">
<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>Statamic Control Panel</title>

    <link href="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>css/adminlte.css" rel="stylesheet" type="text/css" />

    <script>
        var transliterate = <?php echo json_encode(Config::get('custom_transliteration', array())); ?>;
    </script>
    <script>
        var content_type = "<?php echo Config::getContentType(); ?>";
    </script>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <?php echo Hook::run('control_panel', 'add_to_head', 'cumulative') ?>
</head>
<body class="skin-blue fixed" id="<?php echo $route; ?>">
    <header class="header">
        <a href="<?php echo $app->urlFor("dashboard"); ?>" class="logo">Statamic</a>

        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
<!--                    <li class="dropdown notifications-menu">-->
<!--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
<!--                            <i class="fa fa-warning"></i>-->
<!--                            <span class="label label-warning">10</span>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu">-->
<!--                            <li class="header">You have 10 notifications</li>-->
<!--                            <li>-->
<!--                                <!-- inner menu: contains the actual data -->
<!--                                <ul class="menu">-->
<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="ion ion-ios7-people info"></i> 5 new members joined today-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="fa fa-users warning"></i> 5 new members joined-->
<!--                                        </a>-->
<!--                                    </li>-->

<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="ion ion-ios7-cart success"></i> 25 sales made-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="ion ion-ios7-person danger"></i> You changed your username-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                            <li class="footer"><a href="#">View all</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span><?php echo $current_user->get('first_name') . ' ' . $current_user->get('last_name'); ?> <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <img src="<?php echo $current_user->getGravatar(90); ?>" class="img-circle" alt="User Image" />
                                <p>
                                    <?php echo $current_user->get('first_name') . ' ' . $current_user->get('last_name'); ?>
                                    <small><?php echo $current_user->get('email'); ?></small>
                                </p>
                            </li>
                            <?php if (CP_Helper::show_page('account', true) || CP_Helper::show_page('logout', true)): ?>
                                <li class="user-footer">
                                    <?php if (CP_Helper::show_page('account', true)): ?>
                                        <div class="pull-left">
                                            <a href="<?php echo $app->urlFor("member")."?name={$name}"; ?>" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (CP_Helper::show_page('logout', true)): ?>
                                        <div class="pull-right">
                                            <a href="<?php echo $app->urlFor("logout"); ?>" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <aside class="left-side sidebar-offcanvas">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php echo $current_user->getGravatar(45) ?>" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>Hello, <?php echo $current_user->get('first_name'); ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <ul class="sidebar-menu">
                    <?php if (CP_Helper::show_page('dashboard', true)): ?>
                        <li>
                            <a href="<?php echo $app->urlFor("dashboard"); ?>" class="<?php echo ($route === "dashboard") ? 'active' : ''; ?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (CP_Helper::show_page('members', true)): ?>
                        <li class="treeview <?php echo ($route === "members") ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Members</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?php echo $app->urlFor("members"); ?>">
                                        <i class="fa fa-angle-double-right"></i> All Members
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $app->urlFor('member')."?new=1"; ?>">
                                        <i class="fa fa-angle-double-right"></i> New Member
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (CP_Helper::show_page('pages', true) && Config::get('_enable_add_top_level_page', true)): ?>
                        <li class="treeview <?php echo ($route === "pages") ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-files-o"></i>
                                <span>Pages</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?php echo $app->urlFor("pages"); ?>">
                                        <i class="fa fa-angle-double-right"></i> All Pages
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $app->urlFor('publish'); ?>?path=/&new=true">
                                        <i class="fa fa-angle-double-right"></i> New Page
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li>
                            <a href="<?php echo $app->urlFor("pages"); ?>" class="<?php echo ($route === "pages") ? 'active' : ''; ?>">
                                <i class="fa fa-files-o"></i> <span>Pages</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php foreach(Statamic::get_listings() as $listing): ?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-list"></i>
                                <span><?php echo $listing['title']; ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="/admin.php/entries?path=<?php echo $listing['slug']; ?>">
                                        <i class="fa fa-angle-double-right"></i> All <?php echo $listing['title']; ?> Entries
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $app->urlFor('publish') . "?path={$listing['slug']}&new=true"; ?>">
                                        <i class="fa fa-angle-double-right"></i> New <?php echo $listing['title']; ?> Entry
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </aside>

        <aside class="right-side">
            <?php echo $_html; ?>

            <div id="footer" class="clearfix" style="padding: 0 15px; color: #777">
                <div class="pull-left">
                    Statamic theme by <a href="http://arcussolutions.com" target="_blank">Arcus Solutions, LLC</a>
                </div>
                <div class="pull-right">
                    <a href="http://almsaeedstudio.com/preview" target="_blank">AdmintLTE</a> template by <a href="http://almsaeedstudio.com/" target="_blank">Almaseed Studio</a>
                </div>
            </div>
        </aside>
    </div>


    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/markitup/jquery.markitup.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/bootstrap-datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/speakingurls/speakingurls.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/plugins/selectize/selectize.min.js" type="text/javascript"></script>

    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/adminlte.js"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/arcussolutions.js"></script>

    <?php if ($route === "dashboard") : ?>
        <script type="text/javascript">
            $(function() {
                //Make the dashboard widgets sortable Using jquery UI
                $(".connectedSortable").sortable({
                    placeholder: "sort-highlight",
                    connectWith: ".connectedSortable",
                    handle: ".box-header, .nav-tabs",
                    forcePlaceholderSize: true,
                    zIndex: 999999
                }).disableSelection();
                $(".box-header, .nav-tabs").css("cursor","move");
                //jQuery UI sortable for the todo list
                $(".todo-list").sortable({
                    placeholder: "sort-highlight",
                    handle: ".handle",
                    forcePlaceholderSize: true,
                    zIndex: 999999
                }).disableSelection();;

                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();

                $('.daterange').daterangepicker(
                    {
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                            'Last 7 Days': [moment().subtract('days', 6), moment()],
                            'Last 30 Days': [moment().subtract('days', 29), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                        },
                        startDate: moment().subtract('days', 29),
                        endDate: moment()
                    },
                    function(start, end) {
                        alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    });

                /* jQueryKnob */
                $(".knob").knob();

                //jvectormap data
                var visitorsData = {
                    "US": 398, //USA
                    "SA": 400, //Saudi Arabia
                    "CA": 1000, //Canada
                    "DE": 500, //Germany
                    "FR": 760, //France
                    "CN": 300, //China
                    "AU": 700, //Australia
                    "BR": 600, //Brazil
                    "IN": 800, //India
                    "GB": 320, //Great Britain
                    "RU": 3000 //Russia
                };
                //World map by jvectormap
                $('#world-map').vectorMap({
                    map: 'world_mill_en',
                    backgroundColor: "#fff",
                    regionStyle: {
                        initial: {
                            fill: '#e4e4e4',
                            "fill-opacity": 1,
                            stroke: 'none',
                            "stroke-width": 0,
                            "stroke-opacity": 1
                        }
                    },
                    series: {
                        regions: [{
                            values: visitorsData,
                            scale: ["#3c8dbc", "#2D79A6"], //['#3E5E6B', '#A6BAC2'],
                            normalizeFunction: 'polynomial'
                        }]
                    },
                    onRegionLabelShow: function(e, el, code) {
                        if (typeof visitorsData[code] != "undefined")
                            el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
                    }
                });

                //Sparkline charts
                var myvalues = [15, 19, 20, -22, -33, 27, 31, 27, 19, 30, 21];
                $('#sparkline-1').sparkline(myvalues, {
                    type: 'bar',
                    barColor: '#00a65a',
                    negBarColor: "#f56954",
                    height: '20px'
                });
                myvalues = [15, 19, 20, 22, -2, -10, -7, 27, 19, 30, 21];
                $('#sparkline-2').sparkline(myvalues, {
                    type: 'bar',
                    barColor: '#00a65a',
                    negBarColor: "#f56954",
                    height: '20px'
                });
                myvalues = [15, -19, -20, 22, 33, 27, 31, 27, 19, 30, 21];
                $('#sparkline-3').sparkline(myvalues, {
                    type: 'bar',
                    barColor: '#00a65a',
                    negBarColor: "#f56954",
                    height: '20px'
                });
                myvalues = [15, 19, 20, 22, 33, -27, -31, 27, 19, 30, 21];
                $('#sparkline-4').sparkline(myvalues, {
                    type: 'bar',
                    barColor: '#00a65a',
                    negBarColor: "#f56954",
                    height: '20px'
                });
                myvalues = [15, 19, 20, 22, 33, 27, 31, -27, -19, 30, 21];
                $('#sparkline-5').sparkline(myvalues, {
                    type: 'bar',
                    barColor: '#00a65a',
                    negBarColor: "#f56954",
                    height: '20px'
                });
                myvalues = [15, 19, -20, 22, -13, 27, 31, 27, 19, 30, 21];
                $('#sparkline-6').sparkline(myvalues, {
                    type: 'bar',
                    barColor: '#00a65a',
                    negBarColor: "#f56954",
                    height: '20px'
                });

                //Date for the calendar events (dummy data)
                var date = new Date();
                var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear();

                //Calendar
                $('#calendar').fullCalendar({
                    editable: true, //Enable drag and drop
                    events: [
                        {
                            title: 'All Day Event',
                            start: new Date(y, m, 1),
                            backgroundColor: "#3c8dbc", //light-blue
                            borderColor: "#3c8dbc" //light-blue
                        },
                        {
                            title: 'Long Event',
                            start: new Date(y, m, d - 5),
                            end: new Date(y, m, d - 2),
                            backgroundColor: "#f39c12", //yellow
                            borderColor: "#f39c12" //yellow
                        },
                        {
                            title: 'Meeting',
                            start: new Date(y, m, d, 10, 30),
                            allDay: false,
                            backgroundColor: "#0073b7", //Blue
                            borderColor: "#0073b7" //Blue
                        },
                        {
                            title: 'Lunch',
                            start: new Date(y, m, d, 12, 0),
                            end: new Date(y, m, d, 14, 0),
                            allDay: false,
                            backgroundColor: "#00c0ef", //Info (aqua)
                            borderColor: "#00c0ef" //Info (aqua)
                        },
                        {
                            title: 'Birthday Party',
                            start: new Date(y, m, d + 1, 19, 0),
                            end: new Date(y, m, d + 1, 22, 30),
                            allDay: false,
                            backgroundColor: "#00a65a", //Success (green)
                            borderColor: "#00a65a" //Success (green)
                        },
                        {
                            title: 'Click for Google',
                            start: new Date(y, m, 28),
                            end: new Date(y, m, 29),
                            url: 'http://google.com/',
                            backgroundColor: "#f56954", //red
                            borderColor: "#f56954" //red
                        }
                    ],
                    buttonText: {//This is to add icons to the visible buttons
                        prev: "<span class='fa fa-caret-left'></span>",
                        next: "<span class='fa fa-caret-right'></span>",
                        today: 'today',
                        month: 'month',
                        week: 'week',
                        day: 'day'
                    },
                    header: {
                        left: 'title',
                        center: '',
                        right: 'prev,next'
                    }
                });

                //SLIMSCROLL FOR CHAT WIDGET
                $('#chat-box').slimScroll({
                    height: '250px'
                });

                /* Morris.js Charts */
                // Sales chart
                var area = new Morris.Area({
                    element: 'revenue-chart',
                    resize: true,
                    data: [
                        {y: '2011 Q1', item1: 2666, item2: 2666},
                        {y: '2011 Q2', item1: 2778, item2: 2294},
                        {y: '2011 Q3', item1: 4912, item2: 1969},
                        {y: '2011 Q4', item1: 3767, item2: 3597},
                        {y: '2012 Q1', item1: 6810, item2: 1914},
                        {y: '2012 Q2', item1: 5670, item2: 4293},
                        {y: '2012 Q3', item1: 4820, item2: 3795},
                        {y: '2012 Q4', item1: 15073, item2: 5967},
                        {y: '2013 Q1', item1: 10687, item2: 4460},
                        {y: '2013 Q2', item1: 8432, item2: 5713}
                    ],
                    xkey: 'y',
                    ykeys: ['item1', 'item2'],
                    labels: ['Item 1', 'Item 2'],
                    lineColors: ['#a0d0e0', '#3c8dbc'],
                    hideHover: 'auto'
                });
                //Donut Chart
                var donut = new Morris.Donut({
                    element: 'sales-chart',
                    resize: true,
                    colors: ["#3c8dbc", "#f56954", "#00a65a"],
                    data: [
                        {label: "Download Sales", value: 12},
                        {label: "In-Store Sales", value: 30},
                        {label: "Mail-Order Sales", value: 20}
                    ],
                    hideHover: 'auto'
                });
                //Bar chart
                var bar = new Morris.Bar({
                    element: 'bar-chart',
                    resize: true,
                    data: [
                        {y: '2006', a: 100, b: 90},
                        {y: '2007', a: 75, b: 65},
                        {y: '2008', a: 50, b: 40},
                        {y: '2009', a: 75, b: 65},
                        {y: '2010', a: 50, b: 40},
                        {y: '2011', a: 75, b: 65},
                        {y: '2012', a: 100, b: 90}
                    ],
                    barColors: ['#00a65a', '#f56954'],
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['CPU', 'DISK'],
                    hideHover: 'auto'
                });
                //Fix for charts under tabs
                $('.box ul.nav a').on('shown.bs.tab', function(e) {
                    area.redraw();
                    donut.redraw();
                });


                /* BOX REFRESH PLUGIN EXAMPLE (usage with morris charts) */
                $("#loading-example").boxRefresh({
                    source: "ajax/dashboard-boxrefresh-demo.php",
                    onLoadDone: function(box) {
                        bar = new Morris.Bar({
                            element: 'bar-chart',
                            resize: true,
                            data: [
                                {y: '2006', a: 100, b: 90},
                                {y: '2007', a: 75, b: 65},
                                {y: '2008', a: 50, b: 40},
                                {y: '2009', a: 75, b: 65},
                                {y: '2010', a: 50, b: 40},
                                {y: '2011', a: 75, b: 65},
                                {y: '2012', a: 100, b: 90}
                            ],
                            barColors: ['#00a65a', '#f56954'],
                            xkey: 'y',
                            ykeys: ['a', 'b'],
                            labels: ['CPU', 'DISK'],
                            hideHover: 'auto'
                        });
                    }
                });

                /* The todo list plugin */
                $(".todo-list").todolist({
                    onCheck: function(ele) {
                        //console.log("The element has been checked")
                    },
                    onUncheck: function(ele) {
                        //console.log("The element has been unchecked")
                    }
                });
            });
        </script>
    <?php endif; ?>

    <?php echo Hook::run('control_panel', 'add_to_foot', 'cumulative') ?>
</body>
</html>