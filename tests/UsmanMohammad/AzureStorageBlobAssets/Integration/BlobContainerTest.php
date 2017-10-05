<?php

/*
 * This file is part of the Azure Storage Blob Assets plugin.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Forked from AWS S3 Assets plugin by JonnyW\AWSS3Assets
 */
namespace Tests\UsmanMohammad\AzureStorageBlobAssets\Integration;

use UsmanMohammad\AzureStorageBlobAssets\BlobContainer;

/**
 * Azure Storage Blob Assets
 *
 * @author Usman Mohammad <contact@usman.mx>
 *
 * Forked from Jon Wenmoth <contact@jonnyw.me>
 */
class BlobContainerTest extends \PHPUnit_Framework_TestCase
{
    use \Tests\UsmanMohammad\AzureStorageBlobAssets\Traits\FileTestTrait;
    
    /**
     * Test can copy new media
     * to Blob Container
     *
     * @return void
     */
    public function testCanCopyNewMediaToBlobContainer()
    {
        $container = BlobContainer::getInstance(
            '<insertConnectionString>', 
            '<insertContainerName>');
        $container->copy(
            $this->getFilePath(),
            $this->getFileName()
        );

        $this->assertInstanceOf('MicrosoftAzure\Storage\Blob\Models\GetBlobResult', $container->get($this->getFileName()));
    }

    /**
     * Test can overwrite existing
     * media in Blob Container
     *
     * @return void
     */
    public function testCanOverwriteExistingMediaInBlobContainer()
    {
        $container = BlobContainer::getInstance(
            '<insertConnectionString>', 
            '<insertContainerName>');

        $path = $this->getFilePath();
        $name = $this->getFileName();

        $this->assertTrue($container->copy($path, $name) && $container->copy($path, $name));
    }

    /**
     * Test can copy new media
     * to Blob Container in subdirectory
     *
     * @return void
     */
    public function testCanCopyNewMediaToBlobContainerInSubDirectory()
    {
        $file = 'assets/' . $this->getFileName();

        $container = BlobContainer::getInstance(
            '<insertConnectionString>', 
            '<insertContainerName>');
        $container->copy(
            $this->getFilePath(),
            $file
        );

        $this->assertInstanceOf('MicrosoftAzure\Storage\Blob\Models\GetBlobResult', $container->get($file));
    }

    /**
     * Test can delete media from
     * Blob Container
     *
     * @return void
     */
    public function testCanDeleteMediaFromBlobContainer()
    {
        $this->setExpectedException('\UsmanMohammad\AzureStorageBlobAssets\Exception\ObjectNotFoundException');

        $container = BlobContainer::getInstance(
            '<insertConnectionString>', 
            '<insertContainerName>');
        $container->copy(
            $this->getFilePath(),
            $this->getFileName()
        );

        $container->remove($this->getFileName());
        $container->get($this->getFileName());
    }
}
