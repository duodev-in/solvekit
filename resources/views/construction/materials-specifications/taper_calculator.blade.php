<x-calc.page
    title="Taper Calculator - SolveKit"
    description="Free taper calculator: taper per inch and per foot, included angle and compound setting from the large and small diameters and length."
    lede="Work out a taper and how to set it up."
    about="Taper per unit length = (D − d) ÷ L on the diameter; taper per foot is 12 times the taper per inch. The included angle is 2 × atan((D − d) ÷ 2L) and the lathe compound is set to half of it."
    :calc="['engine' => 'con-mech', 'tool' => 'taper', 'fields' => ['large', 'small', 'length'], 'unitFields' => ['large' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'small' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter both diameters', 'text' => 'And the length of the taper.'],
    ]"
    :faqs="[
        ['question' => 'What is taper per foot?', 'answer' => 'The change in diameter over 12 in of length.'],
        ['question' => 'What angle is a 1 in 20 taper?', 'answer' => '2.86° included.'],
        ['question' => 'What is a Morse taper?', 'answer' => 'About ⅝ in per foot, close to 1 : 20.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="large" label="Large diameter" value="1" min="0" placeholder="Large diameter">
            <label for="calc-large-unit" class="sr-only">Large diameter unit</label>
            <select id="calc-large-unit" name="large-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="small" label="Small diameter" value="0.75" min="0" placeholder="Small diameter">
            <label for="calc-small-unit" class="sr-only">Small diameter unit</label>
            <select id="calc-small-unit" name="small-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Length" value="4" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Taper per foot" />

    <x-calc.options :examples="[
        '1 → ¾ in over 4 in' => ['large' => 1, 'large-unit' => 'in', 'small' => 0.75, 'small-unit' => 'in', 'length' => 4, 'length-unit' => 'in'],
        '1 : 20, 50 mm' => ['large' => 25, 'large-unit' => 'mm', 'small' => 22.5, 'small-unit' => 'mm', 'length' => 50, 'length-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_inch' => ['label' => 'Per inch'],
            'included' => ['label' => 'Included angle'],
            'compound' => ['label' => 'Compound setting'],
            'ratio' => ['label' => 'Ratio'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>taper = (D − d) ÷ L</li>
            <li>included angle = 2 atan((D − d) ÷ 2L)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
