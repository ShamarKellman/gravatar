<?php

namespace ShamarKellman\Gravatar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Gravatar
 * @package ShamarKellman\Gravatar
 *
 * @property int $size
 * @property string $defaultImage
 * @property string $maxRating
 * @property bool $alwaysForceDefaultImage
 * @property string $url
 * @method  static Gravatar setAvatarSize(int $size)
 * @method static string buildGravatarURL(string $email = '')
 * @method static string getEmailHash(string $email)
 * @method static string buildParams()
 * @method static int getAvatarSize()
 * @method static string getMaxRating()
 * @method static Gravatar setMaxRating(string $rating)
 * @method static string getDefaultImage()
 * @method static Gravatar setDefaultImage($image)
 * @method static bool getAlwaysForceDefaultImage()
 * @method static Gravatar setAlwaysForceDefaultImage(bool $alwaysForceDefaultImage = false)
 *
 * @see Gravatar
 */
class Gravatar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'gravatar';
    }
}
