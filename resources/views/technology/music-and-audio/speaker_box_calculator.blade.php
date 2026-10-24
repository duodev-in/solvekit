<x-calc.page
    title="Speaker Box Calculator - SolveKit"
    description="Free speaker box calculator: sealed or ported enclosure volume and tuning from Thiele–Small parameters."
    lede="Size a speaker box."
    about="A driver’s Thiele–Small parameters suggest the box volume and tuning that suit it."
    :calc="['engine' => 'tc-music', 'tool' => 'speaker_box', 'fields' => ['fs', 'qts', 'vas', 'type', 'qtc'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What ported box suits the example driver?', 'answer' => '79.34 L, tuned to Fb = 32.11 Hz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fs" label="Driver resonance Fs (Hz)" value="32" min="0" step="any" />
        <x-calc.field name="qts" label="Total Q (Qts)" value="0.38" min="0" step="any" />
        <x-calc.field name="vas" label="Equivalent volume Vas (litres)" value="85" min="0" step="any" />
        <x-calc.select name="type" label="Box" :options="['sealed' => 'Sealed', 'ported' => 'Ported (vented)']" selected="ported" />
        <div data-show-when="type:sealed">
            <x-calc.field name="qtc" label="Target Qtc (sealed; 0.707 = flattest)" value="0.707" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Box volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fs' => 32, 'qts' => 0.38, 'vas' => 85, 'type' => 'ported', 'qtc' => 0.707],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tuning' => ['label' => 'Tuning / resonance'],
            'f3' => ['label' => '−3 dB frequency'],
            'ebp' => ['label' => 'Efficiency bandwidth product (Fs ÷ Qes ≈ Fs ÷ Qts)'],
            'advice' => ['label' => 'Suits'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
