<x-calc.page
    title="Resolution Scale Calculator - SolveKit"
    description="Free resolution scale calculator: scaled resolution and pixel count for a render or video scale."
    lede="Scale a resolution."
    about="Scaling a resolution multiplies each side; the pixel count changes with the square."
    :calc="['engine' => 'tc-photo', 'tool' => 'res_scale', 'fields' => ['w', 'h', 'scale'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is 67% of 4K?', 'answer' => '2,573 × 1,447.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Width (px)" value="3840" min="1" step="any" />
        <x-calc.field name="h" label="Height (px)" value="2160" min="1" step="any" />
        <x-calc.field name="scale" label="Scale (%)" value="67" min="0" step="any" />
    </div>

    <x-calc.result label="Scaled resolution" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 3840, 'h' => 2160, 'scale' => 67],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pixels' => ['label' => 'Pixel count'],
            'change' => ['label' => 'Change in pixel count'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
