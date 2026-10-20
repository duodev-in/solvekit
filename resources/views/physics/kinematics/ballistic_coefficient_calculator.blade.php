<x-calc.page
    title="Ballistic Coefficient Calculator - SolveKit"
    description="Free ballistic coefficient calculator: G1 BC from bullet weight, diameter and form factor, with sectional density."
    lede="Work out a bullet’s ballistic coefficient."
    about="The ballistic coefficient (BC) says how well a bullet keeps its speed against air drag compared with a standard G1 projectile. It is the sectional density (weight ÷ diameter², in pounds and inches) divided by the form factor i, which is about 1 for the standard shape and lower for sleek boat-tail bullets."
    :calc="['engine' => 'ph-mech', 'tool' => 'ballistic_coefficient', 'fields' => ['m', 'd', 'i'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the BC of a 168-grain .308 bullet with i = 0.55?', 'answer' => '0.459989 lb/in².'],
        ['question' => 'What is a good BC?', 'answer' => 'Hunting bullets are typically 0.3–0.5 (G1); long-range match bullets reach 0.6–0.7. Higher means less drop and drift.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Bullet mass" value="168" min="0" placeholder="Bullet mass">
            <label for="calc-m-unit" class="sr-only">Bullet mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gr')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Bullet diameter" value="0.308" placeholder="Bullet diameter">
            <label for="calc-d-unit" class="sr-only">Bullet diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="i" label="Form factor i (G1; about 0.5–0.6 for boat-tail match bullets)" value="0.55" min="0" step="any" />
    </div>

    <x-calc.result label="Ballistic coefficient (G1)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['m' => 168, 'm-unit' => 'gr', 'd' => 0.308, 'd-unit' => 'in', 'i' => 0.55],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sd' => ['label' => 'Sectional density'],
            'si' => ['label' => 'In SI units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
