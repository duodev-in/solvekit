<x-calc.page
    title="Nuclear Binding Energy Calculator - SolveKit"
    description="Free nuclear binding energy calculator: mass defect and binding energy per nucleon from AME2020 masses."
    lede="Find nuclear binding energy."
    about="A nucleus weighs less than its separate protons and neutrons; the missing mass is the binding energy, E = mc². Iron and nickel are the most tightly bound."
    :calc="['engine' => 'ph-quantum', 'tool' => 'binding_energy', 'fields' => ['nuc', 'Z', 'A', 'M'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['nuclides'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the binding energy per nucleon of iron-56?', 'answer' => '8.79036 MeV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="nuc" label="Nuclide" :options="['h2' => 'Deuterium (²H)', 'h3' => 'Tritium (³H)', 'he3' => 'Helium-3', 'he4' => 'Helium-4', 'li6' => 'Lithium-6', 'li7' => 'Lithium-7', 'be9' => 'Beryllium-9', 'c12' => 'Carbon-12', 'c14' => 'Carbon-14', 'n14' => 'Nitrogen-14', 'o16' => 'Oxygen-16', 'ne20' => 'Neon-20', 'na23' => 'Sodium-23', 'si28' => 'Silicon-28', 'ca40' => 'Calcium-40', 'fe56' => 'Iron-56', 'ni62' => 'Nickel-62', 'pb208' => 'Lead-208', 'u235' => 'Uranium-235', 'u238' => 'Uranium-238', 'custom' => 'Other (enter the value)']" selected="fe56" />
        <div data-show-when="nuc:custom">
            <x-calc.field name="Z" label="Protons Z" value="26" min="1" step="any" />
        </div>
        <div data-show-when="nuc:custom">
            <x-calc.field name="A" label="Mass number A" value="56" min="1" step="any" />
        </div>
        <div data-show-when="nuc:custom">
            <x-calc.field name="M" label="Atomic mass (u)" value="55.93493554" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Binding energy per nucleon" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['nuc' => 'fe56', 'Z' => 26, 'A' => 56, 'M' => 55.93493554],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Total binding energy'],
            'defect' => ['label' => 'Mass defect'],
            'compare' => ['label' => 'Compared with iron-56 and nickel-62'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
