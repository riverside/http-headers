<?php
class Http
{
	protected $error;

	protected $info;

	protected $responseHeaders = array();

	protected $authType;
	
	protected $username;

	protected $password;

	public function request($url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'HttpHeadersTool/1.0');
		curl_setopt($ch, CURLOPT_REFERER, 'https://zinoui.com/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
			
		if (!empty($this->username) && !empty($this->password))
		{
			switch ($this->authType)
			{
				case 'basic':
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
					break;
				case 'digest':
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
					break;
				case 'ntlm':
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
					break;
				case 'gss':
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_GSSNEGOTIATE);
					break;
				default:
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			}
			
			curl_setopt($ch, CURLOPT_USERPWD, sprintf('%s:%s', $this->username, $this->password));
		}

		$response = curl_exec($ch);
		$this->info = curl_getinfo($ch);
		if ($response === false)
		{
			$this->error = curl_error($ch);
		}
		curl_close($ch);

		return $this;
	}

	protected function getHeader($ch, $header)
	{
		$i = strpos($header, ':');
		if (!empty($i))
		{
			$key = strtolower(substr($header, 0, $i));
			$value = trim(substr($header, $i + 2));
			$this->responseHeaders[$key] = $value;
		}
		return strlen($header);
	}

	public function getError()
	{
		return $this->error;
	}

	public function getResponseHeaders()
	{
		return $this->responseHeaders;
	}

	public function getHttpCode()
	{
		return isset($this->info['http_code']) ? $this->info['http_code'] : null;
	}

	public function setAuthType($type)
	{
		$type = strtolower($type);
		if (in_array($type, array('basic', 'digest', 'gss', 'ntlm')))
		{
			$this->authType = $type;
		}
		return $this;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}
}
?>