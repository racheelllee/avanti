<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?=  $this->Html->css('bootstrap.min.css?q='.QRDN) ?>
     <?=  $this->Html->css('style.css?q='.QRDN) ?>
    <?=  $this->Html->css('font-awesome/css/font-awesome.css?q='.QRDN) ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>


<body class="cloudC" >

    <div class="container">
    <div class="oops">
        
    </div>
  <div id="clouds">
    <div class="cloud1"></div>
    <div class="cloud2"></div>
    <div class="cloud3"></div>
  </div>
  <div id="clouds2">
    <div class="cloud1"></div>
    <div class="cloud2"></div>
    <div class="cloud3"></div>
  </div>
</div>
    <div class="middle-box text-center animated fadeInDown">
       
        <h1><?= $code ?></h1>
        <h3 class="font-bold"> </h3>

        <div class="error-desc">
            

        </div>

        <div class="error-desc">
            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>
            
            
        </div>
    </div>

    <?=  $this->Html->script('jquery-2.1.1.js?q='.QRDN) ?>
    <?=  $this->Html->script('bootstrap.min.js?q='.QRDN) ?>



</body>
</html>
