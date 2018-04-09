Last Modification of this file is 16-Nov-2015

UserMgmt is a User Management Plugin for cakephp 3.x
Plugin Premium version 3.1.1 (stable)
with Twitter Bootstrap 3.x

Website- http://ektanjali.com
Plugin Demo and It's features- http://cakephp3-user-management.ektanjali.com/

For Documentations go to http://developers.ektanjali.com/docs/umpremium/version3.1/index.html

For Social Application check out our blog http://blog.ektanjali.com/

INSTALLATION
------------
Install cakephp 3.x if you have not installed yet. For cakephp 3.x installation please go to http://book.cakephp.org/3.0/en/installation.html

1. Download the	latest version of plugin from http://cakephp3-user-management.ektanjali.com/
	go to yourapp/plugins
	extract	here
	name it	Usermgmt


2. Schema import (use your favorite sql	tool to	import the schema)

	yourapp/plugins/Usermgmt/config/Schema/usermgmt-3.1.sql


3. Configure your AppController	class
	
	you can download the app controller from http://www.ektanjali.com/products/downloadAppController/umpremium3.1
	
	or you can write manual code as following

	Your yourapp/src/Controller/AppController.php should look like this:

<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller {

	public $components = ['Flash', 'Auth', 'Usermgmt.UserAuth'/*, 'Security', 'Csrf'*/];
	public $helpers = ['Usermgmt.UserAuth', 'Usermgmt.Image', 'Form'];
	
	/* Override functions */
	public function paginate($object = null) {
		$sessionKey = sprintf('UserAuth.Search.%s.%s', $this->request['controller'], $this->request['action']);
		if($this->request->session()->check($sessionKey)) {
			$persistedData = $this->request->session()->read($sessionKey);
			if(!empty($persistedData['page_limit'])) {
				$this->paginate['limit'] = $persistedData['page_limit'];
			}
		}
		return parent::paginate($object);
	}

	public function beforeRender(Event $event) {
		if(!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json', 'application/xml'])) {
			$this->set('_serialize', true);
		}
	}
}
?>

(Optional)
This plugin is CSRF protection enabled and If you want to use CSRF in rest Application just uncomment Security and CSRF component for ex. $components in Your yourapp/src/Controller/AppController.php should look like this:
public $components = ['Flash', 'Auth', 'Usermgmt.UserAuth', 'Security', 'Csrf'];


4. Enable Plugin in your bootstrap.php

	yourapp/config/bootstrap.php should include this line

	// load user management plugin
	Plugin::load('Usermgmt', ['autoload' => true, 'bootstrap' => true, 'routes' => true]);


5. Create a folder "plugins" without quotes in yourapp/webroot
Directory structure should look like
yourapp/webroot/plugins


You can skip steps 6 to 14 by downloading the zip file from here http://www.ektanjali.com/products/downloadExternalPlugins/umpremium3.1/bootstrap3
extract zip into yourapp/webroot/plugins
Directory structure should look like
yourapp/webroot/plugins/bootstrap
-----------------------/bootstrap-datepicker
-----------------------/bootstrap-datetimepicker	etc
now go to step 15


or you can download one by one as follows

6. Download twitter bootstrap framework from http://getbootstrap.com/getting-started/#download (at this time latest version is 3.3.5)
You will see 3 download buttons "Download Bootstrap", "Download Source", "Download Sass"
You should download bootstrap framework from "Download Bootstrap" button.
extract this yourapp/webroot/plugins and name it bootstrap

Directory structure should look like
yourapp/webroot/plugins/bootstrap/css
----------------------------- /js
----------------------------- /fonts


7. Download bootstrap datepicker zip file from https://github.com/eternicode/bootstrap-datepicker
extract this yourapp/webroot/plugins and name it bootstrap-datepicker

Directory structure should look like
yourapp/webroot/plugins/bootstrap-datepicker/build
------------------------------------------- /dist
------------------------------------------- /less		etc


8. Download bootstrap datepicker zip file from https://github.com/smalot/bootstrap-datetimepicker
extract this yourapp/webroot/plugins and name it bootstrap-datetimepicker

Directory structure should look like
yourapp/webroot/plugins/bootstrap-datetimepicker/build
----------------------------------------------- /css
----------------------------------------------- /js		etc


9. Download bootstrap chosen (chosen_v1.4.2.zip at this time latest version is 1.4.2) file from https://github.com/harvesthq/chosen/releases/
extract this yourapp/webroot/plugins and name it chosen

Directory structure should look like
yourapp/webroot/plugins/chosen/chosen.css
----------------------------- /chosen.jquery.min.js		etc


10. Download bootstrap typeahead zip file from https://github.com/biggora/bootstrap-ajax-typeahead
extract this yourapp/webroot/plugins and name it bootstrap-ajax-typeahead

Directory structure should look like
yourapp/webroot/plugins/bootstrap-ajax-typeahead/demo
----------------------------------------------- /js		etc


11. Download the tinymce editor from http://www.tinymce.com/download/download.php (at this time latest version is TinyMCE 4.2.8)
You will see 3 download button "TinyMCE 4.2.8", "TinyMCE 4.2.8 jQuery package", "TinyMCE 4.2.8 development package"
You should download it by "TinyMCE 4.2.8" button
extract this yourapp/webroot/plugins and name it tinymce

Directory structure should look like
yourapp/webroot/plugins/tinymce/js/tinymce/tinymce.min.js
----------------------------------------- /plugins
----------------------------------------- /langs	etc


12. Download the ckeditor (full package) editor from http://ckeditor.com/download (at this time latest version is ckeditor 4.5.8)
Make sure you have downloaded full package
extract this yourapp/webroot/plugins and name it ckeditor
Directory structure should look like
yourapp/webroot/plugins/ckeditor/ckeditor.js
------------------------------- /plugins
------------------------------- /lang	etc

13. Download the jquery from http://jquery.com (at this time latest version is 1.11.3)
Please note I am using jquery-1.11.3.min.js in default layout if you download other jquery version then do not forget to change in default layout.
Directory structure should look like
yourapp/webroot/js/jquery-1.11.3.min.js

14. Download Toastr zip file from https://github.com/CodeSeven/toastr
extract this yourapp/webroot/plugins and name it toastr

Directory structure should look like
yourapp/webroot/plugins/toastr/build
----------------------------- /jtoastr.js		etc


15. Add all plugin, bootstrap and other css and js files in head of your layout file, for example yourapp/src/Template/Layout/default.php
	
you can download the default layout from http://www.ektanjali.com/products/downloadLayout/umpremium3.1/bootstrap3
	
or you can write manual code as following

Your yourapp/src/Template/Layout/default.php should look like this:

<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $this->fetch('title');?> Cakephp 3.x User Management Premium Plugin with Twitter Bootstrap | Ektanjali Softwares</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script language="javascript">
		var urlForJs="<?php echo SITE_URL ?>";
	</script>
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

		/* Toastr is taken from https://github.com/CodeSeven/toastr */
		echo $this->Html->css('/plugins/toastr/build/toastr.min.css?q='.QRDN);

		/* Jquery latest version taken from http://jquery.com */
		echo $this->Html->script('/plugins/jquery-1.11.3.min.js');
		
		/* Bootstrap JS */
		echo $this->Html->script('/plugins/bootstrap/js/bootstrap.min.js?q='.QRDN);

		/* Bootstrap Datepicker is taken from https://github.com/eternicode/bootstrap-datepicker */
		echo $this->Html->script('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js?q='.QRDN);

		/* Bootstrap Datepicker is taken from https://github.com/smalot/bootstrap-datetimepicker */
		echo $this->Html->script('/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js?q='.QRDN);
		
		/* Bootstrap Typeahead is taken from https://github.com/biggora/bootstrap-ajax-typeahead */
		echo $this->Html->script('/plugins/bootstrap-ajax-typeahead/js/bootstrap-typeahead.min.js?q='.QRDN);
		
		/* Chosen is taken from https://github.com/harvesthq/chosen/releases/ */
		echo $this->Html->script('/plugins/chosen/chosen.jquery.min.js?q='.QRDN);

		/* Toastr is taken from https://github.com/CodeSeven/toastr */
		echo $this->Html->script('/plugins/toastr/build/toastr.min.js?q='.QRDN);

		/* Usermgmt Plugin JS */
		echo $this->Html->script('/usermgmt/js/umscript.js?q='.QRDN);
		echo $this->Html->script('/usermgmt/js/ajaxValidation.js?q='.QRDN);

		echo $this->Html->script('/usermgmt/js/chosen/chosen.ajaxaddition.jquery.js?q='.QRDN);

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container">
		<div class="content">
			<?php if($this->UserAuth->isLogged()) { echo $this->element('Usermgmt.dashboard'); } ?>
			<?php echo $this->element('Usermgmt.message_notification'); ?>
			<?php echo $this->fetch('content'); ?>
			<div style="clear:both"></div>
		</div>
	</div>
	<div id="footer">
		<div class="container">
			<p class="muted">Copyright &copy; <?php echo date('Y');?> Your Site. All Rights Reserved. <a href="http://www.ektanjali.com/" target='_blank'>Developed By</a>.</p>
		</div>
    </div>
</body>
</html>


All set??

Go to yourdomain/login
Default	user name password
username- admin
password- 123456

ALL DONE ! Sorry for too many steps!!