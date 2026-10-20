<x-calc.page
    title="Belt Length Calculator - SolveKit"
    description="Free belt length calculator: exact open or crossed belt length from pulley diameters and centre distance."
    lede="Find the belt length for two pulleys."
    about="An open belt wraps part of each pulley and runs straight between them. The exact length uses the wrap angles; the familiar approximation is close when the pulleys are similar in size."
    :calc="['engine' => 'ph-mach', 'tool' => 'belt_length', 'fields' => ['D1', 'D2', 'C', 'kind', 'out'], 'unitFields' => ['D1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'D2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'C' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What belt fits 200 and 100 mm pulleys 500 mm apart?', 'answer' => '1,476.24 mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="D1" label="Large pulley diameter" value="200" placeholder="Large pulley diameter">
            <label for="calc-D1-unit" class="sr-only">Large pulley diameter unit</label>
            <select id="calc-D1-unit" name="D1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="D2" label="Small pulley diameter" value="100" placeholder="Small pulley diameter">
            <label for="calc-D2-unit" class="sr-only">Small pulley diameter unit</label>
            <select id="calc-D2-unit" name="D2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="C" label="Centre distance" value="500" placeholder="Centre distance">
            <label for="calc-C-unit" class="sr-only">Centre distance unit</label>
            <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="kind" label="Belt" :options="['open' => 'Open belt', 'crossed' => 'Crossed belt']" selected="open" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
    </div>

    <x-calc.result label="Belt length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm', 'D1' => 200, 'D1-unit' => 'mm', 'D2' => 100, 'D2-unit' => 'mm', 'C' => 500, 'C-unit' => 'mm', 'kind' => 'open'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'approx' => ['label' => 'Common approximation'],
            'wrap' => ['label' => 'Wrap angle on the small pulley'],
            'ratio' => ['label' => 'Speed ratio'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
