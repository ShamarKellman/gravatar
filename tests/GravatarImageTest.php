<?php


namespace ShamarKellman\Gravatar\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ShamarKellman\Gravatar\Components\GravatarImage;

class GravatarImageTest extends TestCase
{
    public function testRenderImageComponent(): void
    {
        $expected = <<<HTML
<img src="https://secure.gravatar.com/avatar/7905d373cfab2e0fda04b9e7acc8c879?s=80" >
HTML;

        $compiled = $this->rendered(GravatarImage::class, ['email' => 'mail@mail.com']);

        self::assertSame($expected, $compiled);
    }

    public function rendered(string $component, array $data = []): string
    {
        [$data, $attributes] = $this->partitionDataAndAttributes($component, $data);

        $component = $this->app->make($component, $data->all());

        $component->withAttributes($attributes->all());

        $view = $component->resolveView();

        $view->with($component->data());

        return trim($view->render());
    }

    protected function partitionDataAndAttributes($class, array $attributes): Collection
    {
        $constructor = (new ReflectionClass($class))->getConstructor();

        $parameterNames = $constructor
            ? collect($constructor->getParameters())->map->getName()->all()
            : [];

        return collect($attributes)->partition(function ($value, $key) use ($parameterNames) {
            return in_array(Str::camel($key), $parameterNames, true);
        });
    }
}
