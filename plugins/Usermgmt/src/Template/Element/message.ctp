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
<?php if($this->request->session()->check('Flash')): ?>
	<?php
		$flash = $this->request->session()->read('Flash');
		$this->request->session()->delete('Flash');
		$flashMsgClass = 'success';
		$flashMsg = '';
	?>
	<?php if(isset($flash['auth'])): ?>
		<?php if(!empty($flash['auth']['params']['class'])): ?>
			<?php
				$flashMsgClass = $flash['auth']['params']['class'];
				$flashMsgClass = $flashMsgClass == 'error' ? 'danger' : $flashMsgClass;
				$flashMsg = $flash['auth']['message'];
			?>
			<div class="alert alert-<?php echo $flashMsgClass; ?>" id="flashMessage">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span><?php echo $flashMsg; ?></span>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php if(isset($flash['flash'])): ?>
		<?php foreach ($flash['flash'] as $key => $message): ?>
			<?php if(!empty($message['element'])): ?>
				<?php
					if($message['element'] == 'Flash/error') {
						$flashMsgClass = 'danger';
					} else if($message['element'] == 'Flash/success') {
						$flashMsgClass = 'success';
					} else if($message['element'] == 'Flash/warning') {
						$flashMsgClass = 'warning';
					} else if($message['element'] == 'Flash/info') {
						$flashMsgClass = 'info';
					}
				?>
			<?php endif; ?>
			<?php $flashMsg = $message['message']; ?>
			<div class="alert alert-<?php echo $flashMsgClass; ?>" id="flashMessage">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span><?php echo $flashMsg; ?></span>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>
