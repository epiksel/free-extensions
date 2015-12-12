<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-epiksel-summernote" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-epiksel-summernote" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-about" data-toggle="tab"><?php echo $tab_about; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-editor-lang"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_editor_lang; ?>"><?php echo $entry_editor_lang; ?></span></label>
                <div class="col-sm-10">
                  <select name="epiksel_summernote_setting[editor_lang]" id="input-editor-lang" class="form-control">
                    <option value="0"><?php echo $text_select; ?></option>
                    <?php foreach ($editor_langs as $editor_lang) { ?>
                    <?php if ($settings['editor_lang'] && $editor_lang == $settings['editor_lang']) { ?>
                    <option value="<?php echo $editor_lang; ?>" selected="selected"><?php echo $editor_lang; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $editor_lang; ?>"><?php echo $editor_lang; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-editor-direction"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_editor_direction; ?>"><?php echo $entry_editor_direction; ?></span></label>
                <div class="col-sm-10">
                  <select name="epiksel_summernote_setting[editor_direction]" id="input-editor-direction" class="form-control">
                    <?php if ($settings['editor_direction']) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-editor-height"><?php echo $entry_editor_height; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="epiksel_summernote_setting[editor_height]" value="<?php echo isset($settings['editor_height']) ? $settings['editor_height'] : ''; ?>" placeholder="<?php echo $entry_editor_height; ?>" id="input-editor-height" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-codemirror-status"><?php echo $entry_codemirror_status; ?></label>
                <div class="col-sm-10">
                  <select name="epiksel_summernote_setting[codemirror_status]" id="input-codemirror-status" class="form-control">
                    <?php if ($settings['codemirror_status']) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-codemirror-theme"><?php echo $entry_codemirror_theme; ?></label>
                <div class="col-sm-10">
                  <select name="epiksel_summernote_setting[codemirror_theme]" id="input-codemirror-theme" class="form-control">
                    <option value="0"><?php echo $text_select; ?></option>
                    <?php foreach ($codemirror_themes as $codemirror_theme) { ?>
                    <?php if ($settings['codemirror_theme'] && $codemirror_theme == $settings['codemirror_theme']) { ?>
                    <option value="<?php echo $codemirror_theme; ?>" selected="selected"><?php echo $codemirror_theme; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $codemirror_theme; ?>"><?php echo $codemirror_theme; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <div class="help-block"><a href="https://codemirror.net/demo/theme.html" target="_blank"><?php echo $text_theme_demo; ?></a></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-prettify-status"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_prettify_status; ?>"><?php echo $entry_prettify_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="epiksel_summernote_setting[prettify_status]" id="input-prettify-status" class="form-control">
                    <?php if ($settings['prettify_status']) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-prettify-theme"><?php echo $entry_prettify_theme; ?></label>
                <div class="col-sm-10">
                  <select name="epiksel_summernote_setting[prettify_theme]" id="input-prettify-theme" class="form-control">
                    <option value="0"><?php echo $text_select; ?></option>
                    <?php foreach ($prettify_themes as $prettify_theme) { ?>
                    <?php if ($settings['prettify_theme'] && $prettify_theme == $settings['prettify_theme']) { ?>
                    <option value="<?php echo $prettify_theme; ?>" selected="selected"><?php echo $prettify_theme; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $prettify_theme; ?>"><?php echo $prettify_theme; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <div class="help-block"><a href="http://jmblog.github.io/color-themes-for-google-code-prettify/" target="_blank"><?php echo $text_theme_demo; ?></a></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="epiksel_summernote_setting[status]" id="input-status" class="form-control">
                    <?php if ($settings['status']) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-about">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <tbody>
                    <tr>
                      <td><strong><?php echo $text_extension_name; ?></strong></td>
                      <td><?php echo $extension_name; ?></td>
                    </tr>
                    <tr>
                      <td><strong><?php echo $text_extension_uninstall; ?></strong></td>
                      <td><a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $uninstall; ?>' : false;" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> <?php echo $button_uninstall; ?></a></td>
                    </tr>
                    <tr>
                      <td><strong><?php echo $text_extension_version; ?></strong></td>
                      <td><button type="button" class="btn btn-xs btn-default"><?php echo $extension_version; ?></button><?php if ($update_version_check) { ?>&nbsp;&nbsp;<a href="<?php echo $update; ?>" class="btn btn-xs btn-success"><i class="fa fa-refresh"></i> <?php echo $button_update; ?></a><?php } ?>
                      <input type="hidden" name="epiksel_summernote_version" value="<?php echo $extension_version; ?>" /></td>
                    </tr>
                    <tr>
                      <td><strong><?php echo $text_extension_url; ?></strong></td>
                      <td><a href="<?php echo $extension_url; ?>" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> <?php echo $extension_name; ?></a></td>
                    </tr>
                    <tr>
                      <td><strong><?php echo $text_extension_compat; ?></strong></td>
                      <td><?php echo $extension_compat; ?></td>
                    </tr>
                    <tr>
                      <td><strong><?php echo $text_extension_contact; ?></strong></td>
                      <td><?php echo $extension_contact; ?></td>
                    </tr>
                    <tr>
                      <td><strong><?php echo $text_extension_copyright; ?></strong></td>
                      <td><?php echo $extension_copyright; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>