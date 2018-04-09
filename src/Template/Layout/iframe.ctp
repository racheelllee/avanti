<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $this->fetch('title') ?></title>

    <script language="javascript">
        var urlForJs="<?php echo SITE_URL ?>";
    </script>
    <!-- Mainly scripts -->
    <script src="/js/jquery-2.1.1.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <?php
        echo $this->Html->meta('icon');
        /* Bootstrap CSS */
        echo $this->Html->css('/plugins/bootstrap/css/bootstrap.min.css?q='.QRDN);
        
        /* Usermgmt Plugin CSS */
        echo $this->Html->css('/usermgmt/css/umstyle.css?q='.QRDN);
        
        /* Bootstrap Datepicker is taken from https://github.com/eternicode/bootstrap-datepicker */
        echo $this->Html->css('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css?q='.QRDN);

        /* Bootstrap Datepicker is taken from https://github.com/smalot/bootstrap-datetimepicker */
        echo $this->Html->css('/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css?q='.QRDN);
        
        /* Chosen is taken from https://github.com/harvesthq/chosen/releases/ */
        echo $this->Html->css('/plugins/chosen/chosen.min.css?q='.QRDN);

        /* Jquery latest version taken from http://jquery.com */
        //echo $this->Html->script('/plugins/jquery-1.11.2.min.js');
        
        /* Bootstrap JS */
        //echo $this->Html->script('/plugins/bootstrap/js/bootstrap.min.js?q='.QRDN);
        /* Bootstrap Datepicker is taken from https://github.com/eternicode/bootstrap-datepicker */
        echo $this->Html->script('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js?q='.QRDN);
        /* Bootstrap Datepicker is taken from https://github.com/smalot/bootstrap-datetimepicker */
        echo $this->Html->script('/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js?q='.QRDN);
        /* Bootstrap Typeahead is taken from https://github.com/biggora/bootstrap-ajax-typeahead */
        echo $this->Html->script('/plugins/bootstrap-ajax-typeahead/js/bootstrap-typeahead.min.js?q='.QRDN);
        /* Chosen is taken from https://github.com/harvesthq/chosen/releases/ */
        echo $this->Html->script('/plugins/chosen/chosen.jquery.min.js?q='.QRDN);
        /* Usermgmt Plugin JS */
        echo $this->Html->script('/usermgmt/js/umscript.js?q='.QRDN);
        echo $this->Html->script('/usermgmt/js/ajaxValidation.js?q='.QRDN);

        echo $this->Html->script('/usermgmt/js/chosen/chosen.ajaxaddition.jquery.js?q='.QRDN);

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>

    <link href="/assets/layouts/layout/css/style.css" rel="stylesheet" type="text/css" />
    <!-- <link href="/font-awesome/css/font-awesome.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.6/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/font-awesome/dataTables.fontAwesome.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/1.0.6/css/dataTables.responsive.css">
    <!-- Related to dataTables -->
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/chosen.min.css" rel="stylesheet">

    <link href="/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <!-- Local style only for demo purpose -->
    <style>
        .directive-list {
            list-style: none;
        }
        .directive-list li {
            background: #f3f3f4;
            padding: 10px 20px;
            margin: 4px;
        }
    </style>
        
    <!-- Custom and plugin javascript -->
    <script src="/js/inspinia.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>
    <!-- script src="/js/plugins/pace/pace.min.js"></script -->
    <script src="/js/helper.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
      <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/responsive/1.0.6/js/dataTables.responsive.js
"></script>
    <script type="text/javascript" src="/js/typeahead.bundle.js"></script>

    <script src="/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.5/bootstrap-notify.min.js"></script>

</head>

<body style=" background-color: rgba(0,0,0,0);">
        <div id="wrapper">

        <div class="wrapper wrapper-content animated fadeInRight">
            <!-- Contenido -->
            <?php echo $this->element('Usermgmt.message'); ?>
            <?php //echo $this->fetch('tb_flash') ?>
            <?php echo $this->fetch('content'); ?>
            <!-- Contenido -->
        </div>

</div>


</body>


</html>
