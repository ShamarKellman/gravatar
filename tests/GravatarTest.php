<?php

namespace ShamarKellman\Gravatar\Tests;

use ShamarKellman\Gravatar\Exceptions\InvalidDefaultImageException;
use ShamarKellman\Gravatar\Exceptions\InvalidEmailException;
use ShamarKellman\Gravatar\Exceptions\InvalidRatingException;
use ShamarKellman\Gravatar\Exceptions\InvalidSizeException;
use ShamarKellman\Gravatar\Facades\Gravatar;

class GravatarTest extends TestCase
{
    public function testAlwaysUseDefaultImage(): void
    {
        Gravatar::setAlwaysForceDefaultImage(true);

        self::assertTrue(Gravatar::getAlwaysForceDefaultImage());
    }

    public function testAlwaysUseDefaultImageUsesConfig(): void
    {
        self::assertFalse(Gravatar::getAlwaysForceDefaultImage());
    }

    public function testAvatarSize(): void
    {
        Gravatar::setAvatarSize(90);

        self::assertEquals(90, Gravatar::getAvatarSize());
    }

    public function testAvatarSizeReadsFromConfig(): void
    {
        self::assertEquals(80, Gravatar::getAvatarSize());
    }

    public function testAvatarSizeThrowsExceptionIfMoreThan512(): void
    {
        $this->expectException(InvalidSizeException::class);

        Gravatar::setAvatarSize(513);

        self::assertNotEquals(513, Gravatar::getAvatarSize());
    }

    public function testAvatarSizeThrowsExceptionIfLessThan0(): void
    {
        $this->expectException(InvalidSizeException::class);

        Gravatar::setAvatarSize(0);

        self::assertNotEquals(0, Gravatar::getAvatarSize());
    }

    public function testMaxRating(): void
    {

        Gravatar::setMaxRating('pg');

        self::assertEquals('pg', Gravatar::getMaxRating());
    }

    public function testMaxRatingThrowsException(): void
    {
        $this->expectException(InvalidRatingException::class);

        Gravatar::setMaxRating('l');

        self::assertNotEquals('l', Gravatar::getMaxRating());
    }

    public function testDefaultImageAsUrl(): void
    {
        Gravatar::setDefaultImage('https://example.com/images/avatar.jpg');
        self::assertEquals('https%3A%2F%2Fexample.com%2Fimages%2Favatar.jpg', Gravatar::getDefaultImage());
    }

    public function testDefaultImageAsGravatarDefault(): void
    {
        Gravatar::setDefaultImage('mp');
        self::assertEquals('mp', Gravatar::getDefaultImage());
    }

    public function testDefaultImageAsURLFromConfig(): void
    {
        config()->set('gravatar.default_image', 'http://google.com');
        self::assertEquals('http://google.com', Gravatar::getDefaultImage());
    }

    public function testDefaultImageAsGravatarDefaultFromConfig(): void
    {
        config()->set('gravatar.default_image', '404');
        self::assertEquals('404', Gravatar::getDefaultImage());
    }

    public function testDefaultImageWithInvalidUrl(): void
    {
        $this->expectException(InvalidDefaultImageException::class);

        Gravatar::setDefaultImage('http://stackoverflow.com/users/9999999/not a-real-user');

        self::assertNotEquals('http://stackoverflow.com/users/9999999/not a-real-user', Gravatar::getDefaultImage());
    }

    public function testDefaultImageWithInvalidGravatarDefault(): void
    {
        $this->expectException(InvalidDefaultImageException::class);

        Gravatar::setDefaultImage('xxx');

        self::assertNotEquals('xxx', Gravatar::getDefaultImage());
    }

    public function testGetEmailHash(): void
    {
        self::assertEquals(md5('mail@mail.com'), Gravatar::getEmailHash('mail@mail.com'));
    }

    public function testBuildParams(): void
    {
        Gravatar::setAvatarSize(90)
            ->setMaxRating('g')
            ->setDefaultImage('404')
            ->setAlwaysForceDefaultImage(true);
        $params = Gravatar::buildParams();

        self::assertEquals('?s=90&amp;r=g&amp;d=404&amp;f=y', $params);
    }

    public function testBuildUrl(): void
    {
        self::assertEquals('https://secure.gravatar.com/avatar/7905d373cfab2e0fda04b9e7acc8c879?s=80&amp;r=g&amp;d=mp',
            Gravatar::buildGravatarURL('mail@mail.com')
        );
    }

    public function testBuildUrlWithEmptyEmail(): void
    {
        self::assertEquals('https://secure.gravatar.com/avatar/00000000000000000000000000000000?s=80&amp;r=g&amp;d=mp',
            Gravatar::buildGravatarURL()
        );
    }

    public function testBuildUrlThrowsException(): void
    {
        $this->expectException(InvalidEmailException::class);

        Gravatar::buildGravatarURL('main');
    }
}
