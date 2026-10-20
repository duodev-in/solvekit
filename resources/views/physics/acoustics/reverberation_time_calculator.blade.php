<x-calc.page
    title="Reverberation Time Calculator - SolveKit"
    description="Free reverberation time calculator: RT60 of a room from its size and surface materials, by Sabine and Eyring."
    lede="Find a room’s RT60."
    about="Reverberation time RT60 is how long sound takes to fade by 60 dB. Sabine’s formula 0.161V/A uses the room volume and its total absorption; Eyring’s is better for well-damped rooms. Absorption coefficients are typical published values."
    :calc="['engine' => 'ph-wave', 'tool' => 'reverberation', 'fields' => ['L', 'W', 'H', 'band', 'floor', 'ceiling', 'walls', 'glass', 'people', 'out'], 'unitFields' => ['L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'W' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'H' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'glass' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'speed', 'time', 'volume'])->all(), 'physics' => collect(config('physics_data'))->only(['absorption'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the RT60 of the example room at 500 Hz?', 'answer' => '2.15866 s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="L" label="Room length" value="8" placeholder="Room length">
            <label for="calc-L-unit" class="sr-only">Room length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="W" label="Room width" value="6" placeholder="Room width">
            <label for="calc-W-unit" class="sr-only">Room width unit</label>
            <select id="calc-W-unit" name="W-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="H" label="Room height" value="3" placeholder="Room height">
            <label for="calc-H-unit" class="sr-only">Room height unit</label>
            <select id="calc-H-unit" name="H-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="band" label="Frequency band" :options="['0' => '125 Hz', '1' => '250 Hz', '2' => '500 Hz', '3' => '1,000 Hz', '4' => '2,000 Hz', '5' => '4,000 Hz']" selected="2" />
        <x-calc.select name="floor" label="Floor" :options="['concrete' => 'Concrete, smooth unpainted', 'block_painted' => 'Concrete block, painted', 'brick' => 'Brick, unglazed', 'plaster' => 'Plaster on brick or block', 'gypsum' => 'Gypsum board on studs', 'glass' => 'Window glass', 'wood_floor' => 'Wood floor', 'wood_panel' => 'Wood panelling on battens', 'vinyl' => 'Vinyl or linoleum on concrete', 'carpet_concrete' => 'Carpet on concrete', 'carpet_pad' => 'Carpet on foam underlay', 'ceiling_tile' => 'Acoustic ceiling tile (suspended)', 'curtains' => 'Heavy curtains, pleated', 'fibreglass' => 'Fibreglass board, 50 mm', 'seats' => 'Upholstered seats (per m² of seating)', 'water' => 'Water surface (pool)']" selected="wood_floor" />
        <x-calc.select name="ceiling" label="Ceiling" :options="['concrete' => 'Concrete, smooth unpainted', 'block_painted' => 'Concrete block, painted', 'brick' => 'Brick, unglazed', 'plaster' => 'Plaster on brick or block', 'gypsum' => 'Gypsum board on studs', 'glass' => 'Window glass', 'wood_floor' => 'Wood floor', 'wood_panel' => 'Wood panelling on battens', 'vinyl' => 'Vinyl or linoleum on concrete', 'carpet_concrete' => 'Carpet on concrete', 'carpet_pad' => 'Carpet on foam underlay', 'ceiling_tile' => 'Acoustic ceiling tile (suspended)', 'curtains' => 'Heavy curtains, pleated', 'fibreglass' => 'Fibreglass board, 50 mm', 'seats' => 'Upholstered seats (per m² of seating)', 'water' => 'Water surface (pool)']" selected="plaster" />
        <x-calc.select name="walls" label="Walls" :options="['concrete' => 'Concrete, smooth unpainted', 'block_painted' => 'Concrete block, painted', 'brick' => 'Brick, unglazed', 'plaster' => 'Plaster on brick or block', 'gypsum' => 'Gypsum board on studs', 'glass' => 'Window glass', 'wood_floor' => 'Wood floor', 'wood_panel' => 'Wood panelling on battens', 'vinyl' => 'Vinyl or linoleum on concrete', 'carpet_concrete' => 'Carpet on concrete', 'carpet_pad' => 'Carpet on foam underlay', 'ceiling_tile' => 'Acoustic ceiling tile (suspended)', 'curtains' => 'Heavy curtains, pleated', 'fibreglass' => 'Fibreglass board, 50 mm', 'seats' => 'Upholstered seats (per m² of seating)', 'water' => 'Water surface (pool)']" selected="gypsum" />
        <x-calc.field name="glass" label="Window area (part of the walls)" value="6" min="0" placeholder="Window area (part of the walls)">
            <label for="calc-glass-unit" class="sr-only">Window area (part of the walls) unit</label>
            <select id="calc-glass-unit" name="glass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="people" label="People in the room" value="0" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="s" />
    </div>

    <x-calc.result label="Reverberation time RT60 (Sabine)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 's', 'L' => 8, 'L-unit' => 'm', 'W' => 6, 'W-unit' => 'm', 'H' => 3, 'H-unit' => 'm', 'band' => '2', 'floor' => 'wood_floor', 'ceiling' => 'plaster', 'walls' => 'gypsum', 'glass' => 6, 'glass-unit' => 'm2', 'people' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'eyring' => ['label' => 'Eyring RT60 (better for absorbent rooms)'],
            'A' => ['label' => 'Total absorption'],
            'V' => ['label' => 'Room volume'],
            'alpha' => ['label' => 'Average absorption coefficient'],
            'target' => ['label' => 'Typical targets'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
