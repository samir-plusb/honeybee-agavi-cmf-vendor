<?php
/*
 * AUTOGENERATED CODE - DO NOT EDIT!
 *
 * This base class was generated by the Trellis library and
 * must not be modified manually. Any modifications to this
 * file will be lost upon triggering the next automatic
 * class generation.
 *
 * If you are looking for a place to alter the behaviour of
 * the 'User' type please see the skeleton
 * class 'UserType'. Modifications to the skeleton
 * file will prevail any subsequent class generation runs.
 *
 * To define new attributes or adjust existing attributes and their
 * default options modify the schema definition file of
 * the 'User' type.
 *
 * @see https://github.com/honeybee/trellis
 */

namespace Honeybee\SystemAccount\User\Projection\Standard\Base;

use Trellis\Common\Options;
use Honeybee\SystemAccount\User\Projection\Standard\Base;
use Honeybee\Projection\ProjectionType;

/**
 * Serves as the base class to the 'User' type skeleton.
 */
abstract class UserType extends ProjectionType
{
    /**
     * Creates a new 'UserType' instance.
     */
    public function __construct()
    {
        parent::__construct(
            'User',
            [
                new \Trellis\Runtime\Attribute\Text\TextAttribute(
                    'username',
                    $this,
                    array(
                        'mandatory' => true,
                        'min_length' => 1,
                        'max_length' => 50,
                    )
                ),
                new \Trellis\Runtime\Attribute\Email\EmailAttribute(
                    'email',
                    $this,
                    array(
                        'mandatory' => true,
                    )
                ),
                new \Trellis\Runtime\Attribute\Choice\ChoiceAttribute(
                    'role',
                    $this,
                    array(
                        'mandatory' => true,
                        'min_length' => 1,
                        'max_length' => 255,
                    )
                ),
                new \Trellis\Runtime\Attribute\Text\TextAttribute(
                    'firstname',
                    $this,
                    array(
                        'max_length' => 100,
                    )
                ),
                new \Trellis\Runtime\Attribute\Text\TextAttribute(
                    'lastname',
                    $this,
                    array(
                        'max_length' => 100,
                    )
                ),
                new \Trellis\Runtime\Attribute\Text\TextAttribute(
                    'password_hash',
                    $this,
                    array(
                        'min_length' => 50,
                        'max_length' => 100,
                    )
                ),
                new \Trellis\Runtime\Attribute\ImageList\ImageListAttribute(
                    'background_images',
                    $this,
                    array(
                        'max_count' => 5,
                    )
                ),
                new \Trellis\Runtime\Attribute\Text\TextAttribute(
                    'auth_token',
                    $this,
                    array(
                        'max_length' => 40,
                    )
                ),
                new \Trellis\Runtime\Attribute\Timestamp\TimestampAttribute(
                    'token_expire_date',
                    $this,
                    array(
                        'format_native' => 'Y-m-d\\TH:i:s.uP',
                    )
                ),
            ],
            new Options(
                array(
                'vendor' => 'Honeybee',
                'package' => 'SystemAccount',
                'is_hierarchical' => false,
            )
            )
        );
    }

    /**
     * Returns the EntityInterface implementor to use when creating new entities.
     *
     * @return string Fully qualified name of an EntityInterface implementation.
     */
    public static function getEntityImplementor()
    {
        return '\\Honeybee\\SystemAccount\\User\\Projection\\Standard\\User';
    }
}
