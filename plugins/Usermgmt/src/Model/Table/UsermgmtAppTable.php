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
namespace Usermgmt\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Validation\Validation;

class UsermgmtAppTable extends Table {
	/**
	 * Used to validate string with letter, integer, dash, underscore
	 *
	 * @access public
	 * @return boolean
	 * more info http://de3.php.net/manual/en/regexp.reference.unicode.php
	 */
	public function alphaNumericDashUnderscore($value, $context) {
		if(!preg_match('/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}\p{Pd}\p{Pc}]+$/Du', $value)) {
			return false;
		}
		return true;
	}
	/**
	 * Used to validate string with letter, integer, dash, underscore, space
	 *
	 * @access public
	 * @return boolean
	 * more info http://de3.php.net/manual/en/regexp.reference.unicode.php
	 */
	public function alphaNumericDashUnderscoreSpace($value, $context) {
		if(!preg_match('/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}\p{Zs}\p{Pd}\p{Pc}]+$/Du', $value)) {
			return false;
		}
		return true;
	}
	/**
	 * Used to validate string with letter
	 *
	 * @access public
	 * @return boolean
	 */
	public function alpha($value, $context) {
		if(!preg_match('/[\p{L}]/u', $value)) {
			return false;
		}
		return true;
	}
	/**
	 * Used to validate captcha
	 *
	 * @access public
	 * @return boolean
	 */
	public function recaptchaValidate($value, $context) {
		require_once(USERMGMT_PATH.DS.'vendor'.DS.'recaptcha'.DS.'src'.DS.'autoload.php');
		$recaptcha = new \ReCaptcha\ReCaptcha(PRIVATE_KEY_FROM_RECAPTCHA);
		$resp = $recaptcha->verify($value);
		if($resp->isSuccess()) {
			return true;
		} else {
			$errors = $resp->getErrorCodes();
			return false;
		}
	}
	/**
	 * Used to check valid emails
	 *
	 * @access public
	 * @return boolean
	 */
	public function checkValidEmails($value, $context) {
		$emails = explode(',', $value);
		foreach($emails as $email) {
			$email = trim($email);
			if(!empty($email)) {
				if(!Validation::email($email)) {
					return false;
				}
			}
		}
		return true;
	}
}