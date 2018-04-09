<?php
  $usuario = $this->UserAuth->getUser(); 
  ?>
<!DOCTYPE html>
<!-- 
  Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
  Version: 4.7.1
  Author: KeenThemes
  Website: http://www.keenthemes.com/
  Contact: support@keenthemes.com
  Follow: www.twitter.com/keenthemes
  Dribbble: www.dribbble.com/keenthemes
  Like: www.facebook.com/keenthemes
  Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
  Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
  License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
  -->
<!--[if IE 8]> 
<html lang="en" class="ie8 no-js">
  <![endif]-->
  <!--[if IE 9]> 
  <html lang="en" class="ie9 no-js">
    <![endif]-->
    <!--[if !IE]><!-->
    <html lang="en">
      <!--<![endif]-->
      <!-- BEGIN HEAD -->
      <head>
        <meta charset="utf-8" />
        <title><?=  $this->fetch('title') ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for windows 8 style tiles examples" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <link href="/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="/css/select2-theme.css">
        <link href="/assets/layouts/layout/css/style.css" rel="stylesheet" type="text/css" />

        <link href="/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />

        <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />


        <link href="/assets/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />


        <link href="/assets/layouts/layout/css/style.css" rel="stylesheet" type="text/css" />

        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="/favicon.png" />
      </head>
      <!-- END HEAD -->
      <!-- BEGIN CORE PLUGINS -->
      <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
      <script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
      <script src="/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
      <script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
      <script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
      <script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

      <script src="/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>

      <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

      <script src="//cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.5/bootstrap-notify.min.js"></script>


      <script src="/plugins/tinymce/js/tinymce/tinymce.min.js"></script>

      <script src="/assets/global/plugins/jquery-minicolors/jquery.minicolors.js" type="text/javascript"></script>
      <script>
      tinymce.init({ "theme":"modern","plugins":["advlist autolink lists link image charmap print preview hr anchor pagebreak","searchreplace wordcount visualblocks visualchars code fullscreen","insertdatetime media nonbreaking save table contextmenu directionality","emoticons template paste textcolor"],"toolbar1":"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image","toolbar2":"print preview media | forecolor backcolor emoticons","image_advtab":true,"templates":[{"title":"Test template 1","content":"Test 1"},{"title":"Test template 2","content":"Test 2"}],"language":"en","selector":'.tinymce' });
      </script>
      <!-- END CORE PLUGINS -->
      <?= $this->Html->css('umstyle.css?q='.QRDN); ?>
      <?= $this->Html->script('plugins/chosen/chosen.jquery.js?q='.QRDN) ?>
      <?= $this->Html->script('umscript.js?q='.QRDN); ?>
      <?= $this->Html->script('ajaxValidation.js?q='.QRDN); ?>
      <?= $this->Html->script('chosen.ajaxaddition.jquery.js?q='.QRDN); ?>
      <?= $this->Html->script('/plugins/bootstrap-ajax-typeahead/js/bootstrap-typeahead.min.js?q='.QRDN); ?>
      <?= $this->Html->script('jquery.numeric.js'); ?>
      <script language="javascript">
        var urlForJs="<?php echo SITE_URL ?>";
      </script>
      <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
          <!-- BEGIN HEADER -->
          <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
              <!-- BEGIN LOGO -->
              <div class="left-logo">
                <div class="page-logo">
                  <h1 class="logo-name">BRANDING</h1>
                </div>
                <!-- END LOGO -->
                
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
                </a>
              </div>
              <!-- END RESPONSIVE MENU TOGGLER -->
              <!-- BEGIN TOP NAVIGATION MENU -->
              <div class="top-menu">
                <!-- BEGIN LOGO -->
              
              <!-- END LOGO -->
                <ul class="nav navbar-nav pull-right">
                  <!-- BEGIN NOTIFICATION DROPDOWN -->
                  <!-- END TODO DROPDOWN -->
                  <!-- BEGIN USER LOGIN DROPDOWN -->
                  <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                  <li class="dropdown dropdown-user">
                    <?php if($this->UserAuth->isLogged()){
                      
                      $imageURL = $this->Image->resize('library/'.IMG_DIR, $usuario['User']['photo'], 150, 150, true);

                      echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                          <img alt="" class="img-circle" src="'.$imageURL.'">
                          <span id="name-user" class="username username-hide-on-mobile">'.$usuario['User']['first_name'].' '.$usuario['User']['last_name'].'</span>
                          <i class="fa fa-angle-down"></i>
                      </a>';
                      echo '<ul class="dropdown-menu dropdown-menu-default">';
                      
                      if($this->UserAuth->HP('Users', 'myprofile', 'Usermgmt')) {
                          echo '<li> <a href="/myprofile"><i class="fa fa-user"></i>'; echo __('My Profile'); 
                          echo '</a> </li>';
                      }
                      
                      if($this->UserAuth->HP('Users', 'editProfile', 'Usermgmt')) {
                          echo '<li> <a href="/editProfile"><i class="fa fa-pencil"></i>'; echo __('Edit Profile'); 
                          echo '</a> </li>';
                      }
                      
                      if($this->UserAuth->HP('Users', 'changePassword', 'Usermgmt')){
                      
                          echo '<li> <a href="/usermgmt/users/change-password"><i class="fa fa-key" aria-hidden="true"></i>'; echo __('Change Password'); 
                          echo '</a> </li>';
                          
                      }
                      
                      echo '</ul>';}?>
                  </li>
                  <!-- END USER LOGIN DROPDOWN -->
                  <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                  <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                  <li class="dropdown">
                    <a href="/logout" class="dropdown-toggle">
                    <i class="fa fa-sign-out fa-5 ico-logout"></i>
                    </a>
                  </li>
                  <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
              </div>
              <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
          </div>
          <!-- END HEADER -->
          <!-- BEGIN HEADER & CONTENT DIVIDER -->
          <div class="clearfix"> </div>
          <!-- END HEADER & CONTENT DIVIDER -->
          <!-- BEGIN CONTAINER -->
          <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
              <!-- BEGIN SIDEBAR -->
              <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
              <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
              <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <h2 class="nav-title">Menu Principal</h2>
                <ul class="page-sidebar-menu  page-header-fixed navigation-ul" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                  <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                  <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                  <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler">
                      <span></span>
                    </div>
                  </li>
                  <!-- END SIDEBAR TOGGLER BUTTON -->
                  <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                  <?php
                    if($this->UserAuth->isLogged()) {
                        echo $this->element("navigation");
                    }
                    ?>
                </ul>
                <!-- END SIDEBAR MENU -->
                <!-- END SIDEBAR MENU -->
              </div>
              <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
              <!-- BEGIN CONTENT BODY -->
              <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN THEME PANEL -->
                <div class="theme-panel hidden-xs hidden-sm">
                  <div class="toggler-close"> </div>
                  <div class="theme-options">
                    <div class="theme-option theme-colors clearfix">
                      <span> THEME COLOR </span>
                      <ul>
                        <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
                        <li class="color-darkblue tooltips" data-style="darkblue" data-container="body" data-original-title="Dark Blue"> </li>
                        <li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue"> </li>
                        <li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey"> </li>
                        <li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light"> </li>
                        <li class="color-light2 tooltips" data-style="light2" data-container="body" data-html="true" data-original-title="Light 2"> </li>
                      </ul>
                    </div>
                    <div class="theme-option">
                      <span> Theme Style </span>
                      <select class="layout-style-option form-control input-sm">
                        <option value="square" selected="selected">Square corners</option>
                        <option value="rounded">Rounded corners</option>
                      </select>
                    </div>
                    <div class="theme-option">
                      <span> Layout </span>
                      <select class="layout-option form-control input-sm">
                        <option value="fluid" selected="selected">Fluid</option>
                        <option value="boxed">Boxed</option>
                      </select>
                    </div>
                    <div class="theme-option">
                      <span> Header </span>
                      <select class="page-header-option form-control input-sm">
                        <option value="fixed" selected="selected">Fixed</option>
                        <option value="default">Default</option>
                      </select>
                    </div>
                    <div class="theme-option">
                      <span> Top Menu Dropdown</span>
                      <select class="page-header-top-dropdown-style-option form-control input-sm">
                        <option value="light" selected="selected">Light</option>
                        <option value="dark">Dark</option>
                      </select>
                    </div>
                    <div class="theme-option">
                      <span> Sidebar Mode</span>
                      <select class="sidebar-option form-control input-sm">
                        <option value="fixed">Fixed</option>
                        <option value="default" selected="selected">Default</option>
                      </select>
                    </div>
                    <div class="theme-option">
                      <span> Sidebar Menu </span>
                      <select class="sidebar-menu-option form-control input-sm">
                        <option value="accordion" selected="selected">Accordion</option>
                        <option value="hover">Hover</option>
                      </select>
                    </div>
                    <div class="theme-option">
                      <span> Sidebar Style </span>
                      <select class="sidebar-style-option form-control input-sm">
                        <option value="default" selected="selected">Default</option>
                        <option value="light">Light</option>
                      </select>
                    </div>
                    <div class="theme-option">
                      <span> Sidebar Position </span>
                      <select class="sidebar-pos-option form-control input-sm">
                        <option value="left" selected="selected">Left</option>
                        <option value="right">Right</option>
                      </select>
                    </div>
                    <div class="theme-option">
                      <span> Footer </span>
                      <select class="page-footer-option form-control input-sm">
                        <option value="fixed">Fixed</option>
                        <option value="default" selected="selected">Default</option>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- END THEME PANEL -->
                <!-- BEGIN PAGE BAR -->
                <div class="page-bar">
                  <?=  $this->Html->getCrumbList([
                    'firstClass' => false,
                    'separator' => '<i class="fa fa-circle"></i>',
                    'escape' => false,
                    'lastClass' => 'active',
                    'class' => 'page-breadcrumb'],'Home'); ?>
                  <div class="page-toolbar fecha">
                    <?php 
                      setlocale(LC_ALL,"es_ES");
                      define("CHARSET", "iso-8859-1"); 
                      echo utf8_encode(strftime("%A %d de %B del %Y")); 
                      ?>
                  </div>
                </div>
                <!-- END PAGE BAR -->
                <!-- END PAGE HEADER-->
                <!-- BEGIN CONTENT -->
                <?= $this->element('Usermgmt.message'); ?>
                <h1 class="page-title"> 
                  <?=  $this->fetch('header_title') ?>
                </h1>
                <?= $this->fetch("content") ?>
                <!-- END CONTENT -->
              </div>
              <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="/logout" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
            </a>
            <!-- END QUICK SIDEBAR -->
          </div>
          <!-- END CONTAINER -->
          <!-- BEGIN FOOTER -->
          <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
        <div class="quick-nav-overlay"></div>
        <!-- END QUICK NAV -->
        <!--[if lt IE 9]>
        <script src="/assets/global/plugins/respond.min.js"></script>
        <script src="/assets/global/plugins/excanvas.min.js"></script> 
        <script src="/assets/global/plugins/ie8.fix.min.js"></script> 
        <![endif]-->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="/assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
        <script src="/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
       <script language="javascript">
            window.oLanguage = {
                "sInfo": 'Mostrando resultados del _START_ al _END_ de _TOTAL_.',
                "sInfoEmpty": 'No hay registros para mostrar',
                "sInfoFiltered": "(filtrado de _MAX_ registros)",
                "sSearch": "Buscar:",
                "sSelect": "Limit",
                "sZeroRecords": "No se encontró ningún registro",
                "sPaginate": {
                    "sFirst": "Primero",
                    "sPrevious": "Anterior",
                    "sPnext": "Siguiente",
                    "sLast": "Último"
                }
            };
       </script>
        <script type="text/javascript">
          $(document).ready(function(){
          
              $('.datetimepicker').datetimepicker({
                format: 'dd/mm/yyyy hh:mm:ss'
              });
          
          
              $('.datepicker').datepicker({
                format: 'dd/mm/yyyy'
              });
          
              $('.maxToDay').datepicker({
                format: 'dd/mm/yyyy',
                endDate: new Date()
              });
             
              $('#UsersTable').DataTable( {
                  responsive: true,
                  searching: false,
                  bSort: false,
                  bLengthChange: false,
                  columnDefs: [
                      { responsivePriority: 1, targets: 0 },
                      { responsivePriority: 2, targets: -1 }
                  ], "oLanguage": {
                      "sLengthMenu":     "Mostrar _MENU_ registros",
                      "sInfo": 'Mostrando resultados _START_ al _END_ de _TOTAL_.',
                      "sInfoEmpty": 'No hay registros para mostrar',
                      "sInfoFiltered": "(filtrado de _MAX_ registros)",
                      "sSearch": "Buscar:",
                      "sSelect": "Limit",
                      "sZeroRecords": "No se encontro ningún registro",
                      "sPaginate": {
                          "sFirst": "Primero",
                          "sPrevious": "Anterior",
                          "sPnext": "Siguiente",
                          "sLast": "último"
                      }
                  }
              });
          
          });
          
          
          var FormInputMask = function () {
          
              var handleInputMasks = function () {
                  
                  $(".phone").inputmask("+52 (99) 9999 9999", {
                      placeholder: " ",
                      clearMaskOnLostFocus: true
                  });
                  
                  $(".postal-code").inputmask("99999", {
                      placeholder: " ",
                      clearMaskOnLostFocus: true
                  });  
              }
          
              
          
              return {
                  //main function to initiate the module
                  init: function () {
                      handleInputMasks();
                  }
              };
          
          }();
          
          jQuery(document).ready(function() {
              FormInputMask.init(); // init metronic core componets
          });
          
          
          $(".integer").numeric({decimal: false, negative: false}, function() { this.value = ""; this.focus(); });
          
        </script>
      </body>
    </html>
