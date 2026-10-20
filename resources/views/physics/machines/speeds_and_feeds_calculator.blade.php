<x-calc.page
    title="Speeds and Feeds Calculator - SolveKit"
    description="Free speeds and feeds calculator: spindle rpm and feed rate for milling and drilling from material, tool and chip load."
    lede="Find spindle speed and feed."
    about="Cutting speed (surface feet per minute) depends on the material and the tool. rpm = SFM × 12/(πD) and feed = rpm × flutes × chip load. Values are starting points."
    :calc="['engine' => 'ph-mach', 'tool' => 'speeds_feeds', 'fields' => ['work', 'tool', 'D', 'z', 'cl'], 'unitFields' => ['D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'cl' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['cutting'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What rpm for a ½ in carbide end mill in aluminium?', 'answer' => '6,875 rpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="work" label="Workpiece material" :options="['aluminium' => 'Aluminium alloys', 'brass' => 'Brass and bronze', 'mild_steel' => 'Mild steel (1018)', 'alloy_steel' => 'Alloy steel (4140, annealed)', 'stainless' => 'Stainless steel (304)', 'cast_iron' => 'Grey cast iron', 'titanium' => 'Titanium alloys', 'plastic' => 'Plastics (acrylic, nylon, acetal)']" selected="aluminium" />
        <x-calc.select name="tool" label="Tool material" :options="['0' => 'High-speed steel', '1' => 'Carbide']" selected="1" />
        <x-calc.field name="D" label="Cutter diameter" value="0.5" placeholder="Cutter diameter">
            <label for="calc-D-unit" class="sr-only">Cutter diameter unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="z" label="Number of flutes" value="3" min="1" step="any" />
        <x-calc.field name="cl" label="Chip load per tooth" value="0.002" placeholder="Chip load per tooth">
            <label for="calc-cl-unit" class="sr-only">Chip load per tooth unit</label>
            <select id="calc-cl-unit" name="cl-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Spindle speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['work' => 'aluminium', 'tool' => '1', 'D' => 0.5, 'D-unit' => 'in', 'z' => 3, 'cl' => 0.002, 'cl-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'feed' => ['label' => 'Feed rate'],
            'sfm' => ['label' => 'Cutting speed used'],
            'note' => ['label' => 'Chip load guide'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
