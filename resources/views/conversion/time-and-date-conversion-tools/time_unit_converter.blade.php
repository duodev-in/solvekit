<x-tool-page-layout
    title="Time Unit Converter - ConvertPro"
    description="Professional time unit converter for all time measurements. Convert between seconds, minutes, hours, days, weeks, months, and years with precision calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h2 class="text-lg font-semibold text-white">Universal Time Unit Converter</h2>
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

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Time Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter value (e.g., 3600)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Value</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter any positive number</p>
                                                                            </div>

                                                                            <!-- From Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    From Unit (Source)
                                                                                </label>
                                                                                <select 
                                                                                    id="fromUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="milliseconds">Milliseconds (ms)</option>
                                                                                    <option value="seconds" selected>Seconds (s)</option>
                                                                                    <option value="minutes">Minutes (min)</option>
                                                                                    <option value="hours">Hours (hr)</option>
                                                                                    <option value="days">Days</option>
                                                                                    <option value="weeks">Weeks</option>
                                                                                    <option value="months">Months (30 days)</option>
                                                                                    <option value="years">Years (365 days)</option>
                                                                                    <option value="decades">Decades</option>
                                                                                    <option value="centuries">Centuries</option>
                                                                                    <option value="millennia">Millennia</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- To Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    To Unit (Target)
                                                                                </label>
                                                                                <select 
                                                                                    id="toUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="milliseconds">Milliseconds (ms)</option>
                                                                                    <option value="seconds">Seconds (s)</option>
                                                                                    <option value="minutes" selected>Minutes (min)</option>
                                                                                    <option value="hours">Hours (hr)</option>
                                                                                    <option value="days">Days</option>
                                                                                    <option value="weeks">Weeks</option>
                                                                                    <option value="months">Months (30 days)</option>
                                                                                    <option value="years">Years (365 days)</option>
                                                                                    <option value="decades">Decades</option>
                                                                                    <option value="centuries">Centuries</option>
                                                                                    <option value="millennia">Millennia</option>
                                                                                </select>
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

                                                                            <!-- Time Context -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Time Context
                                                                                </label>
                                                                                <select 
                                                                                    id="timeContext" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="">General conversion</option>
                                                                                    <option value="precise">Scientific/Precise</option>
                                                                                    <option value="human">Human lifespan</option>
                                                                                    <option value="historical">Historical periods</option>
                                                                                    <option value="astronomical">Astronomical time</option>
                                                                                    <option value="computing">Computing/Programming</option>
                                                                                </select>
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Values</h3>

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

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Time Unit Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Universal Time System</h4>
                                    <p>Time units form a hierarchical system from milliseconds to millennia. This converter uses standard conversions: 60 seconds per minute, 60 minutes per hour, 24 hours per day, 7 days per week, approximately 30 days per month, and 365 days per year for calculations.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Practical Applications</h4>
                                    <p>Time unit conversion is essential in programming, project planning, scientific calculations, historical research, astronomy, and everyday life. Understanding these relationships helps in scheduling, data analysis, and comprehending time scales from microseconds to geological periods.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-violet-50 rounded-lg border border-violet-200">
                                <p class="text-sm text-violet-800">
                                    <strong>Time Tip:</strong> Remember that months and years are approximations (30 days, 365 days) - use calendar functions for exact date calculations!
                                </p>
                            </div>
                        </div>

                        <!-- Time Scale Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Time Scale Examples</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">Micro to Macro</h4>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-violet-600 cursor-pointer hover:text-violet-800" data-example="1" data-from="milliseconds" data-to="seconds">Blink: ~1 millisecond</div>
                                        <div class="text-xs text-gray-600 mt-1">Camera shutter speed</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-violet-600 cursor-pointer hover:text-violet-800" data-example="1" data-from="seconds" data-to="minutes">Heartbeat: ~1 second</div>
                                        <div class="text-xs text-gray-600 mt-1">Resting heart rate</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-violet-600 cursor-pointer hover:text-violet-800" data-example="1" data-from="hours" data-to="minutes">Class Period: 1 hour</div>
                                        <div class="text-xs text-gray-600 mt-1">Standard lecture duration</div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">Life & History</h4>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-violet-600 cursor-pointer hover:text-violet-800" data-example="80" data-from="years" data-to="days">Human Lifespan: ~80 years</div>
                                        <div class="text-xs text-gray-600 mt-1">Average human life expectancy</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-violet-600 cursor-pointer hover:text-violet-800" data-example="5" data-from="centuries" data-to="years">Historical Era: 5 centuries</div>
                                        <div class="text-xs text-gray-600 mt-1">Renaissance to modern era</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-violet-600 cursor-pointer hover:text-violet-800" data-example="1" data-from="millennia" data-to="years">Millennium: 1000 years</div>
                                        <div class="text-xs text-gray-600 mt-1">Major historical period</div>
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
                        const timeContext = document.getElementById('timeContext');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const millisecondsDisplay = document.getElementById('millisecondsDisplay');
                        const secondsDisplay = document.getElementById('secondsDisplay');
                        const minutesDisplay = document.getElementById('minutesDisplay');
                        const hoursDisplay = document.getElementById('hoursDisplay');
                        const daysDisplay = document.getElementById('daysDisplay');
                        const weeksDisplay = document.getElementById('weeksDisplay');
                        const monthsDisplay = document.getElementById('monthsDisplay');
                        const yearsDisplay = document.getElementById('yearsDisplay');
                        const timeScaleContext = document.getElementById('timeScaleContext');
                        const conversionFactor = document.getElementById('conversionFactor');
                        const scientificNotation = document.getElementById('scientificNotation');
                        const precisionUsed = document.getElementById('precisionUsed');
                        const contextInfo = document.getElementById('contextInfo');
                        const heartbeats = document.getElementById('heartbeats');
                        const breaths = document.getElementById('breaths');
                        const blinks = document.getElementById('blinks');
                        const steps = document.getElementById('steps');
                        const copyResult = document.getElementById('copyResult');

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

                        const unitLabels = {
                            milliseconds: 'ms',
                            seconds: 's',
                            minutes: 'min',
                            hours: 'hr',
                            days: 'days',
                            weeks: 'weeks',
                            months: 'months',
                            years: 'years',
                            decades: 'decades',
                            centuries: 'centuries',
                            millennia: 'millennia'
                        };

                        function getPrecision() {
                            return parseInt(precision.value);
                        }

                        function formatNumber(num, decimals = null) {
                            const precision = decimals !== null ? decimals : getPrecision();
                            if (Math.abs(num) >= 1e15 || (Math.abs(num) <= 1e-6 && num !== 0)) {
                                return num.toExponential(3);
                            } else if (Math.abs(num) >= 1e12) {
                                return (num / 1e12).toLocaleString(undefined, { maximumFractionDigits: 2 }) + 'T';
                            } else if (Math.abs(num) >= 1e9) {
                                return (num / 1e9).toLocaleString(undefined, { maximumFractionDigits: 2 }) + 'B';
                            } else if (Math.abs(num) >= 1e6) {
                                return (num / 1e6).toLocaleString(undefined, { maximumFractionDigits: 2 }) + 'M';
                            } else if (Math.abs(num) >= 1e3) {
                                return (num / 1e3).toLocaleString(undefined, { maximumFractionDigits: 2 }) + 'K';
                            } else {
                                return num.toLocaleString(undefined, { maximumFractionDigits: precision });
                            }
                        }

                        function getTimeScaleContext(seconds) {
                            if (seconds < 1) {
                                return 'Microsecond scale - computer processing, light travel short distances, high-speed photography';
                            } else if (seconds < 60) {
                                return 'Second scale - human reactions, heartbeats, conversation pauses, quick tasks';
                            } else if (seconds < 3600) {
                                return 'Minute scale - short activities, meetings, travel times, cooking durations';
                            } else if (seconds < 86400) {
                                return 'Hour scale - work periods, sleep cycles, major activities, events';
                            } else if (seconds < 2592000) {
                                return 'Day/Week scale - projects, habits, weather patterns, biological cycles';
                            } else if (seconds < 31536000) {
                                return 'Month scale - seasons, academic terms, business quarters, personal goals';
                            } else if (seconds < 3153600000) {
                                return 'Year/Decade scale - careers, education, technology generations, economic cycles';
                            } else if (seconds < 31536000000) {
                                return 'Century scale - historical periods, civilizations, major cultural changes';
                            } else {
                                return 'Millennium scale - geological changes, species evolution, astronomical cycles';
                            }
                        }

                        function getContextualInfo(seconds, context) {
                            const contexts = {
                                precise: {
                                    name: 'Scientific/Precise',
                                    getInfo: (s) => {
                                        if (s < 1e-9) return 'Nanosecond precision - quantum mechanics, atomic clocks';
                                        if (s < 1e-6) return 'Microsecond precision - computer operations, electronic circuits';
                                        if (s < 1e-3) return 'Millisecond precision - network latency, reaction times';
                                        if (s < 1) return 'Sub-second precision - high-speed measurements';
                                        return 'Standard scientific measurement precision';
                                    }
                                },
                                human: {
                                    name: 'Human Lifespan',
                                    getInfo: (s) => {
                                        const years = s / 31536000;
                                        if (years < 1) return 'Less than a year - developmental milestones, seasonal changes';
                                        if (years < 18) return 'Childhood/adolescence - education, growth, development';
                                        if (years < 65) return 'Adult working years - career, family, major life decisions';
                                        if (years < 100) return 'Senior years - retirement, legacy, wisdom sharing';
                                        return 'Multiple human generations - family lineage, cultural memory';
                                    }
                                },
                                historical: {
                                    name: 'Historical Periods',
                                    getInfo: (s) => {
                                        const years = s / 31536000;
                                        if (years < 10) return 'Recent history - current events, political terms';
                                        if (years < 100) return 'Living memory - technological revolution, social changes';
                                        if (years < 1000) return 'Recorded history - empires, civilizations, major discoveries';
                                        if (years < 10000) return 'Human civilization - agriculture, writing, cities';
                                        return 'Prehistoric times - human evolution, geological changes';
                                    }
                                },
                                astronomical: {
                                    name: 'Astronomical Time',
                                    getInfo: (s) => {
                                        const years = s / 31536000;
                                        if (years < 1) return 'Planetary rotation and orbital mechanics';
                                        if (years < 1000) return 'Human astronomical observations, satellite missions';
                                        if (years < 1000000) return 'Stellar evolution timeframes, galactic rotation';
                                        if (years < 1000000000) return 'Geological timescales, solar system formation';
                                        return 'Cosmological timescales - universe age, stellar lifespans';
                                    }
                                },
                                computing: {
                                    name: 'Computing/Programming',
                                    getInfo: (s) => {
                                        if (s < 1e-9) return 'CPU cycle time, quantum computing operations';
                                        if (s < 1e-6) return 'Memory access time, cache operations';
                                        if (s < 1e-3) return 'Database queries, network requests';
                                        if (s < 1) return 'User interface responsiveness, real-time processing';
                                        if (s < 60) return 'Batch processing, compilation times';
                                        return 'Long-running processes, system maintenance windows';
                                    }
                                }
                            };

                            if (context && contexts[context]) {
                                const ctx = contexts[context];
                                return `${ctx.name}: ${ctx.getInfo(seconds)}`;
                            }
                            return 'Select a time context for specific information';
                        }

                        function calculateBiologicalMeasurements(seconds) {
                            // Average rates per minute
                            const heartRate = 70; // beats per minute
                            const breathRate = 16; // breaths per minute
                            const blinkRate = 20; // blinks per minute
                            const stepRate = 120; // steps per minute (walking)

                            const minutes = seconds / 60;

                            return {
                                heartbeats: Math.round(minutes * heartRate),
                                breaths: Math.round(minutes * breathRate),
                                blinks: Math.round(minutes * blinkRate),
                                steps: Math.round(minutes * stepRate)
                            };
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;
                            const context = timeContext.value;

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                // Convert input to seconds first
                                const inputInSeconds = inputVal * timeMultipliers[from];
                                
                                // Convert seconds to target unit
                                const result = inputInSeconds / timeMultipliers[to];
                                
                                // Update primary output
                                output.textContent = formatNumber(result);
                                resultTitle.textContent = `${unitLabels[to]} (${to})`;
                                resultDescription.textContent = `${inputVal} ${unitLabels[from]} = ${formatNumber(result)} ${unitLabels[to]}`;

                                // Convert to all units and display
                                const seconds = inputInSeconds;
                                millisecondsDisplay.textContent = formatNumber(seconds / timeMultipliers.milliseconds);
                                secondsDisplay.textContent = formatNumber(seconds / timeMultipliers.seconds);
                                minutesDisplay.textContent = formatNumber(seconds / timeMultipliers.minutes);
                                hoursDisplay.textContent = formatNumber(seconds / timeMultipliers.hours);
                                daysDisplay.textContent = formatNumber(seconds / timeMultipliers.days);
                                weeksDisplay.textContent = formatNumber(seconds / timeMultipliers.weeks);
                                monthsDisplay.textContent = formatNumber(seconds / timeMultipliers.months);
                                yearsDisplay.textContent = formatNumber(seconds / timeMultipliers.years);

                                // Time scale context
                                timeScaleContext.textContent = getTimeScaleContext(seconds);

                                // Conversion analysis
                                const factor = timeMultipliers[to] / timeMultipliers[from];
                                conversionFactor.textContent = factor >= 1 ? `÷${formatNumber(factor, 3)}` : `×${formatNumber(1/factor, 3)}`;
                                scientificNotation.textContent = result.toExponential(3);
                                precisionUsed.textContent = `${getPrecision()} digits`;

                                // Contextual information
                                contextInfo.textContent = getContextualInfo(seconds, context);

                                // Biological measurements
                                if (seconds <= 31536000000) { // Up to 1000 years
                                    const bio = calculateBiologicalMeasurements(seconds);
                                    heartbeats.textContent = formatNumber(bio.heartbeats, 0);
                                    breaths.textContent = formatNumber(bio.breaths, 0);
                                    blinks.textContent = formatNumber(bio.blinks, 0);
                                    steps.textContent = formatNumber(bio.steps, 0);
                                } else {
                                    heartbeats.textContent = 'N/A';
                                    breaths.textContent = 'N/A';
                                    blinks.textContent = 'N/A';
                                    steps.textContent = 'N/A';
                                }

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Time';
                            resultDescription.textContent = 'Converted result';
                            millisecondsDisplay.textContent = '--';
                            secondsDisplay.textContent = '--';
                            minutesDisplay.textContent = '--';
                            hoursDisplay.textContent = '--';
                            daysDisplay.textContent = '--';
                            weeksDisplay.textContent = '--';
                            monthsDisplay.textContent = '--';
                            yearsDisplay.textContent = '--';
                            timeScaleContext.textContent = 'Enter a time value to see scale context';
                            conversionFactor.textContent = '--';
                            scientificNotation.textContent = '--';
                            precisionUsed.textContent = '6 digits';
                            contextInfo.textContent = 'Select a time context for specific information';
                            heartbeats.textContent = '--';
                            breaths.textContent = '--';
                            blinks.textContent = '--';
                            steps.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'seconds';
                            toUnit.value = 'minutes';
                            timeContext.value = '';
                            precision.value = 6;
                            precisionValue.textContent = '6 digits';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
                        toUnit.addEventListener('change', convert);
                        timeContext.addEventListener('change', convert);

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
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                timeExamples.forEach(btn => btn.classList.remove('bg-violet-100', 'text-violet-700'));
                                timeExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-violet-100', 'text-violet-700');
                            });
                        });

                        // Clickable examples
                        const examples = document.querySelectorAll('[data-example]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const value = this.getAttribute('data-example');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                if (from) fromUnit.value = from;
                                if (to) toUnit.value = to;
                                convert();
                                inputValue.focus();
                            });
                        });

                        // Initialize
                        precisionValue.textContent = precision.value + ' digits';
                        inputValue.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
