<x-tool-page-layout
    title="Minutes to Hours Converter - SolveKit"
    description="Professional minutes to hours converter for time calculations. Convert between minutes and hours with decimal precision and practical time examples."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Minutes to Hours Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer bg-blue-50 border-blue-300">
                                                                                        <input type="radio" name="mode" value="min-to-hour" class="text-blue-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Minutes → Hours</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="hour-to-min" class="text-blue-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Hours → Minutes</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700" id="inputLabel">
                                                                                    Enter Minutes
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter value (e.g., 90)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">min</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="inputHelp">Enter any positive number</p>
                                                                            </div>

                                                                            <!-- Time Format Options -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Display Format Options
                                                                                </label>
                                                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="checkbox" name="showDecimal" class="text-blue-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Decimal</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="checkbox" name="showHourMin" class="text-blue-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Hours:Minutes</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="checkbox" name="showWorded" class="text-blue-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Worded</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Precision Control -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Decimal Precision
                                                                                </label>
                                                                                <div class="flex items-center space-x-4">
                                                                                    <input 
                                                                                        type="range" 
                                                                                        id="precision" 
                                                                                        min="0" 
                                                                                        max="6" 
                                                                                        value="4" 
                                                                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                                                                    >
                                                                                    <span class="text-sm font-mono text-gray-700 min-w-[3rem]" id="precisionValue">4 digits</span>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Adjust decimal places for calculations</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-blue-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Hours</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-blue-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-blue-600 hover:text-blue-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Multiple Format Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Minutes -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Minutes</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="minutesDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">60 minutes = 1 hour</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Hours -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Hours</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="hoursDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">1 hour = 60 minutes</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="hidden">
                                                                                <!-- Format Variations -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200" id="formatSection">
                                                                                    <h4 class="text-sm font-semibold text-green-800 mb-2 text-center">Format Variations</h4>
                                                                                    <div class="space-y-2 text-sm">
                                                                                        <div class="flex justify-between" id="decimalFormat">
                                                                                            <span class="text-gray-600">Decimal:</span>
                                                                                            <span class="font-mono text-green-700">--</span>
                                                                                        </div>
                                                                                        <div class="flex justify-between" id="hourMinFormat">
                                                                                            <span class="text-gray-600">Hours:Minutes:</span>
                                                                                            <span class="font-mono text-green-700">--</span>
                                                                                        </div>
                                                                                        <div class="flex justify-between" id="wordedFormat">
                                                                                            <span class="text-gray-600">Worded:</span>
                                                                                            <span class="font-mono text-green-700">--</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Time Breakdown -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border border-yellow-200">
                                                                                    <h4 class="text-sm font-semibold text-yellow-800 mb-2 text-center">Time Breakdown</h4>
                                                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Seconds:</span>
                                                                                            <span class="font-mono text-yellow-700" id="secondsDisplay">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Days:</span>
                                                                                            <span class="font-mono text-yellow-700" id="daysDisplay">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Weeks:</span>
                                                                                            <span class="font-mono text-yellow-700" id="weeksDisplay">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Months:</span>
                                                                                            <span class="font-mono text-yellow-700" id="monthsDisplay">--</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Practical Context -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border border-purple-200">
                                                                                    <h4 class="text-sm font-semibold text-purple-800 mb-2 text-center">Practical Context</h4>
                                                                                    <div class="text-sm text-purple-700 text-center" id="practicalContext">Enter a time value to see practical examples</div>
                                                                                </div>

                                                                                <!-- Work & Study Context -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border border-orange-200">
                                                                                    <h4 class="text-sm font-semibold text-orange-800 mb-2 text-center">Work & Study Applications</h4>
                                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Work Days (8hr):</span>
                                                                                            <span class="font-mono text-orange-700" id="workDays">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Study Sessions (1hr):</span>
                                                                                            <span class="font-mono text-orange-700" id="studySessions">--</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Mathematical Relationships -->
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border border-pink-200">
                                                                                    <h4 class="text-sm font-semibold text-pink-800 mb-2 text-center">Mathematical Relationships</h4>
                                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Conversion Factor:</span>
                                                                                            <span class="font-mono text-pink-700" id="conversionFactor">÷ 60</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Formula:</span>
                                                                                            <span class="font-mono text-pink-700" id="conversionFormula">minutes ÷ 60</span>
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
                <!-- Quick Time Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Time Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="60" data-mode="min-to-hour">60 min</button>
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="90" data-mode="min-to-hour">90 min</button>
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="2.5" data-mode="hour-to-min">2.5 hrs</button>
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="8" data-mode="hour-to-min">8 hrs</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Time Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Time Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 hour</strong> = 60 minutes</div>
                                                        <div><strong>1 day</strong> = 1,440 minutes</div>
                                                        <div><strong>1 week</strong> = 10,080 minutes</div>
                                                        <div><strong>1 month</strong> ≈ 43,800 minutes</div>
                                                        <div><strong>30 minutes</strong> = 0.5 hours</div>
                                                        <div><strong>90 minutes</strong> = 1.5 hours</div>
                                                        <div><strong>120 minutes</strong> = 2 hours</div>
                                                        <div><strong>480 minutes</strong> = 8 hours</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const modeRadios = document.getElementsByName('mode');
                        const showDecimal = document.getElementsByName('showDecimal')[0];
                        const showHourMin = document.getElementsByName('showHourMin')[0];
                        const showWorded = document.getElementsByName('showWorded')[0];
                        const precision = document.getElementById('precision');
                        const precisionValue = document.getElementById('precisionValue');
                        const clearButton = document.getElementById('clearButton');
                        const inputLabel = document.getElementById('inputLabel');
                        const inputUnit = document.getElementById('inputUnit');
                        const inputHelp = document.getElementById('inputHelp');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const minutesDisplay = document.getElementById('minutesDisplay');
                        const hoursDisplay = document.getElementById('hoursDisplay');
                        const decimalFormat = document.getElementById('decimalFormat').lastElementChild;
                        const hourMinFormat = document.getElementById('hourMinFormat').lastElementChild;
                        const wordedFormat = document.getElementById('wordedFormat').lastElementChild;
                        const secondsDisplay = document.getElementById('secondsDisplay');
                        const daysDisplay = document.getElementById('daysDisplay');
                        const weeksDisplay = document.getElementById('weeksDisplay');
                        const monthsDisplay = document.getElementById('monthsDisplay');
                        const practicalContext = document.getElementById('practicalContext');
                        const workDays = document.getElementById('workDays');
                        const studySessions = document.getElementById('studySessions');
                        const conversionFactor = document.getElementById('conversionFactor');
                        const conversionFormula = document.getElementById('conversionFormula');
                        const copyResult = document.getElementById('copyResult');

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
                        }

                        function getPrecision() {
                            return parseInt(precision.value);
                        }

                        function formatNumber(num, decimals = null) {
                            const precision = decimals !== null ? decimals : getPrecision();
                            if (num !== 0 && Math.abs(num) < Math.pow(10, -precision)) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 3 });
                            }

                            return num.toLocaleString(undefined, { maximumFractionDigits: precision });
                        }

                        function formatTime(totalMinutes) {
                            const hours = Math.floor(totalMinutes / 60);
                            const minutes = totalMinutes % 60;
                            
                            if (hours === 0) {
                                return `${minutes} minute${minutes !== 1 ? 's' : ''}`;
                            } else if (minutes === 0) {
                                return `${hours} hour${hours !== 1 ? 's' : ''}`;
                            } else {
                                return `${hours} hour${hours !== 1 ? 's' : ''} and ${minutes} minute${minutes !== 1 ? 's' : ''}`;
                            }
                        }

                        function formatHourMinutes(totalMinutes) {
                            const hours = Math.floor(totalMinutes / 60);
                            const minutes = Math.round(totalMinutes % 60);
                            return `${hours}:${minutes.toString().padStart(2, '0')}`;
                        }

                        function getPracticalContext(minutes, hours) {
                            if (minutes <= 5) {
                                return 'Quick break time - coffee break, brief phone call, or short walk';
                            } else if (minutes <= 15) {
                                return 'Short task duration - quick meeting, brief presentation, or simple task';
                            } else if (minutes <= 30) {
                                return 'Medium task duration - focused work session, TV episode, or short commute';
                            } else if (minutes <= 60) {
                                return 'Standard duration - meeting, class period, workout session, or lunch break';
                            } else if (minutes <= 120) {
                                return 'Extended activity - movie, long meeting, intensive workout, or detailed project work';
                            } else if (minutes <= 480) {
                                return 'Half to full work day - major project, training session, or extended event';
                            } else if (minutes <= 1440) {
                                return 'Full day duration - work day, conference, travel day, or major event';
                            } else {
                                return 'Multi-day duration - project timeline, vacation period, or extended commitment';
                            }
                        }

                        function updateInterface() {
                            const mode = getMode();
                            
                            if (mode === 'min-to-hour') {
                                inputLabel.textContent = 'Enter Minutes';
                                inputUnit.textContent = 'min';
                                inputHelp.textContent = 'Enter minutes to convert to hours';
                                resultTitle.textContent = 'Hours';
                                resultDescription.textContent = 'Converted to hours';
                                inputValue.placeholder = 'Enter minutes (e.g., 90)';
                                conversionFactor.textContent = '÷ 60';
                                conversionFormula.textContent = 'minutes ÷ 60';
                            } else {
                                inputLabel.textContent = 'Enter Hours';
                                inputUnit.textContent = 'hr';
                                inputHelp.textContent = 'Enter hours to convert to minutes';
                                resultTitle.textContent = 'Minutes';
                                resultDescription.textContent = 'Converted to minutes';
                                inputValue.placeholder = 'Enter hours (e.g., 2.5)';
                                conversionFactor.textContent = '× 60';
                                conversionFormula.textContent = 'hours × 60';
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const mode = getMode();

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                let minutes, hours;

                                if (mode === 'min-to-hour') {
                                    minutes = inputVal;
                                    hours = minutes / 60;
                                } else {
                                    hours = inputVal;
                                    minutes = hours * 60;
                                }

                                // Update primary output
                                output.textContent = formatNumber(mode === 'min-to-hour' ? hours : minutes);
                                resultDescription.textContent = mode === 'min-to-hour' ?
                                    `${formatNumber(inputVal)} ${inputVal === 1 ? 'minute' : 'minutes'} = ${formatNumber(hours)} ${hours === 1 ? 'hour' : 'hours'}` :
                                    `${formatNumber(inputVal)} ${inputVal === 1 ? 'hour' : 'hours'} = ${formatNumber(minutes)} ${minutes === 1 ? 'minute' : 'minutes'}`;

                                // Update displays
                                minutesDisplay.textContent = formatNumber(minutes);
                                hoursDisplay.textContent = formatNumber(hours);

                                // Format variations
                                if (showDecimal.checked) {
                                    decimalFormat.textContent = mode === 'min-to-hour' ? 
                                        `${formatNumber(hours)} hours` : `${formatNumber(minutes)} minutes`;
                                } else {
                                    decimalFormat.textContent = 'Disabled';
                                }

                                if (showHourMin.checked && mode === 'min-to-hour') {
                                    hourMinFormat.textContent = formatHourMinutes(minutes);
                                } else if (showHourMin.checked && mode === 'hour-to-min') {
                                    hourMinFormat.textContent = formatHourMinutes(minutes);
                                } else {
                                    hourMinFormat.textContent = 'Disabled';
                                }

                                if (showWorded.checked) {
                                    wordedFormat.textContent = formatTime(Math.round(minutes));
                                } else {
                                    wordedFormat.textContent = 'Disabled';
                                }

                                // Time breakdown
                                const seconds = minutes * 60;
                                const days = minutes / (24 * 60);
                                const weeks = minutes / (7 * 24 * 60);
                                const months = minutes / (30 * 24 * 60);

                                secondsDisplay.textContent = formatNumber(seconds, 0);
                                daysDisplay.textContent = formatNumber(days, 3);
                                weeksDisplay.textContent = formatNumber(weeks, 3);
                                monthsDisplay.textContent = formatNumber(months, 3);

                                // Practical context
                                practicalContext.textContent = getPracticalContext(minutes, hours);

                                // Work & study applications
                                workDays.textContent = formatNumber(hours / 8, 2);
                                studySessions.textContent = formatNumber(hours, 1);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultDescription.textContent = 'Converted result';
                            minutesDisplay.textContent = '--';
                            hoursDisplay.textContent = '--';
                            decimalFormat.textContent = '--';
                            hourMinFormat.textContent = '--';
                            wordedFormat.textContent = '--';
                            secondsDisplay.textContent = '--';
                            daysDisplay.textContent = '--';
                            weeksDisplay.textContent = '--';
                            monthsDisplay.textContent = '--';
                            practicalContext.textContent = 'Enter a time value to see practical examples';
                            workDays.textContent = '--';
                            studySessions.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            document.querySelector('input[value="min-to-hour"]').checked = true;
                            showDecimal.checked = true;
                            showHourMin.checked = true;
                            showWorded.checked = true;
                            precision.value = 4;
                            precisionValue.textContent = '4 digits';
                            updateInterface();
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                convert();
                            });
                        });

                        [showDecimal, showHourMin, showWorded].forEach(checkbox => {
                            checkbox.addEventListener('change', convert);
                        });

                        precision.addEventListener('input', function() {
                            precisionValue.textContent = this.value + ' digits';
                            convert();
                        });

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
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

                        // Example buttons
                        const timeExamples = document.querySelectorAll('.time-example');
                        timeExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const mode = this.getAttribute('data-mode');
                                
                                inputValue.value = value;
                                document.querySelector(`input[value="${mode}"]`).checked = true;
                                updateInterface();
                                convert();
                                
                                // Update button styles
                                timeExamples.forEach(btn => btn.classList.remove('bg-blue-100', 'text-blue-700'));
                                timeExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-blue-100', 'text-blue-700');
                            });
                        });

                        // Initialize
                        updateInterface();
                        precisionValue.textContent = precision.value + ' digits';
                        inputValue.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                const currentMode = getMode();
                                const newMode = currentMode === 'min-to-hour' ? 'hour-to-min' : 'min-to-hour';
                                document.querySelector(`input[value="${newMode}"]`).checked = true;
                                updateInterface();
                                convert();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
