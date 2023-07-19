<?php
/**
 * Created by PhpStorm.
 * User: imac
 * Date: 1/10/18
 * Time: 2:38 PM
 */

namespace VoxxxUtils\net;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Net {
	static function getHttp(string $url, array $vars = [], $async = false): bool|string {
		if (str_starts_with($url, "https")) {
			return self::getHttpDo($url, $vars, true, $async);
		}
		if (str_starts_with($url, "http:")) {
			return self::getHttpDo($url, $vars, false, $async);
		}
		return "";
	}

	static function getHttpDo(string $url, array $vars = [], bool $isssl = false, bool $async = false): bool|string {
		$ch = curl_init($url);
		if (false === $ch)
			return false;
		if ($isssl === true) {
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if (!empty($vars))
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($vars));
		if (!$async) {
			curl_setopt($ch, CURLOPT_TIMEOUT, 6);
		} else {
			curl_setopt($ch, CURLOPT_TIMEOUT, 0.1);
		}

		$data = curl_exec($ch);
		if (false === $data)
			return false;
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (200 != $http_status)
			return "";
		curl_close($ch);
		return $data;
	}

	/**
	 * @throws GuzzleException
	 */
	public function getGuzzleHttp(string $uri, array $params): bool|string {
		$client = new Client();

		$response = $client->post($uri, [
			RequestOptions::JSON => $params
		]);

		if ($response->getStatusCode()!=200) return false;

		return $response->getBody()->getContents();

	}

}