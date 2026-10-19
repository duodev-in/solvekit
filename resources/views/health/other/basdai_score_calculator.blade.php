<x-calc.page
    title="BASDAI Score Calculator - SolveKit"
    description="Free BASDAI calculator: the Bath Ankylosing Spondylitis Disease Activity Index from six questions on fatigue, pain, swelling, tenderness and morning stiffness."
    lede="Score ankylosing spondylitis activity (BASDAI)."
    about="The BASDAI (Garrett et al. 1994) asks six questions about the last week on 0–10 scales. BASDAI = (Q1 + Q2 + Q3 + Q4 + mean of Q5 and Q6) ÷ 5. A score of 4 or more is generally taken as active disease, a common threshold for considering biologic treatment. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'basdai', 'fields' => ['q1', 'q2', 'q3', 'q4', 'q5', 'q6']]"
    :how-to="[
        ['name' => 'Rate each question for the past week', 'text' => '0 is none, 10 is very severe.'],
    ]"
    :faqs="[
        ['question' => 'What is the BASDAI with answers 5, 6, 3, 4, 6 and 5?', 'answer' => '4.7 of 10: 4 or more: active disease (often used to consider treatment changes).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q1" label="1. Fatigue or tiredness (0–10)" value="5" min="0" max="10" step="0.5" />
        <x-calc.field name="q2" label="2. Neck, back or hip pain (0–10)" value="6" min="0" max="10" step="0.5" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q3" label="3. Pain or swelling in other joints (0–10)" value="3" min="0" max="10" step="0.5" />
        <x-calc.field name="q4" label="4. Tenderness to touch or pressure (0–10)" value="4" min="0" max="10" step="0.5" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q5" label="5. Severity of morning stiffness (0–10)" value="6" min="0" max="10" step="0.5" />
        <x-calc.field name="q6" label="6. Duration of morning stiffness (0 = none, 10 = 2 hours or more)" value="5" min="0" max="10" step="0.5" />
    </div>

    <x-calc.result label="BASDAI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 5, 'q2' => 6, 'q3' => 3, 'q4' => 4, 'q5' => 6, 'q6' => 5],
        'Quiet' => ['q1' => 2, 'q2' => 2, 'q3' => 1, 'q4' => 1, 'q5' => 2, 'q6' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(Q1 + Q2 + Q3 + Q4 + (Q5 + Q6)/2) ÷ 5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
