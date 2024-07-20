<button {{ $attributes->merge(['type' => 'submit', 'class' => 'block w-full mt-2  text-center rounded bg-teal-400 p-3 text-md font-medium text-white transition hover:scale-105']) }}>
    {{ $slot }}
</button>
