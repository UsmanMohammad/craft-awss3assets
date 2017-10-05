<?php

/*
 * This file is part of the Azure Storage Blob Assets plugin.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Forked from AWS S3 Assets plugin by JonnyW\AWSS3Assets
 */
namespace Tests\UsmanMohammad\AzureStorageBlobAssets\Unit;

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
    /**
     * Test can get container instance
     *
     * @return void
     */
    public function testCanGetContainerInstance()
    {
        $container = BlobContainer::getInstance(
            '<insertConnectionString>', 
            '<insertContainerName>'
        );

        $this->assertInstanceOf('\UsmanMohammad\AzureStorageBlobAssets\BlobContainer', $container);
    }

    /**
     * Test can get container instance
     * without credentials
     *
     * @return void
     */
    public function testCannotGetInstanceIfConnectionStringNotProvided()
    {
        $this->setExpectedException('\Exception');

        $container = BlobContainer::getInstance(
            '',
            ''
        );
    }
}
