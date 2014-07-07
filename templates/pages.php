<section class="content-header">
    <h1>
        <?php echo Localization::fetch('viewing_all')?> <?php echo Localization::fetch('site_pages') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $app->urlFor("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pages</li>
    </ol>
</section>

<?php $fieldset = 'page'; ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <form class="box" action="<?php echo $app->urlFor('delete_entry'); ?>" action="post">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox" id="check-all" data-check-class="table-checkbox" />
                            </th>
                            <th><?php echo Localization::fetch('title')?></th>
                            <th><?php echo Localization::fetch('status')?></th>
                            <th style="text-align: center;"><?php echo Localization::fetch('view')?></th>
                            <th style="text-align: center;"><?php echo Localization::fetch('delete')?></th>
                        </tr>

                        <?php foreach ($pages as $page): ?>
                            <?php $status = isset($page['status']) ? $page['status'] : 'live'; ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="table-checkbox" name="entries[]" value="<?php echo "/{$page['slug']}" ?>" data-bind="checked: selectedEntries" />
                                </td>
                                <td>
                                    <?php $base = $page['slug'];
                                    if ($page['type'] == 'file'): ?>
                                        <a href="<?php print $app->urlFor('publish')."?path={$page['slug']}"; ?>"><span class="page-title"><?php print (isset($page['title']) && $page['title'] <> '') ? $page['title'] : Slug::prettify($page['slug']) ?></span></a>
                                    <?php elseif ($page['type'] == 'home'): ?>
                                        <a href="<?php print $app->urlFor('publish')."?path={$page['url']}"; ?>"><span class="page-title"><?php print $page['title'] ?></span></a>
                                    <?php else: $folder = dirname($page['file_path']); ?>
                                        <a href="<?php print $app->urlFor('publish')."?path={$page['file_path']}"; ?>"><span class="page-title"><?php print (isset($page['title']) && $page['title'] <> '') ? $page['title'] : Slug::prettify($page['slug']) ?></span></a>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php if (strtolower($status) === 'draft') : ?>
                                        <span class="label label-default"><?php print ucwords($status) ?></span>
                                    <?php elseif (strtolower($status) === 'hidden') : ?>
                                        <span class="label label-info"><?php print ucwords($status) ?></span>
                                    <?php else : ?>
                                        <span class="label label-success"><?php print ucwords($status) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?php echo $page['url']?>" class="entry-view" target="_blank">
                                        <i class="fa fa-link"></i>
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?php echo $app->urlFor('delete_entry'); ?>">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="btn-group" data-bind="css: {disabled: selectedEntries().length < 1}">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <?php echo Localization::fetch('take_action')?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#"><?php echo Localization::fetch('delete_entries')?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>