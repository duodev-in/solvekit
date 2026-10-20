<x-calc.page
    title="Relatively Prime Calculator - SolveKit"
    description="Free relatively prime calculator: check whether numbers are coprime (their GCF is 1), and pairwise coprime."
    lede="Check if numbers are coprime."
    about="Numbers are relatively prime (coprime) when their only common factor is 1, even if neither is prime: 8 and 15 are coprime. A set is pairwise coprime when every pair is coprime, which matters in the Chinese remainder theorem."
    :calc="['engine' => 'mt-number', 'tool' => 'relatively_prime', 'fields' => ['numbers']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Are 8 and 15 relatively prime?', 'answer' => 'Relatively prime.'],
    ]"
>
    <x-calc.field name="numbers" label="Numbers" value="8, 15" type="text" inputmode="text" />

    <x-calc.result label="Coprime?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['numbers' => '8, 15'],
        'No' => ['numbers' => '21, 35'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'gcf' => ['label' => 'GCF'],
            'pairwise' => ['label' => 'Pairwise coprime'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>coprime ⇔ gcd = 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
