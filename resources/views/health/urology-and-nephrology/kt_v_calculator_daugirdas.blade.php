<x-calc.page
    title="Kt/V Calculator Daugirdas - SolveKit"
    description="Free Kt/V calculator: single-pool Kt/V for haemodialysis adequacy by the Daugirdas second-generation formula, with the urea reduction ratio."
    lede="Calculate dialysis Kt/V."
    about="Daugirdas (1993): spKt/V = −ln(R − 0.008 × t) + (4 − 3.5 × R) × UF ÷ W, where R is post- ÷ pre-dialysis urea, t the session hours, UF the litres removed and W the post-dialysis weight. KDOQI (2015) targets spKt/V of 1.4 per session for thrice-weekly dialysis, with 1.2 as the minimum. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'ktv', 'fields' => ['pre', 'post', 'hours', 'uf', 'weight'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter pre- and post-dialysis urea', 'text' => 'Same unit for both.'],
        ['name' => 'Enter hours, fluid removed and post weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the Kt/V for urea 60 → 18 over 4 hours with 2.5 L removed at 70 kg?', 'answer' => '1.42 (At or above the 1.4 target (KDOQI 2015, thrice weekly)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pre" label="Pre-dialysis urea" value="60" min="0" step="any" />
        <x-calc.field name="post" label="Post-dialysis urea" value="18" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="hours" label="Session length" value="4" min="0" step="any" suffix="h" />
        <x-calc.field name="uf" label="Fluid removed" value="2.5" min="0" step="any" suffix="L" />
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Single-pool Kt/V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pre' => 60, 'post' => 18, 'hours' => 4, 'uf' => 2.5, 'weight' => 70, 'weight-unit' => 'kg'],
        'Low dose' => ['pre' => 70, 'post' => 32, 'hours' => 3.5, 'uf' => 2, 'weight' => 80, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'urr' => ['label' => 'URR'],
            'formula' => ['label' => 'Formula'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Kt/V = −ln(R − 0.008t) + (4 − 3.5R) × UF ÷ W</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
