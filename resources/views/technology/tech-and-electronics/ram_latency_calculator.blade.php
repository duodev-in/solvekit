<x-calc.page
    title="RAM Latency Calculator - SolveKit"
    description="Free RAM latency calculator: true latency in nanoseconds from data rate (MT/s) and CAS latency."
    lede="Compare memory latency."
    about="CAS latency counts clock cycles; the true delay also depends on the memory speed."
    :calc="['engine' => 'tc-elec', 'tool' => 'ram_latency', 'fields' => ['mts', 'cl'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the latency of DDR5-6000 CL30?', 'answer' => '10 ns.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mts" label="Data rate (MT/s, e.g. DDR5-6000)" value="6000" min="1" step="any" />
        <x-calc.field name="cl" label="CAS latency (CL)" value="30" min="1" step="any" />
    </div>

    <x-calc.result label="First-word latency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mts' => 6000, 'cl' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'clock' => ['label' => 'I/O clock'],
            'cycle' => ['label' => 'Clock period'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Common kits" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
