<x-tool-page-layout
    title="Years to Decades Calculator - SolveKit"
    description="Professional years to decades calculator for long-term time periods. Convert years to decades, centuries, millennia with historical context and age calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Years to Decades Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                <!-- Current Date Display -->
                                @php
                                    $currentYear = (int) now('UTC')->format('Y');
                                    $centuryProgressPercent = round((($currentYear - 2001) / 100) * 100, 1);
                                    $millenniumProgressPercent = round((($currentYear - 2001) / 1000) * 100, 1);
                                @endphp
                                <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Current Date & Time (UTC)</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600 block">Date & Time:</span>
                                            <span class="font-mono text-blue-700 text-lg">{{ now('UTC')->format('Y-m-d H:i:s') }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 block">Current Decade:</span>
                                            <span class="font-mono text-blue-700 text-lg">{{ intdiv($currentYear, 10) * 10 }}s</span>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Mode -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Mode
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-rose-300 transition-colors cursor-pointer bg-rose-50 border-rose-300">
                                                                                        <input type="radio" name="mode" value="years-to-periods" class="text-rose-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Years → Periods</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-rose-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="periods-to-years" class="text-rose-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Periods → Years</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Container -->
                                                                            <div id="inputContainer">

                                                                                <!-- Years Input -->
                                                                                <div id="yearsInput" class="space-y-2">
                                                                                    <label for="yearsValue" class="block text-sm font-semibold text-gray-700">
                                                                                        Enter Number of Years
                                                                                    </label>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="yearsValue" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                            placeholder="Enter years (e.g., 25)"
                                                                                            step="any"
                                                                                            min="0"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-sm font-medium">years</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <p class="text-xs text-gray-500">Enter any positive number of years</p>
                                                                                </div>

                                                                                <!-- Periods Input -->
                                                                                <div id="periodsInput" class="space-y-4 hidden">
                                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                        <div class="space-y-2">
                                                                                            <label for="periodsValue" class="block text-sm font-semibold text-gray-700">
                                                                                                Value
                                                                                            </label>
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="periodsValue" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                                placeholder="Enter value"
                                                                                                step="any"
                                                                                                min="0"
                                                                                            >
                                                                                        </div>

                                                                                        <div class="space-y-2">
                                                                                            <label for="periodType" class="block text-sm font-semibold text-gray-700">
                                                                                                Period Type
                                                                                            </label>
                                                                                            <select 
                                                                                                id="periodType" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                            >
                                                                                                <option value="decades">Decades (10 years)</option>
                                                                                                <option value="centuries">Centuries (100 years)</option>
                                                                                                <option value="millennia">Millennia (1000 years)</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <div class="hidden">
                                                                                <!-- Precision Control -->
                                                                                <div class="space-y-2">
                                                                                    <label class="block text-sm font-semibold text-gray-700">
                                                                                        Display Precision
                                                                                    </label>
                                                                                    <div class="flex items-center space-x-4">
                                                                                        <input 
                                                                                            type="range" 
                                                                                            id="precision" 
                                                                                            min="0" 
                                                                                            max="8" 
                                                                                            value="3" 
                                                                                            class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                                                                        >
                                                                                        <span class="text-sm font-mono text-gray-700 min-w-[3rem]" id="precisionValue">3 digits</span>
                                                                                    </div>
                                                                                    <p class="text-xs text-gray-500">Adjust decimal places for calculations</p>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl border-l-4 border-rose-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Time Periods</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-rose-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-rose-600 hover:text-rose-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Time Period Breakdown -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Years -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Years</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="yearsDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Base unit</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Decades -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Decades</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="decadesDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10 years each</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Large Time Periods -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Centuries -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Centuries</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="centuriesDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">100 years each</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Millennia -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Millennia</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="millenniaDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">1000 years each</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Century & Millennium Tracker -->
                                                                            <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                                                                                <h4 class="text-sm font-semibold text-green-800 mb-2 text-center">Century & Millennium Progress</h4>
                                                                                <div class="space-y-3">
                                                                                    <div>
                                                                                        <div class="flex justify-between text-sm mb-1">
                                                                                            <span>21st Century Progress (2001-2100)</span>
                                                                                            <span id="centuryProgress">{{ $centuryProgressPercent }}%</span>
                                                                                        </div>
                                                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                                                            <div class="bg-green-600 h-2 rounded-full transition-all duration-500" id="centuryBar" style="width: {{ $centuryProgressPercent }}%"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="flex justify-between text-sm mb-1">
                                                                                            <span>3rd Millennium Progress (2001-3000)</span>
                                                                                            <span id="millenniumProgress">{{ $millenniumProgressPercent }}%</span>
                                                                                        </div>
                                                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                                                            <div class="bg-green-600 h-2 rounded-full transition-all duration-500" id="millenniumBar" style="width: {{ $millenniumProgressPercent }}%"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Year Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Year Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="year-example px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-gray-700 hover:text-rose-700 rounded-lg transition-colors" data-value="25" data-mode="years-to-periods">25 years</button>
                                                            <button type="button" class="year-example px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-gray-700 hover:text-rose-700 rounded-lg transition-colors" data-value="100" data-mode="years-to-periods">1 Century</button>
                                                            <button type="button" class="year-example px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-gray-700 hover:text-rose-700 rounded-lg transition-colors" data-value="1000" data-mode="years-to-periods">1 Millennium</button>
                                                            <button type="button" class="year-example px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-gray-700 hover:text-rose-700 rounded-lg transition-colors" data-current="true">Current Age</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Period Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Time Period Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 decade</strong> = 10 years</div>
                                                        <div><strong>1 century</strong> = 100 years</div>
                                                        <div><strong>1 millennium</strong> = 1,000 years</div>
                                                        <div><strong>Human generation</strong> ≈ 25-30 years</div>
                                                        <div><strong>Average lifespan</strong> ≈ 80 years</div>
                                                        <div><strong>Recorded history</strong> ≈ 5,000 years</div>
                                                        <div><strong>Civilization</strong> ≈ 10,000 years</div>
                                                        <div><strong>Modern humans</strong> ≈ 300,000 years</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const modeRadios = document.getElementsByName('mode');
                        const yearsValue = document.getElementById('yearsValue');
                        const periodsValue = document.getElementById('periodsValue');
                        const periodType = document.getElementById('periodType');
                        const precision = document.getElementById('precision');
                        const precisionValue = document.getElementById('precisionValue');
                        const clearButton = document.getElementById('clearButton');

                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const yearsDisplay = document.getElementById('yearsDisplay');
                        const decadesDisplay = document.getElementById('decadesDisplay');
                        const centuriesDisplay = document.getElementById('centuriesDisplay');
                        const millenniaDisplay = document.getElementById('millenniaDisplay');
                        const copyResult = document.getElementById('copyResult');

                        const periodYears = {
                            decades: 10,
                            centuries: 100,
                            millennia: 1000
                        };

                        const periodNames = {
                            years: ['year', 'years'],
                            decades: ['decade', 'decades'],
                            centuries: ['century', 'centuries'],
                            millennia: ['millennium', 'millennia']
                        };

                        function unitName(unit, value) {
                            return periodNames[unit][value === 1 ? 0 : 1];
                        }

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
                        }

                        function getPrecision() {
                            return parseInt(precision.value, 10);
                        }

                        function formatNumber(num) {
                            if (num === 0) {
                                return '0';
                            }

                            const absolute = Math.abs(num);

                            if (absolute >= 1e15 || absolute < 1e-6) {
                                return num.toExponential(4);
                            }

                            if (absolute < 1) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: Math.max(getPrecision(), 1) });
                            }

                            return num.toLocaleString(undefined, { maximumFractionDigits: getPrecision() });
                        }

                        function updateInterface() {
                            const mode = getMode();
                            const yearsInput = document.getElementById('yearsInput');
                            const periodsInput = document.getElementById('periodsInput');

                            if (mode === 'years-to-periods') {
                                yearsInput.classList.remove('hidden');
                                periodsInput.classList.add('hidden');
                                resultTitle.textContent = 'Decades';
                            } else {
                                yearsInput.classList.add('hidden');
                                periodsInput.classList.remove('hidden');
                                resultTitle.textContent = 'Years';
                            }
                        }

                        function convert() {
                            const mode = getMode();
                            let years;
                            let inputVal;

                            if (mode === 'years-to-periods') {
                                inputVal = parseFloat(yearsValue.value);
                            } else {
                                inputVal = parseFloat(periodsValue.value);
                            }

                            if (isNaN(inputVal) || inputVal < 0) {
                                clearOutputs();
                                return;
                            }

                            years = mode === 'years-to-periods' ? inputVal : inputVal * periodYears[periodType.value];

                            const decades = years / 10;
                            const centuries = years / 100;
                            const millennia = years / 1000;

                            if (mode === 'years-to-periods') {
                                output.textContent = `${formatNumber(decades)} ${unitName('decades', decades)}`;
                                resultDescription.textContent = `${formatNumber(years)} ${unitName('years', years)} = ${formatNumber(decades)} ${unitName('decades', decades)}`;
                            } else {
                                output.textContent = `${formatNumber(years)} ${unitName('years', years)}`;
                                resultDescription.textContent = `${formatNumber(inputVal)} ${unitName(periodType.value, inputVal)} = ${formatNumber(years)} ${unitName('years', years)}`;
                            }

                            yearsDisplay.textContent = formatNumber(years);
                            decadesDisplay.textContent = formatNumber(decades);
                            centuriesDisplay.textContent = formatNumber(centuries);
                            millenniaDisplay.textContent = formatNumber(millennia);
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultDescription.textContent = getMode() === 'years-to-periods' ? 'Enter years to convert to decades' : 'Enter a period to convert to years';
                            yearsDisplay.textContent = '--';
                            decadesDisplay.textContent = '--';
                            centuriesDisplay.textContent = '--';
                            millenniaDisplay.textContent = '--';
                        }

                        function clearAll() {
                            yearsValue.value = '';
                            periodsValue.value = '';
                            periodType.value = 'decades';
                            document.querySelector('input[value="years-to-periods"]').checked = true;
                            precision.value = 3;
                            precisionValue.textContent = '3 digits';
                            updateInterface();
                            clearOutputs();
                            yearsValue.focus();
                        }

                        // Event listeners
                        yearsValue.addEventListener('input', convert);
                        periodsValue.addEventListener('input', convert);
                        periodType.addEventListener('change', convert);

                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                convert();
                            });
                        });

                        precision.addEventListener('input', function() {
                            precisionValue.textContent = this.value + ' digits';
                            convert();
                        });

                        clearButton.addEventListener('click', clearAll);

                        copyResult.addEventListener('click', function() {
                            const text = output.textContent;
                            if (text !== '--') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        const yearExamples = document.querySelectorAll('.year-example');
                        yearExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const mode = this.getAttribute('data-mode');
                                const isCurrent = this.getAttribute('data-current');

                                // Use a typical age for the "current age" example
                                yearsValue.value = isCurrent ? 30 : value;

                                document.querySelector(`input[value="${mode || 'years-to-periods'}"]`).checked = true;
                                updateInterface();
                                convert();

                                yearExamples.forEach(btn => btn.classList.remove('bg-rose-100', 'text-rose-700'));
                                yearExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-rose-100', 'text-rose-700');
                            });
                        });

                        // Initialize
                        updateInterface();
                        clearOutputs();
                        precisionValue.textContent = precision.value + ' digits';
                        yearsValue.focus();

                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                const newMode = getMode() === 'years-to-periods' ? 'periods-to-years' : 'years-to-periods';
                                document.querySelector(`input[value="${newMode}"]`).checked = true;
                                updateInterface();
                                convert();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
