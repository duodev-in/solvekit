<x-calc.page
    title="Catalan Number Calculator - SolveKit"
    description="Free Catalan number calculator: the n-th Catalan number exactly, with the first terms."
    lede="Find a Catalan number."
    about="Catalan numbers Cₙ = C(2n, n)/(n + 1) count many structures: balanced bracket strings, binary trees with n nodes, triangulations of an (n + 2)-gon and monotone lattice paths that never cross the diagonal. 1, 1, 2, 5, 14, 42, 132, …"
    :calc="['engine' => 'mt-seq', 'tool' => 'catalan', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the 10th Catalan number?', 'answer' => '16,796.'],
    ]"
>
    <x-calc.field name="n" label="n" value="10" type="text" inputmode="decimal" />

    <x-calc.result label="Cₙ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '10'],
        'Large' => ['n' => '100'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'first' => ['label' => 'First terms'],
            'counts' => ['label' => 'What it counts'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Cₙ = C(2n, n)/(n + 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
