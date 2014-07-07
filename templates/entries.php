<section class="content-header">
    <h1>
        <?php echo Localization::fetch('viewing_all')?> <?php echo Localization::fetch('entries', null, true)?>
        <small>/<?php echo $folder; ?>/</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $app->urlFor("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo ucfirst($folder); ?></li>
    </ol>
</section>

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
                            <?php if ($type == 'date'): ?>
                                <th><?php echo Localization::fetch('date')?></th>
                            <?php elseif ($type == 'number' || $type == 'numeric'): ?>
                                <th><?php echo Localization::fetch('number')?></th>
                            <?php endif; ?>
                            <th><?php echo Localization::fetch('status')?></th>
                            <th style="text-align: center;"><?php echo Localization::fetch('view')?></th>
                            <th style="text-align: center;"><?php echo Localization::fetch('delete')?></th>
                        </tr>

                        <?php foreach ($entries as $slug => $entry): ?>
                            <?php $status = isset($entry['status']) ? $entry['status'] : 'live'; ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="table-checkbox" name="entries[]" value="<?php echo "{$path}/{$slug}" ?>" data-bind="checked: selectedEntries" />
                                </td>
                                <td>
                                    <a href="<?php echo $app->urlFor('publish')?>?path=<?php echo Path::tidy($path.'/')?><?php echo $slug ?>">
                                        <?php echo (isset($entry['title']) && $entry['title'] <> '') ? $entry['title'] : Slug::prettify($entry['slug']) ?>
                                    </a>
                                </td>
                                <?php if ($type == 'date'): ?>
                                    <td data-fulldate="<?php echo $entry['datestamp']; ?>">
                                        <?php echo Date::format(Config::getDateFormat('Y/m/d'), $entry['datestamp']); ?>
                                    </td>
                                <?php elseif ($type == 'number'): ?>
                                    <td>
                                        <?php echo $entry['numeric']; ?>
                                    </td>
                                <?php endif ?>
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
                                    <a href="<?php echo $entry['url']?>" class="entry-view" target="_blank">
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