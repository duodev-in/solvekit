<x-calc.page
    title="Exponential Equation Solver - SolveKit"
    description="Free exponential equation solver: solve a · b^(px + q) = c for x with logarithms, step by step."
    lede="Solve an exponential equation."
    about="Isolate the power, then take logarithms of both sides: a·b^(px + q) = c → px + q = log_b(c/a) → x = (log_b(c/a) − q)/p. There is no real solution when c/a ≤ 0."
    :calc="['engine' => 'mt-algebra', 'tool' => 'exponential_eq', 'fields' => ['a', 'b', 'c', 'p', 'q']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Solve 3 · 2^(x + 1) = 48.', 'answer' => 'x = 3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="a" value="3" step="any" />
        <x-calc.field name="b" label="Base b" value="2" step="any" />
        <x-calc.field name="c" label="c" value="48" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p" label="p (coefficient of x)" value="1" step="any" />
        <x-calc.field name="q" label="q" value="1" step="any" />
    </div>

    <x-calc.result label="x" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 3, 'b' => 2, 'c' => 48, 'p' => 1, 'q' => 1],
        'Decay' => ['a' => 500, 'b' => 0.8, 'c' => 100, 'p' => 1, 'q' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact form'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x = (log_b(c/a) − q)/p</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
