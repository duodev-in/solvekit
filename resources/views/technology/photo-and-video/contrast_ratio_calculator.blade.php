<x-calc.page
    title="Contrast Ratio Calculator - SolveKit"
    description="Free contrast ratio calculator: WCAG contrast between text and background colours, with AA and AAA checks."
    lede="Check colour contrast."
    about="Text needs enough contrast against its background to be readable; WCAG sets the minimums."
    :calc="['engine' => 'tc-photo', 'tool' => 'contrast_ratio', 'fields' => ['fg', 'bg'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Does #767676 on white pass WCAG AA?', 'answer' => 'Yes, just: 4.54:1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fg" label="Text colour" value="#767676" type="text" inputmode="text" />
        <x-calc.field name="bg" label="Background colour" value="#ffffff" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Contrast ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fg' => '#767676', 'bg' => '#ffffff'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'aa' => ['label' => 'WCAG AA normal text (4.5:1)'],
            'aaLarge' => ['label' => 'WCAG AA large text (3:1)'],
            'aaa' => ['label' => 'WCAG AAA normal text (7:1)'],
            'ui' => ['label' => 'UI components and graphics (3:1)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
