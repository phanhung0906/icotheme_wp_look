<?php 
  $action_addwidget = admin_url('admin-ajax.php?action=pgl_list_shortcodes');
  $action_close = admin_url('admin.php?page=_options&tab=7');
?>
  <div id="wrapper" class="container-main megamenu-pages">
    <div class="header">
      <h1><?php _e('Megamenu configuration','owlshop'); ?></h1>
    </div>
    <div class="pgl-admin-header clearfix">
      <div class="controls-row">
        <div class="btn-toolbar btn-group pull-right" data-toggle="buttons-radio">
          <button type="button" href="#pgl-admin-megamenu" data-toggle="tab" class="btn btn-primary active"><?php _e('Megamenu','owlshop'); ?></button>
          <button type="button" href="#pgl-admin-listwidgets" data-toggle="tab" class="btn btn-primary"><?php _e('Widget Manager','owlshop'); ?></button>
        </div>
        <?php if(count($option_menu)): ?>
        <div class="pull-left menu-select">
          Menu
          <select id="menu-type" name="menu-type">
          <?php
            foreach ($option_menu as $key => $value) {
              echo "<option value=\"{$key}\">{$value}</option>";
            }
          ?>
          </select>
        </div>
        <?php endif; ?>
        <div class="btn-toolbar ">
          <button id="pgl-admin-mm-save" class="btn btn-success"><i class="fa fa-save"></i> <?php _e('Save','owlshop'); ?></button>
          <button id="pgl-admin-mm-delete" class="btn btn-danger"><i class="fa fa-trash"></i> <?php _e('Delete','owlshop'); ?> </button>
          <button id="pgl-admin-mm-close" class="btn"><i class="fa fa-remove"></i>  <?php _e('Close','owlshop'); ?></button>
        </div>
      </div>
    <div class="pgl-progress" style="width: 59%;"></div></div>
    <div class="tab-content">
      <div id="pgl-admin-listwidgets" class="tab-pane">
        <div class="text-center">
          <button href="<?php echo esc_url( $action_addwidget ); ?>" id="btn-add-widget" class="btn btn-success btn-action"><i class="fa fa-plus"></i> <?php _e('Add Widget','owlshop'); ?></button>
        </div>
        <table class="form table table-striped">
          <tr>
            <th><?php _e('Wiget Name','owlshop'); ?></th>
            <th><?php _e('Type','owlshop'); ?></th>
            <th><?php _e('Action','owlshop'); ?></th>
          </tr>
          <?php if( is_array($widgets) ) { ?>

          <?php foreach( $widgets  as $widget ) { ?>
              <tr data-widget-id="<?php echo esc_attr($widget->id); ?>">
                <td class="name"><?php echo esc_html($widget->name); ?></td>
                <td class="type"><?php echo esc_attr( $widget->type ); ?></td>
                <td>
                  <a class="pgl-edit-widget" rel="edit" data-type="<?php echo esc_attr( $widget->type ); ?>" data-id='<?php echo esc_attr( $widget->id ); ?>' href="#" ><?php _e('Edit','owlshop'); ?></a>
                  |
                  <a rel="delete" class="pgl-delete" data-message="<?php _e('Are You Sure ?','owlshop'); ?>" data-id='<?php echo esc_attr( $widget->id ); ?>' href="#"><?php _e('Delete','owlshop'); ?></a>
                </td>
              <?php } ?>
              </tr>
          <?php } ?>
        </table>
      </div>
      <div id="pgl-admin-megamenu" class="pgl-admin-megamenu pgl-admin-form tab-pane active">
        <div class="admin-inline-toolbox clearfix">
          <div class="pgl-admin-mm-row clearfix">

            <div id="pgl-admin-mm-intro" class="pull-left">
              <h3><?php _e('Megamenu Toolbox','owlshop'); ?></h3>
              <p><?php _e('This toolbox includes all settings of megamenu, just select menu then configure. There are 3 level of configuration: sub-megamenu setting, column setting and menu item setting.','owlshop'); ?></p>
            </div>

            <div id="pgl-admin-mm-tb">
              <div id="pgl-admin-mm-toolitem" class="admin-toolbox" style="display: none;">
                <h3><?php _e('Item Configuration','owlshop'); ?></h3>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Submenu','owlshop'); ?></label>
                    <fieldset class="radio toolitem-sub pglonoff">
                      <input type="radio" id="toggleSub0" class="toolbox-toggle" data-action="toggleSub" name="toggleSub" value="0">
                      <label for="toggleSub0" class="off"><?php _e('No','owlshop'); ?></label>
                      <input type="radio" id="toggleSub1" class="toolbox-toggle" data-action="toggleSub" name="toggleSub" value="1" checked="checked">
                      <label for="toggleSub1" class="on active"><?php _e('Yes','owlshop'); ?></label>
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Group','owlshop'); ?></label>
                    <fieldset class="radio toolitem-group pglonoff">
                      <input type="radio" id="toggleGroup0" class="toolbox-toggle" data-action="toggleGroup" name="toggleGroup" value="0">
                      <label for="toggleGroup0" class="off"><?php _e('No','owlshop'); ?></label>
                      <input type="radio" id="toggleGroup1" class="toolbox-toggle" data-action="toggleGroup" name="toggleGroup" value="1" checked="checked">
                      <label for="toggleGroup1" class="on active"><?php _e('Yes','owlshop'); ?></label>
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Positions','owlshop'); ?></label>
                    <fieldset class="btn-group">
                      <a href="" class="btn toolitem-moveleft toolbox-action" data-action="moveItemsLeft" title="Move to Left Column"><i class="fa fa-arrow-left"></i></a>
                      <a href="" class="btn toolitem-moveright toolbox-action" data-action="moveItemsRight" title="Move to Right Column"><i class="fa fa-arrow-right"></i></a>
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Extra Class','owlshop'); ?></label>
                    <fieldset class="">
                      <input type="text" class="input-medium toolitem-exclass toolbox-input" name="toolitem-exclass" data-name="class" value="">
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" data-placement="right" title="">
                      <a href="<?php echo esc_url( 'http://fortawesome.github.io/Font-Awesome/icons' ); ?>" target="_blank"><i class="fa fa-search"></i><?php _e('Icon','owlshop'); ?></a>
                    </label>
                    <fieldset class="">
                      <input type="text" class="input-medium toolitem-xicon toolbox-input" name="toolitem-xicon" data-name="xicon" value="">
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" title="">
                      <?php _e('Item caption','owlshop'); ?></label>
                    <fieldset class="">
                      <input type="text" class="input-large toolitem-caption toolbox-input" name="toolitem-caption" data-name="caption" value="">
                    </fieldset>
                  </li>
                </ul>
              </div>

              <div id="pgl-admin-mm-toolsub" class="admin-toolbox" style="display: none;">
                <h3><?php _e('Submenu Configuration','owlshop'); ?></h3>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Add row','owlshop'); ?></label>
                    <fieldset class="btn-group">
                      <a href="" class="btn toolsub-addrow toolbox-action" data-action="addRow"><i class="fa fa-plus"></i></a>
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" title="" ><?php _e('Hide when collapse','owlshop'); ?></label>
                    <fieldset class="radio toolsub-hidewhencollapse pglonoff">
                      <input type="radio" id="togglesubHideWhenCollapse0" class="toolbox-toggle" data-action="hideWhenCollapse" name="togglesubHideWhenCollapse" value="0" checked="checked">
                      <label for="togglesubHideWhenCollapse0" class="off active">No</label>
                      <input type="radio" id="togglesubHideWhenCollapse1" class="toolbox-toggle" data-action="hideWhenCollapse" name="togglesubHideWhenCollapse" value="1">
                      <label for="togglesubHideWhenCollapse1" class="on">Yes</label>
                    </fieldset>
                  </li>
                </ul>                    
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Submenu Width (px)','owlshop'); ?></label>
                    <fieldset class="">
                      <input type="text" class="toolsub-width toolbox-input input-small" name="toolsub-width" data-name="width" value="">
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Alignment','owlshop'); ?></label>
                    <fieldset class="toolsub-alignment">
                      <div class="btn-group">
                        <a class="btn toolsub-align-left toolbox-action" href="#" data-action="alignment" data-align="left" title="Left"><i class="fa fa-align-left"></i></a>
                        <a class="btn toolsub-align-right toolbox-action" href="#" data-action="alignment" data-align="right" title="Right"><i class="fa fa-align-right"></i></a>
                        <a class="btn toolsub-align-center toolbox-action" href="#" data-action="alignment" data-align="center" title="Center"><i class="fa fa-align-center"></i></a>
                        <a class="btn toolsub-align-justify toolbox-action" href="#" data-action="alignment" data-align="justify" title="Justify"><i class="fa fa-align-justify"></i></a>
                      </div>
                    </fieldset>
                  </li>
                </ul>          
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Extra Class','owlshop'); ?></label>
                    <fieldset class="">
                      <input type="text" class="toolsub-exclass toolbox-input input-medium" name="toolsub-exclass" data-name="class" value="">
                    </fieldset>
                  </li>
                </ul>
              </div>

              <div id="pgl-admin-mm-toolcol" class="admin-toolbox" style="display: none;">
                <h3><?php _e('Column Configuration','owlshop'); ?></h3>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Add/remove Column','owlshop'); ?></label>
                    <fieldset class="btn-group">
                      <a href="" class="btn toolcol-addcol toolbox-action" data-action="addColumn"><i class="fa fa-plus"></i></a>
                      <a href="" class="btn toolcol-removecol toolbox-action" data-action="removeColumn"><i class="fa fa-minus"></i></a>
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Hide when collapse','owlshop'); ?></label>
                    <fieldset class="radio toolcol-hidewhencollapse pglonoff">
                      <input type="radio" id="toggleHideWhenCollapse0" class="toolbox-toggle" data-action="hideWhenCollapse" name="toggleHideWhenCollapse" value="0" checked="checked">
                      <label for="toggleHideWhenCollapse0" class="off active">No</label>
                      <input type="radio" id="toggleHideWhenCollapse1" class="toolbox-toggle" data-action="hideWhenCollapse" name="toggleHideWhenCollapse" value="1">
                      <label for="toggleHideWhenCollapse1" class="on">Yes</label>
                    </fieldset>
                  </li>
                </ul>          
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Width (1-12)','owlshop'); ?></label>
                    <fieldset class="">
                      <select class="toolcol-width toolbox-input toolbox-select input-mini" name="toolcol-width" data-name="width">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      </select>
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Widget','owlshop'); ?></label>
                    <fieldset class="list-widgets">
                      <select class="toolcol-position toolbox-input toolbox-select" id="pgl-list-widgets" name="toolcol-position" data-name="position" data-placeholder="Select Widget" >
                        <option value=""></option>
                        <?php foreach( $widgets as $w ) { ?>
                        <option value="<?php echo esc_attr( $w->id ); ?>"><?php echo esc_html($w->name); ?></option>
                        <?php } ?>
                      </select>
                    </fieldset>
                  </li>
                </ul>
                <ul>
                  <li>
                    <label class="hasTip" title=""><?php _e('Extra Class','owlshop'); ?></label>
                    <fieldset class="">
                      <input type="text" class="input-medium toolcol-exclass toolbox-input" name="toolcol-exclass" data-name="class" value="">
                    </fieldset>
                  </li>
                </ul>
              </div>    
            </div> 

            <div class="toolbox-actions-group hidden">
              <button class="pgl-admin-tog-fullscreen toolbox-action toolbox-togglescreen" data-action="toggleScreen" data-iconfull="fa fa-resize-full" data-iconsmall="fa fa-resize-small"><i class="fa fa-resize-full"></i></button>
              <button class="btn btn-success toolbox-action toolbox-saveConfig hide" data-action="saveConfig"><i class="fa fa-save"></i>  Save</button>
              <!--button class="btn btn-danger toolbox-action toolbox-resetConfig"><i class="fa fa-undo"></i>Reset</button-->
            </div>

          </div>
        </div>
        <!-- Menu Editor -->
        <div id="pgl-admin-mm-container" class="navbar clearfix"><div class="pgl-megamenu" data-responsive="true"></div></div>

        <div class="ajaxloader">
          <h5><?php _e('Loading Menu...','owlshop'); ?></h5>
        </div>
      </div>
    </div>

    <div id="ajax-message" class="ajax-message alert">
      <button type="button" class="close">x</button>
      <strong>Save success full</strong>
    </div>
    <!-- MODAL DIALOG -->
    <div id="pgl-admin-megamenu-dlg" class="modal fade hide">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h3>Megamenu</h3>
          </div>
          <div class="modal-body">
            <div class="message-block">
              <p class="msg"><?php _e('Are you sure you want to delete configuration?','owlshop'); ?></p>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn cancel" data-dismiss="modal"><?php _e('Cancel','owlshop'); ?></button>
            <button class="btn btn-danger yes"><?php _e('Delete','owlshop'); ?></button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Widget -->
    <div class="modal fade" id="modal-widgets">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php _e( 'Widget Management','owlshop' ); ?></h4>
          </div>
          <div class="modal-body">
            <span class="spinner top" style="display:block;float:none;"></span>
            <div class="pgl-widget-message"></div>
            <div class="modal-body-inner"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','owlshop'); ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    //<![CDATA[

    PGLAdminMegamenu = window.PGLAdminMegamenu || {};
    PGLAdminMegamenu.referer = '<?php echo esc_url( $action_close ); ?>';
    PGLAdminMegamenu.site = '<?php echo esc_url( home_url( '/' ) ); ?>';
    PGLAdminMegamenu.config = <?php echo get_option( 'PGL_MEGAMENU_DATA','{}' ); ?>;

    //]]>
  </script>