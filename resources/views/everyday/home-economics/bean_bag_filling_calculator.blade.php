<x-calc.page
    title="Bean Bag Filling Calculator - SolveKit"
    description="Free bean bag filling calculator: liters or cubic feet of beads to fill a round, cylinder or cube bean bag, and how many bags of filling to buy."
    lede="Work out how much filling a bean bag needs."
    about="Filling = the bag's volume × how full you want it. A sphere holds 4/3 π r³, a cylinder π r² h and a cube or box length × width × height. Most bean bags are filled 70–85% so they shape around you; EPS bead bags are sold by liters or cubic feet."
    :calc="['engine' => 'ev-home', 'tool' => 'bean_bag', 'fields' => ['shape', 'diameter', 'length', 'width', 'height', 'fill', 'bag'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the shape', 'text' => 'And enter its size.'],
        ['name' => 'Set the fill level', 'text' => 'And the size of filling bags.'],
    ]"
    :faqs="[
        ['question' => 'How much filling for a 3 ft round bean bag?', 'answer' => 'About 320 liters (11.3 ft³) at 80% full.'],
        ['question' => 'Why not fill it all the way?', 'answer' => 'A fuller bag is firm and less comfortable.'],
        ['question' => 'How many liters in a cubic foot?', 'answer' => 'About 28.3.'],
    ]"
>
    <x-calc.segmented name="shape" legend="Shape" :options="['sphere' => 'Round', 'cylinder' => 'Cylinder', 'box' => 'Cube or box']" selected="sphere" />

    <div data-show-when="shape:sphere,cylinder">
        <x-calc.field name="diameter" label="Diameter" value="3" min="0" placeholder="Diameter">
            <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="shape:box" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="length" label="Length" value="3" min="0" placeholder="Length">
                <label for="calc-length-unit" class="sr-only">Length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="width" label="Width" value="3" min="0" placeholder="Width">
                <label for="calc-width-unit" class="sr-only">Width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="shape:cylinder,box" hidden>
        <x-calc.field name="height" label="Height" value="2" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fill" label="Fill level" value="80" min="10" max="100" step="5" suffix="%" />
        <x-calc.field name="bag" label="Filling bag size (optional)" value="100" min="1" suffix="L" />
    </div>

    <x-calc.result label="Filling needed" />

    <x-calc.options :examples="[
        '3 ft round' => ['shape' => 'sphere', 'diameter' => 3, 'diameter-unit' => 'ft', 'length' => '', 'length-unit' => 'ft', 'width' => '', 'width-unit' => 'ft', 'height' => '', 'height-unit' => 'ft', 'fill' => 80, 'bag' => 100],
        'Cube 70 cm' => ['shape' => 'box', 'diameter' => '', 'diameter-unit' => 'ft', 'length' => 70, 'length-unit' => 'cm', 'width' => 70, 'width-unit' => 'cm', 'height' => 70, 'height-unit' => 'cm', 'fill' => 75, 'bag' => 100],
        'Floor cylinder' => ['shape' => 'cylinder', 'diameter' => 4, 'diameter-unit' => 'ft', 'length' => '', 'length-unit' => 'ft', 'width' => '', 'width-unit' => 'ft', 'height' => 1.5, 'height-unit' => 'ft', 'fill' => 85, 'bag' => 200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ft3' => ['label' => 'In ft³'],
            'bags' => ['label' => 'Bags to buy'],
            'note' => ['label' => 'Tip'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sphere 4/3 π r³; cylinder π r² h; box L × W × H</li>
            <li>filling = volume × fill %</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
