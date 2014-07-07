<section class="content-header">
    <h1>
        <?php echo $status_message; ?>
        <small><?php echo $identifier; ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $app->urlFor("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $identifier; ?></li>
    </ol>
</section>

<section class="content">
    <form enctype="multipart/form-data" method="post" action="publish?path=<?php print $path ?>" data-validate="parsley" class="primary-form">
        <?php if (isset($errors) && (sizeof($errors) > 0)): ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-danger">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo Localization::fetch('error_form_submission')?></h3>
                        </div>
                        <div class="box-body">
                            <?php foreach ($_errors as $field => $error): ?>
                                <div class="alert alert-danger">
                                    <i class="fa fa-ban"></i>
                                    <?php echo $error; ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php print Hook::run('control_panel', 'add_to_publish_form', 'cumulative') ?>

        <input type="hidden" name="page[full_slug]" value="<?php print $full_slug; ?>">
        <input type="hidden" name="page[type]" value="<?php print $type ?>" />
        <input type="hidden" name="page[folder]" value="<?php print $folder ?>" />
        <input type="hidden" name="page[original_slug]" value="<?php print $original_slug ?>" />
        <input type="hidden" name="page[original_datestamp]" value="<?php print $original_datestamp ?>" />
        <input type="hidden" name="page[original_timestamp]" value="<?php print $original_timestamp ?>" />
        <input type="hidden" name="page[original_numeric]" value="<?php print $original_numeric ?>" />
        <input type="hidden" name="return" value="<?php print $return ?>" />

        <?php if (isset($new)): ?>
            <input type="hidden" name="page[new]" value="1" />
        <?php endif ?>

        <?php if (isset($fieldset)): ?>
            <?php if (is_array($fieldset)):?>
                <?php foreach($fieldset as $key => $set): ?>
                    <input type="hidden" name="page[fieldset][<?php print $key ?>]" value="<?php print $set; ?>" />
                <?php endforeach; ?>
            <?php else: ?>
                <input type="hidden" name="page[fieldset]" value="<?php print $fieldset; ?>" />
            <?php endif; ?>
        <?php endif ?>

        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Title</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        // grab default value and instructions for title
                        $title_details = array(
                            "instructions" => array(
                                "above" => null,
                                "below" => null
                            ),
                            "display" => Localization::fetch('title')
                        );

                        if (isset($fields) && is_array($fields) && isset($fields['title'])) {
                            if (isset($fields['title']['instructions'])) {
                                if (!is_array($fields['title']['instructions'])) {
                                    $title_details["instructions"]["above"] = $fields['title']['instructions'];
                                } else {
                                    if (isset($fields['title']['instructions']['above'])) {
                                        $title_details["instructions"]["above"] = $fields['title']['instructions']['above'];
                                    }
                                    if (isset($fields['title']['instructions']['below'])) {
                                        $title_details["instructions"]["below"] = $fields['title']['instructions']['below'];
                                    }
                                }
                            }

                            if (isset($fields['title']['display'])) {
                                $title_details['display'] = $fields['title']['display'];
                            }
                        }
                        ?>

                        <div class="form-group">
                            <input name="page[yaml][title]" class="text text-large input-lg form-control" data-required="true" tabindex="<?php print tabindex(); ?>" placeholder="<?php echo Localization::fetch('enter_title') ?>" id="publish-title" value="<?php print htmlspecialchars($title); ?>" />

                            <?php if ($title_details['instructions']['below']) : ?>
                                <small><?php echo $title_details['instructions']['below']; ?></small>
                            <?php endif; ?>
                        </div>

                        <?php if ($slug !== '/') : ?>
                            <div class="form-group <?php echo (array_get($fields, 'slug:hide', false) === true) ? 'hidden' : ''; ?>">
                                <label for="publish-slug"><?php echo Localization::fetch('slug') ?></label>
                                <input type="text" id="publish-slug" data-required="true" tabindex="<?php print tabindex(); ?>" class="text <?php echo (isset($new)) ? 'new-slug' : ''; ?>" name="page[meta][slug]" value="<?php print $slug ?>" />
                            </div>
                        <?php else: ?>
                            <input type="hidden" id="publish-slug" tabindex="<?php print tabindex(); ?>" name="page[meta][slug]" value="<?php print $slug ?>" />
                        <?php endif ?>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Additional Fields</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        foreach ($fields as $key => $value):

                            if ($key === 'title' || $key === 'slug')
                                continue;

                            // The default fieldtype is Text.
                            $fieldtype = array_get($value, 'type', 'text');

                            // Value
                            $val = "";
                            if (isset($$key)) {
                                $val = $$key;
                            } elseif (isset($value['default'])) {
                                $val = $value['default'];
                            }

                            # Status is a special system fieldtype
                            if ($fieldtype == 'status' && isset($status)) {
                                $val = $status;
                            }

                            // If no display label is set, we'll prettify the fieldname itself
                            $value['display'] = array_get($value, 'display', Slug::prettify($key));

                            // By default all fields are part of the 'yaml' key. They may need to be overridden
                            // to set a meta/system field, like Content.
                            $input_key = array_get($value, 'input_key', '[yaml]');

                            $wrapper_attributes = array();
                            $wrapper_classes = array(
                                'form-group input-block',
                                'input-' . $fieldtype
                            );

                            if ( array_get($value, 'required', false)  === TRUE) {
                                $wrapper_classes[] = 'required';
                            }

                            if ( array_get($value, 'hide', false)  === TRUE) {
                                $wrapper_classes[] = 'hidden';
                            } ?>

                            <?php if ($value['type'] === 'section') : ?>
                                    </div><!-- / box-body -->
                                </div><!-- / box -->
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title" style="display: block;">
                                            <?php echo $value['display']; ?>

                                            <?php if ($value['instructions']) : ?>
                                                <small><?php echo $value['instructions']; ?></small>
                                            <?php endif; ?>
                                        </h3>
                                    </div>
                                    <div class="box-body">
                            <?php else : ?>
                                <div class="<?php echo implode($wrapper_classes, ' ')?>" <?php echo implode($wrapper_attributes, ' ')?>>
                                    <?php print Fieldtype::render_fieldtype($fieldtype, $key, $value, $val, tabindex(), $input_key);?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Publish Settings</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <?php print Fieldtype::render_fieldtype('status', 'status', array('display' => 'Status'), $status, tabindex());?>
                        </div>

                        <?php if ($type == 'date'): ?>
                            <div class="form-group input-block input-date date required" data-value="<?php print date("Y-m-d", $datestamp) ?>">
                                <label><?php echo Localization::fetch('publish_date') ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control pull-right datepicker" name="page[meta][publish-date]" tabindex="<?php print tabindex(); ?>" type="text" id="publish-date"  value="<?php print date("Y-m-d", $datestamp) ?>" />
                                </div>
                            </div>

                            <?php if (Config::getEntryTimestamps()) : ?>
                                <div class="input-block input-time time required bootstrap-timepicker" data-date="<?php print date("h:i a", $timestamp) ?>" data-date-format="h:i a">
                                    <label><?php echo Localization::fetch('publish_time') ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input name="page[meta][publish-time]" tabindex="<?php print tabindex(); ?>" type="text" id="publish-time" class="form-control pull-right timepicker" value="<?php print date("h:i a", $timestamp) ?>" />
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php elseif ($type == 'number'): ?>
                            <div class="form-group input-block input-text input-number" id="publish-order-number">
                                <label for="publish-order-number"><?php echo Localization::fetch('order_number') ?></label>
                                <input name="page[meta][publish-numeric]" type="text"  tabindex="<?php print tabindex(); ?>" maxlength="4" id="publish-order-number" value="<?php print $numeric; ?>" />
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary" value="Save Changes" id="publish-submit" />
                    </div>
                </div>
            </div>
        </div>

    </form>
</section>


<?php
function tabindex()
{
    static $count = 1;

    return $count++;
}
?>
