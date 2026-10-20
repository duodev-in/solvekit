<x-calc.page
    title="Flat vs. Round Earth Calculator - SolveKit"
    description="Free flat vs round Earth calculator: how much of a distant object a globe hides, and what a flat Earth would predict."
    lede="Compare a globe with a flat Earth."
    about="On a globe, distant objects sink below the horizon from the bottom up; on a flat plane they would only shrink. Measuring hidden height is a classic test."
    :calc="['engine' => 'ph-quantum', 'tool' => 'flat_round', 'fields' => ['h', 'd', 'H', 'refr'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'H' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much of a 100 m tower 30 km away is hidden?', 'answer' => '41.28 m on a globe; none on a flat Earth.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="h" label="Your eye height" value="2" placeholder="Your eye height">
            <label for="calc-h-unit" class="sr-only">Your eye height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Distance to the object" value="30" placeholder="Distance to the object">
            <label for="calc-d-unit" class="sr-only">Distance to the object unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="H" label="Object height" value="100" placeholder="Object height">
            <label for="calc-H-unit" class="sr-only">Object height unit</label>
            <select id="calc-H-unit" name="H-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="refr" label="Refraction" :options="['none' => 'None', 'standard' => 'Standard (k = 0.13)']" selected="standard" />
    </div>

    <x-calc.result label="Hidden height on a round Earth" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['h' => 2, 'h-unit' => 'm', 'd' => 30, 'd-unit' => 'km', 'H' => 100, 'H-unit' => 'm', 'refr' => 'standard'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'flat' => ['label' => 'On a flat Earth'],
            'visible' => ['label' => 'Visible part on a globe'],
            'horizon' => ['label' => 'Your horizon'],
            'angle' => ['label' => 'Angular height of the visible part'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
