<x-calc.page
    title="Megapixel Calculator - SolveKit"
    description="Free megapixel calculator: megapixels from pixel dimensions (or the reverse) and the largest print sizes."
    lede="Find megapixels and print size."
    about="Megapixels count the pixels; the print size depends on how many pixels per inch you print at."
    :calc="['engine' => 'tc-photo', 'tool' => 'megapixel', 'fields' => ['by', 'w', 'h', 'mp', 'aspect'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How big can a 24 MP photo print at 300 PPI?', 'answer' => '20 × 13.33 in (50.8 × 33.87 cm).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="From" :options="['pixels' => 'Width and height in pixels', 'mp' => 'Megapixels and aspect ratio']" selected="pixels" />
        <div data-show-when="by:pixels">
            <x-calc.field name="w" label="Width (px)" value="6000" min="1" step="any" />
        </div>
        <div data-show-when="by:pixels">
            <x-calc.field name="h" label="Height (px)" value="4000" min="1" step="any" />
        </div>
        <div data-show-when="by:mp">
            <x-calc.field name="mp" label="Megapixels" value="24" min="0" step="any" />
        </div>
        <div data-show-when="by:mp">
            <x-calc.field name="aspect" label="Aspect ratio" value="3:2" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Megapixels" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'pixels', 'w' => 6000, 'h' => 4000, 'mp' => 24, 'aspect' => '3:2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dims' => ['label' => 'Pixel dimensions'],
            'print300' => ['label' => 'Print at 300 PPI (gallery)'],
            'print240' => ['label' => 'Print at 240 PPI'],
            'print150' => ['label' => 'Print at 150 PPI (posters)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
