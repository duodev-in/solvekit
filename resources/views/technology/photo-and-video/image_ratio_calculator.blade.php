<x-calc.page
    title="Image Ratio Calculator - SolveKit"
    description="Free image ratio calculator: resize an image keeping its ratio, or crop it to a new ratio."
    lede="Resize or crop an image."
    about="Resizing keeps the ratio; changing the ratio means cropping."
    :calc="['engine' => 'tc-photo', 'tool' => 'image_ratio', 'fields' => ['w', 'h', 'fit', 'newW', 'newH', 'ratio'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is 4000 × 3000 at 1200 wide?', 'answer' => '1,200 × 900.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Original width" value="4000" min="1" step="any" />
        <x-calc.field name="h" label="Original height" value="3000" min="1" step="any" />
        <x-calc.select name="fit" label="Resize to" :options="['width' => 'A new width', 'height' => 'A new height', 'ratio' => 'A different aspect ratio (crop)']" selected="width" />
        <div data-show-when="fit:width">
            <x-calc.field name="newW" label="New width" value="1200" min="1" step="any" />
        </div>
        <div data-show-when="fit:height">
            <x-calc.field name="newH" label="New height" value="800" min="1" step="any" />
        </div>
        <div data-show-when="fit:ratio">
            <x-calc.field name="ratio" label="Target ratio" value="16:9" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="New size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 4000, 'h' => 3000, 'fit' => 'width', 'newW' => 1200, 'newH' => 800, 'ratio' => '16:9'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Original ratio'],
            'scale' => ['label' => 'Scale'],
            'crop' => ['label' => 'Pixels lost to the crop'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
