<section class="content-header">
    <h1>
        <?php echo $status_message; ?> <?php echo $full_name; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $app->urlFor("dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $app->urlFor("members"); ?>"><?php echo ucwords(Localization::fetch('members')); ?></a></li>
        <li class="active"><?php echo $full_name; ?></li>
    </ol>
</section>

<?php $_errors = (!isset($_errors) || !is_array($_errors)) ? array() : $_errors; ?>

<section class="content">
    <form method="post" action="member?name=<?php print $original_name ?>" data-validate="parsley" class="primary-form" autocomplete="off">
        <input type="hidden" name="member[original_name]" value="<?php print $original_name ?>" />

        <?php if (isset($new)): ?>
            <input type="hidden" name="member[new]" value="1" />
        <?php endif ?>

        <?php if (isset($_errors) && (sizeof($_errors) > 0)): ?>
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

        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Profile</h3>
                    </div>
                    <div class="box-body">
                        <?php foreach ($fields['fields'] as $key => $value): ?>
                            <?php
                                $fieldtype = array_get($value, 'type', 'text');
                                $error = array_get($_errors, $key, null);

                                // Value
                                $val = "";
                                if (isset($$key)) {
                                    $val = $$key;
                                } elseif (isset($value['default'])) {
                                    $val = $value['default'];
                                }

                                // If no display label is set, we'll prettify the fieldname itself
                                $value['display'] = array_get($value, 'display', Slug::prettify($key));

                                // By default all fields are part of the 'yaml' key. They may need to be overridden
                                // to set a meta/system field, like Content.
                                $input_key = array_get($value, 'input_key', '[yaml]');

                                $wrapper_attributes = array();
                                $wrapper_classes = array(
                                    'form-group',
                                    'input-' . $fieldtype
                                );

                                if (array_get($value, 'required', false) === TRUE) {
                                    $wrapper_classes[] = 'required';
                                    $wrapper_attributes[] = 'required';
                                }
                            ?>

                            <?php if ($key === 'first_name') : ?>
                                <div class="form-group">
                                    <label>
                                        <?php echo $value['display']; ?>
                                    </label>
                                    <?php if ($value['instructions']) : ?>
                                        <small><?php echo $value['instructions']; ?></small>
                                    <?php endif; ?>
                                    <input <?php echo ($value['required'] ? 'required' : ''); ?> type="text" class="form-control" name="<?php echo 'page' . $input_key . '[' . $key . ']'; ?>" value="<?php echo $val; ?>" tabindex="<?php echo tabindex(); ?>" />
                                </div>
                            <?php elseif ($key === 'last_name') : ?>
                                <div class="form-group">
                                    <label>
                                        <?php echo $value['display']; ?>
                                    </label>
                                    <?php if ($value['instructions']) : ?>
                                        <small><?php echo $value['instructions']; ?></small>
                                    <?php endif; ?>
                                    <input <?php echo ($value['required'] ? 'required' : ''); ?> type="text" class="form-control" name="<?php echo 'page' . $input_key . '[' . $key . ']'; ?>" value="<?php echo $val; ?>" tabindex="<?php echo tabindex(); ?>" />
                                </div>
                            <?php elseif ($key === 'username') : ?>
                                <div class="form-group">
                                    <label>
                                        <?php echo $value['display']; ?>
                                    </label>
                                    <?php if ($value['instructions']) : ?>
                                        <small><?php echo $value['instructions']; ?></small>
                                    <?php endif; ?>
                                    <input <?php echo ($value['required'] ? 'required' : ''); ?> type="text" class="form-control" name="<?php echo 'page' . $input_key . '[' . $key . ']'; ?>" value="<?php echo $val; ?>" tabindex="<?php echo tabindex(); ?>" />
                                </div>
                            <?php elseif ($key === 'email') : ?>
                                <div class="form-group">
                                    <label>
                                        <?php echo $value['display']; ?>
                                    </label>
                                    <?php if ($value['instructions']) : ?>
                                        <small><?php echo $value['instructions']; ?></small>
                                    <?php endif; ?>
                                    <input <?php echo ($value['required'] ? 'required' : ''); ?> type="email" class="form-control" name="<?php echo 'page' . $input_key . '[' . $key . ']'; ?>" value="<?php echo $val; ?>" tabindex="<?php echo tabindex(); ?>" />
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="box-footer">
                        <input class="btn btn-primary" type="submit" value="Save Changes" />
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Additional Fields</h3>
                    </div>
                    <div class="box-body">
                        <?php foreach ($fields['fields'] as $key => $value): ?>
                            <?php
                            $fieldtype = array_get($value, 'type', 'text');
                            $error = array_get($_errors, $key, null);

                            // Value
                            $val = "";
                            if (isset($$key)) {
                                $val = $$key;
                            } elseif (isset($value['default'])) {
                                $val = $value['default'];
                            }

                            // If no display label is set, we'll prettify the fieldname itself
                            $value['display'] = array_get($value, 'display', Slug::prettify($key));

                            // By default all fields are part of the 'yaml' key. They may need to be overridden
                            // to set a meta/system field, like Content.
                            $input_key = array_get($value, 'input_key', '[yaml]');

                            $wrapper_attributes = array();
                            $wrapper_classes = array(
                                'form-group',
                                'input-' . $fieldtype
                            );

                            if (array_get($value, 'required', false) === TRUE) {
                                $wrapper_classes[] = 'required';
                                $wrapper_attributes[] = 'required';
                            }
                            ?>

                            <?php if (!($key === 'first_name' || $key === 'last_name' || $key === 'username' || $key === 'email' || $key === 'password' || $key === 'password_confirmation' || $key === 'show_password')) : ?>
                                <div class="<?php echo implode($wrapper_classes, ' ')?>" <?php echo implode($wrapper_attributes, ' ')?>>
                                    <?php
                                    print Fieldtype::render_fieldtype($fieldtype, $key, $value, $val, tabindex(), $input_key, null, $error);
                                    ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="box-footer">
                        <input class="btn btn-primary" type="submit" value="Save Changes" />
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Change Password</h3>
                    </div>
                    <div class="box-body">
                        <?php foreach ($fields['fields'] as $key => $value): ?>
                            <?php
                            $fieldtype = array_get($value, 'type', 'text');
                            $error = array_get($_errors, $key, null);

                            // Value
                            $val = "";
                            if (isset($$key)) {
                                $val = $$key;
                            } elseif (isset($value['default'])) {
                                $val = $value['default'];
                            }

                            // If no display label is set, we'll prettify the fieldname itself
                            $value['display'] = array_get($value, 'display', Slug::prettify($key));

                            // By default all fields are part of the 'yaml' key. They may need to be overridden
                            // to set a meta/system field, like Content.
                            $input_key = array_get($value, 'input_key', '[yaml]');

                            $wrapper_attributes = array();
                            $wrapper_classes = array(
                                'form-group',
                                'input-' . $fieldtype
                            );

                            if (array_get($value, 'required', false) === TRUE) {
                                $wrapper_classes[] = 'required';
                                $wrapper_attributes[] = 'required';
                            }
                            ?>

                            <?php if ($key === 'password' || $key === 'password_confirmation') : ?>
                                <div class="<?php echo implode($wrapper_classes, ' ')?>" <?php echo implode($wrapper_attributes, ' ')?>>
                                    <?php
                                    print Fieldtype::render_fieldtype($fieldtype, $key, $value, $val, tabindex(), $input_key, null, $error);
                                    ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="box-footer">
                        <input class="btn btn-primary" type="submit" value="Save Changes" />
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