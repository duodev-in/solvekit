<x-calc.page
    title="Comparative Advantage Calculator - SolveKit"
    description="Free comparative advantage calculator: opportunity costs of two goods for two producers, who should specialize in what, and the range of trade terms that benefits both."
    lede="Find who has the comparative advantage."
    about="A producer's opportunity cost of one unit of good 1 is the amount of good 2 it gives up. The producer with the lower opportunity cost has the comparative advantage (Ricardo) and should specialize in it, even if the other is better at both (absolute advantage). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'comparative', 'fields' => ['name_a', 'name_b', 'good1', 'good2', 'a1', 'a2', 'b1', 'b2']]"
    :how-to="[
        ['name' => 'Name the producers and goods', 'text' => ''],
        ['name' => 'Enter what each can produce', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Who should make wheat if A makes 40 wheat or 20 cloth and B 10 wheat or 15 cloth?', 'answer' => 'Country A has the comparative advantage in wheat.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="name_a" label="Producer A" value="Country A" type="text" />
        <x-calc.field name="name_b" label="Producer B" value="Country B" type="text" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="good1" label="Good 1" value="wheat" type="text" />
        <x-calc.field name="good2" label="Good 2" value="cloth" type="text" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a1" label="A: good 1 per day" value="40" min="0" step="any" />
        <x-calc.field name="a2" label="A: good 2 per day" value="20" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="b1" label="B: good 1 per day" value="10" min="0" step="any" />
        <x-calc.field name="b2" label="B: good 2 per day" value="15" min="0" step="any" />
    </div>

    <x-calc.result label="Comparative advantage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['name_a' => 'Country A', 'name_b' => 'Country B', 'good1' => 'wheat', 'good2' => 'cloth', 'a1' => 40, 'a2' => 20, 'b1' => 10, 'b2' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'a' => ['label' => 'A\'s opportunity cost'],
            'b' => ['label' => 'B\'s opportunity cost'],
            'terms' => ['label' => 'Terms of trade'],
            'absolute' => ['label' => 'Absolute advantage'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>opportunity cost of good 1 = good 2 output ÷ good 1 output</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
