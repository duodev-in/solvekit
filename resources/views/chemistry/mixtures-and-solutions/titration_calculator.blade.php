<x-calc.page
    title="Titration Calculator - SolveKit"
    description="Free titration calculator: unknown concentration from a titration, or the equivalence volume and full pH curve for an acid or base titrated with NaOH or HCl."
    lede="Find an unknown concentration, or plot a titration curve."
    about="From the end point, the analyte concentration is titrant moles ÷ moles of titrant per analyte ÷ analyte volume. For the curve, each point is solved exactly from the charge balance, so the equivalence pH, the half-equivalence pH (≈ pKa for a weak acid) and each step of a polyprotic acid show correctly. Acids are titrated with NaOH and bases with HCl."
    :calc="['engine' => 'chem-mix', 'tool' => 'titration', 'fields' => ['mode', 'choice', 'kind', 'strength', 'pkas', 'pkb', 'analyte_volume', 'titrant_concentration', 'analyte_concentration', 'titrant_volume', 'steps'], 'unitFields' => ['analyte_volume' => collect(config('units.volume'))->only(['ml', 'l'])->all(), 'titrant_volume' => collect(config('units.volume'))->only(['ml', 'l'])->all()], 'data' => ['acids' => config('chemistry_data.acids'), 'bases' => config('chemistry_data.bases')]]"
    :how-to="[
        ['name' => 'Pick the analyte', 'text' => 'Acids are titrated with NaOH, bases with HCl.'],
        ['name' => 'Curve mode', 'text' => 'Enter concentrations to see the pH curve.'],
        ['name' => 'Unknown mode', 'text' => 'Enter the end-point volume.'],
    ]"
    :faqs="[
        ['question' => 'What is the pH at the equivalence point?', 'answer' => '7 for strong acid with strong base; above 7 for a weak acid, below 7 for a weak base.'],
        ['question' => 'Why is half-equivalence pH equal to pKa?', 'answer' => 'There the acid and its conjugate base are equal.'],
        ['question' => 'How many end points does phosphoric acid have?', 'answer' => 'Three in theory; the third is too weak to see in water.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['curve' => 'Curve and equivalence', 'find' => 'Unknown concentration']" selected="curve" />

    <x-calc.select name="choice" label="Analyte" :options="collect(config('chemistry_data.acids'))->mapWithKeys(fn ($a, $k) => ['acid:'.$k => $a['name'].' ('.$a['formula'].')'])->merge(collect(config('chemistry_data.bases'))->mapWithKeys(fn ($b, $k) => ['base:'.$k => $b['name'].' ('.$b['formula'].')']))->put('custom', 'Custom acid or base')->all()" selected="acid:acetic_acid" />

    <div data-show-when="choice:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.segmented name="kind" legend="Type" :options="['acid' => 'Acid', 'base' => 'Base']" selected="acid" />
            <x-calc.segmented name="strength" legend="Strength" :options="['weak' => 'Weak', 'strong' => 'Strong']" selected="weak" />
        </div>
    </div>

    <div data-show-when="choice:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="pkas" label="pKa values (acid)" value="4.76" type="text" help="Comma separated for polyprotic acids" />
            <x-calc.field name="pkb" label="pKb (base)" value="4.75" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="analyte_volume" label="Analyte volume" value="25" min="0" placeholder="Analyte volume">
            <label for="calc-analyte_volume-unit" class="sr-only">Analyte volume unit</label>
            <select id="calc-analyte_volume-unit" name="analyte_volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="titrant_concentration" label="Titrant concentration" value="0.1" min="0" suffix="M" />
    </div>

    <div data-show-when="mode:curve">
        <x-calc.field name="analyte_concentration" label="Analyte concentration" value="0.1" min="0" suffix="M" />
    </div>

    <div data-show-when="mode:find" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="titrant_volume" label="Titrant at end point" value="22.4" min="0" placeholder="Titrant at end point">
                <label for="calc-titrant_volume-unit" class="sr-only">Titrant at end point unit</label>
                <select id="calc-titrant_volume-unit" name="titrant_volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="steps" label="Titrant per analyte" value="" min="1" step="1" help="e.g. 1 for the first end point" placeholder="All protons" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Acetic acid with NaOH' => ['mode' => 'curve', 'choice' => 'acid:acetic_acid', 'analyte_volume' => 25, 'analyte_volume-unit' => 'ml', 'titrant_concentration' => 0.1, 'analyte_concentration' => 0.1],
        'HCl with NaOH' => ['mode' => 'curve', 'choice' => 'acid:hydrochloric_acid', 'analyte_volume' => 25, 'analyte_volume-unit' => 'ml', 'titrant_concentration' => 0.1, 'analyte_concentration' => 0.1],
        'Ammonia with HCl' => ['mode' => 'curve', 'choice' => 'base:ammonia', 'analyte_volume' => 25, 'analyte_volume-unit' => 'ml', 'titrant_concentration' => 0.1, 'analyte_concentration' => 0.1],
        'Unknown HCl' => ['mode' => 'find', 'choice' => 'acid:hydrochloric_acid', 'analyte_volume' => 25, 'analyte_volume-unit' => 'ml', 'titrant_concentration' => 0.1, 'titrant_volume' => 22.4, 'titrant_volume-unit' => 'ml', 'steps' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Titration curve" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'equivalence' => ['label' => 'Equivalence volume'],
            'moles' => ['label' => 'Analyte'],
            'half' => ['label' => 'Half-equivalence'],
        ]" />
        <x-calc.quick-ref heading="pH at key volumes" name="points" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C analyte = C titrant × V titrant ÷ (ratio × V analyte)</li>
            <li>curve: exact charge balance at each volume</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
