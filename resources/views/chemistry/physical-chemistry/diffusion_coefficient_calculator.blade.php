<x-calc.page
    title="Diffusion Coefficient Calculator - SolveKit"
    description="Free diffusion coefficient calculator: Stokes-Einstein D from temperature, viscosity and particle size, or D from mean displacement and time."
    lede="Work out a diffusion coefficient."
    about="The Stokes–Einstein equation D = kT ÷ (6πηr) gives the diffusion coefficient of a spherical particle much larger than the solvent molecules. From a measured mean-square displacement in one dimension, D = ⟨x²⟩ ÷ 2t."
    :calc="['engine' => 'chem-physical', 'tool' => 'diffusion', 'fields' => ['mode', 'temperature', 'viscosity', 'radius', 'distance', 'time']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => 'Stokes–Einstein or a measured distance.'],
        ['name' => 'Enter the values', 'text' => 'Viscosity in mPa·s (centipoise).'],
    ]"
    :faqs="[
        ['question' => 'What is the diffusion coefficient of a protein?', 'answer' => 'Typically 10⁻¹¹ to 10⁻¹⁰ m²/s in water.'],
        ['question' => 'What is Stokes–Einstein?', 'answer' => 'D = kT ÷ (6πηr), from the drag on a sphere in a viscous fluid.'],
        ['question' => 'How far does a molecule diffuse?', 'answer' => 'The typical distance grows with √(2Dt), not with time.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['stokes' => 'Stokes–Einstein', 'distance' => 'Distance and time']" selected="stokes" />

    <div data-show-when="mode:stokes">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="temperature" label="Temperature" value="25" suffix="°C" />
            <x-calc.field name="viscosity" label="Viscosity" value="0.89" min="0" suffix="mPa·s" help="Water 0.89 at 25 °C" />
            <x-calc.field name="radius" label="Particle radius" value="3.5" min="0" suffix="nm" />
        </div>
    </div>

    <div data-show-when="mode:distance" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="distance" label="RMS distance" value="10" min="0" suffix="µm" />
            <x-calc.field name="time" label="Time" value="1" min="0" suffix="s" />
        </div>
    </div>

    <x-calc.result label="Diffusion coefficient" />

    <x-calc.options :examples="[
        'Protein in water' => ['mode' => 'stokes', 'temperature' => 25, 'viscosity' => 0.89, 'radius' => 3.5],
        '1 µm bead in water' => ['mode' => 'stokes', 'temperature' => 25, 'viscosity' => 0.89, 'radius' => 500],
        'Bead tracking' => ['mode' => 'distance', 'distance' => 10, 'time' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cm' => ['label' => 'In cm²/s'],
            'time_mm' => ['label' => 'Time to diffuse 1 mm'],
            'radius' => ['label' => 'Particle radius'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>D = kT ÷ (6πηr)</li>
            <li>⟨x²⟩ = 2Dt</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
