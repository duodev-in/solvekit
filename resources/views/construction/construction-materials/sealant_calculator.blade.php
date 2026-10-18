<x-calc.page
    title="Sealant Calculator - SolveKit"
    description="Free sealant and caulk calculator: cartridges of sealant for a joint from its width, depth and length."
    lede="Work out how many caulk or sealant cartridges a joint needs."
    about="Sealant volume = joint width × depth × length (half that for a triangular fillet bead). A 10.1 fl oz cartridge holds 299 mL. For moving joints, ASTM C1193 guidance is a depth about half the width (between ¼ and ½ in), set on a backer rod."
    :calc="['engine' => 'con-finish', 'tool' => 'sealant', 'fields' => ['width', 'depth', 'length', 'profile', 'cartridge', 'waste'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cartridge' => collect(config('units.volume'))->only(['floz_us', 'ml', 'l'])->all()]]"
    :how-to="[
        ['name' => 'Enter the joint size', 'text' => 'Width, depth and total length.'],
        ['name' => 'Choose the cartridge', 'text' => 'Its volume.'],
    ]"
    :faqs="[
        ['question' => 'How far does a tube of caulk go?', 'answer' => 'A 10.1 fl oz tube runs about 16 ft of ⅜ × ¼ in joint.'],
        ['question' => 'How deep should a sealant joint be?', 'answer' => 'About half its width, from ¼ to ½ in.'],
        ['question' => 'What is backer rod?', 'answer' => 'A foam rod pressed into the joint to set the sealant depth.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="width" label="Joint width" value="0.375" min="0" placeholder="Joint width">
            <label for="calc-width-unit" class="sr-only">Joint width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Joint depth" value="0.25" min="0" placeholder="Joint depth">
            <label for="calc-depth-unit" class="sr-only">Joint depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Total length" value="100" min="0" placeholder="Total length">
            <label for="calc-length-unit" class="sr-only">Total length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="profile" label="Bead" :options="['square' => 'Butt joint (rectangle)', 'triangle' => 'Fillet (triangle)']" selected="square" />
        <x-calc.field name="cartridge" label="Cartridge size" value="10.1" min="0" placeholder="Cartridge size">
            <label for="calc-cartridge-unit" class="sr-only">Cartridge size unit</label>
            <select id="calc-cartridge-unit" name="cartridge-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['floz_us', 'ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'floz_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />
    </div>

    <x-calc.result label="Sealant needed" />

    <x-calc.options :examples="[
        '100 ft of ⅜ × ¼ in' => ['width' => 0.375, 'width-unit' => 'in', 'depth' => 0.25, 'depth-unit' => 'in', 'length' => 100, 'length-unit' => 'ft', 'profile' => 'square', 'cartridge' => 10.1, 'cartridge-unit' => 'floz_us', 'waste' => 10],
        'Bathtub fillet ¼ in' => ['width' => 0.25, 'width-unit' => 'in', 'depth' => 0.25, 'depth-unit' => 'in', 'length' => 14, 'length-unit' => 'ft', 'profile' => 'triangle', 'cartridge' => 10.1, 'cartridge-unit' => 'floz_us', 'waste' => 10],
        '20 mm joints, 600 mL sausages' => ['width' => 20, 'width-unit' => 'mm', 'depth' => 10, 'depth-unit' => 'mm', 'length' => 60, 'length-unit' => 'm', 'profile' => 'square', 'cartridge' => 600, 'cartridge-unit' => 'ml', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'volume' => ['label' => 'Volume'],
            'per_cartridge' => ['label' => 'Length per cartridge'],
            'depth' => ['label' => 'Joint shape'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>volume = width × depth × length (× ½ for a fillet)</li>
            <li>cartridges = ⌈volume × (1 + waste) ÷ cartridge⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
