<x-calc.page
    title="PPI Calculator (Pixels Per Inch) - SolveKit"
    description="Free PPI calculator: pixel density of a screen from its resolution and diagonal, with dot pitch."
    lede="Find a screen’s pixel density."
    about="Pixel density is the number of pixels along each inch of the screen."
    :calc="['engine' => 'tc-photo', 'tool' => 'ppi', 'fields' => ['w', 'h', 'diag'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the PPI of a 27″ 1440p monitor?', 'answer' => '108.79 PPI.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Horizontal resolution (px)" value="2560" min="1" step="any" />
        <x-calc.field name="h" label="Vertical resolution (px)" value="1440" min="1" step="any" />
        <x-calc.field name="diag" label="Diagonal size (inches)" value="27" min="0" step="any" />
    </div>

    <x-calc.result label="Pixel density" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 2560, 'h' => 1440, 'diag' => 27],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pitch' => ['label' => 'Dot pitch'],
            'size' => ['label' => 'Screen width × height'],
            'retina' => ['label' => 'Pixels blend at about'],
            'total' => ['label' => 'Total pixels'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
