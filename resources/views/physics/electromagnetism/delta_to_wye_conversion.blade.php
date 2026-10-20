<x-calc.page
    title="Delta to Wye Conversion - SolveKit"
    description="Free delta to wye converter: convert resistor networks between Δ (pi) and Y (star) forms, both ways."
    lede="Convert Δ and Y networks."
    about="Any three-terminal resistor triangle can be replaced by an equivalent star and vice versa. It is the key step for bridges that are not series or parallel."
    :calc="['engine' => 'ph-em', 'tool' => 'delta_wye', 'fields' => ['dir', 'a', 'b', 'c'], 'unitFields' => ['a' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'b' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'c' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What wye matches a 30–60–90 Ω delta?', 'answer' => '30, 15, 10 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="dir" label="Convert" :options="['dy' => 'Delta (Δ) to wye (Y)', 'yd' => 'Wye (Y) to delta (Δ)']" selected="dy" />
        <x-calc.field name="a" label="R_a (Δ: between nodes 2–3; Y: arm at node 1)" value="30" min="0" placeholder="R_a (Δ: between nodes 2–3; Y: arm at node 1)">
            <label for="calc-a-unit" class="sr-only">R_a (Δ: between nodes 2–3; Y: arm at node 1) unit</label>
            <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="b" label="R_b (Δ: between nodes 1–3; Y: arm at node 2)" value="60" min="0" placeholder="R_b (Δ: between nodes 1–3; Y: arm at node 2)">
            <label for="calc-b-unit" class="sr-only">R_b (Δ: between nodes 1–3; Y: arm at node 2) unit</label>
            <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="c" label="R_c (Δ: between nodes 1–2; Y: arm at node 3)" value="90" min="0" placeholder="R_c (Δ: between nodes 1–2; Y: arm at node 3)">
            <label for="calc-c-unit" class="sr-only">R_c (Δ: between nodes 1–2; Y: arm at node 3) unit</label>
            <select id="calc-c-unit" name="c-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Equivalent values" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'dy', 'a' => 30, 'a-unit' => 'ohm', 'b' => 60, 'b-unit' => 'ohm', 'c' => 90, 'c-unit' => 'ohm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'r1' => ['label' => 'First'],
            'r2' => ['label' => 'Second'],
            'r3' => ['label' => 'Third'],
            'check' => ['label' => 'Balanced case'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
