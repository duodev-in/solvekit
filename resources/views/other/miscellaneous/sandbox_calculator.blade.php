<x-calc.page
    title="Sandbox Calculator - SolveKit"
    description="Free sandbox calculator: sand volume, weight and bags for a sandbox of any shape."
    lede="Fill a sandbox."
    about="Sand needed = sandbox area × depth."
    :calc="['engine' => 'ot-misc', 'tool' => 'sandbox', 'fields' => ['shape', 'length', 'width', 'depth', 'bag'], 'unitFields' => ['length' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'width' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'depth' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'bag' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much sand for a 1.5 × 1.5 m box 25 cm deep?', 'answer' => '0.5625 m³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Shape" :options="['rect' => 'Rectangle', 'round' => 'Circle', 'hex' => 'Hexagon']" selected="rect" />
        <x-calc.field name="length" label="Length (or diameter, or side for a hexagon)" value="1.5" placeholder="Length (or diameter, or side for a hexagon)">
            <label for="calc-length-unit" class="sr-only">Length (or diameter, or side for a hexagon) unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="shape:rect">
            <x-calc.field name="width" label="Width (rectangle)" value="1.5" placeholder="Width (rectangle)">
                <label for="calc-width-unit" class="sr-only">Width (rectangle) unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="depth" label="Sand depth" value="25" placeholder="Sand depth">
            <label for="calc-depth-unit" class="sr-only">Sand depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="bag" label="Bag size" value="25" min="0" placeholder="Bag size">
            <label for="calc-bag-unit" class="sr-only">Bag size unit</label>
            <select id="calc-bag-unit" name="bag-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Sand needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['shape' => 'rect', 'length' => 1.5, 'length-unit' => 'm', 'width' => 1.5, 'width-unit' => 'm', 'depth' => 25, 'depth-unit' => 'cm', 'bag' => 25, 'bag-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'weight' => ['label' => 'Weight (dry play sand ≈ 1,600 kg/m³)'],
            'bags' => ['label' => 'Bags'],
            'area' => ['label' => 'Area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
