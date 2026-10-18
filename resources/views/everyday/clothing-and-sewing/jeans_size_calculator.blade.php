<x-calc.page
    title="Jeans Size Calculator - SolveKit"
    description="Free jeans size calculator: your jeans size in waist and inseam (W × L) from body measurements, in inches and centimeters."
    lede="Find your jeans size from your waist and inseam."
    about="Men's jeans are sized by waist (W) and inseam length (L) in inches. Measure your waist where you wear your jeans and your inseam from crotch to ankle. Many brands cut waists 1–2 inches larger than the label (vanity sizing) and women's numeric sizes follow no common standard, so try on."
    :calc="['engine' => 'ev-clothing', 'tool' => 'jeans', 'fields' => ['waist', 'inseam'], 'unitFields' => ['waist' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'inseam' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure waist and inseam', 'text' => 'Or measure jeans that fit.'],
    ]"
    :faqs="[
        ['question' => 'What jeans size is a 33 in waist and 32 in inseam?', 'answer' => 'W33 L32.'],
        ['question' => 'What is inseam?', 'answer' => 'The inside leg length from crotch to hem.'],
        ['question' => 'Why do my jeans fit differently by brand?', 'answer' => 'Brands cut waists differently.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waist" label="Waist (where you wear jeans)" value="33" min="0" placeholder="Waist (where you wear jeans)">
            <label for="calc-waist-unit" class="sr-only">Waist (where you wear jeans) unit</label>
            <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="inseam" label="Inseam" value="32" min="0" placeholder="Inseam">
            <label for="calc-inseam-unit" class="sr-only">Inseam unit</label>
            <select id="calc-inseam-unit" name="inseam-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Jeans size" />

    <x-calc.options :decimals="false" :examples="[
        '33 × 32 in' => ['waist' => 33, 'waist-unit' => 'in', 'inseam' => 32, 'inseam-unit' => 'in'],
        '86 × 81 cm' => ['waist' => 86, 'waist-unit' => 'cm', 'inseam' => 81, 'inseam-unit' => 'cm'],
        'Tall 36 × 35' => ['waist' => 36, 'waist-unit' => 'in', 'inseam' => 35, 'inseam-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cm' => ['label' => 'In cm'],
            'note' => ['label' => 'Fit'],
            'inseam' => ['label' => 'Inseam'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>W = waist (in), L = inseam (in)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
