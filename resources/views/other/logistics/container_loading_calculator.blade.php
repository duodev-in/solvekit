<x-calc.page
    title="Container Loading Calculator - SolveKit"
    description="Free container loading calculator: how many cartons fit in a 20 ft, 40 ft or 40 ft High Cube container."
    lede="Load a container."
    about="The number of cartons depends on how their sides divide into the container’s inside dimensions."
    :calc="['engine' => 'ot-misc', 'tool' => 'container_loading', 'fields' => ['container', 'cl', 'cw', 'ch', 'l', 'w', 'h', 'weight', 'rotate'], 'unitFields' => ['cl' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'cw' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'ch' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'l' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'w' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass'])->all(), 'other' => collect(config('other_data'))->only(['containers'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many 60 × 40 × 35 cm cartons fit in a 20 ft container?', 'answer' => '270.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="container" label="Container" :options="['20' => '20 ft standard', '40' => '40 ft standard', '40hc' => '40 ft High Cube', 'custom' => 'Other (enter the value)']" selected="20" />
        <div data-show-when="container:custom">
            <x-calc.field name="cl" label="Container inside length (custom)" value="590" placeholder="Container inside length (custom)">
                <label for="calc-cl-unit" class="sr-only">Container inside length (custom) unit</label>
                <select id="calc-cl-unit" name="cl-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="container:custom">
            <x-calc.field name="cw" label="Inside width (custom)" value="235" placeholder="Inside width (custom)">
                <label for="calc-cw-unit" class="sr-only">Inside width (custom) unit</label>
                <select id="calc-cw-unit" name="cw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="container:custom">
            <x-calc.field name="ch" label="Inside height (custom)" value="239" placeholder="Inside height (custom)">
                <label for="calc-ch-unit" class="sr-only">Inside height (custom) unit</label>
                <select id="calc-ch-unit" name="ch-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="l" label="Carton length" value="60" placeholder="Carton length">
            <label for="calc-l-unit" class="sr-only">Carton length unit</label>
            <select id="calc-l-unit" name="l-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="w" label="Carton width" value="40" placeholder="Carton width">
            <label for="calc-w-unit" class="sr-only">Carton width unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Carton height" value="35" placeholder="Carton height">
            <label for="calc-h-unit" class="sr-only">Carton height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Carton weight" value="18" min="0" placeholder="Carton weight">
            <label for="calc-weight-unit" class="sr-only">Carton weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="rotate" label="Cartons may lie on any side?" :options="['no' => 'No (this side up)', 'yes' => 'Yes']" selected="no" />
    </div>

    <x-calc.result label="Cartons that fit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['container' => '20', 'cl' => 590, 'cl-unit' => 'cm', 'cw' => 235, 'cw-unit' => 'cm', 'ch' => 239, 'ch-unit' => 'cm', 'l' => 60, 'l-unit' => 'cm', 'w' => 40, 'w-unit' => 'cm', 'h' => 35, 'h-unit' => 'cm', 'weight' => 18, 'weight-unit' => 'kg', 'rotate' => 'no'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'layout' => ['label' => 'Layout (length × width × height)'],
            'fill' => ['label' => 'Volume used'],
            'weight' => ['label' => 'Load weight'],
            'payload' => ['label' => 'Payload check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
