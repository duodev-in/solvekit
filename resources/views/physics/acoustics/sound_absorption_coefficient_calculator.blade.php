<x-calc.page
    title="Sound Absorption Coefficient Calculator - SolveKit"
    description="Free sound absorption coefficient calculator: α from measured energies or typical values for common materials, with NRC."
    lede="Find a material’s absorption coefficient."
    about="The absorption coefficient α is the share of incident sound energy a surface does not reflect. Hard surfaces are near 0; thick porous absorbers approach 1 at mid and high frequencies."
    :calc="['engine' => 'ph-wave', 'tool' => 'absorption_coef', 'fields' => ['mode', 'Ei', 'Ea', 'Er', 'mat', 'band'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['absorption'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is α when 35 of 100 units are absorbed?', 'answer' => '0.35.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['energy' => 'Incident and absorbed sound energy', 'reflected' => 'Incident and reflected sound energy', 'material' => 'The material']" selected="energy" />
        <div data-show-when="mode:energy,reflected">
            <x-calc.field name="Ei" label="Incident energy (any unit)" value="100" min="0" step="any" />
        </div>
        <div data-show-when="mode:energy">
            <x-calc.field name="Ea" label="Absorbed energy (same unit)" value="35" min="0" step="any" />
        </div>
        <div data-show-when="mode:reflected">
            <x-calc.field name="Er" label="Reflected energy (same unit)" value="65" min="0" step="any" />
        </div>
        <div data-show-when="mode:material">
            <x-calc.select name="mat" label="Material" :options="['concrete' => 'Concrete, smooth unpainted', 'block_painted' => 'Concrete block, painted', 'brick' => 'Brick, unglazed', 'plaster' => 'Plaster on brick or block', 'gypsum' => 'Gypsum board on studs', 'glass' => 'Window glass', 'wood_floor' => 'Wood floor', 'wood_panel' => 'Wood panelling on battens', 'vinyl' => 'Vinyl or linoleum on concrete', 'carpet_concrete' => 'Carpet on concrete', 'carpet_pad' => 'Carpet on foam underlay', 'ceiling_tile' => 'Acoustic ceiling tile (suspended)', 'curtains' => 'Heavy curtains, pleated', 'fibreglass' => 'Fibreglass board, 50 mm', 'seats' => 'Upholstered seats (per m² of seating)', 'water' => 'Water surface (pool)']" selected="carpet_pad" />
        </div>
        <div data-show-when="mode:material">
            <x-calc.select name="band" label="Frequency band" :options="['0' => '125 Hz', '1' => '250 Hz', '2' => '500 Hz', '3' => '1,000 Hz', '4' => '2,000 Hz', '5' => '4,000 Hz']" selected="2" />
        </div>
    </div>

    <x-calc.result label="Absorption coefficient α" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'energy', 'Ei' => 100, 'Ea' => 35, 'Er' => 65, 'mat' => 'carpet_pad', 'band' => '2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'refl' => ['label' => 'Reflected share'],
            'nrc' => ['label' => 'Noise reduction coefficient (NRC)'],
            'bands' => ['label' => 'All bands (125 Hz–4 kHz)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
