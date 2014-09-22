<legend>Actions</legend>

<p>Encryption is an essential part of the TownsMods.net API. When passing potentially sensitive data across the internet
it is absolutely a neccessity. Some functions, such as the authentication functions, include the passing of user passwords 
for checking and the return of a unique session variable, which is used in other functions to authenticate a user.</p>

<legend></legend><h4>Encryption Algortihm</h4>

<p>TownsMods.net encrypts all JSON request data and all JSON/XML response data with PHP's <a href="http://php.net/manual/en/book.mcrypt.php">MCrypt</a>. 
Our encryption class is an altered version of the <a href="http://three.laravel.com/docs/encryption">Laravel 3 crypter class</a>.
<br /><br />
We use MCRYPT_RIJNDAEL_256 as our cipher and cipher mode CBC. Your encryption key will be 32 characters in length, and provides security for all data transfers.
</p>

<legend></legend><a id="crypter"></a><h4>Sample Encryption Class</h4>
<div class="alert alert-success">
<strong>NOTE:</strong>This example is in PHP, for other languages please see their respective manuals and documentation.
</div>

<pre class="prettyprint lang-php linenums">
class Encrypter {

	/**
	 * The encryption cipher.
	 *
	 * @var string
	 */
	public static $cipher = MCRYPT_RIJNDAEL_256;

	/**
	 * The encryption mode.
	 *
	 * @var string
	 */
	public static $mode = MCRYPT_MODE_CBC;

	/**
	 * The block size of the cipher.
	 *
	 * @var int
	 */
	public static $block = 32;

	/**
	 * Encrypt a string using Mcrypt.
	 *
	 * The string will be encrypted using the AES-256 scheme and will be base64 encoded.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function encrypt($value, $key)
	{
		$iv = mcrypt_create_iv(static::iv_size(), static::randomizer());

		$value = static::pad($value);

		$value = mcrypt_encrypt(static::$cipher, $key, $value, static::$mode, $iv);

		return base64_encode($iv.$value);
	}

	/**
	 * Decrypt a string using Mcrypt.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function decrypt($value, $key)
	{
		$value = base64_decode($value);

		// To decrypt the value, we first need to extract the input vector and
		// the encrypted value. The input vector size varies across different
		// encryption ciphers and modes, so we'll get the correct size.
		$iv = substr($value, 0, static::iv_size());

		$value = substr($value, static::iv_size());

		// Once we have the input vector and the value, we can give them both
		// to Mcrypt for decryption. The value is sometimes padded with \0,
		// so we will trim all of the padding characters.
		

		$value = mcrypt_decrypt(static::$cipher, $key, $value, static::$mode, $iv);

		return static::unpad($value);
	}

	/**
	 * Get the most secure random number generator for the system.
	 *
	 * @return int
	 */
	public static function randomizer()
	{
		// There are various sources from which we can get random numbers
		// but some are more random than others. We'll choose the most
		// random source we can for this server environment.
		if (defined('MCRYPT_DEV_URANDOM'))
		{
			return MCRYPT_DEV_URANDOM;
		}
		elseif (defined('MCRYPT_DEV_RANDOM'))
		{
			return MCRYPT_DEV_RANDOM;
		}
		// When using the default random number generator, we'll seed
		// the generator on each call to ensure the results are as
		// random as we can possibly get them.
		else
		{
			mt_srand();

			return MCRYPT_RAND;
		}
	}

	/**
	 * Get the input vector size for the cipher and mode.
	 *
	 * @return int
	 */
	protected static function iv_size()
	{
		return mcrypt_get_iv_size(static::$cipher, static::$mode);
	}

	/**
	 * Add PKCS7 compatible padding on the given value.
	 *
	 * @param  string  $value
	 * @return string
	 */
	protected static function pad($value)
	{
		$pad = static::$block - (Str::length($value) % static::$block);

		return $value .= str_repeat(chr($pad), $pad);
	}

	/**
	 * Remove the PKCS7 compatible padding from the given value.
	 *
	 * @param  string  $value
	 * @return string
	 */
	protected static function unpad($value)
	{
		if (MB_STRING)
		{
			$pad = ord(mb_substr($value, -1, 1, 'UTF-8'));
		}
		else
		{
			$pad = ord(substr($value, -1));
		}

		if ($pad and $pad < static::$block)
		{
			// If the correct padding is present on the string, we will remove
			// it and return the value. Otherwise, we'll throw an exception
			// as the padding appears to have been changed.
			if (preg_match('/'.chr($pad).'{'.$pad.'}$/', $value))
			{
				if (MB_STRING)
				{
					return mb_substr($value, 0, Str::length($value) - $pad, 'UTF-8');
				}

				return substr($value, 0, Str::length($value) - $pad);
			}

			// If the padding characters do not match the expected padding
			// for the value we'll bomb out with an exception since the
			// encrypted value seems to have been changed.
			else
			{
				throw new \Exception("Decryption error. Padding is invalid.");
			}
		}

		return $value;
	}

	
}


</pre>
