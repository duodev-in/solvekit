<x-calc.page
    title="Dog Ideal Weight Calculator (Dog BMI) - SolveKit"
    description="Free dog ideal weight calculator: estimate a healthy weight from current weight and body condition score, with a safe weekly loss target."
    lede="Estimate your dog's ideal weight from its body condition score."
    about="Dogs do not have a BMI like people; vets use a 1 to 9 body condition score (BCS), where 5 is ideal and each point above 5 is roughly 10% over ideal weight (WSAVA). A safe loss rate is about 1 to 2% of body weight a week. Ask your vet to score your dog if you are unsure."
    :calc="['engine' => 'pets', 'tool' => 'dog_ideal_weight', 'fields' => ['weight_unit', 'weight', 'bcs']]"
    :how-to="[
        ['name' => 'Weigh your dog', 'text' => 'Use the same scale each time.'],
        ['name' => 'Score the body', 'text' => '1 is emaciated, 5 ideal, 9 obese.'],
    ]"
    :faqs="[
        ['question' => 'Is there a BMI for dogs?', 'answer' => 'Not a standard one; the body condition score is used instead.'],
        ['question' => 'How fast should a dog lose weight?', 'answer' => 'About 1 to 2% of body weight a week, under a vet\'s plan.'],
        ['question' => 'How do I know the score?', 'answer' => 'At 5 you can feel the ribs easily and see a waist from above.'],
    ]"
>
    <x-calc.segmented name="weight_unit" legend="Unit" :options="['lb' => 'lb', 'kg' => 'kg']" selected="lb" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Current weight" value="66" min="0" />
        <x-calc.field name="bcs" label="Body condition score (1–9)" value="7" min="1" max="9" step="1" help="5 is ideal; 7 is ribs hard to feel, no waist" />
    </div>

    <x-calc.result label="Estimated ideal weight" />

    <x-calc.options :examples="[
        'BCS 7, 66 lb' => ['weight_unit' => 'lb', 'weight' => 66, 'bcs' => 7],
        'BCS 8, 40 kg' => ['weight_unit' => 'kg', 'weight' => 40, 'bcs' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'change' => ['label' => 'Change needed'],
            'weekly' => ['label' => 'Safe weekly loss'],
            'weeks' => ['label' => 'Time to ideal'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ideal ≈ weight ÷ (1 + 0.10 × (BCS − 5))</li>
            <li>safe loss 1 to 2% of body weight a week</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
