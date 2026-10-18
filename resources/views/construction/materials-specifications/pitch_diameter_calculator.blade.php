<x-calc.page
    title="Pitch Diameter Calculator - SolveKit"
    description="Free pitch diameter calculator: basic pitch diameter of 60° screw threads with three-wire measurement, or gear pitch diameter from module or diametral pitch."
    lede="Work out the pitch diameter of a thread or gear."
    about="For 60° unified and ISO metric threads the basic pitch diameter is d₂ = d − 0.649519 P (ASME B1.1, ISO 68-1). The best wire for three-wire measurement is 0.57735 P, and the reading over the wires is d₂ + 3W − 0.866025 P. For spur gears, pitch diameter = module × teeth = teeth ÷ diametral pitch."
    :calc="['engine' => 'con-mech', 'tool' => 'pitch_diameter', 'fields' => ['mode', 'major', 'pitch', 'pitch_kind', 'teeth', 'gear_system', 'module', 'dp'], 'unitFields' => ['major' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose thread or gear', 'text' => 'And enter its size.'],
    ]"
    :faqs="[
        ['question' => 'What is the pitch diameter of ½-13 UNC?', 'answer' => '0.4500 in (basic).'],
        ['question' => 'What is the pitch diameter of M10 × 1.5?', 'answer' => '9.026 mm (basic).'],
        ['question' => 'What is module?', 'answer' => 'Pitch diameter in mm ÷ number of teeth.'],
    ]"
>
    <x-calc.segmented name="mode" legend="For" :options="['thread' => 'Screw thread', 'gear' => 'Gear']" selected="thread" />

    <div data-show-when="mode:thread">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="major" label="Major diameter" value="0.5" min="0" placeholder="Major diameter">
                <label for="calc-major-unit" class="sr-only">Major diameter unit</label>
                <select id="calc-major-unit" name="major-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="pitch" label="Pitch" value="13" min="0" />
            <x-calc.select name="pitch_kind" label="Pitch as" :options="['tpi' => 'Threads per inch', 'mm' => 'mm per thread']" selected="tpi" />
        </div>
    </div>

    <div data-show-when="mode:gear" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="teeth" label="Teeth" value="30" min="1" step="1" />
            <x-calc.select name="gear_system" label="Tooth size by" :options="['module' => 'Module (mm)', 'dp' => 'Diametral pitch']" selected="module" />
            <x-calc.field name="module" label="Module" value="2" min="0" step="0.25" />
        </div>
    </div>

    <div data-show-when="mode:gear" hidden>
        <div data-show-when="gear_system:dp" hidden>
            <x-calc.field name="dp" label="Diametral pitch" value="10" min="0" />
        </div>
    </div>

    <x-calc.result label="Pitch diameter" />

    <x-calc.options :examples="[
        '½-13 UNC' => ['mode' => 'thread', 'major' => 0.5, 'major-unit' => 'in', 'pitch' => 13, 'pitch_kind' => 'tpi'],
        'M10 × 1.5' => ['mode' => 'thread', 'major' => 10, 'major-unit' => 'mm', 'pitch' => 1.5, 'pitch_kind' => 'mm'],
        'Gear, module 2, 30 teeth' => ['mode' => 'gear', 'teeth' => 30, 'gear_system' => 'module', 'module' => 2],
        'Gear, 10 DP, 40 teeth' => ['mode' => 'gear', 'teeth' => 40, 'gear_system' => 'dp', 'dp' => 10],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:thread">
            <x-calc.rows heading="Details" :rows="[
                'mm' => ['label' => 'Millimeters'],
                'minor' => ['label' => 'Minor diameter'],
                'wire' => ['label' => 'Best wire'],
                'over' => ['label' => 'Over three wires'],
            ]" />
        </div>
        <div data-show-when="mode:gear" hidden>
            <x-calc.rows heading="Details" :rows="[
                'outside' => ['label' => 'Outside diameter'],
                'root' => ['label' => 'Root diameter'],
                'circular' => ['label' => 'Circular pitch'],
                'inches' => ['label' => 'Inches'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d₂ = d − 0.649519 P</li>
            <li>best wire W = 0.57735 P</li>
            <li>M = d₂ + 3W − 0.866025 P</li>
            <li>gear: d = m z = z ÷ DP</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
