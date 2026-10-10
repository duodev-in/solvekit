<x-tool-page-layout
    title="Time Unit Converter - ConvertPro"
    description="Professional time unit converter for all time measurements. Convert between seconds, minutes, hours, days, weeks, months, and years with precision calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Time Unit Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                <!-- Current Time Display -->
                                <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Current Time (UTC)</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600 block">Date & Time:</span>
                                            <span class="font-mono text-blue-700 text-lg">{{ date('Y-m-d H:i:s') }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 block">Unix Timestamp:</span>
                                            <span class="font-mono text-blue-700 text-lg">{{ time() }}</span>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Value and Units -->
                                                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                                                                <div class="min-w-0 space-y-2">
                                                                                    <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                        Time Value
                                                                                    </label>
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="e.g., 3600"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                </div>

                                                                                <div class="min-w-0 space-y-2">
                                                                                    <label for="fromUnit" class="block text-sm font-semibold text-gray-700">
                                                                                        From Unit
                                                                                    </label>
                                                                                    <select 
                                                                                        id="fromUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="milliseconds">Milliseconds (ms)</option>
                                                                                        <option value="seconds" selected>Seconds (s)</option>
                                                                                        <option value="minutes">Minutes (min)</option>
                                                                                        <option value="hours">Hours (h)</option>
                                                                                        <option value="days">Days (d)</option>
                                                                                        <option value="weeks">Weeks (wk)</option>
                                                                                        <option value="months">Months (30 days)</option>
                                                                                        <option value="years">Years (365 days)</option>
                                                                                        <option value="decades">Decades</option>
                                                                                        <option value="centuries">Centuries</option>
                                                                                        <option value="millennia">Millennia</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="min-w-0 space-y-2">
                                                                                    <label for="toUnit" class="block text-sm font-semibold text-gray-700">
                                                                                        To Unit
                                                                                    </label>
                                                                                    <select 
                                                                                        id="toUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="milliseconds">Milliseconds (ms)</option>
                                                                                        <option value="seconds">Seconds (s)</option>
                                                                                        <option value="minutes" selected>Minutes (min)</option>
                                                                                        <option value="hours">Hours (h)</option>
                                                                                        <option value="days">Days (d)</option>
                                                                                        <option value="weeks">Weeks (wk)</option>
                                                                                        <option value="months">Months (30 days)</option>
                                                                                        <option value="years">Years (365 days)</option>
                                                                                        <option value="decades">Decades</option>
                                                                                        <option value="centuries">Centuries</option>
                                                                                        <option value="millennia">Millennia</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Precision Control -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Display Precision
                                                                                </label>
                                                                                <div class="flex items-center space-x-4">
                                                                                    <input 
                                                                                        type="range" 
                                                                                        id="precision" 
                                                                                        min="0" 
                                                                                        max="10" 
                                                                                        value="6" 
                                                                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                                                                    >
                                                                                    <span class="text-sm font-mono text-gray-700 min-w-[3rem]" id="precisionValue">6 digits</span>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Adjust decimal places for calculations</p>
                                                                            </div>

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-violet-100 hover:bg-violet-200 text-violet-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl border-l-4 border-violet-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Time</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-violet-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-violet-600 hover:text-violet-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- All Time Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Small Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Small Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Milliseconds</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="millisecondsDisplay">--</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Seconds</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="secondsDisplay">--</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Minutes</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="minutesDisplay">--</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Hours</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="hoursDisplay">--</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Large Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Large Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Days</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="daysDisplay">--</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Weeks</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="weeksDisplay">--</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Months</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="monthsDisplay">--</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Years</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="yearsDisplay">--</div>
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
                <!-- Quick Time Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Time Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-violet-100 text-gray-700 hover:text-violet-700 rounded-lg transition-colors" data-value="3600" data-from="seconds" data-to="hours">1 Hour</button>
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-violet-100 text-gray-700 hover:text-violet-700 rounded-lg transition-colors" data-value="86400" data-from="seconds" data-to="days">1 Day</button>
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-violet-100 text-gray-700 hover:text-violet-700 rounded-lg transition-colors" data-value="1" data-from="years" data-to="days">1 Year</button>
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-violet-100 text-gray-700 hover:text-violet-700 rounded-lg transition-colors" data-value="1000" data-from="milliseconds" data-to="seconds">1000ms</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Time Conversion Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Time Unit Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 second</strong> = 1,000 milliseconds</div>
                                                        <div><strong>1 minute</strong> = 60 seconds</div>
                                                        <div><strong>1 hour</strong> = 60 minutes</div>
                                                        <div><strong>1 day</strong> = 24 hours</div>
                                                        <div><strong>1 week</strong> = 7 days</div>
                                                        <div><strong>1 month</strong> ≈ 30 days</div>
                                                        <div><strong>1 year</strong> = 365 days</div>
                                                        <div><strong>1 decade</strong> = 10 years</div>
                                                        <div><strong>1 century</strong> = 100 years</div>
                                                        <div><strong>1 millennium</strong> = 1,000 years</div>
                                                        <div><strong>Leap year</strong> = 366 days</div>
                                                        <div><strong>Solar year</strong> ≈ 365.25 days</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const fromUnit = document.getElementById('fromUnit');
                        const toUnit = document.getElementById('toUnit');
                        const precision = document.getElementById('precision');
                        const precisionValue = document.getElementById('precisionValue');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const copyResult = document.getElementById('copyResult');
                        const unitDisplays = {
                            milliseconds: document.getElementById('millisecondsDisplay'),
                            seconds: document.getElementById('secondsDisplay'),
                            minutes: document.getElementById('minutesDisplay'),
                            hours: document.getElementById('hoursDisplay'),
                            days: document.getElementById('daysDisplay'),
                            weeks: document.getElementById('weeksDisplay'),
                            months: document.getElementById('monthsDisplay'),
                            years: document.getElementById('yearsDisplay')
                        };

                        // Time unit multipliers (in seconds)
                        const timeMultipliers = {
                            milliseconds: 0.001,
                            seconds: 1,
                            minutes: 60,
                            hours: 3600,
                            days: 86400,
                            weeks: 604800,
                            months: 2592000, // 30 days
                            years: 31536000, // 365 days
                            decades: 315360000,
                            centuries: 3153600000,
                            millennia: 31536000000
                        };

                        const unitNames = {
                            milliseconds: ['millisecond', 'milliseconds'],
                            seconds: ['second', 'seconds'],
                            minutes: ['minute', 'minutes'],
                            hours: ['hour', 'hours'],
                            days: ['day', 'days'],
                            weeks: ['week', 'weeks'],
                            months: ['month', 'months'],
                            years: ['year', 'years'],
                            decades: ['decade', 'decades'],
                            centuries: ['century', 'centuries'],
                            millennia: ['millennium', 'millennia']
                        };

                        function unitName(unit, value) {
                            return unitNames[unit][value === 1 ? 0 : 1];
                        }

                        function capitalize(text) {
                            return text.charAt(0).toUpperCase() + text.slice(1);
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

                        function setDisplays(seconds) {
                            Object.keys(unitDisplays).forEach(function(unit) {
                                if (unitDisplays[unit]) {
                                    unitDisplays[unit].textContent = seconds === null ? '--' : formatNumber(seconds / timeMultipliers[unit]);
                                }
                            });
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (isNaN(inputVal) || inputVal < 0) {
                                clearOutputs();
                                return;
                            }

                            const inputInSeconds = inputVal * timeMultipliers[from];
                            const result = inputInSeconds / timeMultipliers[to];

                            output.textContent = formatNumber(result);
                            resultTitle.textContent = `${capitalize(unitNames[to][1])}`;
                            resultDescription.textContent = `${formatNumber(inputVal)} ${unitName(from, inputVal)} = ${formatNumber(result)} ${unitName(to, result)}`;
                            setDisplays(inputInSeconds);
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Time';
                            resultDescription.textContent = 'Enter a time value to convert';
                            setDisplays(null);
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'seconds';
                            toUnit.value = 'minutes';
                            precision.value = 6;
                            precisionValue.textContent = '6 digits';
                            clearOutputs();
                            inputValue.focus();
                        }

                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
                        toUnit.addEventListener('change', convert);

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

                        const timeExamples = document.querySelectorAll('.time-example');
                        timeExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                inputValue.value = this.getAttribute('data-value');
                                fromUnit.value = this.getAttribute('data-from');
                                toUnit.value = this.getAttribute('data-to');
                                convert();

                                timeExamples.forEach(btn => btn.classList.remove('bg-violet-100', 'text-violet-700'));
                                timeExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-violet-100', 'text-violet-700');
                            });
                        });

                        precisionValue.textContent = precision.value + ' digits';
                        clearOutputs();
                        inputValue.focus();

                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
