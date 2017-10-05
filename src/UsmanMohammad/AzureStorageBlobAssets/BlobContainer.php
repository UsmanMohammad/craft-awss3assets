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
use MicrosoftAzure\Storage\Blob\BlobRestProxy; 

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
     * @var \MicrosoftAzure\Storage\Blob\BlobRestProxy
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
     * @param \MicrosoftAzure\Storage\Blob\BlobRestProxy $client
     * @param string                    $name
     */
    public function __construct(BlobRestProxy $client, $name)
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

            $serviceBuilder = ServicesBuilder::getInstance();
            try{
                $client = $serviceBuilder->createBlobService($connectionString);
                self::$instance = new static(
                    $client,
                    $container
                );                
            }
            catch(\Exception $e)
            {
               throw $e;
            }

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
        $result = $this->client->createBlockBlob($this->name, $filename, $content);
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
     * @throws \MicrosoftAzure\Storage\Common\Exceptions\ServiceException
     * @throws \UsmanMohammad\AzureStorageBlobAssets\Exception\ObjectNotFoundException
     */
    public function get($filename)
    {
        try {
            $result = $this->client
                ->getBlob($this->name, $filename);
        }
        catch (\MicrosoftAzure\Storage\Common\Exceptions\ServiceException $e){

            if ( $e->getResponse()->getStatusCode() == '404'){
                throw new ObjectNotFoundException($e->getErrorMessage());
            }
            throw $e;
        }

        return $result;
    }
}
