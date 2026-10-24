<x-calc.page
    title="eDPI Calculator - SolveKit"
    description="Free eDPI calculator: effective DPI from mouse DPI and in-game sensitivity, with cm per 360° for CS2, Valorant and Overwatch 2."
    lede="Find your eDPI."
    about="eDPI multiplies mouse DPI by in-game sensitivity so players with different settings can compare."
    :calc="['engine' => 'tc-elec', 'tool' => 'edpi', 'fields' => ['dpi', 'sens', 'game'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the eDPI at 800 DPI and 1.5 sensitivity?', 'answer' => '1,200.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dpi" label="Mouse DPI (CPI)" value="800" min="1" step="any" />
        <x-calc.field name="sens" label="In-game sensitivity" value="1.5" min="0" step="any" />
        <x-calc.select name="game" label="Game (for cm/360°)" :options="['none' => 'Other', 'cs' => 'Counter-Strike 2 / Apex (yaw 0.022)', 'val' => 'Valorant (yaw 0.07)', 'ow' => 'Overwatch 2 (yaw 0.0066)']" selected="cs" />
    </div>

    <x-calc.result label="eDPI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dpi' => 800, 'sens' => 1.5, 'game' => 'cs'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cm360' => ['label' => 'Distance for a 360° turn'],
            'in360' => ['label' => 'In inches'],
            'note' => ['label' => 'Typical eDPI'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
