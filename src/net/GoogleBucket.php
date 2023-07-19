<?php

namespace VoxxxUtils\net;

use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Client;

class GoogleBucket {

	public Bucket $bucket;

	public function __construct(string $pathToKeyfileJson, string $bucketFolder) {
		$guzzleClient = new Client(['verify' => false]);
		$storage = new StorageClient(['keyFilePath' => $pathToKeyfileJson, 'httpHandler' => function ($request, $options = []) use ($guzzleClient) {
			return $guzzleClient->send($request, $options);
		}]);
		$this->bucket = $storage->bucket($bucketFolder);
	}

	public function uploadToBucket(string $pathToFile, string $filename): void {
		$this->bucket->upload(fopen($pathToFile, 'r'), ['name' => $filename]);
	}
}