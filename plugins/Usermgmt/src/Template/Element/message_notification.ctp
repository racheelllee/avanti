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
<style type="text/css">
	#toast-container > div {
		opacity: 1;
	}
</style>
<?php
if($this->request->session()->check('Flash')) {
	$flashSession = $this->request->session()->read('Flash');
	$this->request->session()->delete('Flash');
	foreach($flashSession as $flashMessages) {
		if(!isset($flashMessages[0])) {
			$flashMessages = [$flashMessages];
		}
		foreach($flashMessages as $flash) {
			$flashMsgClass = 'success';
			$flashMsg = $flash['message'];
			if(!empty($flash['params']['class'])) {
				$flashMsgClass = $flash['params']['class'];
			} else {
				if(!empty($flash['element'])) {
					if(strpos($flash['element'], 'error') !== false) {
						$flashMsgClass = 'error';
					} else if(strpos($flash['element'], 'success') !== false) {
						$flashMsgClass = 'success';
					} else if(strpos($flash['element'], 'warning') !== false) {
						$flashMsgClass = 'warning';
					} else if(strpos($flash['element'], 'info') !== false) {
						$flashMsgClass = 'info';
					}
				}
			}?>
			<script type="text/javascript">
				$(function() {
					var flashMsgClass = '<?php echo $flashMsgClass; ?>';
					var flashMsg = '<?php echo $flashMsg; ?>';
					var positionClass = '<?php echo NOTIFICATION_MESSAGE_POSITION; ?>';
					var timeOut = '<?php echo NOTIFICATION_MESSAGE_CLOSE_TIME * 1000; ?>';
					toastr_options = {
						closeButton: true,
						tapToDismiss: false,
						showMethod: 'slideDown', //fadeIn, slideDown, and show are built into jQuery
						showDuration: 300,
						showEasing: 'swing', //swing and linear are built into jQuery
						hideMethod: 'fadeOut',
						hideDuration: 1000,
						hideEasing: 'swing',
						extendedTimeOut: timeOut,
						positionClass: positionClass,
						timeOut: timeOut, // Set timeOut and extendedTimeOut to 0 to make it sticky
						escapeHtml: true,
						target: 'body',
						closeHtml: '<button type="button">&times;</button>',
						newestOnTop: false,
						preventDuplicates: false,
						progressBar: false
					};
					if(flashMsgClass == 'error') {
						toastr.error(flashMsg, null, toastr_options);
					} else if(flashMsgClass == 'info') {
						toastr.info(flashMsg, null, toastr_options);
					} else if(flashMsgClass == 'warning') {
						toastr.warning(flashMsg, null, toastr_options);
					} else {
						toastr.success(flashMsg, null, toastr_options);
					}
				});
			</script>
<?php	}
	}
}?>