<x-calc.page
    title="Color Converter - SolveKit"
    description="Free colour converter: HEX, RGB, HSL, HSV and CMYK, with contrast against white and black."
    lede="Convert colour codes."
    about="The same colour can be written in several models: hex and RGB for screens, HSL for design, CMYK for print."
    :calc="['engine' => 'tc-text', 'tool' => 'color', 'fields' => ['color'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is #3366CC in RGB?', 'answer' => 'rgb(51, 102, 204).'],
    ]"
>
    <x-calc.field name="color" label="Colour (#3366cc, rgb(51, 102, 204) or hsl(220, 60%, 50%))" value="#3366cc" type="text" inputmode="text" />

    <x-calc.result label="HEX" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['color' => '#3366cc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rgb' => ['label' => 'RGB'],
            'hsl' => ['label' => 'HSL'],
            'hsv' => ['label' => 'HSV / HSB'],
            'cmyk' => ['label' => 'CMYK'],
            'white' => ['label' => 'Contrast with white'],
            'black' => ['label' => 'Contrast with black'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
