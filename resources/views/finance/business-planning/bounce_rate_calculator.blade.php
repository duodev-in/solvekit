<x-calc.page
    title="Bounce Rate Calculator - SolveKit"
    description="Free Bounce Rate Calculator: bounce rate = single-page sessions ÷ sessions. A bounce is a session that views only one page."
    lede="Work out the bounce rate from single-page sessions and total sessions."
    about="A bounce is a session that views only one page. Google Analytics 4 instead reports engagement rate; its bounce rate is 1 − engagement rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'bounce_rate', 'fields' => ['single', 'sessions']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Single-page sessions, Total sessions.'],
        ['name' => 'Read the result', 'text' => 'The bounce rate appears as you type, with engaged or multi-page sessions below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the bounce rate?', 'answer' => 'Bounce rate = single-page sessions ÷ sessions.'],
        ['question' => 'What is the bounce rate for single-page sessions 4,200, total sessions 10,000?', 'answer' => '42%. Engaged or multi-page sessions: 5,800.'],
        ['question' => 'And for single-page sessions 1,800, total sessions 2,500?', 'answer' => '72%. Engaged or multi-page sessions: 700.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Blogs often see 60–90%; checkout pages should be far lower.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="single" label="Single-page sessions" value="4200" min="0" step="1" />
        <x-calc.field name="sessions" label="Total sessions" value="10000" min="0" step="1" />
    </div>

    <x-calc.result label="Bounce rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['single' => 4200, 'sessions' => 10000],
        'Example B' => ['single' => 1800, 'sessions' => 2500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Engaged or multi-page sessions'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bounce rate = single-page sessions ÷ sessions</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
