<?php

namespace ShamarKellman\Gravatar;

use InvalidArgumentException;
use ShamarKellman\Gravatar\Exceptions\InvalidDefaultImageException;
use ShamarKellman\Gravatar\Exceptions\InvalidEmailException;
use ShamarKellman\Gravatar\Exceptions\InvalidRatingException;
use ShamarKellman\Gravatar\Exceptions\InvalidSizeException;

class Gravatar
{
    protected int $size;

    protected string $defaultImage;

    protected string $maxRating;

    protected bool $alwaysForceDefaultImage;

    protected string $url = 'https://secure.gravatar.com/avatar/';

    /**
     * Set the avatar size to use.
     *
     * @param  int  $size
     * @return Gravatar
     *
     * @throws InvalidArgumentException
     * @throws InvalidSizeException
     */
    public function setAvatarSize(int $size): Gravatar
    {
        if ($size > 512 || $size <= 0) {
            throw new InvalidSizeException('Avatar size must be within 0 pixels and 512 pixels');
        }

        $this->size = $size;

        return $this;
    }

    /**
     * Build the avatar URL based on the provided email address.
     * @param  string  $email
     * @return string - The XHTML-safe URL to the gravatar.
     * @throws InvalidEmailException
     */
    public function buildGravatarURL(string $email = ''): string
    {
        if (empty($email)) {
            return $this->url.str_repeat('0', 32).$this->buildParams();
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException('Please use a valid email.');
        }

        return $this->url.$this->getEmailHash($email).$this->buildParams();
    }

    /**
     * Get the email hash to use (after cleaning the string).
     * @param  string  $email  - The email to get the hash for.
     * @return string - The hashed form of the email, post cleaning.
     */
    public function getEmailHash(string $email): string
    {
        return md5(strtolower(trim($email)));
    }

    public function buildParams(): string
    {
        $params = [
            's='.$this->getAvatarSize(),
        ];

        if (isset($this->maxRating)) {
            $params[] = 'r='.$this->getMaxRating();
        }

        if (isset($this->defaultImage)) {
            $params[] = 'd='.$this->getDefaultImage();
        }

        if ($this->getAlwaysForceDefaultImage()) {
            $params[] = 'f=y';
        }

        return '?'.implode('&amp;', $params);
    }

    public function getAvatarSize(): int
    {
        return $this->size ?? config('gravatar.size');
    }

    public function getMaxRating(): string
    {
        return $this->maxRating ?? config('gravatar.max_rating');
    }

    /**
     * Set the maximum allowed rating for avatars.
     * @param  string  $rating  - The maximum rating to use for avatars ('g', 'pg', 'r', 'x').
     * @return Gravatar - Provides a fluent interface.
     *
     * @throws InvalidArgumentException
     * @throws InvalidRatingException
     */
    public function setMaxRating(string $rating): Gravatar
    {
        if (! in_array($rating, ['g', 'pg', 'r', 'x'])) {
            throw new InvalidRatingException('Invalid rating specified, only "g", "pg", "r", or "x" are allowed to be used.');
        }

        $this->maxRating = $rating;

        return $this;
    }

    /**
     * Get the current default image setting.
     */
    public function getDefaultImage(): string
    {
        return $this->defaultImage ?? config('gravatar.default_image');
    }

    /**
     * Set the default image to use for avatars.
     *
     * @param  mixed  $image  - The default image to use. Use boolean false for the gravatar default, a string containing a valid image URL, or a string specifying a recognized gravatar "default".
     * @return Gravatar
     *
     * @throws InvalidDefaultImageException
     */
    public function setDefaultImage($image): Gravatar
    {
        if (! filter_var($image, FILTER_VALIDATE_URL) &&
            ! in_array($image, ['404', 'mp', 'identicon', 'monsterid', 'wavatar', 'retro'], true)) {
            throw new InvalidDefaultImageException('The default image specified is not a recognized gravatar "default" and is not a valid URL');
        }

        $this->defaultImage = filter_var($image, FILTER_VALIDATE_URL) ?
            rawurlencode($image) :
            $this->defaultImage = $image;

        return $this;
    }

    public function getAlwaysForceDefaultImage(): bool
    {
        return $this->alwaysForceDefaultImage ?? config('gravatar.always_force_default_image');
    }

    public function setAlwaysForceDefaultImage(bool $alwaysForceDefaultImage = false): Gravatar
    {
        $this->alwaysForceDefaultImage = $alwaysForceDefaultImage;

        return $this;
    }
}
