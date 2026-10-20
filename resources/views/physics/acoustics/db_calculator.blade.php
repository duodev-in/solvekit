<x-calc.page
    title="dB Calculator - SolveKit"
    description="Free decibel calculator: decibels from power or amplitude ratios, ratios from decibels, and adding sound levels."
    lede="Work with decibels."
    about="Decibels are a log scale: 10 log₁₀ for power ratios and 20 log₁₀ for amplitude ratios. Sound levels add on an energy basis, so two 80 dB sources make 83 dB, not 160."
    :calc="['engine' => 'ph-wave', 'tool' => 'db', 'fields' => ['mode', 'ratio', 'dB', 'levels'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many dB is a power ratio of 100?', 'answer' => '20 dB.'],
        ['question' => 'What is 80 + 80 + 75 dB?', 'answer' => '83.648 dB.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Calculate" :options="['power' => 'Decibels from a power ratio', 'amp' => 'Decibels from an amplitude ratio', 'back' => 'Ratios from decibels', 'add' => 'Add sound levels']" selected="power" />
        <div data-show-when="mode:power,amp">
            <x-calc.field name="ratio" label="Ratio" value="100" min="0" step="any" />
        </div>
        <div data-show-when="mode:back">
            <x-calc.field name="dB" label="Decibels" value="3" step="any" />
        </div>
        <div data-show-when="mode:add">
            <x-calc.textarea name="levels" label="Levels in dB (one per line or comma separated)" value="80, 80, 75" rows="3" />
        </div>
    </div>

    <x-calc.result label="Decibels" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'power', 'ratio' => 100, 'dB' => 3, 'levels' => '80, 80, 75'],
        'Add levels' => ['mode' => 'add', 'ratio' => 100, 'dB' => 3, 'levels' => '80, 80, 75'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'Power ratio'],
            'a' => ['label' => 'Amplitude ratio'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
