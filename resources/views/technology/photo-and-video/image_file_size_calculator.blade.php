<x-calc.page
    title="Image File Size Calculator - SolveKit"
    description="Free image file size calculator: uncompressed size from pixels, bit depth and channels, with JPEG and PNG estimates."
    lede="Find an image file size."
    about="An uncompressed image stores every pixel’s colour values; compression shrinks it a lot."
    :calc="['engine' => 'tc-photo', 'tool' => 'image_size', 'fields' => ['w', 'h', 'depth', 'channels'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How big is an uncompressed 24 MP 8-bit RGB image?', 'answer' => '72 MB (68.66 MiB).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Width (pixels)" value="6000" min="1" step="any" />
        <x-calc.field name="h" label="Height (pixels)" value="4000" min="1" step="any" />
        <x-calc.select name="depth" label="Bits per channel" :options="['8' => '8-bit', '10' => '10-bit', '12' => '12-bit', '14' => '14-bit', '16' => '16-bit', '32' => '32-bit float']" selected="8" />
        <x-calc.select name="channels" label="Channels" :options="['1' => '1 (greyscale)', '3' => '3 (RGB)', '4' => '4 (RGBA or CMYK)']" selected="3" />
    </div>

    <x-calc.result label="Uncompressed size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 6000, 'h' => 4000, 'depth' => '8', 'channels' => '3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mp' => ['label' => 'Megapixels'],
            'bytes' => ['label' => 'Bytes'],
            'jpeg' => ['label' => 'Typical JPEG (about 10:1)'],
            'png' => ['label' => 'Typical PNG (about 2:1, varies)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
