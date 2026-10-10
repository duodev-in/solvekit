<x-tool-page-layout
    title="Angle Conversion Calculator - ConvertPro"
    description="Professional angle conversion calculator for degrees, radians, gradians, and other angular measurements. Perfect for engineering, mathematics, and scientific calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Angle Conversion Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Angle Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter angle value (e.g., 90)"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Value</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter any positive or negative angle value</p>
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
                                                                                    <option value="degrees" selected>Degrees (°)</option>
                                                                                    <option value="radians">Radians (rad)</option>
                                                                                    <option value="gradians">Gradians (grad)</option>
                                                                                    <option value="turns">Turns (rev)</option>
                                                                                    <option value="minutes">Arc Minutes (')</option>
                                                                                    <option value="seconds">Arc Seconds (")</option>
                                                                                    <option value="milliradians">Milliradians (mrad)</option>
                                                                                    <option value="points">Points (compass)</option>
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
                                                                                    <option value="degrees">Degrees (°)</option>
                                                                                    <option value="radians" selected>Radians (rad)</option>
                                                                                    <option value="gradians">Gradians (grad)</option>
                                                                                    <option value="turns">Turns (rev)</option>
                                                                                    <option value="minutes">Arc Minutes (')</option>
                                                                                    <option value="seconds">Arc Seconds (")</option>
                                                                                    <option value="milliradians">Milliradians (mrad)</option>
                                                                                    <option value="points">Points (compass)</option>
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
                                                                                        max="12" 
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-blue-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Angle</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-blue-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-blue-600 hover:text-blue-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- All Angle Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Common Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Common Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Degrees</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="degreesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">360° = full circle</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Radians</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="radiansDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">2π rad = full circle</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Gradians</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="gradiansDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">400 grad = full circle</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Turns</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="turnsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1 turn = full circle</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Precise Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Precise Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Arc Minutes</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="minutesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">60' = 1°</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Arc Seconds</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="secondsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">3600" = 1°</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Milliradians</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="milliradiansDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1000 mrad ≈ 57.3°</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Compass Points</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="pointsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">32 points = full circle</div>
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
                <!-- Quick Angle Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Angle Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="angle-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="90" data-from="degrees" data-to="radians">90°</button>
                                                            <button type="button" class="angle-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="180" data-from="degrees" data-to="radians">180°</button>
                                                            <button type="button" class="angle-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="3.14159" data-from="radians" data-to="degrees">π rad</button>
                                                            <button type="button" class="angle-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="360" data-from="degrees" data-to="radians">360°</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Angle Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Angle Unit Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 degree</strong> = π/180 radians</div>
                                                        <div><strong>1 radian</strong> = 180/π degrees</div>
                                                        <div><strong>1 gradian</strong> = 0.9 degrees</div>
                                                        <div><strong>1 turn</strong> = 360 degrees</div>
                                                        <div><strong>1 arc minute</strong> = 1/60 degree</div>
                                                        <div><strong>1 arc second</strong> = 1/3600 degree</div>
                                                        <div><strong>1 milliradian</strong> = 0.0573 degrees</div>
                                                        <div><strong>1 compass point</strong> = 11.25 degrees</div>
                                                        <div><strong>Right angle</strong> = 90°, π/2 rad</div>
                                                        <div><strong>Straight angle</strong> = 180°, π rad</div>
                                                        <div><strong>Full circle</strong> = 360°, 2π rad</div>
                                                        <div><strong>π (pi)</strong> ≈ 3.14159265359</div>
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
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const degreesDisplay = document.getElementById('degreesDisplay');
                        const radiansDisplay = document.getElementById('radiansDisplay');
                        const gradiansDisplay = document.getElementById('gradiansDisplay');
                        const turnsDisplay = document.getElementById('turnsDisplay');
                        const minutesDisplay = document.getElementById('minutesDisplay');
                        const secondsDisplay = document.getElementById('secondsDisplay');
                        const milliradiansDisplay = document.getElementById('milliradiansDisplay');
                        const pointsDisplay = document.getElementById('pointsDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Conversion multipliers (to degrees)
                        const angleMultipliers = {
                            degrees: 1,
                            radians: 180 / Math.PI,
                            gradians: 0.9,
                            turns: 360,
                            minutes: 1/60,
                            seconds: 1/3600,
                            milliradians: 180 / (Math.PI * 1000),
                            points: 11.25
                        };

                        const unitNames = {
                            degrees: 'Degrees',
                            radians: 'Radians',
                            gradians: 'Gradians',
                            turns: 'Turns',
                            minutes: 'Arc Minutes',
                            seconds: 'Arc Seconds',
                            milliradians: 'Milliradians',
                            points: 'Compass Points'
                        };

                        const unitLabels = {
                            degrees: '°',
                            radians: 'rad',
                            gradians: 'grad',
                            turns: 'rev',
                            minutes: "'",
                            seconds: '"',
                            milliradians: 'mrad',
                            points: 'pts'
                        };

                        function getPrecision() {
                            return parseInt(precision.value);
                        }

                        function formatNumber(num) {
                            if (!isFinite(num)) {
                                return '--';
                            }
                            if (num === 0) {
                                return '0';
                            }
                            const abs = Math.abs(num);
                            if (abs >= 1e15 || abs < 1e-6) {
                                return num.toExponential(4);
                            }
                            if (abs >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: getPrecision() });
                            }
                            return num.toLocaleString(undefined, { maximumSignificantDigits: Math.max(getPrecision(), 1) });
                        }

                        function withUnit(value, unit) {
                            return ['°', "'", '"'].includes(unit) ? `${value}${unit}` : `${value} ${unit}`;
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal)) {
                                // Convert input to degrees first
                                const inputInDegrees = inputVal * angleMultipliers[from];
                                
                                // Convert degrees to target unit
                                const result = inputInDegrees / angleMultipliers[to];
                                
                                // Update primary output
                                output.textContent = withUnit(formatNumber(result), unitLabels[to]);
                                resultTitle.textContent = `${unitNames[to]} (${unitLabels[to]})`;
                                resultDescription.textContent = `${withUnit(formatNumber(inputVal), unitLabels[from])} = ${withUnit(formatNumber(result), unitLabels[to])}`;

                                // Convert to all units and display
                                const degrees = inputInDegrees;
                                degreesDisplay.textContent = formatNumber(degrees / angleMultipliers.degrees);
                                radiansDisplay.textContent = formatNumber(degrees / angleMultipliers.radians);
                                gradiansDisplay.textContent = formatNumber(degrees / angleMultipliers.gradians);
                                turnsDisplay.textContent = formatNumber(degrees / angleMultipliers.turns);
                                minutesDisplay.textContent = formatNumber(degrees / angleMultipliers.minutes);
                                secondsDisplay.textContent = formatNumber(degrees / angleMultipliers.seconds);
                                milliradiansDisplay.textContent = formatNumber(degrees / angleMultipliers.milliradians);
                                pointsDisplay.textContent = formatNumber(degrees / angleMultipliers.points);
                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Angle';
                            resultDescription.textContent = 'Converted result';
                            degreesDisplay.textContent = '--';
                            radiansDisplay.textContent = '--';
                            gradiansDisplay.textContent = '--';
                            turnsDisplay.textContent = '--';
                            minutesDisplay.textContent = '--';
                            secondsDisplay.textContent = '--';
                            milliradiansDisplay.textContent = '--';
                            pointsDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'degrees';
                            toUnit.value = 'radians';
                            precision.value = 6;
                            precisionValue.textContent = '6 digits';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
                        toUnit.addEventListener('change', convert);

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
                        const angleExamples = document.querySelectorAll('.angle-example');
                        angleExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                angleExamples.forEach(btn => btn.classList.remove('bg-blue-100', 'text-blue-700'));
                                angleExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-blue-100', 'text-blue-700');
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
