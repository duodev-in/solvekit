<x-calc.page
    title="Screen Size Calculator - SolveKit"
    description="Free screen size calculator: width and height of a screen from its diagonal and aspect ratio."
    lede="Find a screen’s width and height."
    about="Screens are sold by their diagonal; the width and height follow from the aspect ratio."
    :calc="['engine' => 'tc-photo', 'tool' => 'screen_size', 'fields' => ['diag', 'aspect'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How wide is a 55″ 16:9 TV?', 'answer' => '47.94 × 26.96 in.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="diag" label="Diagonal (inches)" value="55" min="0" step="any" />
        <x-calc.field name="aspect" label="Aspect ratio" value="16:9" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Width × height" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['diag' => 55, 'aspect' => '16:9'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cm' => ['label' => 'In centimetres'],
            'area' => ['label' => 'Screen area'],
            'compare' => ['label' => 'Equal-height 4:3 screen'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
