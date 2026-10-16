<x-calc.page
    title="Miller Indices Calculator - SolveKit"
    description="Free Miller indices calculator: (hkl) from plane intercepts, d-spacing for a cubic lattice and the Bragg angle for X-ray diffraction."
    lede="Find Miller indices from intercepts, with the d-spacing and Bragg angle."
    about="Miller indices are the reciprocals of a plane's intercepts with the cell axes, cleared of fractions to the smallest whole numbers. For a cubic lattice the spacing is d = a ÷ √(h² + k² + l²), and Bragg's law nλ = 2d sin θ gives the diffraction angle."
    :calc="['engine' => 'chem-physical', 'tool' => 'miller', 'fields' => ['mode', 'x', 'y', 'z', 'h', 'k', 'l', 'lattice_constant', 'wavelength']]"
    :how-to="[
        ['name' => 'Enter the intercepts', 'text' => 'In units of the cell edge; ∞ for parallel axes.'],
        ['name' => 'Add a and λ', 'text' => 'For the spacing and diffraction angle.'],
    ]"
    :faqs="[
        ['question' => 'How do I find Miller indices?', 'answer' => 'Take reciprocals of the intercepts and clear the fractions.'],
        ['question' => 'What does a bar over a number mean?', 'answer' => 'A negative index, e.g. (1̅10).'],
        ['question' => 'What is Cu Kα radiation?', 'answer' => 'The common X-ray line at 1.5406 Å used in powder diffraction.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['intercepts' => 'Intercepts', 'indices' => 'Indices']" selected="intercepts" />

    <div data-show-when="mode:intercepts">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="x" label="x intercept" value="1" type="text" help="∞ if parallel" />
            <x-calc.field name="y" label="y intercept" value="2" type="text" />
            <x-calc.field name="z" label="z intercept" value="∞" type="text" />
        </div>
    </div>

    <div data-show-when="mode:indices" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="h" label="h" value="1" step="1" />
            <x-calc.field name="k" label="k" value="1" step="1" />
            <x-calc.field name="l" label="l" value="1" step="1" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lattice_constant" label="Cubic lattice constant a" value="3.6149e-10" min="0" suffix="m" />
        <x-calc.field name="wavelength" label="X-ray wavelength" value="1.5406e-10" min="0" suffix="m" help="Cu Kα1 = 1.5406 Å" />
    </div>

    <x-calc.result label="Miller indices" />

    <x-calc.options :examples="[
        'Intercepts 1, 2, ∞' => ['mode' => 'intercepts', 'x' => '1', 'y' => '2', 'z' => '∞', 'lattice_constant' => 3.6149e-10, 'wavelength' => 1.5406e-10],
        '(111) of copper' => ['mode' => 'indices', 'h' => 1, 'k' => 1, 'l' => 1, 'lattice_constant' => 3.6149e-10, 'wavelength' => 1.5406e-10],
        'Intercepts ½, 1, 1' => ['mode' => 'intercepts', 'x' => '0.5', 'y' => '1', 'z' => '1', 'lattice_constant' => 5.431e-10, 'wavelength' => 1.5406e-10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'spacing' => ['label' => 'd-spacing'],
            'bragg' => ['label' => 'Bragg angle'],
            'sum' => ['label' => 'h² + k² + l²'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(hkl) = smallest integers ∝ (1/x, 1/y, 1/z)</li>
            <li>d = a ÷ √(h² + k² + l²)</li>
            <li>nλ = 2d sin θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
