<img src="{{ $src }}" {{ $attributes->filter(fn ($value, $key) => $key !== 'src') }}>
