<x-calc.page
    title="Concrete Block Fill Calculator - SolveKit"
    description="Free concrete block fill calculator: grout or concrete to fill the cores of a block wall, fully or at a cell spacing, from block size and shell thickness."
    lede="Work out the grout or concrete to fill block cores."
    about="Each standard two-core block's cores are its actual size less the two face shells and three webs. The defaults are the ASTM C90 minimum face shells (1 in for 6 in block, 1¼ in for 8 in, 1⅜ in for 10 in, 1½ in for 12 in) and 1 in webs; real cores taper and are a little smaller, so this errs on the side of enough grout. Measure your block for an exact figure."
    :calc="['engine' => 'con-concrete', 'tool' => 'block_fill', 'fields' => ['input', 'area', 'blocks', 'width', 'face_shell', 'web', 'fill', 'spacing', 'waste'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'face_shell' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'web' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'spacing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['bags' => config('construction_data.bags')]]"
    :how-to="[
        ['name' => 'Enter the wall area or blocks', 'text' => 'Area uses 1.125 blocks per ft².'],
        ['name' => 'Pick the block width', 'text' => 'And check the shell and web thickness.'],
        ['name' => 'Choose the fill', 'text' => 'Every core, or reinforced cells at a spacing.'],
    ]"
    :faqs="[
        ['question' => 'How much grout to fill an 8 in block?', 'answer' => 'About 0.30 ft³ per block with minimum shells, roughly 0.34 ft³ per ft² of wall.'],
        ['question' => 'What is partially grouted?', 'answer' => 'Only the reinforced cells are filled, for example every 48 in.'],
        ['question' => 'Can I use concrete instead of grout?', 'answer' => 'Codes call for grout to ASTM C476 in reinforced masonry; premix concrete is common in DIY non-structural walls.'],
    ]"
>
    <x-calc.segmented name="input" legend="From" :options="['area' => 'Wall area', 'blocks' => 'Number of blocks']" selected="area" />

    <div data-show-when="input:area">
        <x-calc.field name="area" label="Wall area" value="320" min="0" placeholder="Wall area">
            <label for="calc-area-unit" class="sr-only">Wall area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="input:blocks" hidden>
        <x-calc.field name="blocks" label="Blocks" value="360" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="width" label="Block width (nominal)" :options="['6' => '6 in', '8' => '8 in', '10' => '10 in', '12' => '12 in']" selected="8" />
        <x-calc.field name="face_shell" label="Face shell thickness" value="1.25" min="0" placeholder="Face shell thickness">
            <label for="calc-face_shell-unit" class="sr-only">Face shell thickness unit</label>
            <select id="calc-face_shell-unit" name="face_shell-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="web" label="Web thickness" value="1" min="0" placeholder="Web thickness">
            <label for="calc-web-unit" class="sr-only">Web thickness unit</label>
            <select id="calc-web-unit" name="web-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="fill" legend="Fill" :options="['all' => 'Every core (solid grouted)', 'spaced' => 'Cells at a spacing']" selected="all" />

    <div data-show-when="fill:spaced" hidden>
        <x-calc.field name="spacing" label="Grouted cell spacing" value="48" min="0" placeholder="Grouted cell spacing">
            <label for="calc-spacing-unit" class="sr-only">Grouted cell spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />

    <x-calc.result label="Grout or concrete fill" />

    <x-calc.options :examples="[
        '320 ft² of 8 in, solid' => ['input' => 'area', 'area' => 320, 'area-unit' => 'ft2', 'width' => '8', 'face_shell' => 1.25, 'face_shell-unit' => 'in', 'web' => 1, 'web-unit' => 'in', 'fill' => 'all', 'waste' => 10],
        '200 blocks of 12 in at 32 in' => ['input' => 'blocks', 'blocks' => 200, 'width' => '12', 'face_shell' => 1.5, 'face_shell-unit' => 'in', 'web' => 1, 'web-unit' => 'in', 'fill' => 'spaced', 'spacing' => 32, 'spacing-unit' => 'in', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'yd3' => ['label' => 'Cubic yards'],
            'bags_80' => ['label' => '80 lb bags'],
            'bags_60' => ['label' => '60 lb bags'],
            'bags_50' => ['label' => '50 lb bags'],
            'bags_40' => ['label' => '40 lb bags'],
            'per_block' => ['label' => 'Per block'],
            'per_ft2' => ['label' => 'Per ft² of wall'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>core = 2 × (W − 2 × shell) × ((15⅝ − 3 × web) ÷ 2) × 8 in</li>
            <li>cells grouted = 8 in ÷ spacing</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
