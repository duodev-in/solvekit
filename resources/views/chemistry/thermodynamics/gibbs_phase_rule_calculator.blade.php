<x-calc.page
    title="Gibbs' Phase Rule Calculator - SolveKit"
    description="Free Gibbs phase rule calculator: degrees of freedom F = C − P + 2 for any number of components and phases."
    lede="Work out the degrees of freedom of a system with the phase rule."
    about="The Gibbs phase rule F = C − P + 2 gives how many intensive variables (temperature, pressure, composition) can change independently while the number of phases stays the same. At fixed pressure it becomes F = C − P + 1."
    :calc="['engine' => 'chem-thermo', 'tool' => 'phase_rule', 'fields' => ['components', 'phases', 'constant']]"
    :how-to="[
        ['name' => 'Count the components', 'text' => 'Independent chemical species.'],
        ['name' => 'Count the phases', 'text' => 'Solid, liquid, gas, each solid form.'],
    ]"
    :faqs="[
        ['question' => 'Why is the triple point invariant?', 'answer' => 'One component in three phases gives F = 0: temperature and pressure are fixed.'],
        ['question' => 'What is a component?', 'answer' => 'An independent chemical species needed to describe every phase.'],
        ['question' => 'When is the +1 form used?', 'answer' => 'For condensed systems studied at constant pressure.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="components" label="Components C" value="1" min="1" step="1" />
        <x-calc.field name="phases" label="Phases P" value="3" min="1" step="1" />
    </div>

    <x-calc.segmented name="constant" legend="Held constant" :options="['none' => 'Nothing', 'pressure' => 'Pressure']" selected="none" />

    <x-calc.result label="Degrees of freedom" />

    <x-calc.options :decimals="false" :examples="[
        'Water triple point' => ['components' => 1, 'phases' => 3, 'constant' => 'none'],
        'Boiling water' => ['components' => 1, 'phases' => 2, 'constant' => 'none'],
        'Salt water at 1 atm' => ['components' => 2, 'phases' => 2, 'constant' => 'pressure'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Calculation'],
            'max' => ['label' => 'Most phases possible'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = C − P + 2</li>
            <li>fixed pressure: F = C − P + 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
