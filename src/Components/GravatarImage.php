<?php

namespace ShamarKellman\Gravatar\Components;

use Illuminate\View\Component;
use ShamarKellman\Gravatar\Facades\Gravatar;

class GravatarImage extends Component
{
    public int $size;
    public string $email;

    public function __construct(string $email, int $size = null)
    {
        $this->email = $email;
        $this->size = $size ?? config('gravatar.size');
    }

    public function render()
    {
        return view('gravatar::components.gravatar-image', [
            'src' => Gravatar::setAvatarSize($this->size)->buildGravatarURL($this->email),
        ]);
    }
}
