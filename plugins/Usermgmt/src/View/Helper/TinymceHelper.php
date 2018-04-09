<?php
/* Cakephp 3.x User Management Premium Version (a product of Ektanjali Softwares Pvt Ltd)
Website- http://ektanjali.com
Plugin Demo- http://cakephp3-user-management.ektanjali.com/
Author- Chetan Varshney (The Director of Ektanjali Softwares Pvt Ltd)
Plugin Copyright No- 11498/2012-CO/L

UMPremium is a copyrighted work of authorship. Chetan Varshney retains ownership of the product and any copies of it, regardless of the form in which the copies may exist. This license is not a sale of the original product or any copies.

By installing and using UMPremium on your server, you agree to the following terms and conditions. Such agreement is either on your own behalf or on behalf of any corporate entity which employs you or which you represent ('Corporate Licensee'). In this Agreement, 'you' includes both the reader and any Corporate Licensee and Chetan Varshney.

The Product is licensed only to you. You may not rent, lease, sublicense, sell, assign, pledge, transfer or otherwise dispose of the Product in any form, on a temporary or permanent basis, without the prior written consent of Chetan Varshney.

The Product source code may be altered (at your risk)

All Product copyright notices within the scripts must remain unchanged (and visible).

If any of the terms of this Agreement are violated, Chetan Varshney reserves the right to action against you.

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Product.

THE PRODUCT IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE PRODUCT OR THE USE OR OTHER DEALINGS IN THE PRODUCT. */
?>
<?php
namespace Usermgmt\View\Helper;
use Cake\View\Helper;
use Cake\View\View;

class TinymceHelper extends Helper {
	public $helpers = ['Html', 'Form'];
	public $_script = false;

	/**
	* Adds the tinymce.min.js file and constructs the options
	*
	* @param string $fieldName Name of a field, like this "Modelname.fieldname"
	* @param array $tinyoptions Array of TinyMCE attributes for this textarea
	* @return string JavaScript code to initialise the TinyMCE area
	*/
	public function _build($textAreaId, $tinyoptions=array()) {
		if(!$this->_script) {
			// We don't want to add this every time, it's only needed once
			$this->_script = true;
			$this->Html->script('/plugins/tinymce/js/tinymce/tinymce.min.js', array('block'=>true));
		}
		$tinyoptions['selector'] = '#'.$textAreaId;
		$this->Html->scriptStart(array('block'=>true));
		echo 'tinyMCE.init('.json_encode($tinyoptions).');';
		$this->Html->scriptEnd();
	}

	/**
	* Creates a TinyMCE textarea.
	*
	* @param string $fieldName Name of a field, like this "Modelname.fieldname"
	* @param array $options Array of HTML attributes.
	* @param array $tinyoptions Array of TinyMCE attributes for this textarea
	* @param string $preset
	* @return string An HTML textarea element with TinyMCE
	*/
	public function textarea($fieldName, $options=array(), $tinyoptions=array(), $preset=null) {
		$options['type'] = 'textarea';
		if(!empty($preset)) {
			$preset_options = $this->preset($preset);
			if(is_array($preset_options) && is_array($tinyoptions)) {
				$tinyoptions = array_merge($preset_options, $tinyoptions);
			}else{
				$tinyoptions = $preset_options;
			}
		}
		if(isset($options['id'])) {
			$textAreaId = $options['id'];
		} else {
			$textAreaId = str_replace('_', '-', str_replace('.', '-', strtolower($fieldName)));
		}
		return $this->Form->input($fieldName, $options).$this->_build($textAreaId, $tinyoptions);
	}

	/**
	* Creates a TinyMCE textarea.
	*
	* @param string $fieldName Name of a field, like this "Modelname.fieldname"
	* @param array $options Array of HTML attributes.
	* @param array $tinyoptions Array of TinyMCE attributes for this textarea
	* @return string An HTML textarea element with TinyMCE
	*/
	public function input($fieldName, $options=array(), $tinyoptions=array(), $preset=null) {
		return $this->textarea($fieldName, $options, $tinyoptions, $preset);
	}

	/**
	* Creates a preset for TinyOptions
	*
	* @param string $name
	* @return array
	*/
	private function preset($name) {
		// Full Feature
		if($name == 'full') {
			return array(
				'theme' =>  'modern',
				'plugins' =>    array('advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality', 'emoticons template paste textcolor'),
				'toolbar1' =>   'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				'toolbar2' =>   'print preview media | forecolor backcolor emoticons',
				'image_advtab' =>   true,
				'templates' =>  array(array('title'=>'Test template 1', 'content'=>'Test 1'), array('title'=>'Test template 2', 'content'=>'Test 2')),
			);
		}

		// Basic
		if($name == 'basic') {
			return array(
				'plugins' =>    'advlist autolink lists link image charmap print preview anchor', 'searchreplace visualblocks code fullscreen', 'insertdatetime media table contextmenu paste',
				'toolbar' =>    'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
			);
		}

		// Simple
		if($name == 'simple') {
			return array(
				'plugins' =>    'advlist autolink lists link image charmap print preview anchor', 'searchreplace visualblocks code fullscreen', 'insertdatetime media table contextmenu paste',
				'toolbar' =>    'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
			);
		}

		// UMCode
		if($name == 'umcode') {
			return array(
				'theme' =>  'modern',
				'plugins' =>    array('advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality', 'emoticons template paste textcolor'),
				'toolbar1' =>   'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				'toolbar2' =>   'print preview media | forecolor backcolor emoticons',
				'image_advtab' =>   true,
				'templates' =>  array(array('title'=>'Test template 1', 'content'=>'Test 1'), array('title'=>'Test template 2', 'content'=>'Test 2')),
			);
		}
		return null;
	}
}