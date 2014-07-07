<section class="content-header">
    <h1>
        <?php echo Localization::fetch('viewing_all')?> <?php echo Localization::fetch('members')?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $app->urlFor("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo ucwords(Localization::fetch('members')); ?></li>
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
                            <th style="width: 80px;">Gravatar</th>
                            <th><?php echo Localization::fetch('Name'); ?></th>
                            <th><?php echo Localization::fetch('Email'); ?></th>
                            <th style="text-align: center;"><?php echo Localization::fetch('delete')?></th>
                        </tr>

                        <?php foreach ($members as $name => $member): ?>
                            <?php $status = isset($entry['status']) ? $entry['status'] : 'live'; ?>
                            <tr>
                                <td style="vertical-align: middle;">
                                    <input type="checkbox" class="table-checkbox" name="entries[]" value="<?php echo "{$path}/{$slug}" ?>" data-bind="checked: selectedEntries" />
                                </td>
                                <td style="vertical-align: middle;">
                                    <img src="<?php echo $member->getGravatar(35); ?>" class="img-rounded" alt="" style="max-height: 35px;" />
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="<?php echo $app->urlFor("member")."?name={$name}"; ?>">
                                        <?php echo $member->get_full_name(); ?>
                                    </a>
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="<?php echo $app->urlFor("member")."?name={$name}"; ?>">
                                        <?php echo $member->get_email(); ?>
                                    </a>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="<?php echo $app->urlFor('deletemember')."?name={$name}"; ?>">
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