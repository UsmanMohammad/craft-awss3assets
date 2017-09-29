<?php

/*
 * This file is part of the Azure Storage Blob Assets plugin.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Forked from AWS S3 Assets plugin by JonnyW\AWSS3Assets
 */
namespace UsmanMohammad\AzureStorageBlobAssets;

use UsmanMohammad\AzureStorageBlobAssets\Exception\ObjectNotFoundException;
use MicrosoftAzure\Storage\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

/**
 * Azure Storage Blob Assets
 *
 * @author Usman Mohammad <contact@usman.mx>
 *
 * Forked from Jon Wenmoth <contact@jonnyw.me>
 */
class BlobContainer
{
    /**
     * Azure Storage Container instance.
     *
     * @var \UsmanMohammad\AzureStorageBlobAssets\BlobContainer
     * @access private
     */
    private static $instance;

    /**
     * AzureStorage client
     *
     * @var \MicrosoftAzure\Storage\Common\ServicesBuilder
     * @access protected
     */
    protected $client;

    /**
     * Container name
     *
     * @var string
     * @access protected
     */
    protected $name;
   
     /**
     * Internal constructor.
     *
     * @access public
     * @param \MicrosoftAzure\Storage\Common\ServicesBuilder $client
     * @param string                    $name
     */
    public function __construct(ServicesBuilder $client, $name)
    {
        $this->client = $client;
        $this->name   = $name;
        // $this->containerPath = trim($containerPath,'/');
    }

    /**
     * Get singleton instance.
     *
     * @access public
     * @static
     * @param  string                       $connectionString
     * @param  string                       $container
     * @return \UsmanMohammad\AzureStorageBlobAssets\BlobContainer
     */
    public static function getInstance($connectionString, $container)
    {
        if (!self::$instance instanceof \UsmanMohammad\AzureStorageBlobAssets\BlobContainer) {

            $client = ServicesBuilder::getInstance()->createBlobService($connectionString);

            self::$instance = new static(
                $client,
                $container
            );
        }

        return self::$instance;
    }

    /**
     * Copy media.
     *
     * @access public
     * @param  string            $path
     * @param  string            $filename
     * @return \MicrosoftAzure\Storage\Blob\Models\PutBlobResult|false
     */
    public function copy($path, $filename)
    {
        if (!file_exists($path)) {
            return false;
        }
        
        $content = fopen($path, 'r');
        $result = $blobClient->createBlockBlob($this->name, $filename, $content);
        return $result;
    }

    /**
     * Remove media.
     *
     * @access public
     * @param  string      $filename
     * @return void
     */
    public function remove($filename)
    {
        $this->client
            ->deleteBlob($this->name, $filename);
    }

    /**
     * Get media.
     *
     * @access public
     * @param  string $filename
     * @return \MicrosoftAzure\Storage\Models\GetBlobResult
     */
    public function get($filename)
    {
        $result = $this->client
            ->getBlob($this->name, $filename);
        return $result;
    }
}
