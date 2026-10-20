<x-calc.page
    title="Vertical Jump Calculator - SolveKit"
    description="Free vertical jump calculator: jump height from hang time and peak power from the Sayers equation."
    lede="Find jump height and power."
    about="Hang time gives jump height (h = gt²/8), and the Sayers equation turns height and body mass into peak leg power."
    :calc="['engine' => 'sp-fit', 'tool' => 'vertical_jump', 'fields' => ['by', 'h', 't', 'm', 'out'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'short_time', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What power does a 50 cm jump at 75 kg mean?', 'answer' => '4,378 W (58.4 W/kg).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="I know" :options="['h' => 'Jump height', 't' => 'Hang time']" selected="h" />
        <div data-show-when="by:h">
            <x-calc.field name="h" label="Jump height" value="50" placeholder="Jump height">
                <label for="calc-h-unit" class="sr-only">Jump height unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="by:t">
            <x-calc.field name="t" label="Hang time" value="640" min="0" placeholder="Hang time">
                <label for="calc-t-unit" class="sr-only">Hang time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="m" label="Body mass" value="75" min="0" placeholder="Body mass">
            <label for="calc-m-unit" class="sr-only">Body mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
    </div>

    <x-calc.result label="Jump height" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cm', 'by' => 'h', 'h' => 50, 'h-unit' => 'cm', 't' => 640, 't-unit' => 'ms', 'm' => 75, 'm-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'power' => ['label' => 'Peak power (Sayers)'],
            'v' => ['label' => 'Take-off speed'],
            'hang' => ['label' => 'Hang time'],
            'band' => ['label' => 'Rating'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
