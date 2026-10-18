<x-calc.page
    title="Jacket Size Calculator - SolveKit"
    description="Free jacket size calculator: men's suit jacket size from chest measurement and height, with the European size and short, regular or long length."
    lede="Find your suit jacket size."
    about="A men's suit jacket size is the chest circumference in inches, usually in even numbers (40, 42), with a length letter from height: short under about 5′7″, regular 5′8″–5′11″, long 6′0″–6′3″, extra long above. European sizes are about half the chest in centimeters (US 40 = EU 50). Fit varies by brand and cut."
    :calc="['engine' => 'ev-clothing', 'tool' => 'jacket', 'fields' => ['chest', 'height', 'sleeve'], 'unitFields' => ['chest' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'sleeve' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure your chest', 'text' => 'Under the arms, at the fullest part.'],
        ['name' => 'Enter your height', 'text' => 'For the length.'],
    ]"
    :faqs="[
        ['question' => 'What jacket size for a 40 in chest and 5′10″?', 'answer' => '40R (EU 50).'],
        ['question' => 'What does R mean?', 'answer' => 'Regular length.'],
        ['question' => 'How should a jacket sleeve fit?', 'answer' => 'Showing about ¼–½ in of shirt cuff.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="chest" label="Chest (under the arms)" value="40" min="0" placeholder="Chest (under the arms)">
            <label for="calc-chest-unit" class="sr-only">Chest (under the arms) unit</label>
            <select id="calc-chest-unit" name="chest-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="70" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sleeve" label="Sleeve (optional)" value="25" min="0" placeholder="Sleeve (optional)">
            <label for="calc-sleeve-unit" class="sr-only">Sleeve (optional) unit</label>
            <select id="calc-sleeve-unit" name="sleeve-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Suit jacket size (US/UK)" />

    <x-calc.options :decimals="false" :examples="[
        '40 in, 5′10″' => ['chest' => 40, 'chest-unit' => 'in', 'height' => 70, 'height-unit' => 'in', 'sleeve' => 25, 'sleeve-unit' => 'in'],
        '106 cm, 188 cm' => ['chest' => 106, 'chest-unit' => 'cm', 'height' => 188, 'height-unit' => 'cm', 'sleeve' => '', 'sleeve-unit' => 'cm'],
        '38 in, 5′6″' => ['chest' => 38, 'chest-unit' => 'in', 'height' => 66, 'height-unit' => 'in', 'sleeve' => '', 'sleeve-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'eu' => ['label' => 'European size'],
            'length' => ['label' => 'Length'],
            'sleeve' => ['label' => 'Sleeve'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>size = chest in inches (even)</li>
            <li>EU ≈ size + 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
