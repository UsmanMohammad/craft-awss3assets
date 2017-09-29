<?php

/*
 * This file is part of the Azure Storage Blob Assets plugin.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Forked from AWS S3 Assets plugin by JonnyW\AWSS3Assets
 */
namespace UsmanMohammad\AzureStorageBlobAssets\Model;

use Craft\BaseModel;
use Craft\AttributeType;

/**
 * Azure Storage Blob Assets
 *
 * @author Usman Mohammad <contact@usman.mx>
 *
 * Forked from Jon Wenmoth <contact@jonnyw.me>
 */
class Settings extends BaseModel
{
    /**
     * Define model attributes.
     *
     * @access protected
     * @return array
     */
    protected function defineAttributes()
    {
        return array(
            'connectionString'    => array(AttributeType::String, 'required' => false),
            'container'    => array(AttributeType::String, 'required' => false)
            // 'containerPath'   => array(AttributeType::String, 'required' => false),
        );
    }
}
